<template >

  <div >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.media_settings.media_settings") }}
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
                  <nuxt-link :to="localePath('/admin/media/')">{{ this.$t("sidebar.media") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("sidebar.media_setting") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.media_settings.form_description") }}
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
            <AdminFormLoader/>
          </div>
        </div>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0" >
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.media_settings.large_thumbnail_width.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.large_thumbnail_width">
                          {{ error.large_thumbnail_width[0] }}
                        </span>
                      <input :class="error && error.large_thumbnail_width ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.large_thumbnail_width"
                             :placeholder="this.$t('form.media_settings.large_thumbnail_width.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.media_settings.large_thumbnail_width.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.media_settings.large_thumbnail_height.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.large_thumbnail_height">
                          {{ error.large_thumbnail_height[0] }}
                        </span>
                      <input :class="error && error.large_thumbnail_height ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.large_thumbnail_height"
                             :placeholder="this.$t('form.media_settings.large_thumbnail_height.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.media_settings.large_thumbnail_height.subheading") }}
                     </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.media_settings.medium_thumbnail_width.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.medium_thumbnail_width">
                          {{ error.medium_thumbnail_width[0] }}
                        </span>
                      <input :class="error && error.medium_thumbnail_width ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.medium_thumbnail_width"
                             :placeholder="this.$t('form.media_settings.medium_thumbnail_width.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.media_settings.medium_thumbnail_width.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.media_settings.medium_thumbnail_height.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.medium_thumbnail_height">
                          {{ error.medium_thumbnail_height[0] }}
                        </span>
                      <input :class="error && error.medium_thumbnail_height ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.medium_thumbnail_height"
                             :placeholder="this.$t('form.media_settings.medium_thumbnail_height.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.media_settings.medium_thumbnail_height.subheading") }}
                     </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.media_settings.small_thumbnail_width.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.small_thumbnail_width">
                          {{ error.small_thumbnail_width[0] }}
                        </span>
                      <input :class="error && error.small_thumbnail_width ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.small_thumbnail_width"
                             :placeholder="this.$t('form.media_settings.small_thumbnail_width.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.media_settings.small_thumbnail_width.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.media_settings.small_thumbnail_height.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.small_thumbnail_height">
                          {{ error.small_thumbnail_height[0] }}
                        </span>
                      <input :class="error && error.small_thumbnail_height ? 'error' : ''"
                             class="form-control"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.small_thumbnail_height"
                             :placeholder="this.$t('form.media_settings.small_thumbnail_height.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.media_settings.small_thumbnail_height.subheading") }}
                     </span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="row" v-permission="'media_settings.update'">
                  <div class="col-md-12 px-4  text-md-end">
                    <button type="button"
                            class="btn btn-primary mb-3 px-3 py-2"
                            @click="update(false)"
                            name="button">
                        {{ this.$t("form.update") }}
                      </button>
                      <!-- <button type="button"
                              class="btn btn-success mb-3"
                              @click="update(true)"
                              name="button">
                          {{ this.$t("form.update_and_regenerate") }}
                        </button> -->
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
      permission: 'media_settings.index',
      strategy: 'index'
    },
    fetch(){
      if(this.allActiveSettings && this.allActiveSettings.settings && this.allActiveSettings.settings.specificSettings){
        this.formData.small_thumbnail_width = this.allActiveSettings.settings.specificSettings.small_thumbnail_width
        this.formData.small_thumbnail_height = this.allActiveSettings.settings.specificSettings.small_thumbnail_height
        this.formData.medium_thumbnail_width = this.allActiveSettings.settings.specificSettings.medium_thumbnail_width
        this.formData.medium_thumbnail_height = this.allActiveSettings.settings.specificSettings.medium_thumbnail_height
        this.formData.large_thumbnail_width = this.allActiveSettings.settings.specificSettings.large_thumbnail_width
        this.formData.large_thumbnail_height = this.allActiveSettings.settings.specificSettings.large_thumbnail_height
      }
    },
    data() {
      return {
        formData:{
          small_thumbnail_width:'',
          small_thumbnail_height:'',
          medium_thumbnail_width:'',
          medium_thumbnail_height:'',
          large_thumbnail_width:'',
          large_thumbnail_height:'',
          settings:'media_settings',
        },
        error: false
      }
    },
    methods: {
      ...mapActions({
        addSettings: 'Settings/addSettings',
        fetchActiveSettings: 'General/fetchActiveSettings',
      }),
      async update(regenerate) {
        this.formData.regenerate = regenerate
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
        allActiveSettings: 'General/allActiveSettings'
      })
    },
    watch:{
      allActiveSettings(){
        if(this.allActiveSettings && this.allActiveSettings.settings && this.allActiveSettings.settings.specificSettings){
          this.formData.small_thumbnail_width = this.allActiveSettings.settings.specificSettings.small_thumbnail_width
          this.formData.small_thumbnail_height = this.allActiveSettings.settings.specificSettings.small_thumbnail_height
          this.formData.medium_thumbnail_width = this.allActiveSettings.settings.specificSettings.medium_thumbnail_width
          this.formData.medium_thumbnail_height = this.allActiveSettings.settings.specificSettings.medium_thumbnail_height
          this.formData.large_thumbnail_width = this.allActiveSettings.settings.specificSettings.large_thumbnail_width
          this.formData.large_thumbnail_height = this.allActiveSettings.settings.specificSettings.large_thumbnail_height
        }
      }
    }
  }

</script>
