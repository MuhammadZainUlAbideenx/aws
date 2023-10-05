<template>
  <section v-if="$fetchState.pending" class="my-profile-page m-0">
    <WebsiteGlobalComponentsBreadCrumb />
    <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}MyProfilePage`" />
  </section>
  <section v-else class="my-profile-page m-0">
    <WebsiteGlobalComponentsBreadCrumb />
    <WebsiteGlobalComponentsProfileLogOutSection :profile="profile" />
    <div class="container mb-50">
      <div class="row">
        <div class="col-12">
          <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link show active" id="myprofiletab" data-bs-toggle="tab" data-bs-target="#my-profile" type="button" role="tab" aria-controls="my-profile" aria-selected="false">{{$t('profile')}}</button>
              </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="billing-address-tab" data-bs-toggle="tab" data-bs-target="#billing-address" type="button" role="tab" aria-controls="billing-address" aria-selected="true">{{$t('columns.address')}}</button>
            </li>
          <!--  <li class="nav-item" role="presentation">
              <button class="nav-link" id="shipping-methods-tab" data-bs-toggle="tab" data-bs-target="#shipping-methods" type="button" role="tab" aria-controls="shipping-methods" aria-selected="false">Shipping Methods</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="payment-methods-tab" data-bs-toggle="tab" data-bs-target="#payment-methods" type="button" role="tab" aria-controls="payment-methods" aria-selected="false">Payment Methods</button>
            </li> -->
          </ul>
          <div class="tab-content shadow p-3 p-lg-4 bg-white-secondary-light border border-1" id="myTabContent">
            <div class="tab-pane fade active show" id="my-profile" role="tabpanel" aria-labelledby="myprofiletab">
              <Component :is="`WebsiteOrderFormSteps${currentlyActiveTemplate}MyProfileTab`" />
            </div>
            <div class="billing-adress-table tab-pane fade" id="billing-address" role="tabpanel" aria-labelledby="billing-address-tab">
              <Component :is="`WebsiteOrderFormSteps${currentlyActiveTemplate}MyBillingAddressForm`" />
            </div>

          <!--  <div class="tab-content shadow p-5 bg-white-secondary-light" id="myTabContent">
             <div class="tab-pane fade" id="billing-address" role="tabpanel" aria-labelledby="billing-address-tab">
                <WebsiteOrderFormStepsTemplate1MyShippingAddressForm  />
                <div class="d-flex justify-content-end">
                  <a class="btn bg-warning rounded py-3 px-5 lh-sm fw-bold text-uppercase mt-5" >
                        Confirm and Continue
                  </a>
                </div>
              </div>
            <div class="tab-pane fade" id="shipping-methods" role="tabpanel" aria-labelledby="shipping-methods-tab">
              <WebsiteOrderFormStepsTemplate1MyShippingForm  />
              <div class="d-flex justify-content-end">
                <a class="btn bg-warning rounded py-3 px-5 lh-sm fw-bold text-uppercase mt-5" >
                      Confirm and Continue
                </a>
              </div>
            </div>
            <div class="tab-pane fade" id="payment-methods" role="tabpanel" aria-labelledby="payment-methods-tab">
              <WebsiteOrderFormStepsTemplate1MyPaymentMethodForm  />
              <div class="d-flex justify-content-end">
                <a class="btn bg-warning rounded py-3 px-5 lh-sm fw-bold text-uppercase mt-5" >
                      Confirm and Continue
                </a>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <WebsiteTemplate1NewsLetterSection />
  </section>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    middleware: 'customer',
  data() {
    return {
          currentlyActiveTemplate: "",
      key: 1,
      detail: "",
      seo: {},
      profile:{
        first_name :'',
        last_name :'',
        gender :'',
        dob :'',
        phone :'',
        email:'',
        name:'',
        profile_image_path:'',
      },
    };
  },
    created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
  },
  head() {
    return this.seo;
  },
  async fetch() {
    const { data } = await this.$webService.customerProfile()
    if(data){
      this.profile.first_name = data.first_name
      this.profile.last_name = data.last_name
      this.profile.gender = data.gender
      this.profile.dob = data.dob
      this.profile.phone = data.phone
      this.profile.email = data.email
      this.profile.name = data.name
      this.profile.profile_image_path = data.profile_image_path
    }
  },
  methods: {
    //  shipping_address(billing_address){
  //      this.shipping_details = this.billing_address.shipping_address;
    //  },
  },
      computed:{
    ...mapGetters({
      allSettings: 'allDefaultSettings'
    }),
  },
};
</script>

<style>
</style>
