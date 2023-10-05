
const categories = [];
const state = () => ({
  categories: categories ? categories : null ,
  status: categories ?
     { fetched: true }:{}
})
const getters = {
  allCategories: state => state.categories,
}

const actions = {
   async fetchCategories({ commit }) {
     commit('fetchCategories',categories);
     return await this.$repositories.categories.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchCategoriesFailure',  response.error);
           }
           else if(response.categories){
             commit('fetchCategoriesSuccess', response.categories);
           }
           return response
         },
         error => {
             commit('fetchCategoriesFailure', error);
         }
     );
  },
  async addCategories({ commit }, requestParams) {
   commit('addCategoryRequest',categories);
   return await this.$repositories.categories.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addCategoryFailure',  response.data.error);
         }
         else{
           commit('addCategorySuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addCategoryFailure',  e.response.data);
     return e
   });
},
async updateCategories({ commit }, {formData,id}) {
   commit('updateCategoryRequest',categories);
    return await this.$repositories.categories.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateCategoryFailure',  'Some Error OCcured');
         }
         else{
           commit('updateCategorySuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateCategoryFailure',  e.response.data);
     return e
   });
},
  async filterCategories({ commit }, requestParams) {
    return await this.$repositories.categories.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterCategoriesFailure',  response.error);
          }
          else if(response.categories){
            commit('filterCategoriesSuccess', response.categories);
          }
          return response
        },
        error => {
            commit('fetchCategoriesFailure', error);
            return
        }
    );
  },
  async deleteCategories({ dispatch, commit, state }, {filterData,category_id}) {
     return await this.$repositories.categories.delete(filterData,category_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteCategoryFailure',  state.message);
           }
           else if(response.categories){
             commit('deleteCategorySuccess', response.categories);
           }
           return response
         },
     );
     error => {
          commit('deleteCategoryFailure',  state.message);
         return
     }
  },

  async updateCategoryStatus({ commit }, {filterData,category_id}) {
  return await this.$repositories.categories.updateStatus(filterData,category_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCategoryStatusFailure',  response.message);
        }
        else if(response.categories){
          commit('updateCategoryStatusSuccess', response.categories);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchCategories(state, categories) {
      state.status = { fetching: true };
      state.categories = categories;
  },
  fetchCategoriesSuccess(state, categories) {
      state.status = { fetched: true };
      state.categories = categories;
  },
  fetchCategoriesFailure(state) {
      state.status = {};
      state.categories = null;
  },
  addCategoryRequest(state, images) {
    state.status = { adding: true };
},
addCategorySuccess(state) {
  // state.categories = categories;
  state.status = { added: true };
},
addCategoryFailure(state) {
    state.status = {};
},
updateCategoryRequest(state, categories) {
    state.status = { updating: true };
},
updateCategorySuccess(state) {
  state.status = { updated: true };
},
updateCategoryFailure(state) {
    state.status = {};
},
  deleteCategoryRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteCategorySuccess(state, categories) {
    state.categories = categories;
    state.status = { deleted: true };
  },
  deleteCategoryFailure(state) {
      state.status = {deleted: false};
  },
  filterCategoriesSuccess(state, categories) {
      state.status = { filtered: true };
      state.categories = categories;
  },
  filterCategoriesFailure(state) {
      state.status = {};
  },
  updateCategoryStatusSuccess(state, categories) {
      state.status = { fetched: true };
      state.categories = categories;
  },
  updateCategoryStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
