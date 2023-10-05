<template>
<div v-if="$fetchState.pending">
      <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}ShopPage`" />
    </div>
   <div v-else class="shop-page-wrap section-gap my-0">
        <div class="bg-secondary top-shop mb-0">
            <div class="container h-100">
                <div class=" d-flex justify-content-center h-100 flex-column">
                    <h1 class="text-uppercase fw-bold mt-0 mb-30 mt-50">{{this.$t('web.shop.title')}}</h1>
                    <WebsiteGlobalComponentsBreadCrumb :page="`shop`" class="mb-50" />
                </div>
            </div>
        </div>
        <!-- <div class="bg-secondary top-shop my-5">
            <div class="container h-100 d-flex justify-content-center">
                <img src="~/assets/images/blog-img2.jpg" alt="">
                <div class=" d-flex justify-content-center h-100 flex-column ps-5">
                    <h1 class="text-uppercase fw-bold">Men <span class="text-capitalize">Fashion</span></h1>
                    <WebsiteGlobalComponentsBreadCrumb :page="`shop`" />
                </div>
            </div>
        </div> -->
        <div>
            <WebsiteTemplate2CategorySliderSection />
        </div>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="grig-list-nav d-flex justify-content-between mt-50 mb-50 p-3 align-items-center bg-secondary flex-column flex-md-row">
              <WebsiteGlobalComponentsGrigListView
                :grid_class="grid_class"
                @changeGridClass="changeGridClass"
              />
              <!-- <div class="price-range">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label>{{this.$t('web.shop.price_range')}}</label>
                    </div>
                    <div class="col-md-3 p-0">
                    <input
                        id="min-number"
                        type="number"
                        class="form-control"
                        v-model="filterData.min_price"
                    />
                    </div>
                    <div class="col-md-1 p-0 text-center">
                        <label>{{this.$t('web.shop.to')}}</label>
                    </div>
                    <div class="col-md-3 p-0">
                    <input
                        id="max-number"
                        type="number"
                        class="form-control"
                        v-model="filterData.max_price"
                    />
                    </div>
                </div>
              </div>
              <div class="d-flex custom-width">
                <div class="dropdown-fild sort-by-item mt-3 mt-md-0 ms-ms-4 flex-column flex-md-row">
                  <label
                    for="item-per-page"
                    class="form-label text-medium me-2"
                    >{{ $t("sort_by") }}</label
                  >
                  <select
                    class="form-select border-light"
                    id="item-per-page"
                    aria-describedby="item-per-pageFeedback"
                    placeholder="Featured"
                    required
                    @change="onOrderChange"
                    v-model="filterData.sort"
                  >
                    <option selected :value="{type:'',field: ''}">
                      {{ this.$t("a_to_z") }}
                    </option>
                    <option
                      v-for="(option, index) in options"
                      :key="index"
                      :value="option"
                    >
                      {{ option.display }}
                    </option>
                  </select>
                </div>
              </div> -->

              <div class="filter" v-click-outside="externalClick">
                 <span class=" position-relative fs-5 text-primary ms-3 px-3 filter-btn" @click="resetFilters">{{ $t("reset_filter") }}</span>
                <a
                    class="nav-toggle position-relative fs-5 text-primary"
                    id="cart"
                    data-bs-target="#cartcollapse1"
                    data-bs-toggle="collapse"
                    href="#cartcollapse1"
                    role="button"
                    aria-expanded="false"
                    aria-controls="cartcollapse1"
                  >
                    <fa :icon="['fas', 'filter']" /> {{$t('filters')}}
                  </a>

                  <div
                    class="collapse collapse-menu cart-items-container"
                    id="cartcollapse1"
                    aria-labelledby="cart"
                    data-bs-parent="#navAccordion"
                  >
                    <button
                      class="btn-close"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#cartcollapse1"
                      aria-expanded="false"
                      aria-controls="cartcollapse1"
                    ></button>
                    <div class="list-head rounded cart-items-container">
                        <div class="col-sm-12 px-3">
                            <div class="pro-sec pro-filters bg-secondary">
                            <div class="filter-icon">
                                <fa :icon="['fas', 'filter']" class="fs-5 me-2" />
                                {{ $t("filters") }}
                            </div>
                            <div class="">
                                <a
                                href="#"
                                onclick="return false;"
                                class="ms-3"
                                @click="resetFilters"
                                >{{ $t("reset") }}</a
                                >
                                <a
                                href="#"
                                onclick="return false;"
                                class="ms-3"
                                @click="applyFilters"
                                >{{ $t("apply") }}</a
                                >
                            </div>
                            </div>
                            <div class="pro-sec categories-sec">
                            <a
                                class="sec-title d-flex align-items-center"
                                onclick="return false;"
                                href="#"
                            >
                                <h5>{{ $t("categories") }}</h5>
                            </a>
                            <ul>
                                <div
                                v-for="(category,index) in shopPageData.categories"
                                :key="category.id"
                                >
                                    <li
                                        :class="
                                        filterData.category == category.slug ? 'active' : ''
                                        "
                                        class="fw-bold"
                                    >
                                        <span
                                        @click="
                                            () => {
                                            filterData.category = category.slug;
                                            selected_category_name = category.name;
                                            filterData.category_id = category.id;
                                            }
                                        "
                                            class="p-0 m-0 icon-list collapsed"
                                            onclick="return false;"
                                            data-bs-toggle="collapse"
                                            :href="'#pro-product-'+index"
                                            role="button"
                                            aria-expanded="flase"
                                            aria-controls="pro-product"
                                        >
                                            <fa :icon="['fas', 'chevron-down']" class="fs-6 me-3" />{{ category.name }}
                                        </span>
                                    </li>
                                    <div v-if="category.childrens" :id="'pro-product-'+index" class="collapse list-section">
                                        <Component
                                        :is="`WebsiteTemplate1ShopPageSidebarCategoryRecursive`"
                                        @updateFilterCategorySlug="updateFilterCategorySlug"
                                        @updateFilterCategoryId="updateFilterCategoryId"
                                        @updateFilterCategoryName="updateFilterCategoryName"
                                        :subCategories="category.childrens"
                                        :filterDataCategory="filterData.category"
                                        />
                                    </div>
                                </div>
                            </ul>
                            </div>
                            <div
                            v-if="shopPageData.attributes.length>0"
                            class="pro-sec size-sec"
                            v-for="attribute in shopPageData.attributes"
                            :key="attribute.id"
                            >
                            <a
                                class="sec-title d-flex align-items-center"
                                onclick="return false;"
                                data-bs-toggle="collapse"
                                :href="`#attribute_${attribute.id}`"
                                role="button"
                                aria-expanded="true"
                                :aria-controls="`attribute_${attribute.id}`"
                            >
                                <h5>
                                <fa :icon="['fas', 'chevron-down']" class="fs-6 me-3" />{{
                                    attribute.name
                                }}
                                </h5>
                            </a>
                            <div :id="`attribute_${attribute.id}`" class="show" >
                                <div
                                class="btn-group select-opt"
                                role="group"
                                aria-label="button"
                                >
                                <div
                                    class="form-check"
                                    v-for="value in attribute.values"
                                    :key="value.id"
                                >
                                    <input
                                    type="checkbox"
                                    class="btn-check"
                                    :id="`value_${value.id}`"
                                    autocomplete="off"
                                    :value="value"
                                    v-model="filterData.attributes"
                                    />
                                    <label
                                    class="btn btn-primary s-xs"
                                    :for="`value_${value.id}`"
                                    >{{ value.name }}</label
                                    >
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="pro-sec price-product">
                            <a
                                class="sec-title d-flex align-items-center"
                                onclick="return false;"
                                data-bs-toggle="collapse"
                                href="#pro-price"
                                role="button"
                                aria-expanded="true"
                                aria-controls="pro-price"
                            >
                                <h5>
                                <fa :icon="['fas', 'chevron-down']" class="fs-6 me-3" />{{
                                    $t("price")
                                }}
                                </h5>
                            </a>
                            <div id="pro-price" class="show row g-3 mt-0">
                                <div class="col-md-6 mt-0">
                                <label class="form-check-label mb-2">{{
                                    $t("min_price")
                                }}</label>
                                <input
                                    id="min-number"
                                    type="number"
                                    class="form-control border-primary"
                                    v-model="filterData.min_price"
                                />
                                </div>
                                <div class="col-md-6 mt-0">
                                <label class="form-check-label mb-2">{{
                                    $t("max_price")
                                }}</label>
                                <input
                                    id="max-number"
                                    type="number"
                                    class="form-control border-primary"
                                    v-model="filterData.max_price"
                                />
                                </div>
                            </div>
                            </div>
                            <div
                            class="pro-sec brand-sec"
                            v-if="shopPageData.brands.length > 0"
                            >
                            <a
                                class="sec-title d-flex align-items-center"
                                onclick="return false;"
                                data-bs-toggle="collapse"
                                href="#pro-brand"
                                role="button"
                                aria-expanded="true"
                                aria-controls="pro-brand"
                            >
                                <h5>
                                <fa :icon="['fas', 'chevron-down']" class="fs-6 me-3" />{{
                                    $t("brands")
                                }}
                                </h5>
                            </a>
                            <div id="pro-brand" class="show">
                                <div class="checkbox-wrap d-flex flex-column">
                                <div
                                    v-for="brand in shopPageData.brands"
                                    :key="brand.id"
                                    class="form-check"
                                >
                                    <input
                                    type="checkbox"
                                    v-model="filterData.brands"
                                    class="form-check-input"
                                    :value="brand.id"
                                    :id="`brand_${brand.id}`"
                                    />
                                    <label
                                    class="form-check-label"
                                    :for="`brand_${brand.id}`"
                                    >{{ brand.name }}</label
                                    >
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="row" v-if="searching">
              <div class="col-md-12">
                <AdminLoader />
              </div>
            </div>
            <div class="row" v-else>
              <div class="multiselect__tags rounded" v-if="selected_filters.length > 0" >
                <span v-for="(filter, index) in selected_filters" :key="index">
                  <span class="multiselect__tag bg-primary text-white rounded tag-padding ">
                    <span>{{ filter.name }}</span> &nbsp;
                    <fa :icon="['fas', 'times']" v-on:click="deleteSelectedFilter(filter, index)" class="cross-hover"/>
                  </span>
                  &emsp;
                </span>
              </div>
              <div
                :class="grid_class"
                v-for="product in filtered_products.data"
                :key="product.id"
              >
                <Component
                  :is="`${currentlyActiveTemplate}FeaturedProductCard`"
                  :grid_class="grid_class"
                  :product="product"
                />
              </div>
              <div class="no-result pt-5" v-if="filtered_products.data.length == 0">
                <fa :icon="['fas', 'search']" />
                <h2 class="mt-5">
                  {{ $t("sorry_no_matching_results_found") }}
                </h2>
                <p class="mt-3 text-medium lead">
                  {{ $t("try_again_using_more_general_search_filters") }}
                </p>
                <button
                  type="button"
                  class="btn btn-primary"
                  name="button"
                  @click="resetFilters"
                >
                  {{ $t("reset_Filters") }}
                </button>
              </div>
            </div>
            <AdminLoader v-if="loading_more" />
            <div
              class="
                load-more-btn
                d-flex
                justify-content-center
                align-items-center
                mt-4 mb-50
              "
            >
              <button
                type="button"
                name="button"
                class="
                  btn btn-primary
                  text-uppercase
                  fw-bold
                  px-5
                  py-2
                  d-flex
                  align-items-center
                "
                @click="loadmore"
                v-if="
                  filtered_products.meta.current_page !=
                    filtered_products.meta.last_page && !searching
                "
              >
                <fa :icon="['fas', 'arrow-down']" class="me-2 fs-5" />
                {{ $t("load_more") }}
              </button>
            </div>
            <WebsiteTemplate2PermotionSection class="mb-50" />
          </div>
        </div>
      </div>
    </div>

</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  auth: false,
  data() {
    return {
      currentlyActiveTemplate: "",
      key: 1,
      grid_class: "col-lg-2 last-col-2",
      detail: "",
      seo: {},
      shopPageData: [],
      selected_category_name: "",
      filterData: {
        category: "",
        category_id: "",
        brands: [],
        attributes: [],
        page: 1,
        column: "",
        search: "",
        perPage: 10,
        sort: {
          type: "",
          field: "",
        },
        min_price: "",
        max_price: "",
      },
      selected_filters: [],
      options: [
        {
          field: "price",
          type: "ASC",
          display: this.$t("price_low_to_high"),
        },
        {
          field: "price",
          type: "DESC",
          display: this.$t("price_high_to_low"),
        },
      ],
      loading_more: false,
      searching: false,
      filtered_products: "",
    };
  },
  created() {
    this.currentlyActiveTemplate =
      this.allSettings.general_settings.currently_active_theme;
  },
  async fetch() {
    const search = this.$route.query.search;
    const category = this.$route.query.category;
    const brand = this.$route.query.brand;
    const { data } = await this.$webService.shopPageData();
    this.shopPageData = data;
    if (category || search || brand) {
      if (category) {
        this.filterData.category = category;
      }
      if (search) {
        this.filterData.search = search;
      }
      if (brand) {
        this.filterData.brands.push(brand);
      }
      const resp = await this.$webService.shopFilterProducts(this.filterData);
      this.filtered_products = resp.data;
    } else {
      const resp = await this.$webService.shopFilterProducts();
      this.filtered_products = resp.data;
    }
  },
  methods: {
    ...mapActions({
      fetchUpcomingProducts: "Web/General/fetchUpcomingProducts",
    }),
    changeGridClass(grid_class) {
      this.grid_class = grid_class;
    },
    async resetFilters() {
        const query = Object.keys(this.$route.query).length
        if (query != 0) {
         this.$router.replace("/shop");
       }
      if (
        this.filterData.category == "" &&
        this.filterData.search == "" &&
        this.filterData.brands.length == 0 &&
        this.filterData.attributes.length == 0 &&
        this.min_price == "" &&
        this.max_price == ""
      ) {
        this.$toast.success(this.$t("no_filters_selected"));
      } else {
        this.filterData.category = "";
        this.filterData.brands = [];
        this.filterData.attributes = [];
        this.filterData.search = "";
        this.filterData.min_price = "";
        this.filterData.max_price = "";
        this.selected_category_name = "";
        this.filterData.sort = {type:'',field: ''};
        this.searching = true;
        const resp = await this.$webService.shopFilterProducts();
        const { data } = await this.$webService.shopPageData();
        this.shopPageData = data;
        this.searching = false;
        this.filtered_products = resp.data;
        // if (this.filterData.category == "") {
        //   this.$router.replace("/shop");
        // }
        this.$toast.success(this.$t("all_filters_cleared"));
      }
    },
    async applyFilters() {
      if (
        this.filterData.category == "" &&
        this.filterData.category_id == "" &&
        this.filterData.search == "" &&
        this.filterData.brands.length == 0 &&
        this.filterData.attributes.length == 0 &&
        this.min_price == "" &&
        this.max_price == ""
      ) {
        this.$toast.success(this.$t("please_select_any_filters"));
      } else {
        this.searching = true;
        this.filterData.page = 1;
        const resp = await this.$webService.shopFilterProducts(this.filterData);
        const { data } = await this.$webService.shopPageData({
          category_id: this.filterData.category_id,
        });
        this.shopPageData = data;
        this.shopPageData = data;
        this.searching = false;
        this.filtered_products = resp.data;
        // if (this.filterData.category == "") {
        //   this.$router.replace("/shop");
        // }

        // Find Selected Brands Filter and push to Selected Filters Array
       await this.selectedFilterDisplay();

      }
    },
    async loadmore() {
      this.loading_more = true;
      this.filterData.page += 1;
      const { data } = await this.$webService.shopFilterProducts(
        this.filterData
      );
      this.filtered_products.data = this.filtered_products.data.concat(
        data.data
      );
      this.filtered_products.meta = data.meta;
      this.filtered_products.links = data.links;
      this.loading_more = false;
    },
    async onSearch() {
      this.searching = true;
      this.filterData.page = 1;
      const { data } = await this.$webService.shopFilterProducts(
        this.filterData
      );
      this.filtered_products.data = data.data;
      this.filtered_products.meta = data.meta;
      this.filtered_products.links = data.links;
      this.searching = false;
    },
    async onOrderChange() {
      this.searching = true;
      this.filterData.page = 1;
      const { data } = await this.$webService.shopFilterProducts(
        this.filterData
      );
      this.searching = false;
      this.filtered_products = data;
    },
    async onPerPageChange() {
      this.searching = true;
      this.filterData.page = 1;
      const { data } = await this.$webService.shopFilterProducts(
        this.filterData
      );
      this.filtered_products.data = data.data;
      this.filtered_products.meta = data.meta;
      this.filtered_products.links = data.links;
      this.searching = false;
    },
    updateFilterCategorySlug(value) {
      this.filterData.category = value;
    },
    updateFilterCategoryId(value) {
      this.filterData.category_id = value;
    },
    updateFilterCategoryName(value) {
      this.selected_category_name = value;
    },
    selectedFilterDisplay()
    {
      // Brand Filter
      for (let index = 0; index < this.filterData.brands.length; index++) {
          const brand_id = this.filterData.brands[index];
          const brand_index = this.selected_filters.findIndex(object => {
          return object.brand_id === brand_id;
        });
        if (brand_index > -1) {

        }
        else
        {
            let obj = this.shopPageData.brands.find(
                  (brand) => brand.id === brand_id
                );
                this.selected_filters.push({
                  name: obj.name,
                  slug: obj.name,
                  brand_id: obj.id,
                  type: "brand"
                });
        }
        }
         // Attribute Filter
        for (
          let index = 0;
          index < this.filterData.attributes.length;
          index++
        ) {
          const attribute = this.filterData.attributes[index];
              const attribute_index = this.selected_filters.findIndex(object => {
          return object.slug === attribute.slug;
        });

        if (attribute_index > -1) {

        }
        else
        {
            this.selected_filters.push({
            name: attribute.name,
            slug: attribute.slug,
            type: "attribute"
          });
        }

        }
    },
    async deleteSelectedFilter(filterObj, filterIndex)
    {

        this.selected_filters.splice(filterIndex, 1);

      if(filterObj.type == "category")
      {
        this.filterData.category = ""
        this.filterData.category_id = ""
        this.selected_category_name= ""
      }
      if(filterObj.type == "brand")
      {
       let index =  this.filterData.brands.indexOf(filterObj.brand_id)
         this.filterData.brands.splice(index, 1);
          await this.applyFilters();
      }
      if(filterObj.type == "attribute")
      {
          for (let index = 0; index < this.filterData.attributes.length; index++) {
              const element = this.filterData.attributes[index];
              if(element.slug === filterObj.slug)
              {
                  this.filterData.attributes.splice(index, 1);
              }
          }
          await this.applyFilters();
      }
    },
       externalClick(event) {
        var closeElement =document.getElementById("cartcollapse1");
            closeElement.classList.remove("show");

    },
  },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
    shopSearch() {
      return this.$store.state.Web.General.shopSearch;
    },
  },
  mounted() {},
  watch: {
    shopSearch() {
      if (this.shopSearch) {
        this.filterData.search = this.shopSearch;
      }
      this.applyFilters();
    },

    "$route.query.category": {
      handler: function (after, before) {
        this.filterData.category = after;
        this.applyFilters();
      },
      deep: true,
    },
    "filterData.category": {
      handler: async function (after, before) {
        this.filterData.brands = [];
        this.filterData.attributes = [];
        this.selected_filters = []
          if (this.selected_category_name != "") {
             this.selected_filters.push({
          name: this.selected_category_name,
          slug: after,
          type: "category"
        });
          }



        await this.applyFilters();
      },
      deep: true,
    }
  },
};
</script>
<style>
.tag-padding{
padding: 0px 15px !important;
}
.multiselect__tags {
    min-height: 40px;
    display: block;
    padding: 8px 40px 0 8px;
    border-radius: 5px;
    border: 1px solid #e8e8e8;
    background: #fff;
    font-size: 14px;
}
.cross-hover:hover{
    background: transparent;
    padding: 2px;
    font-size: 14px;
}
</style>
