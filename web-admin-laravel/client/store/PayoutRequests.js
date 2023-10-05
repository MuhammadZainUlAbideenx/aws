
const payoutRequests = [];
const state = () => ({
  payoutRequests: payoutRequests ? payoutRequests : null ,
  status: payoutRequests ?
     { fetched: true }:{}
})
const getters = {
  allPayoutRequests: state => state.payoutRequests,
}

const actions = {
   async fetchPayoutRequests({ commit }) {
     commit('fetchPayoutRequests',payoutRequests);
     return await this.$repositories.payoutRequests.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchPayoutRequestsFailure',  response.error);
           }
           else if(response.payoutRequests){
             commit('fetchPayoutRequestsSuccess', response.payoutRequests);
           }
           return response
         },
         error => {
             commit('fetchPayoutRequestsFailure', error);
         }
     );
  },


  async filterPayoutRequests({ commit }, requestParams) {
    return await this.$repositories.payoutRequests.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('fetchPayoutRequestsFailure',  response.error);
          }
          else if(response.payoutRequests){
            commit('fetchPayoutRequestsSuccess', response.payoutRequests);
          }
          return response
        },
        error => {
            commit('fetchPayoutRequestsFailure', error);
            return
        }
    );
  },



  async updatePayoutRequestStatus({ commit }, {filterData,payoutRequest_id,status}) {

  return await this.$generalService.updatePayoutRequestStatus(filterData,payoutRequest_id,status)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updatePayoutRequestStatusFailure',  response.message);
        }
        else if(response.payoutRequests){
          commit('updatePayoutRequestStatusSuccess', response.payoutRequests);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchPayoutRequests(state, payoutRequests) {
      state.status = { fetching: true };
      state.payoutRequests = payoutRequests;
  },
  fetchPayoutRequestsSuccess(state, payoutRequests) {
      state.status = { fetched: true };
      state.payoutRequests = payoutRequests;
  },
  fetchPayoutRequestsFailure(state) {
      state.status = {};
      state.payoutRequests = null;
  },


  updatePayoutRequestStatusSuccess(state, payoutRequests) {
      state.status = { fetched: true };
      state.payoutRequests = payoutRequests;
  },
  updatePayoutRequestStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
