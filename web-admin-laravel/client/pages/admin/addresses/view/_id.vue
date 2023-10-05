<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("address.view_address") }}
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
                  <nuxt-link :to="localePath('/admin/addresses')">{{ this.$t("sidebar.address") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.view") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("address.view_description") }}
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
             <AdminViewLoader/>
          </div>
        </div>
      </div>
      <div class="container" v-else>
        <div class="card gutter-b border-0">
          <div class="card-body p-4">
            <div class="row">
                <div class="col-sm-12">
                    <div class="show-table px-0">
                      <div class="row justify-content-end">
                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.address.address.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{address.address}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.address.country.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{address.country.name}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.address.zip_code.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{address.zip_code}}</p>
                        </div>


                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.address.city.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{address.city.name}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.address.state.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{address.state.name}}</p>
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
      permission: 'addresses.index',
      strategy: 'read'
    },
    data() {
      return {
        options: [
          { value: '', text: 'Select your Positioning' },
          { value: 'ltr', text: 'Select ltr Positioning' },
          { value: 'rtl', text: 'Select rtl Positioning' }
        ],
        address: '',
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.addresses.show(this.$route.params.id)
      this.address = data
    },
    methods: {},
    mounted() {}
  }

</script>
