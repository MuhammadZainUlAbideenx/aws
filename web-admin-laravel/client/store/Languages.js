
const languages = [];
const state = () => ({
  languages: languages ? languages : null ,
  status: languages ?
     { fetched: true }:{}
})
const getters = {
  allLanguages: state => state.languages,
}

const actions = {
   async fetchLanguages({ commit }) {
     commit('fetchLanguages',languages);
     return await this.$repositories.languages.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchLanguagesFailure',  response.error);
           }
           else if(response.languages){
             commit('fetchLanguagesSuccess', response.languages);
           }
           return response
         },
         error => {
             commit('fetchLanguagesFailure', error);
         }
     );
  },
  async addLanguages({ commit }, requestParams) {
   commit('addLanguageRequest',languages);
   return await this.$repositories.languages.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addLanguageFailure',  response.data.error);
         }
         else{
           commit('addLanguageSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addLanguageFailure',  e.response.data);
     return e
   });
},
async updateLanguages({ commit }, {formData,id}) {
   commit('updateLanguageRequest',languages);
    return await this.$repositories.languages.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateLanguageFailure',  'Some Error OCcured');
         }
         else{
           commit('updateLanguageSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateLanguageFailure',  e.response.data);
     return e
   });
},
  async filterLanguages({ commit }, requestParams) {
    return await this.$repositories.languages.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterLanguagesFailure',  response.error);
          }
          else if(response.languages){
            commit('filterLanguagesSuccess', response.languages);
          }
          return response
        },
        error => {
            commit('fetchLanguagesFailure', error);
            return
        }
    );
  },
  async deleteLanguages({ dispatch, commit, state }, {filterData,language_id}) {
     return await this.$repositories.languages.delete(filterData,language_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteLanguageFailure',  state.message);
           }
           else if(response.languages){
             commit('deleteLanguageSuccess', response.languages);
           }
           return response
         },
     );
     error => {
          commit('deleteLanguageFailure',  state.message);
         return
     }
  },

  async updateLanguageStatus({ commit }, {filterData,language_id}) {
  return await this.$repositories.languages.updateStatus(filterData,language_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateLanguageStatusFailure',  response.message);
        }
        else if(response.languages){
          commit('updateLanguageStatusSuccess', response.languages);
        }
        return response

      },
    );
  },
  async updateLanguageIsDefault({ commit }, {filterData,language_id}) {
  return await this.$repositories.languages.updateIsDefault(filterData,language_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateLanguageIsDefaultFailure',  response.error);
        }
        else if(response.languages){
          commit('updateLanguageIsDefaultSuccess', response.languages);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchLanguages(state, languages) {
      state.status = { fetching: true };
      state.languages = languages;
  },
  fetchLanguagesSuccess(state, languages) {
      state.status = { fetched: true };
      state.languages = languages;
  },
  fetchLanguagesFailure(state) {
      state.status = {};
      state.languages = null;
  },
  addLanguageRequest(state, images) {
    state.status = { adding: true };
},
addLanguageSuccess(state) {
  // state.languages = languages;
  state.status = { added: true };
},
addLanguageFailure(state) {
    state.status = {};
},
updateLanguageRequest(state, languages) {
    state.status = { updating: true };
},
updateLanguageSuccess(state) {
  state.status = { updated: true };
},
updateLanguageFailure(state) {
    state.status = {};
},
  deleteLanguageRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteLanguageSuccess(state, languages) {
    state.languages = languages;
    state.status = { deleted: true };
  },
  deleteLanguageFailure(state) {
      state.status = {deleted: false};
  },
  filterLanguagesSuccess(state, languages) {
      state.status = { filtered: true };
      state.languages = languages;
  },
  filterLanguagesFailure(state) {
      state.status = {};
  },
  updateLanguageStatusSuccess(state, languages) {
      state.status = { fetched: true };
      state.languages = languages;
  },
  updateLanguageStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateLanguageIsDefaultSuccess(state, languages) {
      state.status = { fetched: true };
      state.languages = languages;
  },
  updateLanguageIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
