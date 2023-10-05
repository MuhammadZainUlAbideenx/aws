<template>
  <section class="collect-voucher skeletion-effect" v-if="$fetchState.pending">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-heading d-flex justify-content-center w-25 skeletion-animation text"></h2>
                    <p class="section-subheading skeletion-animation litext"></p>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <div class="p-3 d-flex justify-content-between align-items-center rounded skeletion-animation">
                        <span class="d-flex justify-content-center align-items-center text-center thumb-img fw-bold skeletion-animation" ></span>
                        <div class="coupon-description">
                            <span class="skeletion-animation text"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <div class="p-3 d-flex justify-content-between align-items-center rounded skeletion-animation">
                        <span class="d-flex justify-content-center align-items-center text-center thumb-img fw-bold skeletion-animation" ></span>
                        <div class="coupon-description">
                            <span class="skeletion-animation text"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <div class="p-3 d-flex justify-content-between align-items-center rounded skeletion-animation">
                        <span class="d-flex justify-content-center align-items-center text-center thumb-img fw-bold skeletion-animation" ></span>
                        <div class="coupon-description">
                            <span class="skeletion-animation text"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <div class="p-3 d-flex justify-content-between align-items-center rounded skeletion-animation">
                        <span class="d-flex justify-content-center align-items-center text-center thumb-img fw-bold skeletion-animation" ></span>
                        <div class="coupon-description">
                            <span class="skeletion-animation text"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <section class="collect-voucher" v-else>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="section-heading mb-30 mt-0 fadin">
            {{ this.$t("web.home.coupons.heading.collect")
            }} {{ this.$t("web.home.coupons.heading.coupons") }}
          </h2>
          <p class="section-subheading mb-0 fadin">
            {{ this.$t("web.home.coupons.description") }}
          </p>
        </div>
          <div class="saleoff mt-50">
                <div class="container">
                    <div class="row" v-if="allCoupons && allCoupons.length > 0">
                        <div class="col-lg-6 col-xl-3 col-md-6 mb-3 mb-xl-0 fadin" v-for="(coupon,index) in allCoupons" :key="index">
                           <a href="javascript:void(0)" v-on:click="collectCoupons(coupon.code)" class="text-dark">
                             <div :class="[ (index == 0 ? 'bg-pink-light' : ''), (index == 1 ? 'bg-yellow-light' : ''), (index == 2 ? 'bg-blue-light-50' : ''), (index == 3 ? 'bg-purple-light' : '') ]" class="p-3 card flex-row border-0 justify-content-between align-items-center rounded">
                                <span :class="[ (index == 0 ? 'bg-pink-dark' : ''), (index == 1 ? 'bg-yellow-dark' : ''), (index == 2 ? 'bg-blue-dark-50' : ''), (index == 3 ? 'bg-purple-dark' : '') ]" class="d-flex justify-content-center align-items-center text-center fw-bold"  v-if="coupon.discount_type == 1" >{{coupon.amount_with_currency}} {{$t('off')}}</span>
                                <span class="d-flex justify-content-center align-items-center text-center fw-bold" :class="[ (index == 0 ? 'bg-pink-dark' : ''), (index == 1 ? 'bg-yellow-dark' : ''), (index == 2 ? 'bg-blue-dark-50' : ''), (index == 3 ? 'bg-purple-dark' : '') ]" v-if="coupon.discount_type == 2" >{{coupon.amount}}% {{$t('off')}}</span>
                                <div class="coupon-description">
                                <span v-html="coupon.description"></span>
                                </div>
                            </div>
                           </a>
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
