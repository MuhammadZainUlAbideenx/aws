
const static_banners = [];
const state = () => ({
  static_banners: static_banners ? static_banners : null ,
  status: static_banners ?
     { fetched: true }:{}
})
const getters = {
  allStaticBanners: state => state.static_banners,
}

const actions = {
   async fetchStaticBanners({ commit }) {
     commit('fetchStaticBanners',static_banners);
     return await this.$repositories.static_banners.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchStaticBannersFailure',  response.error);
           }
           else if(response.static_banners){
             commit('fetchStaticBannersSuccess', response.static_banners);
           }
           return response
         },
         error => {
             commit('fetchStaticBannersFailure', error);
         }
     );
  },
  async addStaticBanners({ commit }, requestParams) {
   commit('addStaticBannerRequest',static_banners);
   return await this.$repositories.static_banners.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addStaticBannerFailure',  response.data.error);
         }
         else{
           commit('addStaticBannerSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addStaticBannerFailure',  e.response.data);
     return e
   });
},
async updateStaticBanners({ commit }, {formData,id}) {
   commit('updateStaticBannerRequest',static_banners);
    return await this.$repositories.static_banners.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateStaticBannerFailure',  'Some Error OCcured');
         }
         else{
           commit('updateStaticBannerSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateStaticBannerFailure',  e.response.data);
     return e
   });
},
  async filterStaticBanners({ commit }, requestParams) {
    return await this.$repositories.static_banners.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterStaticBannersFailure',  response.error);
          }
          else if(response.static_banners){
            commit('filterStaticBannersSuccess', response.static_banners);
          }
          return response
        },
        error => {
            commit('fetchStaticBannersFailure', error);
            return
        }
    );
  },
  async deleteStaticBanners({ dispatch, commit, state }, {filterData,static_banner_id}) {
     return await this.$repositories.static_banners.delete(filterData,static_banner_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteStaticBannerFailure',  state.message);
           }
           else if(response.static_banners){
             commit('deleteStaticBannerSuccess', response.static_banners);
           }
           return response
         },
     );
     error => {
          commit('deleteStaticBannerFailure',  state.message);
         return
     }
  },

  async updateStaticBannerStatus({ commit }, {filterData,static_banner_id}) {
  return await this.$repositories.static_banners.updateStatus(filterData,static_banner_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateStaticBannerStatusFailure',  response.message);
        }
        else if(response.static_banners){
          commit('updateStaticBannerStatusSuccess', response.static_banners);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchStaticBanners(state, static_banners) {
      state.status = { fetching: true };
      state.static_banners = static_banners;
  },
  fetchStaticBannersSuccess(state, static_banners) {
      state.status = { fetched: true };
      state.static_banners = static_banners;
  },
  fetchStaticBannersFailure(state) {
      state.status = {};
      state.static_banners = null;
  },
  addStaticBannerRequest(state, images) {
    state.status = { adding: true };
},
addStaticBannerSuccess(state) {
  // state.static_banners = static_banners;
  state.status = { added: true };
},
addStaticBannerFailure(state) {
    state.status = {};
},
updateStaticBannerRequest(state, static_banners) {
    state.status = { updating: true };
},
updateStaticBannerSuccess(state) {
  state.status = { updated: true };
},
updateStaticBannerFailure(state) {
    state.status = {};
},
  deleteStaticBannerRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteStaticBannerSuccess(state, static_banners) {
    state.static_banners = static_banners;
    state.status = { deleted: true };
  },
  deleteStaticBannerFailure(state) {
      state.status = {deleted: false};
  },
  filterStaticBannersSuccess(state, static_banners) {
      state.status = { filtered: true };
      state.static_banners = static_banners;
  },
  filterStaticBannersFailure(state) {
      state.status = {};
  },
  updateStaticBannerStatusSuccess(state, static_banners) {
      state.status = { fetched: true };
      state.static_banners = static_banners;
  },
  updateStaticBannerStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
