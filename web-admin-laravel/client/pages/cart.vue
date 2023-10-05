<template>
 <div>
    <section v-if="$fetchState.pending || !allCartItems" class="my-cart mt-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`cart`"/>
     <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}CartPage`" />
  </section>
  <section v-else-if="allCartItems.cart_items.length == 0" class="my-cart mt-0">
     <Component :is="`WebsiteOrderFormSteps${currentlyActiveTemplate}ContinueShopping`" />
  </section>
  <section v-else class="my-cart mt-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`cart`" />
     <div class="container space-custom my-5">
       <div class="row">
         <div class="col-lg-8 col-md-7">
           <Component :is="`WebsiteOrderFormSteps${currentlyActiveTemplate}CartDetail`" />
         </div>
         <div class="col-lg-4 col-md-5 space-custom">
           <Component :is="`WebsiteOrderFormSteps${currentlyActiveTemplate}CartTotals`" />
         </div>
       </div>
     </div>
  </section>
  <WebsiteTemplate1NewsLetterSection />
 </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  auth: false,
  data() {
    return {
      currentlyActiveTemplate: "",
    }
  },
   created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
  },
  async fetch(){
  },
  computed:{
    ...mapGetters({
      allCartItems: 'Web/Cart/allCartItems',
       allSettings: 'allDefaultSettings'
    }),
  },
}
</script>

<style>

</style>
