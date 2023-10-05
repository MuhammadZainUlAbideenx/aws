<template>
  <section class="wishlist-page m-0 mb-4">
    <WebsiteGlobalComponentsBreadCrumb :page="`stores`"/>

    <div  v-if="$fetchState.pending">
    <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}StoresPage`" />
</div>

    <div v-else class="container">
      <div class="">
        <div class="col-12">
          <div
            class="d-md-flex justify-content-between filter-bar mb-5 rounded mt-5 mt-100 mb-50 bg-secondary"
          >
            <div>
              <div class="d-flex align-items-center position-relative mb-2 mb-md-0">
                <label class="form-label flex-shrink-0 text-medium mb-0 me-3"
                  >{{$t("search")}}
                </label>
                <input
                  type="text"
                  class="form-control custom-input"
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
                  >{{$t('sort_by')}}
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
         <AdminLoader v-if="loading_sort" />
        <div v-else-if="vendors.data.length>0" class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4" v-for="vendor in vendors.data" :key="vendor.id">
           <Component :is="`${currentlyActiveTemplate}VendorListCard`" :vendor="vendor" />
        </div>
        </div>
          <div class="no-result py-5" v-else>
            <fa :icon="['fas', 'search']" />
            <h2 class="mt-5">
                {{$t('sorry_no_matching_results_found')}}
            </h2>
            <p class="mt-3 text-medium lead text-center h-auto">
                {{$t('try_again_using_more_general_search_filters')}}
            </p>
            <button
                type="button"
                class="btn btn-primary"
                name="button"
            >
            {{$t('reset_Filters') }}
            </button>
        </div>
        <div class="col-12">
          <AdminLoader v-if="loading_more" />
       <div class="load-more-btn d-flex justify-content-center align-items-center mt-4 mb-5 my-0" v-if="!loading_sort">
            <button type="button" name="button" class="btn btn-primary text-uppercase fw-bold px-5 py-2 d-flex align-items-center" @click="loadmore" v-if="vendors.meta.current_page != vendors.meta.last_page">
              <fa :icon="['fas', 'arrow-down']" class="me-2 fs-5" />
              {{ $t("load_more") }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <WebsiteTemplate1NewsLetterSection class="mt-5" />
  </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  auth: false,
  data() {
    return {
          currentlyActiveTemplate: "",
      key: 1,
      detail: "",
      seo: {},
      vendors: "",
      loading_more:false,
      loading_sort:false,
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
          display:this.$t('name_a_to_z')
        },
        {
          field: 'name',
          type: 'DESC',
          display: this.$t('name_z_to_a')
        }
      ],
    };
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
      const { data } = await this.$webService.allVendors(this.pagination);
      this.vendors.data = this.vendors.data.concat(data.data);
      this.vendors.meta = data.meta
      this.vendors.links = data.links
      this.loading_more = false
    },
    async onSearch(){
      this.searching =true
      this.pagination.page = 1
      const { data } = await this.$webService.allVendors(this.pagination);
      this.vendors.data = data.data;
      this.vendors.meta = data.meta
      this.vendors.links = data.links
      this.searching = false
    },
    async onOrderChange(){
        this.loading_sort = true
      this.searching = true
      this.pagination.page = 1
      const { data } = await this.$webService.allVendors(this.pagination);
      this.vendors = data;
      this.searching = false
       this.loading_sort = false
    },
    async onPerPageChange(){
      this.searching = true
      this.pagination.page = 1
      const { data } = await this.$webService.allVendors(this.pagination);
      this.vendors.data = data.data;
      this.vendors.meta = data.meta
      this.vendors.links = data.links
      this.searching = false
    }
  },
   computed:{
    ...mapGetters({
      allSettings: 'allDefaultSettings'
    }),
  },
  async fetch() {
    const { data } = await this.$webService.allVendors();
    this.vendors = data;
    this.pagination.perPage = this.vendors.meta.per_page

  },
};
</script>

<style>
</style>
