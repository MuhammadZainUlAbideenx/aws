const newsletters = [];
const state = () => ({
  newsletters: newsletters ? newsletters : null ,
  status: newsletters ?
     { fetched: true }:{}
})
const getters = {
  allNewsletters: state => state.newsletters,
}

const actions = {
   async fetchNewsletters({ commit }) {
     commit('fetchNewsletters',newsletters);
     return await this.$repositories.newsletter.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchNewslettersFailure',  response.error);
           }
           else if(response.newsletters){
             commit('fetchNewslettersSuccess', response.newsletters);
           }
           return response
         },
         error => {
             commit('fetchNewslettersFailure', error);
         }
     );
  },
  async addNewsletters({ commit }, requestParams) {
   commit('addNewsletterRequest',newsletters);
   return await this.$repositories.newsletter.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addNewsletterFailure',  response.data.error);
         }
         else{
           commit('addNewsletterSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addNewsletterFailure',  e.response.data);
     return e
   });
},
async updateNewsletters({ commit }, {formData,id}) {
   commit('updateNewsletterRequest',newsletters);
    return await this.$repositories.newsletter.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateNewsletterFailure',  'Some Error OCcured');
         }
         else{
           commit('updateNewsletterSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateNewsletterFailure',  e.response.data);
     return e
   });
},
  async filterNewsletters({ commit }, requestParams) {
    return await this.$repositories.newsletter.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterNewslettersFailure',  response.error);
          }
          else if(response.newsletters){
            commit('filterNewslettersSuccess', response.newsletters);
          }
          return response
        },
        error => {
            commit('fetchNewslettersFailure', error);
            return
        }
    );
  },
  async deleteNewsletters({ dispatch, commit, state }, {filterData,newsletter_id}) {
     return await this.$repositories.newsletter.delete(filterData,newsletter_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteNewsletterFailure',  state.message);
           }
           else if(response.newsletters){
             commit('deleteNewsletterSuccess', response.newsletters);
           }
           return response
         },
     );
     error => {
          commit('deleteNewsletterFailure',  state.message);
         return
     }
  },

  async updateNewsletterStatus({ commit }, {filterData,newsletter_id}) {
  return await this.$repositories.newsletter.updateStatus(filterData,newsletter_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateNewsletterStatusFailure',  response.message);
        }
        else if(response.newsletters){
          commit('updateNewsletterStatusSuccess', response.newsletters);
        }
        return response

      },
    );
  },
  async updateNewsletterIsDefault({ commit }, {filterData,newsletter_id}) {
  return await this.$repositories.newsletter.updateIsDefault(filterData,newsletter_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateNewsletterIsDefaultFailure',  response.error);
        }
        else if(response.newsletters){
          commit('updateNewsletterIsDefaultSuccess', response.newsletters);
        }
        return response
      },
    );
  },


};

const mutations = {
  fetchNewsletters(state, newsletters) {
      state.status = { fetching: true };
      state.newsletters = newsletters;
  },
  fetchNewslettersSuccess(state, newsletters) {
      state.status = { fetched: true };
      state.newsletters = newsletters;
  },
  fetchNewslettersFailure(state) {
      state.status = {};
      state.newsletters = null;
  },
  addNewsletterRequest(state, images) {
    state.status = { adding: true };
},
addNewsletterSuccess(state) {
  // state.newsletters = newsletters;
  state.status = { added: true };
},
addNewsletterFailure(state) {
    state.status = {};
},
updateNewsletterRequest(state, newsletters) {
    state.status = { updating: true };
},
updateNewsletterSuccess(state) {
  state.status = { updated: true };
},
updateNewsletterFailure(state) {
    state.status = {};
},
  deleteNewsletterRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteNewsletterSuccess(state, newsletters) {
    state.newsletters = newsletters;
    state.status = { deleted: true };
  },
  deleteNewsletterFailure(state) {
      state.status = {deleted: false};
  },
  filterNewslettersSuccess(state, newsletters) {
      state.status = { filtered: true };
      state.newsletters = newsletters;
  },
  filterNewslettersFailure(state) {
      state.status = {};
  },
  updateNewsletterStatusSuccess(state, newsletters) {
      state.status = { fetched: true };
      state.newsletters = newsletters;
  },
  updateNewsletterStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateNewsletterIsDefaultSuccess(state,newsletters) {
    state.status = { update_status: false};
    state.newsletters = newsletters;
  },
  updateNewsletterIsDefaultFailure(state) {
      state.status = { fetched: true };
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
