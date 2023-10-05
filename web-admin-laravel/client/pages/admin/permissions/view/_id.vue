<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12">
            <h2 class="m-0 text-body bold">
              {{ this.$t("permission.view_permission") }}
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
                  <nuxt-link :to="localePath('/admin/permissions')">{{ this.$t("sidebar.permission") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.view") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("permission.view_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="card gutter-b border-0">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-md-6 my-1">
                <div permission="group">
                  <label for="input-live form-label">{{$t('name')}}:</label>
                  <div class="py-3">
                    {{ permission.name }}
                  </div>
                </div>
              </div>
              <div class="col-md-6 my-1">
                <div permission="group">
                  <label for="input-live form-label">{{$t('code')}}:</label>
                  <div class="py-3">
                    {{ permission.code }}
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 my-1 d-flex align-items-center">
                <div permission="group">
                  <label for="input-live form-label">{{$t('direction')}}:</label> {{ permission.direction }}
                </div>
              </div>
            <!--  <div class="col-md-6 my-1 pt-1">
                <label class="label form-label">
                    {{ this.$t("form.Active") }}
                  </label>

                <div class="form-switch d-flex align-items-center">
                  <input class="form-check-input"
                         :checked="permission.is_active ? 'checked' : ''"
                         type="checkbox"
                         id="flexSwitchCheckChecked" />
                </div>
              </div> -->
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
      permission: 'permissions.show',
      strategy: 'show'
    },
    data() {
      return {
        options: [
          { value: '', text: 'Select your Positioning' },
          { value: 'ltr', text: 'Select ltr Positioning' },
          { value: 'rtl', text: 'Select rtl Positioning' }
        ],
        permission: '',
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.permissions.show(this.$route.params.id)
      this.permission = data
    },
    methods: {},
    mounted() {}
  }

</script>
