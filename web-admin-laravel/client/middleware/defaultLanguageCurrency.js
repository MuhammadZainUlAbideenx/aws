export default async ({ app,$auth,$gates,$axios, store,redirect }) => {
  // const default_language = app.store.state.default_settings.language
  // if(!app.$cookies.get('language') && default_language){
  //   const check = app.i18n.locales.find((i) => i.code == default_language.code)
  //   if(check){
  //     app.$cookies.set('language',default_language.code)
  //     app.$cookies.set('i18n_redirected',default_language.code)
  //     app.i18n.setLocale(default_language.code)
  //   }
  // }
  const default_currency = app.store.state.default_settings.currency
  if(!app.$cookies.get('currency') && default_currency){
    app.$cookies.set('currency',default_currency.code)
  }
  else if(!app.$cookies.get('currency') && !default_currency){
    app.$cookies.set('currency','usd')
  }
}
