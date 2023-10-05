const actions = {
  async addInventories({ commit }, requestParams) {
   commit('addInventoryRequest');
   return await this.$repositories.inventories.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addInventoryFailure',  response.data.error);
         }
         else{
           commit('addInventorySuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addInventoryFailure',  e.response.data);
     return e
   });
},
}

const mutations = {

addInventoryRequest(state) {
    state.status = { adding: true };
},
addInventorySuccess(state) {
  state.status = { added: true };
},
addInventoryFailure(state) {
    state.status = {};
},
}

export default {
  actions,
  mutations,
};
