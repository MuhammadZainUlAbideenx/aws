<template>
  <section v-if="$fetchState.pending" class="blog-page mt-0">
    <WebsiteGlobalComponentsBreadCrumb :page="about" />
    <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}AboutUsPage`" />
  </section>
  <section v-else class="about-us mt-0 mb-4">
    <WebsiteGlobalComponentsBreadCrumb :page="`about`" />
    <!-- <img class="w-100 img-fluid" src="~/assets/images/about-us2.jpg" alt="..." /> -->
    <div class="container">
      <div class="row d-flex justify-content-center mt-100 mb-100">
<div class="col-lg-2 col-md-2 "></div>

            <div class="col-lg-8 col-md-8 col-sm-12 ">
            <div v-html="about" class="text-justify">
            </div>
          </div>
          <div class="col-lg-2 col-md-2"></div>
          </div>

      </div>
    <!-- <div class="container">
      <div class="row my-5 justify-content-center mt-100 mb-100">
        <div class="col-12">
          <h2 class="section-heading mb-4 text-start mt-0 mb-30">{{this.$t("web.about_us.title.first")}}<span>{{this.$t('web.about_us.title.second')}}</span></h2>
          <h3 class="mb-4 mb-30">{{this.$t('web.about_us.sub_heading')}}</h3>
          <p class="text-start mb-0">
                {{this.$t("web.about_us.description")}}
              </p>
        </div>
      </div>
    </div>
    <div class="w-100 bg-secondary py-5">
        <div class="container mt-50 mb-50">
            <div class="row">
                <div class="col-md-6 pe-5">
                <div class="d-flex flex-column justify-content-center h-100">
                    <h3 class="section-heading text-start fs-5 mb-3 mt-0 mb-30">{{this.$t("web.about_us.our_history.title.first")}}<span>{{this.$t("web.about_us.our_history.title.second")}}</span></h3>
                    <h2 class="fw-bold mb-30">{{this.$t("web.about_us.our_history.sub_heading.first")}}<br /> {{this.$t("web.about_us.our_history.sub_heading.second")}} </h2>
                    <p class="my-4 fs-6 mt-0 mb-30">
                        {{this.$t("web.about_us.our_history.description")}}
                    </p>

                    <nuxt-link to="#" class="text-primary"
                    >{{this.$t("web.about_us.view_more")}}<fa icon="arrow-right" class="ms-2" fixed-width
                    /></nuxt-link>
                </div>
                </div>
                <div class="col-md-6 mb-4 mb-md-0 ps-5">
                <img
                    class="w-sm-100 img-fluid"
                    src="~/assets/images/aboutus1.jpg"
                    alt="..."
                />
                </div>
            </div>
        </div>
    </div>
    <div class="container">
      <div class="row py-5 mt-5 mt-100 mb-50 pd-0">
        <div class="col-md-6 pe-5">
          <img
            class="w-sm-100 img-fluid"
            src="~/assets/images/aboutus1.jpg"
            alt="..."
          />
        </div>
        <div class="col-md-6 pe-5">
          <div class="d-flex flex-column justify-content-center h-100">
            <h3 class="section-heading text-start fs-5 mb-3 mt-0 mb-30">{{this.$t('web.about_us.our_vision.title.first')}}<span>{{this.$t('web.about_us.our_vision.title.second')}}</span></h3>
            <h2 class="fw-bold mb-30">{{this.$t('web.about_us.our_vision.sub_heading.first')}} <br />  {{this.$t('web.about_us.our_vision.sub_heading.second')}}</h2>
            <p class="my-4 mt-0 mb-30">
              {{this.$t('web.about_us.our_vision.description')}}
            </p>
            <nuxt-link to="#" class="text-primary">{{this.$t('web.about_us.view_more')}}
                <fa icon="arrow-right" class="ms-2" fixed-width/>
            </nuxt-link>
          </div>
        </div>
      </div>

      <div class="row review-cards py-5">
        <div class="col-12">
          <h2 class="section-heading mb-4 mt-0 mb-50">{{this.$t('web.about_us.why_us.title.first')}}<span>{{this.$t('web.about_us.why_us.title.second')}}</span></h2>
        </div>

        <div class="col-md-4 mb-4 mb-md-0">
          <div class="rounded shadow card-wrap categories">
            <div class="card-icon text-primary mb-4">
              <fa :icon="['fas', 'shipping-fast']" class="fs-1 me-4" />
            </div>
            <div class="card-content">
              <h6 class="fw-bold mb-1">{{this.$t('web.about_us.why_us.free_shipping.title')}}</h6>
              <p class="fs-7 mb-0">
               {{this.$t('web.about_us.why_us.free_shipping.description')}}
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-4 mb-md-0">
          <div class="rounded shadow card-wrap categories">
            <div class="card-icon text-primary mb-4">
              <fa :icon="['fas', 'dollar-sign']" class="fs-1 me-4" />
            </div>
            <div class="card-content">
              <h6 class="fw-bold mb-1">{{this.$t('web.about_us.why_us.money_back_guarantee.title')}}</h6>
              <p class="fs-7 mb-0">
                {{this.$t('web.about_us.why_us.money_back_guarantee.description')}}
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4 mb-md-0">
          <div class="rounded shadow card-wrap categories">
            <div class="card-icon text-primary mb-4">
              <fa :icon="['fas', 'headset']" class="fs-1 me-4" />
            </div>
            <div class="card-content">
              <h6 class="fw-bold mb-1">{{this.$t('web.about_us.why_us.support.title')}}</h6>
              <p class="fs-7 mb-0">
                {{this.$t('web.about_us.why_us.support.description')}}
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-5 mt-50">
        <div class="col-12">
          <h2 class="section-heading team-heading mb-5 mb-50"> {{this.$t('web.about_us.our_team.title.first')}} <span>{{this.$t('web.about_us.our_team.title.second')}}</span></h2>
        </div>
        <div class="col-md-3">
          <div class="card overflow-hidden mb-4">
            <img src="~/assets/images/team-4.jpg" class="img-fluid" alt="..." />
            <div class="card-body">
                  <p class="card-text mb-2">
                    <small class="text-muted">CEO, Co-founder</small>
                  </p>
                  <h5 class="card-title">Card title</h5>
                </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card overflow-hidden mb-4">
            <img
                  src="~/assets/images/team-3.jpg"
                  class="img-fluid"
                  alt="..."
                />
            <div class="card-body">
                  <p class="card-text mb-2">
                    <small class="text-muted">CEO, Co-founder</small>
                  </p>
                  <h5 class="card-title">Card title</h5>
                </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card overflow-hidden mb-4">
            <img
                  src="~/assets/images/team-6.jpg"
                  class="img-fluid"
                  alt="..."
                />
            <div class="card-body">
                  <p class="card-text mb-2">
                    <small class="text-muted">CEO, Co-founder</small>
                  </p>
                  <h5 class="card-title">Card title</h5>
                </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card overflow-hidden mb-4">
            <img
                  src="~/assets/images/team-4.jpg"
                  class="img-fluid"
                  alt="..."
                />
            <div class="card-body">
                  <p class="card-text mb-2">
                    <small class="text-muted">CEO, Co-founder</small>
                  </p>
                  <h5 class="card-title">Card title</h5>
                </div>
          </div>
        </div>


        <div class="col-md-3">
          <div class="card overflow-hidden mb-4">
                <img
                  src="~/assets/images/team-6.jpg"
                  class="img-fluid"
                  alt="..."
                />
                <div class="card-body">
                  <p class="card-text mb-2">
                    <small class="text-muted">CEO, Co-founder</small>
                  </p>
                  <h5 class="card-title">Card title</h5>
                </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card overflow-hidden mb-4">
                <img
                  src="~/assets/images/team-3.jpg"
                  class="img-fluid"
                  alt="..."
                />
                <div class="card-body">
                  <p class="card-text mb-2">
                    <small class="text-muted">CEO, Co-founder</small>
                  </p>
                  <h5 class="card-title">Card title</h5>
                </div>
          </div>
        </div>
      </div>
    </div> -->
    <WebsiteTemplate1NewsLetterSection />
  </section>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  auth: false,
  data() {
    return {
      about: '',
      currentlyActiveTemplate: "",
    }
  },
  created() {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
  },
  async fetch() {
    const data = await this.$webService.allAboutUs();
    let currentLocale = this.$i18n.locale;
    if(currentLocale){
    this.about = data.textTranslations[this.$i18n.locale];
    }else{
        this.about = data.textTranslations[this.allSettings.language.code];
    }
  },
  computed: {
    ...mapGetters({
      allSettings: 'allDefaultSettings',
    }),
  },
};
</script>
