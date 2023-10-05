export default $axios => ({
  activeCountries(params) {
    return $axios.$get(`/backend/api/vendor/countriesActive`,{params})
  },
  activeStates(params) {
    return $axios.$get(`/backend/api/vendor/statesActive`,{params})
  },
  activeCities(params) {
    return $axios.$get(`/backend/api/vendor/citiesActive`,{params})
  },
  getStatesByCountry(id,params){
    return $axios.$get(`/backend/api/vendor/getStatesByCountry/${id}`,{params})
  },
  getCitiesByState(id,params){
    return $axios.$get(`/backend/api/vendor/getCitiesByState/${id}`,{params})
  },
  registerVendor(payload){
    return $axios.$post(`/backend/api/vendor/registerVendor`,payload)
  },
  forgotPassword(payload){
    return $axios.$post(`/backend/api/customer/auth/password/email`,payload)
  },
  resetPassword(payload){
    return $axios.$post(`/backend/api/customer/auth/password/reset`,payload)
  },
  customerProfileUpdate(payload){
    return $axios.$post(`/backend/api/vendor/customerProfileUpdate`,payload)
  },
  getVendorStore(){
    return $axios.$get(`/backend/api/vendor/getVendorStore`)
  },
  createOrUpdateVendorStore(payload){
    return $axios.$post(`/backend/api/vendor/createOrUpdateVendorStore`,payload)
  },
  updateVendorProfile(payload){
    return $axios.$post(`/backend/api/vendor/updateVendorProfile`,payload)
  },
  updateProfileImage(payload){
    return $axios.$post(`/backend/api/vendor/updateProfileImage`,payload)

  }
})
