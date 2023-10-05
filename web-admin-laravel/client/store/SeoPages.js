
const seo_pages = [];
const state = () => ({
  seo_pages: seo_pages ? seo_pages : null ,
  status: seo_pages ?
     { fetched: true }:{}
})
const getters = {
  allSeoPages: state => state.seo_pages,
}

const actions = {
   async fetchSeoPages({ commit }) {
     commit('fetchSeoPages',seo_pages);
     return await this.$repositories.seo_pages.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchSeoPagesFailure',  response.error);
           }
           else if(response.seo_pages){
             commit('fetchSeoPagesSuccess', response.seo_pages);
           }
           return response
         },
         error => {
             commit('fetchSeoPagesFailure', error);
         }
     );
  },
  async addSeoPages({ commit }, requestParams) {
   commit('addSeoPageRequest',seo_pages);
   return await this.$repositories.seo_pages.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addSeoPageFailure',  response.data.error);
         }
         else{
           commit('addSeoPageSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addSeoPageFailure',  e.response.data);
     return e
   });
},
async updateSeoPages({ commit }, {formData,id}) {
   commit('updateSeoPageRequest',seo_pages);
    return await this.$repositories.seo_pages.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateSeoPageFailure',  'Some Error OCcured');
         }
         else{
           commit('updateSeoPageSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateSeoPageFailure',  e.response.data);
     return e
   });
},
  async filterSeoPages({ commit }, requestParams) {
    return await this.$repositories.seo_pages.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterSeoPagesFailure',  response.error);
          }
          else if(response.seo_pages){
            commit('filterSeoPagesSuccess', response.seo_pages);
          }
          return response
        },
        error => {
            commit('fetchSeoPagesFailure', error);
            return
        }
    );
  },
  async deleteSeoPages({ dispatch, commit, state }, {filterData,seo_page_id}) {
     return await this.$repositories.seo_pages.delete(filterData,seo_page_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteSeoPageFailure',  state.message);
           }
           else if(response.seo_pages){
             commit('deleteSeoPageSuccess', response.seo_pages);
           }
           return response
         },
     );
     error => {
          commit('deleteSeoPageFailure',  state.message);
         return
     }
  },

  async updateSeoPageStatus({ commit }, {filterData,seo_page_id}) {
  return await this.$repositories.seo_pages.updateStatus(filterData,seo_page_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateSeoPageStatusFailure',  response.message);
        }
        else if(response.seo_pages){
          commit('updateSeoPageStatusSuccess', response.seo_pages);
        }
        return response

      },
    );
  },
  async updateSeoPageIsDefault({ commit }, {filterData,seo_page_id}) {
  return await this.$repositories.seo_pages.updateIsDefault(filterData,seo_page_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateSeoPageIsDefaultFailure',  response.error);
        }
        else if(response.seo_pages){
          commit('updateSeoPageIsDefaultSuccess', response.seo_pages);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchSeoPages(state, seo_pages) {
      state.status = { fetching: true };
      state.seo_pages = seo_pages;
  },
  fetchSeoPagesSuccess(state, seo_pages) {
      state.status = { fetched: true };
      state.seo_pages = seo_pages;
  },
  fetchSeoPagesFailure(state) {
      state.status = {};
      state.seo_pages = null;
  },
  addSeoPageRequest(state, images) {
    state.status = { adding: true };
},
addSeoPageSuccess(state) {
  // state.seo_pages = seo_pages;
  state.status = { added: true };
},
addSeoPageFailure(state) {
    state.status = {};
},
updateSeoPageRequest(state, seo_pages) {
    state.status = { updating: true };
},
updateSeoPageSuccess(state) {
  state.status = { updated: true };
},
updateSeoPageFailure(state) {
    state.status = {};
},
  deleteSeoPageRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteSeoPageSuccess(state, seo_pages) {
    state.seo_pages = seo_pages;
    state.status = { deleted: true };
  },
  deleteSeoPageFailure(state) {
      state.status = {deleted: false};
  },
  filterSeoPagesSuccess(state, seo_pages) {
      state.status = { filtered: true };
      state.seo_pages = seo_pages;
  },
  filterSeoPagesFailure(state) {
      state.status = {};
  },
  updateSeoPageStatusSuccess(state, seo_pages) {
      state.status = { fetched: true };
      state.seo_pages = seo_pages;
  },
  updateSeoPageStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateSeoPageIsDefaultSuccess(state, seo_pages) {
      state.status = { fetched: true };
      state.seo_pages = seo_pages;
  },
  updateSeoPageIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
