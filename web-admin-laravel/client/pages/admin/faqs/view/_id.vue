<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.faqs.view_faq") }}
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
                <nuxt-link :to="localePath('/admin/faqs')">{{
                  this.$t("sidebar.faq")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.view") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.faqs.view_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>

    <section class="content">
      <div v-if="$fetchState.pending">
        <AdminViewImageLoader :multilang="true" />
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
                        this.$t("form.faqs.image")
                      }}</label>
                      <div class="py-2">
                        <img
                          class="img-fluid rounded show-img"
                          width="300px"
                          height="300px"
                          v-if="faqs && faqs.product.media[0]"
                          v-bind:src="url + `${faqs.product.media[0].thumbnails[2].thumbnail}`"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div class="show-table">
                      <div class="row justify-content-end">
                        <div class="col-6">
                        <label for="input-live form-label">
                            {{this.$t("form.faqs.product.name.label")}}
                        </label>
                         </div>
                         <div class="col-6">
                             <p>{{ faqs.product.name }}</p>
                        </div>
                        <div class="col-6">
                        <label for="input-live form-label">
                            {{this.$t("form.faqs.product.short_description.label")}}
                        </label>
                         </div>
                         <div class="col-6">
                             <p>{{ faqs.product.short_description }}</p>
                        </div>
                        <div class="col-6">
                          <label class="label form-label pe-4">
                            {{ this.$t("form.faqs.status.label") }}
                          </label>
                        </div>
                        <div class="col-6">
                          <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="faqs.is_active ? 'checked' : ''"
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
                <hr class="text-primary" />
                <div class="row w-100">
                  <div class="col-lg-12 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">
                        {{ $t("form.multilanguage") }}
                      </h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.faqs.form_description") }}
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
                                  :key="language.id"
                                >
                                  <div class="row">
                                    <div class="col-md-6 my-1">
                                      <div role="group ">
                                        <div role="group">
                                          <label
                                            for="input-live"
                                            class="form-label"
                                            >{{
                                              $t("form.faqs.question.label")
                                            }}</label
                                          >
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
                                              faqs.questionTranslations[
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
                                          <label
                                            for="input-live"
                                            class="form-label"
                                            >{{
                                              $t("form.faqs.answer.label")
                                            }}</label
                                          >
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
                                              faqs.answerTranslations[
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
    permission: "faqs.index",
    strategy: "read",
  },
  data() {
    return {
      url: "/backend",
      faqs: "",
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.faqs.show(this.$route.params.id);
    this.faqs = data;
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
