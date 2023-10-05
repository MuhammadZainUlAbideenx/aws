<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.zone.edit_zone") }}
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
                  <nuxt-link :to="localePath('/admin/zones')">{{ this.$t("sidebar.zone") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.zone.edit_description") }}
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
                      <label for="input-live" class=" form-label">{{ this.$t("form.zone.name.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.name">
                          {{ error.name[0] }}
                        </span>
                      <input class="form-control"
                             :class="error && error.name ? 'error' : ''"
                             v-model="formData.name"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.zone.name.placeholder')"
                             trim />
                      <span class="heebo-light">
                          {{ this.$t("form.zone.name.subheading") }}
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.zone.code.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.code">
                          {{ error.code[0] }}
                        </span>
                      <input :class="error && error.code ? 'error' : ''"
                             class="form-control"
                             v-model="formData.code"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.zone.code.placeholder')"
                             trim />
                             <span class=" heebo-light">
                                 {{ $t("form.zone.code.subheading") }}
                             </span>
                    </div>
                  </div>
                </div>
                  <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.zone.country.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.country">
                          {{ error.country[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.country_id ? 'error' : ''" apiMethod="activeCountries" responseKey="countries"
                          :initialOptions="allActiveCountries.countries" :placeholder="this.$t('form.zone.country.placeholder')" :selectedOptions="selected_country" v-model="formData.country_id" />
                             <span class=" heebo-light">
                                 {{ $t("form.zone.country.subheading") }}
                             </span>
                    </div>
                  </div>

                  <div class="col-md-6 my-1 pe-md-0">
                     <div role="group">
                         <label class="label form-label me-4 text-capitalize">
                           {{ this.$t("form.zone.status.label") }}
                         </label>

                         <div class="form-switch d-flex">
                           <input class="form-check-input"
                                   v-model="formData.is_active"
                                 :checked="formData.is_active ? 'checked' : ''"
                                 type="checkbox"
                                 id="flexSwitchCheckChecked" />
                         </div>
                         <span class=" heebo-light">
                             {{ $t("form.zone.status.subheading") }}
                           </span>
                     </div>
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
    layout: 'admin',
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'zones.update',
      strategy: 'update'
    },
    data() {
      return {
        selected_country:'',
        options: [
          { value: '', text: 'Select your Positioning' },
          { value: 'ltr', text: 'Select ltr Positioning' },
          { value: 'rtl', text: 'Select rtl Positioning' }
        ],
        formData: {
          id: '',
          name: '',
          code: '',
          country_id: '',
          is_active:false,
        },
         disabled:false,
        error: false
      }
    },
    async fetch() {
      if(!this.allActiveCountries.countries){
        this.fetchActiveCountries();
      }
      const { data } = await this.$repositories.zones.show(this.$route.params.id)
      this.formData.name = data.name
      this.formData.code = data.code
      this.formData.country_id = data.country.id
      this.selected_country = data.country
      this.formData.is_active = data.is_active
    },
    methods: {
      ...mapActions({
        updateZones: 'Zones/updateZones',
        fetchActiveZones: 'General/fetchActiveZones',
        fetchActiveCountries: 'General/fetchActiveCountries',
      }),
      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/zones'))
        }
      },
      async updateAndContinue() {
            this.disabled=true
        await this.updateZones({
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
            this.fetchActiveZones();
          }
        });
          this.disabled=false
      }
    },
    computed: {
      ...mapGetters({
        allActiveCountries: 'General/allActiveCountries',
      })
    },
    mounted() {}
  }

</script>
