
const zones = [];
const state = () => ({
  zones: zones ? zones : null ,
  status: zones ?
     { fetched: true }:{}
})
const getters = {
  allZones: state => state.zones,
}

const actions = {
   async fetchZones({ commit }) {
     commit('fetchZones',zones);
     return await this.$repositories.zones.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchZonesFailure',  response.error);
           }
           else if(response.zones){
             commit('fetchZonesSuccess', response.zones);
           }
           return response
         },
         error => {
             commit('fetchZonesFailure', error);
         }
     );
  },
  async addZones({ commit }, requestParams) {
   commit('addZoneRequest',zones);
   return await this.$repositories.zones.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addZoneFailure',  response.data.error);
         }
         else{
           commit('addZoneSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addZoneFailure',  e.response.data);
     return e
   });
},
async updateZones({ commit }, {formData,id}) {
   commit('updateZoneRequest',zones);
    return await this.$repositories.zones.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateZoneFailure',  'Some Error OCcured');
         }
         else{
           commit('updateZoneSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateZoneFailure',  e.response.data);
     return e
   });
},
  async filterZones({ commit }, requestParams) {
    return await this.$repositories.zones.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterZonesFailure',  response.error);
          }
          else if(response.zones){
            commit('filterZonesSuccess', response.zones);
          }
          return response
        },
        error => {
            commit('fetchZonesFailure', error);
            return
        }
    );
  },
  async deleteZones({ dispatch, commit, state }, {filterData,zone_id}) {
     return await this.$repositories.zones.delete(filterData,zone_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteZoneFailure',  state.message);
           }
           else if(response.zones){
             commit('deleteZoneSuccess', response.zones);
           }
           return response
         },
     );
     error => {
          commit('deleteZoneFailure',  state.message);
         return
     }
  },

  async updateZoneStatus({ commit }, {filterData,zone_id}) {
  return await this.$repositories.zones.updateStatus(filterData,zone_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateZoneStatusFailure',  response.message);
        }
        else if(response.zones){
          commit('updateZoneStatusSuccess', response.zones);
        }
        return response

      },
    );
  },
  async updateZoneIsDefault({ commit }, {filterData,zone_id}) {
  return await this.$repositories.zones.updateIsDefault(filterData,zone_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateZoneIsDefaultFailure',  response.error);
        }
        else if(response.zones){
          commit('updateZoneIsDefaultSuccess', response.zones);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchZones(state, zones) {
      state.status = { fetching: true };
      state.zones = zones;
  },
  fetchZonesSuccess(state, zones) {
      state.status = { fetched: true };
      state.zones = zones;
  },
  fetchZonesFailure(state) {
      state.status = {};
      state.zones = null;
  },
  addZoneRequest(state, images) {
    state.status = { adding: true };
},
addZoneSuccess(state) {
  // state.zones = zones;
  state.status = { added: true };
},
addZoneFailure(state) {
    state.status = {};
},
updateZoneRequest(state, zones) {
    state.status = { updating: true };
},
updateZoneSuccess(state) {
  state.status = { updated: true };
},
updateZoneFailure(state) {
    state.status = {};
},
  deleteZoneRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteZoneSuccess(state, zones) {
    state.zones = zones;
    state.status = { deleted: true };
  },
  deleteZoneFailure(state) {
      state.status = {deleted: false};
  },
  filterZonesSuccess(state, zones) {
      state.status = { filtered: true };
      state.zones = zones;
  },
  filterZonesFailure(state) {
      state.status = {};
  },
  updateZoneStatusSuccess(state, zones) {
      state.status = { fetched: true };
      state.zones = zones;
  },
  updateZoneStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateZoneIsDefaultSuccess(state, zones) {
      state.status = { fetched: true };
      state.zones = zones;
  },
  updateZoneIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
