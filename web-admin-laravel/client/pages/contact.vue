<template>
  <section v-if="$fetchState.pending" class="contact-us mt-0">
     <WebsiteGlobalComponentsBreadCrumb :page="`contact`"/>
     <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}Contact`" />
  </section>

  <section v-else class="contact-us mt-0">
     <WebsiteGlobalComponentsBreadCrumb :page="`contact`"/>
    <div class="container ">
      <div class="row">
        <div class="col-12 mt-5 mt-100">
          <h2 class="section-heading mt-0 mb-30">
            {{ this.$t("web.contact.get_in_touch.text1")
            }}<span>{{ this.$t("web.contact.get_in_touch.text2") }}</span>
          </h2>
          <p class="section-subheading mb-50">
            {{ this.$t("web.contact.heading.description") }}
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-12 contact-temp2 mb-50">
          <div class="contact-form shadow-none mt-0 p-md-0 border-0">
              <div class="row p-md-0 pt-0">
                <div class="col-md-6 pe-lg-5">
                    <h2 class="pb-4 fs-4 text-start text-custom fw-bold pd-0 mb-30">
                        {{ this.$t("web.contact.send_us.text1")
                        }}<span>{{ this.$t("web.contact.send_us.text2") }}</span>
                    </h2>
                    <p class="section-subheading text-start mb-4 d-none">
                        {{ this.$t("web.contact.send_us.subheading") }}
                    </p>
                  <div class="row g-3">
                    <div class="col-md-6 col-lg-6 mt-0 mb-30">
                      <label for="name" class="form-label">{{ this.$t("web.contact.your_name") }}</label>
                      <input type="text" class="form-control px-3 py-0" id="name"
                      v-model="formData.name" :placeholder="this.$t('web.contact.your_name')" />
                        <span class="float-end text-danger"
                            v-if="error && error.name">
                          {{ error.name[0] }}
                        </span>
                    </div>
                    <div class="col-md-6 mt-0 mb-30">
                      <label for="inputEmail4" class="form-label"
                        >{{ this.$t("web.contact.your_email") }}</label
                      >
                      <input
                        type="email"
                        class="form-control px-3 py-0"
                        v-model="formData.email" :placeholder="this.$t('web.contact.your_email')"
                      />
                      <span class="float-end text-danger"
                            v-if="error && error.email">
                          {{ error.email[0] }}
                        </span>
                    </div>
                    <div class="col-12 mt-0 mb-30">
                      <label for="inputAddress" class="form-label"
                        >{{ this.$t("web.contact.subject") }}</label
                      >
                      <input
                        type="text"
                        class="form-control px-3 py-0"
                        v-model="formData.subject" :placeholder="this.$t('web.contact.subject')"
                      />
                       <span class="float-end text-danger"
                            v-if="error && error.subject">
                          {{ error.subject[0] }}
                        </span>
                    </div>
                    <div class="col-12 mt-0 mb-30">
                      <label
                        for="exampleFormControlTextarea1"
                        class="form-label"
                        >{{ this.$t("web.contact.your_message") }}</label
                      >
                      <textarea
                        class="form-control px-3 py-2"
                        v-model="formData.message"
                        rows="3" :placeholder="this.$t('web.contact.your_message')"
                      ></textarea>
                       <span class="float-end text-danger"
                            v-if="error && error.message">
                          {{ error.message[0] }}
                        </span>
                    </div>

                    <div class="col-12 mt-0">
                      <button type="submit" class="btn btn-primary px-4 py-2" @click="send_form_data()">
                       {{ this.$t("web.contact.send_message") }}
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="shadow-lg" style="width: 100%; height:100%">
                      <iframe v-if="allDefaultSettings.general_settings.contact_map" width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" :src="allDefaultSettings.general_settings.contact_map"></iframe>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </div>

      <div class="row review-cards mt-5 mt-50">
        <div class="col-md-4 mb-4 mb-md-0">
          <div class="text-center rounded shadow card-wrap categories p-md-4 p-lg-5">
            <div class="card-icon text-primary mb-4">
              <fa :icon="['fas', 'map-marker-alt']" class="fs-1 me-4" />
            </div>
            <div class="card-content">
              <h6 class="fw-bold mb-1">{{this.allDefaultSettings.general_settings.contact_address}}</h6>
              <p class="fs-7 mb-0">{{ this.$t("web.contact.address.description") }}</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-4 mb-md-0">
          <div class="text-center rounded shadow card-wrap categories p-md-4 p-lg-5">
            <div class="card-icon text-primary mb-4">
              <fa :icon="['fas', 'phone']" class="fs-1 me-4" />
            </div>
            <div class="card-content">
              <h6 class="fw-bold mb-1">{{ this.allDefaultSettings.general_settings.contact_number }}</h6>
              <p class="fs-7 mb-0">{{ this.$t("web.contact.number.description") }}</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4 mb-md-0">
          <div class="text-center rounded shadow card-wrap categories p-md-4 p-lg-5">
            <div class="card-icon text-primary mb-4">
              <fa :icon="['fas', 'envelope']" class="fs-1 me-4" />
            </div>
            <div class="card-content">
              <h6 class="fw-bold mb-1">{{ this.allDefaultSettings.general_settings.contact_email }}</h6>
              <p class="fs-7 mb-0">{{ this.$t("web.contact.email.description") }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
     <WebsiteTemplate1NewsLetterSection />
  </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
      data() {
    return {
          currentlyActiveTemplate: "",
      error:'',
      formData: {
        name: "",
        email: "",
        subject: "",
        message: "",
      },
    };
  },
   created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
  },
  methods: {
    async send_form_data() {
      await this.$webService
        .submitContactForm({ name: this.formData.name,email: this.formData.email,subject: this.formData.subject,message: this.formData.message })
        .then(async (res) => {
          if (res.success == true) {
            this.formData.name = ""
            this.formData.email = ""
            this.formData.subject = ""
            this.formData.message = ""
            this.$toast.success(
              this.$t("thanks_you_request_is_submitted_successfully")
            );
          }
        })
        .catch(async (res) => {
          if (res.response.data.errors) {
            this.error = res.response.data.errors;
            this.$toast.error(res.response.data.message);
          }
        });
    },
  },
      fetch() {},
  auth:false,
  computed: mapGetters({
    allDefaultSettings: 'allDefaultSettings',
    allSettings: 'allDefaultSettings'
  }),
  watch: {
  formData: {
     handler(val){
        this.error = ''
    },
     deep: true
  }
}
};
</script>

<style>
</style>
