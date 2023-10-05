<template>

  <div class=".container-fluid">
      <div class="row h-100 m-0 login-page">
    <div class="col-md-7 px-0">
      <div class="login-wrapper px-4">
        <div class="row h-100 mx-0 text-white position-relative">
          <div
            class="pt-5 pt-md-0
              col-md-7
              d-flex
              flex-column
              justify-content-md-center
              align-items-start
            "
          >
            <span class="top-level text-uppercase">
              Ecommerce Multi Vendor
            </span>
            <h1 class="text-start text-uppercase">
              Welcome <span class="text-white">back </span>
            </h1>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>

          </div>
          <div class="col-md-5 text-end">
            <div class="position-absolute login-img">
              <img src="~/assets/images/login-img.png" class="img-fluid" alt="" />
            </div>
            </div>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="login-slot">
        <div class="text-center mb-5">
          <img src="~/assets/images/nictus-logo.png" alt="" />
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
            <nuxt-link to="#"
              class=" nav-link active"
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
          </li>
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
          <form @submit.prevent="resetPassword">
            <div class="input-group mb-4">
              <input
                type="email" id="LoggingEmailAddress"
                class="form-control" required v-model="formData.email"
                placeholder="Enter Email"
              />
              <div class="input-group-text">
                <div class="text-primary">
                  <fa :icon="['fas', 'at']" fixed-width class="" />
                </div>
              </div>
            </div>
            <span v-if="error && error.email" class="text-xs text-red-600">
              {{ error.email[0] }}
            </span>
            <div class="input-group mb-4">
              <input
                type="password" id="LoggingEmailAddress"
                class="form-control" required v-model="formData.password"
                placeholder="Enter Password"
              />
              <div class="input-group-text">
                <div class="text-primary">
                  <fa :icon="['fas', 'at']" fixed-width class="" />
                </div>
              </div>
            </div>
            <span v-if="error && error.password" class="text-xs text-red-600">
              {{ error.password[0] }}
            </span>
            <div class="input-group mb-4">
              <input
                type="password" id="LoggingEmailAddress"
                class="form-control" required v-model="formData.password_confirmation"
                placeholder="Re Enter Password"
              />
              <div class="input-group-text">
                <div class="text-primary">
                  <fa :icon="['fas', 'at']" fixed-width class="" />
                </div>
              </div>
            </div>


            <span v-if="error && error.password_confirmation" class="text-xs text-red-600">
              {{ error.password_confirmation[0] }}
            </span>
            <div class="d-grid">
              <button class="btn btn-warning" type="submit">Update Password</button>
            </div>
            </form>
            <p class="mt-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                ut labore et dolore.
            </p>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: 'default_guest',
  auth: 'guest',
  data() {
    return {
      formData: {
        token: this.$route.query.token,
        email: '',
        password: '',
        password_confirmation: '',
      },
      error: null,
    }
  },
  methods: {
    async resetPassword() {
      this.error = null
      await this.$webService.resetPassword(this.formData)
        .then((res) => {
          if(res.success){
            this.$toast.success(res.message)
            this.$router.push('/login')
          }
          else{
            this.$toast.error(res.message)
          }
        })
        .catch((e) => {
          this.error = e.response.data.errors ?? e.response.data
          this.$toast.error(e.response.data.message)
        })
    },
  },
}
</script>
