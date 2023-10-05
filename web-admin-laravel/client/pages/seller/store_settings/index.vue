<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.vendor.store_settings") }}
          </h2>
        </div>
        <!-- /.col -->
     <!-- <div class="row">
          <div class="col-sm-12 px-0">
            <ol class="breadcrumb float-sm-right text-body">
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/admin/dashboard')">{{
                  this.$t("sidebar.home")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/admin/vendors')">{{
                  this.$t("sidebar.vendor")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.edit") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.vendor.edit_description") }}
            </p>
          </div>

        </div> -->
                  <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- Main content -->
    <section class="content pb-5">
      <div  v-if="$fetchState.pending">
       <AdminFormLoader :multilang='true'/>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <!-- <h3 class="">{{ $t("form.vendor.personal_details.heading") }}</h3> -->
                <!-- <hr /> -->
              <!-- <div class="row">
                 <div class="row">
                  <div class="col-md-6 my-1">
                    <div role="group ">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.vendor.name.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.name"
                      >
                        {{ error.name[0] }}
                      </span>
                      <input
                        class="form-control"
                        :class="error && error.name ? 'error' : ''"
                        v-model="formData.name"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="this.$t('form.vendor.name.placeholder')"
                        trim
                      />
                      <span class="heebo-light">
                        {{ this.$t("form.vendor.name.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.vendor.email.label") }}:</label
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
                        :placeholder="
                          this.$t('form.vendor.email.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.vendor.email.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1  ">
                    <div role="group">
                      <label for="input-live" class="   form-label">{{ this.$t("form.vendor.password.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.password">
                          {{ error.password[0] }}
                        </span>
                      <input :class="error && error.password ? 'error' : ''"
                             class="form-control"
                             v-model="formData.password"
                             type="password"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.vendor.password.placeholder')"
                             trim />
                             <span class="   heebo-light">
                                 {{ $t("form.vendor.password.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1  ">
                    <div role="group">
                      <label for="input-live" class="   form-label">{{ this.$t("form.vendor.password_confirmation.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.password_confirmation">
                          {{ error.confirm_password[0] }}
                        </span>
                      <input :class="error && error.password_confirmation ? 'error' : ''"
                             class="form-control"
                             v-model="formData.password_confirmation"
                             type="password"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.vendor.password_confirmation.placeholder')"
                             trim />
                             <span class="   heebo-light">
                                 {{ $t("form.vendor.password_confirmation.subheading") }}
                             </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1">
                      <div role="group ">
                        <label for="input-live" class="form-label"
                          >{{
                            this.$t("form.vendor.contact_phone.label")
                          }}:</label
                        >
                        <span
                          class="float-end text-danger"
                          v-if="error && error.contact_phone"
                        >
                          {{ error.contact_phone[0] }}
                        </span>
                        <input type="number"
                          class="form-control"
                          :class="error && error.contact_phone ? 'error' : ''"
                          v-model="formData.contact_phone"
                          aria-describedby="input-live-help input-live-feedback"
                          :placeholder="
                            this.$t('form.vendor.contact_phone.placeholder')
                          "
                          trim
                        />
                        <span class="heebo-light">
                          {{ this.$t("form.vendor.contact_phone.subheading") }}
                        </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1">
                      <label class="label form-label">
                          {{ this.$t("form.vendor.profile_image.label") }}
                        </label>
                        <span class="float-end text-danger"
                              v-if="error && error.profile_image_id">
                            {{ error.profile_image_id[0] }}
                          </span>
                        <div class="">
                          <img v-if="vendor_profile_image_path" v-bind:src=" url + `${vendor_profile_image_path}`" class="" />
                          <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectVedorProfileMedia">{{ $t("form.select_media") }}</div>
                        </div>
                          <AdminMediaModal type="images" bind_modal="profile_image_id" img_var="vendor_profile_image_path" modal_id="selectVedorProfileMedia" @selectImage="imageSelected" redirect_panel="seller"/>
                      <span class="px-2 heebo-light">
                          {{ $t("form.vendor.profile_image.subheading") }}
                        </span>
                    </div>
                </div>
              </div> -->
              <h3 class="">{{ $t("form.vendor.store_details.heading") }}</h3>
              <hr />
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.vendor.store_name.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error['store_details.name']"
                      >
                        {{ error['store_details.name'][0] }}
                      </span>
                      <input
                        class="form-control"
                        :class="error && error['store_details.name'] ? 'error' : ''"
                        v-model="formData.store_details.name"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.vendor.store.name.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.vendor.store.name.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1  pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.vendor.store_headline.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error['store_details.headline']"
                      >
                        {{ error['store_details.headline'][0] }}
                      </span>
                      <input
                        :class="error && error['store_details.headline'] ? 'error' : ''"
                        class="form-control"
                        v-model="formData.store_details.headline"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.vendor.store.headline.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.vendor.store.headline.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1  ps-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.vendor.store_country.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['store_details.country_id']">
                          {{ error['store_details.country_id'][0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error['store_details.country_id'] ? 'error' : ''" apiMethod="activeCountries" responseKey="countries"
                          :initialOptions="allActiveCountries.countries" :selectedOptions="selected_country" :placeholder="this.$t('form.vendor.store.country.placeholder')" v-model="formData.store_details.country_id" v-on:input="getStatesByCountry($event)" />
                             <span class=" heebo-light">
                                 {{ $t("form.vendor.store.country.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1  pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.vendor.store_state.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['store_details.state_id']">
                          {{ error['store_details.state_id'][0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error['store_details.state_id'] ? 'error' : ''" :search_id="formData.store_details.country_id" apiMethod="getStatesByCountry" responseKey="states"
                          :initialOptions="statesByCountry.states" :selectedOptions="selected_state" :placeholder="this.$t('form.vendor.store.state.placeholder')" :key="states_key" v-model="formData.store_details.state_id" v-on:input="getCitiesByState($event)" />
                             <span class=" heebo-light">
                                 {{ $t("form.vendor.store.state.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1  ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.vendor.store_city.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['store_details.city_id']">
                          {{ error['store_details.city_id'][0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error['store_details.city_id'] ? 'error' : ''" :search_id="formData.store_details.state_id" apiMethod="getCitiesByState" responseKey="cities"
                          :initialOptions="citiesByState.cities" :selectedOptions="selected_city" :placeholder="this.$t('form.vendor.store.city.placeholder')" :key="cities_key" v-model="formData.store_details.city_id" />
                             <span class=" heebo-light">
                                 {{ $t("form.vendor.store.city.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1  pe-md-0">
                    <div role="group ">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.vendor.store_address.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error['store_details.address']"
                      >
                        {{ error['store_details.address'][0] }}
                      </span>

                       <vue-google-autocomplete
                        id="map"
                        classname="form-control"
                       :placeholder="
                          this.$t('form.vendor.store.address.placeholder')
                        "
                        v-on:placechanged="getAddressData"
                       v-model="formData.store_details.address"
                    >
                    </vue-google-autocomplete>
                      <span class="heebo-light">
                        {{ this.$t("form.vendor.store.address.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1  ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.vendor.store_phone.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error['store_details.phone']"
                      >
                        {{ error['store_details.phone'][0] }}
                      </span>
                      <input type="number"
                        :class="error && error['store_details.phone'] ? 'error' : ''"
                        class="form-control"
                        v-model="formData.store_details.phone"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.vendor.store.phone.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.vendor.store.phone.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1  pe-md-0">
                    <div role="group ">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.vendor.store_postal_code.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error['store_details.postal_code']"
                      >
                        {{ error['store_details.postal_code'][0] }}
                      </span>
                      <input type="number"
                        class="form-control"
                        :class="error && error['store_details.postal_code'] ? 'error' : ''"
                        v-model="formData.store_details.postal_code"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.vendor.store.postal_code.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ this.$t("form.vendor.store.postal_code.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1  ps-md-0">
                    <label class="label form-label">
                        {{ this.$t("form.vendor.store_logo_image.label") }}
                      </label>
                      <span class="float-end text-danger"
                            v-if="error && error.logo_image_id">
                          {{ error.logo_image_id[0] }}
                        </span>
                      <div class="">
                        <img v-if="vendor_logo_image_path" v-bind:src=" url + `${vendor_logo_image_path}`" class="" />
                        <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectVedorLogoMedia">{{ $t("form.select_media") }}</div>
                      </div>
                        <AdminMediaModal type="images" bind_modal="logo_image_id" img_var="vendor_logo_image_path" modal_id="selectVedorLogoMedia" @selectImage="imageSelected" redirect_panel="seller" />
                    <span class="px-2 heebo-light">
                        {{ $t("form.vendor.store.logo_image.subheading") }}
                      </span>
                  </div>
                  <div class="col-md-6 my-1  pe-md-0">
                    <label class="label form-label">
                        {{ this.$t("form.vendor.store_cover_image.label") }}
                      </label>
                      <span class="float-end text-danger"
                            v-if="error && error.cover_image_id">
                          {{ error.cover_image_id[0] }}
                        </span>
                      <div class="">
                        <img v-if="vendor_cover_image_path" v-bind:src=" url + `${vendor_cover_image_path}`" class="" />
                        <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectVedorCoverMedia">{{ $t("form.select_media") }}</div>
                      </div>
                        <AdminMediaModal type="images" bind_modal="cover_image_id" img_var="vendor_cover_image_path" modal_id="selectVedorCoverMedia" @selectImage="imageSelected" redirect_panel="seller" />
                    <span class="px-2 heebo-light">
                        {{ $t("form.vendor.store.cover_image.subheading") }}
                      </span>
                  </div>
                </div>

                <hr />
                 <div class="row">
                  <div class="col-md-12 my-1  ps-md-0">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label"
                        >{{ this.$t("form.vendor.categories.label") }} (MAX 2):</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.categories"
                      >
                        {{ error.categories[0] }}
                      </span>
                    </div>

                    <GlobalNestedCategories
                    class="nested-categories"
                      @checkParent="checkAllParent"
                      :parent="null"
                      :categories_array="formData.categories"
                      :value="formData.categories"
                      @input="handleCategories"
                      :categories="allParentActiveCategories.categories"
                    />

                  </div>
                </div>
                <hr class="text-primary">
                <div class="row">
                  <div class="col-lg-12 pt-3 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">
                        {{ $t("form.multilanguage") }}
                      </h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.vendor.form_description") }}
                        </span>
                      </p>
                      <div class="row">
                        <div class="col-lg-12 px-0 d-md-flex">
                          <ul
                            class="nav nav-tabs d-inline-block"
                            id="myTab"
                            role="tablist "
                          >
                            <li
                              class="nav-item"
                              role="presentation"
                              v-for="(
                                language, index
                              ) in allActiveLanguages.languages"
                              :key="language.id"
                            >
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
                            <div
                              class="tab-pane fade"
                              :class="index == 0 ? 'active show' : ''"
                              v-for="(
                                language, index
                              ) in allActiveLanguages.languages"
                              :key="language.id"
                              :id="language.code"
                              role="tabpanel"
                              :aria-labelledby="language.code + '-tab'"
                            >
                              <div class="row">
                                <div class="col-md-12 my-1">
                                  <div role="group ">
                                    <label
                                      for="input-live"
                                      class="px-2 form-label"
                                      >{{
                                        $t("form.vendor.store_description.label")
                                      }}:</label
                                    >
                                    <span
                                      class="float-end text-danger"
                                      v-if="
                                        error &&
                                        error['store_details.description.' + language.code]
                                      "
                                    >
                                      {{
                                        error["store_details.description." + language.code][0]
                                      }}
                                    </span>
                                    <GlobalCkeditorNuxt
                                      v-model="
                                        formData.store_details.description[language.code]
                                      "
                                    />
                                    <span class="px-2 heebo-light">
                                      {{
                                        $t("form.vendor.store.description.subheading")
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
            <div class="row">
                     <div class="col-md-12 px-4 text-center text-md-end">
                       <button type="button" :disabled="disabled"
                               class="btn btn-secondary mb-3 px-3 py-2"
                               @click="update"
                               name="button">
                           {{ this.$t("form.update") }}
                         </button>
                     </div>
                </div>
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
import nestedCategoryMixin from "~/mixins/nestedCategoryMixin.js";

export default {
  layout: "vendor",
  middleware: "vendor",
  mixins: [nestedCategoryMixin],
  data() {
    return {
      url: '/backend',
      vendor_profile_image_path:'',
      vendor_logo_image_path:'',
      vendor_cover_image_path:'',
      statesByCountry:{},
      citiesByState:{},
      selected_city:'',
      selected_state:'',
      selected_country:'',
      states_key:1,
      cities_key:1,
      formData: {
        logo_image_id:'',
        cover_image_id:'',
        name: "",
        password_confirmation:"",
        email: "",
        password: "",
        contact_phone:'',
        profile_image_id:'',
        store_details:{
          name: "",
          address: "",
          latitude: "",
        longitude:"",
          slug:"",
          vendor_id:"",
          city_id:'',
          state_id:'',
          country_id:'',
          cover_image_id:'',
          logo_image_id:'',
          phone: "",
          postal_code: "",
          headline: "",
          description: {},
          is_active:false,
        },
        categories: [],
        is_active: true,
      },
      disabled:false,
      error: false,
    };
  },
  async fetch() {
     if (!this.allParentActiveCategories.categories) {
      await this.fetchParentActiveCategories();
    }
    if(!this.allActiveCountries.countries){
      await this.fetchActiveCountries();
    }
    if(!this.allActiveMedia.media){
      await this.fetchActiveMedia();
    }
    this.categories = this.allActiveCategories.categories
    const { data } = await this.$vendorService.getVendorStore();
    // get and update data
    this.formData.name = data.name;
    this.formData.email = data.email;
    this.formData.contact_phone = data.store_details.phone;
    this.formData.is_active = data.is_active;
    this.formData.is_featured = data.is_featured;
    if (data.categories.length > 0) {
        this.formData.categories = data.categories;
    }

    if(data.store_details != null)
    {
         this.formData.store_details.name = data.store_details.name;
        this.formData.store_details.address = data.store_details.address;
        this.formData.store_details.latitude = data.store_details.latitude;
        this.formData.store_details.longitude = data.store_details.longitude;
        this.formData.store_details.phone = data.store_details.phone;
        this.formData.store_details.postal_code = data.store_details.postal_code;
        this.formData.store_details.headline = data.store_details.headline;
        this.formData.store_details.is_active = data.store_details.is_active;
        this.formData.store_details.description = data.store_details.descriptionTranslations;

    if(data.store_details.country){
      this.formData.store_details.country_id = data.store_details.country.id
      this.selected_country = data.store_details.country
    }
    if(data.store_details.state){
        await this.setStatesByCountry(data.store_details.country.id)
        this.formData.store_details.state_id = data.store_details.state.id
        this.selected_state = data.store_details.state
      }
    if(data.store_details.city){
        await this.setCitiesByState(data.store_details.state.id)
        this.formData.store_details.city_id = data.store_details.city.id
        this.selected_city = data.store_details.city
      }
      if(data.store_details.cover_image){
        this.formData.cover_image_id = data.store_details.cover_image.id
        if(data.store_details.cover_image.thumbnails){
          this.vendor_cover_image_path = data.store_details.cover_image.thumbnails.small.thumbnail
        }
      }
      if(data.store_details.logo_image){
        this.formData.logo_image_id = data.store_details.logo_image.id
        if(data.store_details.logo_image.thumbnails){
          this.vendor_logo_image_path = data.store_details.logo_image.thumbnails.small.thumbnail
        }
      }
      if(data.profile_image){
        this.formData.profile_image_id = data.profile_image.id
        if(data.profile_image.thumbnails){
          this.vendor_profile_image_path = data.profile_image.thumbnails.small.thumbnail
        }
      }
    }

  },

  updated() {
    this.categoryMark();
  },
  methods: {
    ...mapActions({
      fetchActiveCategories: "General/fetchActiveCategories",
      fetchActiveCountries: 'General/fetchActiveCountries',
      fetchActiveMedia: 'General/fetchActiveMedia',
      fetchParentActiveCategories: "General/fetchParentActiveCategories",
    }),
    imageSelected(id,path,img_resource,modal){
      this.formData[modal] = id
      this[img_resource] = path
    },
    async getStatesByCountry(e){
      this.formData.store_details.state_id = ''
      this.formData.store_details.city_id = ''
      this.selected_state = ''
      this.selected_city = ''
      const data =  await this.$generalService.getStatesByCountry(e);
      if(data.states){
        this.statesByCountry = data.states;
      }
      this.states_key+=1;
      },
      async setStatesByCountry(id){
        const data =  await this.$generalService.getStatesByCountry(id);
        if(data.states){
        this.statesByCountry = data.states;
          }
        this.$forceUpdate();
        },
    async getCitiesByState(e){
        this.formData.store_details.city_id = ''
        this.selected_city = ''
        const data =  await this.$generalService.getCitiesByState(e);
        if(data.cities){
          this.citiesByState = data.cities;
        }
        this.cities_key+=1;
        },
    async setCitiesByState(id){
        const data =  await this.$generalService.getCitiesByState(id);
          if(data.cities){
        this.citiesByState = data.cities;
      }
        this.$forceUpdate();
        },
    async update() {
        this.disabled=true
      await this.$vendorService.createOrUpdateVendorStore(this.formData).then((res) => {
        // some error occur
        if (!res.state) {
          this.$toast.error(res.message);
        } else if (res.state ) {
          this.error = false;
          this.$toast.success(res.message);
          this.$router.replace(this.localePath("/seller/dashboard"));
        } else {

        }
      }).catch(error => {

        this.error = true;
        this.error = error.response.data.errors
      });
      await this.$auth.fetchUser()
      this.disabled=false
    },
     getAddressData: function (addressData, placeResultData, id) {
      this.formData.store_details.address = placeResultData.formatted_address
      this.formData.store_details.latitude = addressData.latitude
      this.formData.store_details.longitude = addressData.longitude
    },
  },
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
      allActiveCategories: "General/allActiveCategories",
      allActiveCountries: 'General/allActiveCountries',
      allActiveMedia: 'General/allActiveMedia',
      allParentActiveCategories: "General/allParentActiveCategories",

    }),
  },
  watch: {
    statesByCountry: function(newValue) {
      this.states_key+=1
    },
    citiesByState: function(newValue) {
      this.cities_key+=1
    },
  },
  mounted() {},
};
</script>
