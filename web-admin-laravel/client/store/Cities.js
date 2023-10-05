
const cities = [];
const state = () => ({
  cities: cities ? cities : null ,
  status: cities ?
     { fetched: true }:{}
})
const getters = {
  allCities: state => state.cities,
}

const actions = {
   async fetchCities({ commit }) {
     commit('fetchCities',cities);
     return await this.$repositories.cities.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchCitiesFailure',  response.error);
           }
           else if(response.cities){
             commit('fetchCitiesSuccess', response.cities);
           }
           return response
         },
         error => {
             commit('fetchCitiesFailure', error);
         }
     );
  },
  async addCities({ commit }, requestParams) {
   commit('addCityRequest',cities);
   return await this.$repositories.cities.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addCityFailure',  response.data.error);
         }
         else{
           commit('addCitySuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addCityFailure',  e.response.data);
     return e
   });
},
async updateCities({ commit }, {formData,id}) {
   commit('updateCityRequest',cities);
    return await this.$repositories.cities.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateCityFailure',  'Some Error OCcured');
         }
         else{
           commit('updateCitySuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateCityFailure',  e.response.data);
     return e
   });
},
  async filterCities({ commit }, requestParams) {
    return await this.$repositories.cities.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterCitiesFailure',  response.error);
          }
          else if(response.cities){
            commit('filterCitiesSuccess', response.cities);
          }
          return response
        },
        error => {
            commit('fetchCitiesFailure', error);
            return
        }
    );
  },
  async deleteCities({ dispatch, commit, state }, {filterData,city_id}) {
     return await this.$repositories.cities.delete(filterData,city_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteCityFailure',  state.message);
           }
           else if(response.cities){
             commit('deleteCitySuccess', response.cities);
           }
           return response
         },
     );
     error => {
          commit('deleteCityFailure',  state.message);
         return
     }
  },

  async updateCityStatus({ commit }, {filterData,city_id}) {
  return await this.$repositories.cities.updateStatus(filterData,city_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCityStatusFailure',  response.message);
        }
        else if(response.cities){
          commit('updateCityStatusSuccess', response.cities);
        }
        return response

      },
    );
  },
  async updateCityIsDefault({ commit }, {filterData,city_id}) {
  return await this.$repositories.cities.updateIsDefault(filterData,city_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCityIsDefaultFailure',  response.error);
        }
        else if(response.cities){
          commit('updateCityIsDefaultSuccess', response.cities);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchCities(state, cities) {
      state.status = { fetching: true };
      state.cities = cities;
  },
  fetchCitiesSuccess(state, cities) {
      state.status = { fetched: true };
      state.cities = cities;
  },
  fetchCitiesFailure(state) {
      state.status = {};
      state.cities = null;
  },
  addCityRequest(state, images) {
    state.status = { adding: true };
},
addCitySuccess(state) {
  // state.cities = cities;
  state.status = { added: true };
},
addCityFailure(state) {
    state.status = {};
},
updateCityRequest(state, cities) {
    state.status = { updating: true };
},
updateCitySuccess(state) {
  state.status = { updated: true };
},
updateCityFailure(state) {
    state.status = {};
},
  deleteCityRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteCitySuccess(state, cities) {
    state.cities = cities;
    state.status = { deleted: true };
  },
  deleteCityFailure(state) {
      state.status = {deleted: false};
  },
  filterCitiesSuccess(state, cities) {
      state.status = { filtered: true };
      state.cities = cities;
  },
  filterCitiesFailure(state) {
      state.status = {};
  },
  updateCityStatusSuccess(state, cities) {
      state.status = { fetched: true };
      state.cities = cities;
  },
  updateCityStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateCityIsDefaultSuccess(state, cities) {
      state.status = { fetched: true };
      state.cities = cities;
  },
  updateCityIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
