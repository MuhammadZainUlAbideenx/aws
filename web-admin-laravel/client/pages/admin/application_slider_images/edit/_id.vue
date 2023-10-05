<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.application_slider_image.edit_application_slider_image") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{ this.$t("sidebar.home") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/application_slider_images')">{{ this.$t("sidebar.application_slider_image") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.application_slider_image.edit_description") }}
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
       <AdminFormLoader :multilang='true'/>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card  gutter-b  border-0" >
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6 ps-md-0">
                  <div role="group">
                    <label for="input-live" class="   form-label">{{ this.$t("form.application_slider_image.slider_type.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.slider_type">
                        {{ error.slider_type[0] }}
                      </span>
                      <v-select
                        class=""
                        :placeholder="this.$t('form.application_slider_images.slider_type.placeholder')"
                        v-model="formData.slider_type"
                        :reduce="(opt) => opt.value"
                        label="value"
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
                      <span class="heebo-light">
                          {{ $t("form.application_slider_image.slider_type.subheading") }}
                      </span>
                  </div>
                </div>
                <div class="col-md-6 pe-md-0">
                  <div role="group">
                  <label class="label form-label">
                      {{ this.$t("form.application_slider_image.expiry_date.label") }}
                    </label>
                    <span class="float-end text-danger"
                          v-if="error && error.expiry_date">
                        {{ error.expiry_date[0] }}
                      </span>
                      <datetime :placeholder="this.$t('form.application_slider_image.expiry_date.placeholder')" input-class="form-control" value-zone="local"  type="datetime" use12-hour v-model="formData.expiry_date"></datetime>
                 <span class="   heebo-light">
                     {{ $t("form.application_slider_image.expiry_date.subheading") }}
                 </span>
               </div>
              </div>
              <div class="col-md-6  ps-md-0">
                <div role="group">
                  <label for="input-live" class="px-2 form-label">{{ this.$t("form.application_slider_image.website_url.label") }}:</label>
                  <span class="float-end text-danger"
                        v-if="error && error.website_url">
                      {{ error.website_url[0] }}
                    </span>
                  <input :class="error && error.website_url ? 'error' : ''"
                         class="form-control"
                         aria-describedby="input-live-help input-live-feedback"
                         v-model="formData.website_url"
                         :placeholder="this.$t('form.application_slider_image.website_url.placeholder')"
                         trim />
                 <span class="px-2 heebo-light">
                     {{ $t("form.application_slider_image.website_url.subheading") }}
                   </span>
                </div>
              </div>
               <div class="col-md-6  pe-md-0 my-1 d-flex justify-content-center flex-column ">
                      <div class="d-flex align-items-center ">
                          <label class="label form-label me-4 text-capitalize">
                            {{ this.$t("form.application_slider_image.status.label") }}
                          </label>

                          <div class="form-switch">
                            <input class="form-check-input"
                                    v-model="formData.is_active"
                                  :checked="formData.is_active ? 'checked' : ''"
                                  type="checkbox"
                                  id="flexSwitchCheckChecked" />
                          </div>
                      </div>

                      <span class=" heebo-light">
                          {{ $t("form.application_slider_image.status.subheading") }}
                        </span>
                    </div>
                </div>
                 <hr class="text-primary">
                <div class="col-lg-12 pt-3 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">{{ $t("form.multilanguage") }}</h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("lorem_ipsum") }}
                        </span>
                      </p>
                      <div class="row">
                        <div class="col-lg-12 px-0 d-md-flex">
                          <ul
                            class="nav nav-tabs d-inline-block"
                            id="myTab"
                            role="tablist "
                          >
                            <li class="nav-item" role="presentation"
                              v-for="(language, index) in allActiveLanguages.languages" :key="index">
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
                           <div class="tab-pane fade" :class="index == 0 ? 'active show':''" v-for="(language,index) in allActiveLanguages.languages" :key="language.code" :id="language.code" role="tabpanel" :aria-labelledby="language.code+'-tab'">
                              <div class="row">
                                <div class="col-md-6" >
                                  <div role="group ">
                                    <label for="input-live" class="   form-label">{{ $t("form.application_slider_image.image.label") }}:</label>
                                    <span class="float-end text-danger"
                                          v-if="error && error['image.' + language.code]">
                                        {{ error['image.'+language.code][0] }}
                                      </span>
                                      <div >

                                        <img v-if="images[language.code]" v-bind:src=" url + `${images[language.code]}`" class="tab-img" />
                                        <button class="btn btn-primary" type="button" name="button"  data-bs-toggle="modal" :data-bs-target="'#selectApplicationSliderImageMedia'+language.code">{{ $t("form.select_media") }}</button>

                                        <AdminMediaModal type="images" :bind_modal="language.code" :img_var="language.code" :modal_id="'selectApplicationSliderImageMedia'+language.code" @selectImage="imageSelected" redirect_panel="admin"/>
                                      </div>
                                    <span class="heebo-light">
                                        {{ $t("form.application_slider_image.image.subheading") }}
                                      </span>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t("form.application_slider_image.name.label")
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
                                        $t('form.application_slider_image.name.placeholder')
                                      "
                                      trim
                                    />
                                    <span class="heebo-light">
                                      {{
                                        $t("form.application_slider_image.name.subheading")
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
                                          "form.application_slider_image.description.label"
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
                                          "form.application_slider_image.description.subheading"
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
             <div class="row">
                  <div class="col-md-12 px-4 text-center text-md-end">
                    <button type="button"
                            class="btn btn-secondary mb-3 px-3 py-2"
                            @click="update"
                            name="button">
                        {{ this.$t("form.update") }}
                      </button>
                    <!-- <button type="button"
                            class="btn btn-success mb-3"
                            @click="updateAndContinue"
                            name="button">
                        {{ this.$t("form.update_and_continue") }}
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

  import { mapGetters, mapActions } from 'vuex'

  export default {
    layout: 'admin',
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'application_slider_images.update',
      strategy: 'update'
    },
    data() {
      return {
        images:{},
        options: [
          { value: '1', text: this.$t('form.application_slider_image.slider_type.type_1') },
          { value: '2', text: this.$t('form.application_slider_image.slider_type.type_2') },
          { value: '3', text: this.$t('form.application_slider_image.slider_type.type_3') },
          { value: '4', text: this.$t('form.application_slider_image.slider_type.type_4') },
          { value: '5', text: this.$t('form.application_slider_image.slider_type.type_5') }
        ],
         editorConfig: {
             // The configuration of the editor.
         },
         url: '/backend',
         application_slider_image_image_path:'',
         formData: {
           slider_type:'',
           name:{},
           description:{},
           website_url:'',
           expiry_date:'',
           image:{},
           is_active:false,
         },
         error: false
      }
    },
    async fetch() {
      if(!this.allActiveMedia.media){
        await this.fetchActiveMedia();
      }
      const { data } = await this.$repositories.application_slider_images.show(this.$route.params.id)
      // get and update data
      this.formData.image = data.imageTranslations
      this.formData.name = data.nameTranslations
      this.formData.description = data.descriptionTranslations
      this.formData.website_url = data.website_url
      this.formData.slider_type = data.slider_type
      this.formData.expiry_date = data.expiry_date
      this.images = data.images
      this.formData.is_active = data.is_active

    },
    methods: {
      ...mapActions({
        updateApplicationSliderImages: 'ApplicationSliderImages/updateApplicationSliderImages',
        fetchActiveApplicationSliderImages: 'General/fetchActiveApplicationSliderImages',
        fetchActiveMedia: 'General/fetchActiveMedia',

      }),
      imageSelected(id,path,img_resource,modal){
        this.formData.image[modal] = id
        this.images[img_resource] = path
        this.$forceUpdate();
      },
      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/application_slider_images'))
        }
      },
      async updateAndContinue() {
        await this.updateApplicationSliderImages({
          formData: this.formData,
          id: this.$route.params.id
        }).then(res => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data
            this.$toast.error(res.response.data.message)
          } else if (res.state == 'fail') {
            this.$toast.error(res.message)
          } else {
            this.error = false
            this.$toast.success(res.message)
            this.fetchActiveApplicationSliderImages();

          }
        })
      }
    },
    mounted() {},
    computed:{
      ...mapGetters({
        allActiveLanguages: 'General/allActiveLanguages',
        allActiveMedia: 'General/allActiveMedia',
      })
    }
  }

</script>
