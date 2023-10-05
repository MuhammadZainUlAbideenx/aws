
const parallax_banners = [];
const state = () => ({
  parallax_banners: parallax_banners ? parallax_banners : null ,
  status: parallax_banners ?
     { fetched: true }:{}
})
const getters = {
  allParallaxBanners: state => state.parallax_banners,
}

const actions = {
   async fetchParallaxBanners({ commit }) {
     commit('fetchParallaxBanners',parallax_banners);
     return await this.$repositories.parallax_banners.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchParallaxBannersFailure',  response.error);
           }
           else if(response.parallax_banners){
             commit('fetchParallaxBannersSuccess', response.parallax_banners);
           }
           return response
         },
         error => {
             commit('fetchParallaxBannersFailure', error);
         }
     );
  },
  async addParallaxBanners({ commit }, requestParams) {
   commit('addParallaxBannerRequest',parallax_banners);
   return await this.$repositories.parallax_banners.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addParallaxBannerFailure',  response.data.error);
         }
         else{
           commit('addParallaxBannerSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addParallaxBannerFailure',  e.response.data);
     return e
   });
},
async updateParallaxBanners({ commit }, {formData,id}) {
   commit('updateParallaxBannerRequest',parallax_banners);
    return await this.$repositories.parallax_banners.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateParallaxBannerFailure',  'Some Error OCcured');
         }
         else{
           commit('updateParallaxBannerSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateParallaxBannerFailure',  e.response.data);
     return e
   });
},
  async filterParallaxBanners({ commit }, requestParams) {
    return await this.$repositories.parallax_banners.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterParallaxBannersFailure',  response.error);
          }
          else if(response.parallax_banners){
            commit('filterParallaxBannersSuccess', response.parallax_banners);
          }
          return response
        },
        error => {
            commit('fetchParallaxBannersFailure', error);
            return
        }
    );
  },
  async deleteParallaxBanners({ dispatch, commit, state }, {filterData,parallax_banner_id}) {
     return await this.$repositories.parallax_banners.delete(filterData,parallax_banner_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteParallaxBannerFailure',  state.message);
           }
           else if(response.parallax_banners){
             commit('deleteParallaxBannerSuccess', response.parallax_banners);
           }
           return response
         },
     );
     error => {
          commit('deleteParallaxBannerFailure',  state.message);
         return
     }
  },

  async updateParallaxBannerStatus({ commit }, {filterData,parallax_banner_id}) {
  return await this.$repositories.parallax_banners.updateStatus(filterData,parallax_banner_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateParallaxBannerStatusFailure',  response.message);
        }
        else if(response.parallax_banners){
          commit('updateParallaxBannerStatusSuccess', response.parallax_banners);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchParallaxBanners(state, parallax_banners) {
      state.status = { fetching: true };
      state.parallax_banners = parallax_banners;
  },
  fetchParallaxBannersSuccess(state, parallax_banners) {
      state.status = { fetched: true };
      state.parallax_banners = parallax_banners;
  },
  fetchParallaxBannersFailure(state) {
      state.status = {};
      state.parallax_banners = null;
  },
  addParallaxBannerRequest(state, images) {
    state.status = { adding: true };
},
addParallaxBannerSuccess(state) {
  // state.parallax_banners = parallax_banners;
  state.status = { added: true };
},
addParallaxBannerFailure(state) {
    state.status = {};
},
updateParallaxBannerRequest(state, parallax_banners) {
    state.status = { updating: true };
},
updateParallaxBannerSuccess(state) {
  state.status = { updated: true };
},
updateParallaxBannerFailure(state) {
    state.status = {};
},
  deleteParallaxBannerRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteParallaxBannerSuccess(state, parallax_banners) {
    state.parallax_banners = parallax_banners;
    state.status = { deleted: true };
  },
  deleteParallaxBannerFailure(state) {
      state.status = {deleted: false};
  },
  filterParallaxBannersSuccess(state, parallax_banners) {
      state.status = { filtered: true };
      state.parallax_banners = parallax_banners;
  },
  filterParallaxBannersFailure(state) {
      state.status = {};
  },
  updateParallaxBannerStatusSuccess(state, parallax_banners) {
      state.status = { fetched: true };
      state.parallax_banners = parallax_banners;
  },
  updateParallaxBannerStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
