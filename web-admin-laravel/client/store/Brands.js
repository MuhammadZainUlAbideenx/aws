
const brands = [];
const state = () => ({
  brands: brands ? brands : null ,
  status: brands ?
     { fetched: true }:{}
})
const getters = {
  allBrands: state => state.brands,
}

const actions = {
   async fetchBrands({ commit }) {
     commit('fetchBrands',brands);
     return await this.$repositories.brands.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchBrandsFailure',  response.error);
           }
           else if(response.brands){
             commit('fetchBrandsSuccess', response.brands);
           }
           return response
         },
         error => {
             commit('fetchBrandsFailure', error);
         }
     );
  },
  async addBrands({ commit }, requestParams) {
   commit('addBrandRequest',brands);
   return await this.$repositories.brands.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addBrandFailure',  response.data.error);
         }
         else{
           commit('addBrandSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addBrandFailure',  e.response.data);
     return e
   });
},
async updateBrands({ commit }, {formData,id}) {
   commit('updateBrandRequest',brands);
    return await this.$repositories.brands.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateBrandFailure',  'Some Error OCcured');
         }
         else{
           commit('updateBrandSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateBrandFailure',  e.response.data);
     return e
   });
},
  async filterBrands({ commit }, requestParams) {
    return await this.$repositories.brands.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterBrandsFailure',  response.error);
          }
          else if(response.brands){
            commit('filterBrandsSuccess', response.brands);
          }
          return response
        },
        error => {
            commit('fetchBrandsFailure', error);
            return
        }
    );
  },
  async deleteBrands({ dispatch, commit, state }, {filterData,brand_id}) {
     return await this.$repositories.brands.delete(filterData,brand_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteBrandFailure',  state.message);
           }
           else if(response.brands){
             commit('deleteBrandSuccess', response.brands);
           }
           return response
         },
     );
     error => {
          commit('deleteBrandFailure',  state.message);
         return
     }
  },

  async updateBrandStatus({ commit }, {filterData,brand_id}) {
  return await this.$repositories.brands.updateStatus(filterData,brand_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateBrandStatusFailure',  response.message);
        }
        else if(response.brands){
          commit('updateBrandStatusSuccess', response.brands);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchBrands(state, brands) {
      state.status = { fetching: true };
      state.brands = brands;
  },
  fetchBrandsSuccess(state, brands) {
      state.status = { fetched: true };
      state.brands = brands;
  },
  fetchBrandsFailure(state) {
      state.status = {};
      state.brands = null;
  },
  addBrandRequest(state, images) {
    state.status = { adding: true };
},
addBrandSuccess(state) {
  // state.brands = brands;
  state.status = { added: true };
},
addBrandFailure(state) {
    state.status = {};
},
updateBrandRequest(state, brands) {
    state.status = { updating: true };
},
updateBrandSuccess(state) {
  state.status = { updated: true };
},
updateBrandFailure(state) {
    state.status = {};
},
  deleteBrandRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteBrandSuccess(state, brands) {
    state.brands = brands;
    state.status = { deleted: true };
  },
  deleteBrandFailure(state) {
      state.status = {deleted: false};
  },
  filterBrandsSuccess(state, brands) {
      state.status = { filtered: true };
      state.brands = brands;
  },
  filterBrandsFailure(state) {
      state.status = {};
  },
  updateBrandStatusSuccess(state, brands) {
      state.status = { fetched: true };
      state.brands = brands;
  },
  updateBrandStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
