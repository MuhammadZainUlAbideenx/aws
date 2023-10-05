<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.state.view_state") }}
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
                  <nuxt-link :to="localePath('/admin/states')">{{ this.$t("sidebar.state") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.view") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.state.view_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
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
                    <div class="show-table px-0 mb-3">
                      <div class="row justify-content-end">
                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.state.name.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{state.name}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.state.code.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{state.code}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.state.country.label") }}
                          </label>
                        </div>
                        <div class="col-3" v-if="state.country">
                          <p>{{state.country.name}}</p>
                        </div>

                        <div class="col-3" v-if="state.zone">
                          <label class="label form-label">
                            {{ this.$t("form.state.zone.label") }}
                          </label>
                        </div>
                        <div class="col-3" v-if="state.zone">
                          <p>{{state.zone.name}}</p>
                        </div>

                        <div class="col-3">
                          <label for="input-live " class="form-label">{{
                         this.$t("form.state.status.label")
                          }}</label>
                        </div>
                        <div class="col-3">
                           <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="state.is_active ? 'checked' : ''"
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
      permission: 'states.index',
      strategy: 'read'
    },
    data() {
      return {
        state: '',
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.states.show(this.$route.params.id)
      this.state = data
    },
    methods: {},
    mounted() {}
  }

</script>
