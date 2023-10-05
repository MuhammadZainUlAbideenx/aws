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
  <section class="news-letter m-0 news-temp2">
    <div class="news-letter-mail py-5 mt-5">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 pe-5">
            <h2 class="text-uppercase">{{ this.$t("web.home.news.newsletter.heading") }}</h2>
            <p>{{ this.$t("web.home.news.newsletter.description") }}</p>
          </div>
          <div class="col-sm-6 my-auto">
            <div class="input-group mail shadow-sm">
              <input
                class="form-control border rounded px-3"
                :placeholder="$t('enter_email')"
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
                <fa :icon="['fa', 'paper-plane']" />
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
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
            this.formData.email = ""
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
