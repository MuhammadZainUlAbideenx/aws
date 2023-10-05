
const about_us = [];
const state = () => ({
  about_us: about_us ? about_us : null ,
  status: about_us ?
     { fetched: true }:{}
})
const getters = {
  allAboutUs: state => state.about_us,
}

const actions = {
   async fetchAboutUs({ commit }) {
     commit('fetchAboutUs',about_us);
     return await this.$repositories.about_us.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchAboutUsFailure',  response.error);
           }
           else if(response.about_us){
             commit('fetchAboutUsSuccess', response.about_us);
           }
           return response
         },
         error => {
             commit('fetchAboutUsFailure', error);
         }
     );
  },
  async addAboutUs({ commit }, requestParams) {
   commit('addAboutUsRequest',about_us);
   return await this.$repositories.about_us.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addAboutUsFailure',  response.data.error);
         }
         else{
           commit('addAboutUsSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addAboutUsFailure',  e.response.data);
     return e
   });
},
};

const mutations = {
  fetchAboutUs(state, about_us) {
      state.status = { fetching: true };
      state.about_us = about_us;
  },
  fetchAboutUsSuccess(state, about_us) {
      state.status = { fetched: true };
      state.about_us = about_us;
  },
  fetchAboutUsFailure(state) {
      state.status = {};
      state.about_us = null;
  },
  addAboutUsRequest(state, images) {
    state.status = { adding: true };
},
addAboutUsSuccess(state) {
  // state.about_us = about_us;
  state.status = { added: true };
},
addAboutUsFailure(state) {
    state.status = {};
},
}

export default {
  state,
  actions,
  mutations,
  getters
};
