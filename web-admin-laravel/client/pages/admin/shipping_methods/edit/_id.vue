<template >
  <div class="">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ $t("form.shipping_method.edit_shipping_method") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{
                    $t("sidebar.home")
                  }}</nuxt-link>
                </li>
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/shipping_methods')">{{
                    $t("sidebar.shipping_method")
                  }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ $t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ $t("form.shipping_method.edit_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- Main content -->
    <section class="content pb-5">
      <div class="container" v-if="$fetchState.pending">
        <div class="row">
          <div class="col-md-12">
            <AdminLoader />
          </div>
        </div>
      </div>

      <div class="container" v-else>
        <div class="col-lg-12">
          <div class="card gutter-b border-0">
            <div class="card-body">
                <div class="row">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 my-1 ps-md-0" v-if="ups_shipping_options.length > 0">
                    <div role="group" >
                      <label for="input-live" class="form-label"
                        >{{ $t("form.shipping_method.shipping_service_type.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error[`active_option_indexes`]"
                      >
                        {{ error[`active_option_indexes`][0] }}
                      </span>
                      <v-select
                        class=""
                        :placeholder="$t('form.shipping_method.shipping_service_type.placeholder')"
                        v-model="ups_shipping_settings"
                        :reduce="(opt) => opt.name"
                        label="code"
                        :options="ups_shipping_options"
                        v-on:input="setUpsSettings"
                        multiple
                      >
                        <template slot="no-options">
                          {{ $t("form.search_select.no_options") }}
                        </template>
                        <template slot="option" slot-scope="option">
                          <div class="d-center">
                            {{ option.name }}
                          </div>
                        </template>
                        <template slot="selected-option" slot-scope="option">
                          <div class="selected d-center">
                            {{ option.name }}
                          </div>
                        </template>
                      </v-select>
                      <span class="heebo-light">
                        {{ $t("form.shipping_method.shipping_service_type.subheading") }}
                      </span>
                    </div>
                  </div>
                  <!-- These Checks are for (dnt generate empty divs) -->
                    <div class="col-md-6 my-1 ps-md-0" v-for="(setting,index) in formData.settings" :key="index" v-if="index != 'shipping_service_type_next_day_air' &&
                                              index != 'shipping_service_type_2nd_day_air' &&
                                              index != 'shipping_service_type_ground' &&
                                              index != 'shipping_service_type_new_day_air_saver' &&
                                              index != 'shipping_service_type_next_day_air_saver' &&
                                              index != 'shipping_service_type_next_day_air_early_am' &&
                                              index != 'shipping_service_type_2nd_day_air_am'"  >
                  <!-- These Checks are normal checks -->
                        <div role="group" v-if="index != 'shipping_service_type_next_day_air' &&
                                                  index != 'shipping_service_type_2nd_day_air' &&
                                                  index != 'shipping_service_type_ground' &&
                                                  index != 'shipping_service_type_new_day_air_saver' &&
                                                  index != 'shipping_service_type_next_day_air_saver' &&
                                                  index != 'shipping_service_type_next_day_air_early_am' &&
                                                  index != 'shipping_service_type_2nd_day_air_am' &&
                                                  index != 'country' &&
                                                  index != 'state' &&
                                                  index != 'city'">
                          <label for="input-live" class=" form-label">{{index}}</label>
                          <span class="float-end text-danger"
                                v-if="error && error[`settings.${index}`]">
                              {{ error[`settings.${index}`][0] }}
                            </span>
                            <v-select v-if="index == 'mode'"
                              class=""
                              :placeholder="$t('form.shipping_method.mode.placeholder')"
                              v-model="formData.settings[index]"
                              :reduce="(opt) => opt.value"
                              label="value"
                              :options="mode_options"
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
                            <v-select v-else-if="index == 'pickup_method'"
                              class=""
                              :placeholder="$t('form.shipping_method.pickup_method.placeholder')"
                              v-model="formData.settings[index]"
                              :reduce="(opt) => opt.value"
                              label="value"
                              :options="pickup_methods_options"
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
                            <label for="" class="form-label" v-else-if="index == 'weight'">in Gram</label>
                          <input  :class="error && error[`settings.${index}`] ? 'error' : ''"
                                 class="form-control"
                                 aria-describedby="input-live-help input-live-feedback"
                                 v-model="formData.settings[index]"
                                 :placeholder="index"
                                 :disabled="index == 'weight'"

                                 trim />
                         <span class=" heebo-light">
                             {{ index }}
                         </span>
                        </div>
                        <div role="group" v-else-if="index == 'country'">
                          <label for="input-live" class=" form-label">{{index}}</label>
                          <span class="float-end text-danger"
                                v-if="error && error[`settings.${index}`]">
                              {{ error[`settings.${index}`][0] }}
                            </span>
                            <AdminSearchSelectable :class="error && error[`settings.${index}`] ? 'error' : ''" apiMethod="activeCountries" responseKey="countries"
                              :initialOptions="allActiveCountries.countries" :selectedOptions="selected_country" :placeholder="$t('form.shipping_method.country.placeholder')" v-model="formData.settings[index]" v-on:input="getStatesByCountry($event)" />
                         <span class=" heebo-light">
                             {{ index }}
                         </span>
                        </div>
                        <div role="group" v-else-if="index == 'state'">
                          <label for="input-live" class=" form-label">{{index}}</label>
                          <span class="float-end text-danger"
                                v-if="error && error[`settings.${index}`]">
                              {{ error[`settings.${index}`][0] }}
                            </span>
                            <AdminSearchSelectable :class="error && error[`settings.${index}`] ? 'error' : ''" :search_id="formData.settings[index]" apiMethod="getStatesByCountry" responseKey="states"
                              :initialOptions="statesByCountry.states" :selectedOptions="selected_state" :placeholder="$t('form.shipping_method.state.placeholder')" :key="states_key" v-model="formData.settings[index]" v-on:input="getCitiesByState($event)" />
                         <span class=" heebo-light">
                             {{ index }}
                         </span>
                        </div>
                        <div role="group" v-else-if="index == 'city'">
                          <label for="input-live" class=" form-label">{{index}}</label>
                          <span class="float-end text-danger"
                                v-if="error && error[`settings.${index}`]">
                              {{ error[`settings.${index}`][0] }}
                            </span>
                            <AdminSearchSelectable :class="error && error[`settings.${index}`] ? 'error' : ''" :search_id="formData.settings[index]" apiMethod="getCitiesByState" responseKey="cities"
                              :initialOptions="citiesByState.cities" :selectedOptions="selected_city" :placeholder="$t('form.shipping_method.city.placeholder')" :key="cities_key" v-model="formData.settings[index]" />
                         <span class=" heebo-light">
                             {{ index }}
                         </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ $t("form.shipping_method.status.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.is_active"
                          :checked="formData.is_active ? 'checked' : ''"
                          type="checkbox"
                          @change="checkStatus"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>

                    <span class="heebo-light">
                      {{ $t("form.shipping_method.status.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 my-1 px-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ $t("form.shipping_method.is_default.label") }}
                      </label>

                      <div class="form-switch d-flex align-items-center">
                        <input
                          class="form-check-input"
                          v-model="formData.is_default"
                          :checked="formData.is_default ? 'checked' : ''"
                          type="checkbox"
                          @change="checkDefault"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.shipping_method.is_default.subheading") }}
                    </span>
                  </div>
                </div>
                 <hr class="text-primary">
              <div class="row">
                <div class="col-lg-12 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">{{$t('form.multilanguage')}}</h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.manufacturer.form_description") }}
                        </span>
                      </p>
                      <div class="row">
                        <div class="col-lg-12 d-md-flex px-0">
                          <ul
                            class="nav nav-tabs d-inline-block"
                            id="myTab"
                            role="tablist "
                          >
                            <li class="nav-item" role="presentation" :key="index" v-for="(language, index) in allActiveLanguages.languages">
                              <a
                                class="nav-link"
                                :class="index == 0 ? 'active' : ''"
                                :id="language.code + '-tab'"
                                data-bs-toggle="tab"
                                :href="'#' + language.code"
                                role="tab"
                                :aria-controls="language.code"
                                :aria-selected="index == 0 ? 'true' : 'false'"
                                >{{ language.name }}</a
                              >
                            </li>
                          </ul>

                          <div class="tab-content p-4" id="myTabContent">
                            <div class="tab-pane fade" :key="language.code" :class="index == 0 ? 'active show' : ''" v-for="(language, index ) in allActiveLanguages.languages" :id="language.code" role="tabpanel" :aria-labelledby="language.code + '-tab'">
                              <div class="row">
                                <div class="col-md-6 my-1">
                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t("form.shipping_method.name.label")
                                      }}:</label
                                    >
                                    <span
                                      class="float-end text-danger"
                                      v-if="
                                        error && error['name.' + language.code]
                                      "
                                    >
                                      {{ error["name." + language.code][0] }}
                                    </span>
                                    <input
                                      class="form-control"
                                      :class="
                                        error && error['name.' + language.code]
                                          ? 'error'
                                          : ''
                                      "
                                      v-model="formData.name[language.code]"
                                      aria-describedby="input-live-help input-live-feedback"
                                      :placeholder="
                                        $t('form.shipping_method.name.placeholder')
                                      "
                                      trim
                                    />
                                    <span class="heebo-light">
                                      {{
                                        $t("form.shipping_method.name.subheading")
                                      }}
                                    </span>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 my-1">
                                  <div role="group ">
                                    <label
                                      for="input-live"
                                      class="px-2 form-label"
                                      >{{
                                        $t(
                                          "form.shipping_method.description.label"
                                        )
                                      }}:</label
                                    >
                                    <span
                                      class="float-end text-danger"
                                      v-if="
                                        error &&
                                        error['description.' + language.code]
                                      "
                                    >
                                      {{
                                        error["description." + language.code][0]
                                      }}
                                    </span>
                                    <GlobalCkeditorNuxt
                                      v-model="
                                        formData.description[language.code]
                                      "
                                    />
                                    <span class="px-2 heebo-light">
                                      {{
                                        $t(
                                          "form.shipping_method.description.subheading"
                                        )
                                      }}
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 px-4 text-center text-md-end">
            <button
              type="button" :disabled="disabled"
              class="btn btn-secondary mb-3 px-3 py-2"
              @click="update"
              name="button"
            >
              {{ $t("form.update") }}
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- /.content -->

    <!-- /.content -->
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";

export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "shipping_methods.update",
    strategy: "update",
  },
  data() {
    return {
      //ups_shipping_options options for v-select
      ups_shipping_options: [],
      //ups_shipping_settings currently selected option of v-select
      ups_shipping_settings: [],
      statesByCountry:{},
      citiesByState:{},
      selected_city:'',
      selected_state:'',
      selected_country:'',
      states_key:1,
      cities_key:1,
      mode_options: [
        { value: '', text: this.$t('form.shipping_method.mode.placeholder') },
        { value: 'test', text: this.$t('form.shipping_method.mode.test') },
        { value: 'production', text: this.$t('form.shipping_method.mode.production') },
      ],
      pickup_methods_options: [
        { value: '', text: this.$t('form.shipping_method.pickup_method.placeholder') },
        { value: 'daily', text: this.$t('form.shipping_method.pickup_method.daily') },
        { value: 'cutomer_counter', text: this.$t('form.shipping_method.pickup_method.cutomer_counter') },
        { value: 'one_time', text: this.$t('form.shipping_method.pickup_method.one_time') },
        { value: 'on_call_air', text: this.$t('form.shipping_method.pickup_method.on_call_air') },
        { value: 'letter_center', text: this.$t('form.shipping_method.pickup_method.letter_center') },
        { value: 'air_service_center', text: this.$t('form.shipping_method.pickup_method.air_service_center') },
      ],
      formData: {
        id: this.$route.params.id,
        name: {},
        description: {},
        settings: {},
        //active_option_indexes options index in ups_shipping_options whose values are 1
        active_option_indexes:[],
        is_active: false,
        is_default: false,
      },
       disabled:false,
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.shipping_methods.show(
      this.$route.params.id
    );
    // get and update data
    this.formData.name = data.nameTranslations;
    this.formData.description = data.descriptionTranslations;
    this.formData.is_active = data.is_active;
    this.formData.is_default = data.is_default;
    for (var i = 0; i < data.settings.length; i++) {

      if(data.settings[i].name == 'shipping_service_type_next_day_air'
      || data.settings[i].name == 'shipping_service_type_2nd_day_air'
      || data.settings[i].name == 'shipping_service_type_ground'
      || data.settings[i].name == 'shipping_service_type_new_day_air_saver'
      || data.settings[i].name == 'shipping_service_type_next_day_air_saver'
      || data.settings[i].name == 'shipping_service_type_next_day_air_early_am'
      || data.settings[i].name == 'shipping_service_type_2nd_day_air_am' )
      {
        if(data.settings[i].value == "1"){
          //if 1 comes from DB it means it is selected by default
          this.ups_shipping_settings.push(data.settings[i].name);
          var option = {
            name: data.settings[i].name,
            value: "1",
          }
          this.ups_shipping_options.push(option)
          var finded = this.ups_shipping_options.findIndex((obj) => obj.name == data.settings[i].name)
          this.formData.active_option_indexes.push(finded)
        }else{
          var option = {
            name: data.settings[i].name,
            value: "0",
          }
          this.ups_shipping_options.push(option)
        }
      }
      this.formData.settings[data.settings[i].name] = data.settings[i].value;

      if(data.settings[i].name == 'country'){
        if(!this.allActiveCountries.countries){
          await this.fetchActiveCountries();
        }
        this.AllCountries = this.allActiveCountries.countries;
        var selected_country = this.AllCountries.data.find(item => item.id == data.settings[i].value);
        if(selected_country){
          this.selected_country = selected_country;
          this.formData.settings[data.settings[i].name] = parseInt(data.settings[i].value)
        }
        const states_data =  await this.$generalService.getStatesByCountry(parseInt(data.settings[i].value));
        if(states_data.states){
          this.statesByCountry = states_data.states;
        }

      }
      if(data.settings[i].name == 'state'){
      var selected_state = this.statesByCountry.states.data.find(item => item.id == parseInt(data.settings[i].value));
       if(selected_state){
          this.selected_state = selected_state;
          this.formData.settings[data.settings[i].name] = parseInt(data.settings[i].value)
      }
      const cities_data =  await this.$generalService.getCitiesByState(parseInt(data.settings[i].value));
      if(cities_data.cities){
        this.citiesByState = cities_data.cities;
      }
    }
      if(data.settings[i].name == 'city'){
      var selected_city = this.citiesByState.cities.data.find(item => item.id == parseInt(data.settings[i].value));
       if(selected_city){
          this.selected_city = selected_city;
          this.formData.settings[data.settings[i].name] = parseInt(data.settings[i].value)
          }
      }

    }


  },
    methods: {
    ...mapActions({
      updateShippingMethods: "ShippingMethods/updateShippingMethods",
      fetchActiveShippingMethods: "General/fetchActiveShippingMethods",
      fetchActiveCountries: 'General/fetchActiveCountries',
    }),
    checkDefault() {
      if (this.formData.is_default == 1) {
        this.formData.is_active = 1;
      }
    },
    checkStatus() {
      if (this.formData.is_active == 0) {
        this.formData.is_default = 0;
      }
    },
    setUpsSettings(){
        this.formData.active_option_indexes = []
      for (var i = 0; i < this.ups_shipping_settings.length; i++) {
          var finded = this.ups_shipping_options.findIndex((obj) => obj.name == this.ups_shipping_settings[i])
         this.formData.active_option_indexes.push(finded)
      }
    },
    async getStatesByCountry(e){
    //  var finded_satae = Object.keys(this.formData.settings).find(key => this.formData.settings[key] === e);
      this.formData.settings['state'] = ''
      this.formData.settings['city'] = ''
      this.selected_state = ''
      this.selected_city = ''
      const data =  await this.$generalService.getStatesByCountry(e);
      if(data.states){
        this.statesByCountry = data.states;
      }
      this.states_key+=1;
      },
    async getCitiesByState(e){
          this.formData.settings['city'] = ''
          this.selected_city = ''
        const data =  await this.$generalService.getCitiesByState(e);
        if(data.cities){
          this.citiesByState = data.cities;
        }
        this.cities_key+=1;
        },
    async update() {
      await this.updateAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/shipping_methods"));
      }
    },
    async updateAndContinue() {
          this.disabled=true
          for (var i = 0; i < this.ups_shipping_options.length; i++) {
                this.ups_shipping_options[i].value = "0"
          }
          for (var i = 0; i < this.formData.active_option_indexes.length; i++) {
                this.ups_shipping_options[this.formData.active_option_indexes[i]].value = "1"
          }
            for (var i = 0; i < this.ups_shipping_options.length; i++) {
              this.formData.settings[this.ups_shipping_options[i].name] = this.ups_shipping_options[i].value;
            }
      await this.updateShippingMethods({
        formData: this.formData,
        id: this.$route.params.id,
      }).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else if (res.state == "fail") {
          this.$toast.error(res.message);
        } else {
          this.error = false;
          this.$toast.success(res.message);
          this.fetchActiveShippingMethods();
        }
      });
        this.disabled=false
    },
  },
  mounted() {},
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
      allActiveCountries: 'General/allActiveCountries',
    }),
  },
};
</script>
