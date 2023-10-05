<template>
  <div class="login py-5">
    <div
      class="
        row
        m-0
        d-flex
        align-items-center
        justify-content-center
        px-3 px-md-0
      "
    >
      <div class="w-450px">
        <div class="border border-white rounded">
          <div class="py-4 bg-white rounded">
            <div class="container py-2">
              <h3 class="text-center">
                <nuxt-link to="/admin/dashboard" class="text-primary heebo-bold"
                  ><AdminLogo
                /></nuxt-link>
              </h3>
              <p class="text-center pb-4 mb-0">
                 {{$t('login.admin_description')}}
              </p>
              <form @submit.prevent="loginPassport" class="px-md-3">
                <div class="pb-4 px-md-3">
                  <label for="LoggingEmailAddress" class="form-label px-3"
                    >{{$t('login.email_address')}}</label
                  >
                  <span
                    v-if="error && error.errors && error.errors.email"
                    class="float-end"
                  >
                    <span class="text-danger">
                      {{ error.errors.email[0] }}
                    </span>
                  </span>
                  <div
                    v-if="vErrors.has('email')"
                    class="float-end"
                    :show="true"
                  >
                    <span class="text-danger">
                      {{ vErrors.first("email") }}
                    </span>
                  </div>
                  <div class="form-icon position-relative d-inline-block w-100">
                    <input
                      :class="
                        error && error.errors && error.errors.email
                          ? 'error'
                          : ''
                      "
                      id="LoggingEmailAddress"
                      v-model="form.username"
                      type="email"
                      class="form-control"
                      aria-describedby="emailHelp"
                     :placeholder="$t('login.enter_email_placeholder')"
                      data-vv-name="email"
                      v-validate="'required|email'"
                      :state="vErrors.has('email') ? false : null"
                    />
                    <div
                      class="
                        px-3
                        position-absolute
                        end-0
                        translate-middle-y
                        top-50
                      "
                    >
                      <fa icon="at" class="text-primary" fixed-width />
                    </div>
                  </div>
                </div>

                <div class="pb-4 px-md-3">
                  <label for="loggingPassword" class="form-label px-3"
                    >{{$t('login.password')}}</label
                  >
                  <span
                    v-if="error && error.errors && error.errors.password"
                    class="float-end"
                  >
                    <span class="text-danger">
                      {{ error.errors.password[0] }}
                    </span>
                  </span>
                  <div
                    v-if="vErrors.has('password')"
                    class="float-end"
                    :show="true"
                  >
                    <span class="text-danger">
                      {{ vErrors.first("password") }}
                    </span>
                  </div>
                  <div class="form-icon position-relative d-inline-block w-100">
                    <input
                      :class="
                        error && error.errors && error.errors.password
                          ? 'error'
                          : ''
                      "
                      :type="loginPasswordType"
                      id="loggingPassword"
                      v-model="form.password"
                      class="form-control"
                      :placeholder="$t('login.enter_password_placeholder')"
                      data-vv-name="password"
                      v-validate="'required|min:8'"
                      :state="vErrors.has('password') ? false : null"
                    />
                    <div
                      class="
                        px-3
                        position-absolute
                        top-50
                        end-0
                        translate-middle-y
                      "
                      v-on:click="changeLoginPasswordType"
                    >
                      <fa icon="eye" class="text-primary" fixed-width />
                    </div>
                  </div>
                </div>
                <div
                  class="d-flex align-items-center justify-content-between px-3"
                >
                  <div class="form-check">
                    <input
                      type="checkbox"
                      class="form-check-input"
                      id="login-check"
                    />
                    <label class="form-check-label" for="login-check">
                      {{$t('login.keep_login')}}</label
                    >
                  </div>

                  <div class="form-check pl-0">
                    <nuxt-link
                      :to="localePath('/forgot-passsword')"
                      class="text-xs heebo-light hover:underline"
                    >
                     {{$t('login.forgot_password')}}
                    </nuxt-link>
                  </div>
                </div>

                <div class="mb-3">
                  <!-- <span
                      v-if="error"
                      class="inline-flex items-center font-semibold text-sm text-red-600">
                      <svg
                        aria-hidden="true"
                        class="fill-current mr-2"
                        height="12"
                        width="12"
                        viewBox="0 0 16 16"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M10.115 1.308l5.635 11.269A2.365 2.365 0 0 1 13.634 16H2.365A2.365 2.365 0 0 1 .25 12.577L5.884 1.308a2.365 2.365 0 0 1 4.231 0zM8 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM8 9c.552 0 1-.32 1-.714V4.714C9 4.32 8.552 4 8 4s-1 .32-1 .714v3.572C7 8.68 7.448 9 8 9z"
                          fill-rule="evenodd"
                        ></path>
                      </svg>
                      <span class="text-danger"> {{ error.message }} </span>
                    </span> -->
                </div>
                <div class="d-grid gap-2 p-3">
                  <button
                    type="submit"
                    :disabled="disabled"
                    class="btn btn-primary login-btn"
                  >
                   {{$t('login.login')}}
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- <div class="py-4 text-center">
              <span class="text-white lead text-sm">Or Login with </span>
              <div class="d-flex flex-column flex-md-row align-items-center justify-content-center mt-3">
                <button
                  type="button"
                  class="btn btn-labeled text-white google py-0 mb-3 mb-md-0 me-3">
                  <span class="btn-label">
                    <fa :icon="['fab', 'google-plus-g']" fixed-width /> </span
                  >Google+
                </button>
                <button
                  type="button"
                  class="btn btn-labeled text-white facebook py-0">
                  <span class="btn-label"
                    ><fa :icon="['fab', 'facebook-f']" fixed-width /></span
                  >Facebook
                </button>
              </div>
            </div> -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin_guest",
  auth: false,
  data() {
    return {
      form: {
        username: "",
        password: "",
        strategy: "admin",
        email: "",
      },
      disabled: false,
      error: null,
      fcmToken: "",
      uid: "",
      loginPasswordType: "password",
    };
  },
  mounted() {
    if (
      this.allSettings &&
      this.allSettings.general_settings &&
      this.allSettings.general_settings.is_notification_activated
    ) {
        if (Notification.permission == 'granted') {
           this.generateFcmTokenAndUid();
            }
    }
  },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
  methods: {
    async generateFcmTokenAndUid() {
      this.fcmToken = await this.$fire.messaging.getToken();
      var navigator_info = window.navigator;
      var screen_info = window.screen;
      var uid = navigator_info.mimeTypes.length;
      uid += navigator_info.userAgent.replace(/\D+/g, "");
      uid += navigator_info.plugins.length;
      uid += screen_info.height || "";
      uid += screen_info.width || "";
      uid += screen_info.pixelDepth || "";
      this.uid = uid;
    },
    async loginPassport() {
      this.disabled = true;
      await this.logoutOtherAccounts();
      this.form.email = this.form.username;
      this.error = null;
      await this.$auth
        .loginWith("admin", { data: this.form })
        .then(async () => {
          await this.$auth.fetchUser();
          await this.$gates.setRoles(this.$auth.user.roles);
          await this.$gates.setPermissions(this.$auth.user.permissions);
          if (
            this.allSettings &&
            this.allSettings.general_settings &&
            this.allSettings.general_settings.is_notification_activated
          ) {
             if (Notification.permission == 'granted') {
             await this.storeFcmToken();
            }
          }
          this.$router.replace("/admin/dashboard");
          this.$toast.success(this.$t('you_have_been_logged_in'));
        })
        .catch((e) => (this.error = e.response.data));
      if (this.error) {
        this.disabled = false;
      }
    },
    async storeFcmToken() {
      const { data } = await this.$webService.storeFcmToken({
        device_id: this.uid,
        fcm_token: this.fcmToken,
      });
    },
    changeLoginPasswordType()
    {
        if (this.loginPasswordType === "password") {
             this.loginPasswordType = "text"
        }
        else {
             this.loginPasswordType = "password"
        }
    },
    async logoutOtherAccounts()
    {
        await this.$auth.logout();
        await this.$gates.setRoles([]);
        await this.$gates.setPermissions([]);
    }
  },
  watch: {
    form: {
      handler(val, oldVal) {
        if ((this.error = null)) {
          this.error = null;
        }
      },
      deep: true,
    },
  },
};
</script>
