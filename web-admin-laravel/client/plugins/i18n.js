export default function ({ app }) {
  // beforeLanguageSwitch called right before setting a new locale
  app.i18n.onLanguageSwitched = (oldLocale, newLocale) => {
    // app.$cookies.set('language', newLocale)
    // app.$cookies.set('i18n_redirected', newLocale)
  }


}
