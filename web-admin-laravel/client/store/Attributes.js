
const attributes = [];
const state = () => ({
  attributes: attributes ? attributes : null ,
  status: attributes ?
     { fetched: true }:{}
})
const getters = {
  allAttributes: state => state.attributes,
}

const actions = {
   async fetchAttributes({ commit }) {
     commit('fetchAttributes',attributes);
     return await this.$repositories.attributes.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchAttributesFailure',  response.error);
           }
           else if(response.attributes){
             commit('fetchAttributesSuccess', response.attributes);
           }
           return response
         },
         error => {
             commit('fetchAttributesFailure', error);
         }
     );
  },
  async addAttributes({ commit }, requestParams) {
   commit('addAttributeRequest',attributes);
   return await this.$repositories.attributes.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addAttributeFailure',  response.data.error);
         }
         else{
           commit('addAttributeSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addAttributeFailure',  e.response.data);
     return e
   });
},
async updateAttributes({ commit }, {formData,id}) {
   commit('updateAttributeRequest',attributes);
    return await this.$repositories.attributes.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateAttributeFailure',  'Some Error OCcured');
         }
         else{
           commit('updateAttributeSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateAttributeFailure',  e.response.data);
     return e
   });
},
  async filterAttributes({ commit }, requestParams) {
    return await this.$repositories.attributes.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterAttributesFailure',  response.error);
          }
          else if(response.attributes){
            commit('filterAttributesSuccess', response.attributes);
          }
          return response
        },
        error => {
            commit('fetchAttributesFailure', error);
            return
        }
    );
  },
  async deleteAttributes({ dispatch, commit, state }, {filterData,attribute_id}) {
     return await this.$repositories.attributes.delete(filterData,attribute_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteAttributeFailure',  state.message);
           }
           else if(response.attributes){
             commit('deleteAttributeSuccess', response.attributes);
           }
           return response
         },
     );
     error => {
          commit('deleteAttributeFailure',  state.message);
         return
     }
  },

  async updateAttributeStatus({ commit }, {filterData,attribute_id}) {
  return await this.$repositories.attributes.updateStatus(filterData,attribute_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateAttributeStatusFailure',  response.message);
        }
        else if(response.attributes){
          commit('updateAttributeStatusSuccess', response.attributes);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchAttributes(state, attributes) {
      state.status = { fetching: true };
      state.attributes = attributes;
  },
  fetchAttributesSuccess(state, attributes) {
      state.status = { fetched: true };
      state.attributes = attributes;
  },
  fetchAttributesFailure(state) {
      state.status = {};
      state.attributes = null;
  },
  addAttributeRequest(state, images) {
    state.status = { adding: true };
},
addAttributeSuccess(state) {
  // state.attributes = attributes;
  state.status = { added: true };
},
addAttributeFailure(state) {
    state.status = {};
},
updateAttributeRequest(state, attributes) {
    state.status = { updating: true };
},
updateAttributeSuccess(state) {
  state.status = { updated: true };
},
updateAttributeFailure(state) {
    state.status = {};
},
  deleteAttributeRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteAttributeSuccess(state, attributes) {
    state.attributes = attributes;
    state.status = { deleted: true };
  },
  deleteAttributeFailure(state) {
      state.status = {deleted: false};
  },
  filterAttributesSuccess(state, attributes) {
      state.status = { filtered: true };
      state.attributes = attributes;
  },
  filterAttributesFailure(state) {
      state.status = {};
  },
  updateAttributeStatusSuccess(state, attributes) {
      state.status = { fetched: true };
      state.attributes = attributes;
  },
  updateAttributeStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
