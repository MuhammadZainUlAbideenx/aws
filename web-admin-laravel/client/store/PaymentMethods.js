const payment_methods = [];
const state = () => ({
  payment_methods: payment_methods ? payment_methods : null ,
  status: payment_methods ?
     { fetched: true }:{}
})
const getters = {
  allPaymentMethods: state => state.payment_methods,
}

const actions = {
   async fetchPaymentMethods({ commit }) {
     commit('fetchPaymentMethods',payment_methods);
     return await this.$repositories.payment_methods.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchPaymentMethodsFailure',  response.error);
           }
           else if(response.payment_methods){
             commit('fetchPaymentMethodsSuccess', response.payment_methods);
           }
           return response
         },
         error => {
             commit('fetchPaymentMethodsFailure', error);
         }
     );
  },
  async addPaymentMethods({ commit }, requestParams) {
   commit('addPaymentMethodRequest',payment_methods);
   return await this.$repositories.payment_methods.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addPaymentMethodFailure',  response.data.error);
         }
         else{
           commit('addPaymentMethodSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addPaymentMethodFailure',  e.response.data);
     return e
   });
},
async updatePaymentMethods({ commit }, {formData,id}) {
   commit('updatePaymentMethodRequest',payment_methods);
    return await this.$repositories.payment_methods.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updatePaymentMethodFailure',  'Some Error OCcured');
         }
         else{
           commit('updatePaymentMethodSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updatePaymentMethodFailure',  e.response.data);
     return e
   });
},
  async filterPaymentMethods({ commit }, requestParams) {
    return await this.$repositories.payment_methods.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterPaymentMethodsFailure',  response.error);
          }
          else if(response.payment_methods){
            commit('filterPaymentMethodsSuccess', response.payment_methods);
          }
          return response
        },
        error => {
            commit('fetchPaymentMethodsFailure', error);
            return
        }
    );
  },
  async deletePaymentMethods({ dispatch, commit, state }, {filterData,payment_method_id}) {
     return await this.$repositories.payment_methods.delete(filterData,payment_method_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deletePaymentMethodFailure',  state.message);
           }
           else if(response.payment_methods){
             commit('deletePaymentMethodSuccess', response.payment_methods);
           }
           return response
         },
     );
     error => {
          commit('deletePaymentMethodFailure',  state.message);
         return
     }
  },

  async updatePaymentMethodStatus({ commit }, {filterData,payment_method_id}) {
  return await this.$repositories.payment_methods.updateStatus(filterData,payment_method_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updatePaymentMethodStatusFailure',  response.message);
        }
        else if(response.payment_methods){
          commit('updatePaymentMethodStatusSuccess', response.payment_methods);
        }
        return response

      },
    );
  },
  async updatePaymentMethodIsDefault({ commit }, {filterData,payment_method_id}) {
  return await this.$repositories.payment_methods.updateIsDefault(filterData,payment_method_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updatePaymentMethodIsDefaultFailure',  response.error);
        }
        else if(response.payment_methods){
          commit('updatePaymentMethodIsDefaultSuccess', response.payment_methods);
        }
        return response
      },
    );
  },


};

const mutations = {
  fetchPaymentMethods(state, payment_methods) {
      state.status = { fetching: true };
      state.payment_methods = payment_methods;
  },
  fetchPaymentMethodsSuccess(state, payment_methods) {
      state.status = { fetched: true };
      state.payment_methods = payment_methods;
  },
  fetchPaymentMethodsFailure(state) {
      state.status = {};
      state.payment_methods = null;
  },
  addPaymentMethodRequest(state, images) {
    state.status = { adding: true };
},
addPaymentMethodSuccess(state) {
  // state.payment_methods = payment_methods;
  state.status = { added: true };
},
addPaymentMethodFailure(state) {
    state.status = {};
},
updatePaymentMethodRequest(state, payment_methods) {
    state.status = { updating: true };
},
updatePaymentMethodSuccess(state) {
  state.status = { updated: true };
},
updatePaymentMethodFailure(state) {
    state.status = {};
},
  deletePaymentMethodRequest(state, images) {
      state.status = { deleting: true };
  },
  deletePaymentMethodSuccess(state, payment_methods) {
    state.payment_methods = payment_methods;
    state.status = { deleted: true };
  },
  deletePaymentMethodFailure(state) {
      state.status = {deleted: false};
  },
  filterPaymentMethodsSuccess(state, payment_methods) {
      state.status = { filtered: true };
      state.payment_methods = payment_methods;
  },
  filterPaymentMethodsFailure(state) {
      state.status = {};
  },
  updatePaymentMethodStatusSuccess(state, payment_methods) {
      state.status = { fetched: true };
      state.payment_methods = payment_methods;
  },
  updatePaymentMethodStatusFailure(state) {
      state.status = { update_status: false};
  },
  updatePaymentMethodIsDefaultSuccess(state,payment_methods) {
    state.status = { update_status: false};
    state.payment_methods = payment_methods;
  },
  updatePaymentMethodIsDefaultFailure(state) {
      state.status = { fetched: true };
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
