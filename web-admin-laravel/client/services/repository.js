import fileDownload from 'js-file-download';

export default $axios => resource => ({
  index() {
    return $axios.$get(`/backend/api/admin/${resource}`)
  },
  addresses_index(id) {
    return $axios.$get(`/backend/api/admin/${resource}/customer/${id}`)
  },
  create(payload) {
    return $axios.$post(`/backend/api/admin/${resource}`, payload)
  },
  export(payload) {
    return $axios.$post(`/backend/api/admin/${resource}/export`,payload, {
       responseType: "blob"
  })
  .then((response) => {
    const filename = resource +"." + payload.export
    fileDownload(response,filename);
  });
  },
  show(id) {
    return $axios.$get(`/backend/api/admin/${resource}/${id}`)
  },
  filter(payload) {
    return $axios.$post(`/backend/api/admin/${resource}/filter`, payload)
  },
  update(payload, id) {
    return $axios.$put(`/backend/api/admin/${resource}/${id}`, payload)
  },
  updateMedia(payload, id) {
    return $axios.$put(`/backend/api/admin/${resource}Media/${id}`, payload)
  },
  updateAttribute(payload, id) {
    return $axios.$put(`/backend/api/admin/${resource}Attribute/${id}`, payload)
  },
  addAttribute(payload, id) {
    return $axios.$post(`/backend/api/admin/${resource}Attribute/${id}`, payload)
  },
  updateStatus(payload,id) {
    return $axios.$put(`/backend/api/admin/${resource}/updateStatus/${id}`,payload)
  },
  updateIsDefault(payload,id) {
    return $axios.$put(`/backend/api/admin/${resource}/updateDefault/${id}`,payload)
  },

  delete(payload,id) {
    return $axios.$delete(`/backend/api/admin/${resource}/${id}`,{data:{...payload}})
  },
  deleteAttribute(product_id,combination_id){
    return $axios.$delete(`/backend/api/admin/${resource}DeleteAttribute/${product_id}/${combination_id}`)
  }

})
