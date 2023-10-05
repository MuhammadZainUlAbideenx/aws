<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.Edit_new_langauge") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{ this.$t("sidebar.Home") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/languages')">{{ this.$t("sidebar.Language") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.Edit") }}
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

    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live px-2">{{ this.$t("form.Name") }}:</label>
                      <input class="form-control"
                             v-model="formData.name"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="this.$t('form.Enter_your_Name')"
                             trim />
                      <span v-if="error && error.name">
                          {{ error.name[0] }}
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live px-2">{{ this.$t("form.Code") }}:</label>
                      <input class="form-control"
                             v-model="formData.code"
                             aria-describedby="input-live-help input-live-feedback"
                            :placeholder="this.$t('form.Enter_your_Code')"
                             trim />
                      <span v-if="error && error.code">
                          {{ error.code[0] }}
                        </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live px-2">{{ this.$t("form.Direction") }}:</label>
                      <select class="form-select" v-model="formData.direction">
                          <option :value="option.value" v-for="option in options">
                            {{ option.text }}
                          </option>
                        </select>
                      <span v-if="error && error.direction">
                          {{ error.direction[0] }}
                        </span>
                    </div>
                  </div>

                  <div class="col-md-6 my-1 px-4">
                    <label class="label form-label px-2">
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
                <div class="row pt-5">
                  <div class="col-md-12 text-center text-md-start">
                    <button type="button"
                            class="btn btn-secondary mb-3 px-3 py-2"
                            @click="update"
                            name="button">
                      {{ this.$t("form.Update") }}
                      </button>
                    <button type="button"
                            class="btn btn-success mb-3 px-3 py-2"
                            @click="updateAndContinue"
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
          { value: '', text: 'Select your Positioning' },
          { value: 'ltr', text: 'Select ltr Positioning' },
          { value: 'rtl', text: 'Select rtl Positioning' }
        ],
        formData: {
          id: '',
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
    async fetch() {
      const { data } = await this.$repositories.languages.show(this.$route.params.id)
      this.formData.name = data.name
      this.formData.code = data.code
      this.formData.direction = data.direction
      this.formData.is_default = data.is_default
      this.formData.status = data.status
    },
    methods: {
      ...mapActions({
        updateLanguages: 'Languages/updateLanguages',
        fetchActiveLanguages: 'Languages/fetchActiveLanguages',
      }),
      async update() {
        await this.updateAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/languages'))
        }
      },
      async updateAndContinue() {
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
            this.$toast.success('Language Updated Successfully')
            this.fetchActiveLanguages();
          }
        })
      }
    },
    mounted() {}
  }

</script>
