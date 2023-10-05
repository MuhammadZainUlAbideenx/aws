<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0 mb-2">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("sidebar.newsletter") }}
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
                  <nuxt-link :to="localePath('/admin/newsletters')">{{ this.$t("sidebar.newsletter") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.view") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.newsletter.view_description") }}
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
      <AdminViewLoader :multilang='true' />
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 my-1 ps-md-0">
                       <div class="show-table mb-3">
                      <div class="row justify-content-end">
                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.newsletter.is_verified.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <div class="form-switch">
                            <input class="form-check-input"
                            :checked="newsletters.is_verified ? 'checked' : ''"
                            type="checkbox"
                            id="flexSwitchCheckChecked"
                             disabled/>
                          </div>
                        </div>
                        <div class="col-3">
                            <label for="input-live form-label">{{
                                this.$t("form.newsletter.email.label")
                            }}</label>
                        </div>
                        <div class="col-3"><p>{{ newsletters.email }}</p></div>
                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.newsletter.status.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <div class="form-switch">
                            <input class="form-check-input"
                            :checked="newsletters.is_active ? 'checked' : ''"
                            type="checkbox"
                            id="flexSwitchCheckChecked"
                            disabled />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                 <!-- <hr class="text-primary"> -->

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
      permission: 'newsletters.index',
      strategy: 'read'
    },
    data() {
      return {
        options: [
          { value: '', text: 'Select your Positioning' },
          { value: 'ltr', text: 'Select ltr Positioning' },
          { value: 'rtl', text: 'Select rtl Positioning' }
        ],
        newsletters: '',
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.newsletter.show(this.$route.params.id)
      this.newsletters = data
    },
    methods: {},
    mounted() {},
    computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
    }),
  },
  }

</script>
