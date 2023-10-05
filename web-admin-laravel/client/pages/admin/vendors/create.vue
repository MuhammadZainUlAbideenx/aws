<template >
  <div class="">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.vendor.create_new_vendor") }}
          </h2>
        </div>
        <!-- /.col -->
        <div class="row">
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
                {{ this.$t("form.create") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.vendor.form_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
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
                <h3 class="">{{ $t("form.vendor.personal_details.heading") }}</h3>
                <hr />
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
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
                  <div class="col-md-6 my-1 pe-md-0">
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
                  <div class="col-md-6 my-1  ps-md-0">
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
                  <div class="col-md-6 my-1  pe-md-0">
                    <div role="group">
                      <label for="input-live" class="   form-label">{{ this.$t("form.vendor.password_confirmation.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.password_confirmation">
                          {{ error.password_confirmation[0] }}
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
                  <div class="col-md-6 my-1 ps-md-0">
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
                    <div class="col-md-6 my-1 pe-md-0">
                      <label class="label form-label">
                          {{ this.$t("form.vendor.profile.image.label") }}
                        </label>
                        <span class="float-end text-danger"
                              v-if="error && error.profile_image_id">
                            {{ error.profile_image_id[0] }}
                          </span>
                        <div class="">
                          <img v-if="vendor_profile_image_path" v-bind:src=" url + `${vendor_profile_image_path}`" class="" />
                          <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectVedorProfileMedia">{{ $t("form.select_media") }}</div>
                        </div>
                          <AdminMediaModal type="images" bind_modal="profile_image_id" img_var="vendor_profile_image_path" modal_id="selectVedorProfileMedia" @selectImage="imageSelected" redirect_panel="admin" />
                      <span class="px-2 heebo-light">
                          {{ $t("form.vendor.profile.image.subheading") }}
                        </span>
                    </div>
                </div>
              <div class="row">
                  <div class="col-md-6 my-1 justify-content-center flex-column ps-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.vendor.status.label") }}
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
                      {{ $t("form.vendor.status.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 my-1 justify-content-center flex-column pe-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.vendor.featured.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.is_featured"
                          :checked="formData.is_featured ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.vendor.featured.subheading") }}
                    </span>
                  </div>
                </div>
              <h3 class="">{{ $t("form.vendor.store_details.heading") }}</h3>
              <hr />
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.vendor.store.name.label") }}:</label
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
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.vendor.store.headline.label")
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
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.vendor.store.country.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['store_details.country_id']">
                          {{ error['store_details.country_id'][0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error['store_details.country_id'] ? 'error' : ''" apiMethod="activeCountries" responseKey="countries"
                          :initialOptions="allActiveCountries.countries" :placeholder="this.$t('form.vendor.store.country.placeholder')" v-model="formData.store_details.country_id" v-on:input="getStatesByCountry($event)" />
                             <span class=" heebo-light">
                                 {{ $t("form.vendor.store.country.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.vendor.store.state.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['store_details.state_id']">
                          {{ error['store_details.state_id'][0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error['store_details.state_id'] ? 'error' : ''" :search_id="formData.store_details.country_id" apiMethod="getStatesByCountry" responseKey="states"
                          :initialOptions="statesByCountry.states" :placeholder="this.$t('form.vendor.store.state.placeholder')" :key="states_key" v-model="formData.store_details.state_id" v-on:input="getCitiesByState($event)" />
                             <span class=" heebo-light">
                                 {{ $t("form.vendor.store.state.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.vendor.store.city.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['store_details.city_id']">
                          {{ error['store_details.city_id'][0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error['store_details.city_id'] ? 'error' : ''" :search_id="formData.store_details.state_id" apiMethod="getCitiesByState" responseKey="cities"
                          :initialOptions="citiesByState.cities" :placeholder="this.$t('form.vendor.store.city.placeholder')" :key="cities_key" v-model="formData.store_details.city_id" />
                             <span class=" heebo-light">
                                 {{ $t("form.vendor.store.city.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group ">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.vendor.store.address.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error['store_details.address']"
                      >
                        {{ error['store_details.address'][0] }}
                      </span>
                      <input
                        class="form-control"
                        :class="error && error['store_details.address'] ? 'error' : ''"
                        v-model="formData.store_details.address"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.vendor.store.address.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ this.$t("form.vendor.store.address.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.vendor.store.phone.label")
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
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group ">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.vendor.store.postal_code.label")
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
                  <div class="col-md-6 my-1 ps-md-0">
                    <label class="label form-label">
                        {{ this.$t("form.vendor.store.logo_image.label") }}
                      </label>
                      <span class="float-end text-danger"
                            v-if="error && error.logo_image_id">
                          {{ error.logo_image_id[0] }}
                        </span>
                      <div class="">
                        <img v-if="vendor_logo_image_path" v-bind:src=" url + `${vendor_logo_image_path}`" class="" />
                        <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectVedorLogoMedia">{{ $t("form.select_media") }}</div>
                      </div>
                        <AdminMediaModal type="images" bind_modal="logo_image_id" img_var="vendor_logo_image_path" modal_id="selectVedorLogoMedia" @selectImage="imageSelected" redirect_panel="admin"/>
                    <span class="px-2 heebo-light">
                        {{ $t("form.vendor.store.logo_image.subheading") }}
                      </span>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <label class="label form-label">
                        {{ this.$t("form.vendor.store.cover_image.label") }}
                      </label>
                      <span class="float-end text-danger"
                            v-if="error && error.cover_image_id">
                          {{ error.cover_image_id[0] }}
                        </span>
                      <div class="">
                        <img v-if="vendor_cover_image_path" v-bind:src=" url + `${vendor_cover_image_path}`" class="" />
                        <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectVedorCoverMedia">{{ $t("form.select_media") }}</div>
                      </div>
                        <AdminMediaModal type="images" bind_modal="cover_image_id" img_var="vendor_cover_image_path" modal_id="selectVedorCoverMedia" @selectImage="imageSelected" redirect_panel="admin"/>
                    <span class="px-2 heebo-light">
                        {{ $t("form.vendor.store.cover_image.subheading") }}
                      </span>
                  </div>
                </div>
                <!-- <div class="row">
                  <div class="col-md-6 my-1 justify-content-center flex-column">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.vendor.store_status.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.store_details.is_active"
                          :checked="formData.store_details.is_active ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>

                    <span class="heebo-light">
                      {{ $t("form.vendor.store_status.subheading") }}
                    </span>
                  </div>
                </div> -->
                <hr />
                <div class="row">
                  <div class="col-md-12 my-1 px-0">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label"
                        >{{ this.$t("form.vendor.categories.label") }}:</label
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
                  <div class="col-lg-12 pt-2 px-0">
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
                                        $t("form.vendor.store.description.label")
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
                <button
                  type="button"  :disabled="disabled"
                  class="btn btn-primary mb-3 px-3 py-2"
                  @click="add"
                  name="button"
                >
                  {{ this.$t("form.add") }}
                </button>
                <!-- <button
                  type="button"  :disabled="disabled"
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
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script >
// import CkeditorNuxt from "@/components/global/ckeditorNuxt";
import nestedCategoryMixin from "~/mixins/nestedCategoryMixin.js";
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin",
  middleware: ["admin", "permission",'onlyMultiVendor'],
  meta: {
    permission: "vendors.create",
    strategy: "create",
  },
  mixins: [nestedCategoryMixin],
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
  },
  data() {
    return {
      url: '/backend',
      vendor_profile_image_path:'',
      vendor_logo_image_path:'',
      vendor_cover_image_path:'',
      statesByCountry:{},
      citiesByState:{},
      states_key:1,
      cities_key:1,
      formData: {
        is_credentials: true,
        name: "",
        password_confirmation:"",
        email: "",
        password: "",
        contact_phone:'',
        profile_image_id:'',
        store_details:{
          name: "",
          address: "",
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
        is_active: false,
        is_featured: false,
      },
      disabled:false,
      error: false,
    };
  },
  methods: {
    ...mapActions({
      addVendors: "Vendors/addVendors",
      fetchActiveVendors: "General/fetchActiveVendors",
      fetchParentActiveCategories: "General/fetchParentActiveCategories",
      fetchActiveCountries: 'General/fetchActiveCountries',
      fetchActiveMedia: 'General/fetchActiveMedia',
    }),
    imageSelected(id,path,img_resource,modal){
      this.formData[modal] = id
      this[img_resource] = path
    },
    async getStatesByCountry(e){
      this.formData.store_details.state_id = '';
      this.formData.store_details.city_id = '';
      const data =  await this.$generalService.getStatesByCountry(e,null);
      if(data.states){
        this.statesByCountry = data.states;
      }
      this.states_key+=1;
      },
    async getCitiesByState(e){
        this.formData.store_details.city_id = '';
        const data =  await this.$generalService.getCitiesByState(e);
        if(data.cities){
          this.citiesByState = data.cities;
        }
        this.cities_key+=1;
      },

    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/vendors"));
      }
    },
    async addAndContinue() {
          this.disabled=true
      await this.addVendors(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.name = "";
          this.formData.email = "";
          this.formData.password = "";
          this.formData.contact_phone = "";
          this.formData.is_active = false;
          this.formData.is_featured = false;
          this.formData.password_confirmation = "";
          this.formData.store_details.name = "";
          this.formData.store_details.address = "";
          this.formData.store_details.city_id = "";
          this.formData.store_details.country_id = "";
          this.formData.store_details.state_id = "";
          this.formData.store_details.store_phone = "";
          this.formData.store_details.postal_code = "";
          this.formData.store_details.headline = "";
          this.formData.categories = [];
          this.formData.store_details.description = {};
          this.formData.store_details.is_active = false;
          this.$toast.success(res.message);
          this.fetchActiveVendors();
        }
      });
        this.disabled=false
    },
  },
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
      allParentActiveCategories: "General/allParentActiveCategories",
      allActiveCountries: 'General/allActiveCountries',
      allActiveMedia: 'General/allActiveMedia',
    }),
  },
  watch: {
    statesByCountry: function(newValue) {
      this.states_key+=1
    },
    citiesByState: function(newValue) {
      this.cities_key+=1
    },
     'formData.categories': function(newValue) {
    },
  },
  mounted() {},
};
</script>
