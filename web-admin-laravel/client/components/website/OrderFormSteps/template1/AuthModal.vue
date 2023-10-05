<template>

<div class="modal fade log-in-modal" id="DeleteItem23" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content rounded">
      <div class="modal-body text-center px-5">
        <h3 class="text-uppercase fw-bold fs-4 mb-4">{{ this.$t("login_to_your_account") }}</h3>
        <form>
          <span
            v-if="error && error.errors && error.errors.email"
                class="float-end"
          >
            <span class="text-danger"> {{ error.errors.email[0] }} </span>
          </span>
          <div  class="input-group mb-3"
                :class="
                  error && error.errors && error.errors.email ? 'error' : ''
                " >
            <input type="email" class="form-control shadow border-2" id="exampleInputEmail1"
                   required
                  v-model="formData.email"
                  :placeholder="this.$t('form.login.user_name.placeholder')"
            >
            <div class="input-group-text">
              <div class="text-primary">
                <fa :icon="['fas', 'user']" fixed-width class="" />
              </div>
            </div>
          </div>
              <span
                v-if="error && error.errors && error.errors.password"
                class="float-end"
              >
                <span class="text-danger">
                  {{ error.errors.password[0] }}
                </span>
              </span>
          <div class="input-group mb-4"
                :class="
                  error && error.errors && error.errors.password ? 'error' : ''
                ">
            <input type="password" class="form-control shadow border-2" id="exampleInputPassword1" required
                  v-model="formData.password"
                  :placeholder="this.$t('form.login.password.placeholder')">
                  <div class="input-group-text">
              <div class="text-primary">
                <fa :icon="['fas', 'unlock']" fixed-width class="" />
              </div>
            </div>
          </div>
          <div class="btn-wrap d-md-flex justify-content-between align-items-center flex-column">
            <button  type="button" class="btn bg-warning rounded py-2 px-5 fw-bold text-uppercase mb-md-0 mb-3" data-bs-dismiss="modal" @click="loginPassport" >
              {{this.$t('login.login')}}
            </button>
            <div class="cont-guest mt-3">
               {{this.$t('if_you_do_not_want_login')}}
              <button  type="button" class="p-0 m-0 ms-1 bg-transparent shadow-0 border-0 text-primary text-uppercase" data-bs-dismiss="modal" @click='continueAsGuest'>
               {{this.$t('continue_as_guest')}}
              </button>
            </div>
          </div>
        </form>
    </div>
  </div>
  </div>

  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  layout: "default_guest",
  auth: false,
  data() {
      return {
      signUpData: {
        first_name: '',
        email: '',
        password: '',
        password_confirmation:'',
      },
      formData: {
        email: "",
        password: "",
        strategy: "customer",
      },
      error: null,
      errors:'',
    };
  },
 methods: {

    ...mapActions({
      fetchWishlistItems: "Web/Wishlist/fetchWishlistItems",
      fetchCartItems: 'Web/Cart/fetchCartItems',
    }),
    async loginPassport() {
      if (!this.formData.email || !this.formData.password) {
        if (!this.formData.email) {
          this.$toast.error(this.$t("email_is_required"));
        }
        if (!this.formData.password) {
          this.$toast.error(this.$t("password_field_is_required"));
        }
      } else {
        this.error = null;
        await this.$auth
          .loginWith("customer", { data: this.formData })
          .then(async () => {
            await this.$gates.setRoles(this.$auth.user.roles);
            await this.$gates.setPermissions(this.$auth.user.permissions);
            await this.fetchCartItems();
            this.$router.replace(this.localePath('/ProductOrder'));
            this.$toast.success(this.$t("you_have_been_logged_in"));
          })
          .catch((e) => (this.error = e.response.data));
      }
    },

   continueAsGuest(){
       this.$router.replace(this.localePath('/ProductOrder'))
   }
 }
}
</script>

<style>

</style>
