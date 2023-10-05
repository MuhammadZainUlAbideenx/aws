<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.address.create_new_address") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{ this.$t("sidebar.home") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.create") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.address.form_description") }}
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
             <AdminFormLoader/>
          </div>
        </div>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body p-4">
                <div class="row">
                <div class="col-md-6 px-4">
                  <div role="group">
                    <label for="input-live" class="   form-label">{{ this.$t("form.address.address.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.address">
                        {{ error.address[0] }}
                      </span>
                  <textarea class="form-control" :placeholder="this.$t('form.address.address.placeholder')"  v-model="formData.address" aria-describedby="input-live-help input-live-feedback" rows="8" cols="50"></textarea>
                           <span class="   heebo-light">
                               {{ $t("form.address.address.subheading") }}
                           </span>
                  </div>
                </div>
                <div class="col-md-6 px-4">
                  <div role="group">
                    <label for="input-live" class=" form-label">{{ this.$t("form.address.country.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.country_id">
                        {{ error.country_id[0] }}
                      </span>
                      <AdminSearchSelectable :class="error && error.country_id ? 'error' : ''" apiMethod="activeCountries" responseKey="countries"
                        :initialOptions="allActiveCountries.countries" :placeholder="this.$t('form.address.country.placeholder')" v-model="formData.country_id" v-on:input="getStatesByCountry($event)" />
                           <span class=" heebo-light">
                               {{ $t("form.address.country.subheading") }}
                           </span>
                  </div>
                </div>
                <div class="col-md-6 px-4">
                  <div role="group">
                    <label for="input-live" class="form-label">{{ this.$t("form.address.state.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.state_id">
                        {{ error.state_id[0] }}
                      </span>
                      <AdminSearchSelectable :class="error && error.state_id ? 'error' : ''" :search_id="formData.country_id" apiMethod="getStatesByCountry" responseKey="states"
                        :initialOptions="statesByCountry.states" :placeholder="this.$t('form.address.state.placeholder')" :key="states_key" v-model="formData.state_id" v-on:input="getCitiesByState($event)" />
                           <span class=" heebo-light">
                               {{ $t("form.address.state.subheading") }}
                           </span>
                  </div>
                </div>
                <div class="col-md-6 px-4">
                  <div role="group">
                    <label for="input-live" class="form-label">{{ this.$t("form.address.city.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.city_id">
                        {{ error.city_id[0] }}
                      </span>
                      <AdminSearchSelectable :class="error && error.city_id ? 'error' : ''" :search_id="formData.state_id" apiMethod="getCitiesByState" responseKey="cities"
                        :initialOptions="citiesByState.cities" :placeholder="this.$t('form.address.city.placeholder')" :key="cities_key" v-model="formData.city_id" />
                           <span class=" heebo-light">
                               {{ $t("form.address.city.subheading") }}
                           </span>
                  </div>
                </div>
                <div class="col-md-6 px-4">
                  <div role="group">
                    <label for="input-live" class="px-2 form-label">{{ this.$t("form.address.zip_code.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.zip_code">
                        {{ error.zip_code[0] }}
                      </span>
                      <input :class="error && error.zip_code ? 'error' : ''"
                             class="form-control"
                             v-model="formData.zip_code"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.address.zip_code.placeholder')"
                             trim />
                           <span class="px-2 heebo-light">
                               {{ $t("form.address.zip_code.subheading") }}
                           </span>
                  </div>
                </div>
            </div>
              </div>
            </div>
            <div class="row">
                  <div class="col-md-12 px-4 text-  center text-md-end">
                    <button type="button"
                            class="btn btn-primary mb-3 px-3 py-2"
                            @click="add"
                            name="button">
                        {{ this.$t("form.add") }}
                      </button>
                    <button type="button"
                            class="btn btn-success mb-3 px-3 py-2"
                            @click="addAndContinue"
                            name="button">
                        {{ this.$t("form.add_and_continue") }}
                      </button>
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
      permission: 'addresses.create',
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
        statesByCountry:{},
        citiesByState:{},
        states_key:1,
        cities_key:1,
        formData: {
          customer_id:'',
          city_id:'',
          state_id:'',
          country_id:'',
          zip_code:'',
          address:'',
        },
        error: false
      }

    },
    methods: {
      ...mapActions({
        addAddresses: 'Addresses/addAddresses',
        fetchActiveAddresses: 'General/fetchActiveAddresses',
        fetchActiveCountries: 'General/fetchActiveCountries',
      }),
      async getStatesByCountry(e){
        this.formData.state_id = '';
        this.formData.city_id = '';
        const data =  await this.$generalService.getStatesByCountry(e,null);
        if(data.states){
          this.statesByCountry = data.states;
        }
        this.states_key+=1;
        },
      async getCitiesByState(e){
          this.formData.city_id = '';
          const data =  await this.$generalService.getCitiesByState(e);
          if(data.cities){
            this.citiesByState = data.cities;
          }
          this.cities_key+=1;
        },
      async add() {
        this.formData.customer_id = this.$route.params.id
        await this.addAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/addresses/customer/'+this.$route.params.id))
        }
      },
      async addAndContinue() {
        await this.addAddresses(this.formData).then(res => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data
            this.$toast.error(res.response.data.message)

          } else {
            this.error = false
            this.formData.city_id = ''
            this.formData.address = ''
            this.formData.zip_code = ''
            this.formData.country_id = ''
            this.formData.customer_id = ''
            this.formData.state_id = ''
            this.$toast.success(res.message)
          //  this.fetchActiveAddresses();
          }
        })
      }
    },
    computed: {
      ...mapGetters({
        allAddresses: 'Addresses/allAddresses',
        allActiveCountries: 'General/allActiveCountries',
      })
    },
    watch: {
      statesByCountry: function(newValue) {
        this.states_key+=1
      },
      citiesByState: function(newValue) {
        this.cities_key+=1
      },
    },
    mounted() {}
  }

</script>
