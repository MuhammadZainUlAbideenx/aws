<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("Order_Status.view_product") }}
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
                <nuxt-link :to="localePath('/admin/products')">{{
                  this.$t("sidebar.product")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.view") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("product.view_description") }}
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
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 my-1">
                    <div class="show-table">
                      <div class="row justify-content-end">
                        <div class="col-3">
                          <label class="label form-label">
                            {{
                              this.$t("form.shipping_method.is_default.label")
                            }}
                          </label>
                        </div>
                        <div class="col-3">
                          <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="
                                shipping_methods.is_default ? 'checked' : ''
                              "
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                            />
                          </div>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.shipping_method.status.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="
                                shipping_methods.is_active ? 'checked' : ''
                              "
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                            />
                          </div>
                        </div>
                        <div
                          v-if="shipping_methods.settings"
                          v-for="(setting, index) in shipping_methods.settings"
                          :key="index"
                        >
                          <div class="col-3">
                            {{ shipping_methods.settings[index].name }}
                            <div class="col-3">
                              <p>
                                {{ shipping_methods.settings[index].value }}
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="text-primary" />
                <div class="row w-100">
                  <div class="col-lg-12">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">
                        {{ $t("form.multilanguage") }}
                      </h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.product.website_url.subheading") }}
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
                                            $t(
                                              "form.shipping_methods.name.label"
                                            )
                                          }}</label>
                                          <div
                                            class="
                                              py-3
                                              px-3
                                              rounded
                                              shadow-sm
                                              border
                                              mt-2
                                              show-input
                                            "
                                          >
                                            {{
                                              shipping_methods.nameTranslations[
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
                                              "form.shipping_methods.description.label"
                                            )
                                          }}</label>
                                          <div
                                            class="
                                              py-3
                                              px-3
                                              shadow-sm
                                              rounded
                                              border
                                              mt-2
                                              show-text-area
                                            "
                                            v-html="
                                              shipping_methods
                                                .descriptionTranslations[
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
    permission: "shipping_methods.index",
    strategy: "read",
  },
  data() {
    return {
      shipping_methods: "",
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.shipping_methods.show(
      this.$route.params.id
    );
    this.shipping_methods = data;
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
