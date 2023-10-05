<template>
    <!-- <section class="permotion-section skeletion-effect" v-if="!allGenericData">
        <div class="container">
            <div class="permote-wraper rounded text-white skeletion-animation text">
                <div class="row">
                    <div class="col-sm-3 justify-content-center d-flex"><div class="permote-card">
                        <div class="thumb-img skeletion-animation"></div>
                        <h5 class="mb-1 text-uppercase skeletion-animation"></h5>
                        <h6 class="m-0 opacity-5 skeletion-animation"></h6>
                    </div></div>
                    <div class="col-sm-3 justify-content-center d-flex"><div class="permote-card">
                        <div class="thumb-img skeletion-animation"></div>
                        <h5 class="mb-1 text-uppercase skeletion-animation"></h5>
                        <h6 class="m-0 opacity-5 skeletion-animation"></h6>
                    </div></div>
                    <div class="col-sm-3 justify-content-center d-flex"><div class="permote-card">
                        <div class="thumb-img skeletion-animation"></div>
                        <h5 class="mb-1 text-uppercase skeletion-animation"></h5>
                        <h6 class="m-0 opacity-5 skeletion-animation"></h6>
                    </div></div>
                    <div class="col-sm-3 justify-content-center d-flex"><div class="permote-card">
                        <div class="thumb-img skeletion-animation"></div>
                        <h5 class="mb-1 text-uppercase skeletion-animation"></h5>
                        <h6 class="m-0 opacity-5 skeletion-animation"></h6>
                    </div></div>
                </div>
            </div>
        </div>
    </section> -->
    <section class="permotion-section">
        <div class="container">
            <div class="permote-wraper bg-primary rounded text-white">
                <div class="row">
                    <div class="col-lg-3 col-6 mt-3 mt-lg-0 justify-content-center d-flex">
                        <div class="permote-card">
                            <fa :icon="['fas', 'life-ring']" />
                            <h5 class="mb-0 text-uppercase">{{ this.$t("web.home.promotion.promote.heading") }} </h5>
                            <h6 class="m-0 opacity-5">{{ this.$t("web.home.promotion.promote.description") }} </h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-3 mt-lg-0 justify-content-center d-flex">
                        <div class="permote-card">
                            <fa :icon="['fas', 'credit-card']" />
                            <h5 class="mb-0 text-uppercase">{{ this.$t("web.home.promotion.payment.heading") }} </h5>
                            <h6 class="m-0 opacity-5">{{ this.$t("web.home.promotion.payment.description") }} </h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-3 mt-lg-0 justify-content-center d-flex">
                        <div class="permote-card">
                            <fa :icon="['fas', 'truck']" />
                            <h5 class="mb-0 text-uppercase">{{ this.$t("web.home.promotion.shipping.heading") }} </h5>
                            <h6 class="m-0 opacity-5">{{ this.$t("web.home.promotion.shipping.description") }} </h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-3 mt-lg-0 justify-content-center d-flex">
                        <div class="permote-card">
                            <fa :icon="['fas', 'redo']" />
                            <h5 class="mb-0 text-uppercase">{{ this.$t("web.home.promotion.promote_card.heading") }} </h5>
                            <h6 class="m-0 opacity-5">{{ this.$t("web.home.promotion.promote_card.description") }} </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
}
</script>

<style>

</style>
