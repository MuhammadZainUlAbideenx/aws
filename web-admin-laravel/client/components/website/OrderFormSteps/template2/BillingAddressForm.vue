<template>
  <!-- <div v-if="$fetchState.pending"> -->
    <div v-if="$fetchState.pending">
    <div class="skeletion-effect mt-100">
      <div class="form rounded">
        <div class="row p-4">
          <div class="col-md-10">
            <div class="d-flex align-items-center mb-3">
              <div class="label label-circle"></div>
              <div class="label  ms-3"></div>
            </div>
          </div>
          <div class="col-md-2">
            <div class="label"></div>
          </div>
          <div class="col-md-12">
            <div class="d-flex align-items-center mb-3">
              <div class="label label-circle-2 me-3 ms-2"></div>
              <div class="label w-25"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation rounded"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation rounded"></div>
          </div>
          <div class="col-12">
            <div class="label"></div>
            <div class="input skeletion-animation rounded"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation rounded"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation rounded"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation rounded"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation rounded"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation rounded"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation rounded"></div>
          </div>
          <div class="col-12">
            <div class="label"></div>
            <div class="textarea skeletion-animation  rounded"></div>
          </div>

          <div class="col-12">
            <div class="d-flex justify-content-end">
              <div class="btn button skeletion-animation py-4"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row p-3">
        <div class="card">
          <div class="card-body">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class=" d-flex align-items-center">
              <div class="card-circle"></div>
              <div class="label label-1 ms-3"></div>
            </div>
           </div>
            <div class="col-md-6">
            <div class="d-flex justify-content-end">
              <div class="label label-1 ms-3"></div>
            </div>
            </div>
        </div>
          </div>
        </div>
      </div>



      <div class="row p-3 pt-0">
        <div class="card">
          <div class="card-body">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class=" d-flex align-items-center">
              <div class="card-circle"></div>
              <div class="label label-1 ms-3"></div>
            </div>
           </div>
            <div class="col-md-6">
            <div class="d-flex justify-content-end">
              <div class="label label-1 ms-3"></div>
            </div>
            </div>
        </div>
          </div>
        </div>
      </div>



      <div class="row p-3 pt-0">
        <div class="card">
          <div class="card-body">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class=" d-flex align-items-center">
              <div class="card-circle"></div>
              <div class="label label-1 ms-3"></div>
            </div>
           </div>
            <div class="col-md-6">
            <div class="d-flex justify-content-end">
              <div class="label label-1 ms-3"></div>
            </div>
            </div>
        </div>
          </div>
        </div>
      </div>
    </div>
  </div>




  <div v-else class="billing-adress mt-5 mt-100">
    <div class="accordion" id="accordionExample">
        <div class="accordion-item mb-3 rounded">
            <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button shadow-none fs-4 fw-bold py-2 px-3 " id="collapseOneBtn" :class="billingAddressFilled ? 'done' : ''" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <span>01</span> {{$t('web.step_widget.information')}}
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="billing-adress-form p-4">
                    <form class="row g-3 needs-validation">
                        <div
                        class="col-md-12"
                        v-if="
                            customer &&
                            customer.addresses &&
                            customer.addresses.length &&
                            defaultAddressAvailable
                        "
                        >
                        <div class="form-switch">
                            <input
                            v-model="setDefualtAddress_check"
                            @click="setDefualtAddress"
                            class="form-check-input"
                            type="checkbox"
                            id="flexSwitchCheckDefault"
                            />
                            <label class="form-check-label" for="flexSwitchCheckDefault">{{
                            this.$t("Pick Default Address")
                            }}</label>
                        </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="validationServer01" class="form-label">{{
                            this.$t("form.billing.first_name.label")
                        }}</label>
                        <span
                            class="float-end text-danger"
                            v-if="all_errors && all_errors['billing_address.first_name']"
                        >
                            {{ all_errors["billing_address.first_name"][0] }}
                        </span>

                        <input
                            type="text"
                            v-model="billing_address.first_name"
                            class="form-control"
                            id="validationServer01"
                            :placeholder="this.$t('form.billing.first_name.placeholder')"
                            required
                        />
                        <div class="valid-feedback">{{$t('looks_good')}}</div>
                        </div>
                        <div class="col-lg-6">
                        <label for="validationServer02" class="form-label">{{
                            this.$t("form.billing.last_name.label")
                        }}</label>
                        <span
                            class="float-end text-danger"
                            v-if="all_errors && all_errors['billing_address.last_name']"
                        >
                            {{ all_errors["billing_address.last_name"][0] }}
                        </span>

                        <input
                            type="text"
                            v-model="billing_address.last_name"
                            class="form-control"
                            id="validationServer02"
                            :placeholder="this.$t('form.billing.last_name.placeholder')"
                            required
                        />
                        <div class="invalid-feedback">{{$t('looks_good')}}</div>
                        </div>
                        <div class="col-md-12">
                        <label for="validationServerUsername" class="form-label">{{
                            this.$t("form.billing.email.label")
                        }}</label>
                        <span
                            class="float-end text-danger"
                            v-if="all_errors && all_errors['billing_address.email']"
                        >
                            {{ all_errors["billing_address.email"][0] }}
                        </span>

                        <div class="input-group has-validation">
                            <input
                            v-model="billing_address.email"
                            type="text"
                            class="form-control"
                            id="validationServerUsername"
                            aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback"
                            :placeholder="this.$t('form.billing.email.placeholder')"
                            required
                            />
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                            {{$t('form.customer.choose_username')}}
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <label for="validationServer03" class="form-label">{{
                            this.$t("form.billing.country.label")
                        }}</label>
                        <span
                            class="float-end text-danger"
                            v-if="all_errors && all_errors['billing_address.country_id']"
                        >
                            {{ all_errors["billing_address.country_id"][0] }}
                        </span>
                        <AdminSearchSelectable
                            :class="errors && errors.country_id ? 'errors' : ''"
                            apiMethod="activeCountries"
                            responseKey="countries"
                            :initialOptions="allActiveCountries"
                            :selectedOptions="selected_country ? selected_country : ''"
                            :placeholder="this.$t('form.billing.country.placeholder')"
                            v-model="billing_address.country_id"
                            v-on:input="getStatesByCountry($event)"
                        />
                        </div>
                        <div class="col-lg-6">
                        <label for="validationServer04" class="form-label">{{
                            this.$t("form.billing.state.label")
                        }}</label>
                        <span
                            class="float-end text-danger"
                            v-if="all_errors && all_errors['billing_address.state_id']"
                        >
                            {{ all_errors["billing_address.state_id"][0] }}
                        </span>
                        <AdminSearchSelectable
                            :class="errors && errors.state_id ? 'errors' : ''"
                            :search_id="billing_address.country_id"
                            apiMethod="getStatesByCountry"
                            responseKey="states"
                            :initialOptions="statesByCountry.states"
                            :disabled="statesByCountry.states ? false : true"
                            :selectedOptions="selected_state ? selected_state : ''"
                            :placeholder="this.$t('form.billing.state.placeholder')"
                            :key="states_key"
                            v-model="billing_address.state_id"
                            v-on:input="getCitiesByState($event)"
                        />
                        <div id="validationServer04Feedback" class="invalid-feedback">
                            {{ $t("form.customer.state.subheading") }}
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <label for="validationServer05" class="form-label">{{
                            this.$t("form.billing.city.label")
                        }}</label>
                        <span
                            class="float-end text-danger"
                            v-if="all_errors && all_errors['billing_address.city_id']"
                        >
                            {{ all_errors["billing_address.city_id"][0] }}
                        </span>
                        <AdminSearchSelectable
                            :class="errors && errors.city_id ? 'errors' : ''"
                            :search_id="billing_address.state_id"
                            apiMethod="getCitiesByState"
                            responseKey="cities"
                            :initialOptions="citiesByState.cities"
                            :disabled="citiesByState.cities ? false : true"
                            :selectedOptions="selected_city ? selected_city : ''"
                            :placeholder="this.$t('form.billing.city.placeholder')"
                            :key="cities_key"
                            v-model="billing_address.city_id"
                        />
                        <div id="validationServer05Feedback" class="invalid-feedback">
                            {{ $t("form.customer.city.subheading") }}
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <label for="validationServer06" class="form-label">{{
                            this.$t("form.billing.zip_code.label")
                        }}</label>
                        <span
                            class="float-end text-danger"
                            v-if="all_errors && all_errors['billing_address.zip_code']"
                        >
                            {{ all_errors["billing_address.zip_code"][0] }}
                        </span>
                        <input
                            :class="errors && errors.zip_code ? 'errors' : ''"
                            class="form-control"
                            v-model="billing_address.zip_code"
                            aria-describedby="input-live-help input-live-feedback"
                            :placeholder="this.$t('form.billing.zip_code.placeholder')"
                            trim
                        />
                        <div id="validationServer06Feedback" class="invalid-feedback">
                            {{$t('form.customer.valid_zip')}}
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <label for="validationServer06" class="form-label">{{
                            this.$t("form.billing.contact_no.label")
                        }}</label>
                        <span
                            class="float-end text-danger"
                            v-if="all_errors && all_errors['billing_address.phone']"
                        >
                            {{ all_errors["billing_address.phone"][0] }}
                        </span>
                        <input
                            :class="errors && errors.phone ? 'errors' : ''"
                            class="form-control"
                            v-model="billing_address.phone"
                            aria-describedby="input-live-help input-live-feedback"
                            :placeholder="this.$t('form.billing.contact_no.placeholder')"
                            trim
                        />
                        <div id="validationServer06Feedback" class="invalid-feedback">
                            {{$t('form.customer.valid_zip')}}
                        </div>
                        </div>
                            <div class="col-lg-6">
                            <label for="validationServer06" class="form-label">{{
                                this.$t("form.billing.near_by.label")
                            }}</label>
                            <span
                                class="float-end text-danger"
                                v-if="all_errors && all_errors['billing_address.near_by']"
                            >
                                {{ all_errors["billing_address.near_by"][0] }}
                            </span>
                            <input
                                :class="errors && errors.near_by ? 'errors' : ''"
                                class="form-control"
                                v-model="billing_address.near_by"
                                aria-describedby="input-live-help input-live-feedback"
                                :placeholder="this.$t('form.billing.near_by.placeholder')"
                                trim
                            />
                            <div id="validationServer06Feedback" class="invalid-feedback">
                               {{$t('form.customer.valid_zip')}}
                            </div>
                            </div>
                        <div class="col-md-12">
                        <label for="validationServer07" class="form-label">{{
                            this.$t("form.billing.address.label")
                        }}</label>
                        <span
                            class="float-end text-danger"
                            v-if="all_errors && all_errors['billing_address.address']"
                        >
                            {{ all_errors["billing_address.address"][0] }}
                        </span>
                        <vue-google-autocomplete
                            id="billingAddressMap"
                            classname="form-control"
                            :placeholder="this.$t('form.billing.address.placeholder')"
                            v-on:placechanged="getAddressData"
                            v-model="billing_address.address"
                        >
                        </vue-google-autocomplete>
                        <div class="invalid-feedback">
                            {{ $t("form.customer.address.subheading") }}
                        </div>
                        </div>
                         <div class="col-md-12 d-flex justify-content-end">
                            <button @click="validateBillingAddress" class="btn btn-primary text-white rounded py-2 lh-sm fw-bold text-uppercase mt-4 mx-3 " type="button"> {{$t('next')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        <div class="accordion-item mb-3 rounded">
            <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed shadow-none fs-4 fw-bold py-2 px-3" :class="[(shippingAddressFilled ? 'done' : ''), enableShippingInformationToggle? '' : 'pe-none']" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" id="collapseTwoBtn"  aria-controls="collapseTwo">
                <span>02</span> {{$t('web.step_widget.shipping_information')}}
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                 <WebsiteOrderFormStepsTemplate2ShippingForm
                    :all_errors="all_errors"
                    @shipping_address="shipping_address"
                    :billing_details="billing_details"
                    @shippingAddressFilled="setShippingAddressFilled"
                    @callValidateShippingAddress="validateShippingAddress"
                    @errors="clearErrors"
                 />
            </div>
            </div>
        </div>
        <div class="accordion-item mb-3 rounded">
            <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed shadow-none fs-4 fw-bold py-2 px-3 " :class="[(shippingMethodsFilled ? 'done' : ''), enableShippingMethodsToggle? '' : 'pe-none']"  type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" id="collapseThreeBtn"  aria-controls="collapseThree">
                <span>03</span> {{$t('web.step_widget.shipping_method')}}
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                 <WebsiteOrderFormStepsTemplate2ShippingMethod
                    :all_errors="all_errors"
                    @shipping_method_details="shipping_method_details" :calculated_shipping_value="calculated_shipping_value"
                    @callValidateShippingMethods="validateShippingMethods"
                    v-if="enableShippingMethodsToggle"
                 />
            </div>
            </div>
        </div>
               <div class="accordion-item mb-3 rounded">
            <h2 class="accordion-header" id="headingfour">
            <button class="accordion-button collapsed shadow-none fs-4 fw-bold py-2 px-3" :class="[(paymentMethodsFilled ? 'done' : ''), enablePaymentMethodsToggle? '' : 'pe-none']"  type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" id="collapseFourBtn"  aria-controls="collapseFour">
                <span>04</span> {{$t('web.customer.wallet.payment_methods')}}
            </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                 <WebsiteOrderFormStepsTemplate2PaymentMethodForm
                    :all_errors="all_errors"
                    @details="details"
                 />
            </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      setDefualtAddress_check: false,
      defaultAddressAvailable: false,
      calculated_shipping_value: "",
      selected_country: "",
      selected_city: "",
      selected_state: "",
      statesByCountry: {},
      citiesByState: {},
      states_key: 1,
      cities_key: 1,
      errors: false,
      customer: [],
      billingAddressFilled: false,
      shippingAddressFilled: false,
      shippingMethodsFilled: false,
      paymentMethodsFilled: false,
      enableShippingInformationToggle: false,
      enableShippingMethodsToggle: false,
      enablePaymentMethodsToggle: false,
      billing_address: {
        first_name: "",
        last_name: "",
        email: "",
        city_id: "",
        state_id: "",
        country_id: "",
        zip_code: "",
        phone: "",
        address: "",
        latitude: "",
        longitude: "",
        near_by: "",
      },
      formData: {
        customer_id: "",
        payment_method_code: "",
        cardInfo: {
          number: "",
          exp_month: "",
          exp_year: "",
          cvc: "",
        },
        billing_address: {},
        shipping_address: {},
        shipping_id: "",
        shipping_value: "",
        plateForm: "web",
        paytm_mode: "",
        coupon_id: ""
      },
    };
  },
  props: ["all_errors", "billing_details"],
  async fetch() {
    if (!this.allActiveCountries) {
      await this.fetchActiveCountries();
    }
    if (this.$auth.loggedIn && this.$gates.hasRole("customer")) {
      const { data } = await this.$webService.customerWithAddresses();
      if (data) {
        this.customer = data;
        this.billing_address.first_name = data.first_name;
        this.billing_address.last_name = data.last_name;
        this.billing_address.email = data.email;
        for (let index = 0; index < data.addresses.length; index++) {
          if (data.addresses[index].is_default == 1) {
            this.defaultAddressAvailable = true;
          }
        }
      }
    }
  },
  methods: {
    ...mapActions({
      fetchActiveCountries: "Web/General/fetchActiveCountries",
    }),
    setDefualtAddress() {
      var default_address = 0;
      default_address = this.customer.addresses.findIndex(
        (obj) => obj.is_default === 1
      );
      if (default_address != -1) {
        this.billing_address.id = this.customer.addresses[default_address].id;
        this.billing_address.city_id =
          this.customer.addresses[default_address].city.id;
        this.billing_address.state_id =
          this.customer.addresses[default_address].state.id;
        this.setCitiesByState(
          this.customer.addresses[default_address].state.id
        );
        this.selected_city = this.customer.addresses[default_address].city;
        this.billing_address.country_id =
          this.customer.addresses[default_address].country.id;
        this.selected_country =
          this.customer.addresses[default_address].country;
        this.setStatesByCountry(
          this.customer.addresses[default_address].country.id
        );
        this.selected_state = this.customer.addresses[default_address].state;
        this.billing_address.zip_code =
          this.customer.addresses[default_address].zip_code;
        this.billing_address.address =
          this.customer.addresses[default_address].address;
        this.billing_address.latitude =
          this.customer.addresses[default_address].latitude;
        this.billing_address.longitude =
          this.customer.addresses[default_address].longitude;
        this.billing_address.phone =
          this.customer.addresses[default_address].phone;
        this.setDefualtAddress_check = !this.setDefualtAddress_check;
        if (this.setDefualtAddress_check) {
          this.$toast.success(this.$t("default_address_added"));
          this.$fetch();
        } else {
          this.$toast.success(this.$t("default_address_removed"));
        }
      } else {
        this.setDefualtAddress_check = false;
        this.$toast.error(this.$t("default_address_not_found"));
      }
    },
    async getStatesByCountry(e) {
      this.billing_address.state_id = "";
      this.billing_address.city_id = "";
      const data = await this.$webService.getStatesByCountry(e);
      if (data.states) {
        this.statesByCountry = data.states;
      }
      this.states_key += 1;
    },

    async setStatesByCountry(id) {
      const data = await this.$webService.getStatesByCountry(id);
      if (data.states) {
        this.statesByCountry = data.states;
      }
      this.$forceUpdate();
    },
    async getCitiesByState(e) {
      this.billing_address.city_id = "";
      const data = await this.$webService.getCitiesByState(e);
      if (data.cities) {
        this.citiesByState = data.cities;
      }
      this.cities_key += 1;
    },
    async setCitiesByState(id) {
      const data = await this.$webService.getCitiesByState(id);
      if (data.cities) {
        this.citiesByState = data.cities;
      }
      this.$forceUpdate();
    },
    getAddressData: function (addressData, placeResultData, id) {
      this.billing_address.address = placeResultData.formatted_address
      this.billing_address.latitude = addressData.latitude
      this.billing_address.longitude = addressData.longitude
    },
    setShippingAddressFilled(shippingAddressFilled) {
      this.shippingAddressFilled = shippingAddressFilled
    },
    details(details) {
      this.$emit('details', details)
    },
    shipping_method_details(shipping_method_details) {
      this.$emit('shipping_method_details', shipping_method_details)
    },
    shipping_address(shipping_address) {
      this.$emit("shipping_address", shipping_address);

    },
    async validateBillingAddress() {
      this.formData.billing_address = this.billing_details;

      await this.$webService

        .validateBillingAddress(this.formData)
        .then((res) => {
          // some error occur
          if (res.response) {
            this.errors = res.response.data.errors ?? res.response.data;
            this.enableShippingInformationToggle = false
            this.$toast.error(res.response.data.message);
          } else {
            if (res.state) {
              this.$emit("errors", {});
              this.enableShippingInformationToggle = true
              var openElement = document.getElementById("collapseTwo");
              openElement.classList.add("show");
              var closeElement = document.getElementById("collapseOne");
              closeElement.classList.remove("show");
              var closeBtnIcon = document.getElementById("collapseOneBtn");
              closeBtnIcon.classList.add("collapsed");
              closeBtnIcon.setAttribute("aria-expanded", "false")
              var openBtnIcon = document.getElementById("collapseTwoBtn");
              openBtnIcon.setAttribute("aria-expanded", "true")
              openBtnIcon.classList.remove("collapsed");

            }
          }
        })
        .catch((error) => {
          this.$emit("errors", error.response.data.errors);
        });
    },
    async validateShippingAddress(shipping_address) {
      this.formData.shipping_address = shipping_address;

      await this.$webService.validateShippingAddress(this.formData)
        .then((res) => {
          if (res.response) {
            this.errors = res.response.data.errors ?? res.response.data;
            this.enableShippingMethodsToggle = false
            this.$toast.error(res.response.data.message);
          } else {
            if (res.state) {
              this.$emit("errors", {});
              this.enableShippingMethodsToggle = true
              this.calculated_shipping_value = res.data
              var openElement = document.getElementById("collapseThree");
              openElement.classList.add("show");
              var closeElement = document.getElementById("collapseTwo");
              closeElement.classList.remove("show")
              var closeBtnIcon = document.getElementById("collapseTwoBtn");
              closeBtnIcon.classList.add("collapsed");
              var openBtnIcon = document.getElementById("collapseThreeBtn");
              openBtnIcon.classList.remove("collapsed");
            }
          }
        })
        .catch((error) => {
          this.$emit("errors", error.response.data.errors);
        });
    },
    async validateShippingMethods(shipping_method_details) {
      this.formData.shipping_id = shipping_method_details.id;
      this.formData.shipping_value = shipping_method_details.value;

      await this.$webService.validateShippingMethod(this.formData)
        .then((res) => {

          if (res.response) {
            this.errors = res.response.data.errors ?? res.response.data;
            this.enablePaymentMethodsToggle = false
            this.$toast.error(res.response.data.message);
          } else {
            if (res.state) {
              this.$emit("errors", {});
              this.enablePaymentMethodsToggle = true
              this.shippingMethodsFilled = true
              var openElement = document.getElementById("collapseFour");
              openElement.classList.add("show");
              var closeElement = document.getElementById("collapseThree");
              closeElement.classList.remove("show")
              var closeBtnIcon = document.getElementById("collapseThreeBtn");
              closeBtnIcon.classList.add("collapsed");
              var openBtnIcon = document.getElementById("collapseFourBtn");
              openBtnIcon.classList.remove("collapsed");
              this.paymentMethodsFilled = true
              this.$emit("paymentMethodsFilled", this.paymentMethodsFilled);

            }
          }
        })
        .catch((error) => {
          this.$emit("errors", error.response.data.errors);
        });
    },

    clearErrors(errors) {
      this.$emit("errors", {});
    },
  },
  computed: {
    ...mapGetters({
      allActiveCountries: "Web/General/allActiveCountries",
    }),
  },

  watch: {
    statesByCountry: function (newValue) {
      this.states_key += 1;
    },
    citiesByState: function (newValue) {
      this.cities_key += 1;
    },
    billing_address: {
      deep: true,
      handler() {
        // check all fields are filled
        var local_value_nearby = this.billing_address.near_by
        delete this.billing_address.near_by;
        const filledData = Object.values(this.billing_address).every(value => {
          if (value === null || value != "") {
            return true;
          }
          return false;
        });
        if (filledData) {
          this.billingAddressFilled = true
        }
        else {
          this.billingAddressFilled = false
        }
        this.billing_address.near_by = local_value_nearby
        this.$emit("billing_address", this.billing_address);
        this.$emit("errors", []);
      },
    },
    setDefualtAddress_check: function (newVal, OldVal) {
      if (!newVal) {
        this.billing_address.first_name = "";
        this.billing_address.last_name = "";
        this.billing_address.email = "";
        this.billing_address.state_id = "";
        this.billing_address.city_id = "";
        this.billing_address.country_id = "";
        this.billing_address.zip_code = "";
        this.billing_address.address = "";
        this.billing_address.phone = "";
      }
    },
  },
};
</script>

<style>
</style>
