
const states = [];
const state = () => ({
  states: states ? states : null ,
  status: states ?
     { fetched: true }:{}
})
const getters = {
  allStates: state => state.states,
}

const actions = {
   async fetchStates({ commit }) {
     commit('fetchStates',states);
     return await this.$repositories.states.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchStatesFailure',  response.error);
           }
           else if(response.states){
             commit('fetchStatesSuccess', response.states);
           }
           return response
         },
         error => {
             commit('fetchStatesFailure', error);
         }
     );
  },
  async addStates({ commit }, requestParams) {
   commit('addStateRequest',states);
   return await this.$repositories.states.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addStateFailure',  response.data.error);
         }
         else{
           commit('addStateSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addStateFailure',  e.response.data);
     return e
   });
},
async updateStates({ commit }, {formData,id}) {
   commit('updateStateRequest',states);
    return await this.$repositories.states.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateStateFailure',  'Some Error OCcured');
         }
         else{
           commit('updateStateSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateStateFailure',  e.response.data);
     return e
   });
},
  async filterStates({ commit }, requestParams) {
    return await this.$repositories.states.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterStatesFailure',  response.error);
          }
          else if(response.states){
            commit('filterStatesSuccess', response.states);
          }
          return response
        },
        error => {
            commit('fetchStatesFailure', error);
            return
        }
    );
  },
  async deleteStates({ dispatch, commit, state }, {filterData,state_id}) {
     return await this.$repositories.states.delete(filterData,state_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteStateFailure',  state.message);
           }
           else if(response.states){
             commit('deleteStateSuccess', response.states);
           }
           return response
         },
     );
     error => {
          commit('deleteStateFailure',  state.message);
         return
     }
  },

  async updateStateStatus({ commit }, {filterData,state_id}) {
  return await this.$repositories.states.updateStatus(filterData,state_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateStateStatusFailure',  response.message);
        }
        else if(response.states){
          commit('updateStateStatusSuccess', response.states);
        }
        return response

      },
    );
  },
  async updateStateIsDefault({ commit }, {filterData,state_id}) {
  return await this.$repositories.states.updateIsDefault(filterData,state_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateStateIsDefaultFailure',  response.error);
        }
        else if(response.states){
          commit('updateStateIsDefaultSuccess', response.states);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchStates(state, states) {
      state.status = { fetching: true };
      state.states = states;
  },
  fetchStatesSuccess(state, states) {
      state.status = { fetched: true };
      state.states = states;
  },
  fetchStatesFailure(state) {
      state.status = {};
      state.states = null;
  },
  addStateRequest(state, images) {
    state.status = { adding: true };
},
addStateSuccess(state) {
  // state.states = states;
  state.status = { added: true };
},
addStateFailure(state) {
    state.status = {};
},
updateStateRequest(state, states) {
    state.status = { updating: true };
},
updateStateSuccess(state) {
  state.status = { updated: true };
},
updateStateFailure(state) {
    state.status = {};
},
  deleteStateRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteStateSuccess(state, states) {
    state.states = states;
    state.status = { deleted: true };
  },
  deleteStateFailure(state) {
      state.status = {deleted: false};
  },
  filterStatesSuccess(state, states) {
      state.status = { filtered: true };
      state.states = states;
  },
  filterStatesFailure(state) {
      state.status = {};
  },
  updateStateStatusSuccess(state, states) {
      state.status = { fetched: true };
      state.states = states;
  },
  updateStateStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateStateIsDefaultSuccess(state, states) {
      state.status = { fetched: true };
      state.states = states;
  },
  updateStateIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
