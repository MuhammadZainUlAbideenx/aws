
const commissions = [];
const state = () => ({
  commissions: commissions ? commissions : null ,
  status: commissions ?
     { fetched: true }:{}
})
const getters = {
  allCommissions: state => state.commissions,
}

const actions = {
   async fetchCommissions({ commit }) {
     commit('fetchCommissions',commissions);
     return await this.$repositories.commissions.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchCommissionsFailure',  response.error);
           }
           else if(response.commissions){
             commit('fetchCommissionsSuccess', response.commissions);
           }
           return response
         },
         error => {
             commit('fetchCommissionsFailure', error);
         }
     );
  },
  async addCommissions({ commit }, requestParams) {
   commit('addCommissionRequest',commissions);
   return await this.$repositories.commissions.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addCommissionFailure',  response.data.error);
         }
         else{
           commit('addCommissionSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addCommissionFailure',  e.response.data);
     return e
   });
},
async updateCommissions({ commit }, {formData,id}) {
   commit('updateCommissionRequest',commissions);
    return await this.$repositories.commissions.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateCommissionFailure',  'Some Error OCcured');
         }
         else{
           commit('updateCommissionSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateCommissionFailure',  e.response.data);
     return e
   });
},
  async filterCommissions({ commit }, requestParams) {
    return await this.$repositories.commissions.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterCommissionsFailure',  response.error);
          }
          else if(response.commissions){
            commit('filterCommissionsSuccess', response.commissions);
          }
          return response
        },
        error => {
            commit('fetchCommissionsFailure', error);
            return
        }
    );
  },
  async deleteCommissions({ dispatch, commit, state }, {filterData,commission_id}) {
     return await this.$repositories.commissions.delete(filterData,commission_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteCommissionFailure',  state.message);
           }
           else if(response.commissions){
             commit('deleteCommissionSuccess', response.commissions);
           }
           return response
         },
     );
     error => {
          commit('deleteCommissionFailure',  state.message);
         return
     }
  },

  async updateCommissionStatus({ commit }, {filterData,commission_id}) {
  return await this.$repositories.commissions.updateStatus(filterData,commission_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCommissionStatusFailure',  response.message);
        }
        else if(response.commissions){
          commit('updateCommissionStatusSuccess', response.commissions);
        }
        return response

      },
    );
  },
  async updateCommissionIsDefault({ commit }, {filterData,commission_id}) {
  return await this.$repositories.commissions.updateIsDefault(filterData,commission_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCommissionIsDefaultFailure',  response.error);
        }
        else if(response.commissions){
          commit('updateCommissionIsDefaultSuccess', response.commissions);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchCommissions(state, commissions) {
      state.status = { fetching: true };
      state.commissions = commissions;
  },
  fetchCommissionsSuccess(state, commissions) {
      state.status = { fetched: true };
      state.commissions = commissions;
  },
  fetchCommissionsFailure(state) {
      state.status = {};
      state.commissions = null;
  },
  addCommissionRequest(state, images) {
    state.status = { adding: true };
},
addCommissionSuccess(state) {
  // state.commissions = commissions;
  state.status = { added: true };
},
addCommissionFailure(state) {
    state.status = {};
},
updateCommissionRequest(state, commissions) {
    state.status = { updating: true };
},
updateCommissionSuccess(state) {
  state.status = { updated: true };
},
updateCommissionFailure(state) {
    state.status = {};
},
  deleteCommissionRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteCommissionSuccess(state, commissions) {
    state.commissions = commissions;
    state.status = { deleted: true };
  },
  deleteCommissionFailure(state) {
      state.status = {deleted: false};
  },
  filterCommissionsSuccess(state, commissions) {
      state.status = { filtered: true };
      state.commissions = commissions;
  },
  filterCommissionsFailure(state) {
      state.status = {};
  },
  updateCommissionStatusSuccess(state, commissions) {
      state.status = { fetched: true };
      state.commissions = commissions;
  },
  updateCommissionStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateCommissionIsDefaultSuccess(state, commissions) {
      state.status = { fetched: true };
      state.commissions = commissions;
  },
  updateCommissionIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
