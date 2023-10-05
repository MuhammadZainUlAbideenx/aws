
const coupons = [];
const state = () => ({
  coupons: coupons ? coupons : null ,
  status: coupons ?
     { fetched: true }:{}
})
const getters = {
  allCoupons: state => state.coupons,
}

const actions = {
   async fetchCoupons({ commit }) {
     commit('fetchCoupons',coupons);
     return await this.$repositories.coupons.index()
     .then(
         response => {
           if(response.status)
           {
             commit('fetchCouponsFailure',  response.error);
           }
           else if(response.coupons){
             commit('fetchCouponsSuccess', response.coupons);
           }
           return response
         },
         error => {
             commit('fetchCouponsFailure', error);
         }
     );
  },
  async addCoupons({ commit }, requestParams) {
   commit('addCouponRequest',coupons);
   return await this.$repositories.coupons.create(requestParams)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('addCouponFailure',  response.data.error);
         }
         else{
           commit('addCouponSuccess');
         }
         return response
       },
   )
   .catch((e) => {
     commit('addCouponFailure',  e.response.data);
     return e
   });
},
async updateCoupons({ commit }, {formData,id}) {
   commit('updateCouponRequest',coupons);
    return await this.$repositories.coupons.update(formData,id)
   .then(
       response => {
         if(response.state == 'fail' || response.status)
         {
           commit('updateCouponFailure',  'Some Error OCcured');
         }
         else{
           commit('updateCouponSuccess');
         }
         return response
       },
   )
   .catch((e)=>{
     commit('updateCouponFailure',  e.response.data);
     return e
   });
},
  async filterCoupons({ commit }, requestParams) {
    return await this.$repositories.coupons.filter(requestParams)
    .then(
        response => {
          if(response.state == 'fail')
          {
            commit('filterCouponsFailure',  response.error);
          }
          else if(response.coupons){
            commit('filterCouponsSuccess', response.coupons);
          }
          return response
        },
        error => {
            commit('fetchCouponsFailure', error);
            return
        }
    );
  },
  async deleteCoupons({ dispatch, commit, state }, {filterData,coupon_id}) {
     return await this.$repositories.coupons.delete(filterData,coupon_id)
     .then(
         response => {
           if(response.state == 'fail')
           {
             commit('deleteCouponFailure',  state.message);
           }
           else if(response.coupons){
             commit('deleteCouponSuccess', response.coupons);
           }
           return response
         },
     );
     error => {
          commit('deleteCouponFailure',  state.message);
         return
     }
  },

  async updateCouponStatus({ commit }, {filterData,coupon_id}) {
  return await this.$repositories.coupons.updateStatus(filterData,coupon_id)
    .then(
      response => {
        if(response.state == 'fail')
        {
          commit('updateCouponStatusFailure',  response.message);
        }
        else if(response.coupons){
          commit('updateCouponStatusSuccess', response.coupons);
        }
        return response

      },
    );
  },

};

const mutations = {
  fetchCoupons(state, coupons) {
      state.status = { fetching: true };
      state.coupons = coupons;
  },
  fetchCouponsSuccess(state, coupons) {
      state.status = { fetched: true };
      state.coupons = coupons;
  },
  fetchCouponsFailure(state) {
      state.status = {};
      state.coupons = null;
  },
  addCouponRequest(state, images) {
    state.status = { adding: true };
},
addCouponSuccess(state) {
  // state.coupons = coupons;
  state.status = { added: true };
},
addCouponFailure(state) {
    state.status = {};
},
updateCouponRequest(state, coupons) {
    state.status = { updating: true };
},
updateCouponSuccess(state) {
  state.status = { updated: true };
},
updateCouponFailure(state) {
    state.status = {};
},
  deleteCouponRequest(state, images) {
      state.status = { deleting: true };
  },
  deleteCouponSuccess(state, coupons) {
    state.coupons = coupons;
    state.status = { deleted: true };
  },
  deleteCouponFailure(state) {
      state.status = {deleted: false};
  },
  filterCouponsSuccess(state, coupons) {
      state.status = { filtered: true };
      state.coupons = coupons;
  },
  filterCouponsFailure(state) {
      state.status = {};
  },
  updateCouponStatusSuccess(state, coupons) {
      state.status = { fetched: true };
      state.coupons = coupons;
  },
  updateCouponStatusFailure(state) {
      state.status = { update_status: false};
  },
}

export default {
  state,
  actions,
  mutations,
  getters
};
