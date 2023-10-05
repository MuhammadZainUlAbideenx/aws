<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.language.edit_language") }}
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
                  <nuxt-link :to="localePath('/admin/languages')">{{ this.$t("sidebar.language") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.language.edit_description") }}
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
                      <label for="input-live" class="px-2 form-label">{{ this.$t("form.language.name.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.name">
                          {{ error.name[0] }}
                        </span>
                      <input class="form-control"
                             :class="error && error.name ? 'error' : ''"
                             v-model="formData.name"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.language.name.placeholder')"
                             trim />
                      <span class="px-2 heebo-light">
                          {{ this.$t("form.language.name.subheading") }}
                        </span>
                    </div>
                  </div>
                    <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.language.code.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.code"
                      >
                        {{ error.code[0] }}
                      </span>
                      <v-select
                        class=""
                        :placeholder="this.$t('form.language.code.placeholder')"
                        v-model="formData.code"
                        :reduce="(opt) => opt.code"
                        label="code"
                        :options="allActiveLanguageCodes.language_codes"
                      >
                        <template slot="no-options">
                          {{ $t("form.search_select.no_options") }}
                        </template>
                        <template slot="option" slot-scope="option">
                          <div class="d-center">
                            {{ option.code }}
                          </div>
                        </template>
                        <template slot="selected-option" slot-scope="option">
                          <div class="selected d-center">
                            {{ option.code }}
                          </div>
                        </template>
                      </v-select>
                      <span class="heebo-light">
                        {{ $t("form.language.code.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.language.direction.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.direction">
                          {{ error.direction[0] }}
                        </span>
                        <v-select
                          :placeholder="this.$t('form.language.direction.placeholder')"
                          v-model="formData.direction"
                          :reduce="(opt) => opt.value"
                          label="direction"
                          :options="options"
                        >
                          <template slot="no-options">
                            {{ $t("form.search_select.no_options") }}
                          </template>
                          <template slot="option" slot-scope="option">
                            <div class="d-center">
                              {{ option.value }}
                            </div>
                          </template>
                          <template slot="selected-option" slot-scope="option">
                            <div class="selected d-center">
                              {{ option.value }}
                            </div>
                          </template>
                        </v-select>
                        <span class="heebo-light">
                            {{ $t("form.language.direction.subheading") }}
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6  my-1 d-flex justify-content-center flex-column pe-md-0">
                      <div class="d-flex align-items-center ">
                          <label class="label form-label me-4 text-capitalize">
                            {{ this.$t("form.language.status.label") }}
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
                          {{ $t("form.language.status.subheading") }}
                        </span>
                    </div>
                </div>

              </div>
            </div>
            <div class="row">
                  <div class="col-md-12 px-4 text-md-end">
                    <button type="button" :disabled="disabled"
                            class="btn btn-secondary mb-3 px-3 py-2"
                            @click="update"
                            name="button">
                        {{ this.$t("form.update") }}
                      </button>
                    <!-- <button type="button" :disabled="disabled"
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
      permission: 'languages.update',
      strategy: 'update'
    },
    data() {
      return {
        options: [
          { value: 'ltr', text: 'Select ltr Positioning' },
          { value: 'rtl', text: 'Select rtl Positioning' }
        ],
        formData: {
          id: '',
          name: '',
          code: '',
          direction: '',
          is_default: false,
          is_active: false,
          image_id: 1
        },
         disabled:false,
        error: false
      }
    },
    async fetch() {
      if (!this.allActiveLanguageCodes.language_codes) {
      await this.fetchActiveLanguageCodes();
    }
      const { data } = await this.$repositories.languages.show(this.$route.params.id)
      this.formData.name = data.name
      this.formData.code = data.code
      this.formData.direction = data.direction
      this.formData.is_default = data.is_default
      this.formData.is_active = data.is_active
    },
    methods: {
      ...mapActions({
        updateLanguages: 'Languages/updateLanguages',
        fetchActiveLanguages: "General/fetchActiveLanguages",
      fetchActiveLanguageCodes: "General/fetchActiveLanguageCodes",
      }),
      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/languages'))
        }
      },
      async updateAndContinue() {
          this.disabled=true
        await this.updateLanguages({
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
            this.fetchActiveLanguages();
          }
        });
         this.disabled=false
      }
    }, computed: {
    ...mapGetters({
      allActiveLanguageCodes: "General/allActiveLanguageCodes",
    }),
  },
    mounted() {}
  }

</script>
