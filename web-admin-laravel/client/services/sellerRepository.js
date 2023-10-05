import fileDownload from 'js-file-download';

export default $axios => resource => ({
  index() {
    return $axios.$get(`/backend/api/vendor/${resource}`)
  },
  addresses_index(id) {
    return $axios.$get(`/backend/api/vendor/${resource}/customer/${id}`)
  },
  create(payload) {
    return $axios.$post(`/backend/api/vendor/${resource}`, payload)
  },
  export(payload) {
    return $axios.$post(`/backend/api/vendor/${resource}/export`,payload, {
       responseType: "blob"
  })
  .then((response) => {
    const filename = resource +"." + payload.export
    fileDownload(response,filename);
  });
  },
  show(id) {
    return $axios.$get(`/backend/api/vendor/${resource}/${id}`)
  },
  filter(payload) {
    return $axios.$post(`/backend/api/vendor/${resource}/filter`, payload)
  },
  update(payload, id) {
    return $axios.$put(`/backend/api/vendor/${resource}/${id}`, payload)
  },
  updateMedia(payload, id) {
    return $axios.$put(`/backend/api/vendor/${resource}Media/${id}`, payload)
  },
  updateAttribute(payload, id) {
    return $axios.$put(`/backend/api/vendor/${resource}Attribute/${id}`, payload)
  },
  addAttribute(payload, id) {
    return $axios.$post(`/backend/api/vendor/${resource}Attribute/${id}`, payload)
  },
  updateStatus(payload,id) {
    return $axios.$put(`/backend/api/vendor/${resource}/updateStatus/${id}`,payload)
  },
  updateIsDefault(payload,id) {
    return $axios.$put(`/backend/api/vendor/${resource}/updateDefault/${id}`,payload)
  },

  delete(payload,id) {
    return $axios.$delete(`/backend/api/vendor/${resource}/${id}`,{data:{...payload}})
  },
  deleteAttribute(product_id,combination_id){
    return $axios.$delete(`/backend/api/vendor/${resource}DeleteAttribute/${product_id}/${combination_id}`)
  }

})
