<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.category.view_category") }}
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
                <nuxt-link :to="localePath('/admin/categories')">{{
                  this.$t("sidebar.category")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.view") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.category.view_description") }}
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
      <AdminViewImageLoader :multilang='true'/>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live form-label">{{
                        this.$t("form.category.image.label")
                      }}</label>
                      <div class="py-2">
                        <img
                          class="img-fluid rounded show-img"
                          width="300px"
                          height="300px"
                          v-if="
                            category &&
                            category.image
                          "
                          v-bind:src="
                            url + `${category.image.original_media_path}`
                          "
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div class="show-table">
                      <div class="row justify-content-end">
                        <div class="col-12">
                          <label for="input-live" class="form-label">{{
                            this.$t("form.category.icon.label")
                          }}</label>
                        </div>
                        <div class="col-12 " v-if="
                                category &&
                                category.icon
                              ">
                          <div class="pb-2">
                            <img
                              class="img-fluid rounded show-icon"

                              v-bind:src="
                                url + `${category.icon.original_media_path}`
                              "
                            />
                          </div>
                        </div>
                        <div class="col-6">
                          <label class="label form-label">
                            {{ this.$t("form.category.status.label") }}
                          </label>
                        </div>
                        <div class="col-6">
                          <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="category.is_active ? 'checked' : ''"
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                            />
                          </div>
                        </div>
                        <div class="col-6">
                          <label class="label form-label">
                            {{ this.$t("form.category.is_featured.label") }}
                          </label>
                        </div>
                        <div class="col-6">
                          <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="category.is_featured ? 'checked' : ''"
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                            />
                          </div>
                        </div>
                        <div class="row px-0" v-if="category.parent">
                            <div class="col-6">
                          <label for="input-live " class="form-label">{{
                            this.$t("form.category.parent_category.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p class="text-primary">
                            {{ category.parent.name }}
                          </p>
                        </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                 <hr class="text-primary">
                <div class="row w-100">
                  <div class="col-lg-12 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">
                        {{ $t("form.multilanguage") }}
                      </h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.product.form_description") }}
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
                                            $t("form.category.name.label")
                                          }}</label>
                                          <div
                                            class="py-3 px-3 rounded shadow-sm border mt-2 show-input"
                                          >
                                            {{
                                              category.nameTranslations[
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
                                            $t(
                                              "form.category.description.label"
                                            )
                                          }}</label>
                                          <div
                                            class="py-3 px-3 shadow-sm rounded border mt-2 show-text-area"
                                            v-html="
                                              category.descriptionTranslations[
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
    permission: "categories.index",
    strategy: "index",
  },
  data() {
    return {
      url: "/backend",
      category: "",
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.categories.show(
      this.$route.params.id
    );
    this.category = data;
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
