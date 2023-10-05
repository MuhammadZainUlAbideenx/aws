
const currencies = [];
const state = () => ({
  currencies: currencies ? currencies : null ,
  status: currencies ?
     { fetched: true }:{}
})
const getters = {
  allCurrencies: state => state.currencies,
}

const actions = {
   async fetchCurrencies({ commit }) {
     commit('fetchCurrencies',currencies);
     return await this.$repositories.currencies.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchCurrenciesFailure',  response.error);
           }
           else if(response.currencies){
             commit('fetchCurrenciesSuccess', response.currencies);
           }
           return response
         },
         error => {
             commit('fetchCurrenciesFailure', error);
         }
     );
  },
  async addCurrencies({ commit }, requestParams) {
   commit('addCurrencyRequest',currencies);
   return await this.$repositories.currencies.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addCurrencyFailure',  response.data.error);
         }
         else{
           commit('addCurrencySuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addCurrencyFailure',  e.response.data);
     return e
   });
},
async updateCurrencies({ commit }, {formData,id}) {
   commit('updateCurrencyRequest',currencies);
    return await this.$repositories.currencies.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateCurrencyFailure',  'Some Error OCcured');
         }
         else{
           commit('updateCurrencySuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateCurrencyFailure',  e.response.data);
     return e
   });
},
  async filterCurrencies({ commit }, requestParams) {
    return await this.$repositories.currencies.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterCurrenciesFailure',  response.error);
          }
          else if(response.currencies){
            commit('filterCurrenciesSuccess', response.currencies);
          }
          return response
        },
        error => {
            commit('fetchCurrenciesFailure', error);
            return
        }
    );
  },
  async deleteCurrencies({ dispatch, commit, state }, {filterData,currency_id}) {
     return await this.$repositories.currencies.delete(filterData,currency_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteCurrencyFailure',  state.message);
           }
           else if(response.currencies){
             commit('deleteCurrencySuccess', response.currencies);
           }
           return response
         },
     );
     error => {
          commit('deleteCurrencyFailure',  state.message);
         return
     }
  },

  async updateCurrencyStatus({ commit }, {filterData,currency_id}) {
  return await this.$repositories.currencies.updateStatus(filterData,currency_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCurrencyStatusFailure',  response.message);
        }
        else if(response.currencies){
          commit('updateCurrencyStatusSuccess', response.currencies);
        }
        return response

      },
    );
  },
  async updateCurrencyIsDefault({ commit }, {filterData,currency_id}) {
  return await this.$repositories.currencies.updateIsDefault(filterData,currency_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCurrencyIsDefaultFailure',  response.error);
        }
        else if(response.currencies){
          commit('updateCurrencyIsDefaultSuccess', response.currencies);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchCurrencies(state, currencies) {
      state.status = { fetching: true };
      state.currencies = currencies;
  },
  fetchCurrenciesSuccess(state, currencies) {
      state.status = { fetched: true };
      state.currencies = currencies;
  },
  fetchCurrenciesFailure(state) {
      state.status = {};
      state.currencies = null;
  },
  addCurrencyRequest(state, images) {
    state.status = { adding: true };
},
addCurrencySuccess(state) {
  // state.currencies = currencies;
  state.status = { added: true };
},
addCurrencyFailure(state) {
    state.status = {};
},
updateCurrencyRequest(state, currencies) {
    state.status = { updating: true };
},
updateCurrencySuccess(state) {
  state.status = { updated: true };
},
updateCurrencyFailure(state) {
    state.status = {};
},
  deleteCurrencyRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteCurrencySuccess(state, currencies) {
    state.currencies = currencies;
    state.status = { deleted: true };
  },
  deleteCurrencyFailure(state) {
      state.status = {deleted: false};
  },
  filterCurrenciesSuccess(state, currencies) {
      state.status = { filtered: true };
      state.currencies = currencies;
  },
  filterCurrenciesFailure(state) {
      state.status = {};
  },
  updateCurrencyStatusSuccess(state, currencies) {
      state.status = { fetched: true };
      state.currencies = currencies;
  },
  updateCurrencyStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateCurrencyIsDefaultSuccess(state, currencies) {
      state.status = { fetched: true };
      state.currencies = currencies;
  },
  updateCurrencyIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
