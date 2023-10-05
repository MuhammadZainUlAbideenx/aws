<template>
  <div  class="content d-flex flex-column flex-column-fluid" id="tc_content">
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">{{ this.$t("sidebar.media") }}</h2>
        </div>
        <!-- /.col -->
        <div class="row">
          <div class="col-sm-12 px-0">
            <ol class="breadcrumb float-sm-right text-body">
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/admin/dashboard')">{{
                  this.$t("sidebar.home")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item">
                {{ this.$t("sidebar.media_library") }}
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("sidebar.media") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("sidebar.media_library_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>


            <div class="row table-filter-row px-4 mx-0 justify-content-end">
              <!-- Small boxes (Stat box) -->
              <!-- <div class="col-sm-4">
                <div class="row g-0 input-group">
                  <div class="form-group position-relative col-12">
                    <input
                      class="form-control"
                      v-model="filterData.search"
                      @change="filter"
                      type="search"
                      :placeholder="this.$t('dataTables.Search')"
                    />
                    <div class="position-absolute search-input-custom">
                      <fa :icon="['fas', 'search']" fixed-width class="" />
                    </div>
                  </div>
                </div>
              </div> -->
            </div>

    <!--begin::Entry-->
     <div v-if="$fetchState.pending">
            <AdminMediaLoader/>
        </div>
    <div class="d-flex flex-column-fluid" v-else >
      <!--begin::Container-->
      <div class="container-fluid mb-5 custom-vue-dropzone" >
        <div class="row my-4">
          <div class="col-sm-12 col-md-4 col-lg-2 gutter-b">
            <div class="p-3 dropzone-area rounded-md h-100">
              <GlobalCard class="dropzone-card h-100">
                <dropzone
                  id="drop1"
                  :options="language_api"
                  @vdropzone-complete="afterComplete"
                ></dropzone>
              </GlobalCard>
            </div>
          </div>
          <!-- Media Loading    <div class="container" v-if="$fetchState.pending">
              <div class="row">
                <div class="col-md-12">
                  <AdminLoader />
                </div>
              </div>
            </div> -->
          <div class="col-sm-12 col-md-4 col-lg-2 gutter-b" v-for="image in media.data" :key="image.key">
            <div class="card border-0">
              <div class="card-body">
                <div :key="image.id" class="">
                  <div class="media-gallery-img ms-auto me-auto p-3">
                    <span
                      class="px-2 text-white"
                      v-if="image.type == 'video'"
                      @click="deleteMedia(image.id)"
                    >
                      <fa icon="video"></fa>
                    </span>
                    <img
                      v-if="image.thumbnails && image.thumbnails.small"
                      v-bind:src="url + `${image.thumbnails.small.thumbnail}`"
                      data-bs-toggle="modal"
                      data-bs-target="#exampleModal"
                      @click="changeMediaDetail(image.id)"
                    />
                  </div>
                  <div class="overlay">
                    <div
                      class="h-100 d-flex align-items-center justify-content-center"
                    >

                      <span
                        class="px-2 text-white"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal"
                        @click="changeMediaDetail(image.id)"
                      >
                        <fa icon="eye"></fa>
                      </span>

                       <span
                        class="px-2 text-white"
                        data-bs-toggle="modal"
                        :data-bs-target="'#DeleteItem' + image.id"
                      >
                        <fa icon="trash-alt"></fa>
                      </span>
                    </div>
                  </div>
                  <AdminDeleteModal
                    :modal_id="'DeleteItem' + image.id"
                    @deleteClicked="deleteMedia(image.id)"
                    :delete_id="image.id"
                  >
                  </AdminDeleteModal>
                </div>
              </div>
            </div>
          </div>

          <mediaDetail :media_id="media_detail_id" />
        </div>
      </div>
    </div>
        <div class="col-12 text-center">
          <AdminLoader v-if="loading_more" />
          <button type="button" class="btn btn-primary px-3 py-2" name="button" @click="loadmore" v-if="media.meta && media.meta.current_page != media.meta.last_page">{{$t('load_more')}} </button>
        </div>
  </div>
</template>

<script>
import Dropzone from "nuxt-dropzone";
import "nuxt-dropzone/dropzone.css";
import { mapState, mapGetters, mapActions } from "vuex";
import mediaDetail from "./mediaDetail";
export default {
  layout: "vendor",
  middleware: "vendor",
  data: () => ({
      loading_more:false,
      searching:false,
      mediaData:"",
      media:'',
      pagination:{
          page:1,
          column:'',
          search:'',
          perPage:10,
          sort:{
            type: '',
            field: ''
          }
      },
      filterData: {
      search: '',
      },
    url: "/backend",
    media_detail_id: "",
    language_api: {
      headers: "",
      url: "/backend/api/admin/addMedia",
      dictDefaultMessage:
        "<div >Drop  Files <span>Here</span> to upload.</div>",
    },
  }),
  components: {
    Dropzone,
    mediaDetail,
  },
  async fetch() {
    this.language_api.headers = this.$axios.defaults.headers.common;
    this.media = await this.fetchMedia();
    this.pagination.perPage = this.media.meta.per_page
  },
  methods: {
    ...mapActions({
      fetchMedia: "Media/fetchMedia",
      fetchActiveMedia: "General/fetchActiveMedia",
      filterMedia: "Media/filterMedia",
    }),
     async filter() {
      await this.filterMedia(this.filterData).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
        }
      });
    },
    changeMediaDetail(media_id) {
      this.media_detail_id = media_id;
    },
    afterComplete(file) {
      setTimeout(
        function () {
          this.removeFile(file);
        }.bind(this),
        3000
      );
      if (file.status == "error") {
        // var res = JSON.parse(file.xhr.response);
        this.$toast.error(this.$t('maximum_size_allowed'));
        // if (res.errors) {
        //   for (const [key, value] of Object.entries(res.errors)) {
        //     this.$toast.error(value);
        //   }
        // }
      } else {
        var res = JSON.parse(file.xhr.response);
        // this.$fetch();
        this.$toast.success(res.message);
      }
    },
    removeFile: function (file) {
      file.previewElement.remove();
     this.$fetch();
      //  this.fetchActiveMedia();
    },
    deleteMedia(id) {
      this.$media.deleteMedia(id).then((response) => {
         this.$fetch();
        //  this.fetchActiveMedia();
      this.$toast.success(this.$t('file_deleted_successfully'));
      });
    },
    async loadmore(){
      this.loading_more = true
      this.pagination.page += 1
      const { media } = await this.$media.fetchMedia(this.pagination);
      this.media.data = this.media.data.concat(media.data);
      this.media.meta = media.meta
      this.media.links = media.links
      this.loading_more = false
    },
    async onSearch(){
      this.searching =true
      this.pagination.page = 1
      const { media } = await this.$media.fetchMedia(this.pagination);
      this.media.data = media.data;
      this.media.meta = meda.meta
      this.media.links = media.links
      this.searching = false
    },
    async onOrderChange(){
      this.searching = true
      this.pagination.search = search
      this.pagination.page = 1
      const { media } = await this.$media.fetchMedia(this.pagination);
      this.media.data = media.data;
      this.media.meta = media.meta
      this.media.links = media.links
      this.searching = false
    },
    async onPerPageChange(){
      this.searching = true
      this.pagination.page = 1
      const { media } = await this.$media.fetchMedia(this.pagination);
      this.media.data = media.data;
      this.media.meta = media.meta
      this.media.links = media.links
      this.searching = false
    }
  },
//   computed: {
//     ...mapGetters({
//       allMedia: "Media/allMedia",
//     }),
//   },
  created() {},
};
</script>
<style lang="css" scoped>
#drop1 {
  background-color: #27293d;
}
.todos {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  grid-gap: 1rem;
}

.todo {
  border: 1px solid #ccc;
  background: none;
  padding: 1rem;
  border-radius: 5px;
  text-align: center;
  position: relative;
  cursor: pointer;
}

i {
  position: absolute;
  bottom: 10px;
  right: 10px;
  color: #fff;
  cursor: pointer;
}

.legend {
  display: flex;
  justify-content: space-around;
  margin-bottom: 1rem;
}

.complete-box {
  display: inline-block;
  width: 10px;
  height: 10px;
  background: #35495e;
}

.incomplete-box {
  display: inline-block;
  width: 10px;
  height: 10px;
  background: #41b883;
}

.is-complete {
  background: #35495e;
  color: #fff;
}

@media (max-width: 500px) {
  .todos {
    grid-template-columns: 1fr;
  }
}
</style>
