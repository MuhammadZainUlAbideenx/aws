export default $axios => ({
fetchMedia(params) {
  return $axios.$get(`/backend/api/admin/fetchMedia`,{params})
},
fetchSingleMedia(id) {
  return $axios.$get(`/backend/api/admin/fetchMedia/${id}`)
},
deleteMedia(id) {
  return $axios.$get(`/backend/api/admin/deleteMedia/${id}`)
},
filter(payload) {
    return $axios.$post(`/backend/api/admin/filterMedia`, payload)
  },
addMedia() {
  return $axios.$get(`/backend/api/admin/addMedia`)
}
})
