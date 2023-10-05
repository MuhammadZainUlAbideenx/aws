const privacy_policy = [];
const state = () => ({
  privacy_policy: privacy_policy ? privacy_policy : null ,
  status: privacy_policy ?
     { fetched: true }:{}
})
const getters = {
  allPrivacyPolicy: state => state.privacy_policy,
}

const actions = {
   async fetchPrivacyPolicy({ commit }) {
     commit('fetchPrivacyPolicy',privacy_policy);
     return await this.$repositories.privacy_policy.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchPrivacyPolicyFailure',  response.error);
           }
           else if(response.privacy_policy){
             commit('fetchPrivacyPolicySuccess', response.privacy_policy);
           }
           return response
         },
         error => {
             commit('fetchPrivacyPolicyFailure', error);
         }
     );
  },
  async addPrivacyPolicy({ commit }, requestParams) {
   commit('addPrivacyPolicyRequest',privacy_policy);
   return await this.$repositories.privacy_policy.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addPrivacyPolicyFailure',  response.data.error);
         }
         else{
           commit('addPrivacyPolicySuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addPrivacyPolicyFailure',  e.response.data);
     return e
   });
},
};

const mutations = {
  fetchPrivacyPolicy(state, privacy_policy) {
      state.status = { fetching: true };
      state.privacy_policy = privacy_policy;
  },
  fetchPrivacyPolicySuccess(state, privacy_policy) {
      state.status = { fetched: true };
      state.privacy_policy = privacy_policy;
  },
  fetchPrivacyPolicyFailure(state) {
      state.status = {};
      state.privacy_policy = null;
  },
  addPrivacyPolicyRequest(state, images) {
    state.status = { adding: true };
},
addPrivacyPolicySuccess(state) {
  // state.privacy_policy = privacy_policy;
  state.status = { added: true };
},
addPrivacyPolicyFailure(state) {
    state.status = {};
},
}

export default {
  state,
  actions,
  mutations,
  getters
};
