<template>
  <div v-if="$fetchState.pending">
    <div class="skeletion-effect">
      <div class="form">
        <div class="row p-4">
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation"></div>
          </div>
          <div class="col-12">
            <div class="label"></div>
            <div class="input skeletion-animation"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation"></div>
          </div>
          <div class="col-md-6">
            <div class="label"></div>
            <div class="input skeletion-animation"></div>
          </div>
          <div class="col-12">
            <div class="label"></div>
            <div class="textarea skeletion-animation"></div>
          </div>

          <div class="col-12">
            <div class="btn button skeletion-animation"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div v-else class="billing-adress pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="text-primary text-uppercase fw-bold mb-0">
        {{ this.$t("form.billing.billing_address") }}
      </h5>
    </div>
    <div
      class="billing-adress-form shadow rounded p-4 bg-white-secondary-light"
    >
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
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['billing_address.first_name']"
          >
            {{ all_errors["billing_address.first_name"][0] }}
          </span>
          <label for="validationServer01" class="form-label">{{
            this.$t("form.billing.first_name.label")
          }}</label>
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
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['billing_address.last_name']"
          >
            {{ all_errors["billing_address.last_name"][0] }}
          </span>
          <label for="validationServer02" class="form-label">{{
            this.$t("form.billing.last_name.label")
          }}</label>
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
          <span
            class="float-end text-danger"
            v-if="all_errors && all_errors['billing_address.email']"
          >
            {{ all_errors["billing_address.email"][0] }}
          </span>
          <label for="validationServerUsername" class="form-label">{{
            this.$t("form.billing.email.label")
          }}</label>
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
            Please provide a valid zip.
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
            class="float-end text-warning"
            v-if="billing_address.address == '' || all_errors && all_errors['billing_address.address']"
          >
            {{this.$t("must_be_valid_google_address")}}
          </span>
          <vue-google-autocomplete
            id="map"
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
      defaultAddressAvailable: false,
      selected_country: "",
      selected_city: "",
      selected_state: "",
      statesByCountry: {},
      citiesByState: {},
      states_key: 1,
      cities_key: 1,
      errors: false,
      customer: [],
      billing_address: {
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
  props: ["all_errors"],
  async fetch() {
    if (!this.allActiveCountries) {
      await this.fetchActiveCountries();
      this.$forceUpdate();
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
          this.billing_address.near_by =
          this.customer.addresses[default_address].near_by;
          this.billing_address.latitude =
          this.customer.addresses[default_address].latitude;
          this.billing_address.longitude =
          this.customer.addresses[default_address].longitude;
        this.billing_address.phone =
          this.customer.addresses[default_address].phone;
        this.setDefualtAddress_check = !this.setDefualtAddress_check;
        if (this.setDefualtAddress_check) {
          this.$toast.success("Default Address Added");
          this.$fetch();
        } else {
          this.$toast.success("Default Address Removed");
        }
      } else {
        this.setDefualtAddress_check = false;
        this.$toast.error("Default Address Not Found");
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
        this.$emit("billing_address", this.billing_address);
        this.$emit("shipping_selected_country", this.selected_country);

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
