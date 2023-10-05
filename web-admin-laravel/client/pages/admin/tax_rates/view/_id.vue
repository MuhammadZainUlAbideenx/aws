<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.tax_rate.view_tax_rate") }}
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
                  {{ this.$t("form.view") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.tax_rate.view_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container" v-if="$fetchState.pending">
        <div class="row">
          <div class="col-md-12">
            <AdminLoader />
          </div>
        </div>
      </div>
      <div class="container" v-else>
        <div class="card gutter-b border-0">
          <div class="card-body">
            <div class="row">
                <div class="col-sm-12 px-0">
                    <div class="show-table px-0 mb-3">
                      <div class="row justify-content-end">
                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.tax_rate.rate.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{tax_rate.rate}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.tax_rate.zone.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{tax_rate.zone.name}}</p>
                        </div>

                        <div class="col-3" v-if="tax_class">
                          <label class="label form-label">
                            {{ this.$t("form.tax_rate.tax_class.label") }}
                          </label>
                        </div>
                        <div class="col-3" v-if="tax_class">
                          <p>{{tax_rate.tax_class.name}}</p>
                        </div>


                        <div class="col-3">
                          <label for="input-live " class="form-label">{{
                         this.$t("form.tax_rate.status.label")
                          }}</label>
                        </div>
                        <div class="col-3">
                           <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="tax_rate.is_active ? 'checked' : ''"
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
      permission: 'tax_rates.index',
      strategy: 'read'
    },
    data() {
      return {
        options: [
          { value: '', text: 'Select your Positioning' },
          { value: 'ltr', text: 'Select ltr Positioning' },
          { value: 'rtl', text: 'Select rtl Positioning' }
        ],
        tax_rate: '',
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.tax_rates.show(this.$route.params.id)
      this.tax_rate = data
    },
    methods: {},
    mounted() {}
  }

</script>
