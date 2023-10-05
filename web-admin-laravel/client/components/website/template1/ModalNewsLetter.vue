<template>
  <div class="modal fade newslettermodal" id="newslettermodal" tabindex="-1" aria-labelledby="newsletter" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>

          <img src="~/assets/images/newslettermodal-bg.png" alt="" srcset="">
          <div class="newsletter-wrap text-dark">
            <h2>{{$t('newsletter_popup.want')}} <br> {{$t('newsletter_popup.percentOff')}}</h2>
            <h3>{{$t('newsletter_popup.heading')}} </h3>

              <input type="text" class="form-control"
              :placeholder="this.$t('newsletter_popup.placeholder')"
              v-model="formData.email"
              >
              <button @click="add_email()" class="btn btn-primary" type="button">{{$t('newsletter_popup.subscribe')}}</button>

            <button type="button" class="close not-intrested" data-bs-dismiss="modal">{{$t('newsletter_popup.not_interested')}}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      settings:{
      },
      error:'',
        formData:{
        email:'',
        }
    }
  },
    methods:{
   async add_email(){
                await this.$webService.addNewsletterEmail({email:this.formData.email}).then(async (res) => {
                if(res.success == false)
                {
                this.$toast.error(this.$t('subscription_email_already_exists_message'));
                }
                else
                {
                    this.$toast.success(this.$t('subscription_email_added_message'));
                      $("#newslettermodal").modal('hide');

                }
            }).catch(async (res) =>{
            if(res.response.data.errors)
            {
                this.error = res.response.data.errors;
                if(this.error.email){
                     this.$toast.error(this.error.email[0])
                }
            }
            }
            );
    },
  },
  mounted(){
    if (process.browser) {
        window.onNuxtReady((app) => {
         setTimeout(() => $('#newslettermodal').modal('show'), 5000)
      })
}
  }
}
</script>

<style>

</style>
