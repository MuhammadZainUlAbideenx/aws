const shipping_methods = [];
const state = () => ({
  shipping_methods: shipping_methods ? shipping_methods : null ,
  status: shipping_methods ?
     { fetched: true }:{}
})
const getters = {
  allShippingMethods: state => state.shipping_methods,
}

const actions = {
   async fetchShippingMethods({ commit }) {
     commit('fetchShippingMethods',shipping_methods);
     return await this.$repositories.shipping_methods.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchShippingMethodsFailure',  response.error);
           }
           else if(response.shipping_methods){
             commit('fetchShippingMethodsSuccess', response.shipping_methods);
           }
           return response
         },
         error => {
             commit('fetchShippingMethodsFailure', error);
         }
     );
  },
  async addShippingMethods({ commit }, requestParams) {
   commit('addShippingMethodRequest',shipping_methods);
   return await this.$repositories.shipping_methods.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addShippingMethodFailure',  response.data.error);
         }
         else{
           commit('addShippingMethodSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addShippingMethodFailure',  e.response.data);
     return e
   });
},
async updateShippingMethods({ commit }, {formData,id}) {
   commit('updateShippingMethodRequest',shipping_methods);
    return await this.$repositories.shipping_methods.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateShippingMethodFailure',  'Some Error OCcured');
         }
         else{
           commit('updateShippingMethodSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateShippingMethodFailure',  e.response.data);
     return e
   });
},
  async filterShippingMethods({ commit }, requestParams) {
    return await this.$repositories.shipping_methods.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterShippingMethodsFailure',  response.error);
          }
          else if(response.shipping_methods){
            commit('filterShippingMethodsSuccess', response.shipping_methods);
          }
          return response
        },
        error => {
            commit('fetchShippingMethodsFailure', error);
            return
        }
    );
  },
  async deleteShippingMethods({ dispatch, commit, state }, {filterData,shipping_method_id}) {
     return await this.$repositories.shipping_methods.delete(filterData,shipping_method_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteShippingMethodFailure',  state.message);
           }
           else if(response.shipping_methods){
             commit('deleteShippingMethodSuccess', response.shipping_methods);
           }
           return response
         },
     );
     error => {
          commit('deleteShippingMethodFailure',  state.message);
         return
     }
  },

  async updateShippingMethodStatus({ commit }, {filterData,shipping_method_id}) {
  return await this.$repositories.shipping_methods.updateStatus(filterData,shipping_method_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateShippingMethodStatusFailure',  response.message);
        }
        else if(response.shipping_methods){
          commit('updateShippingMethodStatusSuccess', response.shipping_methods);
        }
        return response

      },
    );
  },
  async updateShippingMethodIsDefault({ commit }, {filterData,shipping_method_id}) {
  return await this.$repositories.shipping_methods.updateIsDefault(filterData,shipping_method_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateShippingMethodIsDefaultFailure',  response.error);
        }
        else if(response.shipping_methods){
          commit('updateShippingMethodIsDefaultSuccess', response.shipping_methods);
        }
        return response
      },
    );
  },


};

const mutations = {
  fetchShippingMethods(state, shipping_methods) {
      state.status = { fetching: true };
      state.shipping_methods = shipping_methods;
  },
  fetchShippingMethodsSuccess(state, shipping_methods) {
      state.status = { fetched: true };
      state.shipping_methods = shipping_methods;
  },
  fetchShippingMethodsFailure(state) {
      state.status = {};
      state.shipping_methods = null;
  },
  addShippingMethodRequest(state, images) {
    state.status = { adding: true };
},
addShippingMethodSuccess(state) {
  // state.shipping_methods = shipping_methods;
  state.status = { added: true };
},
addShippingMethodFailure(state) {
    state.status = {};
},
updateShippingMethodRequest(state, shipping_methods) {
    state.status = { updating: true };
},
updateShippingMethodSuccess(state) {
  state.status = { updated: true };
},
updateShippingMethodFailure(state) {
    state.status = {};
},
  deleteShippingMethodRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteShippingMethodSuccess(state, shipping_methods) {
    state.shipping_methods = shipping_methods;
    state.status = { deleted: true };
  },
  deleteShippingMethodFailure(state) {
      state.status = {deleted: false};
  },
  filterShippingMethodsSuccess(state, shipping_methods) {
      state.status = { filtered: true };
      state.shipping_methods = shipping_methods;
  },
  filterShippingMethodsFailure(state) {
      state.status = {};
  },
  updateShippingMethodStatusSuccess(state, shipping_methods) {
      state.status = { fetched: true };
      state.shipping_methods = shipping_methods;
  },
  updateShippingMethodStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateShippingMethodIsDefaultSuccess(state,shipping_methods) {
    state.status = { update_status: false};
    state.shipping_methods = shipping_methods;
  },
  updateShippingMethodIsDefaultFailure(state) {
      state.status = { fetched: true };
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
