<template>
  <div  v-if="$fetchState.pending">
  <div class="general-card skeletion-effect p-5">
    <div class="text skeletion-animation"></div>
     <div class="text second skeletion-animation"></div>
      <div class="text third skeletion-animation"></div>
</div>
</div>
  <div v-else class="shipping-methods pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="text-primary text-uppercase fw-bold mb-0">{{$t('sidebar.shipping_method')}}</h5>
    </div>
    <div class="shipping-methods-form shadow rounded p-4 bg-white-secondary-light pb-1">
      <form class="row">
        <span class="float-end text-danger"
              v-if="all_errors && all_errors.shipping_id">
            {{ all_errors.shipping_id[0] }}
          </span>
        <div class="row">
          <div v-for='shipping_method in shipping_methods.data' class="shipping-items d-flex justify-content-between" :key="shipping_method.id" >
          <!-- <h5 class="text-primary text-body mb-4"> {{ shipping_method.name }} </h5> -->
            <div class="form-check mb-3">
              <input :id="`shipping_${shipping_method.id}`" v-model='shipping_method_details.id' :value='shipping_method.id' class="form-check-input" type="radio" >
              <label class="form-check-label fw-bold" :for="`shipping_${shipping_method.id}`"> {{ shipping_method.name }}</label>
            </div>
            <div>
            <span v-for="shipping_value in calculated_shipping_value" :key="shipping_value" class="text-end">
                <span v-if="shipping_method.id == shipping_value.shipping_id">
                    <span v-if="allCartItems.currency_direction == 'rlt'">
                        {{format_number(shipping_value.shipping_value,allCartItems.currency_decimal)}} {{allCartItems.symbol}}
                    </span>
                    <span v-if="allCartItems.currency_direction == 'ltr'">
                       {{allCartItems.symbol}} {{format_number(shipping_value.shipping_value,allCartItems.currency_decimal)}}
                    </span>
                    </span>
            </span>
            </div>
            <!-- <div class="shipping-items-det" v-for='shipping_method_setting in shipping_method.settings' :key="shipping_method_setting.id" >
              <p>{{ shipping_method_setting.name }}: <span>{{ shipping_method_setting.value }}</span></p>
            </div> -->
        </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data(){
    return{
      shipping_methods:{},
      url: '/backend',
      shipping_method_details:{
        id:'',
        value:''
      },
    }
  },
  props:['all_errors','calculated_shipping_value'],
  mounted(){
  },
  async fetch(){
    this.shipping_methods = await this.$webService.allShippingMethods();
    for(let x of this.shipping_methods.data ){
        if(x.is_default == 1){
            this.shipping_method_details.id = x.id;
        }
}
  },
  computed:{
    ...mapGetters({
      allCartItems: 'Web/Cart/allCartItems',
    }),
  },
 methods: {
    format_number(number,decimal) {
      return parseFloat(number).toFixed(decimal).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    },
  },
  watch: {
    shipping_method_details: {
      deep: true,
        handler() {
            if(this.shipping_method_details.id == 2)
            {
               this.shipping_method_details.value =  0;
            }
            else
            {

                    for (let inner = 0; inner < this.calculated_shipping_value.length; inner++) {
                        if(this.shipping_method_details.id == this.calculated_shipping_value[inner].shipping_id)
                        {
                            this.shipping_method_details.value = this.format_number(this.calculated_shipping_value[inner].shipping_value,this.allCartItems.currency_decimal)
                        }
                    }
                    if(this.shipping_method_details.id == 2)
                        {
                            // free shipping
                            this.shipping_method_details.value = this.format_number(0,this.allCartItems.currency_decimal)
                        }

        //   for (let index = 0; index < this.shipping_methods.data.length; index++) {
        //             for (let inner = 0; inner < this.shipping_methods.data[index].settings.length; inner++) {
        //                 if(this.shipping_methods.data[index].id == parseInt(this.shipping_method_details.id) && this.shipping_methods.data[index].settings[inner].name == 'rate')
        //                 {
        //                     this.shipping_method_details.value = this.format_number(this.shipping_methods.data[index].settings[inner].value,this.allCartItems.currency_decimal)
        //                 }
        //                 if(this.shipping_methods.data[index].id == 2)
        //                 {
        //                     this.shipping_method_details.value = this.format_number(this.shipping_methods.data[index].settings[inner].value,this.allCartItems.currency_decimal)
        //                 }
        //             }
        //   }

        }
          this.$emit('shipping_method_details', this.shipping_method_details)

    }
  }
}
}
</script>

<style>

</style>
