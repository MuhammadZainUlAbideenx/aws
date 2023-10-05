<template>
  <div class="container-fluid signin">

    <div class="row d-flex align-items-center">
        <div
                        class="col-lg-6 py-lg-0 py-5 signin-slider d-flex justify-content-center flex-column h-100"
                    >
                        <div class="px-lg-3 px-2 logo"><GlobalLogo /></div>

                        <VueSlickCarousel :key="key" v-bind="settings" class="my-5">
                            <div class="px-lg-3 px-2 ">
                                <img
                                    src="~/assets/images/login1.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                            <div class="px-lg-3 px-2 ">
                                <img
                                    src="~/assets/images/login2.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                            <div class="px-lg-3 px-2 ">
                                <img
                                    src="~/assets/images/login1.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                            <div class="px-lg-3 px-2 ">
                                <img
                                    src="~/assets/images/login2.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                        </VueSlickCarousel>
                        <p class="mt-5 px-lg-3 px-2">{{$t('login.login_description')}}</p>
        </div>
      <div class="col-lg-6 py-5 signin-form d-flex justify-content-center flex-column h-100">
        <div class="login-slot">
          <div class="text-center mb-5">
            <h2 class="text-primary mb-5">Forgot Password</h2>
            <nuxt-link
                to="/"
              >
                <img src="~/assets/images/nictus-logo.png" alt="" />
              </nuxt-link>
          </div>
          <ul
            class="
              tab
              nav nav-pills
              mb-3
              d-flex
              align-items-center
              justify-content-center
            "
            id="pills-tab"
            role="tablist"
          >
            <!-- <li class="nav-item" role="presentation">
              <nuxt-link
                to="#"
                class="nav-link active"
                id="pills-email-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-email"
                type="button"
                role="tab"
                aria-controls="pills-email"
                aria-selected="true"
              >
                Email
              </nuxt-link>
            </li> -->
            <!-- <li class="nav-item" role="presentation">
            <nuxt-link
              class=" nav-link" to="#"
              id="pills-phone-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-phone"
              type="button"
              role="tab"
              aria-controls="pills-phone"
              aria-selected="false"
            >
              Phone
            </nuxt-link>
          </li> -->
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div
              class="tab-pane fade active show"
              id="pills-email"
              role="tabpanel"
              aria-labelledby="pills-email-tab"
            >
              <form @submit.prevent="sendPasswordResetLink">
                <div class="input-group mb-4">
                  <input
                    type="email"
                    id="LoggingEmailAddress"
                    class="shadow-sm form-control rounded-1 border-0"
                    required
                    v-model="email"
                    placeholder="Enter Email"
                  />
                  <div class="input-group-text custom-icon border-0 bg-transparent">
                    <div class="text-primary fs-5">
                      <fa :icon="['fas', 'at']" fixed-width class="" />
                    </div>
                  </div>
                </div>

                <span v-if="error" class="text-xs text-red-600">
                  {{ error.email ? error.email[0] : error.message }}
                </span>
                <div class="d-grid">
                  <button class="btn btn-primary d-flex justify-content-center align-items-center text-uppercase text-white fw-bold shadow-lg" type="submit">
                    Reset Password
                  </button>
                </div>
              </form>
              <p class="mt-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore. Lorem ipsum dolor
                sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut labore et dolore.
              </p>
            </div>

            <div
              class="tab-pane fade"
              id="pills-phone"
              role="tabpanel"
              aria-labelledby="pills-phone-tab"
            >
              <form @submit.prevent="sendPasswordResetLink">
                <div class="input-group mb-4">
                  <input
                    type="text"
                    id="phone"
                    class="shadow-sm form-control rounded-1 border-0"
                    required
                    placeholder="Enter Username"
                  />
                  <div class="input-group-text custom-icon border-0 bg-transparent">
                    <div class="text-primary fs-5">
                      <fa :icon="['fas', 'phone']" fixed-width class="" />
                    </div>
                  </div>
                </div>

                <div class="d-grid">
                  <button class="btn btn-primary d-flex justify-content-center align-items-center text-uppercase text-white fw-bold shadow-lg" type="submit">
                    Reset Password
                  </button>
                </div>
              </form>
              <p class="mt-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore. Lorem ipsum dolor
                sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut labore et dolore.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.login-wrapper {
  height: 100vh;
}
@media only screen and (max-width: 767px) {
  .login-wrapper {
    height: auto;
  }
}
</style>

<script>
export default {
  layout: "default_guest",
  auth: "guest",
  data() {
    return {
      email: "",
      success: null,
      error: null,
    };
  },
  methods: {
    async sendPasswordResetLink() {
      this.error = null;
      await this.$webService
        .forgotPassword({ email: this.email })
        .then((response) => this.$toast.success(response.message))
        .catch((e) => (this.error = e.response.data.errors ?? e.response.data));
    },
  },
  data() {
        return {
            settings: {
                slidesToShow: 2,
                slidesToScroll:1,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            arrows: false,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                        },
                    },

                ],
            },
            currentlyActiveTemplate: "",
            signUpData: {
                first_name: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
            formData: {
                email: "",
                password: "",
                strategy: "customer",
            },
            error: null,
            errors: "",
            fcmToken: "",
            uid: "",
            validatorScop: "loginScope",
            loginPasswordType: "password",
            signUpPasswordType: "password",
            signUpConfirmPasswordType: "password",
        };
    },
};
</script>
