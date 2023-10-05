<template>
  <div class="modal rounded fade in media-gallery-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header p-2">
        <button type="button" class="btn rounded-circle btn-primary d-block ms-auto" data-bs-dismiss="modal" aria-label="Close">
          <fa icon="times"  ></fa>
        </button>
      </div>
      <div class="model-body" v-if="$fetchState.pending || media == ''">
        <AdminLoader />
      </div>
      <div class="modal-body" v-else>
        <div class="" v-if="media">

        <div class="gallery-popup-video ms-auto me-auto" v-if="media.type == 'video'">
          <video  controls class="w-100 h-100">
            <source :src="url + `${media.original_media_path}`" type="video/mp4">
            {{$t("media_detail.video_text")}}
          </video>
        </div>
        <div class="gallery-popup-img ms-auto me-auto  mb-4" v-else >
          <img  :src="url + `${media.original_media_path}`"/>
        </div>
        <div class="row border-top border-bottom border-light mx-0 py-4 px-2 text-start">
          <div class="col-md-3 d-flex align-items-center">
            <h5 class="my-auto mx-2">{{$t("media_detail.url")}}</h5>
          </div>
          <div class="col-md-9 ps-3 ps-md-0 d-flex align-items-center">
            <p class="my-auto pe-1" >{{ url + `${media.original_media_path}` }}
              <button type="button" name="button" v-clipboard:copy="full_url + url + media.original_media_path"
            v-clipboard:success="onCopy" v-clipboard:error="onError"
            class="btn btn-sm btn-primary py-0 px-2  ">{{$t("media_detail.copy_text")}}</button>
            </p>

          </div>

        </div>
        <div class="row border-bottom mx-0  py-4 text-start px-2 border-light">
          <div class="col-md-3 d-flex align-items-center">
            <h5 class="my-auto mx-2">{{$t("media_detail.created_at")}}</h5>
          </div>
          <div class="col-md-9  d-flex align-items-center ps-3 ps-md-0">
            <p class="my-auto pe-1">{{media.created_at }}</p>
          </div>
        </div>
        <div class="row border-bottom mx-0  py-4 text-start px-2 border-light">
          <div class="col-md-3 d-flex align-items-center">
            <h5 class="my-auto mx-2">{{$t("media_detail.type")}}</h5>
          </div>
          <div class="col-md-9 d-flex align-items-center ps-3 ps-md-0">
            <p class="my-auto pe-1" >{{ media.type }}</p>
          </div>
        </div>
        <div class="row border-bottom mx-0  py-4 text-start px-2 border-light">
          <div class="col-md-3 d-flex align-items-center">
            <h5 class="my-auto mx-2">{{ $t("media_detail.extension")}}</h5>
          </div>
          <div class="col-md-9 ps-3 ps-md-0">
            <p class="my-auto pe-1">{{ media.mime_type }}</p>
          </div>
        </div>

          <div class="table-responsive">
          <table class="table text-start">
            <thead>
              <tr>
                <th class="ps-4">{{$t("media_detail.thumbnail")}}</th>
                <th>{{$t("media_detail.path")}}</th>
                <th>{{$t("media_detail.type")}}</th>
                <th>{{$t("media_detail.dimension")}}</th>
                <th>{{$t("media_detail.copy_text")}}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="image in media.thumbnails" :key="image.id" class="ms-2">
                <td class="ps-4 d-flex align-items-center justify-content-center">
                  <img  :src="url + `${image.thumbnail}`" alt="">
                </td>
                <td>
                  <p> {{url + `${image.thumbnail}`}}</p>
                </td>
                <td>
                 <span> {{image.thumbnail_type
                  }} </span>
                </td>
                <td>
                <span> {{image.height}} X {{image.width}} </span>
                </td>
                <td>
                  <button type="button" name="button"  v-clipboard:copy="full_url + url + image.thumbnail"
                  v-clipboard:success="onCopy" v-clipboard:error="onError"
                  class="btn btn-sm btn-dark shadow "
                  >{{$t("media_detail.copy_text")}}</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      </div>


      <div class="modal-footer mb-3 mx-2">
        <button type="button" class="btn btn-danger py-2 px-4 shadow" data-bs-dismiss="modal">{{ $t('close')}}</button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import clipboardMixin from '~/mixins/clipboard.js'
export default {
  mixins: [clipboardMixin],
  data(){
    return {
      media: '',
      url: '/backend',
      full_url:'',
      message: 'Copy These Text',
    }
  },
  props:['media_id'],
  components: {
  },
	async fetch(){

    if(this.media_id != ''){
      await this.$media.fetchSingleMedia(this.media_id)
      .then(response => {
        this.media = response.media
        // this.fetchMedia();
        // this.notifyVue('top', 'right','success','File Deleted Successfully');
      });
    }
    await setTimeout(() => {
      this.loading = false
    },3000)
	},
  methods: {
  },
  computed: {
  },
  created() {
    if(process.browser){
      this.full_url = window.location.hostname + (window.location.port ? ':'+window.location.port: '')
    }
  },
  watch: {
    media_id(){
      this.media = ''
      this.$fetch();
    }
  },

}
</script>
<style lang="css" scoped>
.modal-body{
  overflow-x: auto;
}
</style>
