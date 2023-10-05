
const wishlist_items = null;

const state = () => ({
  wishlist_items: wishlist_items ? wishlist_items : null ,
})
const getters = {
  allWishlistItems: state => state.wishlist_items,
}

const actions = {
async fetchWishlistItems({ commit },requestParams) {
  return await this.$webService.fetchWishlistItems(requestParams)
  .then(
      response => {
        if(response.status)
        {
          commit('fetchWishlistItemsFailure',  response.error);
        }
        else if(response.data){
          commit('fetchWishlistItemsSuccess', response.data);
        }
        return response
      },
      error => {
          commit('fetchWishlistItemsFailure', error);
      }
  );
},
async wishlistItemsOnLogout({ commit }) {
  commit('wishlistItemsOnLogout',  '');
},
};

const mutations = {
  fetchWishlistItemsSuccess(state, wishlist_items) {
      state.wishlist_items = wishlist_items;
  },
  fetchWishlistItemsFailure(state) {
      state.wishlist_items = null;
  },
  wishlistItemsOnLogout(state) {
      state.wishlist_items = null;
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
