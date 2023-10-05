
const activeLanguages = [];
const activeRoles = [];
const activeCategories = [];
const activeSelectCategories = [];
const activeParentChildCategories = [];
const activeParentCategories = [];
const activeInactiveCategories = [];
const activeManufacturers = [];
const activeUnits = [];
const activeTaxClasses = [];
const activeOrderStatuses = [];
const activeMedia = [];
const activeSettings = [];
const activeThemeSettings = [];
const activeVendors = [];
const activePermissions = [];
const activeCurrencies = [];
const activeSliderImages = [];
const activeStaticBanners = [];
const activeParallaxBanners = [];
const activeCountries = [];
const activeZones = [];
const activeCities = [];
const activeStates = [];
const activeTaxRates = [];
const activeProducts = [];
const activeProductsSeller = [];
const activeCoupons = [];
const activeCustomers = [];
const activeCustomersSeller = [];
const activeAdmins = [];
const activeNewses = [];
const activeNewsCategories = [];
const activeLanguageCodes = [];
const activeContentPages = [];
const activeReviews = [];
const activeCurrencyCodes = [];
const activeReviewStatuses = [];
const activeApplicationBanners = [];
const activeApplicationParallaxBanners = [];
const activeApplicationSliderImages = [];
const activeContentApplicationPages = [];
const activeSeoPages = [];
const activeBrands = [];
const activeShippingMethods = [];
const activeAttributes = [];
const activeAttributeValues = [];
const activeOrders = [];
const activePaymentMethods = [];
const activeFaqs = [];
const activeNewsletters = [];
const activeRiders = [];

const state = () => ({
  activeLanguages: activeLanguages ? activeLanguages : null ,
  activeRoles: activeRoles ? activeRoles : null ,
  activeCategories: activeCategories ? activeCategories : null ,
  activeSelectCategories: activeSelectCategories ? activeSelectCategories : null ,
  activeParentChildCategories: activeParentChildCategories ? activeParentChildCategories : null ,
  activeParentCategories: activeParentCategories ? activeParentCategories : null ,
  activeInactiveCategories: activeInactiveCategories ? activeInactiveCategories : null ,
  activeManufacturers: activeManufacturers ? activeManufacturers : null ,
  activeUnits: activeUnits ? activeUnits : null ,
  activeTaxClasses: activeTaxClasses ? activeTaxClasses : null ,
  activeOrderStatuses: activeOrderStatuses ? activeOrderStatuses : null ,
  activeMedia: activeMedia ? activeMedia : null ,
  activeSettings: activeSettings ? activeSettings : null ,
  activeThemeSettings: activeThemeSettings ? activeThemeSettings : null ,
  activeVendors: activeVendors ? activeVendors : null ,
  activePermissions: activePermissions ? activePermissions : null ,
  activeCurrencies: activeCurrencies ? activeCurrencies : null ,
  activeSliderImages: activeSliderImages ? activeSliderImages : null ,
  activeStaticBanners: activeStaticBanners ? activeStaticBanners : null ,
  activeParallaxBanners: activeParallaxBanners ? activeParallaxBanners : null ,
  activeCountries: activeCountries ? activeCountries : null ,
  activeZones: activeZones ? activeZones : null ,
  activeCities: activeCities ? activeCities : null ,
  activeStates: activeStates ? activeStates : null ,
  activeTaxRates: activeTaxRates ? activeTaxRates : null ,
  activeProducts: activeProducts ? activeProducts : null ,
  activeProductsSeller: activeProductsSeller ? activeProductsSeller : null ,
  activeCoupons: activeCoupons ? activeCoupons : null ,
  activeCustomers: activeCustomers ? activeCustomers : null ,
  activeCustomersSeller: activeCustomersSeller ? activeCustomersSeller : null ,
  activeAdmins: activeAdmins ? activeAdmins : null ,
  activeNewses: activeNewses ? activeNewses : null ,
  activeNewsCategories: activeNewsCategories ? activeNewsCategories : null ,
  activeLanguageCodes: activeLanguageCodes ? activeLanguageCodes : null ,
  activeContentPages: activeContentPages ? activeContentPages : null ,
  activeReviews: activeReviews ? activeReviews : null ,
  activeCurrencyCodes: activeCurrencyCodes ? activeCurrencyCodes : null,
  activeReviewStatuses: activeReviewStatuses ? activeReviewStatuses : null ,
  activeApplicationBanners: activeApplicationBanners ? activeApplicationBanners : null ,
  activeApplicationParallaxBanners: activeApplicationParallaxBanners ? activeApplicationParallaxBanners : null ,
  activeApplicationSliderImages: activeApplicationSliderImages ? activeApplicationSliderImages : null ,
  activeContentApplicationPages: activeContentApplicationPages ? activeContentApplicationPages : null ,
  activeSeoPages: activeSeoPages ? activeSeoPages : null ,
  activeBrands: activeBrands ? activeBrands : null ,
  activeShippingMethods: activeShippingMethods ? activeShippingMethods : null ,
  activeAttributes: activeAttributes ? activeAttributes : null ,
  activeAttributeValues: activeAttributeValues ? activeAttributeValues : null ,
  activeOrders: activeOrders ? activeOrders : null ,
  activePaymentMethods: activePaymentMethods ? activePaymentMethods : null ,
  activeFaqs: activeFaqs ? activeFaqs : null ,
  activeNewsletters: activeNewsletters ? activeNewsletters : null ,
  activeRiders: activeRiders ? activeRiders : null ,

})
const getters = {
  allActiveLanguages: state => state.activeLanguages,
  allActiveRoles: state => state.activeRoles,
  allActiveCategories: state => state.activeCategories,
  allSelectActiveCategories: state => state.activeSelectCategories,
  allParentChildActiveCategories: state => state.activeParentChildCategories,
  allParentActiveCategories: state => state.activeParentCategories,
  allActiveInactiveCategories: state => state.activeInactiveCategories,
  allActiveManufacturers: state => state.activeManufacturers,
  allActiveUnits: state => state.activeUnits,
  allActiveTaxClasses: state => state.activeTaxClasses,
  allActiveOrderStatuses: state => state.activeOrderStatuses,
  allActiveMedia: state => state.activeMedia,
  allActiveSettings: state => state.activeSettings,
  allActiveThemeSettings: state => state.activeThemeSettings,
  allActiveVendors: state => state.activeVendors,
  allActivePermissions: state => state.activePermissions,
  allActiveCurrencies: state => state.activeCurrencies,
  allActiveSliderImages: state => state.activeSliderImages,
  allActiveStaticBanners: state => state.activeStaticBanners,
  allActiveParallaxBanners: state => state.activeParallaxBanners,
  allActiveCountries: state => state.activeCountries,
  allActiveZones: state => state.activeZones,
  allActiveCities: state => state.activeCities,
  allActiveStates: state => state.activeStates,
  allActiveTaxRates: state => state.activeTaxRates,
  allActiveProducts: state => state.activeProducts,
  allActiveProductsSeller: state => state.activeProductsSeller,
  allActiveCoupons: state => state.activeCoupons,
  allActiveCustomers: state => state.activeCustomers,
  allActiveCustomersSeller: state => state.activeCustomersSeller,
  allActiveAdmins: state => state.activeAdmins,
  allActiveNewses: state => state.activeNewses,
  allActiveNewsCategories: state => state.activeNewsCategories,
  allActiveLanguageCodes: state => state.activeLanguageCodes,
  allActiveContentPages: state => state.activeContentPages,
  allActiveReviews: state => state.activeReviews,
  allActiveCurrencyCodes: state => state.activeCurrencyCodes,
  allActiveReviewStatuses: state => state.activeReviewStatuses,
  allActiveApplicationBanners: state => state.activeApplicationBanners,
  allActiveApplicationParallaxBanners: state => state.activeApplicationParallaxBanners,
  allActiveApplicationSliderImages: state => state.activeApplicationSliderImages,
  allActiveContentApplicationPages: state => state.activeContentApplicationPages,
  allActiveSeoPages: state => state.activeSeoPages,
  allActiveBrands: state => state.activeBrands,
  allActiveShippingMethods: state => state.activeShippingMethods,
  allActiveAttributes: state => state.activeAttributes,
  allActiveOrders: state => state.activeOrders,
  allActiveAttributeValues: state => state.activeAttributeValues,
  allActivePaymentMethods: state => state.activePaymentMethods,
  allActiveFaqs: state => state.activeFaqs,
  allActiveNewsletters: state => state.activenewsletters,
  allActiveRiders: state => state.activeRiders,

}

const actions = {
    async fetchActiveSettings({ commit }) {
        return await this.$generalService.activeSettings()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveSettingsFailure', response.error);
                    }
                    else if (response.settings) {
                        commit('fetchActiveSettingsSuccess', response.settings);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveSettingsFailure', error);
                }
            );
    },
    async fetchActiveThemeSettings({ commit }) {
        return await this.$generalService.activeThemeSettings()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveThemeSettingsFailure', response.error);
                    }
                    else if (response.themeSettings) {
                        commit('fetchActiveThemeSettingsSuccess', response.themeSettings);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveThemeSettingsFailure', error);
                }
            );
    },
    async fetchActiveLanguages({ commit }) {
        return await this.$generalService.activeLanguages()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveLanguagesFailure', response.error);
                    }
                    else if (response.languages) {
                        commit('fetchActiveLanguagesSuccess', response.languages);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveLanguagesFailure', error);
                }
            );
    },
    async fetchActiveRoles({ commit }) {
        return await this.$generalService.activeRoles()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveRolesFailure', response.error);
                    }
                    else if (response.roles) {
                        commit('fetchActiveRolesSuccess', response.roles);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveRolesFailure', error);
                }
            );
    },
    async fetchActiveVendors({ commit }) {
        return await this.$generalService.activeVendors()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveVendorsFailure', response.error);
                    }
                    else if (response.vendors) {
                        commit('fetchActiveVendorsSuccess', response.vendors);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveVendorsFailure', error);
                }
            );
    },
    async fetchActiveCategories({ commit }) {
        return await this.$generalService.activeCategories()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveCategoriesFailure', response.error);
                    }
                    else if (response.categories) {
                        commit('fetchActiveCategoriesSuccess', response.categories);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveCategoriesFailure', error);
                }
            );
    },
    async fetchSelectActiveCategories({ commit }) {
        return await this.$generalService.activeSelectCategories()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchSelectActiveCategoriesFailure', response.error);
                    }
                    else if (response.categories) {
                        commit('fetchSelectActiveCategoriesSuccess', response.categories);
                    }
                    return response
                },
                error => {
                    commit('fetchSelectActiveCategoriesFailure', error);
                }
            );
    },
    async fetchParentChildActiveCategories({ commit }) {
        return await this.$generalService.activeParentChildCategories()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchParentChildActiveCategoriesFailure', response.error);
                    }
                    else if (response.categories) {
                        commit('fetchParentChildActiveCategoriesSuccess', response.categories);
                    }
                    return response
                },
                error => {
                    commit('fetchParentChildActiveCategoriesFailure', error);
                }
            );
    },
    async fetchParentActiveCategories({ commit }) {
        return await this.$generalService.activeParentCategories()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchParentActiveCategoriesFailure', response.error);
                    }
                    else if (response.categories) {
                        commit('fetchParentActiveCategoriesSuccess', response.categories);
                    }
                    return response
                },
                error => {
                    commit('fetchParentActiveCategoriesFailure', error);
                }
            );
    },
    async fetchActiveInactiveCategories({ commit }) {
        return await this.$generalService.activeInactiveCategories()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveInactiveCategoriesFailure', response.error);
                    }
                    else if (response.categories) {
                        commit('fetchActiveInactiveCategoriesSuccess', response.categories);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveInactiveCategoriesFailure', error);
                }
            );
    },
    async fetchActiveManufacturers({ commit }) {
        return await this.$generalService.activeManufacturers()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveManufacturersFailure', response.error);
                    }
                    else if (response.manufacturers) {
                        commit('fetchActiveManufacturersSuccess', response.manufacturers);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveManufacturersFailure', error);
                }
            );
    },

    async fetchActiveUnits({ commit }) {
        return await this.$generalService.activeUnits()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveUnitsFailure', response.error);
                    }
                    else if (response.units) {
                        commit('fetchActiveUnitsSuccess', response.units);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveUnitsFailure', error);
                }
            );
    },
    async fetchActiveTaxClasses({ commit }) {
        return await this.$generalService.activeTaxClasses()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveTaxClassesFailure', response.error);
                    }
                    else if (response.tax_classes) {
                        commit('fetchActiveTaxClassesSuccess', response.tax_classes);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveTaxClassesFailure', error);
                }
            );
    },
    async fetchActiveOrderStatuses({ commit }) {
        return await this.$generalService.activeOrderStatuses()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveOrderStatusesFailure', response.error);
                    }
                    else if (response.order_statuses) {
                        commit('fetchActiveOrderStatusesSuccess', response.order_statuses);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveOrderStatusesFailure', error);
                }
            );
    },
    async fetchActiveNewsletters({ commit }) {
        return await this.$generalService.activeNewsletters()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveNewslettersFailure', response.error);
                    }
                    else if (response.newsletters) {
                        commit('fetchActiveNewslettersSuccess', response.newsletters);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveNewslettersFailure', error);
                }
            );
    },
    async fetchActivePermissions({ commit }) {
        return await this.$generalService.activePermissions()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActivePermissionsFailure', response.error);
                    }
                    else if (response.permissions) {
                        commit('fetchActivePermissionsSuccess', response.permissions);
                    }
                    return response
                },
                error => {
                    commit('fetchActivePermissionsFailure', error);
                }
            );
    },
    async fetchActiveCurrencies({ commit }) {
        return await this.$generalService.activeCurrencies()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveCurrenciesFailure', response.error);
                    }
                    else if (response.currencies) {
                        commit('fetchActiveCurrenciesSuccess', response.currencies);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveCurrenciesFailure', error);
                }
            );
    },
    async fetchActiveMedia({ commit }) {
        return await this.$generalService.activeMedia()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveMediaFailure', response.error);
                    }
                    else if (response.media) {
                        commit('fetchActiveMediaSuccess', response.media);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveMediaFailure', error);
                }
            );
    },
    async fetchActiveSliderImages({ commit }) {
        return await this.$generalService.activeSliderImages()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveSliderImagesFailure', response.error);
                    }
                    else if (response.slider_images) {
                        commit('fetchActiveSliderImagesSuccess', response.slider_images);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveSliderImagesFailure', error);
                }
            );
    },
    async fetchActiveStaticBanners({ commit }) {
        return await this.$generalService.activeStaticBanners()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveStaticBannersFailure', response.error);
                    }
                    else if (response.static_banners) {
                        commit('fetchActiveStaticBannersSuccess', response.static_banners);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveStaticBannersFailure', error);
                }
            );
    },
    async fetchActiveParallaxBanners({ commit }) {
        return await this.$generalService.activeParallaxBanners()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveParallaxBannersFailure', response.error);
                    }
                    else if (response.parallax_banners) {
                        commit('fetchActiveParallaxBannersSuccess', response.parallax_banners);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveParallaxBannersFailure', error);
                }
            );
    },
    async fetchActiveCountries({ commit }) {
        return await this.$generalService.activeCountries()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveCountriesFailure', response.error);
                    }
                    else if (response.countries) {
                        commit('fetchActiveCountriesSuccess', response.countries);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveCountriesFailure', error);
                }
            );
    },
    async fetchActiveZones({ commit }) {
        return await this.$generalService.activeZones()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveZonesFailure', response.error);
                    }
                    else if (response.zones) {
                        commit('fetchActiveZonesSuccess', response.zones);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveZonesFailure', error);
                }
            );
    },

    async fetchActiveCities({ commit }) {
        return await this.$generalService.activeCities()
            .then(
                response => {
                    if (response.status) {
                        commit('fetchActiveCitiesFailure', response.error);
                    }
                    else if (response.cities) {
                        commit('fetchActiveCitiesSuccess', response.cities);
                    }
                    return response
                },
                error => {
                    commit('fetchActiveCitiesFailure', error);
                }
            );
    },

async fetchActiveTaxRates({ commit }) {
  return await this.$generalService.activeTaxRates()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchActiveTaxRatesFailure',  response.error);
        }
        else if(response.tax_rates){
          commit('fetchActiveTaxRatesSuccess', response.tax_rates);
        }
        return response
      },
      error => {
          commit('fetchActiveTaxRatesFailure', error);
      }
  );
},
async fetchActiveProducts({ commit }) {
  return await this.$generalService.activeProducts()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchActiveProductsFailure',  response.error);
        }
        else if(response.products){
          commit('fetchActiveProductsSuccess', response.products);
        }
        return response
      },
      error => {
          commit('fetchActiveProductsFailure', error);
      }
  );
},
async fetchActiveProductsSeller({ commit }) {
    return await this.$generalService.activeProductsSeller()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchActiveProductsSellerFailure',  response.error);
          }
          else if(response.products){
            commit('fetchActiveProductsSellerSuccess', response.products);
          }
          return response
        },
        error => {
            commit('fetchActiveProductsSellerFailure', error);
        }
    );
  },
async fetchActiveCoupons({ commit }) {
  return await this.$generalService.activeCoupons()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchActiveCouponsFailure',  response.error);
        }
        else if(response.coupons){
          commit('fetchActiveCouponsSuccess', response.coupons);
        }
        return response
      },
      error => {
          commit('fetchActiveCouponsFailure', error);
      }
  );
},
async fetchActiveStates({ commit }) {
  return await this.$generalService.activeStates()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchActiveStatesFailure',  response.error);
        }
        else if(response.states){
          commit('fetchActiveStatesSuccess', response.states);
        }
        return response
      },
      error => {
          commit('fetchActiveStatesFailure', error);
      }
  );
},
async fetchActiveCustomers({ commit }) {
  return await this.$generalService.activeCustomers()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchActiveCustomersFailure',  response.error);
        }
        else if(response.customers){
          commit('fetchActiveCustomersSuccess', response.customers);
        }
        return response
      },
      error => {
          commit('fetchActiveCustomersFailure', error);
      }
  );
},
async fetchActiveCustomersSeller({ commit }) {
    return await this.$generalService.activeCustomersSeller()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchActiveCustomersSellerFailure',  response.error);
          }
          else if(response.customers){
            commit('fetchActiveCustomersSellerSuccess', response.customers);
          }
          return response
        },
        error => {
            commit('fetchActiveCustomersSellerFailure', error);
        }
    );
  },
async fetchActiveAdmins({ commit }) {
  return await this.$generalService.activeAdmins()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchActiveAdminsFailure',  response.error);
        }
        else if(response.admins){
          commit('fetchActiveAdminsSuccess', response.admins);
        }
        return response
      },
      error => {
          commit('fetchActiveAdminsFailure', error);
      }
  );
},
async fetchActiveNewses({ commit }) {
  return await this.$generalService.activeNewses()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchActiveNewsesFailure',  response.error);
        }
        else if(response.newses){
          commit('fetchActiveNewsesSuccess', response.newses);
        }
        return response
      },
      error => {
          commit('fetchActiveNewsesFailure', error);
      }
  );
},
async fetchActiveNewsCategories({ commit }) {
    return await this.$generalService.activeNewsCategories()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchActiveNewsCategoriesFailure',  response.error);
          }
          else if(response.news_categories){
            commit('fetchActiveNewsCategoriesSuccess', response.news_categories);
          }
          return response
        },
        error => {
            commit('fetchActiveNewsCategoriesFailure', error);
        }
    );
  },
  async fetchActiveLanguageCodes({ commit }) {
    return await this.$generalService.activeLanguageCodes()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchActiveLanguageCodesFailure',  response.error);
          }
          else if(response.language_codes){
            commit('fetchActiveLanguageCodesSuccess', response.language_codes);
          }
          return response
        },
        error => {
            commit('fetchActiveLanguageCodesFailure', error);
        }
    );
  },
  async fetchActiveContentPages({ commit }) {
    return await this.$generalService.activeContentPages()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchActiveContentPagesFailure',  response.error);
          }
          else if(response.content_pages){
            commit('fetchActiveContentPagesSuccess', response.content_pages);
          }
          return response
        },
        error => {
            commit('fetchActiveContentPagesFailure', error);
        }
    );
  },
  async fetchActiveReviews({ commit }) {
    return await this.$generalService.activeReviews()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchActiveReviewsFailure',  response.error);
          }
          else if(response.reviews){
            commit('fetchActiveReviewsSuccess', response.reviews);
          }
          return response
        },
        error => {
            commit('fetchActiveReviewsFailure', error);
        }
    );
  },
  async fetchActiveCurrencyCodes({ commit }) {
      return await this.$generalService.activeCurrencyCodes()
          .then(
              response => {
                  if (response.status) {
                      commit('fetchActiveCurrencyCodesFailure', response.error);
                  }
                  else if (response.currency_codes) {
                      commit('fetchActiveCurrencyCodesSuccess', response.currency_codes);
                  }
                  return response
              },
              error => {
                  commit('fetchActiveCurrencyCodesFailure', error);
              }
          );
  },
  async fetchActiveReviewStatuses({ commit }) {
      return await this.$generalService.activeReviewStatuses()
          .then(
              response => {
                  if (response.status) {
                      commit('fetchActiveReviewStatusesFailure', response.error);
                  }
                  else if (response.review_statuses) {
                      commit('fetchActiveReviewStatusesSuccess', response.review_statuses);
                  }
                  return response
              },
              error => {
                  commit('fetchActiveReviewStatusesFailure', error);
              }
          );
  },
  async fetchActiveApplicationBanners({ commit }) {
      return await this.$generalService.activeApplicationBanners()
          .then(
              response => {
                  if (response.status) {
                      commit('fetchActiveApplicationBannersFailure', response.error);
                  }
                  else if (response.application_banners) {
                      commit('fetchActiveApplicationBannersSuccess', response.application_banners);
                  }
                  return response
              },
              error => {
                  commit('fetchActiveApplicationBannersFailure', error);
              }
          );
  },
  async fetchActiveApplicationParallaxBanners({ commit }) {
      return await this.$generalService.activeApplicationParallaxBanners()
          .then(
              response => {
                  if (response.status) {
                      commit('fetchActiveApplicationParallaxBannersFailure', response.error);
                  }
                  else if (response.application_parallax_banners) {
                      commit('fetchActiveApplicationParallaxBannersSuccess', response.application_parallax_banners);
                  }
                  return response
              },
              error => {
                  commit('fetchActiveApplicationParallaxBannersFailure', error);
              }
          );
  },
  async fetchActiveApplicationSliderImages({ commit }) {
      return await this.$generalService.activeApplicationSliderImages()
          .then(
              response => {
                  if (response.status) {
                      commit('fetchActiveApplicationSliderImagesFailure', response.error);
                  }
                  else if (response.application_slider_images) {
                      commit('fetchActiveApplicationSliderImagesSuccess', response.application_slider_images);
                  }
                  return response
              },
              error => {
                  commit('fetchActiveApplicationSliderImagesFailure', error);
              }
          );
  },
  async fetchActiveContentApplicationPages({ commit }) {
    return await this.$generalService.activeContentApplicationPages()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchActiveContentApplicationPagesFailure',  response.error);
          }
          else if(response.content_application_pages){
            commit('fetchActiveContentApplicationPagesSuccess', response.content_application_pages);
          }
          return response
        },
        error => {
            commit('fetchActiveContentApplicationPagesFailure', error);
        }
    );
  },
  async fetchActiveSeoPages({ commit }) {
    return await this.$generalService.activeSeoPages()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchActiveSeoPagesFailure',  response.error);
          }
          else if(response.seo_pages){
            commit('fetchActiveSeoPagesSuccess', response.seo_pages);
          }
          return response
        },
        error => {
            commit('fetchActiveSeoPagesFailure', error);
        }
    );
  },
  async fetchActiveBrands({ commit }) {
      return await this.$generalService.activeBrands()
          .then(
              response => {
                  if (response.status) {
                      commit('fetchActiveBrandsFailure', response.error);
                  }
                  else if (response.brands) {
                      commit('fetchActiveBrandsSuccess', response.brands);
                  }
                  return response
              },
              error => {
                  commit('fetchActiveBrandsFailure', error);
              }
          );
  },
  async fetchActiveShippingMethods({ commit }) {
      return await this.$generalService.activeShippingMethods()
          .then(
              response => {
                  if (response.status) {
                      commit('fetchActiveShippingMethodsFailure', response.error);
                  }
                  else if (response.shipping_methods) {
                      commit('fetchActiveShippingMethodsSuccess', response.shipping_methods);
                  }
                  return response
              },
              error => {
                  commit('fetchActiveShippingMethodsFailure', error);
              }
          );
  },
  async fetchActiveAttributes({ commit }) {
    return await this.$generalService.activeAttributes()
        .then(
            response => {
                if (response.status) {
                    commit('fetchActiveAttributesFailure', response.error);
                }
                else if (response.attributes) {
                    commit('fetchActiveAttributesSuccess', response.attributes);
                }
                return response
            },
            error => {
                commit('fetchActiveAttributesFailure', error);
            }
        );
},
async fetchActiveAttributeValues({ commit }) {
    return await this.$generalService.activeAttributeValues()
        .then(
            response => {
                if (response.status) {
                    commit('fetchActiveAttributeValuesFailure', response.error);
                }
                else if (response.attribute_values) {
                    commit('fetchActiveAttributeValuesSuccess', response.attribute_values);
                }
                return response
            },
            error => {
                commit('fetchActiveAttributeValuesFailure', error);
            }
        );
},
async fetchActiveOrders({ commit }) {
    return await this.$generalService.activeOrders()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchActiveOrdersFailure',  response.error);
          }
          else if(response.orders){
            commit('fetchActiveOrdersSuccess', response.orders);
          }
          return response
        },
        error => {
            commit('fetchActiveOrdersFailure', error);
        }
    );
  },
async fetchActivePaymentMethods({ commit }) {
    return await this.$generalService.activePaymentMethods()
        .then(
            response => {
                if (response.status) {
                    commit('fetchActivePaymentMethodsFailure', response.error);
                }
                else if (response.payment_methods) {
                    commit('fetchActivePaymentMethodsSuccess', response.payment_methods);
                }
                return response
            },
            error => {
                commit('fetchActivePaymentMethodsFailure', error);
            }
        );
},
async fetchActiveFaqs({ commit }) {
    return await this.$generalService.activeFaqs()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchActiveFaqsFailure',  response.error);
          }
          else if(response.faqs){
            commit('fetchActiveFaqsSuccess', response.faqs);
          }
          return response
        },
        error => {
            commit('fetchActiveFaqsFailure', error);
        }
    );
  },
  async fetchActiveRiders({ commit }) {
    return await this.$generalService.activeRiders()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchActiveRidersFailure',  response.error);
          }
          else if(response.riders){
            commit('fetchActiveRidersSuccess', response.riders);
          }
          return response
        },
        error => {
            commit('fetchActiveRidersFailure', error);
        }
    );
  },
};

const mutations = {
  fetchActiveSettingsSuccess(state, activeSettings) {
      state.activeSettings = activeSettings;
  },
  fetchActiveSettingsFailure(state) {
      state.activeSettings = null;
  },
  fetchActiveThemeSettingsSuccess(state, activeThemeSettings) {
    state.activeThemeSettings = activeThemeSettings;
},
fetchActiveThemeSettingsFailure(state) {
    state.activeThemeSettings = null;
},

  fetchActiveVendorsSuccess(state, activeVendors) {
      state.activeVendors = activeVendors;
  },
  fetchActiveVendorsFailure(state) {
      state.activeVendors = null;
  },
  fetchActiveLanguagesSuccess(state, activeLanguages) {
      state.activeLanguages = activeLanguages;
  },
  fetchActiveLanguagesFailure(state) {
      state.activeLanguages = null;
  },
  fetchActiveRolesSuccess(state, activeRoles) {
      state.activeRoles = activeRoles;
  },
  fetchActiveRolesFailure(state) {
      state.activeRoles = null;
  },
  fetchActiveMediaSuccess(state, activeMedia) {
      state.activeMedia = activeMedia;
  },
  fetchActiveMediaFailure(state) {
      state.activeMedia = null;
  },
  fetchActiveCategoriesSuccess(state, activeCategories) {
      state.activeCategories = activeCategories;
  },
  fetchActiveCategoriesFailure(state) {
      state.activeCategories = null;
  },
  fetchSelectActiveCategoriesSuccess(state, activeSelectCategories) {
      state.activeSelectCategories = activeSelectCategories;
  },
  fetchSelectActiveCategoriesFailure(state) {
      state.activeSelectCategories = null;
  },
  fetchParentChildActiveCategoriesSuccess(state, activeParentChildCategories) {
      state.activeParentChildCategories = activeParentChildCategories;
  },
  fetchParentChildActiveCategoriesFailure(state) {
      state.activeParentChildCategories = null;
  },
  fetchParentActiveCategoriesSuccess(state, activeParentCategories) {
    state.activeParentCategories = activeParentCategories;
},
fetchParentActiveCategoriesFailure(state) {
    state.activeParentCategories = null;
},
  fetchActiveInactiveCategoriesSuccess(state, activeInactiveCategories) {
      state.activeInactiveCategories = activeInactiveCategories;
  },
  fetchActiveInactiveCategoriesFailure(state) {
      state.activeInactiveCategories = null;
  },
  fetchActiveManufacturersSuccess(state, activeManufacturers) {
      state.activeManufacturers = activeManufacturers;
  },
  fetchActiveManufacturersFailure(state) {
      state.activeManufacturers = null;
  },
  fetchActiveUnitsSuccess(state, activeUnits) {
      state.activeUnits = activeUnits;
  },
  fetchActiveUnitsFailure(state) {
      state.activeUnits = null;
  },
  fetchActiveTaxClassesSuccess(state, activeTaxClasses) {
      state.activeTaxClasses = activeTaxClasses;
  },
  fetchActiveTaxClassesFailure(state) {
      state.activeTaxClasses = null;
  },
  fetchActiveOrderStatusesSuccess(state, activeOrderStatuses) {
      state.activeOrderStatuses = activeOrderStatuses;
  },
  fetchActiveOrderStatusesFailure(state) {
      state.fetchActiveOrderStatusesFailure = null;
  },
  fetchActivePermissionsSuccess(state, activePermissions) {
      state.activePermissions = activePermissions;
  },
  fetchActivePermissionsFailure(state) {
      state.fetchActivePermissionsFailure = null;
  },
  fetchActiveCurrenciesSuccess(state, activeCurrencies) {
      state.activeCurrencies = activeCurrencies;
  },
  fetchActiveCurrenciesFailure(state) {
      state.activeCurrencies = null;
  },
  fetchActiveSliderImagesSuccess(state, activeSliderImages) {
      state.activeSliderImages = activeSliderImages;
  },
  fetchActiveSliderImagesFailure(state) {
      state.activeSliderImages = null;
  },
  fetchActiveStaticBannersSuccess(state, activeStaticBanners) {
      state.activeStaticBanners = activeStaticBanners;
  },
  fetchActiveStaticBannersFailure(state) {
      state.activeStaticBanners = null;
  },
  fetchActiveCountriesSuccess(state, activeCountries) {
      state.activeCountries = activeCountries;
  },
  fetchActiveCountriesFailure(state) {
      state.activeCountries = null;
  },
  fetchActiveReviewsSuccess(state, activeReviews) {
      state.activeReviews = activeReviews;
  },
  fetchActiveReviewsFailure(state) {
      state.activeReviews = null;
  },
  fetchActiveZonesSuccess(state, activeZones) {
      state.activeZones = activeZones;
  },
  fetchActiveZonesFailure(state) {
      state.activeZones = null;
  },
  fetchActiveStatesSuccess(state, activeStates) {
      state.activeStates = activeStates;
  },
  fetchActiveStatesFailure(state) {
      state.activeStates = null;
  },
  fetchActiveTaxRatesSuccess(state, activeTaxRates) {
      state.activeTaxRates = activeTaxRates;
  },
  fetchActiveTaxRatesFailure(state) {
      state.activeTaxRates = null;
  },
  fetchActiveProductsSuccess(state, activeProducts) {
      state.activeProducts = activeProducts;
  },
  fetchActiveProductsFailure(state) {
      state.activeProductsSeller = null;
  },
  fetchActiveProductsSellerSuccess(state, activeProductsSeller) {
    state.activeProductsSeller = activeProductsSeller;
},
fetchActiveProductsSellerFailure(state) {
    state.activeProductsSeller = null;
},
  fetchActiveCouponsSuccess(state, activeCoupons) {
      state.activeCoupons = activeCoupons;
  },
  fetchActiveCouponsFailure(state) {
      state.activeCoupons = null;
  },
  fetchActiveCitiesSuccess(state, activeCities) {
      state.activeCities = activeCities;
  },
  fetchActiveCitiesFailure(state) {
      state.activeCities = null;
  },
  fetchActiveParallaxBannersSuccess(state, activeParallaxBanners) {
      state.activeParallaxBanners = activeParallaxBanners;
  },
  fetchActiveParallaxBannersFailure(state) {
      state.activeParallaxBanners = null;
  },
  fetchActiveCustomersSuccess(state, activeCustomers) {
      state.activeCustomers = activeCustomers;
  },
  fetchActiveCustomersFailure(state) {
      state.activeCustomers = null;
  },
  fetchActiveCustomersSellerSuccess(state, activeCustomersSeller) {
    state.activeCustomersSeller = activeCustomersSeller;
},
fetchActiveCustomersSellerFailure(state) {
    state.activeCustomersSeller = null;
},
  fetchActiveAdminsSuccess(state, activeAdmins) {
      state.activeAdmins = activeAdmins;
  },
  fetchActiveAdminsFailure(state) {
      state.activeAdmins = null;
  },
  fetchActiveNewsesSuccess(state, activeNewses) {
      state.activeNewses = activeNewses;
  },
  fetchActiveNewsesFailure(state) {
      state.activeNewses = null;
  },
  fetchActiveNewsCategoriesSuccess(state, activeNewsCategories) {
    state.activeNewsCategories = activeNewsCategories;
},
fetchActiveNewsCategoriesFailure(state) {
    state.activeNewsCategories = null;
},
fetchActiveLanguageCodesSuccess(state, activeLanguageCodes) {
    state.activeLanguageCodes = activeLanguageCodes;
},
fetchActiveLanguageCodesFailure(state) {
    state.activeLanguageCodes = null;
},
fetchActiveContentPagesSuccess(state, activeContentPages) {
    state.activeContentPages = activeContentPages;
},
fetchActiveContentPagesFailure(state) {
    state.activeContentPages = null;
},
fetchActiveCurrencyCodesSuccess(state, activeCurrencyCodes) {
    state.activeCurrencyCodes = activeCurrencyCodes;
},
fetchActiveCurrencyCodesFailure(state) {
    state.activeCurrencyCodes = null;
},
fetchActiveReviewStatusesSuccess(state, activeReviewStatuses) {
    state.activeReviewStatuses = activeReviewStatuses;
},
fetchActiveReviewStatusesFailure(state) {
    state.fetchActiveReviewStatusesFailure = null;
},
fetchActiveApplicationBannersSuccess(state, activeApplicationBanners) {
    state.activeApplicationBanners = activeApplicationBanners;
},
fetchActiveApplicationBannersFailure(state) {
    state.activeApplicationBanners = null;
},
fetchActiveApplicationParallaxBannersSuccess(state, activeApplicationParallaxBanners) {
    state.activeApplicationParallaxBanners = activeApplicationParallaxBanners;
},
fetchActiveApplicationParallaxBannersFailure(state) {
    state.activeApplicationParallaxBanners = null;
},
fetchActiveApplicationSliderImagesSuccess(state, activeApplicationSliderImages) {
    state.activeApplicationSliderImages = activeApplicationSliderImages;
},
fetchActiveApplicationSliderImagesFailure(state) {
    state.activeApplicationSliderImages = null;
},
fetchActiveContentApplicationPagesSuccess(state, activeContentApplicationPages) {
    state.activeContentApplicationPages = activeContentApplicationPages;
},
fetchActiveContentApplicationPagesFailure(state) {
    state.activeContentApplicationPages = null;
},
fetchActiveSeoPagesSuccess(state, activeSeoPages) {
    state.activeSeoPages = activeSeoPages;
},
fetchActiveSeoPagesFailure(state) {
    state.activeSeoPages = null;
},
fetchActiveBrandsSuccess(state, activeBrands) {
    state.activeBrands = activeBrands;
},
fetchActiveBrandsFailure(state) {
    state.activeBrands = null;
},

fetchActiveShippingMethodsSuccess(state, activeShippingMethods) {
    state.activeShippingMethods = activeShippingMethods;
},
fetchActiveShippingMethodsFailure(state) {
    state.fetchActiveShippingMethodsFailure = null;
},
fetchActiveAttributesSuccess(state, activeAttributes) {
    state.activeAttributes = activeAttributes;
},
fetchActiveAttributesFailure(state) {
    state.activeAttributes = null;
},
fetchActiveAttributeValuesSuccess(state, activeAttributeValues) {
    state.activeAttributeValues = activeAttributeValues;
},
fetchActiveAttributeValuesFailure(state) {
    state.activeAttributeValues = null;
},
fetchActiveOrdersSuccess(state, activeOrders) {
    state.activeOrders = activeOrders;
},
fetchActiveOrdersFailure(state) {
    state.activeOrders = null;
},
fetchActivePaymentMethodsSuccess(state, activePaymentMethods) {
    state.activePaymentMethods = activePaymentMethods;
},
fetchActivePaymentMethodsFailure(state) {
    state.fetchActivePaymentMethodsFailure = null;
},
fetchActiveFaqsSuccess(state, activeFaqs) {
    state.activeFaqs = activeFaqs;
},
fetchActiveFaqsFailure(state) {
    state.activeFaqs = null;
},
fetchActiveNewslettersSuccess(state, activeNewsletters) {
    state.activeNewsletters = activeNewsletters;
},
fetchActiveNewslettersFailure(state) {
    state.fetchActiveNewslettersFailure = null;
},
fetchActiveRidersSuccess(state, activeRiders) {
    state.activeRiders = activeRiders;
},
fetchActiveRidersFailure(state) {
    state.activeRiders = null;
},
}

export default {
    state,
    actions,
    mutations,
    getters
};
