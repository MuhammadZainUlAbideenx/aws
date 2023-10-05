<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.coupon.view_coupon") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{ this.$t("sidebar.home") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/coupons')">{{ this.$t("sidebar.coupon") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.view") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.coupon.view_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>

     <!-- Main content -->
    <section class="content">
      <div  v-if="$fetchState.pending">
       <AdminViewLoader :multilang='true' />
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 my-1  px-md-0">

                       <div class="show-table mb-3">
                <div class="row justify-content-end">
                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.code.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ coupon.code }}</p></div>

                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.discount_type.label")
                      }}</label>
                  </div>
                  <div class="col-3" v-if="coupon.discount_type == 1"><p>{{this.$t("form.coupon.discount_type.cart_discount") }}</p></div>
                  <div class="col-3" v-if="coupon.discount_type == 2"><p>{{ this.$t("form.coupon.discount_type.cart_percentage_discount")}}</p></div>

                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.amount.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ coupon.amount_index }}</p></div>

                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.expiry_date.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ coupon.display_expiry_date }}</p></div>

                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.minimum_spend.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ coupon.display_minimum_spend }}</p></div>
                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.maximum_spend.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ coupon.display_maximum_spend }}</p></div>


                  <!-- <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.products.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p v-for="products in coupon.products" :key="products.id">{{ products.name }} <br> </p></div> -->

                   <!-- <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.categories.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p v-for="categories in coupon.categories" :key="categories.id">{{ categories.name }} <br> </p></div> -->

                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.email_restrictions.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ coupon.email }}</p></div>


                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.usage_limit.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ coupon.usage_limit }}</p></div>

                    <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.user_limit.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ coupon.user_limit }}</p></div>

                    <div class="col-3" v-if="coupon.vendor">
                      <label for="input-live form-label">{{
                        this.$t("form.coupon.vendor.label")
                      }}</label>
                  </div>
                  <div class="col-3" v-if="coupon.vendor"><p>{{ coupon.vendor.name }}</p></div>

                  <div class="col-3">
                      <label class="label form-label pe-4">
                          {{ this.$t("form.coupon.status.label") }}
                        </label>
                  </div>
                  <div class="col-3">  <div class="form-switch">
                          <input
                            class="form-check-input"
                            :checked="coupon.is_active ? 'checked' : ''"
                            type="checkbox"
                            id="flexSwitchCheckChecked"
                            disabled
                          />
                        </div>
                    </div>
                      <div class="col-3">
                      <label class="label form-label pe-4">
                          {{ this.$t("form.coupon.is_featured.label") }}
                        </label>
                  </div>
                  <div class="col-3">  <div class="form-switch">
                          <input
                            class="form-check-input"
                            :checked="coupon.is_featured ? 'checked' : ''"
                            type="checkbox"
                            id="flexSwitchCheckChecked"
                            disabled
                          />
                        </div>
                    </div>
                        <div class="col-3">
                      <label class="label form-label pe-4">
                          {{ this.$t("form.coupon.free_shipping.label") }}
                        </label>
                  </div>
                  <div class="col-3">  <div class="form-switch">
                          <input
                            class="form-check-input"
                            :checked="coupon.free_shipping ? 'checked' : ''"
                            type="checkbox"
                            id="flexSwitchCheckChecked"
                            disabled
                          />
                        </div></div>

                        <div class="col-3">
                      <label class="label form-label pe-4">
                          {{ this.$t("form.coupon.individual_use.label") }}
                        </label>
                  </div>
                  <div class="col-3">  <div class="form-switch">
                          <input
                            class="form-check-input"
                            :checked="coupon.individual_use? 'checked' : ''"
                            type="checkbox"
                            id="flexSwitchCheckChecked"
                            disabled
                          />
                        </div></div>

                        <div class="col-3">
                      <label class="label form-label pe-4">
                          {{ this.$t("form.coupon.exclude_sale_items.label") }}
                        </label>
                  </div>
                  <div class="col-3">  <div class="form-switch">
                          <input
                            class="form-check-input"
                            :checked="coupon.exclude_sale_items? 'checked' : ''"
                            type="checkbox"
                            id="flexSwitchCheckChecked"
                            disabled
                          />
                        </div></div>
                </div>
                       </div>


                  </div>
                </div>
                 <!-- <hr class="text-primary"> -->
                <div class="row w-100">
                  <div class="col-lg-12 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">
                        {{ $t("form.multilanguage") }}
                      </h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.coupon.subheading") }}
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
                                  ) in allActiveLanguages.languages"
                                  :id="language.code"
                                  role="tabpanel"
                                  :aria-labelledby="language.code + '-tab'"
                                >
                                  <div class="row">
                                    <div class="col-md-12 my-1">
                                      <div role="group ">
                                        <div role="group">
                                          <label for="input-live"  class=" form-label">{{
                                            $t(
                                              "form.coupon.description.label"
                                            )
                                          }}</label>
                                          <div
                                            class="py-3 px-3 shadow-sm rounded border mt-2 show-text-area"
                                            v-html="
                                              coupon
                                                .descriptionTranslations[
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

  import { mapGetters, mapActions } from 'vuex'
  export default {
    layout: 'admin',
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'coupons.index',
      strategy: 'read'
    },
    data() {
      return {
        coupon: '',
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.coupons.show(this.$route.params.id)
      this.coupon = data
    },
    methods: {},
    mounted() {},
    computed:{
    ...mapGetters({
      allActiveLanguages: 'General/allActiveLanguages',
    })
  }
  }

</script>
