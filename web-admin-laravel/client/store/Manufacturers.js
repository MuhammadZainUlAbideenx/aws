
const manufacturers = [];
const state = () => ({
  manufacturers: manufacturers ? manufacturers : null ,
  status: manufacturers ?
     { fetched: true }:{}
})
const getters = {
  allManufacturers: state => state.manufacturers,
}

const actions = {
   async fetchManufacturers({ commit }) {
     commit('fetchManufacturers',manufacturers);
     return await this.$repositories.manufacturers.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchManufacturersFailure',  response.error);
           }
           else if(response.manufacturers){
             commit('fetchManufacturersSuccess', response.manufacturers);
           }
           return response
         },
         error => {
             commit('fetchManufacturersFailure', error);
         }
     );
  },
  async addManufacturers({ commit }, requestParams) {
   commit('addManufacturerRequest',manufacturers);
   return await this.$repositories.manufacturers.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addManufacturerFailure',  response.data.error);
         }
         else{
           commit('addManufacturerSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addManufacturerFailure',  e.response.data);
     return e
   });
},
async updateManufacturers({ commit }, {formData,id}) {
   commit('updateManufacturerRequest',manufacturers);
    return await this.$repositories.manufacturers.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateManufacturerFailure',  'Some Error OCcured');
         }
         else{
           commit('updateManufacturerSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateManufacturerFailure',  e.response.data);
     return e
   });
},
  async filterManufacturers({ commit }, requestParams) {
    return await this.$repositories.manufacturers.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterManufacturersFailure',  response.error);
          }
          else if(response.manufacturers){
            commit('filterManufacturersSuccess', response.manufacturers);
          }
          return response
        },
        error => {
            commit('fetchManufacturersFailure', error);
            return
        }
    );
  },
  async deleteManufacturers({ dispatch, commit, state }, {filterData,manufacturer_id}) {
     return await this.$repositories.manufacturers.delete(filterData,manufacturer_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteManufacturerFailure',  state.message);
           }
           else if(response.manufacturers){
             commit('deleteManufacturerSuccess', response.manufacturers);
           }
           return response
         },
     );
     error => {
          commit('deleteManufacturerFailure',  state.message);
         return
     }
  },

  async updateManufacturerStatus({ commit }, {filterData,manufacturer_id}) {
  return await this.$repositories.manufacturers.updateStatus(filterData,manufacturer_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateManufacturerStatusFailure',  response.message);
        }
        else if(response.manufacturers){
          commit('updateManufacturerStatusSuccess', response.manufacturers);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchManufacturers(state, manufacturers) {
      state.status = { fetching: true };
      state.manufacturers = manufacturers;
  },
  fetchManufacturersSuccess(state, manufacturers) {
      state.status = { fetched: true };
      state.manufacturers = manufacturers;
  },
  fetchManufacturersFailure(state) {
      state.status = {};
      state.manufacturers = null;
  },
  addManufacturerRequest(state, images) {
    state.status = { adding: true };
},
addManufacturerSuccess(state) {
  // state.manufacturers = manufacturers;
  state.status = { added: true };
},
addManufacturerFailure(state) {
    state.status = {};
},
updateManufacturerRequest(state, manufacturers) {
    state.status = { updating: true };
},
updateManufacturerSuccess(state) {
  state.status = { updated: true };
},
updateManufacturerFailure(state) {
    state.status = {};
},
  deleteManufacturerRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteManufacturerSuccess(state, manufacturers) {
    state.manufacturers = manufacturers;
    state.status = { deleted: true };
  },
  deleteManufacturerFailure(state) {
      state.status = {deleted: false};
  },
  filterManufacturersSuccess(state, manufacturers) {
      state.status = { filtered: true };
      state.manufacturers = manufacturers;
  },
  filterManufacturersFailure(state) {
      state.status = {};
  },
  updateManufacturerStatusSuccess(state, manufacturers) {
      state.status = { fetched: true };
      state.manufacturers = manufacturers;
  },
  updateManufacturerStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
