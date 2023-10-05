<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.review_status.create_new_review_status") }}
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
                  <nuxt-link :to="localePath('/admin/review_statuses')">{{
                    this.$t("sidebar.review_status")
                  }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.create") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.review_status.form_description") }}
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
        <div class="col-lg-12">
          <div class="card gutter-b border-0">
            <div class="card-body">
              <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.review_status.status.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.is_active"
                          :checked="formData.is_active ? 'checked' : ''"
                          type="checkbox"
                          @change="checkStatus"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>

                    <span class="heebo-light">
                      {{ $t("form.review_status.status.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.review_status.is_default.label") }}
                      </label>

                      <div class="form-switch d-flex align-items-center">
                        <input
                          class="form-check-input"
                          v-model="formData.is_default"
                          :checked="formData.is_default ? 'checked' : ''"
                          type="checkbox"
                          @change="checkDefault"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.review_status.is_default.subheading") }}
                    </span>
                  </div>
              </div>
 <hr class="text-primary">
              <div class="row">
                <div class="col-lg-12 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">{{$t('form.multilanguage')}}</h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.manufacturer.form_description") }}
                        </span>
                      </p>
                      <div class="row">
                        <div class="col-lg-12 d-md-flex px-0">
                          <ul
                            class="nav nav-tabs d-inline-block"
                            id="myTab"
                            role="tablist "
                          >
                            <li class="nav-item" role="presentation"
                              v-for="(language, index) in allActiveLanguages.languages" :key="index">
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
                            <div class="tab-pane fade" :class="index == 0 ? 'active show' : ''" :key="language.code"
                              v-for="(language, index ) in allActiveLanguages.languages" :id="language.code" role="tabpanel" :aria-labelledby="language.code + '-tab'">
                              <div class="row">
                                <div class="col-md-6 my-1">
                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t("form.review_status.name.label")
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
                                        $t('form.review_status.name.placeholder')
                                      "
                                      trim
                                    />
                                    <span class="heebo-light">
                                      {{
                                        $t("form.review_status.name.subheading")
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
                                        $t(
                                          "form.review_status.description.label"
                                        )
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
                                          "form.review_status.description.subheading"
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
        </div>
        <div class="row">
          <div class="col-md-12 px-4 text-center text-md-end">
            <button
              type="button" :disabled="disabled"
              class="btn btn-primary mb-3 px-3 py-2"
              @click="add"
              name="button"
            >
              {{ this.$t("form.add") }}
            </button>
            <!-- <button
              type="button" :disabled="disabled"
              class="btn btn-success mb-3"
              @click="addAndContinue"
              name="button"
            >
              {{ this.$t("form.add_and_continue") }}
            </button> -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script >
// import CkeditorNuxt from "@/components/global/ckeditorNuxt";
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "review_statuses.create",
    strategy: "create",
  },
  fetch() {},
  data() {
    return {
      editorConfig: {
        // The configuration of the editor.
      },
      formData: {
        name: {},
        description: {},
        is_active: false,
        is_default: false,
      },
       disabled:false,
      error: false,
    };
  },
  methods: {
    ...mapActions({
      addReviewStatuses: "ReviewStatuses/addReviewStatuses",
      fetchActiveReviewStatuses: "General/fetchActiveReviewStatuses",
    }),

    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/review_statuses"));
      }
    },
    checkDefault() {
      if (this.formData.is_default == 1) {
        this.formData.is_active = 1;
      }
    },
    checkStatus() {
      if (this.formData.is_active == 0) {
        this.formData.is_default = 0;
      }
    },
    async addAndContinue() {
          this.disabled=true
      await this.addReviewStatuses(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.name = {};
          this.formData.description = {};
          this.formData.is_active = false;
          this.formData.is_default = false;
          this.$toast.success(res.message);
          this.fetchActiveReviewStatuses();
        }
      });
        this.disabled=false
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
