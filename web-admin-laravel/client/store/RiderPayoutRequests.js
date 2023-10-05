
const riderPayoutRequests = [];
const state = () => ({
  riderPayoutRequests: riderPayoutRequests ? riderPayoutRequests : null ,
  status: riderPayoutRequests ?
     { fetched: true }:{}
})
const getters = {
  allRiderPayoutRequests: state => state.riderPayoutRequests,
}

const actions = {
   async fetchRiderPayoutRequests({ commit }) {
     commit('fetchRiderPayoutRequests',riderPayoutRequests);
     return await this.$repositories.riderPayoutRequests.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchRiderPayoutRequestsFailure',  response.error);
           }
           else if(response.riderPayoutRequests){
             commit('fetchRiderPayoutRequestsSuccess', response.riderPayoutRequests);
           }
           return response
         },
         error => {
             commit('fetchRiderPayoutRequestsFailure', error);
         }
     );
  },


  async filterRiderPayoutRequests({ commit }, requestParams) {
    return await this.$repositories.riderPayoutRequests.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('fetchRiderPayoutRequestsFailure',  response.error);
          }
          else if(response.riderPayoutRequests){
            commit('fetchRiderPayoutRequestsSuccess', response.riderPayoutRequests);
          }
          return response
        },
        error => {
            commit('fetchRiderPayoutRequestsFailure', error);
            return
        }
    );
  },



  async updateRiderPayoutRequestStatus({ commit }, {filterData,riderPayoutRequest_id,status}) {

  return await this.$generalService.updateRiderPayoutRequestStatus(filterData,riderPayoutRequest_id,status)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateRiderPayoutRequestStatusFailure',  response.message);
        }
        else if(response.riderPayoutRequests){
          commit('updateRiderPayoutRequestStatusSuccess', response.riderPayoutRequests);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchRiderPayoutRequests(state, riderPayoutRequests) {
      state.status = { fetching: true };
      state.riderPayoutRequests = riderPayoutRequests;
  },
  fetchRiderPayoutRequestsSuccess(state, riderPayoutRequests) {
      state.status = { fetched: true };
      state.riderPayoutRequests = riderPayoutRequests;
  },
  fetchRiderPayoutRequestsFailure(state) {
      state.status = {};
      state.riderPayoutRequests = null;
  },


  updateRiderPayoutRequestStatusSuccess(state, riderPayoutRequests) {
      state.status = { fetched: true };
      state.riderPayoutRequests = riderPayoutRequests;
  },
  updateRiderPayoutRequestStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
