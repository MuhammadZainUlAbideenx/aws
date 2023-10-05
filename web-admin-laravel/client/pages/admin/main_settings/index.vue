<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.main_settings.main_settings") }}
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
                  {{ this.$t("sidebar.main_setting") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.main_settings.form_description") }}
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
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6 my-1 ps-md-0">
                      <div role="group">
                        <label for="input-live" class="px-2 form-label">{{ this.$t("form.main_settings.name_or_logo.label") }}:</label>
                        <span class="float-end text-danger"
                              v-if="error && error.name_or_logo">
                            {{ error.name_or_logo[0] }}
                          </span>
                          <v-select
                            :placeholder="this.$t('form.main_settings.name_or_logo.placeholder')"
                            v-model="formData.name_or_logo"
                            :reduce="(opt) => opt.value"
                            label="name_or_logo"
                            :options="options"
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
                           {{ $t("form.main_settings.name_or_logo.subheading") }}
                         </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1  pe-md-0">
                      <div role="group">
                        <label for="input-live" class="px-2 form-label">{{ this.$t("form.main_settings.web_name.label") }}:</label>
                        <span class="float-end text-danger"
                              v-if="error && error.web_name">
                            {{ error.web_name[0] }}
                          </span>
                        <input :class="error && error.web_name ? 'error' : ''"
                               class="form-control"
                               aria-describedby="input-live-help input-live-feedback"
                               v-model="formData.web_name"
                               :placeholder="this.$t('form.main_settings.web_name.placeholder')"
                               trim />
                       <span class="px-2 heebo-light">
                           {{ $t("form.main_settings.web_name.subheading") }}
                         </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1  ps-md-0">
                      <div role="group">
                        <label for="input-live" class="px-2 form-label">{{ this.$t("form.main_settings.contact_number.label") }}:</label>
                        <span class="float-end text-danger"
                              v-if="error && error.contact_number">
                            {{ error.contact_number[0] }}
                          </span>
                        <input :class="error && error.contact_number ? 'error' : ''"
                               class="form-control"
                               aria-describedby="input-live-help input-live-feedback"
                               v-model="formData.contact_number"
                               :placeholder="this.$t('form.main_settings.contact_number.placeholder')"
                               trim />
                       <span class="px-2 heebo-light">
                           {{ $t("form.main_settings.contact_number.subheading") }}
                         </span>
                      </div>
                    </div>

                    <div class="col-md-6 my-1  pe-md-0">
                      <label class="label form-label">
                          {{ this.$t("form.main_settings.web_logo_image.label") }}
                        </label>
                        <span class="float-end text-danger"
                              v-if="error && error.image_id">
                            {{ error.image_id[0] }}
                          </span>
                        <div class="">

                          <img v-if="web_image_path" v-bind:src=" url + `${web_image_path}`" class="" />
                          <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectWebImageMedia">{{ $t("form.select_media") }}</div>
                          <AdminMediaModal type="images" bind_modal="web_logo_image_id" img_var="web_image_path" modal_id="selectWebImageMedia" @selectImage="imageSelected" redirect_panel="admin"/>
                        </div>

                      <span class="px-2 heebo-light">
                          {{ $t("form.main_settings.web_logo_image.subheading") }}
                        </span>
                    </div>
                    <div class="col-md-6 my-1  ps-md-0">
                      <label class="label form-label">
                          {{ this.$t("form.main_settings.web_dark_logo_image.label") }}
                        </label>
                        <span class="float-end text-danger"
                              v-if="error && error.image_id">
                            {{ error.image_id[0] }}
                          </span>
                        <div class="">

                          <img v-if="web_image_dark_path" v-bind:src=" url + `${web_image_dark_path}`" class="" />
                          <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectWebDarkImageMedia">{{ $t("form.select_media") }}</div>
                          <AdminMediaModal type="images" bind_modal="web_dark_logo_image_id" img_var="web_image_dark_path" modal_id="selectWebDarkImageMedia" @selectImage="imageSelected" redirect_panel="admin" />
                        </div>

                      <span class="px-2 heebo-light">
                          {{ $t("form.main_settings.web_logo_image.subheading") }}
                        </span>
                    </div>
                    <div class="col-md-6 my-1  pe-md-0">
                      <label class="label form-label">
                          {{ this.$t("form.main_settings.favicon.label") }}
                        </label>
                        <span class="float-end text-danger"
                              v-if="error && error.image_id">
                            {{ error.image_id[0] }}
                          </span>
                        <div class="">

                          <img v-if="fav_image_path" v-bind:src=" url + `${fav_image_path}`" class="" />
                          <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectFavImageMedia">{{ $t("form.select_media") }}</div>
                          <AdminMediaModal type="images" bind_modal="fav_icon_image_id" img_var="fav_image_path" modal_id="selectFavImageMedia" @selectImage="imageSelected" redirect_panel="admin"/>
                        </div>

                      <span class="px-2 heebo-light">
                          {{ $t("form.main_settings.favicon.subheading") }}
                        </span>
                    </div>
                    <div class="col-md-6 my-1  ps-md-0">
                      <div role="group">
                        <label for="input-live" class="px-2 form-label">{{ this.$t("form.main_settings.facebook_url.label") }}:</label>
                        <span class="float-end text-danger"
                              v-if="error && error.facebook_url">
                            {{ error.facebook_url[0] }}
                          </span>
                        <input :class="error && error.facebook_url ? 'error' : ''"
                               class="form-control"
                               aria-describedby="input-live-help input-live-feedback"
                               v-model="formData.facebook_url"
                               :placeholder="this.$t('form.main_settings.facebook_url.placeholder')"
                               trim />
                       <span class="px-2 heebo-light">
                           {{ $t("form.main_settings.facebook_url.subheading") }}
                         </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1  pe-md-0">
                      <div role="group">
                        <label for="input-live" class="px-2 form-label">{{ this.$t("form.main_settings.twitter_url.label") }}:</label>
                        <span class="float-end text-danger"
                              v-if="error && error.twitter_url">
                            {{ error.twitter_url[0] }}
                          </span>
                        <input :class="error && error.twitter_url ? 'error' : ''"
                               class="form-control"
                               aria-describedby="input-live-help input-live-feedback"
                               v-model="formData.twitter_url"
                               :placeholder="this.$t('form.main_settings.twitter_url.placeholder')"
                               trim />
                       <span class="px-2 heebo-light">
                           {{ $t("form.main_settings.twitter_url.subheading") }}
                         </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1  ps-md-0">
                      <div role="group">
                        <label for="input-live" class="px-2 form-label">{{ this.$t("form.main_settings.linked_in_url.label") }}:</label>
                        <span class="float-end text-danger"
                              v-if="error && error.linked_in_url">
                            {{ error.linked_in_url[0] }}
                          </span>
                        <input :class="error && error.linked_in_url ? 'error' : ''"
                               class="form-control"
                               aria-describedby="input-live-help input-live-feedback"
                               v-model="formData.linked_in_url"
                               :placeholder="this.$t('form.main_settings.linked_in_url.placeholder')"
                               trim />
                       <span class="px-2 heebo-light">
                           {{ $t("form.main_settings.linked_in_url.subheading") }}
                         </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1  pe-md-0">
                      <div role="group">
                        <label for="input-live" class="px-2 form-label">{{ this.$t("form.main_settings.instagram_url.label") }}:</label>
                        <span class="float-end text-danger"
                              v-if="error && error.instagram_url">
                            {{ error.instagram_url[0] }}
                          </span>
                        <input :class="error && error.instagram_url ? 'error' : ''"
                               class="form-control"
                               aria-describedby="input-live-help input-live-feedback"
                               v-model="formData.instagram_url"
                               :placeholder="this.$t('form.main_settings.instagram_url.placeholder')"
                               trim />
                       <span class="px-2 heebo-light">
                           {{ $t("form.main_settings.instagram_url.subheading") }}
                         </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1  ps-md-0">
                      <div role="group">
                        <label for="input-live" class="px-2 form-label">{{ this.$t("form.main_settings.contact_address.label") }}:</label>
                        <span class="float-end text-danger"
                              v-if="error && error.contact_address">
                            {{ error.contact_address[0] }}
                          </span>
                        <input :class="error && error.contact_address ? 'error' : ''"
                               class="form-control"
                               aria-describedby="input-live-help input-live-feedback"
                               v-model="formData.contact_address"
                               :placeholder="this.$t('form.main_settings.contact_address.placeholder')"
                               trim />
                       <span class="px-2 heebo-light">
                           {{ $t("form.main_settings.contact_address.subheading") }}
                         </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1  pe-md-0">
                      <div role="group">
                        <label for="input-live" class="px-2 form-label">{{ this.$t("form.main_settings.contact_email.label") }}:</label>
                        <span class="float-end text-danger"
                              v-if="error && error.contact_email">
                            {{ error.contact_email[0] }}
                          </span>
                        <input :class="error && error.contact_email ? 'error' : ''"
                               class="form-control"
                               aria-describedby="input-live-help input-live-feedback"
                               v-model="formData.contact_email"
                               :placeholder="this.$t('form.main_settings.contact_email.placeholder')"
                               trim />
                       <span class="px-2 heebo-light">
                           {{ $t("form.main_settings.contact_email.subheading") }}
                         </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1  ps-md-0">
                      <div role="group">
                        <label for="input-live" class="px-2 form-label">{{ this.$t("form.main_settings.contact_map.label") }}:</label>
                        <span class="float-end text-danger"
                              v-if="error && error.contact_map">
                            {{ error.contact_map[0] }}
                          </span>
                        <input :class="error && error.contact_map ? 'error' : ''"
                               class="form-control"
                               aria-describedby="input-live-help input-live-feedback"
                               v-model="formData.contact_map"
                               :placeholder="this.$t('form.main_settings.contact_map.placeholder')"
                               trim />
                       <span class="px-2 heebo-light">
                           {{ $t("form.main_settings.contact_map.subheading") }}
                         </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1  pe-md-0">
                      <div role="group">
                        <label for="input-live" class="px-2 form-label">{{ this.$t("form.main_settings.copyright_text.label") }}:</label>
                        <span class="float-end text-danger"
                              v-if="error && error.copyright_text">
                            {{ error.copyright_text[0] }}
                          </span>
                        <input :class="error && error.copyright_text ? 'error' : ''"
                               class="form-control"
                               aria-describedby="input-live-help input-live-feedback"
                               v-model="formData.copyright_text"
                               :placeholder="this.$t('form.main_settings.copyright_text.placeholder')"
                               trim />
                       <span class="px-2 heebo-light">
                           {{ $t("form.main_settings.copyright_text.subheading") }}
                         </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1  ps-md-0">
                      <label class="label form-label">
                          {{ this.$t("form.main_settings.web_loader_image.label") }}
                        </label>
                        <span class="float-end text-danger"
                              v-if="error && error.image_id">
                            {{ error.image_id[0] }}
                          </span>
                        <div class="">

                          <img v-if="web_loader_path" v-bind:src=" url + `${web_loader_path}`" class="" />
                          <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectWebLoaderMedia">{{ $t("form.select_media") }}</div>
                          <AdminMediaModal type="images" bind_modal="web_loader_image_id" img_var="web_loader_path" modal_id="selectWebLoaderMedia" @selectImage="imageSelected" redirect_panel="admin"/>
                        </div>

                      <span class="px-2 heebo-light">
                          {{ $t("form.main_settings.web_loader_image.subheading") }}
                        </span>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row" v-permission="'main_settings.update'">
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
      permission: 'main_settings.index',
      strategy: 'index'
    },
    async fetch(){
      if(!this.allActiveSettings.settings){
        await this.fetchActiveSettings();
      }
      if(!this.allActiveMedia.media){
        await this.fetchActiveMedia();
      }
      if(this.allActiveSettings && this.allActiveSettings.settings && this.allActiveSettings.settings.specificSettings){
        this.formData.name_or_logo = parseInt(this.allActiveSettings.settings.specificSettings.name_or_logo)
        this.formData.web_name = this.allActiveSettings.settings.specificSettings.web_name
        this.formData.contact_number = this.allActiveSettings.settings.specificSettings.contact_number

        this.formData.twitter_url = this.allActiveSettings.settings.specificSettings.twitter_url
        this.formData.facebook_url = this.allActiveSettings.settings.specificSettings.facebook_url
        this.formData.instagram_url = this.allActiveSettings.settings.specificSettings.instagram_url
        this.formData.linked_in_url = this.allActiveSettings.settings.specificSettings.linked_in_url
        this.formData.contact_number = this.allActiveSettings.settings.specificSettings.contact_number
        this.formData.contact_email = this.allActiveSettings.settings.specificSettings.contact_email
        this.formData.contact_map = this.allActiveSettings.settings.specificSettings.contact_map
        this.formData.contact_address = this.allActiveSettings.settings.specificSettings.contact_address
        this.formData.copyright_text = this.allActiveSettings.settings.specificSettings.copyright_text

        if(this.allActiveSettings.settings.specificSettings.web_logo_image_id != null || this.allActiveSettings.settings.specificSettings.web_logo_image_id != ''){
          this.formData.web_logo_image_id = this.allActiveSettings.settings.specificSettings.web_logo_image_id
        }
        if(this.allActiveSettings.settings.specificSettings.web_loader_image_id != null || this.allActiveSettings.settings.specificSettings.web_loader_image_id != ''){
            this.formData.web_loader_image_id = this.allActiveSettings.settings.specificSettings.web_loader_image_id
        }
         if(this.allActiveSettings.settings.specificSettings.web_dark_logo_image_id != null || this.allActiveSettings.settings.specificSettings.web_dark_logo_image_id != ''){
          this.formData.web_dark_logo_image_id = this.allActiveSettings.settings.specificSettings.web_dark_logo_image_id
        }
        if(this.allActiveSettings.settings.specificSettings.fav_icon_image_id != null || this.allActiveSettings.settings.specificSettings.web_logo_image_id != ''){
          this.formData.fav_icon_image_id = this.allActiveSettings.settings.specificSettings.fav_icon_image_id
        }
        if(this.allActiveSettings.settings.media.logo && this.allActiveSettings.settings.media.logo.thumbnails && this.allActiveSettings.settings.media.logo.thumbnails.small){
          this.web_image_path = this.allActiveSettings.settings.media.logo.thumbnails.small.thumbnail
        }
        if(this.allActiveSettings.settings.media.loader && this.allActiveSettings.settings.media.loader.thumbnails && this.allActiveSettings.settings.media.loader.thumbnails.small){
          this.web_loader_path = this.allActiveSettings.settings.media.loader.thumbnails.small.thumbnail
        }
        if(this.allActiveSettings.settings.media.logo_dark && this.allActiveSettings.settings.media.logo_dark.thumbnails && this.allActiveSettings.settings.media.logo_dark.thumbnails.small){
          this.web_image_dark_path = this.allActiveSettings.settings.media.logo_dark.thumbnails.small.thumbnail
        }
        if(this.allActiveSettings.settings.media.favicon.thumbnails){
          this.fav_image_path = this.allActiveSettings.settings.media.favicon.thumbnails.small.thumbnail
        }
      }
    },
    data() {
      return {
        url: '/backend',
        web_image_path:'',
        web_loader_path:'',
        web_image_dark_path:'',
        fav_image_path:'',
        options: [
          { value: 0, text: this.$t('form.main_settings.name_or_logo_type.name') },
          { value: 1, text: this.$t('form.main_settings.name_or_logo_type.logo') },
        ],
        formData:{
          name_or_logo:'',
          contact_phone:'',
          contact_email:'',
          contact_address:'',
          contact_map:'',
          web_name:'',
          contact_number:'',
          web_logo_image_id:'',
          web_loader_image_id:'',
          web_dark_logo_image_id:'',
          fav_icon_image_id:'',
          twitter_url:'',
          facebook_url:'',
          linked_in_url:'',
          instagram_url:'',
          settings:'main_settings',
        },
        error: false
      }
    },
    methods: {
      ...mapActions({
        addSettings: 'Settings/addSettings',
        fetchActiveSettings: 'General/fetchActiveSettings',
        fetchActiveCountries: 'General/fetchActiveCountries',
        fetchActiveMedia: 'General/fetchActiveMedia',
      }),
      imageSelected(id,path,img_resource,modal){
        this.formData[modal] = id
        this[img_resource] = path
      },
  //    async getThumbnailsByMedia(ids){
  //      const data = await this.$genearalService.getThumbnailsByMedia(ids);
//      }
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
        allActiveMedia: 'General/allActiveMedia',
      })
    },
    watch:{
    }
  }

</script>
