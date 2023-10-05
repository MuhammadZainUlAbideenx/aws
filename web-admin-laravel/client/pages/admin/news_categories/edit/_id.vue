<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.news_category.edit_news_category") }}
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
                  <nuxt-link :to="localePath('/admin/news_categories')">{{ this.$t("sidebar.news_category") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary mb-0">
                {{ this.$t("form.news_category.edit_description") }}
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
                        {{ this.$t("form.news_category.image.label") }}
                      </label>
                      <span class="float-end text-danger"
                            v-if="error && error.image_id">
                          {{ error.image_id[0] }}
                        </span>
                      <div class="">

                        <img v-if="news_category_image_path" v-bind:src=" url + `${news_category_image_path}`" class="mb-3" />
                        <div class="btn-media mb-3" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectNewsCategoryMedia">{{ $t("form.select_media") }}</div>
                        <AdminMediaModal type="images" bind_modal="image_id" img_var="news_category_image_path" modal_id="selectNewsCategoryMedia" @selectImage="imageSelected" redirect_panel="admin"/>
                      </div>

                    <span class="heebo-light">
                        {{ $t("form.news_category.image.subheading") }}
                      </span>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                                            <div class="d-flex align-items-center ">
                          <label class="label form-label me-4 text-capitalize">
                            {{ this.$t("form.news_category.status.label") }}
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
                          {{ $t("form.news_category.status.subheading") }}
                        </span>
                  </div>
                </div>
                 <hr class="text-primary">
                 <div class="row">
          <div class="col-lg-12 px-0">
            <div class="" >
              <div class="px-0 pt-4">
               <h2 class="m-0 text-body bold">
                  Multilanguage
              </h2>
              <p>
                 <span class=" heebo-light">
                         {{ $t("lorem_ipsum") }}
                  </span>
              </p>
                <div class="row mb-2">
                  <div class="col-lg-12 px-0 d-flex ">
                    <ul class="nav nav-tabs d-inline-block" id="myTab" role="tablist ">
                      <li class="nav-item" role="presentation" v-for="(language,index) in allActiveLanguages.languages" :key="language.id">
                        <a class="nav-link" :class="index == 0 ? 'active':''" :id="language.code+'-tab'" data-bs-toggle="tab" :href="'#' + language.code" role="tab" :aria-controls="language.code" :aria-selected="index == 0 ? 'true':'false'">{{language.name}}</a>
                      </li>
                    </ul>

                        <div class="tab-content p-4" id="myTabContent">
                          <div class="tab-pane fade" :class="index == 0 ? 'active show':''" v-for="(language,index) in allActiveLanguages.languages" :id="language.code" :key="language.id" role="tabpanel" :aria-labelledby="language.code+'-tab'">
                              <div class="row">
                                <div class="col-md-6 my-1" >
                                  <div role="group ">
                                    <label for="input-live" class=" form-label">{{ $t("form.news_category.name.label") }}:</label>
                                    <span class="float-end text-danger"
                                          v-if="error && error['name.' + language.code]">
                                        {{ error['name.'+language.code][0] }}
                                      </span>
                                    <input class="form-control"
                                           :class="error && error['name.'+language.code] ? 'error' : ''"
                                           v-model="formData.name[language.code]"
                                           aria-describedby="input-live-help input-live-feedback"
                                           :placeholder="$t('form.news_category.name.placeholder')"
                                           trim />
                                    <span class=" heebo-light">
                                        {{ $t("form.news_category.name.subheading") }}
                                      </span>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 my-1" >
                                  <div role="group ">
                                    <label for="input-live" class=" form-label">{{ $t("form.news_category.description.label") }}:</label>
                                    <span class="float-end text-danger"
                                          v-if="error && error['description.' + language.code]">
                                        {{ error['description.'+language.code][0] }}
                                      </span>
                                      <GlobalCkeditorNuxt v-model="formData.description[language.code]"/>
                                    <span class=" heebo-light">
                                        {{ $t("form.news_category.description.subheading") }}
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
    </section>
    <!-- /.content -->

    <!-- /.content -->
  </div>

</template>
<script >

  import { mapGetters, mapActions } from 'vuex'

  export default {
    layout: 'admin',
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'news_categories.update',
      strategy: 'update'
    },
    data() {
      return {
        url: '/backend',
        news_category_image_path:'',
        formData: {
          name: {},
          description:{},
          is_active: false,
          website_url:'',
          image_id:'',
        },
        error: false
      }
    },
    async fetch() {
      if(!this.allActiveMedia.media){
        await this.fetchActiveMedia();
      }
      const { data } = await this.$repositories.news_categories.show(this.$route.params.id)
      // get and update data
      this.formData.name = data.nameTranslations
      this.formData.description = data.descriptionTranslations
      this.formData.website_url = data.website_url
      if(data.image){
        this.formData.image_id = data.image.id
        if(data.image.thumbnails){
          this.news_category_image_path = data.image.thumbnails.small.thumbnail
        }
      }
      this.formData.is_active = data.is_active

    },
    methods: {
      ...mapActions({
        updateNewsCategories: 'NewsCategories/updateNewsCategories',
        fetchActiveNewsCategories: 'General/fetchActiveNewsCategories',
        fetchActiveMedia: 'General/fetchActiveMedia',

      }),
      imageSelected(id,path,img_resource,modal){
        this.formData[modal] = id
        this[img_resource] = path
      },
      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/news_categories'))
        }
      },
      async updateAndContinue() {
        await this.updateNewsCategories({
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
            this.fetchActiveNewsCategories();

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
