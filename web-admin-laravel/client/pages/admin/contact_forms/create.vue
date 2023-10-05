<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.contact_form.create_new_contact_form") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{
                    this.$t("sidebar.home")
                  }}</nuxt-link>
                </li>
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/contact_forms')">{{
                    this.$t("sidebar.contact_form")
                  }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.create") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.contact_form.form_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content pb-5">
      <div  v-if="$fetchState.pending">
      <AdminFormLoader :multilang='true'/>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">

                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label"
                        >{{
                          this.$t("form.contact_form.slug.label")
                        }}</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.slug"
                      >
                        {{ error.slug[0] }}
                      </span>
                      <input
                        :class="error && error.slug ? 'error' : ''"
                        class="form-control"
                        aria-describedby="input-live-help input-live-feedback"
                        v-model="formData.slug"
                        :placeholder="
                          this.$t('form.contact_form.slug.placeholder')
                        "
                        trim
                      />
                      <span class="px-2 heebo-light">
                        {{ $t("form.contact_form.slug.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.contact_form.status.label") }}
                      </label>
                      <div class="form-switch d-flex">
                        <input
                          class="form-check-input"
                          v-model="formData.is_active"
                          :checked="formData.is_active ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                      <span class="heebo-light">
                        {{ $t("form.contact_form.status.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                 <hr class="text-primary">
                <div class="col-lg-12 py-3">
                  <div class="px-0 pt-3">
                    <h2 class="m-0 text-body bold">
                      {{ $t("form.multilanguage") }}
                    </h2>
                    <p>
                      <span class="heebo-light">
                        {{ $t("form.contact_form.slug.subheading") }}
                      </span>
                    </p>
                    <div class="row">
                      <div class="col-lg-12 px-0 d-md-flex">
                        <ul
                          class="nav nav-tabs d-inline-block"
                          id="myTab"
                          role="tablist "
                        >
                          <li
                            class="nav-item"
                            role="presentation"
                            v-for="(
                              language, index
                            ) in allActiveLanguages.languages"
                            :key="language.id"
                          >
                            <a
                              class="nav-link"
                              :class="index == 0 ? 'active' : ''"
                              :id="language.code + '-tab'"
                              data-bs-toggle="tab"
                              :href="'#' + language.code"
                              role="tab"
                              :aria-controls="language.code"
                              :aria-selected="index == 0 ? 'true' : 'false'"
                              >{{ language.name }}</a
                            >
                          </li>
                        </ul>

                        <div class="tab-content p-4" id="myTabContent">
                          <div
                            class="tab-pane fade"
                            :class="index == 0 ? 'active show' : ''"
                            v-for="(
                              language, index
                            ) in allActiveLanguages.languages"
                            :id="language.code"
                            :key="language.id"
                            role="tabpanel"
                            :aria-labelledby="language.code + '-tab'"
                          >
                            <div class="row">
                              <div class="col-md-6 my-1">
                                <div role="group ">
                                  <label for="input-live" class="form-label"
                                    >{{
                                      $t("form.contact_form.name.label")
                                    }}:</label
                                  >
                                  <span
                                    class="float-end text-danger"
                                    v-if="
                                      error && error['name.' + language.code]
                                    "
                                  >
                                    {{ error["name." + language.code][0] }}
                                  </span>
                                  <input
                                    class="form-control"
                                    :class="
                                      error && error['name.' + language.code]
                                        ? 'error'
                                        : ''
                                    "
                                    v-model="formData.name[language.code]"
                                    aria-describedby="input-live-help input-live-feedback"
                                    :placeholder="
                                      $t('form.contact_form.name.placeholder')
                                    "
                                    trim
                                  />
                                  <span class="heebo-light">
                                    {{
                                      $t("form.contact_form.name.subheading")
                                    }}
                                  </span>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12 my-1">
                                <div role="group ">
                                  <label
                                    for="input-live"
                                    class="px-2 form-label"
                                    >{{
                                      $t("form.contact_form.description.label")
                                    }}:</label
                                  >
                                  <span
                                    class="float-end text-danger"
                                    v-if="
                                      error &&
                                      error['description.' + language.code]
                                    "
                                  >
                                    {{
                                      error["description." + language.code][0]
                                    }}
                                  </span>
                                  <GlobalCkeditorNuxt
                                    v-model="
                                      formData.description[language.code]
                                    "
                                  />
                                  <span class="px-2 heebo-light">
                                    {{
                                      $t(
                                        "form.contact_form.description.subheading"
                                      )
                                    }}
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
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 px-4 text-center text-md-end">
              <button
                type="button"
                class="btn btn-primary mb-3 px-3 py-2"
                @click="add"
                name="button"
              >
                {{ this.$t("form.add") }}
              </button>
              <button
                type="button"
                class="btn btn-success mb-3 px-3 py-2"
                @click="addAndContinue"
                name="button"
              >
                {{ this.$t("form.add_and_continue") }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "contact_forms.create",
    strategy: "create",
  },
 fetch() {

  },
  data() {
    return {
      editorConfig: {
        // The configuration of the editor.
      },
      url: "/backend",
      contact_form_image_path: "",
      formData: {
        name: {},
        description: {},
        slug: "",
        is_active: false,
      },
      error: false,
    };
  },
  methods: {
    ...mapActions({
      addContactForms: "ContactForms/addContactForms",
      fetchActiveContactForms: "General/fetchActiveContactForms",
    }),
    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/contact_forms"));
      }
    },
    async addAndContinue() {
      await this.addContactForms(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.is_active = false;
          this.formData.name = {};
          this.formData.description = {};
          this.formData.slug = "";
          this.$toast.success(res.message);
          this.fetchActiveContactForms();
        }
      });
    },
  },

  mounted() {},
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
    }),
  },
};
</script>
