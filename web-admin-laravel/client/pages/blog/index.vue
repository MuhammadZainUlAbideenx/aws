<template>
  <section v-if="$fetchState.pending" class="blog-page mt-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`blog`" />
     <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}BlogPage`" />
  </section>

  <section v-else class="blog-page mt-0 my-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`blog`" />

    <div class="container">
      <div class="row">
          <div class="col-12">
            <div class="grig-list-nav filter-bar d-flex justify-content-between mb-0 flex-md-row mt-4 mt-md-5 bg-secondary align-items-center mt-100 mb-18">
            <WebsiteGlobalComponentsGrigListView :grid_class="grid_class" @changeGridClass="changeGridClass" />
          <div
            class="d-md-flex justify-content-between filter-bar rounded bg-transparent flex-md-row"
          >
            <div class="me-3 mb-md-0">
              <div class="d-flex align-items-center position-relative">
                <label class="form-label flex-shrink-0 text-medium mb-0 me-3"
                  >{{$t("search")}}:
                </label>
                <input
                  type="email"
                  class="form-control custom-input"
                  aria-describedby="emailHelp"
                 :placeholder="this.$t('search')"
                  @change="onSearch"
                  v-model="pagination.search"
                />
                <div
                  class="position-absolute top-50 end-0 translate-middle-y px-3"
                >
                  <fa icon="search" class="text-primary" fixed-width />
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-between">
              <div
                class="dropdown-fild d-flex align-items-center sort-by-dropdown"
              >
                <label class="form-label flex-shrink-0 text-medium mb-0 me-3"
                  >{{$t("sort_by")}}:
                </label>
                <select
                  class="form-select"
                  id="item-per-page"
                  aria-describedby="item-per-pageFeedback"
                  placeholder="Featured"
                  required
                  @change="onOrderChange"
                  v-model="pagination.sort"
                >
                  <option  selected hidden :value="{type:'',field: ''}" >{{ $t("select_sort") }}</option>
                  <option v-for="(option,index) in options " :key="index" :value="option">{{option.display}}</option>
                </select>
              </div>
            </div>
          </div>
          </div>
        </div>
        <div class="col-md-12 p-0">
          <div class="row blog">
            <div class="my-3 col-md-6 col-sm-12"
              :class="grid_class"
              v-for="post in posts.data" :key="post.id"
            >
              <Component :is="`${currentlyActiveTemplate}BlogPostCard`" :post="post" :grid_class="grid_class" />
            </div>
          </div>
        </div>
        <div class="col-12">
          <AdminLoader v-if="loading_more" />
       <div class="load-more-btn d-flex justify-content-center align-items-center mt-4 mb-5">
            <button type="button" name="button" class="btn btn-primary text-uppercase fw-bold px-5 py-2 d-flex align-items-center" @click="loadmore" v-if="posts.meta.current_page != posts.meta.last_page">
              <fa :icon="['fas', 'arrow-down']" class="me-2 fs-5" />
              {{ $t("load_more") }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <WebsiteTemplate1NewsLetterSection />
  </section>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  auth: false,
  data() {
    return {
         currentlyActiveTemplate: "",
        grid_class:'col-lg-4 last-col-4',
        posts:'',
        loading_more:false,
        searching:false,
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
        options:[
            {
            field: 'name',
            type: 'ASC',
            display: this.$t('name_a_to_z')
            },
            {
            field: 'name',
            type: 'DESC',
            display: this.$t('name_z_to_a'),
            }
        ],
    };
  },
    created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
  },
  async fetch(){
           const { data } = await this.$webService.allPosts();
            this.posts= data
             this.pagination.perPage = this.posts.meta.per_page
  },
  methods:{
       changeGridClass(grid_class){
      this.grid_class = grid_class
    },
    async loadmore(){
      this.loading_more = true
      this.pagination.page += 1
      const { data } = await this.$webService.allPosts(this.pagination);
      this.posts.data = this.posts.data.concat(data.data);
      this.posts.meta = data.meta
      this.posts.links = data.links
      this.loading_more = false
    },
    async onSearch(){
      this.searching =true
      this.pagination.page = 1
      const { data } = await this.$webService.allPosts(this.pagination);
      this.posts.data = data.data;
      this.posts.meta = data.meta
      this.posts.links = data.links
      this.searching = false
    },
    async onOrderChange(){
      this.searching = true
      this.pagination.page = 1
      const { data } = await this.$webService.allPosts(this.pagination);
      this.searching = false
      this.posts = data;
    },
    async onPerPageChange(){
      this.searching = true
      this.pagination.page = 1
      const { data } = await this.$webService.allPosts(this.pagination);
      this.posts.data = data.data;
      this.posts.meta = data.meta
      this.posts.links = data.links
      this.searching = false
    }
  },
      computed:{
    ...mapGetters({
      allSettings: 'allDefaultSettings'
    }),
  },
};
</script>

