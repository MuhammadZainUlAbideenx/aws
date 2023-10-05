<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.product.view_product") }}
          </h2>
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
                <nuxt-link :to="localePath('/admin/products')">{{
                  this.$t("sidebar.product")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.product.view_product") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.product.view_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div v-if="$fetchState.pending">
        <AdminViewImageLoader :multilang="true" />
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div class="col-sm-12">
                      <div role="group" class="admin-product-slider">
                        <label for="input-live form-label">{{
                          this.$t("form.product.image.label")
                        }}</label>
                        <div
                          class="slider-placeholder"
                          v-if="product && product.media.length <= 0"
                        >
                          <img
                            class="hero-img d-block w-100 h-100"
                            src="~/assets/images/placeholder.png"
                            alt=""
                          />
                        </div>
                        <VueSlickCarousel
                          v-if="product && product.media.length > 0"
                          v-bind="settings"
                          class="my-3"
                        >
                          <div
                            class="
                              d-flex
                              align-items-center
                              justify-content-center
                            "
                            v-for="product_media in product.media"
                            :key="product_media.id"
                          >
                            <img
                              v-bind:src="
                                url + `${product_media.original_media_path}`
                              "
                              class="product-img d-block"
                              alt="..."
                            />
                          </div>
                        </VueSlickCarousel>
                      </div>
                    </div>

                    <div class="row">
                      <div class="show-table px-0">
                        <div class="row justify-content-end">
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.product.available_date.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>{{ product.available_date_display }}</p>
                          </div>

                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.product.price.label")
                            }}</label>
                          </div>
                          <div class="col-6" v-if="product.special_sale">
                            <p>{{ product.special_sale.display_price }}</p>
                              <span class="text-decoration-line-through text-danger">
                        {{ product.display_price}}
                      </span>
                          </div>
                          <div class="col-6" v-else-if="product.flash_sale">
                            <p>{{ product.flash_sale.display_price }}</p>
                            <span class="text-decoration-line-through text-danger">
                        {{ product.display_price}}
                      </span>
                          </div>
                          <div class="col-6" v-else-if="product.product_type == 2">
                            <p>{{ product.starting_from_price }}</p>
                          </div>
                           <div class="col-6" v-else>
                            <p>{{ product.display_price }}</p>
                          </div>
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.product.stock.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>{{ product.stock }}</p>
                          </div>

                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.product.status.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <div class="form-switch">
                              <input
                                class="form-check-input"
                                :checked="product.is_active ? 'checked' : ''"
                                type="checkbox"
                                id="flexSwitchCheckChecked"
                                disabled
                              />
                            </div>
                          </div>

                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.product.is_feature.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <div class="form-switch">
                              <input
                                class="form-check-input"
                                :checked="product.is_feature ? 'checked' : ''"
                                type="checkbox"
                                id="flexSwitchCheckChecked"
                                disabled
                              />
                            </div>
                          </div>

                          <div class="row px-0" v-if="product.flash_sale">
                            <div class="col-6">
                              <label for="input-live " class="form-label">
                                {{
                                  this.$t(
                                    "form.product.special_sale.special_price.label"
                                  )
                                }}</label
                              >
                            </div>
                            <div class="col-6">
                              <p>{{ product.flash_sale.display_price }}</p>
                            </div>

                            <div class="col-6">
                              <label for="input-live " class="form-label">
                                {{
                                  this.$t(
                                    "form.product.special_sale.expire_date.label"
                                  )
                                }}</label
                              >
                            </div>
                            <div class="col-6">
                              <p>{{ product.flash_sale.expire_date }}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div class="show-table">
                      <div class="row justify-content-end">
                        <div class="col-6">
                          <label for="input-live " class="form-label">{{
                            this.$t("form.product.product_type.label")
                          }}</label>
                        </div>
                        <div class="col-6" v-if="product.product_type == 1">
                          <p>{{
                            this.$t("simple_product")
                          }}</p>
                        </div>
                        <div class="col-6" v-if="product.product_type == 2">
                          <p>{{
                            this.$t("variable_product")
                          }}</p>
                        </div>
                        <div class="col-6">
                          <label for="input-live " class="form-label">{{
                            this.$t("form.product.manufacturer.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p v-if="product.manufacturer">
                            {{ product.manufacturer.name }}
                          </p>
                          <p v-else>-</p>
                        </div>

                        <div
                          class="col-6"
                          v-if="
                            $auth.strategy.options.name == 'admin' &&
                            allActiveSettings &&
                            allActiveSettings.settings &&
                            allActiveSettings.settings.generalSettings &&
                            allActiveSettings.settings.generalSettings
                              .is_multi_vendor == '1' &&
                            product.vendor
                          "
                        >
                          <label for="input-live " class="form-label">{{
                            this.$t("form.product.vendor.label")
                          }}</label>
                        </div>
                        <div
                          class="col-6"
                          v-if="
                            $auth.strategy.options.name == 'admin' &&
                            allActiveSettings &&
                            allActiveSettings.settings &&
                            allActiveSettings.settings.generalSettings &&
                            allActiveSettings.settings.generalSettings
                              .is_multi_vendor == '1' &&
                            product.vendor
                          "
                        >
                          <p>
                            {{ product.vendor.name }}
                          </p>
                        </div>

                        <div class="col-6">
                          <label for="input-live " class="form-label">{{
                            this.$t("form.product.categories.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <div class="d-flex flex-wrap justify-content-between">
                            <p
                              v-if="product.categories_res"
                              class="pe-5"
                              v-for="category in product.categories_res"
                              :key="category"
                            >
                              {{ category.name }}
                            </p>
                            <p v-else class="pe-5">-</p>
                          </div>
                        </div>

                        <div class="col-6">
                          <label for="input-live " class="form-label">{{
                            this.$t("form.product.tax_class.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p v-if="product.tax_class">
                            {{ product.tax_class.name }}
                          </p>
                          <p v-else>-</p>
                        </div>

                        <div class="col-6">
                          <label for="input-live " class="form-label">{{
                            this.$t("form.product.min_order.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p>{{ product.min_order }}</p>
                        </div>
                        <div class="col-6">
                          <label for="input-live " class="form-label">{{
                            this.$t("form.product.max_order.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p>{{ product.max_order }}</p>
                        </div>

                        <div class="col-6">
                          <label for="input-live " class="form-label">{{
                            this.$t("form.product.product_weight.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p>{{ product.weight }}</p>
                        </div>

                        <div class="col-6">
                          <label for="input-live " class="form-label">{{
                            this.$t("form.product.shipping_weight.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p>{{ product.shipping_weight }}</p>
                        </div>

                        <div class="col-6">
                          <label for="input-live " class="form-label">{{
                            this.$t("form.product.unit.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p v-if="product.unit">{{ product.unit.name }}</p>
                          <p v-else>-</p>
                        </div>

                        <div v-if="product.product_type == 1" class="d-inline-flex">
                            <div class="col-6">
                          <label for="input-live " class="form-label">{{
                            this.$t("form.product.flash_sale.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="product.flash_sale ? 'checked' : ''"
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                              disabled
                            />
                          </div>
                        </div>
                        </div>

                        <div v-if="product.product_type == 1" class="d-inline-flex">
                             <div class="col-6">
                          <label for="input-live " class="form-label">
                            {{
                              this.$t("form.product.special_sale.label")
                            }}</label
                          >
                        </div>
                        <div class="col-6">
                          <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="product.special_sale ? 'checked' : ''"
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                              disabled
                            />
                          </div>
                        </div>
                        </div>



                        <div class="row px-0" v-if="product.flash_sale">
                          <div class="col-6">
                            <label for="input-live " class="form-label">
                              {{
                                this.$t(
                                  "form.product.flash_sale.flash_sale_price.label"
                                )
                              }}</label
                            >
                          </div>
                          <div class="col-6">
                            <p>{{ product.flash_sale.display_price }}</p>
                          </div>

                          <div class="col-6">
                            <label for="input-live " class="form-label">
                              {{
                                this.$t(
                                  "form.product.flash_sale.start_date.label"
                                )
                              }}</label
                            >
                          </div>
                          <div class="col-6">
                            <p>{{ product.flash_sale.start_date }}</p>
                          </div>

                          <div class="col-6">
                            <label for="input-live " class="form-label">
                              {{
                                this.$t(
                                  "form.product.flash_sale.expire_date.label"
                                )
                              }}</label
                            >
                          </div>
                          <div class="col-6">
                            <p>{{ product.flash_sale.expire_date }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row" v-if="product.product_type == 2">
                    <div v-if="product.attributes.length > 0">
                      <div class="col-2">
                            <label for="input-live " class="form-label">
                              <b>{{ this.$t("variants")}}: </b> </label>
                        </div>
                        <div class="col-10">
                           <span  class="mb-3 d-inline-block w-100" v-for="(attribute,index) in product.attributes" :key="index"><b class="d-block mb-2">{{attribute.name}}:</b>

                                <span class="px-2 py-1 border me-2" v-for="(value,index) in attribute.values" :key="index" >
                                    {{value.name}}
                                    <span v-if="index < attribute.values.length-1 ">,</span>
                                </span>
                                <br/>
                           </span>
                        </div>
                        </div>
                        <div v-else>

                        </div>
                </div>
                <hr class="text-primary" />
                <div class="row w-100">
                  <div class="col-lg-12 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">
                        {{ $t("form.multilanguage") }}
                      </h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.product.form_description") }}
                        </span>
                      </p>
                    </div>
                    <div class="d-md-flex">
                      <div class="row">
                        <div class="col-md-12 px-0">
                          <ul
                            class="nav nav-tabs px-0"
                            id="myTab"
                            role="tablist"
                          >
                            <li
                              class="nav-item"
                              role="presentation"
                              v-for="(
                                language, index
                              ) in allActiveLanguages.languages"
                              :key="index"
                            >
                              <a
                                class="nav-link"
                                :class="index == 0 ? 'active' : ''"
                                :id="language.code + '-tab'"
                                data-bs-toggle="tab"
                                :href="'#' + language.code"
                                role="tab"
                                :aria-controls="language.code"
                                :aria-selected="index == 0 ? 'true' : 'false'"
                                >{{ language.name }}</a
                              >
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="row w-100">
                        <div class="col-lg-12 px-0">
                          <div class="">
                            <div class="">
                              <div class="tab-content p-4" id="myTabContent">
                                <div
                                  class="tab-pane fade"
                                  :class="index == 0 ? 'active show' : ''"
                                  v-for="(
                                    language, index
                                  ) in allActiveLanguages.languages" :key="index"
                                  :id="language.code"
                                  role="tabpanel"
                                  :aria-labelledby="language.code + '-tab'"
                                >
                                  <div class="row">
                                    <div class="col-md-6 my-1">
                                      <div role="group ">
                                        <div role="group">
                                          <label for="input-live form-label">{{
                                            $t("form.product.name.label")
                                          }}</label>
                                          <div
                                            class="
                                              py-3
                                              px-3
                                              rounded
                                              shadow-sm
                                              border
                                              mt-2
                                              show-input
                                            "
                                          >
                                            {{
                                              product.nameTranslations[
                                                language.code
                                              ]
                                            }}
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                     <div class="col-md-12 my-1">
                                      <div role="group ">
                                        <div role="group">
                                          <label for="input-live form-label">{{
                                            $t("form.product.short_description.label")
                                          }}</label>
                                          <div
                                            class="
                                              py-3
                                              px-3
                                              shadow-sm
                                              rounded
                                              border
                                              mt-2
                                              show-text-area
                                            "
                                            v-html="
                                              product.shortDescriptionTranslations[
                                                language.code
                                              ]
                                            "
                                          ></div>
                                        </div>
                                      </div>
                                    </div>

                                  </div>
                                   <div class="row">
                                    <div class="col-md-12 my-1">
                                      <div role="group ">
                                        <div role="group">
                                          <label for="input-live form-label">{{
                                            $t("form.product.description.label")
                                          }}</label>
                                          <div
                                            class="
                                              py-3
                                              px-3
                                              shadow-sm
                                              rounded
                                              border
                                              mt-2
                                              show-text-area
                                            "
                                            v-html="
                                              product.descriptionTranslations[
                                                language.code
                                              ]
                                            "
                                          ></div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                    <div class="row">
                                    <div class="col-md-12 my-1" v-if="product.refundPolicyTranslations[
                                                language.code
                                              ]">
                                      <div role="group ">
                                        <div role="group">
                                          <label for="input-live form-label">{{
                                            $t("form.product.refund_policy.label")
                                          }}</label>
                                          <div
                                            class="
                                              py-3
                                              px-3
                                              shadow-sm
                                              rounded
                                              border
                                              mt-2
                                              show-text-area
                                            "
                                            v-html="
                                              product.refundPolicyTranslations[
                                                language.code
                                              ]
                                            "
                                          ></div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "products.index",
    strategy: "read",
  },
  data() {
    return {
      settings: {
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 1,
            },
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
            },
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 2,
            },
          },
        ],
      },
      url: "/backend",
      product: "",
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.products.show(
      this.$route.params.id
    );
    this.product = data;
  },
  methods: {},
  mounted() {},
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
      allActiveSettings: "General/allActiveSettings",
    }),
  },
};
</script>
