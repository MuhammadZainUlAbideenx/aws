const order_statuses = [];
const state = () => ({
  order_statuses: order_statuses ? order_statuses : null ,
  status: order_statuses ?
     { fetched: true }:{}
})
const getters = {
  allOrderStatuses: state => state.order_statuses,
}

const actions = {
   async fetchOrderStatuses({ commit }) {
     commit('fetchOrderStatuses',order_statuses);
     return await this.$repositories.order_statuses.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchOrderStatusesFailure',  response.error);
           }
           else if(response.order_statuses){
             commit('fetchOrderStatusesSuccess', response.order_statuses);
           }
           return response
         },
         error => {
             commit('fetchOrderStatusesFailure', error);
         }
     );
  },
  async addOrderStatuses({ commit }, requestParams) {
   commit('addOrderStatusRequest',order_statuses);
   return await this.$repositories.order_statuses.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addOrderStatusFailure',  response.data.error);
         }
         else{
           commit('addOrderStatusSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addOrderStatusFailure',  e.response.data);
     return e
   });
},
async updateOrderStatuses({ commit }, {formData,id}) {
   commit('updateOrderStatusRequest',order_statuses);
    return await this.$repositories.order_statuses.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateOrderStatusFailure',  'Some Error OCcured');
         }
         else{
           commit('updateOrderStatusSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateOrderStatusFailure',  e.response.data);
     return e
   });
},
  async filterOrderStatuses({ commit }, requestParams) {
    return await this.$repositories.order_statuses.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterOrderStatusesFailure',  response.error);
          }
          else if(response.order_statuses){
            commit('filterOrderStatusesSuccess', response.order_statuses);
          }
          return response
        },
        error => {
            commit('fetchOrderStatusesFailure', error);
            return
        }
    );
  },
  async deleteOrderStatuses({ dispatch, commit, state }, {filterData,order_status_id}) {
     return await this.$repositories.order_statuses.delete(filterData,order_status_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteOrderStatusFailure',  state.message);
           }
           else if(response.order_statuses){
             commit('deleteOrderStatusSuccess', response.order_statuses);
           }
           return response
         },
     );
     error => {
          commit('deleteOrderStatusFailure',  state.message);
         return
     }
  },

  async updateOrderStatusStatus({ commit }, {filterData,order_status_id}) {
  return await this.$repositories.order_statuses.updateStatus(filterData,order_status_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateOrderStatusStatusFailure',  response.message);
        }
        else if(response.order_statuses){
          commit('updateOrderStatusStatusSuccess', response.order_statuses);
        }
        return response

      },
    );
  },
  async updateOrderStatusIsDefault({ commit }, {filterData,order_status_id}) {
  return await this.$repositories.order_statuses.updateIsDefault(filterData,order_status_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateOrderStatusIsDefaultFailure',  response.error);
        }
        else if(response.order_statuses){
          commit('updateOrderStatusIsDefaultSuccess', response.order_statuses);
        }
        return response
      },
    );
  },


};

const mutations = {
  fetchOrderStatuses(state, order_statuses) {
      state.status = { fetching: true };
      state.order_statuses = order_statuses;
  },
  fetchOrderStatusesSuccess(state, order_statuses) {
      state.status = { fetched: true };
      state.order_statuses = order_statuses;
  },
  fetchOrderStatusesFailure(state) {
      state.status = {};
      state.order_statuses = null;
  },
  addOrderStatusRequest(state, images) {
    state.status = { adding: true };
},
addOrderStatusSuccess(state) {
  // state.order_statuses = order_statuses;
  state.status = { added: true };
},
addOrderStatusFailure(state) {
    state.status = {};
},
updateOrderStatusRequest(state, order_statuses) {
    state.status = { updating: true };
},
updateOrderStatusSuccess(state) {
  state.status = { updated: true };
},
updateOrderStatusFailure(state) {
    state.status = {};
},
  deleteOrderStatusRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteOrderStatusSuccess(state, order_statuses) {
    state.order_statuses = order_statuses;
    state.status = { deleted: true };
  },
  deleteOrderStatusFailure(state) {
      state.status = {deleted: false};
  },
  filterOrderStatusesSuccess(state, order_statuses) {
      state.status = { filtered: true };
      state.order_statuses = order_statuses;
  },
  filterOrderStatusesFailure(state) {
      state.status = {};
  },
  updateOrderStatusStatusSuccess(state, order_statuses) {
      state.status = { fetched: true };
      state.order_statuses = order_statuses;
  },
  updateOrderStatusStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateOrderStatusIsDefaultSuccess(state,order_statuses) {
    state.status = { update_status: false};
    state.order_statuses = order_statuses;
  },
  updateOrderStatusIsDefaultFailure(state) {
      state.status = { fetched: true };
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
