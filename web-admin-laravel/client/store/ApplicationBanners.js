
const application_banners = [];
const state = () => ({
  application_banners: application_banners ? application_banners : null ,
  status: application_banners ?
     { fetched: true }:{}
})
const getters = {
  allApplicationBanners: state => state.application_banners,
}

const actions = {
   async fetchApplicationBanners({ commit }) {
     commit('fetchApplicationBanners',application_banners);
     return await this.$repositories.application_banners.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchApplicationBannersFailure',  response.error);
           }
           else if(response.application_banners){
             commit('fetchApplicationBannersSuccess', response.application_banners);
           }
           return response
         },
         error => {
             commit('fetchApplicationBannersFailure', error);
         }
     );
  },
  async addApplicationBanners({ commit }, requestParams) {
   commit('addApplicationBannerRequest',application_banners);
   return await this.$repositories.application_banners.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addApplicationBannerFailure',  response.data.error);
         }
         else{
           commit('addApplicationBannerSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addApplicationBannerFailure',  e.response.data);
     return e
   });
},
async updateApplicationBanners({ commit }, {formData,id}) {
   commit('updateApplicationBannerRequest',application_banners);
    return await this.$repositories.application_banners.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateApplicationBannerFailure',  'Some Error OCcured');
         }
         else{
           commit('updateApplicationBannerSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateApplicationBannerFailure',  e.response.data);
     return e
   });
},
  async filterApplicationBanners({ commit }, requestParams) {
    return await this.$repositories.application_banners.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterApplicationBannersFailure',  response.error);
          }
          else if(response.application_banners){
            commit('filterApplicationBannersSuccess', response.application_banners);
          }
          return response
        },
        error => {
            commit('fetchApplicationBannersFailure', error);
            return
        }
    );
  },
  async deleteApplicationBanners({ dispatch, commit, state }, {filterData,application_banner_id}) {
     return await this.$repositories.application_banners.delete(filterData,application_banner_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteApplicationBannerFailure',  state.message);
           }
           else if(response.application_banners){
             commit('deleteApplicationBannerSuccess', response.application_banners);
           }
           return response
         },
     );
     error => {
          commit('deleteApplicationBannerFailure',  state.message);
         return
     }
  },

  async updateApplicationBannerStatus({ commit }, {filterData,application_banner_id}) {
  return await this.$repositories.application_banners.updateStatus(filterData,application_banner_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateApplicationBannerStatusFailure',  response.message);
        }
        else if(response.application_banners){
          commit('updateApplicationBannerStatusSuccess', response.application_banners);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchApplicationBanners(state, application_banners) {
      state.status = { fetching: true };
      state.application_banners = application_banners;
  },
  fetchApplicationBannersSuccess(state, application_banners) {
      state.status = { fetched: true };
      state.application_banners = application_banners;
  },
  fetchApplicationBannersFailure(state) {
      state.status = {};
      state.application_banners = null;
  },
  addApplicationBannerRequest(state, images) {
    state.status = { adding: true };
},
addApplicationBannerSuccess(state) {
  // state.application_banners = application_banners;
  state.status = { added: true };
},
addApplicationBannerFailure(state) {
    state.status = {};
},
updateApplicationBannerRequest(state, application_banners) {
    state.status = { updating: true };
},
updateApplicationBannerSuccess(state) {
  state.status = { updated: true };
},
updateApplicationBannerFailure(state) {
    state.status = {};
},
  deleteApplicationBannerRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteApplicationBannerSuccess(state, application_banners) {
    state.application_banners = application_banners;
    state.status = { deleted: true };
  },
  deleteApplicationBannerFailure(state) {
      state.status = {deleted: false};
  },
  filterApplicationBannersSuccess(state, application_banners) {
      state.status = { filtered: true };
      state.application_banners = application_banners;
  },
  filterApplicationBannersFailure(state) {
      state.status = {};
  },
  updateApplicationBannerStatusSuccess(state, application_banners) {
      state.status = { fetched: true };
      state.application_banners = application_banners;
  },
  updateApplicationBannerStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
