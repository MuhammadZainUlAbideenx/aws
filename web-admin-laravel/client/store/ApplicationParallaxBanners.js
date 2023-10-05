
const application_parallax_banners = [];
const state = () => ({
  application_parallax_banners: application_parallax_banners ? application_parallax_banners : null ,
  status: application_parallax_banners ?
     { fetched: true }:{}
})
const getters = {
  allApplicationParallaxBanners: state => state.application_parallax_banners,
}

const actions = {
   async fetchApplicationParallaxBanners({ commit }) {
     commit('fetchApplicationParallaxBanners',application_parallax_banners);
     return await this.$repositories.application_parallax_banners.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchApplicationParallaxBannersFailure',  response.error);
           }
           else if(response.application_parallax_banners){
             commit('fetchApplicationParallaxBannersSuccess', response.application_parallax_banners);
           }
           return response
         },
         error => {
             commit('fetchApplicationParallaxBannersFailure', error);
         }
     );
  },
  async addApplicationParallaxBanners({ commit }, requestParams) {
   commit('addApplicationParallaxBannerRequest',application_parallax_banners);
   return await this.$repositories.application_parallax_banners.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addApplicationParallaxBannerFailure',  response.data.error);
         }
         else{
           commit('addApplicationParallaxBannerSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addApplicationParallaxBannerFailure',  e.response.data);
     return e
   });
},
async updateApplicationParallaxBanners({ commit }, {formData,id}) {
   commit('updateApplicationParallaxBannerRequest',application_parallax_banners);
    return await this.$repositories.application_parallax_banners.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateApplicationParallaxBannerFailure',  'Some Error OCcured');
         }
         else{
           commit('updateApplicationParallaxBannerSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateApplicationParallaxBannerFailure',  e.response.data);
     return e
   });
},
  async filterApplicationParallaxBanners({ commit }, requestParams) {
    return await this.$repositories.application_parallax_banners.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterApplicationParallaxBannersFailure',  response.error);
          }
          else if(response.application_parallax_banners){
            commit('filterApplicationParallaxBannersSuccess', response.application_parallax_banners);
          }
          return response
        },
        error => {
            commit('fetchApplicationParallaxBannersFailure', error);
            return
        }
    );
  },
  async deleteApplicationParallaxBanners({ dispatch, commit, state }, {filterData,application_parallax_banner_id}) {
     return await this.$repositories.application_parallax_banners.delete(filterData,application_parallax_banner_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteApplicationParallaxBannerFailure',  state.message);
           }
           else if(response.application_parallax_banners){
             commit('deleteApplicationParallaxBannerSuccess', response.application_parallax_banners);
           }
           return response
         },
     );
     error => {
          commit('deleteApplicationParallaxBannerFailure',  state.message);
         return
     }
  },

  async updateApplicationParallaxBannerStatus({ commit }, {filterData,application_parallax_banner_id}) {
  return await this.$repositories.application_parallax_banners.updateStatus(filterData,application_parallax_banner_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateApplicationParallaxBannerStatusFailure',  response.message);
        }
        else if(response.application_parallax_banners){
          commit('updateApplicationParallaxBannerStatusSuccess', response.application_parallax_banners);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchApplicationParallaxBanners(state, application_parallax_banners) {
      state.status = { fetching: true };
      state.application_parallax_banners = application_parallax_banners;
  },
  fetchApplicationParallaxBannersSuccess(state, application_parallax_banners) {
      state.status = { fetched: true };
      state.application_parallax_banners = application_parallax_banners;
  },
  fetchApplicationParallaxBannersFailure(state) {
      state.status = {};
      state.application_parallax_banners = null;
  },
  addApplicationParallaxBannerRequest(state, images) {
    state.status = { adding: true };
},
addApplicationParallaxBannerSuccess(state) {
  // state.application_parallax_banners = application_parallax_banners;
  state.status = { added: true };
},
addApplicationParallaxBannerFailure(state) {
    state.status = {};
},
updateApplicationParallaxBannerRequest(state, application_parallax_banners) {
    state.status = { updating: true };
},
updateApplicationParallaxBannerSuccess(state) {
  state.status = { updated: true };
},
updateApplicationParallaxBannerFailure(state) {
    state.status = {};
},
  deleteApplicationParallaxBannerRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteApplicationParallaxBannerSuccess(state, application_parallax_banners) {
    state.application_parallax_banners = application_parallax_banners;
    state.status = { deleted: true };
  },
  deleteApplicationParallaxBannerFailure(state) {
      state.status = {deleted: false};
  },
  filterApplicationParallaxBannersSuccess(state, application_parallax_banners) {
      state.status = { filtered: true };
      state.application_parallax_banners = application_parallax_banners;
  },
  filterApplicationParallaxBannersFailure(state) {
      state.status = {};
  },
  updateApplicationParallaxBannerStatusSuccess(state, application_parallax_banners) {
      state.status = { fetched: true };
      state.application_parallax_banners = application_parallax_banners;
  },
  updateApplicationParallaxBannerStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
