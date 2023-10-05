
const news_categories = [];
const state = () => ({
  news_categories: news_categories ? news_categories : null ,
  status: news_categories ?
     { fetched: true }:{}
})
const getters = {
  allNewsCategories: state => state.news_categories,
}

const actions = {
   async fetchNewsCategories({ commit }) {
     commit('fetchNewsCategories',news_categories);
     return await this.$repositories.news_categories.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchNewsCategoriesFailure',  response.error);
           }
           else if(response.news_categories){
             commit('fetchNewsCategoriesSuccess', response.news_categories);
           }
           return response
         },
         error => {
             commit('fetchNewsCategoriesFailure', error);
         }
     );
  },
  async addNewsCategories({ commit }, requestParams) {
   commit('addNewsCategoryRequest',news_categories);
   return await this.$repositories.news_categories.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addNewsCategoryFailure',  response.data.error);
         }
         else{
           commit('addNewsCategorySuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addNewsCategoryFailure',  e.response.data);
     return e
   });
},
async updateNewsCategories({ commit }, {formData,id}) {
   commit('updateNewsCategoryRequest',news_categories);
    return await this.$repositories.news_categories.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateNewsCategoryFailure',  'Some Error OCcured');
         }
         else{
           commit('updateNewsCategorySuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateNewsCategoryFailure',  e.response.data);
     return e
   });
},
  async filterNewsCategories({ commit }, requestParams) {
    return await this.$repositories.news_categories.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterNewsCategoriesFailure',  response.error);
          }
          else if(response.news_categories){
            commit('filterNewsCategoriesSuccess', response.news_categories);
          }
          return response
        },
        error => {
            commit('fetchNewsCategoriesFailure', error);
            return
        }
    );
  },
  async deleteNewsCategories({ dispatch, commit, state }, {filterData,news_category_id}) {
     return await this.$repositories.news_categories.delete(filterData,news_category_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteNewsCategoryFailure',  state.message);
           }
           else if(response.news_categories){
             commit('deleteNewsCategorySuccess', response.news_categories);
           }
           return response
         },
     );
     error => {
          commit('deleteNewsCategoryFailure',  state.message);
         return
     }
  },

  async updateNewsCategoryStatus({ commit }, {filterData,news_category_id}) {
  return await this.$repositories.news_categories.updateStatus(filterData,news_category_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateNewsCategoryStatusFailure',  response.message);
        }
        else if(response.news_categories){
          commit('updateNewsCategoryStatusSuccess', response.news_categories);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchNewsCategories(state, news_categories) {
      state.status = { fetching: true };
      state.news_categories = news_categories;
  },
  fetchNewsCategoriesSuccess(state, news_categories) {
      state.status = { fetched: true };
      state.news_categories = news_categories;
  },
  fetchNewsCategoriesFailure(state) {
      state.status = {};
      state.news_categories = null;
  },
  addNewsCategoryRequest(state, images) {
    state.status = { adding: true };
},
addNewsCategorySuccess(state) {
  // state.news_categories = news_categories;
  state.status = { added: true };
},
addNewsCategoryFailure(state) {
    state.status = {};
},
updateNewsCategoryRequest(state, news_categories) {
    state.status = { updating: true };
},
updateNewsCategorySuccess(state) {
  state.status = { updated: true };
},
updateNewsCategoryFailure(state) {
    state.status = {};
},
  deleteNewsCategoryRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteNewsCategorySuccess(state, news_categories) {
    state.news_categories = news_categories;
    state.status = { deleted: true };
  },
  deleteNewsCategoryFailure(state) {
      state.status = {deleted: false};
  },
  filterNewsCategoriesSuccess(state, news_categories) {
      state.status = { filtered: true };
      state.news_categories = news_categories;
  },
  filterNewsCategoriesFailure(state) {
      state.status = {};
  },
  updateNewsCategoryStatusSuccess(state, news_categories) {
      state.status = { fetched: true };
      state.news_categories = news_categories;
  },
  updateNewsCategoryStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
