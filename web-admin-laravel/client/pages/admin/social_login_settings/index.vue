<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.social_login_settings.social_login_settings") }}
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
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.social_login_settings.form_description") }}
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
        <AdminFormLoader />
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-custom gutter-b border-0">
              <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button
                      class="btn nav-link active"
                      id="pills-home-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-facebook"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true"
                    >
                      {{$t('facebook')}}
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button
                      class="btn nav-link"
                      id="pills-profile-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-google"
                      type="button"
                      role="tab"
                      aria-controls="pills-profile"
                      aria-selected="false"
                    >
                      {{$t('google')}}
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button
                      class="btn nav-link"
                      id="pills-contact-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-apple"
                      type="button"
                      role="tab"
                      aria-controls="pills-contact"
                      aria-selected="false"
                    >
                      {{$t('apple')}}
                    </button>
                  </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                  <div
                    class="tab-pane fade show active"
                    id="pills-facebook"
                    role="tabpanel"
                    aria-labelledby="pills-home-tab"
                  >
                    <div class="row p-4">
                      <div class="col-md-6 my-1">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label"
                            >{{
                              this.$t(
                                "form.social_login_settings.facebook_app_url.label"
                              )
                            }}:</label
                          >
                          <span
                            class="float-end text-danger"
                            v-if="error && error.facebook_app_url"
                          >
                            {{ error.facebook_app_url[0] }}
                          </span>
                          <input
                            :class="
                              error && error.facebook_app_url ? 'error' : ''
                            "
                            class="form-control"
                            aria-describedby="input-live-help input-live-feedback"
                            v-model="formData.facebook_app_url"
                            :placeholder="
                              this.$t(
                                'form.social_login_settings.facebook_app_url.placeholder'
                              )
                            "
                            trim
                          />
                          <span class="px-2 heebo-light">
                            {{
                              $t(
                                "form.social_login_settings.facebook_app_url.subheading"
                              )
                            }}
                          </span>
                        </div>
                      </div>
                      <div class="col-md-6 my-1">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label"
                            >{{
                              this.$t(
                                "form.social_login_settings.facebook_app_id.label"
                              )
                            }}:</label
                          >
                          <span
                            class="float-end text-danger"
                            v-if="error && error.facebook_app_id"
                          >
                            {{ error.facebook_app_id[0] }}
                          </span>
                          <input
                            :class="
                              error && error.facebook_app_id ? 'error' : ''
                            "
                            class="form-control"
                            aria-describedby="input-live-help input-live-feedback"
                            v-model="formData.facebook_app_id"
                            :placeholder="
                              this.$t(
                                'form.social_login_settings.facebook_app_id.placeholder'
                              )
                            "
                            trim
                          />
                          <span class="px-2 heebo-light">
                            {{
                              $t(
                                "form.social_login_settings.facebook_app_id.subheading"
                              )
                            }}
                          </span>
                        </div>
                      </div>
                      <div class="col-md-6 my-1">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label"
                            >{{
                              this.$t(
                                "form.social_login_settings.facebook_secret.label"
                              )
                            }}:</label
                          >
                          <span
                            class="float-end text-danger"
                            v-if="error && error.facebook_secret"
                          >
                            {{ error.facebook_secret[0] }}
                          </span>
                          <input
                            :class="
                              error && error.facebook_secret ? 'error' : ''
                            "
                            class="form-control"
                            aria-describedby="input-live-help input-live-feedback"
                            v-model="formData.facebook_secret"
                            :placeholder="
                              this.$t(
                                'form.social_login_settings.facebook_secret.placeholder'
                              )
                            "
                            trim
                          />
                          <span class="px-2 heebo-light">
                            {{
                              $t(
                                "form.social_login_settings.facebook_secret.subheading"
                              )
                            }}
                          </span>
                        </div>
                      </div>
                      <div
                        class="
                          col-md-6
                          my-1
                          d-flex
                          justify-content-center
                          flex-column
                        "
                      >
                        <div class="d-flex align-items-center">
                          <label class="label form-label me-4 text-capitalize">
                            {{
                              this.$t(
                                "form.social_login_settings.facebook_login_is_active.label"
                              )
                            }}
                          </label>
                          <div class="form-switch">
                            <input
                              class="form-check-input"
                              v-model="formData.facebook_login_is_active"
                              :checked="
                                formData.facebook_login_is_active
                                  ? 'checked'
                                  : ''
                              "
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                            />
                          </div>
                        </div>
                        <span class="heebo-light">
                          {{
                            $t(
                              "form.social_login_settings.facebook_login_is_active.subheading"
                            )
                          }}
                        </span>
                      </div>
                      <div
                        class="row"
                        v-permission="'social_login_settings.update'"
                      >
                        <div class="col-md-12 px-4 text-center text-md-end">
                          <button
                            type="button"
                            class="btn btn-primary mb-3 px-3 py-2"
                            @click="fb_update()"
                            name="button"
                          >
                            {{ this.$t("form.update") }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="pills-google"
                    role="tabpanel"
                    aria-labelledby="pills-profile-tab"
                  >
                    <div class="row p-4">
                      <div class="col-md-6 my-1">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label"
                            >{{
                              this.$t(
                                "form.social_login_settings.google_app_url.label"
                              )
                            }}:</label
                          >
                          <span
                            class="float-end text-danger"
                            v-if="error && error.google_app_url"
                          >
                            {{ error.google_app_url[0] }}
                          </span>
                          <input
                            :class="
                              error && error.google_app_url ? 'error' : ''
                            "
                            class="form-control"
                            aria-describedby="input-live-help input-live-feedback"
                            v-model="formData.google_app_url"
                            :placeholder="
                              this.$t(
                                'form.social_login_settings.google_app_url.placeholder'
                              )
                            "
                            trim
                          />
                          <span class="px-2 heebo-light">
                            {{
                              $t(
                                "form.social_login_settings.google_app_url.subheading"
                              )
                            }}
                          </span>
                        </div>
                      </div>
                      <div class="col-md-6 my-1">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label"
                            >{{
                              this.$t(
                                "form.social_login_settings.google_app_id.label"
                              )
                            }}:</label
                          >
                          <span
                            class="float-end text-danger"
                            v-if="error && error.google_app_id"
                          >
                            {{ error.google_app_id[0] }}
                          </span>
                          <input
                            :class="error && error.google_app_id ? 'error' : ''"
                            class="form-control"
                            aria-describedby="input-live-help input-live-feedback"
                            v-model="formData.google_app_id"
                            :placeholder="
                              this.$t(
                                'form.social_login_settings.google_app_id.placeholder'
                              )
                            "
                            trim
                          />
                          <span class="px-2 heebo-light">
                            {{
                              $t(
                                "form.social_login_settings.google_app_id.subheading"
                              )
                            }}
                          </span>
                        </div>
                      </div>
                      <div class="col-md-6 my-1">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label"
                            >{{
                              this.$t(
                                "form.social_login_settings.google_secret.label"
                              )
                            }}:</label
                          >
                          <span
                            class="float-end text-danger"
                            v-if="error && error.google_secret"
                          >
                            {{ error.google_secret[0] }}
                          </span>
                          <input
                            :class="error && error.google_secret ? 'error' : ''"
                            class="form-control"
                            aria-describedby="input-live-help input-live-feedback"
                            v-model="formData.google_secret"
                            :placeholder="
                              this.$t(
                                'form.social_login_settings.google_secret.placeholder'
                              )
                            "
                            trim
                          />
                          <span class="px-2 heebo-light">
                            {{
                              $t(
                                "form.social_login_settings.google_secret.subheading"
                              )
                            }}
                          </span>
                        </div>
                      </div>
                      <div
                        class="
                          col-md-6
                          my-1
                          d-flex
                          justify-content-center
                          flex-column
                        "
                      >
                        <div class="d-flex align-items-center">
                          <label class="label form-label me-4 text-capitalize">
                            {{
                              this.$t(
                                "form.social_login_settings.google_login_is_active.label"
                              )
                            }}
                          </label>
                          <div class="form-switch">
                            <input
                              class="form-check-input"
                              v-model="formData.google_login_is_active"
                              :checked="
                                formData.google_login_is_active ? 'checked' : ''
                              "
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                            />
                          </div>
                        </div>
                        <span class="heebo-light">
                          {{
                            $t(
                              "form.social_login_settings.google_login_is_active.subheading"
                            )
                          }}
                        </span>
                      </div>
                      <div
                        class="row"
                        v-permission="'social_login_settings.update'"
                      >
                        <div class="col-md-12 px-4 text-center text-md-end">
                          <button
                            type="button"
                            class="btn btn-primary mb-3 px-3 py-2"
                            @click="google_update()"
                            name="button"
                          >
                            {{ this.$t("form.update") }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="pills-apple"
                    role="tabpanel"
                    aria-labelledby="pills-contact-tab"
                  >
                    <div class="row p-4">
                      <div class="col-md-6 my-1">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label"
                            >{{
                              this.$t(
                                "form.social_login_settings.apple_app_url.label"
                              )
                            }}:</label
                          >
                          <span
                            class="float-end text-danger"
                            v-if="error && error.apple_app_url"
                          >
                            {{ error.apple_app_url[0] }}
                          </span>
                          <input
                            :class="error && error.apple_app_url ? 'error' : ''"
                            class="form-control"
                            aria-describedby="input-live-help input-live-feedback"
                            v-model="formData.apple_app_url"
                            :placeholder="
                              this.$t(
                                'form.social_login_settings.apple_app_url.placeholder'
                              )
                            "
                            trim
                          />
                          <span class="px-2 heebo-light">
                            {{
                              $t(
                                "form.social_login_settings.apple_app_url.subheading"
                              )
                            }}
                          </span>
                        </div>
                      </div>
                      <div class="col-md-6 my-1">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label"
                            >{{
                              this.$t(
                                "form.social_login_settings.apple_client_id.label"
                              )
                            }}:</label
                          >
                          <span
                            class="float-end text-danger"
                            v-if="error && error.apple_client_id"
                          >
                            {{ error.apple_client_id[0] }}
                          </span>
                          <input
                            :class="
                              error && error.apple_client_id ? 'error' : ''
                            "
                            class="form-control"
                            aria-describedby="input-live-help input-live-feedback"
                            v-model="formData.apple_client_id"
                            :placeholder="
                              this.$t(
                                'form.social_login_settings.apple_client_id.placeholder'
                              )
                            "
                            trim
                          />
                          <span class="px-2 heebo-light">
                            {{
                              $t(
                                "form.social_login_settings.apple_client_id.subheading"
                              )
                            }}
                          </span>
                        </div>
                      </div>
                      <div class="col-md-6 my-1">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label"
                            >{{
                              this.$t(
                                "form.social_login_settings.apple_client_secret.label"
                              )
                            }}:</label
                          >
                          <span
                            class="float-end text-danger"
                            v-if="error && error.apple_client_secret"
                          >
                            {{ error.apple_client_secret[0] }}
                          </span>
                          <input
                            :class="
                              error && error.apple_client_secret ? 'error' : ''
                            "
                            class="form-control"
                            aria-describedby="input-live-help input-live-feedback"
                            v-model="formData.apple_client_secret"
                            :placeholder="
                              this.$t(
                                'form.social_login_settings.apple_client_secret.placeholder'
                              )
                            "
                            trim
                          />
                          <span class="px-2 heebo-light">
                            {{
                              $t(
                                "form.social_login_settings.apple_client_secret.subheading"
                              )
                            }}
                          </span>
                        </div>
                      </div>
                      <div
                        class="
                          col-md-6
                          my-1
                          d-flex
                          justify-content-center
                          flex-column
                        "
                      >
                        <div class="d-flex align-items-center">
                          <label class="label form-label me-4 text-capitalize">
                            {{
                              this.$t(
                                "form.social_login_settings.apple_login_is_active.label"
                              )
                            }}
                          </label>
                          <div class="form-switch">
                            <input
                              class="form-check-input"
                              v-model="formData.apple_login_is_active"
                              :checked="
                                formData.apple_login_is_active ? 'checked' : ''
                              "
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                            />
                          </div>
                        </div>
                        <span class="heebo-light">
                          {{
                            $t(
                              "form.social_login_settings.apple_login_is_active.subheading"
                            )
                          }}
                        </span>
                      </div>
                      <div
                        class="row"
                        v-permission="'social_login_settings.update'"
                      >
                        <div class="col-md-12 px-4 text-center text-md-end">
                          <button
                            type="button"
                            class="btn btn-primary mb-3 px-3 py-2"
                            @click="apple_update()"
                            name="button"
                          >
                            {{ this.$t("form.update") }}
                          </button>
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
    </section>
    <!-- /.content -->
  </div>
</template>
<script >
// import CkeditorNuxt from "@/components/global/ckeditorNuxt";
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "social_login_settings.index",
    strategy: "index",
  },
  async fetch() {
    if (!this.allActiveSettings.settings) {
      await this.fetchActiveSettings();
    }
    if (
      this.allActiveSettings &&
      this.allActiveSettings.settings &&
      this.allActiveSettings.settings.specificSettings
    ) {
      this.formData.facebook_login_is_active = parseInt(
        this.allActiveSettings.settings.specificSettings
          .facebook_login_is_active
      );
      this.formData.facebook_app_url =
        this.allActiveSettings.settings.specificSettings.facebook_app_url;
      this.formData.facebook_app_id =
        this.allActiveSettings.settings.specificSettings.facebook_app_id;
      this.formData.facebook_secret =
        this.allActiveSettings.settings.specificSettings.facebook_secret;
      this.formData.google_login_is_active = parseInt(
        this.allActiveSettings.settings.specificSettings.google_login_is_active
      );
      this.formData.google_app_url =
        this.allActiveSettings.settings.specificSettings.google_app_url;
      this.formData.google_app_id =
        this.allActiveSettings.settings.specificSettings.google_app_id;
      this.formData.google_secret =
        this.allActiveSettings.settings.specificSettings.google_secret;
      this.formData.apple_login_is_active = parseInt(
        this.allActiveSettings.settings.specificSettings.apple_login_is_active
      );
      this.formData.apple_app_url =
        this.allActiveSettings.settings.specificSettings.apple_app_url;
      this.formData.apple_client_id =
        this.allActiveSettings.settings.specificSettings.apple_client_id;
      this.formData.apple_client_secret =
        this.allActiveSettings.settings.specificSettings.apple_client_secret;
    }
  },
  data() {
    return {
      formData: {
        facebook_login_is_active: "",
        google_login_is_active: "",
        apple_login_is_active: "",
        facebook_app_url: "",
        facebook_app_id: "",
        facebook_secret: "",
        google_app_url: "",
        google_app_id: "",
        google_secret: "",
        apple_app_url: "",
        apple_client_id: "",
        apple_client_secret: "",
        settings: "",
      },
      error: false,
    };
  },
  methods: {
    ...mapActions({
      addSettings: "Settings/addSettings",
      fetchActiveSettings: "General/fetchActiveSettings",
      fetchActiveCountries: "General/fetchActiveCountries",
    }),
    async fb_update() {
      this.formData.settings = "facebook_settings";
      await this.addSettings(this.formData).then((res) => {
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.fetchActiveSettings();
          this.error = false;
          this.$toast.success(res.message);
        }
      });
    },
    async google_update() {
      this.formData.settings = "google_settings";
      await this.addSettings(this.formData).then((res) => {
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.fetchActiveSettings();
          this.error = false;
          this.$toast.success(res.message);
        }
      });
    },
    async apple_update() {
      this.formData.settings = "apple_settings";
      await this.addSettings(this.formData).then((res) => {
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.fetchActiveSettings();
          this.error = false;
          this.$toast.success(res.message);
        }
      });
    },
  },
  computed: {
    ...mapGetters({
      allActiveSettings: "General/allActiveSettings",
    }),
  },
  watch: {},
};
</script>
