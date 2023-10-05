<template >
  <div class="address-wrap">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content m-0" v-if="addresses_index">
      <div class="address-index-wrap">
        <div class="card gutter-b border-0">
          <div class="card-header p-0">
            <div class="row table-filter-row g-0">
              <!-- Small boxes (Stat box) -->
              <div class="col-12 d-flex justify-content-end">
                <div slot="table-actions">
                  <button
                    type="button"
                    @click="addAddress()"
                    v-tooltip="{ content: 'Add Address' }"
                    class="btn add px-3 rounded"
                    name="button"
                  >
                    <fa :icon="['fas', 'plus']" fixed-width />
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="col-md-12">
              <vue-good-table
                v-if="!$fetchState.pending"
                mode="remote"
                :columns="columns"
                :rows="rows"
                :totalRows="totalRows"
                @on-page-change="onPageChange"
                @on-sort-change="onSortChange"
                @on-per-page-change="onPerPageChange"
                :line-numbers="true"
                styleClass="vgt-table striped overflow-hidden"
                row-style-class="m-5"
              >
                <template slot="table-row" slot-scope="props">
                  <div v-if="props.column.field == 'is_active'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeAddressStatus(props.row.id, event)
                        "
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <div v-if="props.column.field == 'is_default'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeDefaultAddress(props.row.id, event)
                        "
                        :checked="props.row.is_default == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <div v-else-if="props.column.field == 'actions'">
                    <button
                      class="btn btn-md rounded-circle text-primary"
                      v-tooltip="{ content: 'Show' }"
                      @click="viewAddress(props.row.id)"
                    >
                      <fa :icon="['fas', 'eye']" fixed-width />
                    </button>
                    <button
                      class="btn btn-md rounded-circle text-success"
                      v-tooltip="{ content: 'Edit' }"
                      @click="editAddress(props.row.id)"
                    >
                      <fa :icon="['fas', 'edit']" fixed-width />
                    </button>
                    <button
                      v-tooltip="{ content: 'Delete' }"
                      type="button"
                      class="btn btn-md rounded-circle text-danger"
                      name="button"
                      data-bs-toggle="modal"
                      :data-bs-target="'#DeleteItem' + props.row.id"
                    >
                      <fa :icon="['fas', 'trash-alt']" fixed-width />
                    </button>
                    <AdminDeleteModal
                      :modal_id="'DeleteItem' + props.row.id"
                      @deleteClicked="deleteAddress(props.row.id)"
                      :delete_id="props.row.id"
                    >
                    </AdminDeleteModal>
                  </div>
                  <span v-else>
                    {{ props.formattedRow[props.column.field] }}
                  </span>
                </template>
                <div slot="emptystate">
                  {{ $t("table.table_empty_message") }}
                </div>
              </vue-good-table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content m-0" v-if="addresses_create || addresses_edit">
      <div class="row">
        <div class="col-lg-12">
          <div class="card gutter-b border-0">
            <div class="card-body p-0">
              <div class="row g-4 needs-validation">
                <div class="col-md-6">
                  <div role="group">
                    <label for="input-live" class="form-label text-capitalize"
                      >{{ this.$t("form.customer.country.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="errors && errors.country_id"
                    >
                      {{ errors.country_id[0] }}
                    </span>
                    <AdminSearchSelectable
                      :class="errors && errors.country_id ? 'errors' : ''"
                      apiMethod="activeCountries"
                      responseKey="countries"
                      :initialOptions="allActiveCountries"
                      :selectedOptions="
                        selected_country ? selected_country : ''
                      "
                      :placeholder="
                        this.$t('form.customer.country.placeholder')
                      "
                      v-model="formData.country_id"
                      v-on:input="getStatesByCountry($event)"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div role="group">
                    <label for="input-live" class="form-label text-capitalize"
                      >{{ this.$t("form.customer.state.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="errors && errors.state_id"
                    >
                      {{ errors.state_id[0] }}
                    </span>
                    <AdminSearchSelectable
                      :class="errors && errors.state_id ? 'errors' : ''"
                      :search_id="formData.country_id"
                      apiMethod="getStatesByCountry"
                      responseKey="states"
                      :initialOptions="statesByCountry.states"
                      :disabled="statesByCountry.states ? false : true"
                      :selectedOptions="selected_state ? selected_state : ''"
                      :placeholder="this.$t('form.customer.state.placeholder')"
                      :key="states_key"
                      v-model="formData.state_id"
                      v-on:input="getCitiesByState($event)"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div role="group">
                    <label for="input-live" class="form-label text-capitalize"
                      >{{ this.$t("form.customer.city.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="errors && errors.city_id"
                    >
                      {{ errors.city_id[0] }}
                    </span>
                    <AdminSearchSelectable
                      :class="errors && errors.city_id ? 'errors' : ''"
                      :search_id="formData.state_id"
                      apiMethod="getCitiesByState"
                      responseKey="cities"
                      :initialOptions="citiesByState.cities"
                      :disabled="citiesByState.cities ? false : true"
                      :selectedOptions="selected_city ? selected_city : ''"
                      :placeholder="this.$t('form.customer.city.placeholder')"
                      :key="cities_key"
                      v-model="formData.city_id"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div role="group">
                    <label for="input-live" class="form-label text-capitalize"
                      >{{ this.$t("form.customer.zip_code.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="errors && errors.zip_code"
                    >
                      {{ errors.zip_code[0] }}
                    </span>
                    <input
                      :class="errors && errors.zip_code ? 'errors' : ''"
                      class="form-control"
                      v-model="formData.zip_code"
                      aria-describedby="input-live-help input-live-feedback"
                      :placeholder="
                        this.$t('form.customer.zip_code.placeholder')
                      "
                      trim
                    />
                  </div>
                </div>
                            <div class="col-md-6">
                  <div role="group">
                    <label for="input-live" class="form-label text-capitalize"
                      >{{ this.$t("form.customer.near_by.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="errors && errors.near_by"
                    >
                      {{ errors.near_by[0] }}
                    </span>
                    <input
                      :class="errors && errors.near_by ? 'errors' : ''"
                      class="form-control"
                      v-model="formData.near_by"
                      aria-describedby="input-live-help input-live-feedback"
                      :placeholder="
                        this.$t('form.customer.near_by.placeholder')
                      "
                      trim
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div role="group">
                    <label for="input-live" class="form-label text-capitalize"
                      >{{ this.$t("form.customer.address.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="errors && errors.address"
                    >
                      {{ errors.address[0] }}
                    </span>
                    <!-- <textarea
                      class="form-control"
                      :placeholder="
                        this.$t('form.customer.address.placeholder')
                      "
                      v-model="formData.address"
                      aria-describedby="input-live-help input-live-feedback"
                      rows="8"
                      cols="50"
                    ></textarea> -->
                    <vue-google-autocomplete
                        id="map"
                        classname="form-control"
                        :placeholder="
                        this.$t('form.customer.address.placeholder')
                      "
                        v-on:placechanged="getAddressData"
                        v-model="formData.address"
                    >
                    </vue-google-autocomplete>
                  </div>
                </div>
                <div class="col-md-6">
                  <div role="group">
                    <label for="input-live" class="form-label text-capitalize"
                      >{{ this.$t("form.customer.phone.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="errors && errors.phone"
                    >
                      {{ errors.phone[0] }}
                    </span>
                    <input
                      :class="errors && errors.phone ? 'errors' : ''"
                      class="form-control"
                      v-model="formData.phone"
                      aria-describedby="input-live-help input-live-feedback"
                      :placeholder="this.$t('form.customer.phone.placeholder')"
                      trim
                    />
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="d-flex align-items-center">
                    <div class="form-switch d-flex align-items-center">
                      <input
                        class="form-check-input"
                        v-model="formData.is_default"
                        :checked="formData.is_default ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                    </div>
                    <label class="label form-label ms-2 mb-0">
                      {{ this.$t("web.form.customer.is_default.label") }}
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-end">
        <a
          class="
            btn
            bg-dark
            text-white
            rounded
            py-2
            px-3
            fw-bold
            text-uppercase
            mt-5
          "
          @click="back"
          v-if="addresses_edit || addresses_create"
        >
          Back
        </a>
        <a
          v-if="addresses_create"
          class="
            btn btn-primary
            rounded
            py-2
            px-3
            fw-bold
            text-uppercase
            mt-5
            ms-3
          "
          @click="create"
        >
          {{ this.$t("form.add") }}
        </a>
        <a
          class="
            btn
            bg-warning
            rounded
            py-2
            px-3
            fw-bold
            text-uppercase
            mt-5
            ms-3
          "
          @click="update"
          v-if="addresses_edit"
        >
          Update
        </a>
      </div>
    </section>

    <section class="content m-0" v-if="addresses_view">
      <div class="card gutter-b border-0">
        <div class="card-body p-0">
          <div class="show-table px-0">
            <div class="row">
              <div
                class="
                  col-md-6 col-12
                  d-flex
                  justify-content-md-start justify-content-center
                  h-100
                "
              >
                <div class="rounded shadow border p-3 w-75 mb-3 mt-3">
                  <span class="fw-bold h5 text-capitalize">
                    {{ this.$t("form.address.country.label") }}: &nbsp;</span
                  >
                  <span class="text-muted h6">{{ address.country.name }}</span>
                </div>
              </div>
              <div
                class="
                  col-md-6 col-12
                  d-flex
                  justify-content-md-start justify-content-center
                  h-100
                "
              >
                <div class="rounded shadow border p-3 w-75 mb-3 mt-3">
                  <span class="fw-bold h5 text-capitalize">
                    {{ this.$t("form.address.zip_code.label") }}: &nbsp;</span
                  >
                  <span class="text-muted h6">{{ address.zip_code }}</span>
                </div>
              </div>
              <div
                class="
                  col-md-6 col-12
                  d-flex
                  justify-content-md-start justify-content-center
                  h-100
                "
              >
                <div class="rounded shadow border p-3 w-75 mb-3 mt-3">
                  <span class="fw-bold h5 text-capitalize">
                    {{ this.$t("form.address.city.label") }}: &nbsp;</span
                  >
                  <span class="text-muted h6">{{ address.city.name }}</span>
                </div>
              </div>
              <div
                class="
                  col-md-6 col-12
                  d-flex
                  justify-content-md-start justify-content-center
                  h-100
                "
              >
                <div class="rounded shadow border p-3 w-75 mb-3 mt-3">
                  <span class="fw-bold h5 text-capitalize">
                    {{ this.$t("form.address.state.label") }}: &nbsp;</span
                  >
                  <span class="text-muted h6">{{ address.state.name }}</span>
                </div>
              </div>
              <div
                class="
                  col-md-6 col-12
                  d-flex
                  justify-content-md-start justify-content-center
                  h-100
                "
              >
                <div class="rounded shadow border p-3 w-75 mb-3 mt-3">
                  <span class="fw-bold h5 text-capitalize">
                    {{ this.$t("form.address.is_default.label") }}: &nbsp;</span
                  >
                  <span class="text-muted h6" v-if="address.is_default">{{$t('yes')}}</span>
                  <span class="text-muted h6" v-else>{{$t('no')}}</span>
                </div>
              </div>
                  <div
                class="
                  col-md-6 col-12
                  d-flex
                  justify-content-md-start justify-content-center
                  h-100
                "
              >
                <div class="rounded shadow border p-3 w-75 mb-3 mt-3">
                  <span class="fw-bold h5 text-capitalize">
                    {{ this.$t("form.address.phone.label") }}: &nbsp;</span
                  >
                  <span class="text-muted h6" v-if="address.phone">{{address.phone}}</span>
                </div>
              </div>
            <div
                class="
                  col-md-6 col-12
                  d-flex
                  justify-content-md-start justify-content-center
                  h-100
                "
              >
                <div class="rounded shadow border p-3 w-75 mb-3 mt-3">
                  <span class="fw-bold h5 text-capitalize"
                    >{{ this.$t("form.address.near_by.label") }}: &nbsp;</span
                  >
                  <span class="text-muted h6">{{ address.near_by }}</span>
                </div>
              </div>
              <div
                class="
                  col-md-6 col-12
                  d-flex
                  justify-content-md-start justify-content-center
                  h-100
                "
              >
                <div class="rounded shadow border p-3 w-75 mb-3 mt-3">
                  <span class="fw-bold h5 text-capitalize"
                    >{{ this.$t("form.address.address.label") }}: &nbsp;</span
                  >
                  <span class="text-muted h6">{{ address.address }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-end">
        <a
          class="
            btn
            bg-dark
            text-white
            rounded
            py-2
            px-3
            fw-bold
            text-uppercase
            mt-4
          "
          @click="back"
        >
          {{$t('back')}}
        </a>
      </div>
    </section>
  </div>
</template>
<script >
import productMixin from "~/mixins/productMixin.js";
import { mapGetters, mapActions } from "vuex";
import datatableMixin from "~/mixins/datatableMixin.js";
export default {
  mixins: [datatableMixin],
  data() {
    return {
      selected_city: "",
      selected_state: "",
      selected_country: "",
      allAddresses: "",
      address: "",
      addresses_index: true,
      addresses_create: false,
      addresses_edit: false,
      addresses_view: false,
      address_id: "",
      statesByCountry: {},
      citiesByState: {},
      states_key: 1,
      cities_key: 1,
      formData: {
        id: "",
        city_id: "",
        state_id: "",
        country_id: "",
        zip_code: "",
        is_default: false,
        phone: "",
        address: "",
        near_by:"",
        latitude: "",
        longitude:""
      },
      error: false,
      errors: "",
      columns: [
        {
          label: this.$t("columns.country"),
          field: "country.name",
          sortable: false,
        },
        {
          label: this.$t("columns.state"),
          field: "state.name",
          sortable: false,
        },
        {
          label: this.$t("columns.city"),
          field: "city.name",
          sortable: false,
        },
        {
          label: this.$t("columns.address"),
          field: "address",
          sortable: false,
        },
        {
          label: this.$t("columns.zip_code"),
          field: "zip_code",
          sortable: false,
        },
        {
          label: this.$t("columns.phone"),
          field: "phone",
          sortable: false,
        },
        {
          label: this.$t("columns.is_default"),
          field: "is_default",
          sortable: false,
        },
        {
          label: this.$t("columns.actions"),
          field: "actions",
          sortable: false,
        },
      ],
    };
  },
  async fetch() {
    const { data } = await this.$webService.customerAllAddresses();
    if (data) {
      this.allAddresses = data;
    }
  },
  methods: {
    ...mapActions({
      fetchActiveCountries: "Web/General/fetchActiveCountries",
    }),
    async addAddress() {
      await this.fetchActiveCountries();

      this.addresses_index = false;
      this.addresses_create = true;
      this.addresses_edit = false;
      this.addresses_view = false;
    },
    async viewAddress(id) {
      this.address_id = id;
      const { data } = await this.$webService.viewCustomerAddress(
        this.address_id
      );
      if (data) {
        (this.address = data), (this.addresses_index = false);
        this.addresses_create = false;
        this.addresses_edit = false;
        this.addresses_view = true;
      }
    },
    async editAddress(id) {
      if (!this.allActiveCountries) {
        await this.fetchActiveCountries();
      }
      this.address_id = id;
      const { data } = await this.$webService.viewCustomerAddress(
        this.address_id
      );
      if (data) {
        if (data.country) {
          this.formData.country_id = data.country.id;
          this.selected_country = data.country;
        }
        if (data.state) {
          this.formData.state_id = data.state.id;
          await this.setStatesByCountry(data.country.id);
          this.selected_state = data.state;
        }
        if (data.city) {
          this.formData.city_id = data.city.id;
          await this.setCitiesByState(data.state.id);
          this.selected_city = data.city;
        }
        this.formData.zip_code = data.zip_code;
        this.formData.address = data.address;
        this.formData.near_by = data.near_by;
        this.formData.is_default = data.is_default;
        this.formData.phone = data.phone;
        this.formData.latitude = data.latitude;
        this.formData.longitude = data.longitude;
        this.addresses_index = false;
        this.addresses_create = false;
        this.addresses_edit = true;
        this.addresses_view = false;
      }
    },
    async deleteAddress(id) {
      await this.$webService.deleteCustomerAddress(id).then((res) => {
        // some error occur
        if (res.state == "fail") {
          if (res.message) {
            this.$toast.error(res.message);
          }
        } else {
          this.addresses_index = true;
          this.addresses_create = false;
          this.addresses_edit = false;
          this.addresses_view = false;
          if (res.message) {
            this.$toast.success(res.message);
          }
          this.$fetch();
        }
        this.error = false;
        this.errors = "";
      });
    },
    async create() {
      await this.$webService
        .addCustomerAddress(this.formData)
        .then((res) => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data;
            this.$toast.error(res.response.data.message);
          } else {
            this.error = false;
            this.formData.city_id = "";
            this.formData.address = "";
            this.formData.zip_code = "";
            this.formData.country_id = "";
            this.formData.near_by = "";
            this.formData.customer_id = "";
            this.formData.state_id = "";
            this.formData.is_default = false;
            this.formData.phone = "";
            this.$toast.success(res.message);
            this.addresses_index = true;
            this.addresses_create = false;
            this.addresses_edit = false;
            this.addresses_view = false;
            this.error = false;
            this.errors = "";
            this.$fetch();
          }
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
    back() {
      this.formData.city_id = "";
      this.statesByCountry = "";
      this.citiesByState = "";
      this.formData.address = "";
       this.formData.near_by = "";
      this.formData.zip_code = "";
      this.formData.country_id = "";
      this.formData.customer_id = "";
      this.formData.state_id = "";
      this.formData.phone = "";
      this.is_default = false;
      this.error = false;
      this.errors = "";
      this.addresses_index = true;
      this.addresses_create = false;
      this.addresses_edit = false;
      this.addresses_view = false;
      this.$fetch();
    },
    async update() {
      this.formData.id = this.address_id;
      await this.$webService
        .updateCustomerAddress(this.formData)
        .then((res) => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data;
            this.$toast.error(res.response.data.message);
          } else {
            this.error = false;
            this.statesByCountry = "";
            this.citiesByState = "";
            this.formData.city_id = "";
            this.formData.address = "";
            this.formData.near_by = "";
            this.formData.zip_code = "";
            this.formData.country_id = "";
            this.formData.state_id = "";
            this.formData.phone = "";
            this.formData.selected_country = "";
            this.formData.selected_state = "";
            this.formData.selected_city = "";
            this.formData.is_default = false;
            this.$toast.success(res.message);
            this.addresses_index = true;
            this.addresses_create = false;
            this.addresses_edit = false;
            this.addresses_view = false;
            this.errors = "";
            this.$fetch();
          }
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },

    async getStatesByCountry(e) {
      this.formData.state_id = "";
      this.formData.city_id = "";
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
      this.formData.city_id = "";
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
    async changeDefaultAddress(id, event) {
      await this.$webService.updateCustomerdefaultAddress({
        is_default:  event.target.checked,
        address_id: id,
      }).then((response) => {
        if (!response.success) {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.success) {
          this.$toast.success(response.message);
           this.$fetch();
        }
      });
    },
    async changeAddressStatus(id, event) {
      await this.updateAddressStatus({
        filterData: this.filterData,
        address_id: id,
      })
        .then((response) => {
          if (response.state == "fail") {
            this.$toast.error(response.message);
            event.target.checked = !event.target.checked;
          }
          if (response.state == "success") {
            this.$toast.success(response.message);
            this.fetchActiveAddresses();
          }
        })
        .catch((e) => {
          event.target.checked = !event.target.checked;
        });
    },
     getAddressData: function (addressData, placeResultData, id) {
      this.formData.address = placeResultData.formatted_address
      this.formData.latitude = addressData.latitude
      this.formData.longitude = addressData.longitude
    },
  },

  computed: {
    ...mapGetters({
      allActiveCountries: "Web/General/allActiveCountries",
    }),
  },
  mounted() {},
  watch: {
    allAddresses(newCount, oldCount) {
      if (
        this.allAddresses &&
        this.allAddresses != null &&
        this.allAddresses.data != null
      ) {
        this.rows = this.allAddresses.data;
        this.totalRows = this.allAddresses.meta.total;
        if (this.filterData.page != this.allAddresses.meta.current_page) {
          this.filterData.page = this.allAddresses.meta.current_page;
        }
        if (this.filterData.perPage != this.allAddresses.meta.per_page) {
          this.filterData.perPage = this.allAddresses.meta.per_page;
        }
      }
    },
    statesByCountry: function (newValue) {
      this.states_key += 1;
    },
    citiesByState: function (newValue) {
      this.cities_key += 1;
    },
  },
};
</script>
