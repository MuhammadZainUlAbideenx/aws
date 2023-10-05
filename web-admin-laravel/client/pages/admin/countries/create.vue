<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0 ">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.country.create_new_country") }}
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
                  <nuxt-link :to="localePath('/admin/countries')">{{ this.$t("sidebar.country") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.create") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.country.form_description") }}
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
                      <label for="input-live" class=" form-label">{{ this.$t("form.country.name.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.name">
                          {{ error.name[0] }}
                        </span>
                      <input class="form-control"
                             :class="error && error.name ? 'error' : ''"
                             v-model="formData.name"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.country.name.placeholder')"
                             trim />
                      <span class=" heebo-light">
                          {{ this.$t("form.country.name.subheading") }}
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.country.iso_code_2.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.iso_code_2">
                          {{ error.iso_code_2[0] }}
                        </span>
                      <input :class="error && error.iso_code_2 ? 'error' : ''"
                             class="form-control"
                             v-model="formData.iso_code_2"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.country.iso_code_2.placeholder')"
                             trim />
                             <span class="heebo-light">
                                 {{ $t("form.country.iso_code_2.subheading") }}
                             </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class=" form-label">{{ this.$t("form.country.iso_code_3.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.iso_code_3">
                          {{ error.iso_code_3[0] }}
                        </span>
                      <input :class="error && error.iso_code_3 ? 'error' : ''"
                             class="form-control"
                             v-model="formData.iso_code_3"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.country.iso_code_3.placeholder')"
                             trim />
                             <span class=" heebo-light">
                                 {{ $t("form.country.iso_code_3.subheading") }}
                             </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                     <div class="col-md-6 my-1 mb-3 ps-md-0">
                  <div class="d-flex align-items-center ">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.country.status.label") }}
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
                      {{ $t("form.country.status.subheading") }}
                    </span>
                </div>
                </div>


              </div>
            </div>
             <div class="row">
                  <div class="col-md-12 px-4 text-center text-md-end ">
                    <button type="button" :disabled="disabled"
                            class="btn btn-primary mb-3 px-3 py-2"
                            @click="add"
                            name="button">
                        {{ this.$t("form.add") }}
                      </button>
                    <!-- <button type="button" :disabled="disabled"
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
      permission: 'countries.create',
      strategy: 'create'
    },
    async asyncData({ params }) {},
    fetch(){

    },
    data() {
      return {
        formData: {
          name: '',
          iso_code_2: '',
          iso_code_3: '',
          is_active: false,
        },
         disabled:false,
        error: false
      }
    },
    methods: {
      ...mapActions({
        addCountries: 'Countries/addCountries',
        fetchActiveCountries: 'General/fetchActiveCountries',
      }),
      async add() {
        await this.addAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/countries'))
        }
      },
      async addAndContinue() {
            this.disabled=true
        await this.addCountries(this.formData).then(res => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data
            this.$toast.error(res.response.data.message)

          } else {
            this.error = false
            this.formData.name = ''
            this.formData.is_active = false
            this.formData.iso_code_2 = ''
            this.formData.iso_code_3 = ''
            this.$toast.success(res.message)
            this.fetchActiveCountries();
          }
        });
          this.disabled=false
      }
    },
    computed: {
      ...mapGetters({
        allCountries: 'Countries/allCountries'
      })
    },
    mounted() {}
  }

</script>
