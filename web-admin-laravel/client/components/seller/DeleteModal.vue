<template>

<div class="modal fade" :id="modal_id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-5 text-center">
                        <div class="warning-icon text-white">
                            <fa :icon="['fas', 'trash-alt']" fixed-width />
                        </div>

                        <h3 class="py-5">{{$t('are_you_sure_you_want_to_delete')}}</h3>
                            <button data-bs-dismiss="modal" class="btn btn-danger" @click="delete_item">
                                    {{$t('delete')}}
                            </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{$t('web.customer.wallet.close')}}</button>
                      </div>

    </div>
  </div>
  </div>
</template>
<script>
export default {
props:['modal_id','delete_id'],
 methods: {
     delete_item(){
         this.$emit('deleteClicked')
     }
 }
}
</script>

<style>

</style>
