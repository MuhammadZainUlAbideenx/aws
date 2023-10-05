
const application_slider_images = [];
const state = () => ({
  application_slider_images: application_slider_images ? application_slider_images : null ,
  status: application_slider_images ?
     { fetched: true }:{}
})
const getters = {
  allApplicationSliderImages: state => state.application_slider_images,
}

const actions = {
   async fetchApplicationSliderImages({ commit }) {
     commit('fetchApplicationSliderImages',application_slider_images);
     return await this.$repositories.application_slider_images.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchApplicationSliderImagesFailure',  response.error);
           }
           else if(response.application_slider_images){
             commit('fetchApplicationSliderImagesSuccess', response.application_slider_images);
           }
           return response
         },
         error => {
             commit('fetchApplicationSliderImagesFailure', error);
         }
     );
  },
  async addApplicationSliderImages({ commit }, requestParams) {
   commit('addApplicationSliderImageRequest',application_slider_images);
   return await this.$repositories.application_slider_images.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addApplicationSliderImageFailure',  response.data.error);
         }
         else{
           commit('addApplicationSliderImageSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addApplicationSliderImageFailure',  e.response.data);
     return e
   });
},
async updateApplicationSliderImages({ commit }, {formData,id}) {
   commit('updateApplicationSliderImageRequest',application_slider_images);
    return await this.$repositories.application_slider_images.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateApplicationSliderImageFailure',  'Some Error OCcured');
         }
         else{
           commit('updateApplicationSliderImageSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateApplicationSliderImageFailure',  e.response.data);
     return e
   });
},
  async filterApplicationSliderImages({ commit }, requestParams) {
    return await this.$repositories.application_slider_images.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterApplicationSliderImagesFailure',  response.error);
          }
          else if(response.application_slider_images){
            commit('filterApplicationSliderImagesSuccess', response.application_slider_images);
          }
          return response
        },
        error => {
            commit('fetchApplicationSliderImagesFailure', error);
            return
        }
    );
  },
  async deleteApplicationSliderImages({ dispatch, commit, state }, {filterData,application_slider_image_id}) {
     return await this.$repositories.application_slider_images.delete(filterData,application_slider_image_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteApplicationSliderImageFailure',  state.message);
           }
           else if(response.application_slider_images){
             commit('deleteApplicationSliderImageSuccess', response.application_slider_images);
           }
           return response
         },
     );
     error => {
          commit('deleteApplicationSliderImageFailure',  state.message);
         return
     }
  },

  async updateApplicationSliderImageStatus({ commit }, {filterData,application_slider_image_id}) {
  return await this.$repositories.application_slider_images.updateStatus(filterData,application_slider_image_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateApplicationSliderImageStatusFailure',  response.message);
        }
        else if(response.application_slider_images){
          commit('updateApplicationSliderImageStatusSuccess', response.application_slider_images);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchApplicationSliderImages(state, application_slider_images) {
      state.status = { fetching: true };
      state.application_slider_images = application_slider_images;
  },
  fetchApplicationSliderImagesSuccess(state, application_slider_images) {
      state.status = { fetched: true };
      state.application_slider_images = application_slider_images;
  },
  fetchApplicationSliderImagesFailure(state) {
      state.status = {};
      state.application_slider_images = null;
  },
  addApplicationSliderImageRequest(state, images) {
    state.status = { adding: true };
},
addApplicationSliderImageSuccess(state) {
  // state.application_slider_images = application_slider_images;
  state.status = { added: true };
},
addApplicationSliderImageFailure(state) {
    state.status = {};
},
updateApplicationSliderImageRequest(state, application_slider_images) {
    state.status = { updating: true };
},
updateApplicationSliderImageSuccess(state) {
  state.status = { updated: true };
},
updateApplicationSliderImageFailure(state) {
    state.status = {};
},
  deleteApplicationSliderImageRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteApplicationSliderImageSuccess(state, application_slider_images) {
    state.application_slider_images = application_slider_images;
    state.status = { deleted: true };
  },
  deleteApplicationSliderImageFailure(state) {
      state.status = {deleted: false};
  },
  filterApplicationSliderImagesSuccess(state, application_slider_images) {
      state.status = { filtered: true };
      state.application_slider_images = application_slider_images;
  },
  filterApplicationSliderImagesFailure(state) {
      state.status = {};
  },
  updateApplicationSliderImageStatusSuccess(state, application_slider_images) {
      state.status = { fetched: true };
      state.application_slider_images = application_slider_images;
  },
  updateApplicationSliderImageStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
