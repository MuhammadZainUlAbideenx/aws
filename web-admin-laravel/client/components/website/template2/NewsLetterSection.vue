<template>
  <!-- the below setction is skeleton of instagram and Newsletter field -->
  <!-- <section class="news-letter skeletion-effect">
        <div class="news-letter-mail py-5 skeletion-animation text">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 pe-5">
                        <h2 class="skeletion-animation"></h2>
                        <p class="skeletion-animation"></p>
                    </div>
                    <div class="col-sm-6 my-auto">
                        <div class="input-group mail rounded shadow-sm skeletion-animation"></div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
  <section class="news-letter mb-0 d-none">
    <div class="news-letter-mail py-5">
      <div class="col-sm-12 pb-0 mb-30 d-flex align-items-center justify-content-md-start justify-content-between flex-column">
            <h2 class="text-uppercase mb-4 w-100 text-body">{{$t("newsletter.heading")}}</h2>
            <p class="text-body w-100">{{$t("newsletter.subheading")}}</p>
          </div>
          <div class="col-sm-12">
            <div class="input-group mail shadow-none flex-column h-auto flex-nowrap">
              <input
                class="form-control border rounded px-3 w-100"
                placeholder="Enter your email here"
                type="email"
                v-on:keyup.enter="add_email()"
                v-model="formData.email"
              />
              <span
                class="
                  input-group-append
                  position-absolute
                  top-50
                  end-0
                  translate-middle-y
                  me-3
                  cursor-pointer
                "
                v-on:click="add_email()"
              >

              </span>
              <button type="button" v-on:click="add_email()" class="btn btn-primary py-2 px-3 rounded mt-4" >{{$t("newsletter.subscribe_button")}}</button>
            </div>
          </div>
    </div>
  </section>
</template>

<script>
import Button from '../../global/Button.vue';
export default {
  components: { Button },
  data() {
    return {
      formData: {
        email: "",
      },
    };
  },
  methods: {
    async add_email() {
      await this.$webService
        .addNewsletterEmail({ email: this.formData.email })
        .then(async (res) => {
          if (res.success == false) {
            this.$toast.error(
              this.$t("subscription_email_already_exists_message")
            );
          } else {
            this.$toast.success(this.$t("subscription_email_added_message"));
          }
        })
        .catch(async (res) => {
          if (res.response.data.errors) {
            this.error = res.response.data.errors;
            if (this.error.email) {
              this.$toast.error(this.error.email[0]);
            }
          }
        });
    },
  },
};
</script>

<style>
.cursor-pointer {
  cursor: pointer;
}
</style>
