
const content_application_pages = [];
const state = () => ({
  content_application_pages: content_application_pages ? content_application_pages : null ,
  status: content_application_pages ?
     { fetched: true }:{}
})
const getters = {
  allContentApplicationPages: state => state.content_application_pages,
}

const actions = {
   async fetchContentApplicationPages({ commit }) {
     commit('fetchContentApplicationPages',content_application_pages);
     return await this.$repositories.content_application_pages.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchContentApplicationPagesFailure',  response.error);
           }
           else if(response.content_application_pages){
             commit('fetchContentApplicationPagesSuccess', response.content_application_pages);
           }
           return response
         },
         error => {
             commit('fetchContentApplicationPagesFailure', error);
         }
     );
  },
  async addContentApplicationPages({ commit }, requestParams) {
   commit('addContentApplicationPageRequest',content_application_pages);
   return await this.$repositories.content_application_pages.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addContentApplicationPageFailure',  response.data.error);
         }
         else{
           commit('addContentApplicationPageSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addContentApplicationPageFailure',  e.response.data);
     return e
   });
},
async updateContentApplicationPages({ commit }, {formData,id}) {
   commit('updateContentApplicationPageRequest',content_application_pages);
    return await this.$repositories.content_application_pages.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateContentApplicationPageFailure',  'Some Error OCcured');
         }
         else{
           commit('updateContentApplicationPageSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateContentApplicationPageFailure',  e.response.data);
     return e
   });
},
  async filterContentApplicationPages({ commit }, requestParams) {
    return await this.$repositories.content_application_pages.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterContentApplicationPagesFailure',  response.error);
          }
          else if(response.content_application_pages){
            commit('filterContentApplicationPagesSuccess', response.content_application_pages);
          }
          return response
        },
        error => {
            commit('fetchContentApplicationPagesFailure', error);
            return
        }
    );
  },
  async deleteContentApplicationPages({ dispatch, commit, state }, {filterData,content_application_page_id}) {
     return await this.$repositories.content_application_pages.delete(filterData,content_application_page_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteContentApplicationPageFailure',  state.message);
           }
           else if(response.content_application_pages){
             commit('deleteContentApplicationPageSuccess', response.content_application_pages);
           }
           return response
         },
     );
     error => {
          commit('deleteContentApplicationPageFailure',  state.message);
         return
     }
  },

  async updateContentApplicationPageStatus({ commit }, {filterData,content_application_page_id}) {
  return await this.$repositories.content_application_pages.updateStatus(filterData,content_application_page_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateContentApplicationPageStatusFailure',  response.message);
        }
        else if(response.content_application_pages){
          commit('updateContentApplicationPageStatusSuccess', response.content_application_pages);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchContentApplicationPages(state, content_application_pages) {
      state.status = { fetching: true };
      state.content_application_pages = content_application_pages;
  },
  fetchContentApplicationPagesSuccess(state, content_application_pages) {
      state.status = { fetched: true };
      state.content_application_pages = content_application_pages;
  },
  fetchContentApplicationPagesFailure(state) {
      state.status = {};
      state.content_application_pages = null;
  },
  addContentApplicationPageRequest(state, images) {
    state.status = { adding: true };
},
addContentApplicationPageSuccess(state) {
  // state.content_application_pages = content_application_pages;
  state.status = { added: true };
},
addContentApplicationPageFailure(state) {
    state.status = {};
},
updateContentApplicationPageRequest(state, content_application_pages) {
    state.status = { updating: true };
},
updateContentApplicationPageSuccess(state) {
  state.status = { updated: true };
},
updateContentApplicationPageFailure(state) {
    state.status = {};
},
  deleteContentApplicationPageRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteContentApplicationPageSuccess(state, content_application_pages) {
    state.content_application_pages = content_application_pages;
    state.status = { deleted: true };
  },
  deleteContentApplicationPageFailure(state) {
      state.status = {deleted: false};
  },
  filterContentApplicationPagesSuccess(state, content_application_pages) {
      state.status = { filtered: true };
      state.content_application_pages = content_application_pages;
  },
  filterContentApplicationPagesFailure(state) {
      state.status = {};
  },
  updateContentApplicationPageStatusSuccess(state, content_application_pages) {
      state.status = { fetched: true };
      state.content_application_pages = content_application_pages;
  },
  updateContentApplicationPageStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
