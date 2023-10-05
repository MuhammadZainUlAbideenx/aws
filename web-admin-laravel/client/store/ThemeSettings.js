const actions = {
  async updateThemeSettings({ commit }, requestParams) {
   commit('updateThemeSettingRequest');

   return await this.$repositories.themeSettings.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateThemeSettingFailure',  response.data.error);
         }
         else{
           commit('updateThemeSettingSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('updateThemeSettingFailure',  e.response.data);
     return e
   });
},
}

const mutations = {

updateThemeSettingRequest(state) {
    state.status = { adding: true };
},
updateThemeSettingSuccess(state) {
  state.status = { added: true };
},
updateThemeSettingFailure(state) {
    state.status = {};
},
}

export default {
  actions,
  mutations,
};
