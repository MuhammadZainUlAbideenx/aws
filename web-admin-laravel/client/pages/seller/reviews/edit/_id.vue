<template >
  <div class="" v-if="!this.$auth.user.store">
    <SellerShopSettings />
  </div>
  <div class="" v-else-if="!this.$auth.user.is_active">
    <SellerShopDeactive />
  </div>
  <div class="" v-else>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.review.edit_review") }}
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
                  <nuxt-link :to="localePath('/seller/reviews')">{{ this.$t("sidebar.review") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.review.edit_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Main content -->
        <section class="content pb-5">
      <div v-if="$fetchState.pending">
         <AdminFormLoader/>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0" >
                    <div role="group ">
                      <label for="input-live" class="  form-label">{{ $t("form.review.customer.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['customer_id']">
                          {{ error.customer_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.customer_id ? 'error' : ''" apiMethod="activeCustomers" responseKey="customers"
                          :initialOptions="allActiveCustomersSeller" :selectedOptions="selected_customer" :placeholder="$t('form.review.customer.placeholder')" v-model="formData.customer_id" />
                      <span class="  heebo-light">
                          {{ $t("form.review.customer.subheading") }}
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0" >
                    <div role="group ">
                      <label for="input-live" class="  form-label">{{ $t("form.review.product.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['product_id']">
                          {{ error.product_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.product_id ? 'error' : ''" apiMethod="activeProducts" responseKey="products"
                          :initialOptions="allActiveProductsSeller" :selectedOptions="selected_product" :placeholder="$t('form.review.product.placeholder')" v-model="formData.product_id" />
                      <span class="  heebo-light">
                          {{ $t("form.review.product.subheading") }}
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0" >
                    <div role="group ">
                      <label for="input-live" class="  form-label">{{ $t("form.review.set_status.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['review_status_id']">
                          {{ error.review_status_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.review_status_id ? 'error' : ''" apiMethod="activeReviewStatuses" responseKey="review_statuses"
                          :initialOptions="allActiveReviewStatuses.review_statuses" :selectedOptions="selected_review_status" :placeholder="$t('form.review.set_status.placeholder')" v-model="formData.review_status_id" />
                      <span class="  heebo-light">
                          {{ $t("form.review.customer.subheading") }}
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.review.description.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.description">
                          {{ error.description[0] }}
                        </span>
                      <textarea class="form-control" :placeholder="this.$t('form.admin.description.placeholder')"  v-model="formData.description" aria-describedby="input-live-help input-live-feedback" rows="8" cols="50"></textarea>
                             <span class="heebo-light">
                                 {{ $t("form.review.description.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.review.rating.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.rating">
                          {{ error.rating[0] }}
                        </span>
                      <input :class="error && error.rating ? 'error' : ''"
                             class="form-control"
                             type="number"
                             maxlength="5.0"
                             minlength="0.0"
                             v-model="formData.rating"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.review.rating.placeholder')"
                             trim />
                             <span class=" heebo-light">
                                 {{ $t("form.review.rating.subheading") }}
                             </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                     <div class="col-md-6 my-1 mb-3 ps-md-0">
                  <div class="d-flex align-items-center ">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.review.status.label") }}
                      </label>

                      <div class="form-switch">
                        <input class="form-check-input"
                                v-model="formData.is_active"
                              :checked="formData.is_active ? 'checked' : ''"
                              type="checkbox"
                              id="flexSwitchCheckChecked" />
                      </div>
                  </div>
                  <span class=" heebo-light">
                      {{ $t("form.review.status.subheading") }}
                    </span>
                </div>
                </div>


              </div>
            </div>
           <div class="row">
                  <div class="col-md-12 px-4 text-center text-md-end">
                    <button type="button" :disabled="disabled"
                            class="btn btn-secondary mb-3 px-3 py-2"
                            @click="update"
                            name="button">
                        {{ this.$t("form.update") }}
                      </button>
                    <!-- <button type="button" :disabled="disabled"
                            class="btn btn-success mb-3"
                            @click="updateAndContinue"
                            name="button">
                        {{ this.$t("form.update_and_continue") }}
                      </button> -->
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
    layout: 'vendor',
    middleware: ['vendor'],
    meta: {

      strategy: 'update'
    },
    data() {
      return {
        selected_customer:'',
        selected_product:'',
        selected_review_status:'',
        formData: {
          customer_id: '',
          product_id:'',
          review_status_id:'',
          description: '',
          rating: '',
          is_active: false,
        },
        disabled:false,
        error: false
      }
    },
    async fetch() {
        await this.fetchActiveProductsSeller();
        await this.fetchActiveCustomersSeller();
        await this.fetchActiveReviewStatuses();
        const { data } = await this.$sellerRepositories.reviews.show(this.$route.params.id)
        this.formData.description = data.description
        this.formData.rating = data.rating
        this.formData.customer_id = data.customer.id
        this.selected_customer = data.customer
        this.selected_product = data.product
        this.formData.product_id = data.product.id
        this.formData.review_status_id = data.review.id
        this.selected_review_status = data.review

        this.formData.is_active = data.is_active
    },
    methods: {
      ...mapActions({
        updateReviews: 'Seller/Reviews/updateReviews',
        fetchActiveReviews: 'General/fetchActiveReviews',
        fetchActiveReviewStatuses: 'General/fetchActiveReviewStatuses',
        fetchActiveProductsSeller: 'General/fetchActiveProductsSeller',
        fetchActiveCustomersSeller: 'General/fetchActiveCustomersSeller',
      }),
      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/seller/reviews'))
        }
      },
      async updateAndContinue() {
             this.disabled=true
        await this.updateReviews({
          formData: this.formData,
          id: this.$route.params.id
        }).then(res => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data
            this.$toast.error(res.response.data.message)

          } else if (res.state == 'fail') {
            this.$toast.error(res.message)
          } else {
            this.error = false
            this.$toast.success(res.message)
            this.fetchActiveReviews();
          }
        });
           this.disabled=false
      }
    },
    computed: {
      ...mapGetters({
        allActiveProducts: 'General/allActiveProducts',
        allActiveProductsSeller: 'General/allActiveProductsSeller',
        allActiveCustomersSeller: 'General/allActiveCustomersSeller',
        allActiveReviewStatuses: 'General/allActiveReviewStatuses',
      })
    },
    mounted() {}
  }

</script>
