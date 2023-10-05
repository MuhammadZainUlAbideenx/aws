<template >
  <div class="" v-if="!this.$auth.user.store">
    <SellerShopSettings />
  </div>
  <div class="" v-else-if="!this.$auth.user.is_active">
    <SellerShopDeactive />
  </div>
  <div v-else>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.rider.create_new_rider") }}
          </h2>
        </div>
        <!-- /.col -->
        <div class="row">
          <div class="col-sm-12 px-0">
            <ol class="breadcrumb float-sm-right text-body">
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/rider/dashboard')">{{
                  this.$t("sidebar.home")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/rider/riders')">{{
                  this.$t("sidebar.rider")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.create") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.rider.form_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content pb-5">
      <div v-if="$fetchState.pending">
        <AdminFormLoader />
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                  <!-- <div class="col-md-6 px-4">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.rider.rider_type.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.role_id">
                          {{ error.role_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.role_id ? 'error' : ''" apiMethod="allActiveAdminsRoles" responseKey="riders_types"
                          :initialOptions="allActiveAdminsRoles.riders_types" show_key="display_name" :placeholder="this.$t('form.rider.rider_type.placeholder')" v-model="formData.role_id"/>
                             <span class=" heebo-light">
                                 {{ $t("form.rider.rider_type.subheading") }}
                             </span>
                    </div>
                  </div> -->
                  <div class="col-md-6 ps-md-0">
                    <div role="group ">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.rider.first_name.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.first_name"
                      >
                        {{ error.first_name[0] }}
                      </span>
                      <input
                        class="form-control"
                        :class="error && error.first_name ? 'error' : ''"
                        v-model="formData.first_name"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.rider.first_name.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ this.$t("form.rider.first_name.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6  pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.rider.last_name.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.last_name"
                      >
                        {{ error.last_name[0] }}
                      </span>
                      <input
                        :class="error && error.last_name ? 'error' : ''"
                        class="form-control"
                        v-model="formData.last_name"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.rider.last_name.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.rider.last_name.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.rider.email.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.email"
                      >
                        {{ error.email[0] }}
                      </span>
                      <input
                        :class="error && error.email ? 'error' : ''"
                        class="form-control"
                        v-model="formData.email"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="this.$t('form.rider.email.placeholder')"
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.rider.email.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 pe-md-0">
                    <div role="group">
                      <label class="label form-label">
                        {{ this.$t("form.rider.dob.label") }}
                      </label>
                      <span
                        class="float-end text-danger"
                        v-if="error && error.dob"
                      >
                        {{ error.dob[0] }}
                      </span>
                      <datetime
                        :min-datetime="now.min_date"
                        :max-datetime="now.max_date"
                        :placeholder="this.$t('form.rider.dob.placeholder')"
                        input-class="form-control"
                        type="date"
                        v-model="formData.dob"
                        value-zone="local"
                      ></datetime>
                      <span class="heebo-light">
                        {{ $t("form.rider.dob.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6  ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.rider.phone.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.phone"
                      >
                        {{ error.phone[0] }}
                      </span>
                      <input
                        :class="error && error.phone ? 'error' : ''"
                        class="form-control"
                        type="number"
                        v-model="formData.phone"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="this.$t('form.rider.phone.placeholder')"
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.rider.phone.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6  pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.rider.address.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.address"
                      >
                        {{ error.address[0] }}
                      </span>
                       <vue-google-autocomplete
                        id="map"
                        classname="form-control"
                        :placeholder="this.$t('form.rider.address.placeholder')"
                        v-on:placechanged="getAddressData"
                       v-model="formData.address"
                    >
                    </vue-google-autocomplete>
                      <span class="heebo-light">
                        {{ $t("form.rider.address.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6  ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.rider.zip_code.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.zip_code"
                      >
                        {{ error.zip_code[0] }}
                      </span>
                      <input
                        :class="error && error.zip_code ? 'error' : ''"
                        class="form-control"
                        v-model="formData.zip_code"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.rider.zip_code.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.rider.zip_code.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6  pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.rider.country.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.country_id"
                      >
                        {{ error.country_id[0] }}
                      </span>
                      <AdminSearchSelectable
                        :class="error && error.country_id ? 'error' : ''"
                        apiMethod="activeCountries"
                        responseKey="countries"
                        :initialOptions="allActiveCountries.countries"
                        :placeholder="this.$t('form.rider.country.placeholder')"
                        v-model="formData.country_id"
                        v-on:input="getStatesByCountry($event)"
                      />
                      <span class="heebo-light">
                        {{ $t("form.rider.country.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6  ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.rider.state.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.state_id"
                      >
                        {{ error.state_id[0] }}
                      </span>
                      <AdminSearchSelectable
                        :class="error && error.state_id ? 'error' : ''"
                        :search_id="formData.country_id"
                        apiMethod="getStatesByCountry"
                        responseKey="states"
                        :initialOptions="statesByCountry.states"
                        :placeholder="this.$t('form.rider.state.placeholder')"
                        :key="states_key"
                        v-model="formData.state_id"
                        v-on:input="getCitiesByState($event)"
                      />
                      <span class="heebo-light">
                        {{ $t("form.rider.state.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6  pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.rider.city.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.city_id"
                      >
                        {{ error.city_id[0] }}
                      </span>
                      <AdminSearchSelectable
                        :class="error && error.city_id ? 'error' : ''"
                        :search_id="formData.state_id"
                        apiMethod="getCitiesByState"
                        responseKey="cities"
                        :initialOptions="citiesByState.cities"
                        :placeholder="this.$t('form.rider.city.placeholder')"
                        :key="cities_key"
                        v-model="formData.city_id"
                      />
                      <span class="heebo-light">
                        {{ $t("form.rider.city.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6  ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.rider.gender.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.gender"
                      >
                        {{ error.gender[0] }}
                      </span>
                      <div class="d-flex">
                        <label class="radio">
                          {{ $t("form.rider.gender.male") }}
                          <input
                            type="radio"
                            v-model="formData.gender"
                            value="male"
                          />
                          <span class="checkround"></span>
                        </label>
                        <label class="radio mx-3"
                          >{{ $t("form.rider.gender.female") }}
                          <input
                            type="radio"
                            v-model="formData.gender"
                            value="female"
                          />
                          <span class="checkround"></span>
                        </label>
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.rider.gender.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6  pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.rider.password.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.password"
                      >
                        {{ error.password[0] }}
                      </span>
                      <input
                        :class="error && error.password ? 'error' : ''"
                        class="form-control"
                        v-model="formData.password"
                        type="password"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.rider.password.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.rider.password.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6  ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.rider.password_confirmation.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.password_confirmation"
                      >
                        {{ error.confirm_password[0] }}
                      </span>
                      <input
                        :class="
                          error && error.password_confirmation ? 'error' : ''
                        "
                        class="form-control"
                        v-model="formData.password_confirmation"
                        type="password"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t(
                            'form.rider.password_confirmation.placeholder'
                          )
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.rider.password_confirmation.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3  pe-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.rider.status.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.is_active"
                          :checked="formData.is_active ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.rider.status.subheading") }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 px-4 text-center text-md-end">
              <button
                type="button"
                class="btn btn-primary mb-3 px-3 py-2"
                @click="add"
                name="button"
              >
                {{ this.$t("form.add") }}
              </button>
              <!-- <button
                type="button"
                class="btn btn-success mb-3"
                @click="addAndContinue"
                name="button"
              >
                {{ this.$t("form.add_and_continue") }}
              </button> -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "vendor",
  middleware: ["vendor"],
  meta: {
    permission: "riders.create",
    strategy: "create",
  },
  async asyncData({ params }) {},
  async fetch() {
    const data = await this.$generalService.allActiveAdminsRoles();
    this.allActiveAdminsRoles = data.admins_types;
    if (!this.allActiveCountries.countries) {
      await this.fetchActiveCountries();
    }
  },
  data() {
    return {
      url: "/backend",
      min_date: "",
      max_date: "",
      rider_image_path: "",
      allActiveAdminsRoles: {},
      statesByCountry: {},
      citiesByState: {},
      states_key: 1,
      cities_key: 1,
      formData: {
        role_id: 4,
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        password_confirmation: "",
        city_id: "",
        state_id: "",
        country_id: "",
        zip_code: "",
        gender: "",
        address: "",
        dob: "",
        phone: "",
        vendor_id: this.$auth.user.id,
        is_active: false,
        is_credentials: true,
        image_id: "",
        latitude: "",
        longitude:"",
      },
      error: false,
    };
  },
  methods: {
    ...mapActions({
      addRiders: "Seller/Riders/addRiders",
      fetchActiveRiders: "General/fetchActiveRiders",
      fetchActiveCountries: "General/fetchActiveCountries",
      fetchActiveMedia: "General/fetchActiveMedia",
    }),
    imageSelected(id, path, img_resource, modal) {
      this.formData[modal] = id;
      this[img_resource] = path;
    },
    async getStatesByCountry(e) {
      this.formData.state_id = "";
      this.formData.city_id = "";
      const data = await this.$generalService.getStatesByCountry(e, null);
      if (data.states) {
        this.statesByCountry = data.states;
      }
      this.states_key += 1;
    },
    async getCitiesByState(e) {
      this.formData.city_id = "";
      const data = await this.$generalService.getCitiesByState(e);
      if (data.cities) {
        this.citiesByState = data.cities;
      }
      this.cities_key += 1;
    },
    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/seller/riders"));
      }
    },
    async addAndContinue() {
      await this.addRiders(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.user = "";
          this.formData.is_active = false;
          this.formData.first_name = "";
          this.formData.last_name = "";
          this.formData.gender = "";
          this.formData.address = "";
          this.formData.country_id = "";
          this.formData.state_id = "";
          this.formData.zip_code = "";
          this.formData.dob = "";
          this.formData.phone = "";
          this.rider_image_path = "";
          this.$toast.success(res.message);
          this.fetchActiveRiders();
        }
      });
    },
      getAddressData: function (addressData, placeResultData, id) {
      this.formData.address = placeResultData.formatted_address
      this.formData.latitude = addressData.latitude
      this.formData.longitude = addressData.longitude
    },
  },
  computed: {
    now: function () {
      var max_date = new Date();
      var min_date = new Date();
      min_date.setYear(min_date.getFullYear() - 100);
      max_date.setYear(max_date.getFullYear() -10);
      var max_date = new Date(max_date).toISOString();
      var min_date = new Date(min_date).toISOString();
      //const parsing_max_date = (today.getFullYear()-8)+'-'+(today.getMonth()+1)+'-'+today.getDate();
      //const parsing_min_date = (today.getFullYear()-100)+'-'+(today.getMonth()+1)+'-'+today.getDate();
      // const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
      return {
        min_date: min_date,
        max_date: max_date,
      };
    },
    ...mapGetters({
      allRiders: "Riders/allRiders",
      allActiveCountries: "General/allActiveCountries",
      allActiveMedia: "General/allActiveMedia",
    }),
  },
  watch: {
    statesByCountry: function (newValue) {
      this.states_key += 1;
    },
    citiesByState: function (newValue) {
      this.cities_key += 1;
    },
  },
  mounted() {},
};
</script>
