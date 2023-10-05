<template>
  <section v-if="$fetchState.pending">
    <WebsiteGlobalComponentsBreadCrumb :page="`wishlist`" />
    <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}WishList`" />
  </section>
  <section v-else class="wishlist-page m-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`wishlist`" />
    <div class="container">
      <div class="row review-girds mb-50">
        <div class="col-12">
          <div v-if="this.wishlist_products.data.length == 0">
            <Component :is="`Website${currentlyActiveTemplate}WishlistEmpty`" />
          </div>
          <div v-else class="grig-list-nav d-flex justify-content-between mb-3 mt-5 bg-secondary mt-100 mb-50">
            <WebsiteGlobalComponentsGrigListView
              :grid_class="grid_class"
              @changeGridClass="changeGridClass"
            />
            <!-- <div class="dropdown-fild per-page-item">
              <label for="item-per-page" class="form-label text-medium me-2">Items per page</label>
              <select v-model="pagination.perPage" @change="onPerPageChange" class="form-select " id="item-per-page" aria-describedby="item-per-pageFeedback" placeholder="1" required>
                <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>
                <option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option>
                <option value="9">9</option><option value="10">10</option>
              </select>
            </div> -->
          </div>
        </div>
        <div
          :class="grid_class"
          v-for="product in wishlist_products.data"
          :key="product.id"
        >
          <!-- <Template1WishlistProductCard :grid_class="grid_class"  @removeWishlistItem="removeWishlistItem"  :product="product"  /> -->
          <Component
            :is="`${currentlyActiveTemplate}WishlistProductCard`"
            grid_class="grid_class"
            @removeWishlistItem="removeWishlistItem"
            :product="product"
          />
        </div>
        <div class="col-12 text-center">
          <AdminLoader v-if="loading_more" />

          <button
            type="button"
            class="btn btn-primary px-3 py-2"
            name="button"
            @click="loadmore"
            v-if="
              wishlist_products.meta.current_page !=
              wishlist_products.meta.last_page
            "
          >
            {{$t('load_more')}}
          </button>
        </div>
      </div>
    </div>
    <WebsiteTemplate1NewsLetterSection />
  </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  middleware: "customer",
  data() {
    return {
      currentlyActiveTemplate: "",
      key: 1,
      detail: "",
      grid_class: "col-lg-2 last-col-2",
      seo: {},
      loading_more: false,
      searching: false,
      wishlist_products: "",
      pagination: {
        page: 1,
        column: "",
        search: "",
        perPage: 10,
        sort: {
          type: "",
          field: "",
        },
      },
    };
  },
  created() {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme;
  },
  head() {
    return this.seo;
  },
  async fetch() {
    if (!this.allWishlistItems) {
      await this.fetchWishlistItems();
    }
    this.wishlist_products = { ...this.allWishlistItems };
    this.pagination.perPage = this.wishlist_products.meta.per_page;
  },
  methods: {
    ...mapActions({
      fetchWishlistItems: "Web/Wishlist/fetchWishlistItems",
    }),
    changeGridClass(grid_class) {
      this.grid_class = grid_class;
    },
    async loadmore() {
      this.loading_more = true;
      this.pagination.page += 1;
      const { data } = await this.$webService.fetchWishlistItems(
        this.pagination
      );
      this.wishlist_products.data = this.wishlist_products.data.concat(
        data.data
      );
      this.wishlist_products.meta = data.meta;
      this.wishlist_products.links = data.links;
      this.loading_more = false;
    },
    async onSearch() {
      this.searching = true;
      this.pagination.page = 1;
      const { data } = await this.$webService.fetchWishlistItems(
        this.pagination
      );
      this.wishlist_products.data = data.data;
      this.wishlist_products.meta = data.meta;
      this.wishlist_products.links = data.links;
      this.searching = false;
    },
    async onOrderChange() {
      this.searching = true;
      this.pagination.page = 1;
      const { data } = await this.$webService.fetchWishlistItems(
        this.pagination
      );
      this.wishlist_products.data = data.data;
      this.wishlist_products.meta = data.meta;
      this.wishlist_products.links = data.links;
      this.searching = false;
    },
    async onPerPageChange() {
      this.searching = true;
      this.pagination.page = 1;
      const { data } = await this.$webService.fetchWishlistItems(
        this.pagination
      );
      this.wishlist_products.data = data.data;
      this.wishlist_products.meta = data.meta;
      this.wishlist_products.links = data.links;
      this.searching = false;
    },
    async removeWishlistItem() {
      await this.fetchWishlistItems();
      this.wishlist_products = { ...this.allWishlistItems };
      this.pagination.perPage = this.wishlist_products.meta.per_page;
    },
  },
  computed: {
    ...mapGetters({
      allWishlistItems: "Web/Wishlist/allWishlistItems",
      allSettings: "allDefaultSettings",
    }),
  },
};
</script>

<style>
</style>
