<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.role.edit_role") }}
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
                <nuxt-link :to="localePath('/admin/roles')">{{
                  this.$t("sidebar.role")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.edit") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.role.edit_description") }}
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
        <AdminFormLoader :multilang="true" />
      </div>
      <div class="container" v-else>
        <div class="col-lg-12">
          <div class="card gutter-b border-0">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 my-1 ps-md-0">
                  <div role="group ">
                    <label for="input-live" class="form-label"
                      >{{ $t("form.role.name.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error['display_name']"
                    >
                      {{ error.display_name[0] }}
                    </span>
                    <input
                      class="form-control"
                      :class="error && error.display_name ? 'error' : ''"
                      v-model="formData.display_name"
                      aria-describedby="input-live-help input-live-feedback"
                      :placeholder="$t('form.role.name.placeholder')"
                      trim
                    />
                    <span class="heebo-light">
                      {{ $t("form.role.name.subheading") }}
                    </span>
                  </div>
                </div>
                <div
                  class="
                    col-md-6
                    my-1
                    pe-md-0
                    d-flex
                    justify-content-center
                    flex-column
                  "
                >
                  <div class="d-flex align-items-center">
                    <label class="label form-label me-4 text-capitalize">
                      {{ this.$t("form.role.status.label") }}
                    </label>

                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        v-model="formData.is_active"
                        :checked="formData.is_active ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                    </div>
                  </div>

                  <span class="heebo-light">
                    {{ $t("form.role.status.subheading") }}
                  </span>
                </div>
              </div>
              <hr class="text-primary" />
              <div class="row">
                <div class="col-lg-12 pt-3 px-0">
                  <div class="px-0 pt-3">
                    <h2 class="m-0 text-body bold">
                      {{ $t("form.multilanguage") }}
                    </h2>
                    <p>
                      <span class="heebo-light">
                        {{ $t("lorem_ipsum") }}
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
                            :key="index"
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
                            :key="language.code"
                            :id="language.code"
                            role="tabpanel"
                            :aria-labelledby="language.code + '-tab'"
                          >
                            <div class="row">
                              <div class="col-md-12 my-1">
                                <div role="group ">
                                  <label
                                    for="input-live"
                                    class="px-2 form-label"
                                    >{{
                                      $t("form.role.description.label")
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
                                    {{ $t("form.role.description.subheading") }}
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
              type="button"
              class="btn btn-secondary mb-3 px-3 py-2"
              @click="update"
              name="button"
            >
              {{ this.$t("form.update") }}
            </button>
            <!-- <button type="button"
                            class="btn btn-success mb-3"
                            @click="updateAndContinue"
                            name="button">
                        {{ this.$t("form.update_and_continue") }}
                      </button> -->
          </div>
        </div>
      </div>
    </section>

    <!-- /.content -->

    <!-- /.content -->
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";

export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "roles.update",
    strategy: "update",
  },
  data() {
    return {
      formData: {
        description: {},
        display_name: "",
        is_active: false,
      },
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.roles.show(this.$route.params.id);
    // get and update data
    this.formData.description = data.descriptionTranslations;
    this.formData.display_name = data.display_name;
    this.formData.is_active = data.is_active;
  },
  methods: {
    ...mapActions({
      updateRoles: "Roles/updateRoles",
      fetchActiveRoles: "General/fetchActiveRoles",
    }),

    async update() {
      await this.updateAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/roles"));
      }
    },
    async updateAndContinue() {
      await this.updateRoles({
        formData: this.formData,
        id: this.$route.params.id,
      }).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else if (res.state == "fail") {
          this.$toast.error(res.message);
        } else {
          this.error = false;
          this.$toast.success(res.message);
          this.fetchActiveRoles();
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
