<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.state.create_new_state") }}
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
                  <nuxt-link :to="localePath('/admin/states')">{{ this.$t("sidebar.state") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.create") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.state.form_description") }}
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
                      <label for="input-live" class=" form-label">{{ this.$t("form.state.name.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.name">
                          {{ error.name[0] }}
                        </span>
                      <input class="form-control"
                             :class="error && error.name ? 'error' : ''"
                             v-model="formData.name"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.state.name.placeholder')"
                             trim />
                      <span class=" heebo-light">
                          {{ this.$t("form.state.name.subheading") }}
                        </span>
                    </div>
                    </div>
                    <div class="col-md-6 py-1 pe-md-0 ">
                           <div role="group ">
                      <label for="input-live" class=" form-label">{{ this.$t("form.state.code.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.code">
                          {{ error.code[0] }}
                        </span>
                      <input class="form-control"
                             :class="error && error.code ? 'error' : ''"
                             v-model="formData.code"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.state.code.placeholder')"
                             trim />
                      <span class=" heebo-light">
                          {{ this.$t("form.state.code.subheading") }}
                        </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.state.country.label") }}</label>
                      <span class="float-end text-danger"
                            v-if="error && error.country_id">
                          {{ error.country_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.country_id ? 'error' : ''" apiMethod="activeCountries" responseKey="countries"
                          :initialOptions="allActiveCountries.countries" :placeholder="this.$t('form.state.country.placeholder')" v-model="formData.country_id" v-on:input="getZonesByCountry($event)" />
                             <span class="px-2 heebo-light">
                                 {{ $t("form.state.country.subheading") }}
                             </span>
                    </div>

                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.state.zone.label") }}</label>
                      <span class="float-end text-danger"
                            v-if="error && error.zone_id">
                          {{ error.zone_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.zone_id ? 'error' : ''" :search_id="formData.country_id" apiMethod="getZonesByCountry" responseKey="zones"
                          :initialOptions="zonesByCountry.zones" :key="zones_key" :placeholder="this.$t('form.state.zone.placeholder')" v-model="formData.zone_id" />
                             <span class=" heebo-light">
                                 {{ $t("form.state.zone.subheading") }}
                             </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                     <div class="col-md-6 my-1 mb-3 ps-md-0">
                   <div class="d-flex align-items-center ">
                       <label class="label form-label me-4 text-capitalize">
                         {{ this.$t("form.city.status.label") }}
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
                       {{ $t("form.city.status.subheading") }}
                     </span>
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
      permission: 'states.create',
      strategy: 'create'
    },
    async asyncData({ params }) {},
    async fetch(){
        if(!this.allActiveCountries.countries){
          await this.fetchActiveCountries();
        }
    },
    data() {
      return {
        zonesByCountry:{},
        zones_key:1,
        formData: {
          name: '',
          country_id:'',
          zone_id:'',
          code:'',
          is_active:false,
        },
        error: false
      }
    },
    methods: {
      ...mapActions({
        addStates: 'States/addStates',
        fetchActiveStates: 'General/fetchActiveStates',
        fetchActiveCountries: 'General/fetchActiveCountries',
      }),
      async add() {
        await this.addAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/states'))
        }
      },
    async getZonesByCountry(e){
      this.formData.zone_id = '';
      const data =  await this.$generalService.getZonesByCountry(e);
      if(data.zones){
        this.zonesByCountry = data.zones;
      }
      this.zones_key+=1;
      },
      async addAndContinue() {
        await this.addStates(this.formData).then(res => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data
            this.$toast.error(res.response.data.message)

          } else {
            this.error = false
            this.formData.name = ''
            this.formData.code = ''
            this.formData.country_id = ''
            this.$toast.success(res.message)
            this.fetchActiveStates();
          }
        })
      }
    },
    computed: {
      ...mapGetters({
        allStates: 'States/allStates',
        allActiveCountries: 'General/allActiveCountries',
      })
    },
    watch: {
      zonesByCountry: function(newValue) {
        this.zones_key+=1
      },
    },
    mounted() {}
  }

</script>
