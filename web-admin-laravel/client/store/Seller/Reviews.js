
const reviews = [];
const state = () => ({
  reviews: reviews ? reviews : null ,
  status: reviews ?
     { fetched: true }:{}
})
const getters = {
  allReviews: state => state.reviews,
}

const actions = {
   async fetchReviews({ commit }) {
     commit('fetchReviews',reviews);
     return await this.$sellerRepositories.reviews.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchReviewsFailure',  response.error);
           }
           else if(response.reviews){
             commit('fetchReviewsSuccess', response.reviews);
           }
           return response
         },
         error => {
             commit('fetchReviewsFailure', error);
         }
     );
  },
  async addReviews({ commit }, requestParams) {
   commit('addReviewRequest',reviews);
   return await this.$sellerRepositories.reviews.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addReviewFailure',  response.data.error);
         }
         else{
           commit('addReviewSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addReviewFailure',  e.response.data);
     return e
   });
},
async updateReviews({ commit }, {formData,id}) {
   commit('updateReviewRequest',reviews);
    return await this.$sellerRepositories.reviews.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateReviewFailure',  'Some Error OCcured');
         }
         else{
           commit('updateReviewSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateReviewFailure',  e.response.data);
     return e
   });
},
  async filterReviews({ commit }, requestParams) {
    return await this.$sellerRepositories.reviews.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterReviewsFailure',  response.error);
          }
          else if(response.reviews){
            commit('filterReviewsSuccess', response.reviews);
          }
          return response
        },
        error => {
            commit('fetchReviewsFailure', error);
            return
        }
    );
  },
  async deleteReviews({ dispatch, commit, state }, {filterData,review_id}) {
     return await this.$sellerRepositories.reviews.delete(filterData,review_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteReviewFailure',  state.message);
           }
           else if(response.reviews){
             commit('deleteReviewSuccess', response.reviews);
           }
           return response
         },
     );
     error => {
          commit('deleteReviewFailure',  state.message);
         return
     }
  },

  async updateReviewStatus({ commit }, {filterData,review_id}) {
  return await this.$sellerRepositories.reviews.updateStatus(filterData,review_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateReviewStatusFailure',  response.message);
        }
        else if(response.reviews){
          commit('updateReviewStatusSuccess', response.reviews);
        }
        return response

      },
    );
  },
  async updateReviewIsDefault({ commit }, {filterData,review_id}) {
  return await this.$sellerRepositories.reviews.updateIsDefault(filterData,review_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateReviewIsDefaultFailure',  response.error);
        }
        else if(response.reviews){
          commit('updateReviewIsDefaultSuccess', response.reviews);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchReviews(state, reviews) {
      state.status = { fetching: true };
      state.reviews = reviews;
  },
  fetchReviewsSuccess(state, reviews) {
      state.status = { fetched: true };
      state.reviews = reviews;
  },
  fetchReviewsFailure(state) {
      state.status = {};
      state.reviews = null;
  },
  addReviewRequest(state, images) {
    state.status = { adding: true };
},
addReviewSuccess(state) {
  // state.reviews = reviews;
  state.status = { added: true };
},
addReviewFailure(state) {
    state.status = {};
},
updateReviewRequest(state, reviews) {
    state.status = { updating: true };
},
updateReviewSuccess(state) {
  state.status = { updated: true };
},
updateReviewFailure(state) {
    state.status = {};
},
  deleteReviewRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteReviewSuccess(state, reviews) {
    state.reviews = reviews;
    state.status = { deleted: true };
  },
  deleteReviewFailure(state) {
      state.status = {deleted: false};
  },
  filterReviewsSuccess(state, reviews) {
      state.status = { filtered: true };
      state.reviews = reviews;
  },
  filterReviewsFailure(state) {
      state.status = {};
  },
  updateReviewStatusSuccess(state, reviews) {
      state.status = { fetched: true };
      state.reviews = reviews;
  },
  updateReviewStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateReviewIsDefaultSuccess(state, reviews) {
      state.status = { fetched: true };
      state.reviews = reviews;
  },
  updateReviewIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
