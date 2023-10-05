<template>
  <section class="product-faqs">
      <div class="container" v-if="currentlyActiveTemplate == 'Template1'" >
          <div class="row">
              <div class="col-12">
                  <h2 class="section-heading text-start text-capitalize">
                      {{$t('question_about_products')}}
                  </h2>
                  <h4 class="text-medium">{{$t('total_questions')}}: {{this.product.faq.length}}</h4>
                  <div class="row g-0">
                      <div class="col-md-8 pt-5">
                          <div v-for="faq in product.faq" :key="faq.id">
                            <div class="d-flex align-items-start"><img  src="~/assets/images/fi-rr-shield-interrogation.png" alt="" class="pe-4"> <h2>{{faq.question}}</h2></div>

                            <div class="d-flex align-items-start pt-4 mb-5">  <img  src="~/assets/images/fi-rr-shield-check.png" alt="" class="pe-4"> <p >{{faq.answer}}</p> </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

  </section>
</template>
<style media="screen">

</style>
<script type="text/javascript">
import { mapGetters } from "vuex";

  export default {
    props:['product'],
    data(){
        return{
         currentlyActiveTemplate: "",

        }
    },
     created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme;
  },
  methods:{
  },
      computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
}
</script>
