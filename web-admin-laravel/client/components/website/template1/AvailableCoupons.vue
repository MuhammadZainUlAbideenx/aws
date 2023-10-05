<template>
  <section class="collect-voucher skeletion-effect" v-if="$fetchState.pending">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-heading skeletion-animation text"></h2>
                    <p class="section-subheading skeletion-animation litext"></p>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 mb-3 mb-xl-0"><div class="skeletion-animation text"></div></div>
                <div class="col-lg-6 col-xl-3 col-md-6 mb-3 mb-xl-0"><div class="skeletion-animation"></div></div>
                <div class="col-lg-6 col-xl-3 col-md-6 mb-3 mb-xl-0"><div class="skeletion-animation litext"></div></div>
                <div class="col-lg-6 col-xl-3 col-md-6 mb-3 mb-xl-0"><div class="skeletion-animation litext"></div></div>
            </div>
        </div>
    </section>
  <section class="collect-voucher" v-else>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <h2 class="section-heading">
            {{ this.$t("web.home.coupons.heading.collect")
            }}<span>{{ this.$t("web.home.coupons.heading.coupons") }}</span>
          </h2>
          <p class="section-subheading">
            {{ this.$t("web.home.coupons.description") }}
          </p>
        </div>
        <div class="row" v-if="allCoupons && allCoupons.length > 0">
             <div class="col-lg-6 col-xl-3 col-md-6 mb-3 mb-xl-0" v-for="(coupon,index) in allCoupons" :key="index">
                    <div :class="[ (index == 0 ? 'bg-voucher-pink' : ''), (index == 1 ? 'bg-voucher-warning' : ''), (index == 2 ? 'bg-voucher-blue' : ''), (index == 3 ? 'bg-voucher-red' : '') ]" class="voucher-section w-100 p-2 rounded">
                        <div class="h-100 w-100 border-2 border-white py-2 px-3 rounded d-flex align-items-center justify-content-between">
                            <h3 v-if="coupon.discount_type == 1" class="fs-5 fw-normal text-white">{{$t('spend')}}: {{coupon.minimum_spend_with_currency}} <br>{{$t('and_get')}} {{coupon.amount_with_currency}} {{$t('off')}}</h3>
                            <h3 v-if="coupon.discount_type == 2" class="fs-5 fw-normal text-white">{{$t('spend')}}: {{coupon.minimum_spend_with_currency}} <br>{{$t('and_get')}} {{coupon.amount}}% {{$t('off')}}</h3>
                            <span class="mb-auto">
                                <button type="button" class="btn border-0 bg-white rounded-1 mt-1 fw-bold text-info btn-voucher" v-on:click="collectCoupons(coupon.code)" >{{$t('collect')}}</button>
                            </span>
                        </div>
                    </div>
          </div>

        </div>

      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  async fetch() {
    if (!this.allCoupons) {
      await this.fetchCoupons();
    }
  },
  methods: {
    ...mapActions({
      fetchCoupons: "Web/General/fetchCoupons",
    }),
    collectCoupons(coupon_code)
    {

        localStorage.removeItem("coupon_applied");
        if (process.client) {
            localStorage.setItem("coupon_applied", coupon_code);
            this.$toast.success("Coupon is Collected");
        }
    }
  },
  computed: {
    ...mapGetters({
      allCoupons: "Web/General/allCoupons",
    }),
  },
};
</script>

<style>
</style>
