<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.customer.edit_customer") }}
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
                  <nuxt-link :to="localePath('/admin/customers')">{{ this.$t("sidebar.customer") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.customer.edit_description") }}
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
                  <div class="col-md-6 my-1 ps-md-0  ">
                    <div role="group ">
                      <label for="input-live" class="   form-label">{{ this.$t("form.customer.first_name.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.first_name">
                          {{ error.first_name[0] }}
                        </span>
                      <input class="form-control"
                             :class="error && error.first_name ? 'error' : ''"
                             v-model="formData.first_name"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.customer.first_name.placeholder')"
                             trim />
                      <span class="   heebo-light">
                          {{ this.$t("form.customer.first_name.subheading") }}
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0 ">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.customer.last_name.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.last_name">
                          {{ error.last_name[0] }}
                        </span>
                      <input :class="error && error.last_name ? 'error' : ''"
                             class="form-control"
                             v-model="formData.last_name"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.customer.last_name.placeholder')"
                             trim />
                             <span class="   heebo-light">
                                 {{ $t("form.customer.last_name.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0 ">
                    <div role="group">
                    <label class="label form-label">
                        {{ this.$t("form.customer.dob.label") }}
                      </label>
                      <span class="float-end text-danger"
                            v-if="error && error.dob">
                          {{ error.dob[0] }}
                        </span>
                        <datetime :min-datetime="now.min_date"  :max-datetime="now.max_date" :placeholder="this.$t('form.customer.dob.placeholder')" value-zone="local"  input-class="form-control" type="date" v-model="formData.dob"></datetime>
                   <span class="heebo-light">
                       {{ $t("form.customer.dob.subheading") }}
                   </span>
                 </div>
                </div>
                <div class="col-md-6 my-1 pe-md-0 ">
                  <div role="group">
                    <label for="input-live" class="form-label">{{ this.$t("form.customer.phone.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.phone">
                        {{ error.phone[0] }}
                      </span>
                    <input :class="error && error.phone ? 'error' : ''"
                           class="form-control"
                           v-model="formData.phone"
                           type="number"
                           aria-describedby="input-live-help input-live-feedback"
                           :placeholder="this.$t('form.customer.phone.placeholder')"
                           trim />
                           <span class="heebo-light">
                               {{ $t("form.customer.phone.subheading") }}
                           </span>
                  </div>
                </div>
                  <div class="col-md-6 my-1 ps-md-0 ">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.customer.gender.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.gender">
                          {{ error.gender[0] }}
                        </span>
                        <div class="d-flex">
                         <label class="radio heebo-light">  {{ $t("form.customer.gender.male") }}
                    <input type="radio"   v-model="formData.gender"
                                value="male">
                    <span class="checkround"></span>
                    </label>
                    <label class="radio heebo-light mx-3">{{ $t("form.customer.gender.female") }}
                      <input type="radio"  v-model="formData.gender"
                                   value="female" >
                      <span class="checkround"></span>
                    </label>
                        </div>

                    </div>
                    <span class="heebo-light">
                        {{ $t("form.customer.gender.subheading") }}
                    </span>
                  </div>
                </div>
                <div class="col-md-6 my-1 mb-3 ps-md-0">
                  <div class="d-flex align-items-center ">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.customer.is_credentials.label") }}
                      </label>
                      <div class="form-switch">
                        <input class="form-check-input"
                                v-model="formData.is_credentials"
                              :checked="formData.is_credentials ? 'checked' : ''"
                              type="checkbox"
                              id="flexSwitchCheckChecked" />
                      </div>
                  </div>
                  <span class="heebo-light">
                      {{ $t("form.customer.is_credentials.subheading") }}
                    </span>
                </div>

                <div class="row" v-if="formData.is_credentials">
                   <div class="col-md-6 my-1 ps-md-0 ">
                  <div role="group">
                    <label for="input-live" class="form-label">{{ this.$t("form.customer.email.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.email">
                        {{ error.email[0] }}
                      </span>
                    <input :class="error && error.email ? 'error' : ''"
                           class="form-control"
                           v-model="formData.email"
                           aria-describedby="input-live-help input-live-feedback"
                           :placeholder="this.$t('form.customer.email.placeholder')"
                           trim />
                           <span class="heebo-light">
                               {{ $t("form.customer.email.subheading") }}
                           </span>
                  </div>
                </div>
                <div class="col-md-6 my-1 pe-md-0 ">
                  <div role="group">
                    <label for="input-live" class="form-label">{{ this.$t("form.customer.password.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.password">
                        {{ error.password[0] }}
                      </span>
                    <input :class="error && error.password ? 'error' : ''"
                           class="form-control"
                           v-model="formData.password"
                           type="password"
                           aria-describedby="input-live-help input-live-feedback"
                           :placeholder="this.$t('form.customer.password.placeholder')"
                           trim />
                           <span class="heebo-light">
                               {{ $t("form.customer.password.subheading") }}
                           </span>
                  </div>
                </div>
                <div class="col-md-6 my-1 ps-md-0 ">
                  <div role="group">
                    <label for="input-live" class="form-label">{{ this.$t("form.customer.password_confirmation.label") }}:</label>
                    <span class="float-end text-danger"
                          v-if="error && error.password_confirmation">
                        {{ error.confirm_password[0] }}
                      </span>
                    <input :class="error && error.password_confirmation ? 'error' : ''"
                           class="form-control"
                           v-model="formData.password_confirmation"
                           type="password"
                           aria-describedby="input-live-help input-live-feedback"
                           :placeholder="this.$t('form.customer.password_confirmation.placeholder')"
                           trim />
                           <span class="heebo-light">
                               {{ $t("form.customer.password_confirmation.subheading") }}
                           </span>
                  </div>
                </div>
              </div>
                <div class="row">
                <div class="col-md-6 my-1 mb-3 ps-md-0">
                  <div class="d-flex align-items-center ">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.customer.status.label") }}
                      </label>

                      <div class="form-switch">
                        <input class="form-check-input"
                                v-model="formData.is_active"
                              :checked="formData.is_active ? 'checked' : ''"
                              type="checkbox"
                              id="flexSwitchCheckChecked" />
                      </div>
                  </div>
                  <span class="heebo-light">
                      {{ $t("form.customer.status.subheading") }}
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
      permission: 'customers.update',
      strategy: 'update'
    },
    data() {
      return {
        min_date:'',
        max_date:'',
        formData: {
          is_credentials: false,
          email:'',
          password:'',
          password_confirmation:'',
          first_name: '',
          last_name: '',
          gender: '',
          dob: '',
          phone: '',
          is_active: false,
        },
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.customers.show(this.$route.params.id)
      this.formData.email = data.email
      this.formData.first_name = data.first_name
      this.formData.last_name = data.last_name
      this.formData.gender = data.gender
      this.formData.dob = data.dob
      this.formData.phone = data.phone
      this.formData.is_active = data.is_active
    },
    methods: {
      ...mapActions({
        updateCustomers: 'Customers/updateCustomers',
        fetchActiveCustomers: 'General/fetchActiveCustomers',
      }),
      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/customers'))
        }
      },
      async updateAndContinue() {
        await this.updateCustomers({
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
            this.fetchActiveCustomers();
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
    },
    mounted() {}
  }

</script>
