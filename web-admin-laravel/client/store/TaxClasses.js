
const tax_classes = [];
const state = () => ({
  tax_classes: tax_classes ? tax_classes : null ,
  status: tax_classes ?
     { fetched: true }:{}
})
const getters = {
  allTaxClasses: state => state.tax_classes,
}

const actions = {
   async fetchTaxClasses({ commit }) {
     commit('fetchTaxClasses',tax_classes);
     return await this.$repositories.tax_classes.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchTaxClassesFailure',  response.error);
           }
           else if(response.tax_classes){
             commit('fetchTaxClassesSuccess', response.tax_classes);
           }
           return response
         },
         error => {
             commit('fetchTaxClassesFailure', error);
         }
     );
  },
  async addTaxClasses({ commit }, requestParams) {
   commit('addTaxClassRequest',tax_classes);
   return await this.$repositories.tax_classes.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addTaxClassFailure',  response.data.error);
         }
         else{
           commit('addTaxClassSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addTaxClassFailure',  e.response.data);
     return e
   });
},
async updateTaxClasses({ commit }, {formData,id}) {
   commit('updateTaxClassRequest',tax_classes);
    return await this.$repositories.tax_classes.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateTaxClassFailure',  'Some Error OCcured');
         }
         else{
           commit('updateTaxClassSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateTaxClassFailure',  e.response.data);
     return e
   });
},
  async filterTaxClasses({ commit }, requestParams) {
    return await this.$repositories.tax_classes.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterTaxClassesFailure',  response.error);
          }
          else if(response.tax_classes){
            commit('filterTaxClassesSuccess', response.tax_classes);
          }
          return response
        },
        error => {
            commit('fetchTaxClassesFailure', error);
            return
        }
    );
  },
  async deleteTaxClasses({ dispatch, commit, state }, {filterData,tax_class_id}) {
     return await this.$repositories.tax_classes.delete(filterData,tax_class_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteTaxClassFailure',  state.message);
           }
           else if(response.tax_classes){
             commit('deleteTaxClassSuccess', response.tax_classes);
           }
           return response
         },
     );
     error => {
          commit('deleteTaxClassFailure',  state.message);
         return
     }
  },

  async updateTaxClassStatus({ commit }, {filterData,tax_class_id}) {
  return await this.$repositories.tax_classes.updateStatus(filterData,tax_class_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateTaxClassStatusFailure',  response.message);
        }
        else if(response.tax_classes){
          commit('updateTaxClassStatusSuccess', response.tax_classes);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchTaxClasses(state, tax_classes) {
      state.status = { fetching: true };
      state.tax_classes = tax_classes;
  },
  fetchTaxClassesSuccess(state, tax_classes) {
      state.status = { fetched: true };
      state.tax_classes = tax_classes;
  },
  fetchTaxClassesFailure(state) {
      state.status = {};
      state.tax_classes = null;
  },
  addTaxClassRequest(state, images) {
    state.status = { adding: true };
},
addTaxClassSuccess(state) {
  // state.tax_classes = tax_classes;
  state.status = { added: true };
},
addTaxClassFailure(state) {
    state.status = {};
},
updateTaxClassRequest(state, tax_classes) {
    state.status = { updating: true };
},
updateTaxClassSuccess(state) {
  state.status = { updated: true };
},
updateTaxClassFailure(state) {
    state.status = {};
},
  deleteTaxClassRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteTaxClassSuccess(state, tax_classes) {
    state.tax_classes = tax_classes;
    state.status = { deleted: true };
  },
  deleteTaxClassFailure(state) {
      state.status = {deleted: false};
  },
  filterTaxClassesSuccess(state, tax_classes) {
      state.status = { filtered: true };
      state.tax_classes = tax_classes;
  },
  filterTaxClassesFailure(state) {
      state.status = {};
  },
  updateTaxClassStatusSuccess(state, tax_classes) {
      state.status = { fetched: true };
      state.tax_classes = tax_classes;
  },
  updateTaxClassStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
