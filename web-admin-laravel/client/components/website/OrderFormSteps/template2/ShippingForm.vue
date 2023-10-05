<template>
  <div class="billing-adress">
    <div
      class="billing-adress-form rounded p-4"
    >
      <form class="row g-3 needs-validation">
        <div class="col-md-12">
          <div class="form-switch mb-4">
            <input
              @click="setAsBillingAddress"
              class="form-check-input"
              type="checkbox"
              id="flexSwitchCheckDefault"
            />
            <label class="form-check-label" for="flexSwitchCheckDefault"
              >{{$t('web.customer.shipping_form.set_as_billing_address')}}</label
            >
          </div>
        </div>
        <div class="col-lg-6">
            <label for="validationServer01" class="form-label">{{$t('form.customer.first_name.label')}}</label>
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['shipping_address.first_name']"
          >
            {{ all_errors["shipping_address.first_name"][0] }}
          </span>

          <input
            type="text"
            v-model="shipping_address.first_name"
            class="form-control"
            id="validationServer01"
            :placeholder="$t('form.customer.first_name.placeholder')"
            required
          />
          <div class="valid-feedback">{{$t('looks_good')}}</div>
        </div>
        <div class="col-lg-6">
            <label for="validationServer02" class="form-label">{{$t('form.customer.last_name.label')}}</label>
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['shipping_address.last_name']"
          >
            {{ all_errors["shipping_address.last_name"][0] }}
          </span>

          <input
            type="text"
            v-model="shipping_address.last_name"
            class="form-control"
            id="validationServer02"
            :placeholder="$t('form.customer.last_name.placeholder')"
            required
          />
          <div class="invalid-feedback">{{$t('looks_good')}}</div>
        </div>
        <div class="col-md-12">
            <label for="validationServerUsername" class="form-label"
            >{{$t('form.customer.email.label')}}</label>
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['shipping_address.email']"
          >
            {{ all_errors["shipping_address.email"][0] }}
          </span>

          <div class="input-group has-validation">
            <input
              v-model="shipping_address.email"
              type="text"
              class="form-control"
              id="validationServerUsername"
              aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback"
              :placeholder="$t('form.customer.email.placeholder')"
              required
            />
            <div id="validationServerUsernameFeedback" class="invalid-feedback">
              {{$t('form.customer.choose_username')}}
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <label for="validationServer03" class="form-label">{{$t('form.customer.country.label')}}</label>
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['shipping_address.country_id']"
          >
            {{ all_errors["shipping_address.country_id"][0] }}
          </span>
          <AdminSearchSelectable
            :class="errors && errors.country_id ? 'errors' : ''"
            apiMethod="activeCountries"
            responseKey="countries"
            :initialOptions="allActiveCountries"
            :selectedOptions="selected_country ? selected_country : ''"
            :placeholder="this.$t('form.customer.country.placeholder')"
            v-model="shipping_address.country_id"
            v-on:input="getStatesByCountry($event)"
            :key="country_key"
          />
        </div>
        <div class="col-lg-6">
          <label for="validationServer04" class="form-label">{{$t('form.customer.state.label')}}</label>
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['shipping_address.state_id']"
          >
            {{ all_errors["shipping_address.state_id"][0] }}
          </span>
          <AdminSearchSelectable
            :class="errors && errors.state_id ? 'errors' : ''"
            :search_id="shipping_address.country_id"
            apiMethod="getStatesByCountry"
            responseKey="states"
            :initialOptions="statesByCountry.states"
            :disabled="statesByCountry.states ? false : true"
            :selectedOptions="selected_state ? selected_state : ''"
            :placeholder="this.$t('form.customer.state.placeholder')"
            :key="states_key"
            v-model="shipping_address.state_id"
            v-on:input="getCitiesByState($event)"
          />
          <div id="validationServer04Feedback" class="invalid-feedback">
            {{ $t("form.customer.state.subheading") }}
          </div>
        </div>
        <div class="col-lg-6">
          <label for="validationServer05" class="form-label">{{$t('form.customer.city.label')}}</label>
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['shipping_address.city_id']"
          >
            {{ all_errors["shipping_address.city_id"][0] }}
          </span>
          <AdminSearchSelectable
            :class="errors && errors.city_id ? 'errors' : ''"
            :search_id="shipping_address.state_id"
            apiMethod="getCitiesByState"
            responseKey="cities"
            :initialOptions="citiesByState.cities"
            :disabled="citiesByState.cities ? false : true"
            :selectedOptions="selected_city ? selected_city : ''"
            :placeholder="this.$t('form.customer.city.placeholder')"
            :key="cities_key"
            v-model="shipping_address.city_id"
          />
          <div id="validationServer05Feedback" class="invalid-feedback">
            {{ $t("form.customer.city.subheading") }}
          </div>
        </div>
        <div class="col-lg-6">
          <label for="validationServer06" class="form-label">{{$t('form.customer.zip_code.label')}}</label>
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['shipping_address.zip_code']"
          >
            {{ all_errors["shipping_address.zip_code"][0] }}
          </span>
          <input
            :class="errors && errors.zip_code ? 'errors' : ''"
            class="form-control"
            v-model="shipping_address.zip_code"
            aria-describedby="input-live-help input-live-feedback"
            :placeholder="this.$t('form.customer.zip_code.placeholder')"
            trim
          />
          <div id="validationServer06Feedback" class="invalid-feedback">
            {{$t('form.customer.valid_zip')}}
          </div>
        </div>
        <div class="col-lg-6">
          <label for="validationServer06" class="form-label">{{$t('form.customer.contact.label')}}</label>
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['shipping_address.phone']"
          >
            {{ all_errors["shipping_address.phone"][0] }}
          </span>
          <input
            :class="errors && errors.phone ? 'errors' : ''"
            class="form-control"
            v-model="shipping_address.phone"
            aria-describedby="input-live-help input-live-feedback"
            :placeholder="this.$t('form.customer.phone.placeholder')"
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
                    v-if="all_errors && all_errors['shipping_address.near_by']"
                >
                    {{ all_errors["shipping_address.near_by"][0] }}
                </span>
                <input
                    :class="errors && errors.near_by ? 'errors' : ''"
                    class="form-control"
                    v-model="shipping_address.near_by"
                    aria-describedby="input-live-help input-live-feedback"
                    :placeholder="this.$t('form.billing.near_by.placeholder')"
                    trim
                />
                <div id="validationServer06Feedback" class="invalid-feedback">
                   {{$t('form.customer.valid_zip')}}
                </div>
                </div>
        <div class="col-md-12">
          <label for="validationServer07" class="form-label">{{$t('form.customer.address.label')}}</label>
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['shipping_address.address']"
          >
            {{ all_errors["shipping_address.address"][0] }}
          </span>
          <vue-google-autocomplete
            id="map"
            classname="form-control"
            :placeholder="this.$t('form.billing.address.placeholder')"
            v-on:placechanged="getAddressData"
            v-model="shipping_address.address"
          >
          </vue-google-autocomplete>
          <div class="invalid-feedback">{{$t('form.customer.address.provide_address')}}</div>
            <div class="col-md-12 d-flex justify-content-end">
                 <button @click="validateShippingAddress" class="btn btn-primary text-white rounded py-2 lh-sm fw-bold text-uppercase mt-4 mx-3 " type="button"> {{$t('next')}}</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      setDefualtAddress_check: false,
      shippingAddressFilled: false,
      selected_country: "",
      selected_city: "",
      selected_state: "",
      statesByCountry: {},
      citiesByState: {},
      states_key: 1,
      cities_key: 1,
      errors: false,
      customer: [],
      shipping_address: {
        id: "",
        first_name: "",
        last_name: "",
        email: "",
        city_id: "",
        state_id: "",
        country_id: "",
        zip_code: "",
        phone: "",
        address: "",
          near_by:"",
         latitude: "",
        longitude:""
      },
    };
  },
  props: ["billing_details", "all_errors"],
  async fetch() {
    if (!this.allActiveCountries) {
      await this.fetchActiveCountries();
      this.$forceUpdate();
    }
    if (this.$auth.loggedIn && this.$gates.hasRole('customer') ) {
      const { data } = await this.$webService.customerWithAddresses();
      if (data) {
        this.customer = data;
      }
    }
  },
  methods: {
    ...mapActions({
      fetchActiveCountries: "Web/General/fetchActiveCountries",
    }),
   async setAsBillingAddress() {
      this.shipping_address.id = this.billing_details.id;
       await this.getSelectedCountry(this.billing_details.country_id);
      this.shipping_address.city_id = this.billing_details.city_id;
      this.shipping_address.state_id = this.billing_details.state_id;
      this.shipping_address.country_id = this.billing_details.country_id;
      this.setStatesByCountry(this.billing_details.country_id);
      this.setCitiesByState(this.billing_details.state_id);
      this.shipping_address.first_name = this.billing_details.first_name;
      this.shipping_address.last_name = this.billing_details.last_name;
      this.shipping_address.email = this.billing_details.email;
      this.shipping_address.phone = this.billing_details.phone;
      this.shipping_address.zip_code = this.billing_details.zip_code;
      this.shipping_address.address = this.billing_details.address;
      this.shipping_address.latitude = this.billing_details.latitude;
      this.shipping_address.longitude = this.billing_details.longitude;
      this.shipping_address.near_by = this.billing_details.near_by;
      this.setDefualtAddress_check = !this.setDefualtAddress_check
      if(this.setDefualtAddress_check)
      {
          this.$toast.success("Shipping Address Sets as Billing Address");
      }
      else
      {
          this.$toast.success("Shipping Address is Reset");
      }
    },
     async getSelectedCountry(country_id) {
      const data = await this.$generalService.getActiveCountryById(country_id);
      this.selected_country = data
       this.country_key += 1;
    },
    async getStatesByCountry(e) {
      this.shipping_address.state_id = "";
      this.shipping_address.city_id = "";
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
      this.shipping_address.city_id = "";
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
      this.shipping_address.address = placeResultData.formatted_address
      this.shipping_address.latitude = addressData.latitude
      this.shipping_address.longitude = addressData.longitude
    },
    validateShippingAddress()
    {
        this.$emit("callValidateShippingAddress", this.shipping_address);
    }
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
    shipping_address: {
      deep: true,
      handler() {
         // check all fields are filled
        var local_value_nearby = this.shipping_address.near_by
        delete this.shipping_address.near_by;
        const filledData = Object.values(this.shipping_address).every(value => {
        if (value === null || value != "") {
            return true;
        }
        return false;
        });
        if (filledData) {
            this.shippingAddressFilled = true
        }
        else
        {
            this.shippingAddressFilled = false
        }
        this.shipping_address.near_by = local_value_nearby
        this.$emit("shipping_address", this.shipping_address);
        this.$emit("shippingAddressFilled", this.shippingAddressFilled);
         this.$emit("errors", []);
      },
    },
    setDefualtAddress_check: function (newVal, OldVal) {
      if (!newVal) {
        this.shipping_address.first_name = "";
        this.shipping_address.last_name = "";
        this.shipping_address.email = "";
        this.shipping_address.state_id = "";
        this.shipping_address.city_id = "";
        this.shipping_address.country_id = "";
        this.shipping_address.zip_code = "";
        this.shipping_address.address = "";
        this.shipping_address.phone = "";
      }
    },
  },
};
</script>

<style>
</style>
