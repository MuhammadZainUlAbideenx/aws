<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.category.edit_category") }}
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
                  <nuxt-link :to="localePath('/admin/categories')">{{ this.$t("sidebar.category") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.category.edit_description") }}
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
            <div class="card gutter-b border-0" >
              <div class="card-body">
                <div class="row">


                  <div class="col-md-6 my-1 ps-md-0">
                    <label class="label form-label">
                        {{ this.$t("form.category.image.label") }}
                      </label>
                      <span class="float-end text-danger"
                            v-if="error && error.image_id">
                          {{ error.image_id[0] }}
                        </span>
                      <div class="">

                        <img v-if="category_image_path" v-bind:src=" url + `${category_image_path}`" class="" />
                        <div class="btn-media mb-4" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectCategoryMedia">{{ $t("form.select_media") }}</div>

                        <AdminMediaModal type="images" bind_modal="image_id" img_var="category_image_path" modal_id="selectCategoryMedia" @selectImage="imageSelected" redirect_panel="admin"/>
                      </div>

                    <span class=" heebo-light">
                        {{ $t("form.category.image.subheading") }}
                      </span>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <label class="label form-label">
                        {{ this.$t("form.category.icon.label") }}
                      </label>
                      <span class="float-end text-danger"
                            v-if="error && error.icon_id">
                          {{ error.icon_id[0] }}
                        </span>
                      <div class="">

                        <img v-if="category_icon_path" v-bind:src=" url + `${category_icon_path}`" class="" />
                        <div class="btn-media mb-4" type="button" name="button"  data-bs-toggle="modal" data-bs-target="#selectCategoryIcon">{{ $t("form.select_media") }}</div>

                        <AdminMediaModal type="images" bind_modal="icon_id" img_var="category_icon_path" modal_id="selectCategoryIcon" @selectImage="imageSelected" redirect_panel="admin"/>
                      </div>

                    <span class=" heebo-light">
                        {{ $t("form.category.icon.subheading") }}
                      </span>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.category.parent_category.label") }}</label>
                      <span class="float-end text-danger"
                            v-if="error && error.parent_id">
                          {{ error.parent_id[0] }}
                        </span>
                        <AdminSearchSelectable :key="key" :class="error && error.parent_id ? 'error' : ''" apiMethod="activeInactiveCategories" responseKey="categories"
                          :initialOptions="categoriesExceptSelf" :placeholder="$t('form.category.parent_category.placeholder')" :selectedOptions="selected_category" v-model="formData.parent_id" v-on:input="checkParentId" />
                     <span class=" heebo-light">
                         {{ $t("form.category.parent_category.subheading") }}
                       </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1  d-flex justify-content-center flex-column pe-md-0">
                      <div class="d-flex align-items-center ">
                          <label class="label form-label me-4 text-capitalize">
                            {{ this.$t("form.category.status.label") }}
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
                          {{ $t("form.category.status.subheading") }}
                        </span>
                    </div>
                    <div class="col-md-6 my-1  d-flex justify-content-center flex-column ps-md-0" v-if="this.enableFeatured">
                        <div class="d-flex align-items-center ">
                            <label class="label form-label me-4 text-capitalize">
                              {{ this.$t("form.category.is_featured.label") }}
                            </label>

                            <div class="form-switch">
                              <input class="form-check-input"
                                      v-model="formData.is_featured"
                                    :checked="formData.is_featured ? 'checked' : ''"
                                    type="checkbox"
                                    id="flexSwitchCheckChecked" />
                            </div>
                        </div>

                        <span class=" heebo-light">
                            {{ $t("form.category.is_featured.subheading") }}
                          </span>
                      </div>
                </div>
                 <hr class="text-primary">
              <div class="row mb-1">
                <div class="col-lg-12 pt-2 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">{{$t('form.multilanguage')}}</h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.category.form_description") }}
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
                              v-for="(language, index) in allActiveLanguages.languages">
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
                            <div class="tab-pane fade" :class="index == 0 ? 'active show' : ''"
                              v-for="(language, index ) in allActiveLanguages.languages" :id="language.code" role="tabpanel" :aria-labelledby="language.code + '-tab'">
                              <div class="row">
                                <div class="col-md-6 my-1">
                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t("form.category.name.label")
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
                                        $t('form.category.name.placeholder')
                                      "
                                      trim
                                    />
                                    <span class="heebo-light">
                                      {{
                                        $t("form.category.name.subheading")
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
                                          "form.category.description.label"
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
                                          "form.category.description.subheading"
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
        </div>

        <div class="row">
          <div class="col-md-12 px-4 text-center text-md-end">
            <button type="button" :disabled="disabled"
                    class="btn btn-secondary mb-3 px-3 py-2"
                    @click="update"
                    name="button">
                {{ this.$t("form.update") }}
              </button>
            <!-- <button type="button" :disabled="disabled"
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
      permission: 'categories.update',
      strategy: 'update'
    },
    data() {
      return {
        selected_category:'',
        url: '/backend',
        key:1,
        enableFeatured:false,
        category_image_path:'',
        category_icon_path:'',
        parentCategories:{},
        formData: {
          name: {},
          description:{},
          is_active: false,
          parent_id: '',
          image_id:'',
          icon_id:'',
          is_featured:false,
        },
        disabled:false,
        error: false
      }
    },
    async fetch() {
      if(!this.allActiveMedia.media){
        await this.fetchActiveMedia();
      }
      if(!this.allActiveInactiveCategories.categories){
        await this.fetchActiveInactiveCategories()
      }
      const { data } = await this.$repositories.categories.show(this.$route.params.id)
      // get and update data
      this.formData.name = data.nameTranslations
      this.formData.description = data.descriptionTranslations
      if(data.icon){
        this.formData.icon_id = data.icon.id
        if(data.icon.thumbnails){
          this.category_icon_path = data.icon.thumbnails.small.thumbnail
        }
      }
      if(data.image){
        this.formData.image_id = data.image.id
        if(data.image.thumbnails){
          this.category_image_path = data.image.thumbnails.small.thumbnail
        }
      }
      this.formData.is_active = data.is_active
      this.formData.is_featured = data.is_featured
      if(data.parent){
        this.selected_category = data.parent.name
        this.formData.parent_id = data.parent.id
        this.formData.is_featured = false
        this.enableFeatured = false
      }else{
        this.enableFeatured = true
      }

  //    this.parentCategories.data = this.allActiveInactiveCategories.categories.data.filter((category) => category.id != this.$route.params.id)

    },
    methods: {
      ...mapActions({
        updateCategories: 'Categories/updateCategories',
        fetchActiveInactiveCategories: 'General/fetchActiveInactiveCategories',
        fetchActiveCategories: 'General/fetchActiveCategories',
        fetchActiveMedia: 'General/fetchActiveMedia',
        fetchCategories: 'Categories/fetchCategories',
      }),
      checkParentId(){
        if(this.formData.parent_id == 0 || this.formData.parent_id == null){
          this.enableFeatured = true;
        }else{
          this.enableFeatured = false;
          this.formData.is_featured = false;
        }
      },
      imageSelected(id,path,img_resource,modal){
        this.formData[modal] = id
        this[img_resource] = path
      },
      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/categories'))
        }
      },
      async updateAndContinue() {
           this.disabled=true
        const sendData = this.formData
        if(sendData.parent_id == ''){
          delete sendData.parent_id
        }
        await this.updateCategories({
          formData: sendData,
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
            this.fetchActiveInactiveCategories();
            this.fetchActiveCategories();
            this.fetchCategories();
          }
        });
         this.disabled=false
      }
    },
    mounted() {},
    computed:{
      ...mapGetters({
        allActiveLanguages: 'General/allActiveLanguages',
        allActiveInactiveCategories: 'General/allActiveInactiveCategories',
        allActiveMedia: 'General/allActiveMedia',
      }),
      categoriesExceptSelf(){
          this.parentCategories.data = this.allActiveInactiveCategories.categories.data.filter((category) => category.id != this.$route.params.id)
          return this.parentCategories
      }
    },
    watch:{
      parentCategories(){
        this.key +=1
      }
    }
  }

</script>
