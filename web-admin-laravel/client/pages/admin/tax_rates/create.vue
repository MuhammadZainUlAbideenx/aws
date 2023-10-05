<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.tax_rate.create_new_tax_rate") }}
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
                  <nuxt-link :to="localePath('/admin/tax_rates')">{{ this.$t("sidebar.tax_rate") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.create") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.tax_rate.form_description") }}
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
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group ">
                      <label for="input-live" class=" form-label">{{ this.$t("form.tax_rate.rate.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.rate">
                          {{ error.rate[0] }}
                        </span>
                      <input class="form-control"
                             :class="error && error.rate ? 'error' : ''"
                             v-model="formData.rate"
                             type="number"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.tax_rate.rate.placeholder')"
                             trim />
                      <span class=" heebo-light">
                          {{ this.$t("form.tax_rate.rate.subheading") }}
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.tax_rate.zone.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.zone_id">
                          {{ error.zone_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.zone_id ? 'error' : ''" apiMethod="activeZones" responseKey="zones"
                          :initialOptions="allActiveZones.zones" :placeholder="this.$t('form.tax_rate.zone.placeholder')" v-model="formData.zone_id" />
                             <span class=" heebo-light">
                                 {{ $t("form.tax_rate.zone.subheading") }}
                             </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.tax_rate.tax_class.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.tax_class_id">
                          {{ error.tax_class_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.tax_class_id ? 'error' : ''" apiMethod="activeTaxClasses" responseKey="tax_classes"
                          :initialOptions="allActiveTaxClasses.tax_classes" :placeholder="this.$t('form.tax_rate.tax_class.placeholder')" v-model="formData.tax_class_id" />
                             <span class=" heebo-light">
                                 {{ $t("form.tax_rate.tax_class.subheading") }}
                             </span>
                    </div>
                  </div>

                  <div class="col-md-6 my-1 pe-md-0">
                       <div role="group">
                           <label class="label form-label me-4 text-capitalize">
                             {{ this.$t("form.tax_rate.status.label") }}
                           </label>

                           <div class="form-switch d-flex">
                             <input class="form-check-input"
                                     v-model="formData.is_active"
                                   :checked="formData.is_active ? 'checked' : ''"
                                   type="checkbox"
                                   id="flexSwitchCheckChecked" />
                           </div>
                           <span class=" heebo-light">
                               {{ $t("form.tax_rate.status.subheading") }}
                             </span>
                       </div>
                     </div>
                </div>
              </div>
            </div>
            <div class="row">
                  <div class="col-md-12 px-4 text-center text-md-end">
                    <button type="button"
                            class="btn btn-primary mb-3 px-3 py-2"
                            @click="add"
                            name="button">
                        {{ this.$t("form.add") }}
                      </button>
                    <!-- <button type="button"
                            class="btn btn-success mb-3"
                            @click="addAndContinue"
                            name="button">
                        {{ this.$t("form.add_and_continue") }}
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
    layout: 'admin',
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'tax_rates.create',
      strategy: 'create'
    },
    async asyncData({ params }) {},

    async fetch(){
      if(!this.allActiveTaxClasses.tax_classes){
      await this.fetchActiveTaxClasses();
      }
      if(!this.allActiveZones.zone){
      await this.fetchActiveZones();
      }
    },
    data() {
      return {
        formData: {
          rate: '',
          tax_class_id:'',
          zone_id:'',
          is_active:false,
        },
        error: false
      }
    },
    methods: {
      ...mapActions({
        addTaxRates: 'TaxRates/addTaxRates',
        fetchActiveTaxRates: 'General/fetchActiveTaxRates',
        fetchActiveZones: 'General/fetchActiveZones',
        fetchActiveTaxClasses: 'General/fetchActiveTaxClasses',
      }),
      async add() {
        await this.addAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/tax_rates'))
        }
      },
      async addAndContinue() {
        await this.addTaxRates(this.formData).then(res => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data
            this.$toast.error(res.response.data.message)

          } else {
            this.error = false
            this.formData.rate = ''
            this.formData.tax_class_id = ''
            this.formData.zone_id = ''
            this.formData.zone_id = false
            this.$toast.success(res.message)
            this.fetchActiveTaxRates();
          }
        })
      }
    },
    computed: {
      ...mapGetters({
        allTaxRates: 'TaxRates/allTaxRates',
        allActiveZones: 'General/allActiveZones',
        allActiveTaxClasses: 'General/allActiveTaxClasses',
      })
    },
    mounted() {}
  }

</script>
