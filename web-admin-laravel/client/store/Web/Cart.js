
const cart_items = null;

const state = () => ({
  cart_items: cart_items ? cart_items : null ,
})
const getters = {
  allCartItems: state => state.cart_items,
}

const actions = {
async fetchCartItems({ commit }) {
  return await this.$webService.fetchCartItems()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchCartItemsFailure',  response.error);
        }
        else if(response.data){
          commit('fetchCartItemsSuccess', response.data);
        }
        return response
      },
      error => {
          commit('fetchCartItemsFailure', error);
      }
  );
},
};

const mutations = {
  fetchCartItemsSuccess(state, cart_items) {
    state.cart_items = cart_items;
  },
  fetchCartItemsFailure(state) {
      state.cart_items = null;
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
