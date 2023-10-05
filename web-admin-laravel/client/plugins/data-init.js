export default async ({ app , commit }) => {
  if(!app.store.state.default_settings){
    await app.store.dispatch('fetchDefaultSettings')
  }
  if(!app.store.state.Web.General.languages){
    await app.store.dispatch('Web/General/fetchLanguages')
  }
  if(!app.store.state.Web.General.currencies){
    await app.store.dispatch('Web/General/fetchCurrencies')
  }
  if(!app.$cookies.get('session_token')){
    const characters ='ABCDEFGHIJKLMNklmnopqrstuvwxyz0123456789';
    let result = '';
    const charactersLength = characters.length;
    for ( let i = 0; i < 64; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    app.$cookies.set('session_token',result)
  }
  // if(!app.store.state.Web.Cart.cart_items){
  //   await app.store.dispatch('Web/Cart/fetchCartItems')
  // }
}
