<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0 mb-2">
          <div class="col-sm-12">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.admin.edit_admin") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{ this.$t("sidebar.home") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/admins')">{{ this.$t("sidebar.admin") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.admin.edit_description") }}
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
                  <div class="col-md-6 ps-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.admin.admin_type.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.admin_type">
                          {{ error.admin_type[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.admin_type ? 'error' : ''" apiMethod="allActiveAdminsRoles" responseKey="admins_types"
                          :initialOptions="allActiveAdminsRoles.admins_types" :selectedOptions="selected_admin_type" show_key="display_name" :placeholder="this.$t('form.admin.admin_type.placeholder')" v-model="formData.role_id"/>
                             <span class=" heebo-light">
                                 {{ $t("form.admin.admin_type.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 pe-md-0">
                    <div role="group ">
                      <label for="input-live" class="  form-label">{{ this.$t("form.admin.first_name.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.first_name">
                          {{ error.first_name[0] }}
                        </span>
                      <input class="form-control"
                             :class="error && error.first_name ? 'error' : ''"
                             v-model="formData.first_name"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.admin.first_name.placeholder')"
                             trim />
                      <span class="  heebo-light">
                          {{ this.$t("form.admin.first_name.subheading") }}
                        </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="  form-label">{{ this.$t("form.admin.last_name.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.last_name">
                          {{ error.last_name[0] }}
                        </span>
                      <input :class="error && error.last_name ? 'error' : ''"
                             class="form-control"
                             v-model="formData.last_name"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.admin.last_name.placeholder')"
                             trim />
                             <span class="  heebo-light">
                                 {{ $t("form.admin.last_name.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 pe-md-0">
                    <div role="group">
                    <label class="label form-label">
                        {{ this.$t("form.admin.dob.label") }}
                      </label>
                      <span class="float-end text-danger"
                            v-if="error && error.dob">
                          {{ error.dob[0] }}
                        </span>
                        <datetime :min-datetime="now.min_date" value-zone="local"  :max-datetime="now.max_date" :placeholder="this.$t('form.admin.dob.placeholder')"   input-class="form-control" type="date" v-model="formData.dob"></datetime>
                   <span class="  heebo-light">
                       {{ $t("form.admin.dob.subheading") }}
                   </span>
                 </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-6 ps-md-0">
                  <div role="group">
                    <label for="input-live" class="  form-label">{{ this.$t("form.admin.phone.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.phone">
                        {{ error.phone[0] }}
                      </span>
                    <input :class="error && error.phone ? 'error' : ''"
                           class="form-control"
                           type="number"
                           v-model="formData.phone"
                           aria-describedby="input-live-help input-live-feedback"
                           :placeholder="this.$t('form.admin.phone.placeholder')"
                           trim />
                           <span class="  heebo-light">
                               {{ $t("form.admin.phone.subheading") }}
                           </span>
                  </div>
                </div>
                <div class="col-md-6 pe-md-0">
                  <div role="group">
                    <label for="input-live" class="  form-label">{{ this.$t("form.admin.address.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.address">
                        {{ error.address[0] }}
                      </span>
                  <textarea class="form-control" :placeholder="this.$t('form.admin.address.placeholder')"  v-model="formData.address" aria-describedby="input-live-help input-live-feedback" rows="8" cols="50"></textarea>
                           <span class="  heebo-light">
                               {{ $t("form.admin.address.subheading") }}
                           </span>
                  </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-6 ps-md-0">
                  <div role="group">
                    <label for="input-live" class="  form-label">{{ this.$t("form.admin.zip_code.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.zip_code">
                        {{ error.zip_code[0] }}
                      </span>
                      <input :class="error && error.zip_code ? 'error' : ''"
                             class="form-control"
                             v-model="formData.zip_code"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.admin.zip_code.placeholder')"
                             trim />
                           <span class="  heebo-light">
                               {{ $t("form.admin.zip_code.subheading") }}
                           </span>
                  </div>
                </div>
                <div class="col-md-6 pe-md-0">
                  <div role="group">
                    <label for="input-live" class=" form-label">{{ this.$t("form.admin.country.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.country_id">
                        {{ error.country_id[0] }}
                      </span>
                      <AdminSearchSelectable :class="error && error.country_id ? 'error' : ''" apiMethod="activeCountries" responseKey="countries"
                        :initialOptions="allActiveCountries.countries" :selectedOptions="selected_country" :placeholder="this.$t('form.admin.country.placeholder')" v-model="formData.country_id" v-on:input="getStatesByCountry($event)" />
                           <span class=" heebo-light">
                               {{ $t("form.admin.country.subheading") }}
                           </span>
                  </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-6 ps-md-0">
                  <div role="group">
                    <label for="input-live" class="form-label">{{ this.$t("form.admin.state.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.state_id">
                        {{ error.state_id[0] }}
                      </span>
                      <AdminSearchSelectable :class="error && error.state_id ? 'error' : ''" :search_id="formData.country_id" apiMethod="getStatesByCountry" responseKey="states"
                        :initialOptions="statesByCountry.states" :selectedOptions="selected_state" :placeholder="this.$t('form.admin.state.placeholder')" :key="states_key" v-model="formData.state_id" v-on:input="getCitiesByState($event)" />
                           <span class=" heebo-light">
                               {{ $t("form.admin.state.subheading") }}
                           </span>
                  </div>
                </div>
                <div class="col-md-6 pe-md-0">
                  <div role="group">
                    <label for="input-live" class="form-label">{{ this.$t("form.admin.city.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.city_id">
                        {{ error.city_id[0] }}
                      </span>
                      <AdminSearchSelectable :class="error && error.city_id ? 'error' : ''" :search_id="formData.state_id" apiMethod="getCitiesByState" responseKey="cities"
                        :initialOptions="citiesByState.cities" :selectedOptions="selected_city" :placeholder="this.$t('form.admin.city.placeholder')" :key="cities_key" v-model="formData.city_id" />
                           <span class=" heebo-light">
                               {{ $t("form.admin.city.subheading") }}
                           </span>
                  </div>
                </div>
                </div>
                <div class="row">
                  <div class="col-md-6 ps-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.admin.gender.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.gender">
                          {{ error.gender[0] }}
                        </span>
                          <div class="d-flex">
                         <label class="radio heebo-light">  {{ $t("form.admin.gender.male") }}
                    <input type="radio"   v-model="formData.gender"
                                value="male">
                    <span class="checkround"></span>
                    </label>
                    <label class="radio heebo-light mx-3">{{ $t("form.admin.gender.female") }}
                      <input type="radio"  v-model="formData.gender"
                                   value="female" >
                      <span class="checkround"></span>
                    </label>
                        </div>
                    </div>
                    <span class=" heebo-light">
                        {{ $t("form.admin.gender.subheading") }}
                    </span>
                  </div>
                <div class="col-md-6 mb-3 pe-md-0">
                  <div class="d-flex align-items-center ">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.admin.is_credentials.label") }}
                      </label>

                      <div class="form-switch">
                        <input class="form-check-input"
                                v-model="formData.is_credentials"
                              :checked="formData.is_credentials ? 'checked' : ''"
                              type="checkbox"
                              id="flexSwitchCheckChecked" />
                      </div>
                  </div>
                  <span class=" heebo-light">
                      {{ $t("form.admin.is_credentials.subheading") }}
                    </span>
                </div>
                </div>
               <div class="row" v-if="formData.is_credentials">
              <div class="col-md-6 ps-md-0">
                <div role="group">
                  <label for="input-live" class="  form-label">{{ this.$t("form.admin.email.label") }}:</label>
                  <span class="float-end text-danger"
                        v-if="error && error.email">
                      {{ error.email[0] }}
                    </span>
                  <input :class="error && error.email ? 'error' : ''"
                         class="form-control"
                         v-model="formData.email"
                         aria-describedby="input-live-help input-live-feedback"
                         :placeholder="this.$t('form.admin.email.placeholder')"
                         trim />
                         <span class="  heebo-light">
                             {{ $t("form.admin.email.subheading") }}
                         </span>
                </div>
              </div>
                <div class="col-md-6 pe-md-0">
                  <div role="group">
                    <label for="input-live" class="  form-label">{{ this.$t("form.admin.password.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.password">
                        {{ error.password[0] }}
                      </span>
                    <input :class="error && error.password ? 'error' : ''"
                           class="form-control"
                           v-model="formData.password"
                           type="password"
                           aria-describedby="input-live-help input-live-feedback"
                           :placeholder="this.$t('form.admin.password.placeholder')"
                           trim />
                           <span class="  heebo-light">
                               {{ $t("form.admin.password.subheading") }}
                           </span>
                  </div>
                </div>
                <div class="col-md-6 ps-md-0">
                  <div role="group">
                    <label for="input-live" class="   form-label">{{ this.$t("form.admin.password_confirmation.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.password_confirmation">
                        {{ error.confirm_password[0] }}
                      </span>
                    <input :class="error && error.password_confirmation ? 'error' : ''"
                           class="form-control"
                           v-model="formData.password_confirmation"
                           type="password"
                           aria-describedby="input-live-help input-live-feedback"
                           :placeholder="this.$t('form.admin.password_confirmation.placeholder')"
                           trim />
                           <span class="   heebo-light">
                               {{ $t("form.admin.password_confirmation.subheading") }}
                           </span>
                  </div>
                </div>
               </div>
               <div class="row">
                <div class="col-md-6 ps-md-0">
                  <div class="d-flex align-items-center ">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.admin.status.label") }}
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
                      {{ $t("form.admin.status.subheading") }}
                    </span>
                </div>
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
      permission: 'admins.update',
      strategy: 'update'
    },
    data() {
      return {
        min_date:'',
        max_date:'',
        allActiveAdminsRoles:{},
        statesByCountry:{},
        citiesByState:{},
        selected_city:'',
        selected_state:'',
        selected_country:'',
        states_key:1,
        cities_key:1,
        formData: {
          role_id:'',
          email:'',
          password:'',
          password_confirmation:'',
          city_id:'',
          state_id:'',
          country_id:'',
          zip_code:'',
          first_name: '',
          last_name: '',
          gender: '',
          address:'',
          dob: '',
          phone: '',
          is_active: false,
          is_credentials: false,
        },
        error: false
      }
    },
    async fetch() {
      const admins_types = await this.$generalService.allActiveAdminsRoles()
       this.allActiveAdminsRoles = admins_types.admins_types
       if(!this.allActiveCountries.countries){
         await this.fetchActiveCountries()
       }
      const { data } = await this.$repositories.admins.show(this.$route.params.id)
      this.formData.email = data.email
      this.formData.role_id = data.admin_type.id
      this.selected_admin_type = data.admin_type
      this.formData.first_name = data.first_name
      this.formData.last_name = data.last_name
      this.formData.gender = data.gender
      this.formData.dob = data.dob
      this.formData.phone = data.phone
      this.formData.address = data.address
      this.formData.is_active = data.is_active
      this.formData.zip_code = data.zip_code
      if(data.country){
      this.formData.country_id = data.country.id
        this.selected_country = data.country
      if(data.state){
          await this.setStatesByCountry(data.country.id)
          this.formData.state_id = data.state.id
          this.selected_state = data.state
        }
      if(data.city){
         await this.setCitiesByState(data.state.id)
          this.formData.city_id = data.city.id
          this.selected_city = data.city
        }
      }
    },
    methods: {
      ...mapActions({
        updateAdmins: 'Admins/updateAdmins',
        fetchActiveAdmins: 'General/fetchActiveAdmins',
        fetchActiveCountries: 'General/fetchActiveCountries',
      }),
      async getStatesByCountry(e){
        this.formData.state_id = ''
        this.formData.city_id = ''
        this.selected_state = ''
        this.selected_city = ''
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
      async getCitiesByState(e){
          this.formData.city_id = ''
          this.selected_city = ''
          const data =  await this.$generalService.getCitiesByState(e);
          if(data.cities){
            this.citiesByState = data.cities;
          }
          this.cities_key+=1;
          },
      async setCitiesByState(id){
          const data =  await this.$generalService.getCitiesByState(id);
            if(data.cities){
          this.citiesByState = data.cities;
        }
          this.$forceUpdate();
          },
      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/admins'))
        }
      },
      async updateAndContinue() {
        await this.updateAdmins({
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
            this.fetchActiveAdmins();
          }
        })
      }
    },
    computed: {
      now: function () {
                var max_date = new Date();
                var min_date = new Date();
                min_date.setYear(min_date.getFullYear()-100);
                max_date.setYear(max_date.getFullYear()-2);
                var max_date = new Date(max_date).toISOString();
                var min_date = new Date(min_date).toISOString();
                return {
                  min_date: min_date,
                  max_date: max_date
                };
      },
      ...mapGetters({
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
