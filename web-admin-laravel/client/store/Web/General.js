
const languages = null;
const currencies = null;
const settings = null;
const genericData = null;
const flashSaleProducts = null;
const coupons = null;
const featuredCategories = null;
const upcomingProducts = null;
const newArrivalProducts = null;
const trendingProducts = null;
const latestProducts = null;
const featuredProductsCategoryWise = null;
const featuredProducts = null;
const featuredVendors = null;
const activeCountries = null;
const activeStates = null;
const activeCities = null;
const footerData = null;
const compareProducts = null;
const megaMenuItems = null;

const state = () => ({
  languages: languages ? languages : null ,
  currencies: currencies ? currencies : null ,
  settings: settings ? settings : null ,
  genericData: genericData ? genericData : null,
  flashSaleProducts: flashSaleProducts ? flashSaleProducts : null ,
  coupons: coupons ? coupons : null ,
  featuredCategories: featuredCategories ? featuredCategories : null ,
  upcomingProducts: upcomingProducts ? upcomingProducts : null ,
  newArrivalProducts: newArrivalProducts ? newArrivalProducts : null ,
  trendingProducts: trendingProducts ? trendingProducts : null ,
  latestProducts: latestProducts ? latestProducts : null ,
  featuredProductsCategoryWise: featuredProductsCategoryWise ? featuredProductsCategoryWise : null ,
  featuredProducts: featuredProducts ? featuredProducts : null ,
  featuredVendors: featuredVendors ? featuredVendors : null ,
  activeCountries: activeCountries ? activeCountries : null ,
  activeStates: activeStates ? activeStates : null ,
  activeCities: activeCities ? activeCities : null ,
  footerData: footerData ? footerData : null ,
  shopSearch: '',
  compareProducts: compareProducts ? compareProducts:null,
  megaMenuItems: megaMenuItems ? megaMenuItems : null ,
})
const getters = {
  allLanguages: state => state.languages,
  allCurrencies: state => state.currencies,
  allSettings: state => state.settings,
  allGenericData: state => state.genericData,
  allFlashSaleProducts: state => state.flashSaleProducts,
  allCoupons: state => state.coupons,
  allFeaturedCategories: state => state.featuredCategories,
  allUpcomingProducts: state => state.upcomingProducts,
  allNewArrivalProducts: state => state.newArrivalProducts,
  allTrendingProducts: state => state.trendingProducts,
  allLatestProducts: state => state.latestProducts,
  allFeaturedProductsCategoryWise: state => state.featuredProductsCategoryWise,
  allFeaturedProducts: state => state.featuredProducts,
  allFeaturedVendors: state => state.featuredVendors,
  allActiveCountries: state => state.activeCountries,
  allActiveStates: state => state.activeStates,
  allActiveCities: state => state.activeCities,
  allFooterData: state => state.footerData,
  allCompareProducts: state => state.compareProducts,
  allMegaMenuItems: state => state.megaMenuItems,
}

const actions = {
  async fetchSettings({ commit }) {
    return await this.$webService.settings()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchSettingsFailure',  response.error);
          }
          else if(response.data){
            commit('fetchSettingsSuccess', response.data);
          }
          return response
        },
        error => {
            commit('fetchSettingsFailure', error);
        }
    );
 },
 async fetchGenericData({ commit }) {
   return await this.$webService.genericData()
   .then(
       response => {
         if(response.status)
         {
           commit('fetchGenericDataFailure',  response.error);
         }
         else if(response.data){
           commit('fetchGenericDataSuccess', response.data);
         }
         return response
       },
       error => {
           commit('fetchGenericDataFailure', error);
       }
   );
},
 async fetchDefaultSettings({ commit }) {
   return await this.$webService.defaultSettings()
   .then(
       response => {
         if(response.status)
         {
           commit('fetchDefaultSettingsFailure',  response.error);
         }
         else if(response.data){
           commit('fetchDefaultSettingsSuccess', response.data);
         }
         return response
       },
       error => {
           commit('fetchDefaultSettingsFailure', error);
       }
   );
},
  async fetchLanguages({ commit }) {
    return await this.$webService.languages()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchLanguagesFailure',  response.error);
          }
          else if(response.data){
            commit('fetchLanguagesSuccess', response.data);
          }
          return response
        },
        error => {
            commit('fetchLanguagesFailure', error);
        }
    );
 },
 async fetchCurrencies({ commit }) {
   return await this.$webService.currencies()
   .then(
       response => {
         if(response.status)
         {
           commit('fetchCurrenciesFailure',  response.error);
         }
         else if(response.data){
           commit('fetchCurrenciesSuccess', response.data);
         }
         return response
       },
       error => {
           commit('fetchCurrenciesFailure', error);
       }
   );
},
async fetchFlashSaleProducts({ commit }) {
  return await this.$webService.flashSaleProducts()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchFlashSaleProductsFailure',  response.error);
        }
        else if(response.data){
          commit('fetchFlashSaleProductsSuccess', response.data);
        }
        return response
      },
      error => {
          commit('fetchFlashSaleProductsFailure', error);
      }
  );
},
async fetchCoupons({ commit }) {
    return await this.$webService.coupons()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchCouponsFailure',  response.error);
          }
          else if(response.data){
            commit('fetchCouponsSuccess', response.data);
          }
          return response
        },
        error => {
            commit('fetchCouponsFailure', error);
        }
    );
  },
  async fetchFeaturedCategories({ commit }) {
    return await this.$webService.featuredCategories()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchFeaturedCategoriesFailure',  response.error);
          }
          else if(response.data){
            commit('fetchFeaturedCategoriesSuccess', response.data);
          }
          return response
        },
        error => {
            commit('fetchFeaturedCategoriesFailure', error);
        }
    );
  },

async fetchUpcomingProducts({ commit }) {
  return await this.$webService.upcomingProducts()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchUpcomingProductsFailure',  response.error);
        }
        else if(response.data){
          commit('fetchUpcomingProductsSuccess', response.data);
        }
        return response
      },
      error => {
          commit('fetchUpcomingProductsFailure', error);
      }
  );
},
async fetchNewArrivalProducts({ commit }) {
  return await this.$webService.newArrivalProducts()
  .then(
      response => {

        if(response.status)
        {
          commit('fetchNewArrivalProductsFailure',  response.error);
        }
        else if(response.data){
          commit('fetchNewArrivalProductsSuccess', response.data);
        }
        return response
      },
      error => {
          commit('fetchNewArrivalProductsFailure', error);
      }
  );
},
async fetchTrendingProducts({ commit }) {
  return await this.$webService.trendingProducts()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchTrendingProductsFailure',  response.error);
        }
        else if(response){
          commit('fetchTrendingProductsSuccess', response);
        }
        return response
      },
      error => {
          commit('fetchTrendingProductsFailure', error);
      }
  );
},
async fetchLatestProducts({ commit }) {
    return await this.$webService.latestProducts()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchLatestProductsFailure',  response.error);
          }
          else if(response.data){
            commit('fetchLatestProductsSuccess', response.data);
          }
          return response
        },
        error => {
            commit('fetchLatestProductsFailure', error);
        }
    );
  },
async fetchFeaturedProductsCategoryWise({ commit }) {
  return await this.$webService.featured_products_categories_wise()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchFeaturedProductsCategoryWiseFailure',  response.error);
        }
        else if(response.data){
          commit('fetchFeaturedProductsCategoryWiseSuccess', response.data);
        }
        return response
      },
      error => {
          commit('fetchFeaturedProductsCategoryWiseFailure', error);
      }
  );
},
async fetchFeaturedProducts({ commit }) {
    return await this.$webService.featured_products()
    .then(
        response => {
          if(response.status)
          {
            commit('fetchFeaturedProductsFailure',  response.error);
          }
          else if(response.data){
            commit('fetchFeaturedProductsSuccess', response.data);
          }
          return response
        },
        error => {
            commit('fetchFeaturedProductsFailure', error);
        }
    );
  },
async fetchFeaturedVendors({ commit }) {
  return await this.$webService.featuredVendors()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchFeaturedVendorsFailure',  response.error);
        }
        else if(response.data){
          commit('fetchFeaturedVendorsSuccess', response.data);
        }
        return response
      },
      error => {
          commit('fetchFeaturedVendorsFailure', error);
      }
  );
},
async fetchActiveCountries({ commit }) {
    return await this.$webService.activeCountries()
        .then(
            response => {
                if (response.status) {
                    commit('fetchActiveCountriesFailure', response.error);
                }
                else if (response.data) {
                    commit('fetchActiveCountriesSuccess', response.data);
                }
                return response
            },
            error => {
                commit('fetchActiveCountriesFailure', error);
            }
        );
},
async fetchActiveStates({ commit }) {
  return await this.$webService.activeStates()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchActiveStatesFailure',  response.error);
        }
        else if(response.data){
          commit('fetchActiveStatesSuccess', response.data);
        }
        return response
      },
      error => {
          commit('fetchActiveStatesFailure', error);
      }
  );
},
async fetchCompareProducts({ commit },payload) {
  return await this.$webService.compareProducts(payload)
  .then(
      response => {
        if(response.status)
        {
          commit('updateCompareProducts',  null);
        }
        else if(response.data){
          commit('updateCompareProducts', response.data);
        }
        else
        {
            commit('updateCompareProducts', null);
        }
        return response
      },
      error => {
          commit('updateCompareProducts', null);
      }
  );
},
async fetchActiveCities({ commit }) {
    return await this.$webService.activeCities()
        .then(
            response => {
                if (response.status) {
                    commit('fetchActiveCitiesFailure', response.error);
                }
                else if (response.data) {
                    commit('fetchActiveCitiesSuccess', response.data);
                }
                return response
            },
            error => {
                commit('fetchActiveCitiesFailure', error);
            }
        );
},
async fetchFooterData({ commit }) {
    return await this.$webService.fetchFooterData()
        .then(
            response => {
                if (response.status) {
                    commit('fetchFooterDataFailure', response.error);
                }
                else if (response.data) {
                    commit('fetchFooterDataSuccess', response.data);
                }
                return response
            },
            error => {
                commit('fetchFooterDataFailure', error);
            }
        );
},
async fetchMegaMenuItems({ commit }) {
  return await this.$webService.megaMenuItems()
  .then(
      response => {
        if(response.status)
        {
          commit('fetchMegaMenuItemsFailure',  response.error);
        }
        else if(response.data){
          commit('fetchMegaMenuItemsSuccess', response.data);
        }
        return response
      },
      error => {
          commit('fetchMegaMenuItemsFailure', error);
      }
  );
},
};

const mutations = {
  fetchSettingsSuccess(state, settings) {
      state.settings = settings;
  },
  fetchSettingsFailure(state) {
      state.settings = null;
  },
  fetchGenericDataSuccess(state, genericData) {
      state.genericData = genericData;
  },
  fetchGenericDataFailure(state) {
      state.genericData = null;
  },
  fetchLanguagesSuccess(state, languages) {
      state.languages = languages;
  },
  fetchLanguagesFailure(state) {
      state.languages = null;
  },
  fetchCurrenciesSuccess(state, currencies) {
      state.currencies = currencies;
  },
  updateShopSearch(state, shopSearch) {
      state.shopSearch = shopSearch;
  },
  updateCompareProducts(state, compareProducts) {
      state.compareProducts = compareProducts;
  },
  fetchCurrenciesFailure(state) {
      state.currencies = null;
  },
  fetchFlashSaleProductsSuccess(state, flash_sale_products) {
      state.flashSaleProducts = flash_sale_products;
  },
  fetchFlashSaleProductsFailure(state) {
      state.flashSaleProducts = null;
  },
  fetchCouponsSuccess(state, coupons) {
    state.coupons = coupons;
},
fetchCouponsFailure(state) {
    state.coupons = null;
},
fetchFeaturedCategoriesSuccess(state, featuredCategories) {
    state.featuredCategories = featuredCategories;
},
fetchFeaturedCategoriesFailure(state) {
    state.featuredCategories = null;
},
  fetchUpcomingProductsSuccess(state, upcoming_products) {
      state.upcomingProducts = upcoming_products;
  },
  fetchUpcomingProductsFailure(state) {
      state.upcomingProducts = null;
  },
  fetchNewArrivalProductsSuccess(state, new_arrival_products) {
      state.newArrivalProducts = new_arrival_products;
  },
  fetchNewArrivalProductsFailure(state) {
      state.newArrivalProducts = null;
  },
  fetchTrendingProductsSuccess(state, trending_products) {
    state.trendingProducts = trending_products;
},
fetchTrendingProductsFailure(state) {
    state.newArrivalProducts = null;
},
  fetchLatestProductsSuccess(state, latest_products) {
    state.latestProducts = latest_products;
},
fetchLatestProductsFailure(state) {
    state.latestProducts = null;
},
  fetchFeaturedProductsCategoryWiseSuccess(state, featured_products_categories_wise) {
      state.featuredProductsCategoryWise = featured_products_categories_wise;
  },
  fetchFeaturedProductsCategoryWiseFailure(state) {
      state.featuredProductsCategoryWise = null;
  },
  fetchFeaturedProductsSuccess(state, featured_products) {
    state.featuredProducts = featured_products;
},
fetchFeaturedProductsFailure(state) {
    state.featuredProducts = null;
},
  fetchFeaturedVendorsSuccess(state, featured_vendors) {
      state.featuredVendors = featured_vendors;
  },
  fetchFeaturedVendorsFailure(state) {
      state.featuredVendors = null;
  },
  fetchActiveCountriesSuccess(state, activeCountries) {
      state.activeCountries = activeCountries;
  },
  fetchActiveCountriesFailure(state) {
      state.activeCountries = null;
  },
  fetchActiveStatesSuccess(state, activeStates) {
      state.activeStates = activeStates;
  },
  fetchActiveStatesFailure(state) {
      state.activeStates = null;
  },
  fetchActiveCitiesSuccess(state, activeCities) {
      state.activeCities = activeCities;
  },
  fetchActiveCitiesFailure(state) {
      state.activeCities = null;
  },
  fetchFooterDataSuccess(state, footerData) {
      state.footerData = footerData;
  },
  fetchFooterDataFailure(state) {
      state.footerData = null;
  },
  fetchMegaMenuItemsSuccess(state, megaMenuItems) {
      state.megaMenuItems = megaMenuItems;
  },
  fetchMegaMenuItemsFailure(state) {
      state.megaMenuItems = null;
  },

}

export default {
  state,
  actions,
  mutations,
  getters
};
