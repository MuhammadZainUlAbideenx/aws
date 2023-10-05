
const admins = [];
const state = () => ({
  admins: admins ? admins : null ,
  status: admins ?
     { fetched: true }:{}
})
const getters = {
  allAdmins: state => state.admins,
}

const actions = {
   async fetchAdmins({ commit }) {
     commit('fetchAdmins',admins);
     return await this.$repositories.admins.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchAdminsFailure',  response.error);
           }
           else if(response.admins){
             commit('fetchAdminsSuccess', response.admins);
           }
           return response
         },
         error => {
             commit('fetchAdminsFailure', error);
         }
     );
  },
  async addAdmins({ commit }, requestParams) {
   commit('addAdminRequest',admins);
   return await this.$repositories.admins.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addAdminFailure',  response.data.error);
         }
         else{
           commit('addAdminSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addAdminFailure',  e.response.data);
     return e
   });
},
async updateAdmins({ commit }, {formData,id}) {
   commit('updateAdminRequest',admins);
    return await this.$repositories.admins.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateAdminFailure',  'Some Error OCcured');
         }
         else{
           commit('updateAdminSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateAdminFailure',  e.response.data);
     return e
   });
},
  async filterAdmins({ commit }, requestParams) {
    return await this.$repositories.admins.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterAdminsFailure',  response.error);
          }
          else if(response.admins){
            commit('filterAdminsSuccess', response.admins);
          }
          return response
        },
        error => {
            commit('fetchAdminsFailure', error);
            return
        }
    );
  },
  async deleteAdmins({ dispatch, commit, state }, {filterData,admin_id}) {
     return await this.$repositories.admins.delete(filterData,admin_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteAdminFailure',  state.message);
           }
           else if(response.admins){
             commit('deleteAdminSuccess', response.admins);
           }
           return response
         },
     );
     error => {
          commit('deleteAdminFailure',  state.message);
         return
     }
  },

  async updateAdminStatus({ commit }, {filterData,admin_id}) {
  return await this.$repositories.admins.updateStatus(filterData,admin_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateAdminStatusFailure',  response.message);
        }
        else if(response.admins){
          commit('updateAdminStatusSuccess', response.admins);
        }
        return response

      },
    );
  },
  async updateAdminIsDefault({ commit }, {filterData,admin_id}) {
  return await this.$repositories.admins.updateIsDefault(filterData,admin_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateAdminIsDefaultFailure',  response.error);
        }
        else if(response.admins){
          commit('updateAdminIsDefaultSuccess', response.admins);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchAdmins(state, admins) {
      state.status = { fetching: true };
      state.admins = admins;
  },
  fetchAdminsSuccess(state, admins) {
      state.status = { fetched: true };
      state.admins = admins;
  },
  fetchAdminsFailure(state) {
      state.status = {};
      state.admins = null;
  },
  addAdminRequest(state, images) {
    state.status = { adding: true };
},
addAdminSuccess(state) {
  // state.admins = admins;
  state.status = { added: true };
},
addAdminFailure(state) {
    state.status = {};
},
updateAdminRequest(state, admins) {
    state.status = { updating: true };
},
updateAdminSuccess(state) {
  state.status = { updated: true };
},
updateAdminFailure(state) {
    state.status = {};
},
  deleteAdminRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteAdminSuccess(state, admins) {
    state.admins = admins;
    state.status = { deleted: true };
  },
  deleteAdminFailure(state) {
      state.status = {deleted: false};
  },
  filterAdminsSuccess(state, admins) {
      state.status = { filtered: true };
      state.admins = admins;
  },
  filterAdminsFailure(state) {
      state.status = {};
  },
  updateAdminStatusSuccess(state, admins) {
      state.status = { fetched: true };
      state.admins = admins;
  },
  updateAdminStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateAdminIsDefaultSuccess(state, admins) {
      state.status = { fetched: true };
      state.admins = admins;
  },
  updateAdminIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
