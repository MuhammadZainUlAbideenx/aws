import fileDownload from 'js-file-download';
export default $axios => ({
  activeLanguages() {
    return $axios.$get(`/backend/api/admin/languagesActive`)
  },
  getDashboardData() {
    return $axios.$get(`/backend/api/admin/getDashboardData`)
  },
  getSellerDashboardData() {
    return $axios.$get(`/backend/api/vendor/getSellerDashboardData`)
  },
  activeRoles() {
    return $axios.$get(`/backend/api/admin/rolesActive`)
  },
  activeSettings() {
    return $axios.$get(`/backend/api/admin/settingsActive`)
  },
  activeThemeSettings() {
    return $axios.$get(`/backend/api/admin/themeSettingsActive`)
  },
  activeCategories() {
    return $axios.$get(`/backend/api/admin/categoriesActive`)
  },
  activeSelectCategories(params) {
    return $axios.$get(`/backend/api/admin/categoriesSelectActive`,{params})
  },
  activeParentChildCategories(params){
    return $axios.$get(`/backend/api/admin/categoriesParentChildActive`,{params})
  },
  activeParentCategories(){
    return $axios.$get(`/backend/api/admin/categoriesParentActive`)
  },
  vendorCategories(id) {
    return $axios.$get(`/backend/api/admin/categoryVendors/${id}`)
  },
  activeInactiveCategories(params) {
    return $axios.$get(`/backend/api/admin/categoriesActiveInactive`,{params})
  },
  activeManufacturers(params) {
    return $axios.$get(`/backend/api/admin/manufacturersActive`,{params})
  },
  activeUnits(params) {
    return $axios.$get(`/backend/api/admin/unitsActive`,{params})
  },
  activeTaxClasses(params) {
    return $axios.$get(`/backend/api/admin/taxClassesActive`,{params})
  },
  activeOrderStatuses(params) {
    return $axios.$get(`/backend/api/admin/orderStatusesActive`,{params})
  },
  activeOrders(params) {
    return $axios.$get(`/backend/api/admin/ordersActive`,{params})
  },
  activePermissions() {
    return $axios.$get(`/backend/api/admin/permissionsActive`)
  },
  activeCurrencies(params) {
    return $axios.$get(`/backend/api/admin/currenciesActive`,{params})
  },
  activeMedia() {
    return $axios.$get(`/backend/api/admin/mediaActive`)
  },
  activeVendors(params) {
    return $axios.$get(`/backend/api/admin/vendorsActive`,{params})
  },
  activeSliderImages(params){
    return $axios.$get(`/backend/api/admin/sliderImagesActive`,{params})
  },
  activeStaticBanners(params){
    return $axios.$get(`/backend/api/admin/staticBannersActive`,{params})
  },
  activeParallaxBanners(params){
    return $axios.$get(`/backend/api/admin/parallaxBannersActive`,{params})
  },
  activeCountries(params) {
    return $axios.$get(`/backend/api/admin/countriesActive`,{params})
  },
  getActiveCountryById(id) {
    return $axios.$get(`/backend/api/admin/getActiveCountryById/${id}`)
  },
  activeZones(params) {
    return $axios.$get(`/backend/api/admin/zonesActive`,{params})
  },
  activeTaxRates(params) {
    return $axios.$get(`/backend/api/admin/tax_ratesActive`,{params})
  },
  activeProducts(params) {
    return $axios.$get(`/backend/api/admin/productsActive`,{params})
  },
  activeProductsSeller(params) {
    return $axios.$get(`/backend/api/vendor/activeProductsSeller`,{params})
  },
  activeCoupons(params) {
    return $axios.$get(`/backend/api/admin/couponsActive`,{params})
  },
  activeCities(params) {
    return $axios.$get(`/backend/api/admin/citiesActive`,{params})
  },
  activeStates(params) {
    return $axios.$get(`/backend/api/admin/statesActive`,{params})
  },
  activeCustomers(params) {
    return $axios.$get(`/backend/api/admin/customersActive`,{params})
  },
  activeCustomersSeller(params) {
    return $axios.$get(`/backend/api/vendor/activeCustomersSeller`,{params})
  },
  activeAdmins(params) {
    return $axios.$get(`/backend/api/admin/adminsActive`,{params})
  },
  activeNewses(params) {
    return $axios.$get(`/backend/api/admin/newsActive`,{params})
  },
  activeNewsCategories(params) {
    return $axios.$get(`/backend/api/admin/newsCategoriesActive`,{params})
  },
  activeAboutUs(params) {
    return $axios.$get(`/backend/api/admin/aboutUsActive`,{params})
  },
  getZonesByCountry(id,params){
    return $axios.$get(`/backend/api/admin/getZonesByCountry/${id}`,{params})
  },
  getStatesByCountry(id,params){
    return $axios.$get(`/backend/api/admin/getStatesByCountry/${id}`,{params})
  },
  getCitiesByState(id,params){
    return $axios.$get(`/backend/api/admin/getCitiesByState/${id}`,{params})
  },
  getAttributeValuesByAttribute(id,params){
    return $axios.$get(`/backend/api/admin/getAttributeValuesByAttribute/${id}`,{params})
  },
  allActiveAdminsRoles(params){
    return $axios.$get(`/backend/api/admin/allActiveAdminsRoles`,{params})
  },
  activeContentPages(params){
    return $axios.$get(`/backend/api/admin/contentPagesActive`,{params})
  },
  activeLanguageCodes(){
    return $axios.$get(`/backend/api/admin/languageCodesActive`)
  },
  activeReviews(params) {
    return $axios.$get(`/backend/api/admin/reviewsActive`,{params})
  },
  activeCurrencyCodes(){
    return $axios.$get(`/backend/api/admin/currencyCodesActive`)
  },
  activeReviewStatuses(params) {
    return $axios.$get(`/backend/api/admin/reviewStatusesActive`,{params})
  },
  activeApplicationBanners(params){
    return $axios.$get(`/backend/api/admin/applicationBannersActive`,{params})
  },
  activeApplicationParallaxBanners(params){
    return $axios.$get(`/backend/api/admin/applicationParallaxBannersActive`,{params})
  },
  activeApplicationSliderImages(params){
    return $axios.$get(`/backend/api/admin/applicationSliderImagesActive`,{params})
  },
  activeContentApplicationPages(params){
    return $axios.$get(`/backend/api/admin/contentApplicationPagesActive`,{params})
  },
  activeSeoPages(params) {
    return $axios.$get(`/backend/api/admin/seoPagesActive`,{params})
  },
  activeBrands(params) {
    return $axios.$get(`/backend/api/admin/brandsActive`,{params})
  },
  cacheClear() {
    return $axios.$get(`/backend/api/admin/cacheClear`)
  },
  activeShippingMethods(params) {
    return $axios.$get(`/backend/api/admin/shippingMethodsActive`,{params})
  },
  activeAttributes(params) {
    return $axios.$get(`/backend/api/admin/attributeActive`,{params})
  },
  activeAttributeValues(params) {
    return $axios.$get(`/backend/api/admin/attributeValuesActive`,{params})
  },
  activePaymentMethods(params) {
    return $axios.$get(`/backend/api/admin/paymentMethodsActive`,{params})
  },
  activeContactForms(params) {
    return $axios.$get(`/backend/api/admin/ContactFormsActive`,{params})
  },
  getProductInventory(id) {
    return $axios.$get(`/backend/api/admin/getProductInventory/${id}`)
  },
  activeFaqs(params) {
    return $axios.$get(`/backend/api/admin/faqsActive`,{params})
  },
  activeNewsletters(params) {
    return $axios.$get(`/backend/api/admin/newslettersActive`,{params})
  },
  changeOrderStatus(payload){
    return $axios.$post(`/backend/api/admin/changeOrderStatus`,payload)
  },
  changeSellerOrderStatus(payload){
    return $axios.$post(`/backend/api/vendor/changeSellerOrderStatus`,payload)
  },
  getAdminProfile(){
    return $axios.$get(`/backend/api/admin/getAdminProfile`)
  },
  updateAdminProfile(payload){
    return $axios.$post(`/backend/api/admin/updateAdminProfile`,payload)
  },
  activeRiders(params) {
    return $axios.$get(`/backend/api/admin/ridersActive`,{params})
  },
  sendPushNotification(payload){
    return $axios.$post(`/backend/api/web/sendPushNotification`,payload)
  },
  getSaleReports(params){
    return $axios.$get(`/backend/api/admin/getFilteredSaleReports`,{params})
  },
  getSellerSaleReports(params){
    return $axios.$get(`/backend/api/vendor/getFilteredSellerSaleReports`,{params})
  },
  getCustomerReports(params){
    return $axios.$get(`/backend/api/admin/getFilteredCustomerReports`,{params})
  },
  getProductReports(params){
    return $axios.$get(`/backend/api/admin/getFilteredProductReports`,{params})
  },
  getSellerProductReports(params){
    return $axios.$get(`/backend/api/vendor/getFilteredSellerProductReports`,{params})
  },
  getOrderReports(params){
    return $axios.$get(`/backend/api/admin/getFilteredOrderReports`,{params})
  },
  getSellerOrderReports(params){
    return $axios.$get(`/backend/api/vendor/getFilteredSellerOrderReports`,{params})
  },
  saleExport(params){
    return $axios.$post(`/backend/api/admin/saleExport`,params,{
        responseType: "blob"
   }).then((response) => {
    const filename = "SaleReport" +"." + params.export
    fileDownload(response,filename);
  });
  },
  saleSellerExport(params){
    return $axios.$post(`/backend/api/vendor/saleSellerExport`,params,{
        responseType: "blob"
   }).then((response) => {
    const filename = "SellerSaleReport" +"." + params.export
    fileDownload(response,filename);
  });
  },
  customerExport(params){
    return $axios.$post(`/backend/api/admin/customerExport`,params,{
        responseType: "blob"
   }).then((response) => {
    const filename = "CustomerReport" +"." + params.export
    fileDownload(response,filename);
  });
  },
  productExport(params){
    return $axios.$post(`/backend/api/admin/productExport`,params,{
        responseType: "blob"
   }).then((response) => {
    const filename = "ProductReport" +"." + params.export
    fileDownload(response,filename);
  });
  },
  productSellerExport(params){
    return $axios.$post(`/backend/api/vendor/productSellerExport`,params,{
        responseType: "blob"
   }).then((response) => {
    const filename = "SellerProductReport" +"." + params.export
    fileDownload(response,filename);
  });
  },
  orderExport(params){
    return $axios.$post(`/backend/api/admin/orderExport`,params,{
        responseType: "blob"
   }).then((response) => {
    const filename = "OrderReport" +"." + params.export
    fileDownload(response,filename);
  });
  },
  orderSellerExport(params){
    return $axios.$post(`/backend/api/vendor/orderSellerExport`,params,{
        responseType: "blob"
   }).then((response) => {
    const filename = "SellerOrderReport" +"." + params.export
    fileDownload(response,filename);
  });
  },
  filterVendorProducts(params){
    return $axios.$get(`/backend/api/admin/filterVendorProducts`,{params})
  },
  updateVendorStoreStatus(filterData,vendor_id){
    return $axios.$put(`/backend/api/admin/updateVendorStoreStatus/${vendor_id}`,{filterData})
  },

  updateVendorFeatured(filterData,vendor_id){
    return $axios.$put(`/backend/api/admin/updateVendorFeatured/${vendor_id}`,{filterData})
  },

  updatePayoutRequestStatus(filterData,payoutRequest_id,status){
    return $axios.$put(`/backend/api/admin/updatePayoutRequestStatus/${payoutRequest_id}/${status}`,{filterData})
  },

  updateRiderPayoutRequestStatus(filterData,riderPayoutRequest_id,status){
    return $axios.$put(`/backend/api/admin/updateRiderPayoutRequestStatus/${riderPayoutRequest_id}/${status}`,{filterData})
  },

  updateSellerRiderPayoutRequestStatus(filterData,riderPayoutRequest_id,status){
    return $axios.$put(`/backend/api/vendor/updateRiderPayoutRequestStatus/${riderPayoutRequest_id}/${status}`,{filterData})
  },


  getRiderMessages(params){
    return $axios.$get(`/backend/api/vendor/getRiderMessages`,{params})
  },
  fetchAllRiderMessages(id){
    return $axios.$get(`/backend/api/vendor/fetchAllRiderMessages/${id}`)
  },

  getAdminRiderMessages(params){
    return $axios.$get(`/backend/api/admin/getRiderMessages`,{params})
  },
  fetchAdminAllRiderMessages(id){
    return $axios.$get(`/backend/api/admin/fetchAllRiderMessages/${id}`)
  },
  updateRiderCommission(params){
    return $axios.$get(`/backend/api/admin/updateRiderCommission`,{params})
  },
  getRiderShipping(){
    return $axios.$get(`/backend/api/admin/getRiderShipping`)
  },
  updateSellerRiderCommission(params){
    return $axios.$get(`/backend/api/vendor/updateRiderCommission`,{params})
  },
  getSellerRiderShipping(){
    return $axios.$get(`/backend/api/vendor/getRiderShipping`)
  },
  importData(payload,prefix){
    return $axios.$post(`/backend/api/${prefix}/importData`,payload, {
        headers: {
             'Content-Type': 'multipart/form-data'
        }
     })
  },
})
