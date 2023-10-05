
const slider_images = [];
const state = () => ({
  slider_images: slider_images ? slider_images : null ,
  status: slider_images ?
     { fetched: true }:{}
})
const getters = {
  allSliderImages: state => state.slider_images,
}

const actions = {
   async fetchSliderImages({ commit }) {
     commit('fetchSliderImages',slider_images);
     return await this.$repositories.slider_images.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchSliderImagesFailure',  response.error);
           }
           else if(response.slider_images){
             commit('fetchSliderImagesSuccess', response.slider_images);
           }
           return response
         },
         error => {
             commit('fetchSliderImagesFailure', error);
         }
     );
  },
  async addSliderImages({ commit }, requestParams) {
   commit('addSliderImageRequest',slider_images);
   return await this.$repositories.slider_images.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addSliderImageFailure',  response.data.error);
         }
         else{
           commit('addSliderImageSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addSliderImageFailure',  e.response.data);
     return e
   });
},
async updateSliderImages({ commit }, {formData,id}) {
   commit('updateSliderImageRequest',slider_images);
    return await this.$repositories.slider_images.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateSliderImageFailure',  'Some Error OCcured');
         }
         else{
           commit('updateSliderImageSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateSliderImageFailure',  e.response.data);
     return e
   });
},
  async filterSliderImages({ commit }, requestParams) {
    return await this.$repositories.slider_images.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterSliderImagesFailure',  response.error);
          }
          else if(response.slider_images){
            commit('filterSliderImagesSuccess', response.slider_images);
          }
          return response
        },
        error => {
            commit('fetchSliderImagesFailure', error);
            return
        }
    );
  },
  async deleteSliderImages({ dispatch, commit, state }, {filterData,slider_image_id}) {
     return await this.$repositories.slider_images.delete(filterData,slider_image_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteSliderImageFailure',  state.message);
           }
           else if(response.slider_images){
             commit('deleteSliderImageSuccess', response.slider_images);
           }
           return response
         },
     );
     error => {
          commit('deleteSliderImageFailure',  state.message);
         return
     }
  },

  async updateSliderImageStatus({ commit }, {filterData,slider_image_id}) {
  return await this.$repositories.slider_images.updateStatus(filterData,slider_image_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateSliderImageStatusFailure',  response.message);
        }
        else if(response.slider_images){
          commit('updateSliderImageStatusSuccess', response.slider_images);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchSliderImages(state, slider_images) {
      state.status = { fetching: true };
      state.slider_images = slider_images;
  },
  fetchSliderImagesSuccess(state, slider_images) {
      state.status = { fetched: true };
      state.slider_images = slider_images;
  },
  fetchSliderImagesFailure(state) {
      state.status = {};
      state.slider_images = null;
  },
  addSliderImageRequest(state, images) {
    state.status = { adding: true };
},
addSliderImageSuccess(state) {
  // state.slider_images = slider_images;
  state.status = { added: true };
},
addSliderImageFailure(state) {
    state.status = {};
},
updateSliderImageRequest(state, slider_images) {
    state.status = { updating: true };
},
updateSliderImageSuccess(state) {
  state.status = { updated: true };
},
updateSliderImageFailure(state) {
    state.status = {};
},
  deleteSliderImageRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteSliderImageSuccess(state, slider_images) {
    state.slider_images = slider_images;
    state.status = { deleted: true };
  },
  deleteSliderImageFailure(state) {
      state.status = {deleted: false};
  },
  filterSliderImagesSuccess(state, slider_images) {
      state.status = { filtered: true };
      state.slider_images = slider_images;
  },
  filterSliderImagesFailure(state) {
      state.status = {};
  },
  updateSliderImageStatusSuccess(state, slider_images) {
      state.status = { fetched: true };
      state.slider_images = slider_images;
  },
  updateSliderImageStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
