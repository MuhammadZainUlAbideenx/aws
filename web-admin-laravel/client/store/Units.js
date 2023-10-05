
const units = [];
const state = () => ({
  units: units ? units : null ,
  status: units ?
     { fetched: true }:{}
})
const getters = {
  allUnits: state => state.units,
}

const actions = {
   async fetchUnits({ commit }) {
     commit('fetchUnits',units);
     return await this.$repositories.units.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchUnitsFailure',  response.error);
           }
           else if(response.units){
             commit('fetchUnitsSuccess', response.units);
           }
           return response
         },
         error => {
             commit('fetchUnitsFailure', error);
         }
     );
  },
  async addUnits({ commit }, requestParams) {
   commit('addUnitRequest',units);
   return await this.$repositories.units.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addUnitFailure',  response.data.error);
         }
         else{
           commit('addUnitSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addUnitFailure',  e.response.data);
     return e
   });
},
async updateUnits({ commit }, {formData,id}) {
   commit('updateUnitRequest',units);
    return await this.$repositories.units.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateUnitFailure',  'Some Error OCcured');
         }
         else{
           commit('updateUnitSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateUnitFailure',  e.response.data);
     return e
   });
},
  async filterUnits({ commit }, requestParams) {
    return await this.$repositories.units.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterUnitsFailure',  response.error);
          }
          else if(response.units){
            commit('filterUnitsSuccess', response.units);
          }
          return response
        },
        error => {
            commit('fetchUnitsFailure', error);
            return
        }
    );
  },
  async deleteUnits({ dispatch, commit, state }, {filterData,unit_id}) {
     return await this.$repositories.units.delete(filterData,unit_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteUnitFailure',  state.message);
           }
           else if(response.units){
             commit('deleteUnitSuccess', response.units);
           }
           return response
         },
     );
     error => {
          commit('deleteUnitFailure',  state.message);
         return
     }
  },

  async updateUnitStatus({ commit }, {filterData,unit_id}) {
  return await this.$repositories.units.updateStatus(filterData,unit_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateUnitStatusFailure',  response.message);
        }
        else if(response.units){
          commit('updateUnitStatusSuccess', response.units);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchUnits(state, units) {
      state.status = { fetching: true };
      state.units = units;
  },
  fetchUnitsSuccess(state, units) {
      state.status = { fetched: true };
      state.units = units;
  },
  fetchUnitsFailure(state) {
      state.status = {};
      state.units = null;
  },
  addUnitRequest(state, images) {
    state.status = { adding: true };
},
addUnitSuccess(state) {
  // state.units = units;
  state.status = { added: true };
},
addUnitFailure(state) {
    state.status = {};
},
updateUnitRequest(state, units) {
    state.status = { updating: true };
},
updateUnitSuccess(state) {
  state.status = { updated: true };
},
updateUnitFailure(state) {
    state.status = {};
},
  deleteUnitRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteUnitSuccess(state, units) {
    state.units = units;
    state.status = { deleted: true };
  },
  deleteUnitFailure(state) {
      state.status = {deleted: false};
  },
  filterUnitsSuccess(state, units) {
      state.status = { filtered: true };
      state.units = units;
  },
  filterUnitsFailure(state) {
      state.status = {};
  },
  updateUnitStatusSuccess(state, units) {
      state.status = { fetched: true };
      state.units = units;
  },
  updateUnitStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
