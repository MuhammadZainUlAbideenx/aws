const actions = {
  async addSettings({ commit }, requestParams) {
   commit('addSettingRequest');
   return await this.$repositories.settings.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addSettingFailure',  response.data.error);
         }
         else{
           commit('addSettingSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addSettingFailure',  e.response.data);
     return e
   });
},
}

const mutations = {

addSettingRequest(state) {
    state.status = { adding: true };
},
addSettingSuccess(state) {
  state.status = { added: true };
},
addSettingFailure(state) {
    state.status = {};
},
}

export default {
  actions,
  mutations,
};
