<template>
  <section
    v-if="$fetchState.pending || !allCartItems || currentlyActiveTemplate == null || currentlyActiveTemplate == ''"
    class="product-order mt-0"
  >
    <WebsiteGlobalComponentsBreadCrumb :page="`product_order`" />
    <!-- <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}CartPage`" /> -->

  </section>
  <section
    v-else-if="allCartItems.cart_items.length == 0 && Step != 5 && !thankYou"
    class="my-cart mt-0"
  >
    <Component
      :is="`WebsiteOrderFormSteps${currentlyActiveTemplate}ContinueShopping`"
    />
  </section>

  <section v-else-if="thankYou">
     <div >
         <WebsiteOrderFormStepsTemplate1ThankYou
            :customer_credentials="customer_credentials"
            :order_num="order_num"
            :ordered_id="ordered_id" />
    </div>
  </section>
    <section v-else class="product-order mt-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`product_order`" />
    <WebsiteTemplate1CheckoutPage
        v-if="currentlyActiveTemplate == 'Template1'"
     />
    <WebsiteTemplate2CheckoutPage
        v-if="currentlyActiveTemplate == 'Template2'"
        @showThankYouPage="(showThankYouPage)=> this.thankYou = showThankYouPage"
        @customer="customer"
        @order_nunber="order_nunber"
        @order_id="order_id"
     />
    <WebsiteTemplate1NewsLetterSection />
  </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
     currentlyActiveTemplate: "",
      Step: 1,
      thankYou: false,
      customer_credentials: {},
      order_num: "",
      ordered_id: "",

    };
  },
    created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme

  },
  fetch() {},
  methods:{
        order_nunber(order_nunber) {
      this.order_num = order_nunber;
    },
    order_id(order_id) {
      this.ordered_id = order_id;
    },
    customer(customer) {
      this.customer_credentials = customer;
    },
  },
  computed: {
    ...mapGetters({
      allCartItems: "Web/Cart/allCartItems",
        allSettings: 'allDefaultSettings'
    }),
  },
  auth: false,
};
</script>

<style></style>
