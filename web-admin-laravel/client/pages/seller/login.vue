<template>
  <!-----New Design starts------->
  <div class="login py-4">
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
          <div class="pt-4 pb-3 bg-white rounded">
            <div class="container py-2">
              <h3 class="text-center">
                <a href="/" class="text-primary heebo-bold"
                  ><AdminLogo
                /></a>
              </h3>
              <p class="text-center pb-4 mb-0">
                {{$t('login.seller_description')}}
              </p>
              <div
              >
                <div class="login-slot">
                  <ul
                    class="
                      tab
                      nav nav-pills
                      mb-5
                      d-flex
                      align-items-center
                      justify-content-center
                      bg-transparents
                    "
                    id="pills-tab"
                    role="tablist"
                  >
                    <li class="nav-item" role="presentation">
                      <nuxt-link
                        to="#"
                        class="nav-link active"
                        id="pills-login-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#pills-login"
                        type="button"
                        role="tab"
                        aria-controls="pills-login"
                        aria-selected="true"
                      >
                        {{$t('login.login')}}
                      </nuxt-link>
                    </li>
                    <li class="nav-item" role="presentation">
                      <nuxt-link
                        class="nav-link"
                        to="#"
                        id="pills-signup-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#pills-signup"
                        type="button"
                        role="tab"
                        aria-controls="pills-signup"
                        aria-selected="false"
                      >
                        {{$t('login.signup')}}
                      </nuxt-link>
                    </li>
                  </ul>
                  <div class="tab-content bg-transparent" id="pills-tabContent">
                    <div
                      class="tab-pane fade active show"
                      id="pills-login"
                      role="tabpanel"
                      aria-labelledby="pills-login-tab"
                    >
                      <form @submit.prevent="loginPassport">

                        <div
                          class="input-group mb-5 position-relative rounded-1"
                          :class="
                            error && error.errors && error.errors.email
                              ? 'error'
                              : ''
                          "
                        >
                        <span
                          v-if="error && error.errors && error.errors.email"
                          class="d-flex justify-content-end"
                        >
                          <span class="text-danger position-absolute error-pos">
                            {{ error.errors.email[0] }}
                          </span>
                        </span>
                        <div
                          v-if="vErrors.has('email')"
                          class="d-flex justify-content-end"
                          :show="true"
                        >
                          <span class="text-danger position-absolute error-pos">
                            {{ vErrors.first("email") }}
                          </span>
                        </div>
                          <input
                            type="email"
                            id="LoggingEmailAddress"
                            aria-describedby="emailHelp"
                            class="form-control rounded-1"
                            required
                            v-model="formData.email"
                            :placeholder="$t('login.enter_email_placeholder')"
                            data-vv-name="email"
                            v-validate="'required|email'"
                            :state="vErrors.has('email') ? false : null"
                          />
                          <div class="input-group-text custom-icon border-0 bg-transparent">
                            <div class="text-primary">
                              <fa
                                :icon="['fas', 'user']"
                                fixed-width
                                class=""
                              />
                            </div>
                          </div>
                        </div>


                        <div
                          class="input-group mb-5 position-relative rounded-1"
                          :class="
                            error && error.errors && error.errors.password
                              ? 'error'
                              : ''
                          "
                        >
                        <span
                          v-if="error && error.errors && error.errors.password"
                          class="d-flex justify-content-end"
                        >
                          <span class="text-danger position-absolute error-pos">
                            {{ error.errors.password[0] }}
                          </span>
                        </span>
                        <div
                          v-if="vErrors.has('password')"
                          class="d-flex justify-content-end"
                          :show="true"
                        >
                          <span class="text-danger position-absolute error-pos">
                            {{ vErrors.first("password") }}
                          </span>
                        </div>
                          <input
                            :type="loginPasswordType"
                            id="loggingPassword"
                            class="form-control rounded-1"
                            required
                            v-model="formData.password"
                            :placeholder="$t('login.enter_password_placeholder')"
                            data-vv-name="password"
                            v-validate="'required|min:8'"
                            :state="vErrors.has('password') ? false : null"
                          />
                          <div class="input-group-text custom-icon border-0 bg-transparent">
                            <div class="text-primary" v-on:click="changeLoginPasswordType">
                              <fa :icon="['fas', 'key']" fixed-width class="" />
                            </div>
                          </div>
                        </div>
                        <div
                          class="
                            d-flex
                            align-items-center
                            justify-content-between
                            px-2
                            mb-4
                          "
                        >
                          <div class="form-check">
                            <input
                              type="checkbox"
                              class="form-check-input"
                              id="login"
                            />
                            <label class="form-check-label" for="login">
                              {{$t('login.remember_me')}}</label
                            >
                          </div>

                          <div class="form-check pl-0">
                            <nuxt-link
                              :to="localePath('/forgot-password')"
                              class="text-xs heebo-light text-decoration-none"
                            >
                              {{$t('login.forgot_password')}}
                            </nuxt-link>
                          </div>
                        </div>

                        <div class="d-grid">
                          <button class="btn btn-warning" type="submit">
                            {{$t('login.login')}}
                          </button>
                        </div>
                      </form>
                      <div class="text-center my-3">
                        <span>{{$t('login.already_account.label')}}</span>
                        <span @click="openSignupTab">
                          <nuxt-link to="#" class="text-decoration-none"
                            >{{$t('login.already_account.click')}}</nuxt-link
                          >
                        </span>
                      </div>
                      <div class="mt-3 text-center"></div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="pills-signup"
                      role="tabpanel"
                      aria-labelledby="pills-signup-tab"
                    >

                      <div
                        class="input-group mb-5 position-relative rounded-1"
                        :class="error && errors && errors.name ? 'error' : ''"
                      >
                      <span
                        v-if="error && errors && errors.name"
                        class="d-flex justify-content-end"
                      >
                        <span class="text-danger position-absolute error-pos"> {{ errors.name[0] }} </span>
                      </span>
                      <div
                        v-if="vErrors.has('name')"
                        class="d-flex justify-content-end"
                        :show="true"
                      >
                        <span class="text-danger position-absolute error-pos">
                          {{ vErrors.first("name") }}
                        </span>
                      </div>
                        <input
                          type="text"
                          class="form-control rounded-1"
                          :placeholder="$t('login.enter_name_placeholder')"
                          v-model="signUpData.name"
                          data-vv-name="name"
                          v-validate="'required'"
                          :state="vErrors.has('name') ? false : null"
                        />
                        <div class="input-group-text custom-icon border-0 bg-transparent">
                          <div class="text-primary">
                            <fa :icon="['fas', 'user']" fixed-width class="" />
                          </div>
                        </div>
                      </div>

                      <div
                        class="input-group mb-5 position-relative rounded-1"
                        :class="error && errors && errors.email ? 'error' : ''"
                      >
                      <span
                        v-if="error && error && errors.email"
                        class="d-flex justify-content-end"
                      >
                        <span class="text-danger position-absolute error-pos"> {{ errors.email[0] }} </span>
                      </span>
                      <div
                        v-if="vErrors.has('signup_email')"
                        class="d-flex justify-content-end"
                        :show="true"
                      >
                        <span class="text-danger position-absolute error-pos">
                          {{ vErrors.first("signup_email") }}
                        </span>
                      </div>
                        <input
                          type="email"
                          class="form-control rounded-1"
                          :placeholder="$t('login.enter_email_placeholder')"
                          v-model="signUpData.email"
                          data-vv-name="signup_email"
                          data-vv-as="email"
                          v-validate="'email'"
                          :state="vErrors.has('email') ? false : null"
                        />
                        <div class="input-group-text custom-icon border-0 bg-transparent">
                          <div class="text-primary">
                            <fa
                              :icon="['fas', 'envelope']"
                              fixed-width
                              class=""
                            />
                          </div>
                        </div>
                      </div>

                      <div
                        class="input-group mb-5 position-relative rounded-1"
                        :class="
                          error && errors && errors.password ? 'error' : ''
                        "
                      >
                      <span
                        v-if="error && errors && errors.password"
                        class="d-flex justify-content-end"
                      >
                        <span class="text-danger position-absolute error-pos">
                          {{ errors.password[0] }}
                        </span>
                      </span>
                      <div
                        v-if="vErrors.has('signup_password')"
                        class="d-flex justify-content-end"
                        :show="true"
                      >
                        <span class="text-danger position-absolute error-pos">
                          {{ vErrors.first("signup_password") }}
                        </span>
                      </div>
                        <input
                          :type="signUpPasswordType"
                          class="form-control rounded-1"
                          :placeholder="$t('login.enter_password_placeholder')"
                          v-model="signUpData.password"
                          data-vv-name="signup_password"
                          data-vv-as="password"
                          v-validate="'required|min:8'"
                          ref="password"
                          :state="vErrors.has('password') ? false : null"
                        />
                        <div class="input-group-text custom-icon border-0 bg-transparent">
                          <div class="text-primary" v-on:click="changeSignUpPasswordType">
                            <fa :icon="['fas', 'key']" fixed-width class="" />
                          </div>
                        </div>
                      </div>

                      <div
                        class="input-group mb-4 position-relative"
                        :class="
                          error && errors && errors.password_confirmation
                            ? 'error'
                            : ''
                        "
                      >
                      <span
                        v-if="error && errors && errors.password"
                        class="d-flex justify-content-end"
                      >
                        <span class="text-danger position-absolute error-pos">
                          {{ errors.password[0] }}
                        </span>
                      </span>
                      <div
                        v-if="vErrors.has('password_confirmation')"
                        class="d-flex justify-content-end"
                        :show="true"
                      >
                        <span class="text-danger position-absolute error-pos">
                          {{ vErrors.first("password_confirmation") }}
                        </span>
                      </div>
                        <input
                          :type="signUpConfirmPasswordType"
                          class="form-control rounded-1"
                          :placeholder="$t('login.confirm_password_placeholder')"
                          v-model="signUpData.password_confirmation"
                          data-vv-name="password_confirmation"
                          v-validate="'required|confirmed:password'"
                          :state="
                            vErrors.has('password_confirmation') ? false : null
                          "
                          data-vv-as="password"
                        />
                        <div class="input-group-text custom-icon border-0 bg-transparent">
                          <div class="text-primary" v-on:click="changeSignUpConfirmPasswordType">
                            <fa :icon="['fas', 'key']" fixed-width class="" />
                          </div>
                        </div>
                      </div>

                      <div
                        class="
                          d-flex
                          align-items-center
                          justify-content-start
                          px-2
                          mb-3
                        "
                      >
                        <div class="form-check">
                          <input
                            type="checkbox"
                            class="form-check-input"
                            id="signup"
                          />
                          <label class="form-check-label" for="signup">
                            {{$t('login.remember_me')}}</label
                          >
                        </div>
                      </div>

                      <div class="d-grid">
                        <button
                          class="btn btn-warning"
                          type="button"
                          @click="register"
                        >
                          {{$t('login.signup')}}
                        </button>
                      </div>
                      <div class="text-center mt-3 mb-0">
                        <span>{{$t('login.already_account.label')}}</span>
                        <span @click="openLoginTab">
                          <a href="#" class="text-decoration-none"
                            >{{$t('login.login')}}</a
                          ></span
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
  <!----New Design ends---->
  <!-- <div class="row m-0 login-page">
    <div class="col-md-7 px-0">
      <div class="login-wrapper px-4">
        <div class="row h-100 mx-0 text-white position-relative">
          <div
            class="
              pt-5 pt-md-0
              col-md-7
              d-flex
              flex-column
              justify-content-md-center
              align-items-md-start
            "
          >
            <span class="top-level text-uppercase">
              Ecommerce Multi Vendor
            </span>
            <h1 class="text-start text-uppercase">
              Welcome <span class="text-white">back </span>
            </h1>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
          </div>
          <div class="col-md-5 text-end">
            <div class="position-absolute login-img">

               <nuxt-link
              to="/"
            > <img
                src="~/assets/images/login-img.png"
                class="img-fluid"
                alt=""
              />
            </nuxt-link>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5 d-flex align-items-center justify-content-center">
      <div class="login-slot">
        <div class="text-center mb-4">
          <GlobalLogoHref />
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
          <li class="nav-item" role="presentation">
            <nuxt-link
              to="#"
              class="nav-link active"
              id="pills-login-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-login"
              type="button"
              role="tab"
              aria-controls="pills-login"
              aria-selected="true"
            >
              Login
            </nuxt-link>
          </li>
          <li class="nav-item" role="presentation">
            <nuxt-link
              class="nav-link"
              to="#"
              id="pills-signup-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-signup"
              type="button"
              role="tab"
              aria-controls="pills-signup"
              aria-selected="false"
            >
              Sign Up
            </nuxt-link>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div
            class="tab-pane fade active show"
            id="pills-login"
            role="tabpanel"
            aria-labelledby="pills-login-tab"
          >
            <form @submit.prevent="loginPassport">
              <span
                v-if="error && error.errors && error.errors.email"
                class="d-flex justify-content-end"
              >
                <span class="text-danger"> {{ error.errors.email[0] }} </span>
              </span>
              <div
                v-if="vErrors.has('email')"
                class="d-flex justify-content-end"
                :show="true"
              >
                <span class="text-danger">
                  {{ vErrors.first("email") }}
                </span>
              </div>
              <div
                class="input-group mb-4"
                :class="
                  error && error.errors && error.errors.email ? 'error' : ''
                "
              >
                <input
                  type="email"
                  id="LoggingEmailAddress"
                  aria-describedby="emailHelp"
                  class="form-control"
                  required
                  v-model="formData.email"
                  placeholder="Enter Email"
                  data-vv-name="email"
                  v-validate="'required|email'"
                  :state="vErrors.has('email') ? false : null"
                />
                <div class="input-group-text">
                  <div class="text-primary">
                    <fa :icon="['fas', 'user']" fixed-width class="" />
                  </div>
                </div>
              </div>

              <span
                v-if="error && error.errors && error.errors.password"
                class="d-flex justify-content-end"
              >
                <span class="text-danger">
                  {{ error.errors.password[0] }}
                </span>
              </span>
              <div
                v-if="vErrors.has('password')"
                class="d-flex justify-content-end"
                :show="true"
              >
                <span class="text-danger">
                  {{ vErrors.first("password") }}
                </span>
              </div>
              <div
                class="input-group mb-4"
                :class="
                  error && error.errors && error.errors.password ? 'error' : ''
                "
              >
                <input
                  type="password"
                  id="loggingPassword"
                  class="form-control"
                  required
                  v-model="formData.password"
                  placeholder="Enter Password"
                  data-vv-name="password"
                  v-validate="'required|min:8'"
                  :state="vErrors.has('password') ? false : null"
                />
                <div class="input-group-text">
                  <div class="text-primary">
                    <fa :icon="['fas', 'key']" fixed-width class="" />
                  </div>
                </div>
              </div>
              <div
                class="
                  d-flex
                  align-items-center
                  justify-content-between
                  px-2
                  mb-4
                "
              >
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="login" />
                  <label class="form-check-label" for="login">
                    Remember Me</label
                  >
                </div>

                <div class="form-check pl-0">
                  <nuxt-link
                    :to="localePath('/forgot-password')"
                    class="text-xs heebo-light text-decoration-none"
                  >
                    Forget Password?
                  </nuxt-link>
                </div>
              </div>

              <div class="d-grid">
                <button class="btn btn-warning" type="submit">LOGIN</button>
              </div>
            </form>
            <div class="text-center my-3">
              <span>Dont have an account?</span>
              <span @click="openSignupTab">
                <nuxt-link to="#" class="text-decoration-none"
                  >Click Here</nuxt-link
                >
              </span>
            </div>
            <div class="mt-3 text-center"></div>
          </div>

          <div
            class="tab-pane fade"
            id="pills-signup"
            role="tabpanel"
            aria-labelledby="pills-signup-tab"
          >
            <span
              v-if="error && errors && errors.name"
              class="d-flex justify-content-end"
            >
              <span class="text-danger"> {{ errors.name[0] }} </span>
            </span>
            <div
              v-if="vErrors.has('name')"
              class="d-flex justify-content-end"
              :show="true"
            >
              <span class="text-danger">
                {{ vErrors.first("name") }}
              </span>
            </div>
            <div
              class="input-group mb-4"
              :class="error && errors && errors.name ? 'error' : ''"
            >
              <input
                type="text"
                class="form-control"
                placeholder="Enter Name"
                v-model="signUpData.name"
                data-vv-name="name"
                v-validate="'required'"
                :state="vErrors.has('name') ? false : null"
              />
              <div class="input-group-text">
                <div class="text-primary">
                  <fa :icon="['fas', 'user']" fixed-width class="" />
                </div>
              </div>
            </div>
            <span
              v-if="error && error && errors.email"
              class="d-flex justify-content-end"
            >
              <span class="text-danger"> {{ errors.email[0] }} </span>
            </span>
            <div
              v-if="vErrors.has('signup_email')"
              class="d-flex justify-content-end"
              :show="true"
            >
              <span class="text-danger">
                {{ vErrors.first("signup_email") }}
              </span>
            </div>
            <div
              class="input-group mb-4"
              :class="error && errors && errors.email ? 'error' : ''"
            >
              <input
                type="email"
                class="form-control"
                placeholder="Enter email"
                v-model="signUpData.email"
                data-vv-name="signup_email"
                data-vv-as="email"
                v-validate="'email'"
                :state="vErrors.has('email') ? false : null"
              />
              <div class="input-group-text">
                <div class="text-primary">
                  <fa :icon="['fas', 'envelope']" fixed-width class="" />
                </div>
              </div>
            </div>
            <span
              v-if="error && errors && errors.password"
              class="d-flex justify-content-end"
            >
              <span class="text-danger"> {{ errors.password[0] }} </span>
            </span>
            <div
              v-if="vErrors.has('signup_password')"
              class="d-flex justify-content-end"
              :show="true"
            >
              <span class="text-danger">
                {{ vErrors.first("signup_password") }}
              </span>
            </div>
            <div
              class="input-group mb-4"
              :class="error && errors && errors.password ? 'error' : ''"
            >
              <input
                type="password"
                class="form-control"
                placeholder="Enter Password"
                v-model="signUpData.password"
                data-vv-name="signup_password"
                data-vv-as="password"
                v-validate="'required|min:8'"
                ref="password"
                :state="vErrors.has('password') ? false : null"
              />
              <div class="input-group-text">
                <div class="text-primary">
                  <fa :icon="['fas', 'key']" fixed-width class="" />
                </div>
              </div>
            </div>
            <span
              v-if="error && errors && errors.password"
              class="d-flex justify-content-end"
            >
              <span class="text-danger"> {{ errors.password[0] }} </span>
            </span>
            <div
              v-if="vErrors.has('password_confirmation')"
              class="d-flex justify-content-end"
              :show="true"
            >
              <span class="text-danger">
                {{ vErrors.first("password_confirmation") }}
              </span>
            </div>
            <div
              class="input-group mb-4"
              :class="
                error && errors && errors.password_confirmation ? 'error' : ''
              "
            >
              <input
                type="password"
                class="form-control"
                placeholder="Confirm Password"
                v-model="signUpData.password_confirmation"
                data-vv-name="password_confirmation"
                v-validate="'required|confirmed:password'"
                :state="vErrors.has('password_confirmation') ? false : null"
                data-vv-as="password"
              />
              <div class="input-group-text">
                <div class="text-primary">
                  <fa :icon="['fas', 'key']" fixed-width class="" />
                </div>
              </div>
            </div>

            <div
              class="d-flex align-items-center justify-content-start px-2 mb-4"
            >
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="signup" />
                <label class="form-check-label" for="signup">
                  Remember Me</label
                >
              </div>
            </div>

            <div class="d-grid">
              <button class="btn btn-warning" type="button" @click="register">
                SIGN UP
              </button>
            </div>
            <div class="text-center my-3">
              <span>Already have account</span>
              <span @click="openLoginTab">
                <a href="#" class="text-decoration-none">Login</a></span
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "vendor_guest",
    middleware: ['onlyMultiVendorSeller'],
  auth: false,
  data() {
    return {
      signUpData: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      formData: {
        email: "",
        password: "",
        strategy: "vendor",
      },
      loginPasswordType: "password",
      signUpPasswordType: "password",
      signUpConfirmPasswordType: "password",
      error: null,
      errors: "",
    };
  },
  mounted() {},
  methods: {
    async register() {
      this.error = null;
      await this.$vendorService
        .registerVendor(this.signUpData)
        .then(() => {
          this.$toast.success("Your account created successfully!");
          this.openLoginTab();
        })
        .catch((error) => {
          this.error = true;
          this.errors = error.response.data.errors;
        });
    },
    async loginPassport() {
      if (!this.formData.email || !this.formData.password) {
        if (!this.formData.email) {
          this.$toast.error("Email is required");
        }
        if (!this.formData.password) {
          this.$toast.error("password field is required");
        }
      } else {
            await this.logoutOtherAccounts();
        this.error = null;
        await this.$auth
          .loginWith("vendor", { data: this.formData })
          .then(async () => {
            await this.$gates.setRoles(this.$auth.user.roles);
            await this.$gates.setPermissions(this.$auth.user.permissions);
            this.$router.push("/seller/dashboard");
            this.$toast.success("You have been logged in");
          })
          .catch((e) => (this.error = e.response.data));
      }
    },
    openSignupTab() {
      var tab = document.getElementById("pills-login");
      tab.classList.remove("active", "show");
      tab = document.getElementById("pills-signup");
      tab.classList.add("active", "show");
      tab = document.getElementById("pills-signup-tab");
      tab.classList.add("active");
      var tab = document.getElementById("pills-login-tab");
      tab.classList.remove("active");
    },
    openLoginTab() {
      var tab = document.getElementById("pills-login");
      tab.classList.add("active", "show");
      tab = document.getElementById("pills-signup");
      tab.classList.remove("active", "show");
      var tab = document.getElementById("pills-login-tab");
      tab.classList.add("active");
      tab = document.getElementById("pills-signup-tab");
      tab.classList.remove("active");
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
     changeSignUpPasswordType()
    {
        if (this.signUpPasswordType === "password") {
             this.signUpPasswordType = "text"
        }
        else {
             this.signUpPasswordType = "password"
        }
    },
     changeSignUpConfirmPasswordType()
    {
        if (this.signUpConfirmPasswordType === "password") {
             this.signUpConfirmPasswordType = "text"
        }
        else {
             this.signUpConfirmPasswordType = "password"
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
    formData: {
      handler(val, oldVal) {
        if ((this.error = null)) {
          this.error = null;
          this.errors = "";
        }
      },
      deep: true,
    },
    signUpData: {
      handler(val, oldVal) {
        if ((this.error = null)) {
          this.error = null;
          this.errors = "";
        }
      },
      deep: true,
    },
  },
};
</script>
