
const customers = [];
const state = () => ({
  customers: customers ? customers : null ,
  status: customers ?
     { fetched: true }:{}
})
const getters = {
  allCustomers: state => state.customers,
}

const actions = {
   async fetchCustomers({ commit }) {
     commit('fetchCustomers',customers);
     return await this.$repositories.customers.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchCustomersFailure',  response.error);
           }
           else if(response.customers){
             commit('fetchCustomersSuccess', response.customers);
           }
           return response
         },
         error => {
             commit('fetchCustomersFailure', error);
         }
     );
  },
  async addCustomers({ commit }, requestParams) {
   commit('addCustomerRequest',customers);
   return await this.$repositories.customers.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addCustomerFailure',  response.data.error);
         }
         else{
           commit('addCustomerSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addCustomerFailure',  e.response.data);
     return e
   });
},
async updateCustomers({ commit }, {formData,id}) {
   commit('updateCustomerRequest',customers);
    return await this.$repositories.customers.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateCustomerFailure',  'Some Error OCcured');
         }
         else{
           commit('updateCustomerSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateCustomerFailure',  e.response.data);
     return e
   });
},
  async filterCustomers({ commit }, requestParams) {
    return await this.$repositories.customers.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterCustomersFailure',  response.error);
          }
          else if(response.customers){
            commit('filterCustomersSuccess', response.customers);
          }
          return response
        },
        error => {
            commit('fetchCustomersFailure', error);
            return
        }
    );
  },
  async deleteCustomers({ dispatch, commit, state }, {filterData,customer_id}) {
     return await this.$repositories.customers.delete(filterData,customer_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteCustomerFailure',  state.message);
           }
           else if(response.customers){
             commit('deleteCustomerSuccess', response.customers);
           }
           return response
         },
     );
     error => {
          commit('deleteCustomerFailure',  state.message);
         return
     }
  },

  async updateCustomerStatus({ commit }, {filterData,customer_id}) {
  return await this.$repositories.customers.updateStatus(filterData,customer_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCustomerStatusFailure',  response.message);
        }
        else if(response.customers){
          commit('updateCustomerStatusSuccess', response.customers);
        }
        return response

      },
    );
  },
  async updateCustomerIsDefault({ commit }, {filterData,customer_id}) {
  return await this.$repositories.customers.updateIsDefault(filterData,customer_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCustomerIsDefaultFailure',  response.error);
        }
        else if(response.customers){
          commit('updateCustomerIsDefaultSuccess', response.customers);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchCustomers(state, customers) {
      state.status = { fetching: true };
      state.customers = customers;
  },
  fetchCustomersSuccess(state, customers) {
      state.status = { fetched: true };
      state.customers = customers;
  },
  fetchCustomersFailure(state) {
      state.status = {};
      state.customers = null;
  },
  addCustomerRequest(state, images) {
    state.status = { adding: true };
},
addCustomerSuccess(state) {
  // state.customers = customers;
  state.status = { added: true };
},
addCustomerFailure(state) {
    state.status = {};
},
updateCustomerRequest(state, customers) {
    state.status = { updating: true };
},
updateCustomerSuccess(state) {
  state.status = { updated: true };
},
updateCustomerFailure(state) {
    state.status = {};
},
  deleteCustomerRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteCustomerSuccess(state, customers) {
    state.customers = customers;
    state.status = { deleted: true };
  },
  deleteCustomerFailure(state) {
      state.status = {deleted: false};
  },
  filterCustomersSuccess(state, customers) {
      state.status = { filtered: true };
      state.customers = customers;
  },
  filterCustomersFailure(state) {
      state.status = {};
  },
  updateCustomerStatusSuccess(state, customers) {
      state.status = { fetched: true };
      state.customers = customers;
  },
  updateCustomerStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateCustomerIsDefaultSuccess(state, customers) {
      state.status = { fetched: true };
      state.customers = customers;
  },
  updateCustomerIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
