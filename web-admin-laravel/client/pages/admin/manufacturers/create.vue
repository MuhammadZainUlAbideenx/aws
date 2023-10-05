<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.manufacturer.create_new_manufacturer") }}
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
                  <nuxt-link :to="localePath('/admin/manufacturers')">{{ this.$t("sidebar.manufacturer") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.create") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.manufacturer.form_description") }}
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
        <div class="col-lg-12">
            <div class="card gutter-b border-0" >
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <label class="label form-label">
                        {{ this.$t("form.manufacturer.image.label") }}
                      </label>
                      <span class="float-end text-danger"
                            v-if="error && error.image_id">
                          {{ error.image_id[0] }}
                        </span>
                      <div class="">

                        <img v-if="manufacturer_image_path" v-bind:src=" url + `${manufacturer_image_path}`" class="" />
                        <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectManufacturerMedia">{{ $t("form.select_media") }}</div>
                      </div>
                        <AdminMediaModal type="images" bind_modal="image_id" img_var="manufacturer_image_path" modal_id="selectManufacturerMedia" @selectImage="imageSelected" redirect_panel="admin"/>
                    <span class="px-2 heebo-light">
                        {{ $t("form.manufacturer.image.subheading") }}
                      </span>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.manufacturer.website_url.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.website_url">
                          {{ error.website_url[0] }}
                        </span>
                      <input :class="error && error.website_url ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.website_url"
                             :placeholder="this.$t('form.manufacturer.website_url.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.manufacturer.website_url.subheading") }}
                       </span>
                    </div>
                  </div>
                </div>
                <div class="row">

                   <div class="col-md-6  my-1 d-flex justify-content-center flex-column ps-md-0 ">
                      <div class="d-flex align-items-center ">
                          <label class="label form-label me-4 text-capitalize">
                            {{ this.$t("form.manufacturer.status.label") }}
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
                          {{ $t("form.manufacturer.status.subheading") }}
                        </span>
                    </div>

                </div>
                 <hr class="text-primary">
                <div class="row">
                <div class="col-lg-12 py-2 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">{{ $t("form.multilanguage") }}</h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.manufacturer.website_url.subheading") }}
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
                            <div class="tab-pane fade" :class="index == 0 ? 'active show' : ''" :key="language.code"
                              v-for="(language, index ) in allActiveLanguages.languages" :id="language.code" role="tabpanel" :aria-labelledby="language.code + '-tab'">
                              <div class="row">
                                <div class="col-md-6 my-1">
                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t("form.manufacturer.name.label")
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
                                        $t('form.manufacturer.name.placeholder')
                                      "
                                      trim
                                    />
                                    <span class="heebo-light">
                                      {{
                                        $t("form.manufacturer.name.subheading")
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
                                          "form.manufacturer.description.label"
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
                                          "form.manufacturer.description.subheading"
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
            <button type="button" :disabled="disabled"
                    class="btn btn-primary mb-3 px-3 py-2"
                    @click="add"
                    name="button">
                {{ this.$t("form.add") }}
              </button>
            <!-- <button type="button" :disabled="disabled"
                    class="btn btn-success mb-3"
                    @click="addAndContinue"
                    name="button">
                {{ this.$t("form.add_and_continue") }}
              </button> -->
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
      permission: 'manufacturers.create',
      strategy: 'create'
    },
    async fetch(){
      if(!this.allActiveMedia.media){
        await this.fetchActiveMedia();
      }
    },
    data() {
      return {
         editorConfig: {
             // The configuration of the editor.
         },
         url: '/backend',
         manufacturer_image_path:'',
         formData: {
           name: {},
           description:{},
           is_active: false,
           website_url:'',
           image_id:'',
         },
         disabled:false,
         error: false
      }
    },
    methods: {
      ...mapActions({
        addManufacturers: 'Manufacturers/addManufacturers',
        fetchActiveManufacturers: 'General/fetchActiveManufacturers',
        fetchActiveMedia: 'General/fetchActiveMedia',

      }),
      imageSelected(id,path,img_resource,modal){
        this.formData[modal] = id
        this[img_resource] = path
      },
      async add() {
        await this.addAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/manufacturers'))
        }
      },
      async addAndContinue() {
             this.disabled=true
        await this.addManufacturers(this.formData).then(res => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data
            this.$toast.error(res.response.data.message)
          } else {
            this.error = false
            this.formData.name = {}
            this.formData.description = {}
            this.formData.is_active = false
            this.formData.website_url = ''
            this.formData.image_id = ''
            this.manufacturer_image_path = ''
            this.$toast.success(res.message)
            this.fetchActiveManufacturers();

          }
        });
           this.disabled=false
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
