<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.facebook_settings.facebook_settings") }}
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
                  {{ this.$t("sidebar.facebook_setting") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.facebook_settings.form_description") }}
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
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0" >
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.facebook_settings.facebook_app_url.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.facebook_app_url">
                          {{ error.facebook_app_url[0] }}
                        </span>
                      <input :class="error && error.facebook_app_url ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.facebook_app_url"
                             :placeholder="this.$t('form.facebook_settings.facebook_app_url.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.facebook_settings.facebook_app_url.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.facebook_settings.facebook_app_id.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.facebook_app_id">
                          {{ error.facebook_app_id[0] }}
                        </span>
                      <input :class="error && error.facebook_app_id ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.facebook_app_id"
                             :placeholder="this.$t('form.facebook_settings.facebook_app_id.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.facebook_settings.facebook_app_id.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.facebook_settings.facebook_secret.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.facebook_secret">
                          {{ error.facebook_secret[0] }}
                        </span>
                      <input :class="error && error.facebook_secret ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.facebook_secret"
                             :placeholder="this.$t('form.facebook_settings.facebook_secret.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.facebook_settings.facebook_secret.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 d-flex justify-content-center flex-column">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.facebook_settings.facebook_login_is_active.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.facebook_login_is_active"
                          :checked="formData.facebook_login_is_active ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.facebook_settings.facebook_login_is_active.subheading") }}
                    </span>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="row" v-permission="'facebook_settings.update'">
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
      permission: 'facebook_settings.index',
      strategy: 'index'
    },
    async fetch(){
      if(!this.allActiveSettings.settings){
        await this.fetchActiveSettings();
      }
      if(this.allActiveSettings && this.allActiveSettings.settings && this.allActiveSettings.settings.specificSettings){
        this.formData.facebook_login_is_active = parseInt(this.allActiveSettings.settings.specificSettings.facebook_login_is_active)
        this.formData.facebook_app_url = this.allActiveSettings.settings.specificSettings.facebook_app_url
        this.formData.facebook_app_id = this.allActiveSettings.settings.specificSettings.facebook_app_id
        this.formData.facebook_secret = this.allActiveSettings.settings.specificSettings.facebook_secret
      }
    },
    data() {
      return {
        formData:{
          facebook_login_is_active:'',
          facebook_app_url:'',
          facebook_app_id:'',
          facebook_secret:'',
          settings:'facebook_settings',
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
      })
    },
    watch:{
    }
  }

</script>
