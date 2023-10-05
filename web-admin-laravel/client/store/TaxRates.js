
const tax_rates = [];
const state = () => ({
  tax_rates: tax_rates ? tax_rates : null ,
  status: tax_rates ?
     { fetched: true }:{}
})
const getters = {
  allTaxRates: state => state.tax_rates,
}

const actions = {
   async fetchTaxRates({ commit }) {
     commit('fetchTaxRates',tax_rates);
     return await this.$repositories.tax_rates.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchTaxRatesFailure',  response.error);
           }
           else if(response.tax_rates){
             commit('fetchTaxRatesSuccess', response.tax_rates);
           }
           return response
         },
         error => {
             commit('fetchTaxRatesFailure', error);
         }
     );
  },
  async addTaxRates({ commit }, requestParams) {
   commit('addTaxRateRequest',tax_rates);
   return await this.$repositories.tax_rates.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addTaxRateFailure',  response.data.error);
         }
         else{
           commit('addTaxRateSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addTaxRateFailure',  e.response.data);
     return e
   });
},
async updateTaxRates({ commit }, {formData,id}) {
   commit('updateTaxRateRequest',tax_rates);
    return await this.$repositories.tax_rates.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateTaxRateFailure',  'Some Error OCcured');
         }
         else{
           commit('updateTaxRateSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateTaxRateFailure',  e.response.data);
     return e
   });
},
  async filterTaxRates({ commit }, requestParams) {
    return await this.$repositories.tax_rates.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterTaxRatesFailure',  response.error);
          }
          else if(response.tax_rates){
            commit('filterTaxRatesSuccess', response.tax_rates);
          }
          return response
        },
        error => {
            commit('fetchTaxRatesFailure', error);
            return
        }
    );
  },
  async deleteTaxRates({ dispatch, commit, state }, {filterData,tax_rate_id}) {
     return await this.$repositories.tax_rates.delete(filterData,tax_rate_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteTaxRateFailure',  state.message);
           }
           else if(response.tax_rates){
             commit('deleteTaxRateSuccess', response.tax_rates);
           }
           return response
         },
     );
     error => {
          commit('deleteTaxRateFailure',  state.message);
         return
     }
  },

  async updateTaxRateStatus({ commit }, {filterData,tax_rate_id}) {
  return await this.$repositories.tax_rates.updateStatus(filterData,tax_rate_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateTaxRateStatusFailure',  response.message);
        }
        else if(response.tax_rates){
          commit('updateTaxRateStatusSuccess', response.tax_rates);
        }
        return response

      },
    );
  },
  async updateTaxRateIsDefault({ commit }, {filterData,tax_rate_id}) {
  return await this.$repositories.tax_rates.updateIsDefault(filterData,tax_rate_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateTaxRateIsDefaultFailure',  response.error);
        }
        else if(response.tax_rates){
          commit('updateTaxRateIsDefaultSuccess', response.tax_rates);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchTaxRates(state, tax_rates) {
      state.status = { fetching: true };
      state.tax_rates = tax_rates;
  },
  fetchTaxRatesSuccess(state, tax_rates) {
      state.status = { fetched: true };
      state.tax_rates = tax_rates;
  },
  fetchTaxRatesFailure(state) {
      state.status = {};
      state.tax_rates = null;
  },
  addTaxRateRequest(state, images) {
    state.status = { adding: true };
},
addTaxRateSuccess(state) {
  // state.tax_rates = tax_rates;
  state.status = { added: true };
},
addTaxRateFailure(state) {
    state.status = {};
},
updateTaxRateRequest(state, tax_rates) {
    state.status = { updating: true };
},
updateTaxRateSuccess(state) {
  state.status = { updated: true };
},
updateTaxRateFailure(state) {
    state.status = {};
},
  deleteTaxRateRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteTaxRateSuccess(state, tax_rates) {
    state.tax_rates = tax_rates;
    state.status = { deleted: true };
  },
  deleteTaxRateFailure(state) {
      state.status = {deleted: false};
  },
  filterTaxRatesSuccess(state, tax_rates) {
      state.status = { filtered: true };
      state.tax_rates = tax_rates;
  },
  filterTaxRatesFailure(state) {
      state.status = {};
  },
  updateTaxRateStatusSuccess(state, tax_rates) {
      state.status = { fetched: true };
      state.tax_rates = tax_rates;
  },
  updateTaxRateStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateTaxRateIsDefaultSuccess(state, tax_rates) {
      state.status = { fetched: true };
      state.tax_rates = tax_rates;
  },
  updateTaxRateIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
