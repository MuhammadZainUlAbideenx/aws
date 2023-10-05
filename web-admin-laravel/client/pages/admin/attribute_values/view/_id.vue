<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("attribute_value.view_attribute_value") }}
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
                <nuxt-link :to="localePath('/admin/attribute_value_values')">{{
                  this.$t("sidebar.attribute_value")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.view") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("attribute_value.view_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content">
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
            <div class="card gutter-b border-0">
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-md-6">
                    <div class="show-table">
                      <div class="row justify-content-end">
                        <div class="col-6">
                          <label class="label form-label">
                            {{ this.$t("form.attribute_value.status.label") }}
                          </label>
                        </div>
                        <div class="col-6">
                          <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="attribute_value.is_active ? 'checked' : ''"
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
                 <hr class="text-primary">
                <div class="row w-100">
                  <div class="col-lg-12">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">
                        {{ $t("form.multilanguage") }}
                      </h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.attribute_value.subheading") }}
                        </span>
                      </p>
                    </div>
                    <div class="d-md-flex">
                      <div class="row">
                        <div class="col-md-12 px-0">
                          <ul
                            class="nav nav-tabs px-0"
                            id="myTab"
                            role="tablist"
                          >
                            <li
                              class="nav-item"
                              role="presentation"
                              v-for="(
                                language, index
                              ) in allActiveLanguages.languages"
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
                        </div>
                      </div>
                      <div class="row w-100">
                        <div class="col-lg-12 px-0">
                          <div class="">
                            <div class="">
                              <div class="tab-content p-4" id="myTabContent">
                                <div
                                  class="tab-pane fade"
                                  :class="index == 0 ? 'active show' : ''"
                                  v-for="(
                                    language, index
                                  ) in allActiveLanguages.languages"
                                  :id="language.code"
                                  role="tabpanel"
                                  :aria-labelledby="language.code + '-tab'"
                                >
                                  <div class="row">
                                    <div class="col-md-6 my-1">
                                      <div role="group ">
                                        <div role="group">
                                          <label for="input-live form-label">{{
                                            $t("form.attribute_value.name.label")
                                          }}</label>
                                          <div
                                            class="py-3 px-3 rounded shadow-sm border mt-2 show-input"
                                          >
                                            {{
                                              attribute_value.nameTranslations[
                                                language.code
                                              ]
                                            }}
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12 my-1">
                                      <div role="group ">
                                        <div role="group">
                                          <label for="input-live form-label">{{
                                            $t("form.attribute_value.description.label")
                                          }}</label>
                                          <div
                                            class="py-3 px-3 shadow-sm rounded border mt-2 show-text-area"
                                            v-html="
                                              attribute_value.descriptionTranslations[
                                                language.code
                                              ]
                                            "
                                          ></div>
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
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "attribute_value_values.index",
    strategy: "read",
  },
  data() {
    return {
      attribute_value: "",
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.attribute_value_values.show(this.$route.params.id);
    this.attribute_value = data;
  },
  methods: {},
  mounted() {},
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
    }),
  },
};
</script>
