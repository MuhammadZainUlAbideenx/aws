<template>
    <section class="terms-and-conditions">
    <WebsiteGlobalComponentsBreadCrumb :page="`term_and_condition`" />
    <div class="container">
      <div class="row">
        <div class="col-12">
            <h2 class="section-heading text-start">
            {{detail.name}}
          </h2>
        </div>
      </div>
      <div class="row mt-3">
          <div class="col-12" v-html="detail.description_web">

          </div>
      </div>
    </div>
     <WebsiteTemplate1NewsLetterSection />
    </section>
</template>
<script>
export default {
  auth:false,
  data(){
    return {
        detail:''
    }
  },
  async fetch() {
    const { data } = await this.$webService.contentPageDetail(
      this.$route.params.slug
    );
    if (data) {
      this.detail = data;
    }
  },
}
</script>
