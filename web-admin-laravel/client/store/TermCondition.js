
const term_condition = [];
const state = () => ({
  term_condition: term_condition ? term_condition : null ,
  status: term_condition ?
     { fetched: true }:{}
})
const getters = {
  allTermCondition: state => state.term_condition,
}

const actions = {
   async fetchTermCondition({ commit }) {
     commit('fetchTermCondition',term_condition);
     return await this.$repositories.term_condition.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchTermConditionFailure',  response.error);
           }
           else if(response.term_condition){
             commit('fetchTermConditionSuccess', response.term_condition);
           }
           return response
         },
         error => {
             commit('fetchTermConditionFailure', error);
         }
     );
  },
  async addTermCondition({ commit }, requestParams) {
   commit('addTermConditionRequest',term_condition);
   return await this.$repositories.term_condition.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addTermConditionFailure',  response.data.error);
         }
         else{
           commit('addTermConditionSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addTermConditionFailure',  e.response.data);
     return e
   });
},
};

const mutations = {
  fetchTermCondition(state, term_condition) {
      state.status = { fetching: true };
      state.term_condition = term_condition;
  },
  fetchTermConditionSuccess(state, term_condition) {
      state.status = { fetched: true };
      state.term_condition = term_condition;
  },
  fetchTermConditionFailure(state) {
      state.status = {};
      state.term_condition = null;
  },
  addTermConditionRequest(state, images) {
    state.status = { adding: true };
},
addTermConditionSuccess(state) {
  // state.term_condition = term_condition;
  state.status = { added: true };
},
addTermConditionFailure(state) {
    state.status = {};
},
}

export default {
  state,
  actions,
  mutations,
  getters
};
