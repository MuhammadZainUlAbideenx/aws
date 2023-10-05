
const roles = [];
const state = () => ({
  roles: roles ? roles : null ,
  status: roles ?
     { fetched: true }:{}
})
const getters = {
  allRoles: state => state.roles,
}

const actions = {
   async fetchRoles({ commit }) {
     commit('fetchRoles',roles);
     return await this.$repositories.roles.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchRolesFailure',  response.error);
           }
           else if(response.roles){
             commit('fetchRolesSuccess', response.roles);
           }
           return response
         },
         error => {
             commit('fetchRolesFailure', error);
         }
     );
  },
  async addRoles({ commit }, requestParams) {
   commit('addRoleRequest',roles);
   return await this.$repositories.roles.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addRoleFailure',  response.data.error);
         }
         else{
           commit('addRoleSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addRoleFailure',  e.response.data);
     return e
   });
},
async updateRoles({ commit }, {formData,id}) {
   commit('updateRoleRequest',roles);
    return await this.$repositories.roles.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateRoleFailure',  'Some Error OCcured');
         }
         else{
           commit('updateRoleSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateRoleFailure',  e.response.data);
     return e
   });
},
  async filterRoles({ commit }, requestParams) {
    return await this.$repositories.roles.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterRolesFailure',  response.error);
          }
          else if(response.roles){
            commit('filterRolesSuccess', response.roles);
          }
          return response
        },
        error => {
            commit('fetchRolesFailure', error);
            return
        }
    );
  },
  async deleteRoles({ dispatch, commit, state }, {filterData,role_id}) {
     return await this.$repositories.roles.delete(filterData,role_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteRoleFailure',  state.message);
           }
           else if(response.roles){
             commit('deleteRoleSuccess', response.roles);
           }
           return response
         },
     );
     error => {
          commit('deleteRoleFailure',  state.message);
         return
     }
  },
  async updateRoleStatus({ commit }, {filterData,role_id}) {
  return await this.$repositories.roles.updateStatus(filterData,role_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateRoleStatusFailure',  response.message);
        }
        else if(response.roles){
          commit('updateRoleStatusSuccess', response.roles);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchRoles(state, roles) {
      state.status = { fetching: true };
      state.roles = roles;
  },
  fetchRolesSuccess(state, roles) {
      state.status = { fetched: true };
      state.roles = roles;
  },
  fetchRolesFailure(state) {
      state.status = {};
      state.roles = null;
  },
  addRoleRequest(state, images) {
    state.status = { adding: true };
},
addRoleSuccess(state) {
  // state.roles = roles;
  state.status = { added: true };
},
addRoleFailure(state) {
    state.status = {};
},
updateRoleRequest(state, roles) {
    state.status = { updating: true };
},
updateRoleSuccess(state) {
  state.status = { updated: true };
},
updateRoleFailure(state) {
    state.status = {};
},
  deleteRoleRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteRoleSuccess(state, roles) {
    state.roles = roles;
    state.status = { deleted: true };
  },
  deleteRoleFailure(state) {
      state.status = {deleted: false};
  },
  filterRolesSuccess(state, roles) {
      state.status = { filtered: true };
      state.roles = roles;
  },
  filterRolesFailure(state) {
      state.status = {};
  },
  updateRoleStatusFailure(state, roles) {
      state.status = { filtered: true };
      state.roles = roles;
  },
  updateRoleStatusSuccess(state) {
      state.status = {};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
