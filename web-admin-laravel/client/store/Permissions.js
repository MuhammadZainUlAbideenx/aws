
const permissions = [];
const state = () => ({
  permissions: permissions ? permissions : null ,
  status: permissions ?
     { fetched: true }:{}
})
const getters = {
  allPermissions: state => state.permissions,
}

const actions = {
   async fetchPermissions({ commit }) {
     commit('fetchPermissions',permissions);
     return await this.$repositories.permissions.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchPermissionsFailure',  response.error);
           }
           else if(response.permissions){
             commit('fetchPermissionsSuccess', response.permissions);
           }
           return response
         },
         error => {
             commit('fetchPermissionsFailure', error);
         }
     );
  },
  async addPermissions({ commit }, requestParams) {
   commit('addPermissionRequest',permissions);
   return await this.$repositories.permissions.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addPermissionFailure',  response.data.error);
         }
         else{
           commit('addPermissionSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addPermissionFailure',  e.response.data);
     return e
   });
},
async updatePermissions({ commit }, {formData,id}) {
   commit('updatePermissionRequest',permissions);
    return await this.$repositories.permissions.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updatePermissionFailure',  'Some Error OCcured');
         }
         else{
           commit('updatePermissionSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updatePermissionFailure',  e.response.data);
     return e
   });
},
  async filterPermissions({ commit }, requestParams) {
    return await this.$repositories.permissions.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterPermissionsFailure',  response.error);
          }
          else if(response.permissions){
            commit('filterPermissionsSuccess', response.permissions);
          }
          return response
        },
        error => {
            commit('fetchPermissionsFailure', error);
            return
        }
    );
  },
  async deletePermissions({ dispatch, commit, state }, {filterData,permission_id}) {
     return await this.$repositories.permissions.delete(filterData,permission_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deletePermissionFailure',  state.message);
           }
           else if(response.permissions){
             commit('deletePermissionSuccess', response.permissions);
           }
           return response
         },
     );
     error => {
          commit('deletePermissionFailure',  state.message);
         return
     }
  },

};

const mutations = {
  fetchPermissions(state, permissions) {
      state.status = { fetching: true };
      state.permissions = permissions;
  },
  fetchPermissionsSuccess(state, permissions) {
      state.status = { fetched: true };
      state.permissions = permissions;
  },
  fetchPermissionsFailure(state) {
      state.status = {};
      state.permissions = null;
  },
  addPermissionRequest(state, images) {
    state.status = { adding: true };
},
addPermissionSuccess(state) {
  // state.permissions = permissions;
  state.status = { added: true };
},
addPermissionFailure(state) {
    state.status = {};
},
updatePermissionRequest(state, permissions) {
    state.status = { updating: true };
},
updatePermissionSuccess(state) {
  state.status = { updated: true };
},
updatePermissionFailure(state) {
    state.status = {};
},
  deletePermissionRequest(state, images) {
      state.status = { deleting: true };
  },
  deletePermissionSuccess(state, permissions) {
    state.permissions = permissions;
    state.status = { deleted: true };
  },
  deletePermissionFailure(state) {
      state.status = {deleted: false};
  },
  filterPermissionsSuccess(state, permissions) {
      state.status = { filtered: true };
      state.permissions = permissions;
  },
  filterPermissionsFailure(state) {
      state.status = {};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
