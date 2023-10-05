export default $axios => ({
  environment() {
    return $axios.$get(`/backend/api/web/environment`)
  },
  fetchCartItems(){
    return $axios.$get('/backend/api/web/fetchCartItems')
  },
  removeCartItem(cart_id) {
    return $axios.$delete(`/backend/api/web/removeCartItem/${cart_id}`)
  },
  deleteAllCartItems() {
    return $axios.$delete(`/backend/api/web/deleteAllCartItems`)
  },
  addCartItem(payload){
    return $axios.$post(`/backend/api/web/addCartItem`, payload)
  },
  changeCartItemQuantity(payload){
    return $axios.$post(`/backend/api/web/changeCartItemQuantity`, payload)
  },
  fetchWishlistItems(params){
    return $axios.$get('/backend/api/web/fetchWishlistItems',{params})
  },
  removeWishlistItem(product_id) {
    return $axios.$delete(`/backend/api/web/removeWishlistItem/${product_id}`)
  },
  addWishlistItem(payload){
    return $axios.$post(`/backend/api/web/addWishlistItem`, payload)
  },
  deleteWishlistItem(payload){
    return $axios.$post(`/backend/api/web/deleteWishlistItem`, payload)
  },
  default_settings() {
    return $axios.$get(`/backend/api/web/website_default_settings`)
  },
  languages() {
    return $axios.$get(`/backend/api/web/languages`)
  },
  currencies() {
    return $axios.$get(`/backend/api/web/currencies`)
  },
  genericData(){
    return $axios.$get(`/backend/api/web/generic_web_data`)
  },
  settings() {
    return $axios.$get(`/backend/api/web/settings`)
  },
  flashSaleProducts() {
    return $axios.$get(`/backend/api/web/flash_sale_products`)
  },
  featured_products_categories_wise() {
    return $axios.$get(`/backend/api/web/featured_products_categories_wise`)
  },
  featured_products() {
    return $axios.$get(`/backend/api/web/featured_products`)
  },
  productDetail(slug) {
    return $axios.$get(`/backend/api/web/product/${slug}`)
  },
  contentPageDetail(slug){
    return $axios.$get(`/backend/api/web/contentPageDetail/${slug}`)
  },
  upcomingProducts() {
    return $axios.$get(`/backend/api/web/upcoming_products`)
  },
  newArrivalProducts() {
    return $axios.$get(`/backend/api/web/new_arrival_products`)
  },
  latestProducts() {
    return $axios.$get(`/backend/api/web/latest_products`)
  },
  featuredVendors(){
    return $axios.$get(`/backend/api/web/featured_vendors`)
  },
  executePayment(payload) {
    return $axios.$post(`/backend/api/web/executePayment`, payload)
  },
  verifyPayment(payload) {
    return $axios.$post(`/backend/api/web/verifyPayment`, payload)
  },
  compareProducts(payload){
    return $axios.$post(`/backend/api/web/compare_products`, payload)
  },
  allBrands(params) {
    return $axios.$get(`/backend/api/web/brands`,{params})
  },
  allAboutUs(params) {
    return $axios.$get(`/backend/api/web/aboutus`,{params})
  },
  allTermCondition(params) {
    return $axios.$get(`/backend/api/web/term_condition`,{params})
  },
  allRefundPolicy(params) {
    return $axios.$get(`/backend/api/web/refund_policy`,{params})
  },
  allPrivacyPolicy(params) {
    return $axios.$get(`/backend/api/web/privacy_policy`,{params})
  },
  allVendors(params) {
    return $axios.$get(`/backend/api/web/vendors`,{params})
  },
  vendorDetail(slug) {
    return $axios.$get(`/backend/api/web/vendor/${slug}`)
  },
  vendorReview(slug) {
    return $axios.$get(`/backend/api/web/vendor/${slug}/reviews`)
  },
  shopPageData(params) {
    return $axios.$get(`/backend/api/web/shopPageData`,{params})
  },
  shopFilterProducts(params) {
    return $axios.$get(`/backend/api/web/shopFilterProducts`,{params})
  },
  allPaymentMethods() {
    return $axios.$get(`/backend/api/web/payment_methods`)
  },
  customerOrders(params){
    return $axios.$get(`/backend/api/web/customer_orders`,{params})
  },
  customerProfile(){
    return $axios.$get(`/backend/api/web/customer_profile`)
  },
  CustomerOrderDetail(id){
    return $axios.$get(`/backend/api/web/order_detail/${id}`)
  },
  customerAllAddresses(){
    return $axios.$get(`/backend/api/web/customer_all_addresses`)
  },
  activeCountries(params) {
    return $axios.$get(`/backend/api/web/countriesActive`,{params})
  },
  activeStates(params) {
    return $axios.$get(`/backend/api/web/statesActive`,{params})
  },
  activeCities(params) {
    return $axios.$get(`/backend/api/web/citiesActive`,{params})
  },
  fetchFooterData(params) {
    return $axios.$get(`/backend/api/web/fetchFooterData`)
  },
  getStatesByCountry(id,params){
    return $axios.$get(`/backend/api/web/getStatesByCountry/${id}`,{params})
  },
  getCitiesByState(id,params){
    return $axios.$get(`/backend/api/web/getCitiesByState/${id}`,{params})
  },
  addCustomerAddress(payload){
    return $axios.$post(`/backend/api/web/addCustomerAddress`,payload)
  },
  viewCustomerAddress(id){
    return $axios.$get(`/backend/api/web/viewCustomerAddress/${id}`)
  },
  updateCustomerAddress(payload){
    return $axios.$post(`/backend/api/web/updateCustomerAddress`,payload)
  },
  updateCustomerdefaultAddress(payload){
    return $axios.$post(`/backend/api/web/updateCustomerdefaultAddress`,payload)
  },
  deleteCustomerAddress(id){
    return $axios.$delete(`/backend/api/web/deleteCustomerAddress/${id}`)
  },
  registerCustomer(payload){
    return $axios.$post(`/backend/api/web/registerCustomer`,payload)
  },
  forgotPassword(payload){
    return $axios.$post(`/backend/api/customer/auth/password/email`,payload)
  },
  resetPassword(payload){
    return $axios.$post(`/backend/api/customer/auth/password/reset`,payload)
  },
  customerProfileUpdate(payload){
    return $axios.$post(`/backend/api/web/customerProfileUpdate`,payload)
  },
  customerWithAddresses(){
    return $axios.$get(`/backend/api/web/customerWithAddresses`)
  },
  allShippingMethods(){
    return $axios.$get(`/backend/api/web/allShippingMethods`)
  },
  addNewsletterEmail(payload){
    return $axios.$post(`/backend/api/web/newsletter`,payload)
  },
  allPosts(params){
    return $axios.$get(`/backend/api/web/all_posts`,{params})
  },
  postDetail(param){
    return $axios.$get(`/backend/api/web/post_detail/${param}`)
  },
  validateBillingAddress(payload){
    return $axios.$post(`/backend/api/web/validateBillingAddress`,payload)
  },
  validateShippingAddress(payload){
    return $axios.$post(`/backend/api/web/validateShippingAddress`,payload)
  },
  validateShippingMethod(payload){
    return $axios.$post(`/backend/api/web/validateShippingMethod`,payload)
  },
  submitContactForm(payload){
    return $axios.$post(`/backend/api/web/submit_contact_form`,payload)
  },
  megaMenuItems(){
    return $axios.$get(`/backend/api/web/megaMenuItems`)
  },
  validateCouponCode(payload){
    return $axios.$post(`/backend/api/web/validateCouponCode`,payload)
  },
  storeFcmToken(payload) {
    return $axios.$post(`/backend/api/web/storeFcmToken`, payload)
  },
  getWalletTransactions(params){
    return $axios.$get(`/backend/api/web/getWalletTransactions`,{params})
  },
  getWalletBalance(){
    return $axios.$get(`/backend/api/web/getWalletBalance`)
  },
  depositAmount(payload) {
    return $axios.$post(`/backend/api/web/depositAmount`, payload)
  },
  googleAuthDetails(params){
    return $axios.$get(`/backend/api/web/googleAuthDetails`,{params})
  },
  facebookAuthDetails(params){
    return $axios.$get(`/backend/api/web/facebookAuthDetails`,{params})
  },
  submitProductRating(payload){
    return $axios.$post(`/backend/api/web/add_product_review`,payload)
  },
  fetchMessages(params){
    return $axios.$get(`/backend/api/web/fetch_message`,{params})
  },
  sendMessage(payload){
    return $axios.$post(`/backend/api/web/store_message`,payload)
  },
  fetchInstagramMedia(){
    return $axios.$get(`/backend/api/web/instagram`)
  },
  searchProducts(params){
    return $axios.$get(`/backend/api/web/search_products`,{params})
  },
  followVendor(payload){
    return $axios.$post(`/backend/api/web/follow_vendor`, payload)
  },
  createPayoutRequest(payload) {
    return $axios.$post(`/backend/api/vendor/createPayoutRequest`, payload)
  },
  coupons() {
    return $axios.$get(`/backend/api/web/fetch_coupons`)
  },
  featuredCategories() {
    return $axios.$get(`/backend/api/web/featured_category`)
  },
  trendingProducts() {
    return $axios.$get(`/backend/api/web/trending_products_web`)
  },
})
