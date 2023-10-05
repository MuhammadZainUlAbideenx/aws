
const content_pages = [];
const state = () => ({
  content_pages: content_pages ? content_pages : null ,
  status: content_pages ?
     { fetched: true }:{}
})
const getters = {
  allContentPages: state => state.content_pages,
}

const actions = {
   async fetchContentPages({ commit }) {
     commit('fetchContentPages',content_pages);
     return await this.$repositories.content_pages.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchContentPagesFailure',  response.error);
           }
           else if(response.content_pages){
             commit('fetchContentPagesSuccess', response.content_pages);
           }
           return response
         },
         error => {
             commit('fetchContentPagesFailure', error);
         }
     );
  },
  async addContentPages({ commit }, requestParams) {
   commit('addContentPageRequest',content_pages);
   return await this.$repositories.content_pages.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addContentPageFailure',  response.data.error);
         }
         else{
           commit('addContentPageSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addContentPageFailure',  e.response.data);
     return e
   });
},
async updateContentPages({ commit }, {formData,id}) {
   commit('updateContentPageRequest',content_pages);
    return await this.$repositories.content_pages.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateContentPageFailure',  'Some Error OCcured');
         }
         else{
           commit('updateContentPageSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateContentPageFailure',  e.response.data);
     return e
   });
},
  async filterContentPages({ commit }, requestParams) {
    return await this.$repositories.content_pages.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterContentPagesFailure',  response.error);
          }
          else if(response.content_pages){
            commit('filterContentPagesSuccess', response.content_pages);
          }
          return response
        },
        error => {
            commit('fetchContentPagesFailure', error);
            return
        }
    );
  },
  async deleteContentPages({ dispatch, commit, state }, {filterData,content_page_id}) {
     return await this.$repositories.content_pages.delete(filterData,content_page_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteContentPageFailure',  state.message);
           }
           else if(response.content_pages){
             commit('deleteContentPageSuccess', response.content_pages);
           }
           return response
         },
     );
     error => {
          commit('deleteContentPageFailure',  state.message);
         return
     }
  },

  async updateContentPageStatus({ commit }, {filterData,content_page_id}) {
  return await this.$repositories.content_pages.updateStatus(filterData,content_page_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateContentPageStatusFailure',  response.message);
        }
        else if(response.content_pages){
          commit('updateContentPageStatusSuccess', response.content_pages);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchContentPages(state, content_pages) {
      state.status = { fetching: true };
      state.content_pages = content_pages;
  },
  fetchContentPagesSuccess(state, content_pages) {
      state.status = { fetched: true };
      state.content_pages = content_pages;
  },
  fetchContentPagesFailure(state) {
      state.status = {};
      state.content_pages = null;
  },
  addContentPageRequest(state, images) {
    state.status = { adding: true };
},
addContentPageSuccess(state) {
  // state.content_pages = content_pages;
  state.status = { added: true };
},
addContentPageFailure(state) {
    state.status = {};
},
updateContentPageRequest(state, content_pages) {
    state.status = { updating: true };
},
updateContentPageSuccess(state) {
  state.status = { updated: true };
},
updateContentPageFailure(state) {
    state.status = {};
},
  deleteContentPageRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteContentPageSuccess(state, content_pages) {
    state.content_pages = content_pages;
    state.status = { deleted: true };
  },
  deleteContentPageFailure(state) {
      state.status = {deleted: false};
  },
  filterContentPagesSuccess(state, content_pages) {
      state.status = { filtered: true };
      state.content_pages = content_pages;
  },
  filterContentPagesFailure(state) {
      state.status = {};
  },
  updateContentPageStatusSuccess(state, content_pages) {
      state.status = { fetched: true };
      state.content_pages = content_pages;
  },
  updateContentPageStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
