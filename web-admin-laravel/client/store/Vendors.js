
const vendors = [];
const state = () => ({
  vendors: vendors ? vendors : null ,
  status: vendors ?
     { fetched: true }:{}
})
const getters = {
  allVendors: state => state.vendors,
}

const actions = {
   async fetchVendors({ commit }) {
     commit('fetchVendors',vendors);
     return await this.$repositories.vendors.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchVendorsFailure',  response.error);
           }
           else if(response.vendors){
             commit('fetchVendorsSuccess', response.vendors);
           }
           return response
         },
         error => {
             commit('fetchVendorsFailure', error);
         }
     );
  },
  async addVendors({ commit }, requestParams) {
   commit('addVendorRequest',vendors);
   return await this.$repositories.vendors.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addVendorFailure',  response.data.error);
         }
         else{
           commit('addVendorSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addVendorFailure',  e.response.data);
     return e
   });
},
async updateVendors({ commit }, {formData,id}) {
   commit('updateVendorRequest',vendors);
    return await this.$repositories.vendors.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateVendorFailure',  'Some Error OCcured');
         }
         else{
           commit('updateVendorSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateVendorFailure',  e.response.data);
     return e
   });
},
  async filterVendors({ commit }, requestParams) {
    return await this.$repositories.vendors.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterVendorsFailure',  response.error);
          }
          else if(response.vendors){
            commit('filterVendorsSuccess', response.vendors);
          }
          return response
        },
        error => {
            commit('fetchVendorsFailure', error);
            return
        }
    );
  },
  async deleteVendors({ dispatch, commit, state }, {filterData,vendor_id}) {
     return await this.$repositories.vendors.delete(filterData,vendor_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteVendorFailure',  state.message);
           }
           else if(response.vendors){
             commit('deleteVendorSuccess', response.vendors);
           }
           return response
         },
     );
     error => {
          commit('deleteVendorFailure',  state.message);
         return
     }
  },

  async updateVendorStatus({ commit }, {filterData,vendor_id}) {
  return await this.$repositories.vendors.updateStatus(filterData,vendor_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateVendorStatusFailure',  response.message);
        }
        else if(response.vendors){
          commit('updateVendorStatusSuccess', response.vendors);
        }
        return response

      },
    );
  },
  async updateVendorStoreStatus({ commit }, {filterData,vendor_id}) {
    return await this.$generalService.updateVendorStoreStatus(filterData,vendor_id)
      .then(
        response => {
          if(response.state == 'fail')
          {
            commit('updateVendorStoreStatusFailure',  response.message);
          }
          else if(response.vendors){
            commit('updateVendorStoreStatusSuccess', response.vendors);
          }
          return response

        },
      );
    },
    async updateVendorFeatured({ commit }, {filterData,vendor_id}) {
        return await this.$generalService.updateVendorFeatured(filterData,vendor_id)
          .then(
            response => {
              if(response.state == 'fail')
              {
                commit('updateVendorStoreStatusFailure',  response.message);
              }
              else if(response.vendors){
                commit('updateVendorStoreStatusSuccess', response.vendors);
              }
              return response

            },
          );
        },

};

const mutations = {
  fetchVendors(state, vendors) {
      state.status = { fetching: true };
      state.vendors = vendors;
  },
  fetchVendorsSuccess(state, vendors) {
      state.status = { fetched: true };
      state.vendors = vendors;
  },
  fetchVendorsFailure(state) {
      state.status = {};
      state.vendors = null;
  },
  addVendorRequest(state, images) {
    state.status = { adding: true };
},
addVendorSuccess(state) {
  // state.vendors = vendors;
  state.status = { added: true };
},
addVendorFailure(state) {
    state.status = {};
},
updateVendorRequest(state, vendors) {
    state.status = { updating: true };
},
updateVendorSuccess(state) {
  state.status = { updated: true };
},
updateVendorFailure(state) {
    state.status = {};
},
  deleteVendorRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteVendorSuccess(state, vendors) {
    state.vendors = vendors;
    state.status = { deleted: true };
  },
  deleteVendorFailure(state) {
      state.status = {deleted: false};
  },
  filterVendorsSuccess(state, vendors) {
      state.status = { filtered: true };
      state.vendors = vendors;
  },
  filterVendorsFailure(state) {
      state.status = {};
  },
  updateVendorStatusSuccess(state, vendors) {
      state.status = { fetched: true };
      state.vendors = vendors;
  },
  updateVendorStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateVendorStoreStatusSuccess(state, vendors) {
    state.status = { fetched: true };
    state.vendors = vendors;
},
updateVendorStoreStatusFailure(state) {
    state.status = { update_status: false};
},
updateVendorFeaturedSuccess(state, vendors) {
    state.status = { fetched: true };
    state.vendors = vendors;
},
updateVendorFeaturedFailure(state) {
    state.status = { update_status: false};
},
}

export default {
  state,
  actions,
  mutations,
  getters
};
