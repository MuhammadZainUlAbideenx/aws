<template >

  <div >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.tax_rate.edit_tax_rate") }}
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
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.tax_rate.edit_description") }}
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
                            v-if="error && error.zone">
                          {{ error.zone[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.zone_id ? 'error' : ''" apiMethod="activeZones" responseKey="zones"
                          :initialOptions="allActiveZones.zones" :placeholder="this.$t('form.tax_rate.zone.placeholder')" :selectedOptions="selected_zone" v-model="formData.zone_id" />
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
                            v-if="error && error.tax_class">
                          {{ error.tax_class[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.tax_class_id ? 'error' : ''" apiMethod="activeTaxClasses" responseKey="tax_classes"
                          :initialOptions="allActiveTaxClasses.tax_classes" :placeholder="this.$t('form.tax_rate.tax_class.placeholder')" :selectedOptions="selected_tax_class" v-model="formData.tax_class_id" />
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
                <div class="row">

                </div>

              </div>
            </div>
            <div class="row">
                  <div class="col-md-12 px-4 text-center text-md-end">
                    <button type="button"
                            class="btn btn-secondary mb-3 px-3 py-2"
                            @click="update"
                            name="button">
                        {{ this.$t("form.update") }}
                      </button>
                    <!-- <button type="button"
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
    layout: 'admin',
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'tax_rates.update',
      strategy: 'update'
    },
    data() {
      return {
        selected_zone:'',
        selected_tax_class:'',
        formData: {
          rate: '',
          tax_class_id:'',
          zone_id:'',
          is_active: false,
        },
        error: false
      }
    },
    async fetch() {
      if(!this.allActiveTaxClasses.tax_classes){
      await this.fetchActiveTaxClasses();
      }
      if(!this.allActiveZones.zone){
      await this.fetchActiveZones();
      }
      const { data } = await this.$repositories.tax_rates.show(this.$route.params.id)
      this.formData.rate = data.rate
      this.formData.tax_class_id = data.tax_class.id
      this.formData.zone_id = data.zone.id
      this.selected_zone = data.zone
      this.selected_tax_class = data.tax_class
      this.formData.is_active = data.is_active
    },
    methods: {
      ...mapActions({
        updateTaxRates: 'TaxRates/updateTaxRates',
        fetchActiveTaxRates: 'General/fetchActiveTaxRates',
        fetchActiveZones: 'General/fetchActiveZones',
        fetchActiveTaxClasses: 'General/fetchActiveTaxClasses',
      }),
      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/tax_rates'))
        }
      },
      async updateAndContinue() {
        await this.updateTaxRates({
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
