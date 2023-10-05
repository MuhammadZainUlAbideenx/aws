<template >

  <div class="py-5">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.Create_new_langauge") }}
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
                  {{ this.$t("form.Create") }}
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
    <section class="content pb-5">
      <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">
              <div class="col-lg-12">
                <div class="card gutter-b border-0">
                  <div class="card-body p-4">
                    <div class="row">
                      <div class="col-md-6 my-1 px-4">
                        <div role="group ">
                          <label for="input-live" class="px-2 form-label">{{ this.$t("form.Name") }}:</label>
                          <span class="float-end text-danger"
                                v-if="error && error.name">
                              {{ error.name[0] }}
                            </span>
                          <input class="form-control"
                                 :class="error && error.name ? 'error' : ''"
                                 v-model="formData.name"
                                 aria-describedby="input-live-help input-live-feedback"
                                 :placeholder="this.$t('form.Enter_your_Name')"
                                 trim />
                          <span class="px-2 heebo-light">
                              {{ this.$t("form.SubHeading") }}
                            </span>
                        </div>
                      </div>
                      <div class="col-md-6 my-1 px-4">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label">{{ this.$t("form.Code") }}:</label>
                          <span class="float-end text-danger"
                                v-if="error && error.code">
                              {{ error.code[0] }}
                            </span>
                          <input :class="error && error.name ? 'error' : ''"
                                 class="form-control"
                                 v-model="formData.code"
                                 aria-describedby="input-live-help input-live-feedback"
                                 :placeholder="this.$t('form.Enter_your_Code')"
                                 trim />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 my-1 px-4">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label">{{ this.$t("form.Direction") }}:</label>
                          <span class="float-end text-danger"
                                v-if="error && error.direction">
                              {{ error.direction[0] }}
                            </span>
                          <select :class="error && error.name ? 'error' : ''"
                                  class="form-select"
                                  v-model="formData.direction">
                              <option :value="option.value" v-for="option in options">
                                {{ option.text }}
                              </option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6 my-1 px-4">
                        <label class="label form-label">
                            {{ this.$t("form.status") }}
                          </label>

                        <div class="form-switch d-flex align-items-center">
                          <input class="form-check-input"
                                 :checked="formData.status ? 'checked' : ''"
                                 type="checkbox"
                                 id="flexSwitchCheckChecked" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 px-4 text-center text-md-start">
                        <button type="button"
                                class="btn btn-primary mb-3 px-3 py-2"
                                @click="add"
                                name="button">
                            {{ this.$t("form.Add") }}
                          </button>
                        <button type="button"
                                class="btn btn-success mb-3 px-3 py-2"
                                @click="addAndContinue"
                                name="button">
                            {{ this.$t("form.Continue") }}
                          </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row">
              <div class="col-lg-12">
                <div class="card gutter-b border-0">
                  <div class="card-body p-4">
                    <div class="row">
                      <div class="col-md-6 my-1 px-4">
                        <div role="group ">
                          <label for="input-live" class="px-2 form-label">{{ this.$t("form.Name") }}:</label>
                          <span class="float-end text-danger"
                                v-if="error && error.name">
                              {{ error.name[0] }}
                            </span>
                          <input class="form-control"
                                 :class="error && error.name ? 'error' : ''"
                                 v-model="formData.name"
                                 aria-describedby="input-live-help input-live-feedback"
                                 :placeholder="this.$t('form.Enter_your_Name')"
                                 trim />
                          <span class="px-2 heebo-light">
                              {{ this.$t("form.SubHeading") }}
                            </span>
                        </div>
                      </div>
                      <div class="col-md-6 my-1 px-4">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label">{{ this.$t("form.Code") }}:</label>
                          <span class="float-end text-danger"
                                v-if="error && error.code">
                              {{ error.code[0] }}
                            </span>
                          <input :class="error && error.name ? 'error' : ''"
                                 class="form-control"
                                 v-model="formData.code"
                                 aria-describedby="input-live-help input-live-feedback"
                                 :placeholder="this.$t('form.Enter_your_Code')"
                                 trim />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 my-1 px-4">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label">{{ this.$t("form.Direction") }}:</label>
                          <span class="float-end text-danger"
                                v-if="error && error.direction">
                              {{ error.direction[0] }}
                            </span>
                          <select :class="error && error.name ? 'error' : ''"
                                  class="form-select"
                                  v-model="formData.direction">
                              <option :value="option.value" v-for="option in options">
                                {{ option.text }}
                              </option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6 my-1 px-4">
                        <label class="label form-label">
                            {{ this.$t("form.status") }}
                          </label>

                        <div class="form-switch d-flex align-items-center">
                          <input class="form-check-input"
                                 :checked="formData.status ? 'checked' : ''"
                                 type="checkbox"
                                 id="flexSwitchCheckChecked" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 px-4 text-center text-md-start">
                        <button type="button"
                                class="btn btn-primary mb-3 px-3 py-2"
                                @click="add"
                                name="button">
                            {{ this.$t("form.Add") }}
                          </button>
                        <button type="button"
                                class="btn btn-success mb-3 px-3 py-2"
                                @click="addAndContinue"
                                name="button">
                            {{ this.$t("form.Continue") }}
                          </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="row">
              <div class="col-lg-12">
                <div class="card gutter-b border-0">
                  <div class="card-body p-4">
                    <div class="row">
                      <div class="col-md-6 my-1 px-4">
                        <div role="group ">
                          <label for="input-live" class="px-2 form-label">{{ this.$t("form.Name") }}:</label>
                          <span class="float-end text-danger"
                                v-if="error && error.name">
                              {{ error.name[0] }}
                            </span>
                          <input class="form-control"
                                 :class="error && error.name ? 'error' : ''"
                                 v-model="formData.name"
                                 aria-describedby="input-live-help input-live-feedback"
                                 :placeholder="this.$t('form.Enter_your_Name')"
                                 trim />
                          <span class="px-2 heebo-light">
                              {{ this.$t("form.SubHeading") }}
                            </span>
                        </div>
                      </div>
                      <div class="col-md-6 my-1 px-4">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label">{{ this.$t("form.Code") }}:</label>
                          <span class="float-end text-danger"
                                v-if="error && error.code">
                              {{ error.code[0] }}
                            </span>
                          <input :class="error && error.name ? 'error' : ''"
                                 class="form-control"
                                 v-model="formData.code"
                                 aria-describedby="input-live-help input-live-feedback"
                                 :placeholder="this.$t('form.Enter_your_Code')"
                                 trim />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 my-1 px-4">
                        <div role="group">
                          <label for="input-live" class="px-2 form-label">{{ this.$t("form.Direction") }}:</label>
                          <span class="float-end text-danger"
                                v-if="error && error.direction">
                              {{ error.direction[0] }}
                            </span>
                          <select :class="error && error.name ? 'error' : ''"
                                  class="form-select"
                                  v-model="formData.direction">
                              <option :value="option.value" v-for="option in options">
                                {{ option.text }}
                              </option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6 my-1 px-4">
                        <label class="label form-label">
                            {{ this.$t("form.status") }}
                          </label>

                        <div class="form-switch d-flex align-items-center">
                          <input class="form-check-input"
                                 :checked="formData.status ? 'checked' : ''"
                                 type="checkbox"
                                 id="flexSwitchCheckChecked" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 px-4 text-center text-md-start">
                        <button type="button"
                                class="btn btn-primary mb-3 px-3 py-2"
                                @click="add"
                                name="button">
                            {{ this.$t("form.Add") }}
                          </button>
                        <button type="button"
                                class="btn btn-success mb-3 px-3 py-2"
                                @click="addAndContinue"
                                name="button">
                            {{ this.$t("form.Continue") }}
                          </button>
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
      permission: 'languages.create',
      strategy: 'create'
    },
    async asyncData({ params }) {},
    data() {
      return {
        options: [
          { value: '', text: 'Select your Positioning' },
          { value: 'ltr', text: 'Select ltr Positioning' },
          { value: 'rtl', text: 'Select rtl Positioning' }
        ],
        formData: {
          name: '',
          code: '',
          direction: '',
          is_default: false,
          status: false,
          image_id: 1
        },
        error: false
      }
    },
    methods: {
      ...mapActions({
        addLanguages: 'Languages/addLanguages',
        fetchActiveLanguages: 'Languages/fetchActiveLanguages',

      }),
      async add() {
        await this.addAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/languages'))
        }
      },
      async addAndContinue() {
        await this.addLanguages(this.formData).then(res => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data
            this.$toast.error(res.response.data.message)

          } else {
            this.error = false
            this.formData.name = ''
            this.formData.code = ''
            this.formData.direction = ''
            this.formData.is_default = false
            this.formData.status = false
            this.$toast.success('Language Added Successfully')
            this.fetchActiveLanguages();
          }
        })
      }
    },
    computed: {
      ...mapGetters({
        allLanguages: 'Languages/allLanguages'
      })
    },
    mounted() {}
  }

</script>
