
const orders = [];
const state = () => ({
  orders: orders ? orders : null ,
  status: orders ?
     { fetched: true }:{}
})
const getters = {
  allOrders: state => state.orders,
}

const actions = {
   async fetchOrders({ commit }) {
     commit('fetchOrders',orders);
     return await this.$sellerRepositories.orders.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchOrdersFailure',  response.error);
           }
           else if(response.orders){
             commit('fetchOrdersSuccess', response.orders);
           }
           return response
         },
         error => {
             commit('fetchOrdersFailure', error);
         }
     );
  },
  async addOrders({ commit }, requestParams) {
   commit('addOrderRequest',orders);
   return await this.$sellerRepositories.orders.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addOrderFailure',  response.data.error);
         }
         else{
           commit('addOrderSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addOrderFailure',  e.response.data);
     return e
   });
},
async updateOrders({ commit }, {formData,id}) {
   commit('updateOrderRequest',orders);
    return await this.$sellerRepositories.orders.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateOrderFailure',  'Some Error OCcured');
         }
         else{
           commit('updateOrderSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateOrderFailure',  e.response.data);
     return e
   });
},
  async filterOrders({ commit }, requestParams) {
    return await this.$sellerRepositories.orders.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterOrdersFailure',  response.error);
          }
          else if(response.orders){
            commit('filterOrdersSuccess', response.orders);
          }
          return response
        },
        error => {
            commit('fetchOrdersFailure', error);
            return
        }
    );
  },
  async deleteOrders({ dispatch, commit, state }, {filterData,order_id}) {
     return await this.$sellerRepositories.orders.delete(filterData,order_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteOrderFailure',  state.message);
           }
           else if(response.orders){
             commit('deleteOrderSuccess', response.orders);
           }
           return response
         },
     );
     error => {
          commit('deleteOrderFailure',  state.message);
         return
     }
  },

  async updateOrderStatus({ commit }, {filterData,order_id}) {
  return await this.$sellerRepositories.orders.updateStatus(filterData,order_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateOrderStatusFailure',  response.message);
        }
        else if(response.orders){
          commit('updateOrderStatusSuccess', response.orders);
        }
        return response

      },
    );
  },
  async updateOrderIsDefault({ commit }, {filterData,order_id}) {
  return await this.$sellerRepositories.orders.updateIsDefault(filterData,order_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateOrderIsDefaultFailure',  response.error);
        }
        else if(response.orders){
          commit('updateOrderIsDefaultSuccess', response.orders);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchOrders(state, orders) {
      state.status = { fetching: true };
      state.orders = orders;
  },
  fetchOrdersSuccess(state, orders) {
      state.status = { fetched: true };
      state.orders = orders;
  },
  fetchOrdersFailure(state) {
      state.status = {};
      state.orders = null;
  },
  addOrderRequest(state, images) {
    state.status = { adding: true };
},
addOrderSuccess(state) {
  // state.orders = orders;
  state.status = { added: true };
},
addOrderFailure(state) {
    state.status = {};
},
updateOrderRequest(state, orders) {
    state.status = { updating: true };
},
updateOrderSuccess(state) {
  state.status = { updated: true };
},
updateOrderFailure(state) {
    state.status = {};
},
  deleteOrderRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteOrderSuccess(state, orders) {
    state.orders = orders;
    state.status = { deleted: true };
  },
  deleteOrderFailure(state) {
      state.status = {deleted: false};
  },
  filterOrdersSuccess(state, orders) {
      state.status = { filtered: true };
      state.orders = orders;
  },
  filterOrdersFailure(state) {
      state.status = {};
  },
  updateOrderStatusSuccess(state, orders) {
      state.status = { fetched: true };
      state.orders = orders;
  },
  updateOrderStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateOrderIsDefaultSuccess(state, orders) {
      state.status = { fetched: true };
      state.orders = orders;
  },
  updateOrderIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
