<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.country.view_country") }}
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
                  {{ this.$t("form.view") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.country.view_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        <!-- /.row -->
    </div>
    </div>

    <!-- Main content -->
    <section class="content">
     <div  v-if="$fetchState.pending">
      <AdminViewLoader/>
      </div>
      <div class="container" v-else>
        <div class="card gutter-b border-0">
          <div class="card-body">
            <div class="row">
                <div class="col-sm-12 px-0">
                    <div class="show-table px-0 mb-2">
                      <div class="row justify-content-end">
                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.country.name.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{country.name}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.country.iso_code_2.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{country.iso_code_2}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.country.iso_code_3.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{country.iso_code_3}}</p>
                        </div>

                        <div class="col-3">
                          <label for="input-live " class="form-label">{{
                         this.$t("form.country.status.label")
                          }}</label>
                        </div>
                        <div class="col-3">
                           <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="country.is_active ? 'checked' : ''"
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                              disabled
                            />
                          </div>
                        </div>

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
      permission: 'countries.index',
      strategy: 'read'
    },
    data() {
      return {
        options: [
          { value: '', text: 'Select your Positioning' },
          { value: 'ltr', text: 'Select ltr Positioning' },
          { value: 'rtl', text: 'Select rtl Positioning' }
        ],
        country: '',
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.countries.show(this.$route.params.id)
      this.country = data
    },
    methods: {},
    mounted() {},
    computed:{
    ...mapGetters({
      allActiveLanguages: 'General/allActiveLanguages',
    })
  }
  }

</script>
