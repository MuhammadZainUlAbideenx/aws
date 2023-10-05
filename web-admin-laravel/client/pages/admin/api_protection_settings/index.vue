<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header ">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.api_protection_settings.edit_api_protection_settings") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{ this.$t("sidebar.home") }}</nuxt-link>
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.api_protection_settings.form_description") }}
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
            <div class="card card-custom gutter-b border-0" >
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 ps-md-0 ">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.api_protection_settings.consumer_key.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.consumer_key">
                          {{ error.consumer_key[0] }}
                        </span>
                      <input :class="error && error.consumer_key ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.consumer_key"
                             :placeholder="this.$t('form.api_protection_settings.consumer_key.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.api_protection_settings.consumer_key.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.api_protection_settings.consumer_secret.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.consumer_secret">
                          {{ error.consumer_secret[0] }}
                        </span>
                      <input :class="error && error.consumer_secret ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData.consumer_secret"
                             :placeholder="this.$t('form.api_protection_settings.consumer_secret.placeholder')"
                             trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.api_protection_settings.consumer_secret.subheading") }}
                     </span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="row" v-permission="'api_protection_settings.update'">
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
      permission: 'api_protection_settings.index',
      strategy: 'index'
    },
    async fetch(){
      if(!this.allActiveSettings.settings){
        await this.fetchActiveSettings();
      }
      if(this.allActiveSettings && this.allActiveSettings.settings && this.allActiveSettings.settings.specificSettings){
        this.formData.consumer_key = this.allActiveSettings.settings.specificSettings.consumer_key
        this.formData.consumer_secret = this.allActiveSettings.settings.specificSettings.consumer_secret
      }
    },
    data() {
      return {
        formData:{
          consumer_key:'',
          consumer_secret:'',
          settings:'api_protection_settings',
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
