
const faqs = [];
const state = () => ({
  faqs: faqs ? faqs : null ,
  status: faqs ?
     { fetched: true }:{}
})
const getters = {
  allFaqs: state => state.faqs,
}

const actions = {
   async fetchFaqs({ commit }) {
     commit('fetchFaqs',faqs);
     return await this.$repositories.faqs.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchFaqsFailure',  response.error);
           }
           else if(response.faqs){
             commit('fetchFaqsSuccess', response.faqs);
           }
           return response
         },
         error => {
             commit('fetchFaqsFailure', error);
         }
     );
  },
  async addFaqs({ commit }, requestParams) {
   commit('addFaqRequest',faqs);
   return await this.$repositories.faqs.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addFaqFailure',  response.data.error);
         }
         else{
           commit('addFaqSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addFaqFailure',  e.response.data);
     return e
   });
},
async updateFaqs({ commit }, {formData,id}) {
   commit('updateFaqRequest',faqs);
    return await this.$repositories.faqs.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateFaqFailure',  'Some Error OCcured');
         }
         else{
           commit('updateFaqSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateFaqFailure',  e.response.data);
     return e
   });
},
  async filterFaqs({ commit }, requestParams) {
    return await this.$repositories.faqs.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterFaqsFailure',  response.error);
          }
          else if(response.faqs){
            commit('filterFaqsSuccess', response.faqs);
          }
          return response
        },
        error => {
            commit('fetchFaqsFailure', error);
            return
        }
    );
  },
  async deleteFaqs({ dispatch, commit, state }, {filterData,faqs_id}) {
     return await this.$repositories.faqs.delete(filterData,faqs_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteFaqFailure',  state.message);
           }
           else if(response.faqs){
             commit('deleteFaqSuccess', response.faqs);
           }
           return response
         },
     );
     error => {
          commit('deleteFaqFailure',  state.message);
         return
     }
  },

  async updateFaqStatus({ commit }, {filterData,faqs_id}) {
  return await this.$repositories.faqs.updateStatus(filterData,faqs_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateFaqStatusFailure',  response.message);
        }
        else if(response.faqs){
          commit('updateFaqStatusSuccess', response.faqs);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchFaqs(state, faqs) {
      state.status = { fetching: true };
      state.faqs = faqs;
  },
  fetchFaqsSuccess(state, faqs) {
      state.status = { fetched: true };
      state.faqs = faqs;
  },
  fetchFaqsFailure(state) {
      state.status = {};
      state.faqs = null;
  },
  addFaqRequest(state, images) {
    state.status = { adding: true };
},
addFaqSuccess(state) {
  // state.faqs = faqs;
  state.status = { added: true };
},
addFaqFailure(state) {
    state.status = {};
},
updateFaqRequest(state, faqs) {
    state.status = { updating: true };
},
updateFaqSuccess(state) {
  state.status = { updated: true };
},
updateFaqFailure(state) {
    state.status = {};
},
  deleteFaqRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteFaqSuccess(state, faqs) {
    state.faqs = faqs;
    state.status = { deleted: true };
  },
  deleteFaqFailure(state) {
      state.status = {deleted: false};
  },
  filterFaqsSuccess(state, faqs) {
      state.status = { filtered: true };
      state.faqs = faqs;
  },
  filterFaqsFailure(state) {
      state.status = {};
  },
  updateFaqStatusSuccess(state, faqs) {
      state.status = { fetched: true };
      state.faqs = faqs;
  },
  updateFaqStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
