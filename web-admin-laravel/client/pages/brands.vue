<template>
  <section class="brands-page m-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`brands`" />

    <div  v-if="$fetchState.pending">
   <!-- <WebsiteSkeletonTemplate1BrandsPage/> -->
   <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}BrandsPage`" />
</div>
    <div v-else class="container">
      <div class="row">
        <div class="col-12">
          <div
            class="d-md-flex justify-content-between filter-bar mb-4 rounded mt-5 bg-secondary mt-100"
          >
            <div>
              <div class="d-flex align-items-center position-relative mb-3 mb-md-0 search">
                <label class="form-label flex-shrink-0 text-medium mb-0 me-3"
                  >{{$t("search")}}:
                </label>
                <input
                  type="email"
                  class="form-control"
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
      <div class="row mt-3 gy-4 my-0">

        <div class="col-6 col-md-3 col-lg-2" v-for="brand in brands.data" :key="brand.id">
          <div class="card p-2">
            <div class="img-wrap">
                <nuxt-link :to="'/shop?brand='+brand.id">
                        <img
                v-if="brand.image"
                :src="`/backend${brand.image.thumbnails.large.thumbnail}`"
              />
              <img
                v-else
                class="w-sm-100 img-fluid"
                src="~/assets/images/placeholder.png"
                alt="..."
              />
                </nuxt-link>

            </div>
          </div>
          <h5 class="pt-3 mb-0 text-center">{{brand.name}}</h5>
        </div>

        <div class="col-12 my-0">
          <AdminLoader v-if="loading_more" />
       <div class="load-more-btn d-flex justify-content-center align-items-center mt-4 mb-5 mt-50">
            <button type="button" name="button" class="btn btn-primary text-uppercase fw-bold px-5 py-2 d-flex align-items-center" @click="loadmore" v-if="brands.meta.current_page != brands.meta.last_page">
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
import { mapGetters,mapActions } from "vuex";
export default {
  auth: false,
  data() {
    return {
      currentlyActiveTemplate: "",
      loading_more:false,
      searching:false,
      key: 1,
      detail: "",
      seo: {},
      brands: "",
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
          display: this.$t('name_z_to_a')
        }
      ],
    }
  },
  created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
  },
  head() {
    return this.seo;
  },
  methods:{
    async loadmore(){
      this.loading_more = true
      this.pagination.page += 1
      const { data } = await this.$webService.allBrands(this.pagination);
      this.brands.data = this.brands.data.concat(data.data);
      this.brands.meta = data.meta
      this.brands.links = data.links
      this.loading_more = false
    },
    async onSearch(){
      this.searching =true
      this.pagination.page = 1
      const { data } = await this.$webService.allBrands(this.pagination);
      this.brands.data = data.data;
      this.brands.meta = data.meta
      this.brands.links = data.links
      this.searching = false
    },
    async onOrderChange(){
      this.searching = true
      this.pagination.page = 1
      const { data } = await this.$webService.allBrands(this.pagination);
      this.searching = false
      this.brands = data;
    },
    async onPerPageChange(){
      this.searching = true
      this.pagination.page = 1
      const { data } = await this.$webService.allBrands(this.pagination);
      this.brands.data = data.data;
      this.brands.meta = data.meta
      this.brands.links = data.links
      this.searching = false
    }
  },
    computed:{
    ...mapGetters({
      allSettings: 'allDefaultSettings'
    }),
  },
  async fetch() {
    const { data } = await this.$webService.allBrands();
    this.brands = data;
    this.pagination.perPage = this.brands.meta.per_page
  },

};
</script>

<style lang="scss" scoped>
.img-wrap {
  background-color: transparent !important;
  img{
      max-height: calc(148px - 2rem);
  }
}
.card{
  background-color: var(--page-background-secondary);
}
</style>
