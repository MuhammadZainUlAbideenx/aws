<template>
  <section class="profile-logout-section mt-100">
    <div class="container">
      <div class="row">
        <div class="col-12">

          <div class="profile-logout-wrap d-flex justify-content-between align-items-center bg-primary rounded px-4 py-3 text-white">
            <div class="log-sec d-flex align-items-center position-relative flex-column flex-md-row">

                <dropzone
                :useCustomSlot=true
                  id="drop1"
                  :options="backend_api"
                  @vdropzone-complete="afterComplete"
                >
                <div class="img-wrap "  v-if='profile'>
                <img v-if="profile.profile_image_path" class="dropzone-previews" v-bind:src=" url + `${profile.profile_image_path}`" :placeholder="this.$t('web.customer.profile_image.placeholder')" alt="profile_image">
                <img v-else
                class="dropzone-previews rounded-circle border profile-photo"
                src="~/assets/images/profile.jpg"
                />
              </div>

              </dropzone>


              <div class="profile-detail" v-if='profile'>
                <h4 class="text-uppercase mb-1" >
                  {{  profile.name }}
             </h4>
                <p class="fs-5 m-0"> {{  profile.email }} </p>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-2 gutter-b">
                <div class="p-3 dropzone-area rounded-md h-100">



                </div>
              </div>
            </div>

            <div class="profile-status fs-5 d-flex align-items-center position-relative">
              <fa :icon="['fas', 'sign-out-alt']" class="me-3 fs-1" @click='logout' />
              <span class="opacity-7" @click='logout'>{{$t('logout')}}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Dropzone from "nuxt-dropzone";
import "nuxt-dropzone/dropzone.css";
import { mapGetters,mapActions } from "vuex";

export default {
  data(){
    return{
        url: "/backend",
      brand_image_path:'',
        error:'',
        backend_api: {
          headers: "",
          url: "/backend/api/web/updateProfileImage",
          dictDefaultMessage:
          "Drop Profile Image here",
            uploadMultiple:false,
            parallelUploads:1,
            previewsContainer:'.dropzone-previews'
        },
    };
  },
  fetch(){
    this.backend_api.headers = this.$axios.defaults.headers.common;
  },
  props:['profile'],
  components: {
    Dropzone
  },
  methods:{
    ...mapActions({
        fetchCartItems: 'Web/Cart/fetchCartItems',
        wishlistItemsOnLogout: 'Web/Wishlist/wishlistItemsOnLogout'
    }),
    async afterComplete(file) {
      setTimeout(
        function () {
          this.removeFile(file);
        }.bind(this),
        3000
      );
      if (file.status == "error") {
        var res = JSON.parse(file.xhr.response);
        this.$toast.error(res.message);
        if (res.errors) {
          for (const [key, value] of Object.entries(res.errors)) {
            this.$toast.error(value);
          }
        }
      } else {
        var res = JSON.parse(file.xhr.response);
        this.profile.profile_image_path = res.data.profile_image_path
        await this.$auth.fetchUser()
        this.$toast.success(res.message);
      }
    },
    removeFile: function (file) {
      file.previewElement.remove();
    },
    async logout() {
      this.error = null;
      await this.$auth
        .logout("customer")
        .then(async () => {
            await this.$gates.setRoles([])
            await this.$gates.setPermissions([])
            this.$toast.success('You are logged out now')
            this.$router.replace('/login')
            await this.fetchCartItems()
            this.wishlistItemsOnLogout()
        })
        .catch((e) => (this.error = e.response.data));
    },
  }
}
</script>

<style scoped>
.dropzone{
  background:none !important;
  padding:0px;
}
.vue-dropzone{
  border: 0px !important;
}
</style>
