
const countries = [];
const state = () => ({
  countries: countries ? countries : null ,
  status: countries ?
     { fetched: true }:{}
})
const getters = {
  allCountries: state => state.countries,
}

const actions = {
   async fetchCountries({ commit }) {
     commit('fetchCountries',countries);
     return await this.$repositories.countries.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchCountriesFailure',  response.error);
           }
           else if(response.countries){
             commit('fetchCountriesSuccess', response.countries);
           }
           return response
         },
         error => {
             commit('fetchCountriesFailure', error);
         }
     );
  },
  async addCountries({ commit }, requestParams) {
   commit('addCountryRequest',countries);
   return await this.$repositories.countries.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addCountryFailure',  response.data.error);
         }
         else{
           commit('addCountrySuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addCountryFailure',  e.response.data);
     return e
   });
},
async updateCountries({ commit }, {formData,id}) {
   commit('updateCountryRequest',countries);
    return await this.$repositories.countries.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateCountryFailure',  'Some Error OCcured');
         }
         else{
           commit('updateCountrySuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateCountryFailure',  e.response.data);
     return e
   });
},
  async filterCountries({ commit }, requestParams) {
    return await this.$repositories.countries.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterCountriesFailure',  response.error);
          }
          else if(response.countries){
            commit('filterCountriesSuccess', response.countries);
          }
          return response
        },
        error => {
            commit('fetchCountriesFailure', error);
            return
        }
    );
  },
  async deleteCountries({ dispatch, commit, state }, {filterData,country_id}) {
     return await this.$repositories.countries.delete(filterData,country_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteCountryFailure',  state.message);
           }
           else if(response.countries){
             commit('deleteCountrySuccess', response.countries);
           }
           return response
         },
     );
     error => {
          commit('deleteCountryFailure',  state.message);
         return
     }
  },

  async updateCountryStatus({ commit }, {filterData,country_id}) {
  return await this.$repositories.countries.updateStatus(filterData,country_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCountryStatusFailure',  response.message);
        }
        else if(response.countries){
          commit('updateCountryStatusSuccess', response.countries);
        }
        return response

      },
    );
  },
  async updateCountryIsDefault({ commit }, {filterData,country_id}) {
  return await this.$repositories.countries.updateIsDefault(filterData,country_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCountryIsDefaultFailure',  response.error);
        }
        else if(response.countries){
          commit('updateCountryIsDefaultSuccess', response.countries);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchCountries(state, countries) {
      state.status = { fetching: true };
      state.countries = countries;
  },
  fetchCountriesSuccess(state, countries) {
      state.status = { fetched: true };
      state.countries = countries;
  },
  fetchCountriesFailure(state) {
      state.status = {};
      state.countries = null;
  },
  addCountryRequest(state, images) {
    state.status = { adding: true };
},
addCountrySuccess(state) {
  // state.countries = countries;
  state.status = { added: true };
},
addCountryFailure(state) {
    state.status = {};
},
updateCountryRequest(state, countries) {
    state.status = { updating: true };
},
updateCountrySuccess(state) {
  state.status = { updated: true };
},
updateCountryFailure(state) {
    state.status = {};
},
  deleteCountryRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteCountrySuccess(state, countries) {
    state.countries = countries;
    state.status = { deleted: true };
  },
  deleteCountryFailure(state) {
      state.status = {deleted: false};
  },
  filterCountriesSuccess(state, countries) {
      state.status = { filtered: true };
      state.countries = countries;
  },
  filterCountriesFailure(state) {
      state.status = {};
  },
  updateCountryStatusSuccess(state, countries) {
      state.status = { fetched: true };
      state.countries = countries;
  },
  updateCountryStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateCountryIsDefaultSuccess(state, countries) {
      state.status = { fetched: true };
      state.countries = countries;
  },
  updateCountryIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
