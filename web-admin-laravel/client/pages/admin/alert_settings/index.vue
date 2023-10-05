<template >

  <div class="">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.alert_settings.alert_settings") }}
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
                  {{ this.$t("sidebar.alert_setting") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.alert_settings.form_description") }}
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
                  <div class="col-md-6 d-flex justify-content-center flex-column ps-md-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.customer_welcome_send_email.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.customer_welcome_send_email"
                          :checked="formData.customer_welcome_send_email ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.customer_welcome_send_email.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 d-flex justify-content-center flex-column pe-md-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.customer_welcome_send_notification.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.customer_welcome_send_notification"
                          :checked="formData.customer_welcome_send_notification ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.customer_welcome_send_notification.subheading") }}
                    </span>
                  </div>

                  <div class="col-md-6 d-flex justify-content-center flex-column ps-md-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.order_send_email.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.order_send_email"
                          :checked="formData.order_send_email ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.order_send_email.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 d-flex justify-content-center flex-column pe-md-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.order_send_notification.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.order_send_notification"
                          :checked="formData.order_send_notification ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.order_send_notification.subheading") }}
                    </span>
                  </div>

                  <div class="col-md-6 d-flex justify-content-center flex-column ps-md-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.order_status_send_email.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.order_status_send_email"
                          :checked="formData.order_status_send_email ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.order_status_send_email.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 d-flex justify-content-center flex-column pe-md-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.order_status_send_notification.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.order_status_send_notification"
                          :checked="formData.order_status_send_notification ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.order_status_send_notification.subheading") }}
                    </span>
                  </div>

                  <div class="col-md-6 d-flex justify-content-center flex-column ps-md-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.new_product_send_email.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.new_product_send_email"
                          :checked="formData.new_product_send_email ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.new_product_send_email.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 d-flex justify-content-center flex-column pe-md-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.new_product_send_notification.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.new_product_send_notification"
                          :checked="formData.new_product_send_notification ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.new_product_send_notification.subheading") }}
                    </span>
                  </div>

                  <div class="col-md-6 d-flex justify-content-center flex-column ps-md-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.forgot_password_send_email.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.forgot_password_send_email"
                          :checked="formData.forgot_password_send_email ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.forgot_password_send_email.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 d-flex justify-content-center flex-column pe-md-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.forgot_password_send_notification.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.forgot_password_send_notification"
                          :checked="formData.forgot_password_send_notification ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.forgot_password_send_notification.subheading") }}
                    </span>
                  </div>


                  <div class="col-md-6 d-flex justify-content-center flex-column ps-md-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.adding_news_send_email.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.adding_news_send_email"
                          :checked="formData.adding_news_send_email ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.adding_news_send_email.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 d-flex justify-content-center flex-column pe-md-0">
                    <div class="d-flex align-items-center justify-content-between ">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.adding_news_send_notification.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.adding_news_send_notification"
                          :checked="formData.adding_news_send_notification ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.adding_news_send_notification.subheading") }}
                    </span>
                  </div>

                  <div class="col-md-6 d-flex justify-content-center flex-column ps-md-0 mb-0">
                    <div class="d-flex align-items-center justify-content-between ">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.alert_settings.contact_us_send_email.label") }}
                      </label>
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.contact_us_send_email"
                          :checked="formData.contact_us_send_email ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.alert_settings.contact_us_send_email.subheading") }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row" v-permission="'alert_settings.update'">
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
      permission: 'alert_settings.index',
      strategy: 'index'
    },
    async fetch(){
      if(!this.allActiveSettings.settings){
        await this.fetchActiveSettings();
      }
      if(this.allActiveSettings && this.allActiveSettings.settings && this.allActiveSettings.settings.specificSettings){
        this.formData.contact_us_send_email = parseInt(this.allActiveSettings.settings.specificSettings.contact_us_send_email)
        this.formData.adding_news_send_notification = parseInt(this.allActiveSettings.settings.specificSettings.adding_news_send_notification)
        this.formData.adding_news_send_email = parseInt(this.allActiveSettings.settings.specificSettings.adding_news_send_email)
        this.formData.forgot_password_send_notification = parseInt(this.allActiveSettings.settings.specificSettings.forgot_password_send_notification)
        this.formData.forgot_password_send_email = parseInt(this.allActiveSettings.settings.specificSettings.forgot_password_send_email)
        this.formData.new_product_send_notification = parseInt(this.allActiveSettings.settings.specificSettings.new_product_send_notification)
        this.formData.new_product_send_email = parseInt(this.allActiveSettings.settings.specificSettings.new_product_send_email)
        this.formData.customer_welcome_send_email = parseInt(this.allActiveSettings.settings.specificSettings.customer_welcome_send_email)
        this.formData.customer_welcome_send_notification = parseInt(this.allActiveSettings.settings.specificSettings.customer_welcome_send_notification)
        this.formData.order_send_email = parseInt(this.allActiveSettings.settings.specificSettings.order_send_email)
        this.formData.order_send_notification = parseInt(this.allActiveSettings.settings.specificSettings.order_send_notification)
        this.formData.order_status_send_email = parseInt(this.allActiveSettings.settings.specificSettings.order_status_send_email)
        this.formData.order_status_send_notification = parseInt(this.allActiveSettings.settings.specificSettings.order_status_send_notification)
      }
    },
    data() {
      return {
        formData:{
          contact_us_send_email:'',
          adding_news_send_notification:'',
          adding_news_send_email:'',
          forgot_password_send_notification:'',
          forgot_password_send_email:'',
          new_product_send_notification:'',
          new_product_send_email:'',
          customer_welcome_send_email:'',
          customer_welcome_send_notification:'',
          order_send_email:'',
          order_send_notification:'',
          order_status_send_email:'',
          order_status_send_notification:'',
          settings:'alert_settings',
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
