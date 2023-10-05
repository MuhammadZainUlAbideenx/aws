
const contact_forms = [];
const state = () => ({
  contact_forms: contact_forms ? contact_forms : null ,
  status: contact_forms ?
     { fetched: true }:{}
})
const getters = {
  allContactForms: state => state.contact_forms,
}

const actions = {
   async fetchContactForms({ commit }) {
     commit('fetchContactForms',contact_forms);
     return await this.$repositories.contact_forms.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchContactFormsFailure',  response.error);
           }
           else if(response.contact_forms){
             commit('fetchContactFormsSuccess', response.contact_forms);
           }
           return response
         },
         error => {
             commit('fetchContactFormsFailure', error);
         }
     );
  },
  async addContactForms({ commit }, requestParams) {
   commit('addContactFormRequest',contact_forms);
   return await this.$repositories.contact_forms.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addContactFormFailure',  response.data.error);
         }
         else{
           commit('addContactFormSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addContactFormFailure',  e.response.data);
     return e
   });
},
async updateContactForms({ commit }, {formData,id}) {
   commit('updateContactFormRequest',contact_forms);
    return await this.$repositories.contact_forms.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateContactFormFailure',  'Some Error OCcured');
         }
         else{
           commit('updateContactFormSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateContactFormFailure',  e.response.data);
     return e
   });
},
  async filterContactForms({ commit }, requestParams) {
    return await this.$repositories.contact_forms.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterContactFormsFailure',  response.error);
          }
          else if(response.contact_forms){
            commit('filterContactFormsSuccess', response.contact_forms);
          }
          return response
        },
        error => {
            commit('fetchContactFormsFailure', error);
            return
        }
    );
  },
  async deleteContactForms({ dispatch, commit, state }, {filterData,contact_form_id}) {
     return await this.$repositories.contact_forms.delete(filterData,contact_form_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteContactFormFailure',  state.message);
           }
           else if(response.contact_forms){
             commit('deleteContactFormSuccess', response.contact_forms);
           }
           return response
         },
     );
     error => {
          commit('deleteContactFormFailure',  state.message);
         return
     }
  },

  async updateContactFormStatus({ commit }, {filterData,contact_form_id}) {
  return await this.$repositories.contact_forms.updateStatus(filterData,contact_form_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateContactFormStatusFailure',  response.message);
        }
        else if(response.contact_forms){
          commit('updateContactFormStatusSuccess', response.contact_forms);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchContactForms(state, contact_forms) {
      state.status = { fetching: true };
      state.contact_forms = contact_forms;
  },
  fetchContactFormsSuccess(state, contact_forms) {
      state.status = { fetched: true };
      state.contact_forms = contact_forms;
  },
  fetchContactFormsFailure(state) {
      state.status = {};
      state.contact_forms = null;
  },
  addContactFormRequest(state, images) {
    state.status = { adding: true };
},
addContactFormSuccess(state) {
  // state.contact_forms = contact_forms;
  state.status = { added: true };
},
addContactFormFailure(state) {
    state.status = {};
},
updateContactFormRequest(state, contact_forms) {
    state.status = { updating: true };
},
updateContactFormSuccess(state) {
  state.status = { updated: true };
},
updateContactFormFailure(state) {
    state.status = {};
},
  deleteContactFormRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteContactFormSuccess(state, contact_forms) {
    state.contact_forms = contact_forms;
    state.status = { deleted: true };
  },
  deleteContactFormFailure(state) {
      state.status = {deleted: false};
  },
  filterContactFormsSuccess(state, contact_forms) {
      state.status = { filtered: true };
      state.contact_forms = contact_forms;
  },
  filterContactFormsFailure(state) {
      state.status = {};
  },
  updateContactFormStatusSuccess(state, contact_forms) {
      state.status = { fetched: true };
      state.contact_forms = contact_forms;
  },
  updateContactFormStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
