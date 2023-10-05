
const products = [];
const productsFilterData = [];

const state = () => ({
  products: products ? products : null ,
  status: products ?
     { fetched: true }:{}
})
const getters = {
  allProducts: state => state.products,
}

const actions = {
   async fetchProducts({ commit }) {
     commit('fetchProducts',products);
     return await this.$sellerRepositories.products.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchProductsFailure',  response.error);
           }
           else if(response.products){
             commit('fetchProductsSuccess', response.products);
           }
           return response
         },
         error => {
             commit('fetchProductsFailure', error);
         }
     );
  },
  async addProducts({ commit }, requestParams) {
   commit('addProductRequest',products);
   return await this.$sellerRepositories.products.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addProductFailure',  response.data.error);
         }
         else{
           commit('addProductSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addProductFailure',  e.response.data);
     return e
   });
},
async updateProducts({ commit }, {formData,id}) {
   commit('updateProductRequest',products);
    return await this.$sellerRepositories.products.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateProductFailure',  'Some Error OCcured');
         }
         else{
           commit('updateProductSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateProductFailure',  e.response.data);
     return e
   });
},
async addProductAttribute({ commit }, {formData,id}) {
   commit('addProductAttributeRequest',products);
    return await this.$sellerRepositories.products.addAttribute(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addProductAttributeFailure',  'Some Error OCcured');
         }
         else{
           commit('addProductAttributeSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('addProductAttributeFailure',  e.response.data);
     return e
   });
},
async updateProductAttribute({ commit }, {formData,id}) {
   commit('updateProductAttributesRequest',products);
    return await this.$sellerRepositories.products.updateAttribute(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateProductAttributeFailure',  'Some Error OCcured');
         }
         else{
           commit('updateProductAttributeSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateProductAttributeFailure',  e.response.data);
     return e
   });
},
async updateProductMedia({ commit }, {formData,id}) {
   commit('updateProductMediaRequest',products);
    return await this.$sellerRepositories.products.updateMedia(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateProductMediaFailure',  'Some Error OCcured');
         }
         else{
           commit('updateProductMediaSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateProductFailure',  e.response.data);
     return e
   });
},
  async filterProducts({ commit }, requestParams) {
    return await this.$sellerRepositories.products.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterProductsFailure',  response.error);
          }
          else if(response.products){
            commit('filterProductsSuccess', response.products);
          }
          return response
        },
        error => {
            commit('fetchProductsFailure', error);
            return
        }
    );
  },
  async deleteProducts({ dispatch, commit, state }, {filterData,product_id}) {
     return await this.$sellerRepositories.products.delete(filterData,product_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteProductFailure',  state.message);
           }
           else if(response.products){
             commit('deleteProductSuccess', response.products);
           }
           return response
         },
     );
     error => {
          commit('deleteProductFailure',  state.message);
         return
     }
  },

  async updateProductStatus({ commit }, {filterData,product_id}) {
  return await this.$sellerRepositories.products.updateStatus(filterData,product_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateProductStatusFailure',  response.message);
        }
        else if(response.products){
          commit('updateProductStatusSuccess', response.products);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchProducts(state, products) {
      state.status = { fetching: true };
      state.products = products;
  },
  fetchProductsSuccess(state, products) {
      state.status = { fetched: true };
      state.products = products;
  },
  fetchProductsFailure(state) {
      state.status = {};
      state.products = null;
  },
  addProductRequest(state, images) {
    state.status = { adding: true };
},
addProductSuccess(state) {
  // state.products = products;
  state.status = { added: true };
},
addProductFailure(state) {
    state.status = {};
},
updateProductRequest(state, products) {
    state.status = { updating: true };
},
updateProductSuccess(state) {
  state.status = { updated: true };
},
updateProductFailure(state) {
    state.status = {};
},
updateProductMediaRequest(state, products) {
    state.status = { updating: true };
},
updateProductMediaSuccess(state) {
  state.status = { updated: true };
},
updateProductMediaFailure(state) {
    state.status = {};
},
addProductAttributeRequest(state, products) {
    state.status = { updating: true };
},
addProductAttributeSuccess(state) {
  state.status = { updated: true };
},
updateProductAttributeRequest(state, products) {
    state.status = { updating: true };
},
updateProductAttributeSuccess(state) {
  state.status = { updated: true };
},
updateProductAttributesFailure(state) {
    state.status = {};
},
  deleteProductRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteProductSuccess(state, products) {
    state.products = products;
    state.status = { deleted: true };
  },
  deleteProductFailure(state) {
      state.status = {deleted: false};
  },
  filterProductsSuccess(state, products) {
      state.status = { filtered: true };
      state.products = products;
  },
  filterProductsFailure(state) {
      state.status = {};
  },
  updateProductStatusSuccess(state, products) {
      state.status = { fetched: true };
      state.products = products;
  },
  updateProductStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
