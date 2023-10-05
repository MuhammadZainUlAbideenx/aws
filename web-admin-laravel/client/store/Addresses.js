
const addresses = [];
const state = () => ({
  addresses: addresses ? addresses : null ,
  status: addresses ?
     { fetched: true }:{}
})
const getters = {
  allAddresses: state => state.addresses,
}

const actions = {
   async fetchAddresses({ commit } ,id) {
     commit('fetchAddresses',addresses);
     return await this.$repositories.addresses.addresses_index(id)
     .then(
         response => {
           if(response.status)
           {
             commit('fetchAddressesFailure',  response.error);
           }
           else if(response.addresses){
             commit('fetchAddressesSuccess', response.addresses);
           }
           return response
         },
         error => {
             commit('fetchAddressesFailure', error);
         }
     );
  },
  async addAddresses({ commit }, requestParams) {
   commit('addAddressRequest',addresses);
   return await this.$repositories.addresses.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addAddressFailure',  response.data.error);
         }
         else{
           commit('addAddressSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addAddressFailure',  e.response.data);
     return e
   });
},
async updateAddresses({ commit }, {formData,id}) {
   commit('updateAddressRequest',addresses);
    return await this.$repositories.addresses.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateAddressFailure',  'Some Error OCcured');
         }
         else{
           commit('updateAddressSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateAddressFailure',  e.response.data);
     return e
   });
},
  async filterAddresses({ commit }, requestParams) {
    return await this.$repositories.addresses.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterAddressesFailure',  response.error);
          }
          else if(response.addresses){
            commit('filterAddressesSuccess', response.addresses);
          }
          return response
        },
        error => {
            commit('fetchAddressesFailure', error);
            return
        }
    );
  },
  async deleteAddresses({ dispatch, commit, state }, {filterData,address_id}) {
     return await this.$repositories.addresses.delete(filterData,address_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteAddressFailure',  state.message);
           }
           else if(response.addresses){
             commit('deleteAddressSuccess', response.addresses);
           }
           return response
         },
     );
     error => {
          commit('deleteAddressFailure',  state.message);
         return
     }
  },

  async updateAddressStatus({ commit }, {filterData,address_id}) {
  return await this.$repositories.addresses.updateStatus(filterData,address_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateAddressStatusFailure',  response.message);
        }
        else if(response.addresses){
          commit('updateAddressStatusSuccess', response.addresses);
        }
        return response

      },
    );
  },
  async updateAddressIsDefault({ commit }, {filterData,address_id}) {
  return await this.$repositories.addresses.updateIsDefault(filterData,address_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateAddressIsDefaultFailure',  response.error);
        }
        else if(response.addresses){
          commit('updateAddressIsDefaultSuccess', response.addresses);
        }
        return response
      },
    );
  },

};

const mutations = {
  fetchAddresses(state, addresses) {
      state.status = { fetching: true };
      state.addresses = addresses;
  },
  fetchAddressesSuccess(state, addresses) {
      state.status = { fetched: true };
      state.addresses = addresses;
  },
  fetchAddressesFailure(state) {
      state.status = {};
      state.addresses = null;
  },
  addAddressRequest(state, images) {
    state.status = { adding: true };
},
addAddressSuccess(state) {
  // state.addresses = addresses;
  state.status = { added: true };
},
addAddressFailure(state) {
    state.status = {};
},
updateAddressRequest(state, addresses) {
    state.status = { updating: true };
},
updateAddressSuccess(state) {
  state.status = { updated: true };
},
updateAddressFailure(state) {
    state.status = {};
},
  deleteAddressRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteAddressSuccess(state, addresses) {
    state.addresses = addresses;
    state.status = { deleted: true };
  },
  deleteAddressFailure(state) {
      state.status = {deleted: false};
  },
  filterAddressesSuccess(state, addresses) {
      state.status = { filtered: true };
      state.addresses = addresses;
  },
  filterAddressesFailure(state) {
      state.status = {};
  },
  updateAddressStatusSuccess(state, addresses) {
      state.status = { fetched: true };
      state.addresses = addresses;
  },
  updateAddressStatusFailure(state) {
      state.status = { update_status: false};
  },
  updateAddressIsDefaultSuccess(state, addresses) {
      state.status = { fetched: true };
      state.addresses = addresses;
  },
  updateAddressIsDefaultFailure(state) {
      state.status = {update_default: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
