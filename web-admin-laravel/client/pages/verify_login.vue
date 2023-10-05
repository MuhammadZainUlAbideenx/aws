<template>
  <div class="text-center mb-4">
    <div v-if="loading">
      <AdminLoader />
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
      loading: true,
      google_access_token: "",
      facebook_access_token: "",
      socialData: {
        name: "",
        first_name: "",
        last_name: "",
        email: "",
        google_id: null,
        facebook_id: null,
        social_type: "",
        picture: "",
      },
    };
  },
  created() {
    if (process.client) {
      var social_login_type = localStorage.getItem("social_login_type");
      if (social_login_type) {
          this.socialData.social_type = social_login_type;
      }
    }
  },
  async fetch(){
       if (this.socialData.social_type == "google") {
      var first_string = this.$route.fullPath.split("&access_token=");
      var again_first_string_split = first_string[1].split("&token_type=");
      var access_token = again_first_string_split[0];
      this.google_access_token = access_token;
      await this.googleAuthDetails();
    }
    if (this.socialData.social_type == "facebook") {
      var first_string = this.$route.fullPath.split("#access_token=");
      var again_first_string_split = first_string[1].split(
        "&data_access_expiration_time="
      );
      var access_token = again_first_string_split[0];
      this.facebook_access_token = access_token;
      await this.facebookAuthDetails();
    }
  },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
  methods: {
    ...mapActions({
      fetchWishlistItems: "Web/Wishlist/fetchWishlistItems",
      fetchCartItems: "Web/Cart/fetchCartItems",
    }),
    async customerSocialLogin() {
      await this.$auth
        .loginWith("customerSocialLogin", { data: this.socialData })
        .then(async () => {
          await this.$gates.setRoles(this.$auth.user.roles);
          await this.$gates.setPermissions(this.$auth.user.permissions);
          await this.fetchCartItems();
          this.$router.replace("/");
          this.$toast.success("You have been logged in");
        })
        .catch((e) => (this.error = e.response.data));
    },
    async googleAuthDetails() {
      const data = await this.$webService.googleAuthDetails({
        token: this.google_access_token,
      });
      if (data) {
        this.socialData.name = data.data.name;
        this.socialData.first_name = data.data.given_name;
        this.socialData.last_name = data.data.family_name;
        this.socialData.email = data.data.email;
        this.socialData.google_id = data.data.sub;
        this.socialData.facebook_id = null;
        this.socialData.picture = data.data.picture;
        await this.customerSocialLogin();
      }
    },
    async facebookAuthDetails() {
      const data = await this.$webService.facebookAuthDetails({
        token: this.facebook_access_token,
      });
      if (data) {
        this.socialData.name = data.data.name;
        this.socialData.first_name = data.data.first_name;
        this.socialData.last_name = data.data.last_name;
        this.socialData.email = data.data.email;
        this.socialData.google_id = null;
        this.socialData.facebook_id = data.data.id;
        this.socialData.picture = data.data.picture.data.url;
        await this.customerSocialLogin();
      }
    },
  },
};
</script>
