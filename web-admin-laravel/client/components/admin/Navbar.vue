<template>
  <div
    id="tc_header"
    class="header header-on animate__animated animate__fadeInDown"
  >
    <!--begin::Container-->
    <div class="container-fluid py-lg-3 py-0 px-0 m-0">
      <!--begin::Topbar-->
      <div class="topbar row p-0 m-0">
        <div class="col-md-6 px-4">
          <div class="d-flex align-items-center">
            <!--begin::Toggle-->
            <div
              class="toggle-btn"
              id="tc_aside_toggle"
              @click="sidebarCollapse"
            >
              <div v-bind:class="{ active: isActive }">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-list"
                  viewBox="0 0 16 16"
                >
                  <path
                    fill-rule="evenodd"
                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"
                  />
                </svg>
              </div>
            </div>

            <!--end::Header Menu Wrapper-->
            <div class="topbar-item w-100 position-relative">
              <div
                class="
                  quick-search quick-search-inline
                  ml-20
                  mr-1
                  w-100
                  rounded
                "
                id="kt_quick_search_inline"
              >
                <!--begin::Form-->
                <form method="get" class="quick-search-form">
                  <div class="form-group has-search">
                    <button
                      class="
                        btn
                        border-0
                        bg-gradient-secondary
                        form-control-feedback
                        top-0
                        end-0
                        text-white
                        rounded
                        btn
                      "
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-search"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"
                        />
                      </svg>
                    </button>
                    <input
                      type="text"
                      class="form-control"
                      :placeholder="this.$t('navbar.Search')"
                    />
                  </div>
                </form>
                <!--end::Form-->
                <!--begin::Search Toggle-->
                <div
                  id="kt_quick_search_toggle"
                  data-toggle="dropdown"
                  data-offset="0px,1px"
                ></div>
                <!--end::Search Toggle-->
                <!--begin::Dropdown-->
                <div
                  class="
                    dropdown-menu
                    dropdown-menu-left
                    dropdown-menu-lg
                    dropdown-menu-anim-up
                  "
                >
                  <div
                    class="quick-search-wrapper scroll ps"
                    data-scroll="true"
                    data-height="350"
                    data-mobile-height="200"
                    style="height: 350px; overflow: hidden"
                  >
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px">
                      <div
                        class="ps__thumb-x"
                        tabindex="0"
                        style="left: 0px; width: 0px"
                      ></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; right: 0px">
                      <div
                        class="ps__thumb-y"
                        tabindex="0"
                        style="top: 0px; height: 0px"
                      ></div>
                    </div>
                  </div>
                </div>
                <!--end::Dropdown-->
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 d-flex justify-content-end p-0 m-0">
          <div
            class="
              d-flex
              align-items-center
              justify-content-end
              h-48
              profile-bar
              px-1
            "
          >
            <!--begin::Languages-->

            <div class="dropdown me-3">
              <div
                class="topbar-item dropdown-toggle"
                id="dropdownMenu1"
                data-toggle="dropdown"
                data-display="static"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <div class="btn btn-icon btn-clean btn-dropdown btn-lg">
                  <img
                    class="h-20px w-20px rounded-sm"
                    :src="`/backend/api/flags/png100px/${currentLocale.code}.png`"
                    alt=""
                  />
                </div>
              </div>

              <div
                class="dropdown-menu dropdown-menu-right shadow"
                aria-labelledby="dropdownMenu1"
              >
                <button
                  class="dropdown-item"
                  v-for="locale in availableLocales"
                  :key="locale.code"
                  @click="changeLocale(locale.code)"
                >
                  <span class="symbol symbol-20 me-3">
                    <img
                      class="h-20px w-20px rounded-sm"
                      :src="`/backend/api/flags/png100px/${locale.code}.png`"
                      alt=""
                    />
                  </span>
                  {{ locale.name }}
                </button>
              </div>
            </div>
            <!--end::Languages-->

            <!--begin::Quick Actions-->
            <div class="">
              <div class="topbar-item">
                <div
                  id="kt_open_fullscreen"
                  v-on:click="isHidden = true"
                  v-if="!isHidden"
                  class="btn btn-icon btn-clean btn-dropdown mr-1"
                  @click="openFullscreen"
                >
                  <span class="svg-icon svg-icon-xl svg-icon-primary">
                    <svg
                      width="20px"
                      height="20px"
                      viewBox="0 0 16 16"
                      class="bi bi-fullscreen"
                      fill="currentColor"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M1.5 1a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4A1.5 1.5 0 0 1 1.5 0h4a.5.5 0 0 1 0 1h-4zM10 .5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 16 1.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5zM.5 10a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 0 14.5v-4a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v4a1.5 1.5 0 0 1-1.5 1.5h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5z"
                      />
                    </svg>
                  </span>
                </div>

                <div
                  id="kt_close_fullscreen"
                  v-if="isHidden"
                  v-on:click="isHidden = false"
                  class="btn btn-icon btn-clean btn-dropdown mr-1"
                  @click="closeFullscreen"
                >
                  <span class="svg-icon svg-icon-xl svg-icon-primary">
                    <svg
                      width="20px"
                      height="20px"
                      viewBox="0 0 16 16"
                      class="bi bi-fullscreen-exit"
                      fill="currentColor"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.5 0a.5.5 0 0 1 .5.5v4A1.5 1.5 0 0 1 4.5 6h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5zm5 0a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 10 4.5v-4a.5.5 0 0 1 .5-.5zM0 10.5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 6 11.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5zm10 1a1.5 1.5 0 0 1 1.5-1.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4z"
                      />
                    </svg>
                  </span>
                </div>
              </div>
            </div>
            <!--end::Quick Actions-->

            <!--begin::Quick panel-->
            <div class="dropdown">
              <div class="topbar-item">
                <div
                  class="btn btn-icon btn-clean mr-1"
                  id="tc_quick_panel_toggle"
                >
                  <span class="svg-icon svg-icon-xl svg-icon-primary">
                    <svg
                      width="20px"
                      height="20px"
                      viewBox="0 0 16 16"
                      class="bi bi-people"
                      fill="currentColor"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"
                      />
                    </svg>
                  </span>
                  <span class="badge badge-pill badge-secondary">5</span>
                </div>
              </div>
            </div>
            <!--end::Quick panel-->

            <!--begin::Notifications-->
            <div class="dropdown me-2 notifications">
              <div
                class="topbar-item"
                id="dropdownMenu4"
                data-toggle="dropdown"
                data-display="static"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <div class="btn btn-icon btn-clean btn-dropdown mr-1">
                  <span class="svg-icon svg-icon-xl svg-icon-primary">
                    <svg
                      width="20px"
                      height="20px"
                      viewBox="0 0 16 16"
                      class="bi bi-bell"
                      fill="currentColor"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z" />
                      <path
                        fill-rule="evenodd"
                        d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"
                      />
                    </svg>
                    <div class="lds-ripple">
                      <div></div>
                      <div></div>
                    </div>
                  </span>
                  <span class="badge badge-pill badge-primary">5</span>
                </div>
              </div>

              <div
                class="dropdown-menu p-0 m-0 dropdown-menu shadow"
                aria-labelledby="dropdownMenu4"
                style="width: max-content"
              >
                <form>
                  <div class="d-flex flex-column p-3 border-bottom rounded-top">
                    <h4
                      class="
                        d-flex
                        justify-content-between
                        align-items-center
                        mb-0
                        rounded-top
                      "
                    >
                      <span class="font-size-h5">{{
                        this.$t("navbar.Notifications")
                      }}</span>
                      <nuxt-link
                        to=""
                        class="btn btn-sm btn-primary-hover py-1 px-2"
                      >
                        {{ this.$t("navbar.Clear") }}
                      </nuxt-link>
                    </h4>
                  </div>

                  <div class="nav nav-hover scrollbar-1">
                    <nuxt-link to="" class="nav-item border-bottom">
                      <div class="nav-link">
                        <div class="nav-icon mr-3">
                          <i data-feather="settings"></i>
                        </div>
                        <div class="nav-text">
                          <div class="font-weight-bold">
                            {{ this.$t("navbar.Report") }}
                          </div>
                          <div class="text-muted">
                            {{ this.$t("navbar.Time") }}
                          </div>
                        </div>
                      </div>
                    </nuxt-link>
                    <nuxt-link to="" class="nav-item border-bottom">
                      <div class="nav-link">
                        <div class="nav-icon mr-3">
                          <i data-feather="archive"></i>
                        </div>
                        <div class="nav-text">
                          <div class="font-weight-bold">
                            {{ this.$t("navbar.Report") }}
                          </div>
                          <div class="text-muted">
                            {{ this.$t("navbar.Time") }}
                          </div>
                        </div>
                      </div>
                    </nuxt-link>
                    <nuxt-link to="" class="nav-item border-bottom">
                      <div class="nav-link">
                        <div class="nav-icon mr-3">
                          <i data-feather="send"></i>
                        </div>
                        <div class="nav-text">
                          <div class="font-weight-bold">
                            {{ this.$t("navbar.Report") }}
                          </div>
                          <div class="text-muted">
                            {{ this.$t("navbar.Time") }}
                          </div>
                        </div>
                      </div>
                    </nuxt-link>
                    <nuxt-link to="" class="nav-item border-bottom">
                      <div class="nav-link">
                        <div class="nav-icon mr-3">
                          <i data-feather="send"></i>
                        </div>
                        <div class="nav-text">
                          <div class="font-weight-bold">
                            {{ this.$t("navbar.Report") }}
                          </div>
                          <div class="text-muted">
                            {{ this.$t("navbar.Time") }}
                          </div>
                        </div>
                      </div>
                    </nuxt-link>
                    <nuxt-link to="" class="nav-item border-bottom">
                      <div class="nav-link">
                        <div class="nav-icon mr-3">
                          <i data-feather="send"></i>
                        </div>
                        <div class="nav-text">
                          <div class="font-weight-bold">
                            {{ this.$t("navbar.Report") }}
                          </div>
                          <div class="text-muted">
                            {{ this.$t("navbar.Time") }}
                          </div>
                        </div>
                      </div>
                    </nuxt-link>
                    <nuxt-link to="" class="nav-item border-bottom">
                      <div class="nav-link">
                        <div class="nav-icon mr-3">
                          <i data-feather="send"></i>
                        </div>
                        <div class="nav-text">
                          <div class="font-weight-bold">
                            {{ this.$t("navbar.Report") }}
                          </div>
                          <div class="text-muted">
                            {{ this.$t("navbar.Time") }}
                          </div>
                        </div>
                      </div>
                    </nuxt-link>
                    <nuxt-link to="" class="nav-item border-bottom">
                      <div class="nav-link">
                        <div class="nav-icon mr-3">
                          <i data-feather="send"></i>
                        </div>
                        <div class="nav-text">
                          <div class="font-weight-bold">
                            {{ this.$t("navbar.Report") }}
                          </div>
                          <div class="text-muted">
                            {{ this.$t("navbar.Time") }}
                          </div>
                        </div>
                      </div>
                    </nuxt-link>
                    <nuxt-link to="" class="nav-item border-bottom">
                      <div class="nav-link">
                        <div class="nav-icon mr-3">
                          <i data-feather="send"></i>
                        </div>
                        <div class="nav-text">
                          <div class="font-weight-bold">
                            {{ this.$t("navbar.Report") }}
                          </div>
                          <div class="text-muted">
                            {{ this.$t("navbar.Time") }}
                          </div>
                        </div>
                      </div>
                    </nuxt-link>
                    <nuxt-link to="" class="nav-item border-bottom">
                      <div class="nav-link">
                        <div class="nav-icon mr-3">
                          <i data-feather="hexagon"></i>
                        </div>
                        <div class="nav-text">
                          <div class="font-weight-bold">
                            {{ this.$t("navbar.Report") }}
                          </div>
                          <div class="text-muted">
                            {{ this.$t("navbar.Time") }}
                          </div>
                        </div>
                      </div>
                    </nuxt-link>
                  </div>
                  <div class="d-flex flex-column p-3 rounded-top">
                    <h4 class="d-flex justify-content-center mb-0 rounded-top">
                      <a href="#" class="font-size-base text-primary">
                        {{ this.$t("navbar.View") }}
                      </a>
                    </h4>
                  </div>
                </form>
              </div>
            </div>
            <!--end::Notifications-->

            <!--begin::user-->
            <div class="dropdown h-100">
              <div
                class="topbar-item"
                id="dropdownMenu4"
                data-toggle="dropdown"
                data-display="static"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                data-offset="0px,1px"
              >
                <div
                  class="
                    btn-icon
                    w-auto
                    btn-clean
                    d-flex
                    align-items-center
                    mx-0 mx-lg-4
                  "
                >
                  <span
                    v-if="$auth.loggedIn"
                    class="
                      font-size-base
                      d-none d-md-inline
                      me-2
                      text-capitalize
                    "
                  >
                    <!-- AngilinaDeo -->
                    {{ $auth.user.name }}
                  </span>
                  <span
                    class="
                      symbol symbol-35 symbol-light-success
                      profile-icon
                      rounded-circle
                      mx-md-1 mx-3
                    "
                  >
                    <span class="symbol-label font-size-h5">
                      <img v-if="$auth.user.profile_image_path"    class="rounded-circle"
                        alt=""
                        width="30px"
                        height="30px" v-bind:src=" url + `${$auth.user.profile_image_path}`" alt="profile_image">
                      <img v-else
                      class="rounded-circle"
                      alt=""
                      width="30px"
                      height="30px"
                        src="~/assets/images/profile.jpg"
                      />
                    </span>
                  </span>
                </div>
              </div>

              <div
                class="dropdown-menu dropdown-menu-right shadow"
                aria-labelledby="dropdownMenu1"
                style="min-width: 150px"
              >
                <nuxt-link to="/admin/profile" class="dropdown-item">
                  <span class="svg-icon svg-icon-xl svg-icon-primary mr-2">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="20px"
                      height="20px"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      class="feather feather-user"
                    >
                      <path
                        d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
                      ></path>
                      <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                  </span>
                  {{$t('form.admin.profile.edit')}}
                </nuxt-link>

                <button @click="logout" class="dropdown-item">
                  <span class="svg-icon svg-icon-xl svg-icon-primary mr-2">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="20px"
                      height="20px"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      class="feather feather-power"
                    >
                      <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                      <line x1="12" y1="2" x2="12" y2="12"></line>
                    </svg>
                  </span>
                  {{$t('logout')}}
                </button>
              </div>
            </div>
            <!--end::user-->
          </div>
        </div>
      </div>
      <!--end::Topbar-->
    </div>

    <!--end::Container-->
  </div>
</template>

<script>
import { mapGetters } from "vuex";
// import LocaleDropdown from './LocaleDropdown'
export default {
  components: {
    // LocaleDropdown
  },
  created() {},
  data() {
    return {
      url:"/backend",
      error: false,
      isActive: false,
      isHidden: false,
      opened: false,
    };
  },
  methods: {
    menuToggle() {},
    async changeLocale(locale) {
      const check = this.$i18n.locales.find((i) => i.code == locale);
      if (check) {
        await this.$i18n.setLocale(locale);
        var language = this.allLanguages.find((i) => i.code == locale);
        this.$emit("change_direction", language.direction);
        this.$router.go();
      }
    },
    async logout() {
      this.error = null;
      await this.$auth
        .logout("admin")
        .then(async () => {
          await this.$gates.setRoles([]);
          await this.$gates.setPermissions([]);
          this.$toast.success(this.$t("you_are_logged_out_now"));
          this.$router.replace("/admin/login");
        })
        .catch((e) => (this.error = e.response.data));
    },
    sidebarCollapse() {
      this.opened = !this.opened;
      this.isActive = !this.isActive;
      const body = document.querySelector("body");
      body.classList.toggle("aside-minimize");
    },
    openFullscreen() {
      var elem = document.documentElement;
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.mozRequestFullScreen) {
        /* Firefox */
        elem.mozRequestFullScreen();
      } else if (elem.webkitRequestFullscreen) {
        /* Chrome, Safari and Opera */
        elem.webkitRequestFullscreen();
      } else if (elem.msRequestFullscreen) {
        /* IE/Edge */
        elem.msRequestFullscreen();
      }
    },
    closeFullscreen() {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.mozCancelFullScreen) {
        /* Firefox */
        document.mozCancelFullScreen();
      } else if (document.webkitExitFullscreen) {
        /* Chrome, Safari and Opera */
        document.webkitExitFullscreen();
      } else if (document.msExitFullscreen) {
        /* IE/Edge */
        document.msExitFullscreen();
      }
    },
  },
  computed: {
    ...mapGetters({
      allLanguages: "Web/General/allLanguages",
    }),
    availableLocales() {
      return this.allLanguages.filter((i) => i.code !== this.$i18n.locale);
    },
    currentLocale() {
      return this.allLanguages.find((i) => i.code == this.$i18n.locale);
    },
  },
};
</script>

<style>
</style>
