<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0 ">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.city.edit_city") }}
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
                  <nuxt-link :to="localePath('/admin/cities')">{{ this.$t("sidebar.city") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.city.edit_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Main content -->
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
                  <div class="col-md-6 my-1 ps-md-0 ">
                    <div role="group ">
                      <label for="input-live" class="form-label">{{ this.$t("form.city.name.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.name">
                          {{ error.name[0] }}
                        </span>
                      <input class="form-control"
                             :class="error && error.name ? 'error' : ''"
                             v-model="formData.name"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.city.name.placeholder')"
                             trim />
                      <span class="px-2 heebo-light">
                          {{ this.$t("form.city.name.subheading") }}
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.city.code.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.code">
                          {{ error.code[0] }}
                        </span>
                      <input :class="error && error.code ? 'error' : ''"
                             class="form-control"
                             v-model="formData.code"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.city.code.placeholder')"
                             trim />
                             <span class=" heebo-light">
                                 {{ $t("form.city.code.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1  ps-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.city.country.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.country_id">
                          {{ error.country_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.country_id ? 'error' : ''" apiMethod="activeCountries" responseKey="countries"
                          :initialOptions="allActiveCountries.countries" :placeholder="this.$t('form.city.country.placeholder')" :selectedOptions="selected_country" v-model="formData.country_id" v-on:input="getStatesByCountry($event)" />
                             <span class=" heebo-light">
                                 {{ $t("form.city.country.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1  pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.city.state.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.state_id">
                          {{ error.state_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.state_id ? 'error' : ''" :search_id="formData.country_id" apiMethod="getStatesByCountry" responseKey="states"
                          :initialOptions="statesByCountry.states" :selectedOptions="selected_state" :placeholder="this.$t('form.city.state.placeholder')" :key="states_key" v-model="formData.state_id" />
                             <span class=" heebo-light">
                                 {{ $t("form.city.state.subheading") }}
                             </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                     <div class="col-md-6 my-1 mb-3  ps-md-0">
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
      permission: 'cities.update',
      strategy: 'update'
    },
    data() {
      return {
        statesByCountry:{},
        selected_country:'',
        selected_state:'',
        states_key:1,
        formData: {
          name: '',
          code: '',
          country_id:'',
          state_id:'',
          is_active: false,
        },
        error: false
      }
    },
    async fetch() {
      if(!this.allActiveCountries.countries){
        this.fetchActiveCountries();
      }
      const { data } = await this.$repositories.cities.show(this.$route.params.id)
      this.formData.is_active = data.is_active
      this.formData.name = data.name
      this.formData.code = data.code
      if(data.country){
        this.formData.country_id = data.country.id
        this.selected_country = data.country
      }
      if(data.state){
          await this.setStatesByCountry(data.country.id)
          this.formData.state_id = data.state.id
          this.selected_state = data.state
        }
    },
    methods: {
      ...mapActions({
        updateCities: 'Cities/updateCities',
        fetchActiveCities: 'General/fetchActiveCities',
        fetchActiveCountries: 'General/fetchActiveCountries',
      }),
      async getStatesByCountry(e){
        this.formData.state_id = ''
        this.selected_state = ''
        const data =  await this.$generalService.getStatesByCountry(e);
        if(data.states){
          this.statesByCountry = data.states;
        }
        this.states_key+=1;
      },
      async setStatesByCountry(id){
        const data =  await this.$generalService.getStatesByCountry(id);
        if(data.states){
          this.statesByCountry = data.states;
          }
        this.$forceUpdate();
        },
      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/cities'))
        }
      },
      async updateAndContinue() {
        await this.updateCities({
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
            this.fetchActiveCities();
          }
        })
      }
    },
    computed: {
      ...mapGetters({
        allActiveCountries: 'General/allActiveCountries',
      })
    },
    watch: {
      statesByCountry: function(newValue) {
        this.states_key+=1
      }
    },
    mounted() {}
  }

</script>
