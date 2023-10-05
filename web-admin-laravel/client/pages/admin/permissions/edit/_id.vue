<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.permission.edit_permission") }}
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
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.permission.edit_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- Main content -->
    <section class="content pb-5">
      <div class="container" v-if="$fetchState.pending">
        <div class="row">
          <div class="col-md-12">
            <AdminLoader />
          </div>
        </div>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0" >
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-md-6 my-1 px-4" >
                    <div permission="group ">
                      <label for="input-live" class="px-2 form-label">{{ $t("form.permission.name.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.name[0]">
                          {{ error.name[0] }}
                        </span>
                      <input class="form-control"
                             :class="error && error.name ? 'error' : ''"
                             v-model="formData.name"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="$t('form.permission.name.placeholder')"
                             trim />
                      <span class="px-2 heebo-light">
                          {{ $t("form.permission.name.subheading") }}
                        </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" permission="tablist">
                      <li class="nav-item" permission="presentation" :key="index" v-for="(language,index) in allActiveLanguages.languages">
                        <a class="nav-link" :class="index == 0 ? 'active':''" :id="language.code+'-tab'" data-bs-toggle="tab" :href="'#' + language.code" permission="tab" :aria-controls="language.code" :aria-selected="index == 0 ? 'true':'false'">{{language.name}}</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card gutter-b border-0" >
                      <div class="card-body p-4">
                        <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade" :class="index == 0 ? 'active show':''" :key="language.code" v-for="(language,index) in allActiveLanguages.languages" :id="language.code" permission="tabpanel" :aria-labelledby="language.code+'-tab'">
                              <div class="row">
                                <div class="col-md-6 my-1 px-4" >
                                  <div permission="group ">
                                    <label for="input-live" class="px-2 form-label">{{ $t("form.permission.display_name.label") }}:</label>
                                    <span class="float-end text-danger"
                                          v-if="error && error['display_name.' + language.code]">
                                        {{ error['display_name.'+language.code][0] }}
                                      </span>
                                    <input class="form-control"
                                           :class="error && error['display_name.'+language.code] ? 'error' : ''"
                                           v-model="formData.display_name[language.code]"
                                           aria-describedby="input-live-help input-live-feedback"
                                           :placeholder="$t('form.permission.display_name.placeholder')"
                                           trim />
                                    <span class="px-2 heebo-light">
                                        {{ $t("form.permission.display_name.subheading") }}
                                      </span>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 my-1 px-4" >
                                  <div permission="group ">
                                    <label for="input-live" class="px-2 form-label">{{ $t("form.permission.description.label") }}:</label>
                                    <span class="float-end text-danger"
                                          v-if="error && error['description.' + language.code]">
                                        {{ error['description.'+language.code][0] }}
                                      </span>
                                      <GlobalCkeditorNuxt v-model="formData.description[language.code]"/>
                                    <span class="px-2 heebo-light">
                                        {{ $t("form.permission.description.subheading") }}
                                      </span>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 px-4 text-center text-md-start">
                    <button type="button"
                            class="btn btn-secondary mb-3 px-3 py-2"
                            @click="update"
                            name="button">
                        {{ this.$t("form.update") }}
                      </button>
                    <button type="button"
                            class="btn btn-success mb-3 px-3 py-2"
                            @click="updateAndContinue"
                            name="button">
                        {{ this.$t("form.update_and_continue") }}
                      </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- /.content -->

    <!-- /.content -->
  </div>

</template>
<script >

  import { mapGetters, mapActions } from 'vuex'

  export default {
    layout: 'admin',
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'permissions.update',
      strategy: 'update'
    },
    data() {
      return {
        formData: {
          name: '',
          description:{},
          display_name:{},

        },
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.permissions.show(this.$route.params.id)
      // get and update data
      this.formData.name = data.name
      this.formData.description = data.descriptionTranslations
      this.formData.display_name = data.display_nameTranslations
    },
    methods: {
      ...mapActions({
        updatePermissions: 'Permissions/updatePermissions',
        fetchActivePermissions: 'General/fetchActivePermissions',
      }),

      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/permissions'))
        }
      },
      async updateAndContinue() {
        await this.updatePermissions({
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
            this.fetchActivePermissions();
          }
        })
      }
    },
    mounted() {},
    computed:{
      ...mapGetters({
        allActiveLanguages: 'General/allActiveLanguages'
      })
    }
  }

</script>
