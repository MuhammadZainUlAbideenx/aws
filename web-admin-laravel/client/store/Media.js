const media = '';

const state = () =>({
  media: media ? media:null,
  status: media ?{ fetched: true}: {}
})
const getters = {
  allMedia: state => state.media
};

const actions = {
  async fetchMedia({ dispatch, commit }, requestParams) {
     commit('fetchRequest',media);
     return await this.$media.fetchMedia(requestParams)
     .then(
         response => {
           if(response.state == 'fail' || response.status)
           {
             commit('fetchFailure',  response.error);
           }
           else{
             commit('fetchSuccess', response.media);
             return response.media
           }
         },
         error => {
             commit('deleteFailure', error);
         }
     );
  },
  async filterMedia({ commit }, requestParams) {
    return await this.$media.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterMediaFailure',  response.error);
          }
          else if(response.media){
            commit('filterMediaSuccess', response.media);
            return response.media
          }
          return response
        },
        error => {
            commit('filterMediaFailure', error);
            return
        }
    );
  },
  async deleteMedia({ dispatch, commit }, id) {
     commit('deleteRequest','ghg');
     return await this.$media.deleteMedia(id)
     .then(
         response => {
           if(response.state == 'fail' || response.status)
           {
             commit('deleteFailure',  response.error);
           }
           else{
             commit('deleteSuccess', id);
           }
         },
         error => {
             commit('deleteFailure', error);
         }
     );
  }
};

const mutations = {
  fetchRequest(state, media) {
      state.status = { fetching: true };
      state.media = media;

  },
  fetchSuccess(state, media) {
      state.status = { fetched: true };
      state.media = media;
  },
  fetchFailure(state) {
      state.status = {};
      state.media = null;
  },
    filterMediaSuccess(state, media) {
      state.status = { fetched: true };
      state.media = media;
  },
  filterMediaFailure(state) {
      state.status = {};
      state.media = null;
  },
  deleteRequest(state, media) {
      state.status = { deleting: true };
  },
  deleteSuccess(state, id) {
    state.media = state.media.filter(media => media.id !== id);
    state.status = { deleted: true };
  },
  deleteFailure(state) {
      state.status = {};
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
