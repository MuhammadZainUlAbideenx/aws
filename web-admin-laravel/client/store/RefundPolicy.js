
const refund_policy = [];
const state = () => ({
  refund_policy: refund_policy ? refund_policy : null ,
  status: refund_policy ?
     { fetched: true }:{}
})
const getters = {
  allRefundPolicy: state => state.refund_policy,
}

const actions = {
   async fetchRefundPolicy({ commit }) {
     commit('fetchRefundPolicy',refund_policy);
     return await this.$repositories.refund_policy.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchRefundPolicyFailure',  response.error);
           }
           else if(response.refund_policy){
             commit('fetchRefundPolicySuccess', response.refund_policy);
           }
           return response
         },
         error => {
             commit('fetchRefundPolicyFailure', error);
         }
     );
  },
  async addRefundPolicy({ commit }, requestParams) {
   commit('addRefundPolicyRequest',refund_policy);
   return await this.$repositories.refund_policy.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addRefundPolicyFailure',  response.data.error);
         }
         else{
           commit('addRefundPolicySuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addRefundPolicyFailure',  e.response.data);
     return e
   });
},
};

const mutations = {
  fetchRefundPolicy(state, refund_policy) {
      state.status = { fetching: true };
      state.refund_policy = refund_policy;
  },
  fetchRefundPolicySuccess(state, refund_policy) {
      state.status = { fetched: true };
      state.refund_policy = refund_policy;
  },
  fetchRefundPolicyFailure(state) {
      state.status = {};
      state.refund_policy = null;
  },
  addRefundPolicyRequest(state, images) {
    state.status = { adding: true };
},
addRefundPolicySuccess(state) {
  // state.refund_policy = refund_policy;
  state.status = { added: true };
},
addRefundPolicyFailure(state) {
    state.status = {};
},
}

export default {
  state,
  actions,
  mutations,
  getters
};
