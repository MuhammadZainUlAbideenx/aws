
<template>
  <div class="modal fade newslettermodal" id="newslettermodal" tabindex="-1" aria-labelledby="newsletter" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-1">
        <div class="modal-body bg-white">
        <button type="button" class="btn-close popup" data-bs-dismiss="modal" aria-label="Close" ></button>

          <img src="~/assets/images/popup.jpg" alt="" srcset="">
          <div class="newsletter-wrap text-dark p-5 text-center">
            <h2>{{$t('newsletter_popup.want')}} {{$t('newsletter_popup.percentOff')}}</h2>
            <p>{{$t('before_you_leave_grab_the_offer_enter')}} <br> {{$t('this_coupon_code_at_checkout_to_get_off')}}</p>
            <div class="promo-popup-discount-code d-flex">
                <input type="text" class="discount-code" readonly="" name="discount_code" value="special10%">
                <button class="btn btn-primary rounded-1" data-message-success="Copied" value="Copy">{{$t('copy')}}</button>
            </div>
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
