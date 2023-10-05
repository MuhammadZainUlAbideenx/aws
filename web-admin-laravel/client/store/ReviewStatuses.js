const review_statuses = [];
const state = () => ({
  review_statuses: review_statuses ? review_statuses : null ,
  status: review_statuses ?
     { fetched: true }:{}
})
const getters = {
  allReviewStatuses: state => state.review_statuses,
}

const actions = {
   async fetchReviewStatuses({ commit }) {
     commit('fetchReviewStatuses',review_statuses);
     return await this.$repositories.review_statuses.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchReviewStatusesFailure',  response.error);
           }
           else if(response.review_statuses){
             commit('fetchReviewStatusesSuccess', response.review_statuses);
           }
           return response
         },
         error => {
             commit('fetchReviewStatusesFailure', error);
         }
     );
  },
  async addReviewStatuses({ commit }, requestParams) {
   commit('addReviewStatusRequest',review_statuses);
   return await this.$repositories.review_statuses.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addReviewStatusFailure',  response.data.error);
         }
         else{
           commit('addReviewStatusSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addReviewStatusFailure',  e.response.data);
     return e
   });
},
async updateReviewStatuses({ commit }, {formData,id}) {
   commit('updateReviewStatusRequest',review_statuses);
    return await this.$repositories.review_statuses.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateReviewStatusFailure',  'Some Error OCcured');
         }
         else{
           commit('updateReviewStatusSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateReviewStatusFailure',  e.response.data);
     return e
   });
},
  async filterReviewStatuses({ commit }, requestParams) {
    return await this.$repositories.review_statuses.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterReviewStatusesFailure',  response.error);
          }
          else if(response.review_statuses){
            commit('filterReviewStatusesSuccess', response.review_statuses);
          }
          return response
        },
        error => {
            commit('fetchReviewStatusesFailure', error);
            return
        }
    );
  },
  async deleteReviewStatuses({ dispatch, commit, state }, {filterData,review_status_id}) {
     return await this.$repositories.review_statuses.delete(filterData,review_status_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteReviewStatusFailure',  state.message);
           }
           else if(response.review_statuses){
             commit('deleteReviewStatusSuccess', response.review_statuses);
           }
           return response
         },
     );
     error => {
          commit('deleteReviewStatusFailure',  state.message);
         return
     }
  },

  async updateReviewStatusStatus({ commit }, {filterData,review_status_id}) {
  return await this.$repositories.review_statuses.updateStatus(filterData,review_status_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateReviewStatusStatusFailure',  response.message);
        }
        else if(response.review_statuses){
          commit('updateReviewStatusStatusSuccess', response.review_statuses);
        }
        return response

      },
    );
  },
  async updateReviewStatusIsDefault({ commit }, {filterData,review_status_id}) {
  return await this.$repositories.review_statuses.updateIsDefault(filterData,review_status_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateReviewStatusIsDefaultFailure',  response.error);
        }
        else if(response.review_statuses){
          commit('updateReviewStatusIsDefaultSuccess', response.review_statuses);
        }
        return response
      },
    );
  },


};

const mutations = {
  fetchReviewStatuses(state, review_statuses) {
      state.status = { fetching: true };
      state.review_statuses = review_statuses;
  },
  fetchReviewStatusesSuccess(state, review_statuses) {
      state.status = { fetched: true };
      state.review_statuses = review_statuses;
  },
  fetchReviewStatusesFailure(state) {
      state.status = {};
      state.review_statuses = null;
  },
  addReviewStatusRequest(state, images) {
    state.status = { adding: true };
},
addReviewStatusSuccess(state) {
  // state.review_statuses = review_statuses;
  state.status = { added: true };
},
addReviewStatusFailure(state) {
    state.status = {};
},
updateReviewStatusRequest(state, review_statuses) {
    state.status = { updating: true };
},
updateReviewStatusSuccess(state) {
  state.status = { updated: true };
},
updateReviewStatusFailure(state) {
    state.status = {};
},
  deleteReviewStatusRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteReviewStatusSuccess(state, review_statuses) {
    state.review_statuses = review_statuses;
    state.status = { deleted: true };
  },
  deleteReviewStatusFailure(state) {
      state.status = {deleted: false};
  },
  filterReviewStatusesSuccess(state, review_statuses) {
      state.status = { filtered: true };
      state.review_statuses = review_statuses;
  },
  filterReviewStatusesFailure(state) {
      state.status = {};
  },
  updateReviewStatusStatusSuccess(state, review_statuses) {
      state.status = { fetched: true };
      state.review_statuses = review_statuses;
  },
  updateReviewStatusStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateReviewStatusIsDefaultSuccess(state,review_statuses) {
    state.status = { update_status: false};
    state.review_statuses = review_statuses;
  },
  updateReviewStatusIsDefaultFailure(state) {
      state.status = { fetched: true };
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
