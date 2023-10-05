
const attribute_values = [];
const state = () => ({
  attribute_values: attribute_values ? attribute_values : null ,
  status: attribute_values ?
     { fetched: true }:{}
})
const getters = {
  allAttributeValues: state => state.attribute_values,
}

const actions = {
   async fetchAttributeValues({ commit }) {
     commit('fetchAttributeValues',attribute_values);
     return await this.$repositories.attribute_values.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchAttributeValuesFailure',  response.error);
           }
           else if(response.attribute_values){
             commit('fetchAttributeValuesSuccess', response.attribute_values);
           }
           return response
         },
         error => {
             commit('fetchAttributeValuesFailure', error);
         }
     );
  },
  async addAttributeValues({ commit }, requestParams) {
   commit('addAttributeRequest',attribute_values);
   return await this.$repositories.attribute_values.create(requestParams)
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
async updateAttributeValues({ commit }, {formData,id}) {
   commit('updateAttributeRequest',attribute_values);
    return await this.$repositories.attribute_values.update(formData,id)
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
  async filterAttributeValues({ commit }, requestParams) {
    return await this.$repositories.attribute_values.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterAttributeValuesFailure',  response.error);
          }
          else if(response.attribute_values){
            commit('filterAttributeValuesSuccess', response.attribute_values);
          }
          return response
        },
        error => {
            commit('fetchAttributeValuesFailure', error);
            return
        }
    );
  },
  async deleteAttributeValues({ dispatch, commit, state }, {filterData,attribute_id}) {
     return await this.$repositories.attribute_values.delete(filterData,attribute_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteAttributeFailure',  state.message);
           }
           else if(response.attribute_values){
             commit('deleteAttributeSuccess', response.attribute_values);
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
  return await this.$repositories.attribute_values.updateStatus(filterData,attribute_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateAttributeStatusFailure',  response.message);
        }
        else if(response.attribute_values){
          commit('updateAttributeStatusSuccess', response.attribute_values);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchAttributeValues(state, attribute_values) {
      state.status = { fetching: true };
      state.attribute_values = attribute_values;
  },
  fetchAttributeValuesSuccess(state, attribute_values) {
      state.status = { fetched: true };
      state.attribute_values = attribute_values;
  },
  fetchAttributeValuesFailure(state) {
      state.status = {};
      state.attribute_values = null;
  },
  addAttributeRequest(state, images) {
    state.status = { adding: true };
},
addAttributeSuccess(state) {
  // state.attribute_values = attribute_values;
  state.status = { added: true };
},
addAttributeFailure(state) {
    state.status = {};
},
updateAttributeRequest(state, attribute_values) {
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
  deleteAttributeSuccess(state, attribute_values) {
    state.attribute_values = attribute_values;
    state.status = { deleted: true };
  },
  deleteAttributeFailure(state) {
      state.status = {deleted: false};
  },
  filterAttributeValuesSuccess(state, attribute_values) {
      state.status = { filtered: true };
      state.attribute_values = attribute_values;
  },
  filterAttributeValuesFailure(state) {
      state.status = {};
  },
  updateAttributeStatusSuccess(state, attribute_values) {
      state.status = { fetched: true };
      state.attribute_values = attribute_values;
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
