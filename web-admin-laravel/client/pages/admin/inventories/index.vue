<template >

  <div >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.inventory.inventory") }}
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
                  <nuxt-link :to="localePath('/admin/media/')">{{ this.$t("sidebar.media") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("sidebar.inventory") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.inventory.form_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content pb-5">
      <div class="container" v-if="$fetchState.pending">
        <div class="row">
          <div class="col-md-12">
            <AdminLoader />
          </div>
        </div>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0" >
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.inventory.product.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.large_thumbnail_width">
                          {{ error.large_thumbnail_width[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.product_id ? 'error' : ''" apiMethod="activeProducts" responseKey="products"
                          :initialOptions="allActiveProducts.products" :placeholder="$t('form.inventory.product.placeholder')" v-model="formData.product_id" v-on:input="getProductInventory($event)" />
                     <span class="px-2 heebo-light">
                         {{ $t("form.inventory.product.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.inventory.total_purchase_price.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.total_purchase_price">
                          {{ error.total_purchase_price[0] }}
                        </span>
                        <p> {{ total_purchase_price }} </p>
                     <span class="px-2 heebo-light">
                         {{ $t("form.inventory.total_purchase_price.subheading") }}
                     </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.inventory.current_stock.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.current_stock">
                          {{ error.current_stock[0] }}
                        </span>
                        <p> {{ current_stock }} </p>
                     <span class="px-2 heebo-light">
                         {{ $t("form.inventory.current_stock.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.inventory.purchase_price.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.purchase_price">
                          {{ error.purchase_price[0] }}
                        </span>
                        <p> {{ formData.purchase_price }} </p>
                     <span class="px-2 heebo-light">
                         {{ $t("form.inventory.purchase_price.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.inventory.min_level.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.min_level">
                          {{ error.min_level[0] }}
                        </span>
                        <input :class="error && error.min_level ? 'error' : ''"
                               class="form-control"
                               v-model="formData.min_level"
                               aria-describedby="input-live-help input-live-feedback"
                               :placeholder="this.$t('form.inventory.min_level.placeholder')"
                               trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.inventory.min_level.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.inventory.max_level.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.max_level">
                          {{ error.max_level[0] }}
                        </span>
                        <input :class="error && error.max_level ? 'error' : ''"
                               class="form-control"
                               v-model="formData.max_level"
                               aria-describedby="input-live-help input-live-feedback"
                               :placeholder="this.$t('form.inventory.max_level.placeholder')"
                               trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.inventory.max_level.subheading") }}
                     </span>
                    </div>
                  </div>
                </div>
                <div class="row" v-if='formData.product_type == 1 || formData.product_type == 3 || formData.product_type == 4'>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.inventory.stock.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.stock">
                          {{ error.stock[0] }}
                        </span>
                        <input :class="error && error.min_level ? 'error' : ''"
                               class="form-control"
                               v-model="formData.stock"
                               aria-describedby="input-live-help input-live-feedback"
                               :placeholder="this.$t('form.inventory.stock.placeholder')"
                               trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.inventory.current_stock.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.inventory.purchase_price.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.purchase_price">
                          {{ error.purchase_price[0] }}
                        </span>
                        <input :class="error && error.min_level ? 'error' : ''"
                               class="form-control"
                               v-model="formData.purchase_price"
                               aria-describedby="input-live-help input-live-feedback"
                               :placeholder="this.$t('form.inventory.purchase_price.placeholder')"
                               trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.inventory.purchase_price.subheading") }}
                     </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.inventory.refrence_number.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.refrence_number">
                          {{ error.refrence_number[0] }}
                        </span>
                        <input :class="error && error.refrence_number ? 'error' : ''"
                               class="form-control"
                               v-model="formData.refrence_number"
                               aria-describedby="input-live-help input-live-feedback"
                               :placeholder="this.$t('form.inventory.refrence_number.placeholder')"
                               trim />
                     <span class="px-2 heebo-light">
                         {{ $t("form.inventory.refrence_number.subheading") }}
                     </span>
                    </div>
                  </div>
                </div>
                <div class="row" v-else-if='formData.product_type == 2'>
                  Type 2 Variable

                </div>
                <div class="row" else>

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row" v-permission="'inventories.update'">
                  <div class="col-md-12 px-4 text-center text-md-end">
                    <button type="button"
                            class="btn btn-primary mb-3 px-3 py-2"
                            @click="update(false)"
                            name="button">
                        {{ this.$t("form.update") }}
                      </button>
                  </div>
                </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

</template>
<script >
// import CkeditorNuxt from "@/components/global/ckeditorNuxt";
  import { mapGetters, mapActions } from 'vuex'
  export default {
    layout: 'admin',
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'inventories.update',
      strategy: 'update'
    },
    async fetch(){
      if(!this.allActiveProducts.products){
        await this.fetchActiveProducts();
      }
    },
    data() {
      return {
        current_stock:'',
        total_purchase_price:'',
        product:'',
        formData:{
          stock:'',
          product_id:'',
          min_level:'',
          max_level:'',
          purchase_price:'',
          refrence_number:'',
        },
        error: false
      }
    },
    methods: {
      ...mapActions({
        addInventories: 'Inventories/addInventories',
        fetchActiveProducts: 'General/fetchActiveProducts',
      }),
      async update() {
        await this.addInventories(this.formData)
        .then(
            res => {
              if (res.response) {
                this.error = res.response.data.errors ?? res.response.data
                this.$toast.error(res.response.data.message)
              } else {
                this.error = false
                this.$toast.success(res.message)
              }
            })
          },
          async getProductInventory(e){
            const data = await this.$generalService.getProductInventory(e);
            if(data.product){
              this.product = data.product
            }
            if(data.productInventory.productInventory && data.productInventory.productInventory !=null){
            //  this.current_stock = data.productInventory.productInventory[0].stock

              this.total_purchase_price = data.productInventory.productInventory.total_purchase_price
              this.formData.min_level = data.productInventory.productInventory.min_level
              this.formData.max_level = data.productInventory.productInventory.max_level
              this.formData.reference_number = data.productInventory.productInventory.refrence_number
            }
            this.$forceUpdate();
          }
    },
    computed:{
      ...mapGetters({
        allActiveProducts: 'General/allActiveProducts',
      })
    },
    watch:{
    }
  }

</script>
