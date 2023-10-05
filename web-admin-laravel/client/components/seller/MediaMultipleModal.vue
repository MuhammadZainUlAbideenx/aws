<template >
  <div class="modal fade in media-gallery-modal" :id="modal_id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header p-3">
        <button type="button" class="btn rounded-circle btn-primary d-block ms-auto" data-bs-dismiss="modal" aria-label="Close">
          <fa icon="times"  ></fa>
        </button>
      </div>
      <div class="modal-body">
        <GlobalCard class="my-4 " style="background:none;">
            <div class="pop-up-gallery border-bottom border-2 rounded-0 p-5 justify-content-between">
            <div
              v-for="image in allActiveMedia.media[type]"
              :key="image.id"
              class="todo"
              >
                <div class="media-gallery-img mb-3" >
                  <img @click="currentImage(image.media.id,image.thumbnail)" :class="image.media.id == image_id ? 'border border-2':''"   v-bind:src=" url + `${image.thumbnail}`"
                />
                </div>
            </div>
          </div>
          <!-- <div class="py-5 px-100  bg-gray border-bottom border-2">
               <div class="row">
            <label class="label form-label">
                {{ this.$t("form.product.product_media.description.label") }}
              </label>
            <input type="text" v-model="description" class="form-control" :placeholder="this.$t('form.product.product_media.description.placeholder')">
            <span class="px-2 heebo-light">
                {{ $t("form.product.product_media.description.subheading") }}
            </span>
          </div>
          <div class="row">
            <label class="label form-label">
                {{ this.$t("form.product.product_media.alt_text.label") }}
              </label>
            <input type="text" v-model="alt_text" class="form-control" :placeholder="this.$t('form.product.product_media.alt_text.placeholder')">
            <span class="px-2 heebo-light">
                {{ $t("form.product.product_media.alt_text.subheading") }}
            </span>
          </div>
          </div> -->

      </GlobalCard>
      </div>

      <div class="modal-footer mt-3 mb-5 mx-2">
        <button type="button" @click="cancel" class="btn btn-danger py-2 px-4 shadow" data-bs-dismiss="modal">{{ $t("cancel") }}</button>
        <nuxt-link :to="localePath('/admin/media')" target="_blank" class="btn btn-secondary py-2 px-4 shadow">{{ $t('upload')}}</nuxt-link>
        <button @click="refetchMedia" class="btn btn-success py-2 px-4 shadow">{{ this.$t('refresh')}}</button>
        <button :data-bs-dismiss="image_id && alt_text ?'modal':''" @click="selectImage()" type="button" class="btn btn-primary py-2 px-4 shadow">{{ $t("add") }}</button>
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
      description:'',
      image_id:'',
      path:'',
      alt_text:''
    }
  },
  props:['type','modal_id','product_name'],
  mounted(){
    this.alt_text = this.changed_alt_text
  },
  methods: {
    ...mapActions({
      fetchActiveMedia: 'General/fetchActiveMedia',
    }),
    selectImage(){
      if(this.image_id == '' || this.alt_text == ''){
        if(this.image_id == ''){
          this.$toast.error(this.$t('form.product.product_media.image.required_message'))
        }
        if(this.alt_text == ''){
          this.$toast.error(this.$t('form.product.product_media.alt_text.required_message'))
        }
      }
      else{
        this.$emit('selectImage',this.image_id,this.path,this.description,this.alt_text)
        this.image_id = ''
        this.description = ''
        this.path = ''
        this.alt_text = this.product_name
      }
    },
    cancel(){
      this.image_id = ''
      this.description = ''
      this.path = ''
      this.alt_text = this.product_name
    },
    refetchMedia(){
      this.fetchActiveMedia();
    },
    currentImage(id,path){
      this.image_id = id
      this.path = path
    },

  },
  computed: {
    ...mapGetters({
      allActiveMedia: 'General/allActiveMedia',
    }),
    changed_alt_text(){
        return this.product_name
    }

  },
}
</script>
<style scoped>
</style>
