<template >

  <div class="py-5">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.View_langauge") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{ this.$t("sidebar.Home") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/languages')">{{ this.$t("sidebar.Language") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.View") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.Description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="card gutter-b border-0">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-md-6 my-1">
                <div role="group">
                  <label for="input-live form-label">{{ this.$t("form.Name") }}:</label>
                  <div class="py-3">
                    {{ language.name }}
                  </div>
                </div>
              </div>
              <div class="col-md-6 my-1">
                <div role="group">
                  <label for="input-live form-label">{{ this.$t("form.Code") }}:</label>
                  <div class="py-3">
                    {{ language.code }}
                  </div>
                </div>
              </div>
            </div>
            <div class="row my-4">
              <div class="col-md-6 d-flex align-items-center">
              <div role="" class="gorm-group">
                  <label for="input-live form-label">{{ this.$t("form.Direction") }}:</label>
                  <div class="">
                      {{ language.direction }}
                  </div>

                </div>
              </div>
              <div class="col-md-6">
                <label class="label form-label">
                    {{ this.$t("form.status") }}
                  </label>

                <div class="form-switch d-flex align-items-center">
                  <input class="form-check-input"
                         :checked="language.status ? 'checked' : ''"
                         type="checkbox"
                         id="flexSwitchCheckChecked" />
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
      permission: 'languages.show',
      strategy: 'show'
    },
    data() {
      return {
        options: [
          { value: '', text: 'Select your Positioning' },
          { value: 'ltr', text: 'Select ltr Positioning' },
          { value: 'rtl', text: 'Select rtl Positioning' }
        ],
        language: '',
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.languages.show(this.$route.params.id)
      this.language = data
    },
    methods: {},
    mounted() {}
  }

</script>
