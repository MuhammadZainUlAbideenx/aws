export const state = () => ({
  default_settings: null,
})
export const mutations = {
  fetchDefaultSettingsSuccess(state, default_settings) {
      state.default_settings = default_settings;
  },
  fetchDefaultSettingsFailure(state) {
      state.default_settings = null;
  },
}
export const getters = {
  allDefaultSettings: state => state.default_settings,
}
export const actions = {
  async fetchDefaultSettings({ commit }) {
     await this.$webService.default_settings()
    .then(
        response => {
            commit('fetchDefaultSettingsSuccess', response.data);
        },
        error => {
            commit('fetchDefaultSettingsFailure');
        }
    );
 },
 async nuxtServerInit ({ commit , state , dispatch},{app}) {
    // await dispatch('fetchDefaultSettings')
    // await dispatch('fetchEnvironment')
    // await dispatch('Web/General/fetchLanguages')
    // await dispatch('Web/General/fetchCurrencies')
  },
}
