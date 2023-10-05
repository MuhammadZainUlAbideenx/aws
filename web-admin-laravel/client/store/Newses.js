
const newses = [];
const state = () => ({
  newses: newses ? newses : null ,
  status: newses ?
     { fetched: true }:{}
})
const getters = {
  allNewses: state => state.newses,
}

const actions = {
   async fetchNewses({ commit }) {
     commit('fetchNewses',newses);
     return await this.$repositories.news.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchNewsesFailure',  response.error);
           }
           else if(response.newses){
             commit('fetchNewsesSuccess', response.newses);
           }
           return response
         },
         error => {
             commit('fetchNewsesFailure', error);
         }
     );
  },
  async addNewses({ commit }, requestParams) {
   commit('addNewsRequest',newses);
   return await this.$repositories.news.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addNewsFailure',  response.data.error);
         }
         else{
           commit('addNewsSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addNewsFailure',  e.response.data);
     return e
   });
},
async updateNewses({ commit }, {formData,id}) {
   commit('updateNewsRequest',newses);
    return await this.$repositories.news.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateNewsFailure',  'Some Error OCcured');
         }
         else{
           commit('updateNewsSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateNewsFailure',  e.response.data);
     return e
   });
},
  async filterNewses({ commit }, requestParams) {
    return await this.$repositories.news.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterNewsesFailure',  response.error);
          }
          else if(response.newses){
            commit('filterNewsesSuccess', response.newses);
          }
          return response
        },
        error => {
            commit('fetchNewsesFailure', error);
            return
        }
    );
  },
  async deleteNewses({ dispatch, commit, state }, {filterData,news_id}) {
     return await this.$repositories.news.delete(filterData,news_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteNewsFailure',  state.message);
           }
           else if(response.newses){
             commit('deleteNewsSuccess', response.newses);
           }
           return response
         },
     );
     error => {
          commit('deleteNewsFailure',  state.message);
         return
     }
  },

  async updateNewsStatus({ commit }, {filterData,news_id}) {
  return await this.$repositories.news.updateStatus(filterData,news_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateNewsStatusFailure',  response.message);
        }
        else if(response.newses){
          commit('updateNewsStatusSuccess', response.newses);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchNewses(state, newses) {
      state.status = { fetching: true };
      state.newses = newses;
  },
  fetchNewsesSuccess(state, newses) {
      state.status = { fetched: true };
      state.newses = newses;
  },
  fetchNewsesFailure(state) {
      state.status = {};
      state.newses = null;
  },
  addNewsRequest(state, images) {
    state.status = { adding: true };
},
addNewsSuccess(state) {
  // state.newses = newses;
  state.status = { added: true };
},
addNewsFailure(state) {
    state.status = {};
},
updateNewsRequest(state, newses) {
    state.status = { updating: true };
},
updateNewsSuccess(state) {
  state.status = { updated: true };
},
updateNewsFailure(state) {
    state.status = {};
},
  deleteNewsRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteNewsSuccess(state, newses) {
    state.newses = newses;
    state.status = { deleted: true };
  },
  deleteNewsFailure(state) {
      state.status = {deleted: false};
  },
  filterNewsesSuccess(state, newses) {
      state.status = { filtered: true };
      state.newses = newses;
  },
  filterNewsesFailure(state) {
      state.status = {};
  },
  updateNewsStatusSuccess(state, newses) {
      state.status = { fetched: true };
      state.newses = newses;
  },
  updateNewsStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
