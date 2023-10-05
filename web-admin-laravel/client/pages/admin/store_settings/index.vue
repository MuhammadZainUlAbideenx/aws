<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.store_settings.store_settings") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{ this.$t("sidebar.home") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("sidebar.store_setting") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.store_settings.form_description") }}
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
         <AdminFormLoader/>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0" >
              <div class="card-body p-4">
                <div class="row bg-section gutter-b p-4 rounded-md">
                  <h3 class="">{{ $t("form.store_settings.general_configurations.heading") }}</h3>

                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.web_mode.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.web_mode">
                          {{ error.web_mode[0] }}
                        </span>
                        <v-select
                          class=""
                          :placeholder="this.$t('form.store_settings.web_mode.placeholder')"
                          v-model="formData.web_mode"
                          :reduce="(opt) => opt.value"
                          label="value"
                          :options="web_mode_options"
                        >
                          <template slot="no-options">
                            {{ $t("form.search_select.no_options") }}
                          </template>
                          <template slot="option" slot-scope="option">
                            <div class="d-center">
                              {{ option.text }}
                            </div>
                          </template>
                          <template slot="selected-option" slot-scope="option">
                            <div class="selected d-center">
                              {{ option.text }}
                            </div>
                          </template>
                        </v-select>
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.web_mode.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.maintenance_text.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.maintenance_text">
                          {{ error.maintenance_text[0] }}
                        </span>
                      <input :class="error && error.maintenance_text ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.maintenance_text"
                             :placeholder="this.$t('form.store_settings.maintenance_text.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.maintenance_text.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.web_url.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.web_url">
                          {{ error.web_url[0] }}
                        </span>
                      <input :class="error && error.web_url ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.web_url"
                             :placeholder="this.$t('form.store_settings.web_url.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.web_url.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.android_app_link.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.android_app_link">
                          {{ error.android_app_link[0] }}
                        </span>
                      <input :class="error && error.android_app_link ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.android_app_link"
                             :placeholder="this.$t('form.store_settings.android_app_link.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.android_app_link.subheading") }}
                     </span>
                    </div>
                  </div>

                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.apple_app_link.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.apple_app_link">
                          {{ error.apple_app_link[0] }}
                        </span>
                      <input :class="error && error.apple_app_link ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.apple_app_link"
                             :placeholder="this.$t('form.store_settings.apple_app_link.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.apple_app_link.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.app_name.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.app_name">
                          {{ error.app_name[0] }}
                        </span>
                      <input :class="error && error.app_name ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.app_name"
                             :placeholder="this.$t('form.store_settings.app_name.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.app_name.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.new_product_duration.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.new_product_duration">
                          {{ error.new_product_duration[0] }}
                        </span>
                      <input :class="error && error.new_product_duration ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.new_product_duration"
                             :placeholder="this.$t('form.store_settings.new_product_duration.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.new_product_duration.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.google_map_api.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.google_map_api">
                          {{ error.google_map_api[0] }}
                        </span>
                      <input :class="error && error.google_map_api ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.google_map_api"
                             :placeholder="this.$t('form.store_settings.google_map_api.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.google_map_api.subheading") }}
                     </span>
                    </div>
                  </div>
                </div>
                <div class="row  bg-section gutter-b p-4 rounded-md">
                  <h3 class="">{{ $t("form.store_settings.emial_configurations.heading") }}</h3>

                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.contact_us_email.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.contact_us_email">
                          {{ error.contact_us_email[0] }}
                        </span>
                      <input :class="error && error.contact_us_email ? 'error' : ''"
                             class="form-control"
                             type="email"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.contact_us_email"
                             :placeholder="this.$t('form.store_settings.contact_us_email.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.contact_us_email.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.order_email.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.order_email">
                          {{ error.order_email[0] }}
                        </span>
                      <input :class="error && error.order_email ? 'error' : ''"
                             class="form-control"
                             type="email"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.order_email"
                             :placeholder="this.$t('form.store_settings.order_email.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.order_email.subheading") }}
                     </span>
                    </div>
                  </div>
                </div>
                <div class="row  bg-section gutter-b p-4 rounded-md">
                  <h3 class="">{{ $t("form.store_settings.order_configurations.heading") }}</h3>

                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.free_ship_min_price.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.free_ship_min_price">
                          {{ error.free_ship_min_price[0] }}
                        </span>
                      <input :class="error && error.free_ship_min_price ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.free_ship_min_price"
                             :placeholder="this.$t('form.store_settings.free_ship_min_price.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.free_ship_min_price.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.min_order_price.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.min_order_price">
                          {{ error.min_order_price[0] }}
                        </span>
                      <input :class="error && error.min_order_price ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.min_order_price"
                             :placeholder="this.$t('form.store_settings.min_order_price.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.min_order_price.subheading") }}
                     </span>
                    </div>
                  </div>
                </div>
                <div class="row  bg-section p-4 rounded-md">
                  <h3 class="">{{ $t("form.store_settings.our_configurations.heading") }}</h3>

                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.phone.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.phone">
                          {{ error.phone[0] }}
                        </span>
                      <input :class="error && error.phone ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.phone"
                             :placeholder="this.$t('form.store_settings.phone.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.phone.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.country.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.country_id">
                          {{ error.country_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.country_id ? 'error' : ''" apiMethod="activeCountries" responseKey="countries"
                          :initialOptions="allActiveCountries.countries" :selectedOptions="selected_country" :placeholder="this.$t('form.store_settings.country.placeholder')" v-model="formData.country_id" v-on:input="getStatesByCountry($event)" />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.country.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.state.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.state_id">
                          {{ error.state_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.state_id ? 'error' : ''" :search_id="formData.country_id" apiMethod="getStatesByCountry" responseKey="states"
                          :initialOptions="statesByCountry.states" :selectedOptions="selected_state" :placeholder="this.$t('form.store_settings.state.placeholder')" :key="states_key" v-model="formData.state_id" v-on:input="getCitiesByState($event)" />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.state.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.city.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.city_id">
                          {{ error.city_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.city_id ? 'error' : ''" :search_id="formData.state_id" apiMethod="getCitiesByState" responseKey="cities"
                          :initialOptions="citiesByState.cities" :selectedOptions="selected_city" :placeholder="this.$t('form.store_settings.city.placeholder')" :key="cities_key" v-model="formData.city_id" />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.city.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.zip_code.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.zip_code">
                          {{ error.zip_code[0] }}
                        </span>
                      <input :class="error && error.zip_code ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.zip_code"
                             :placeholder="this.$t('form.store_settings.zip_code.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.zip_code.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.address.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.address">
                          {{ error.address[0] }}
                        </span>
                    <textarea class="form-control" :placeholder="this.$t('form.store_settings.address.placeholder')"  v-model="formData.address" aria-describedby="input-live-help input-live-feedback" rows="8" cols="50"></textarea>
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.address.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.longitude.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.longitude">
                          {{ error.longitude[0] }}
                        </span>
                      <input :class="error && error.longitude ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.longitude"
                             :placeholder="this.$t('form.store_settings.longitude.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.longitude.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.store_settings.latitude.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.latitude">
                          {{ error.latitude[0] }}
                        </span>
                      <input :class="error && error.latitude ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.latitude"
                             :placeholder="this.$t('form.store_settings.latitude.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.store_settings.latitude.subheading") }}
                     </span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="row" v-permission="'store_settings.update'">
                  <div class="col-md-12 px-4 text-center text-md-end">
                    <button type="button"
                            class="btn btn-primary mb-3 px-3 py-2"
                            @click="update()"
                            name="button">
                        {{ this.$t("form.update") }}
                      </button>
                  </div>
                </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

</template>
<script >
// import CkeditorNuxt from "@/components/global/ckeditorNuxt";
  import { mapGetters, mapActions } from 'vuex'
  export default {
    layout: 'admin',
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'store_settings.index',
      strategy: 'index'
    },
    async fetch(){
      if(!this.allActiveCountries.countries){
        await this.fetchActiveCountries();

      }
      if(this.allActiveSettings && this.allActiveSettings.settings && this.allActiveSettings.settings.specificSettings){
        this.formData.zip_code = this.allActiveSettings.settings.specificSettings.zip_code
        this.formData.address = this.allActiveSettings.settings.specificSettings.address
        this.formData.phone = this.allActiveSettings.settings.specificSettings.phone
        this.formData.web_mode = this.allActiveSettings.settings.specificSettings.web_mode
        this.formData.web_url = this.allActiveSettings.settings.specificSettings.web_url
        this.formData.maintenance_text = this.allActiveSettings.settings.specificSettings.maintenance_text
        this.formData.android_app_link = this.allActiveSettings.settings.specificSettings.android_app_link
        this.formData.apple_app_link = this.allActiveSettings.settings.specificSettings.apple_app_link
        this.formData.app_name = this.allActiveSettings.settings.specificSettings.app_name
        this.formData.new_product_duration = this.allActiveSettings.settings.specificSettings.new_product_duration
        this.formData.google_map_api = this.allActiveSettings.settings.specificSettings.google_map_api
        this.formData.contact_us_email = this.allActiveSettings.settings.specificSettings.contact_us_email
        this.formData.order_email = this.allActiveSettings.settings.specificSettings.order_email
        this.formData.min_order_price = this.allActiveSettings.settings.specificSettings.min_order_price
        this.formData.free_ship_min_price = this.allActiveSettings.settings.specificSettings.free_ship_min_price
        this.formData.latitude = this.allActiveSettings.settings.specificSettings.latitude
        this.formData.longitude = this.allActiveSettings.settings.specificSettings.longitude
        this.getStatesByCountry(this.allActiveSettings.settings.specificSettings.country_id)
        this.setStateByCountry(this.allActiveSettings.settings.specificSettings.country_id)
        this.getCitiesByState(this.allActiveSettings.settings.specificSettings.state_id)
        this.setCityByState(this.allActiveSettings.settings.specificSettings.state_id)
        this.AllCountries = this.allActiveCountries.countries;
        var selected_country = this.AllCountries.data.find(item => item.id == this.allActiveSettings.settings.specificSettings.country_id);
        if(selected_country){
          this.selected_country = selected_country;
          this.formData.country_id = selected_country.id
        }
      }
    },
    data() {
      return {
        web_mode_options: [
          { value: '', text: this.$t('form.store_settings.web_mode.placeholder') },
          { value: 'maintenance', text: this.$t('form.store_settings.web_mode.maintenance') },
          { value: 'development', text: this.$t('form.store_settings.web_mode.development') },
          { value: 'production', text: this.$t('form.store_settings.web_mode.production') },
          { value: 'local', text: this.$t('form.store_settings.web_mode.local') },
        ],
        statesByCountry:[],
        citiesByState:[],
        AllCountries:[],
        states_key:1,
        cities_key:1,
        selected_city:'',
        selected_state:'',
        selected_country:'',
        formData:{
          city_id:'',
          state_id:'',
          country_id:'',
          zip_code:'',
          address:'',
          phone: '',
          web_mode:'',
          maintenance_text:'',
          web_url:'',
          android_app_link:'',
          apple_app_link:'',
          app_name:'',
          new_product_duration:'',
          google_map_api:'',
          contact_us_email:'',
          order_email:'',
          min_order_price:'',
          free_ship_min_price:'',
          latitude:'',
          longitude:'',
          settings:'store_settings',
        },
        error: false
      }
    },
    methods: {
      ...mapActions({
        addSettings: 'Settings/addSettings',
        fetchActiveSettings: 'General/fetchActiveSettings',
        fetchActiveCountries: 'General/fetchActiveCountries',
      }),
      async getStatesByCountry(e){
        this.formData.state_id = '';
        this.selected_state = '';
        this.formData.city_id = '';
        this.selected_city = '';
        const data =  await this.$generalService.getStatesByCountry(e);
        if(data.states){
          this.statesByCountry = data.states;
        }
        this.states_key+=1;
    },
        async setStateByCountry(e){
          const data =  await this.$generalService.getStatesByCountry(e);
          if(data.states){
            this.statesByCountry = data.states;
           var selected_state = this.statesByCountry.states.data.find(item => item.id == this.allActiveSettings.settings.specificSettings.state_id);
            if(selected_state){
              this.selected_state = selected_state;
              this.formData.state_id = selected_state.id
            }
          }
        },
      async getCitiesByState(e){
          this.formData.city_id = '';
          this.selected_city = '';
          const data =  await this.$generalService.getCitiesByState(e);
          if(data.cities){
            this.citiesByState = data.cities;
            }
          this.cities_key+=1;
        },
      async setCityByState(e){
              const data =  await this.$generalService.getCitiesByState(e);
              if(data.cities){
                this.citiesByState = data.cities;
                var selected_city = this.citiesByState.cities.data.find(item => item.id == this.allActiveSettings.settings.specificSettings.city_id);
                if(selected_city){
                  this.selected_city = selected_city;
                  this.formData.city_id = selected_city.id;
              }
            }
          },
      async update() {
        await this.addSettings(this.formData)
        .then(
            res => {
              if (res.response) {
                this.error = res.response.data.errors ?? res.response.data
                this.$toast.error(res.response.data.message)
              } else {
                this.fetchActiveSettings();
                this.error = false
                this.$toast.success(res.message)
              }
            })
          }
    },
    computed:{
      ...mapGetters({
        allActiveSettings: 'General/allActiveSettings',
        allActiveCountries: 'General/allActiveCountries'
      })
    },
    watch:{
      statesByCountry: function(newValue) {
        this.states_key+=1
      },
      citiesByState: function(newValue) {
        this.cities_key+=1
      },
    }
  }

</script>
