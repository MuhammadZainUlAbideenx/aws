
const riders = [];
const state = () => ({
  riders: riders ? riders : null ,
  status: riders ?
     { fetched: true }:{}
})
const getters = {
  allRiders: state => state.riders,
}

const actions = {
   async fetchRiders({ commit }) {
     commit('fetchRiders',riders);
     return await this.$repositories.riders.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchRidersFailure',  response.error);
           }
           else if(response.riders){
             commit('fetchRidersSuccess', response.riders);
           }
           return response
         },
         error => {
             commit('fetchRidersFailure', error);
         }
     );
  },
  async addRiders({ commit }, requestParams) {
   commit('addRiderRequest',riders);
   return await this.$repositories.riders.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addRiderFailure',  response.data.error);
         }
         else{
           commit('addRiderSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addRiderFailure',  e.response.data);
     return e
   });
},
async updateRiders({ commit }, {formData,id}) {
   commit('updateRiderRequest',riders);
    return await this.$repositories.riders.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateRiderFailure',  'Some Error OCcured');
         }
         else{
           commit('updateRiderSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateRiderFailure',  e.response.data);
     return e
   });
},
  async filterRiders({ commit }, requestParams) {
    return await this.$repositories.riders.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterRidersFailure',  response.error);
          }
          else if(response.riders){
            commit('filterRidersSuccess', response.riders);
          }
          return response
        },
        error => {
            commit('fetchRidersFailure', error);
            return
        }
    );
  },
  async deleteRiders({ dispatch, commit, state }, {filterData,rider_id}) {
     return await this.$repositories.riders.delete(filterData,rider_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteRiderFailure',  state.message);
           }
           else if(response.riders){
             commit('deleteRiderSuccess', response.riders);
           }
           return response
         },
     );
     error => {
          commit('deleteRiderFailure',  state.message);
         return
     }
  },

  async updateRiderStatus({ commit }, {filterData,rider_id}) {
  return await this.$repositories.riders.updateStatus(filterData,rider_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateRiderStatusFailure',  response.message);
        }
        else if(response.riders){
          commit('updateRiderStatusSuccess', response.riders);
        }
        return response

      },
    );
  },
  async updateRiderIsDefault({ commit }, {filterData,rider_id}) {
  return await this.$repositories.riders.updateIsDefault(filterData,rider_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateRiderIsDefaultFailure',  response.error);
        }
        else if(response.riders){
          commit('updateRiderIsDefaultSuccess', response.riders);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchRiders(state, riders) {
      state.status = { fetching: true };
      state.riders = riders;
  },
  fetchRidersSuccess(state, riders) {
      state.status = { fetched: true };
      state.riders = riders;
  },
  fetchRidersFailure(state) {
      state.status = {};
      state.riders = null;
  },
  addRiderRequest(state, images) {
    state.status = { adding: true };
},
addRiderSuccess(state) {
  // state.riders = riders;
  state.status = { added: true };
},
addRiderFailure(state) {
    state.status = {};
},
updateRiderRequest(state, riders) {
    state.status = { updating: true };
},
updateRiderSuccess(state) {
  state.status = { updated: true };
},
updateRiderFailure(state) {
    state.status = {};
},
  deleteRiderRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteRiderSuccess(state, riders) {
    state.riders = riders;
    state.status = { deleted: true };
  },
  deleteRiderFailure(state) {
      state.status = {deleted: false};
  },
  filterRidersSuccess(state, riders) {
      state.status = { filtered: true };
      state.riders = riders;
  },
  filterRidersFailure(state) {
      state.status = {};
  },
  updateRiderStatusSuccess(state, riders) {
      state.status = { fetched: true };
      state.riders = riders;
  },
  updateRiderStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateRiderIsDefaultSuccess(state, riders) {
      state.status = { fetched: true };
      state.riders = riders;
  },
  updateRiderIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
