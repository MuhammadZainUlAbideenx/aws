<template >
  <div class="modal fade in media-gallery-modal single" :id="modal_id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header p-2">
        <button type="button" class="btn rounded-circle btn-primary d-block ms-auto" data-bs-dismiss="modal" aria-label="Close">
          <fa icon="times"  ></fa>
        </button>
      </div>
      <div class="modal-body">
        <GlobalCard class="" style="background:none;">
            <div class="todos p-5">
              <div
              v-for="image in allActiveMedia.media[type]"
              :key="image.id"
              class="todo"
              >
                <div class="media-gallery-img ms-auto me-auto mb-3">
                  <img data-bs-dismiss="modal" @click="selectImage(image.media.id,image.thumbnail)"  v-bind:src=" url + `${image.thumbnail}`"
                class="" />
                </div>
            </div>
          </div>
      </GlobalCard>
      </div>

      <div class="modal-footer py-5">
        <button type="button" class="btn btn-danger py-2 px-4 shadow" data-bs-dismiss="modal">{{ $t('close')}}</button>
        <nuxt-link :to="localePath('/admin/media')" target="_blank" class="btn btn-primary py-2 px-4 shadow">{{ $t('upload')}}</nuxt-link>
        <button @click="refetchMedia" class="btn btn-success py-2 px-4 shadow">{{ this.$t('refresh')}}</button>
      </div>
    </div>
  </div>
  </div>
</template>
<script type="text/javascript">
import { mapState, mapGetters, mapActions } from "vuex";
export default {
  data(){
    return {
      url: '/backend',
    }
  },
  props:['modal_id','img_var','bind_modal','type'],
  methods: {
    ...mapActions({
      fetchActiveMedia: 'General/fetchActiveMedia',
    }),
    selectImage(id,path){
      this.$emit('selectImage',id,path,this.img_var,this.bind_modal)
    },
    refetchMedia(){
      this.fetchActiveMedia();
    }

  },
  computed: {
    ...mapGetters({
      allActiveMedia: 'General/allActiveMedia',
    })
  },
}
</script>
<style scoped>
</style>
