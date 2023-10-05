<template >
  <div >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.news.create_new_news") }}
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
                  <nuxt-link :to="localePath('/admin/news')">{{
                    this.$t("sidebar.news")
                  }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.create") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.news.form_description") }}
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
       <AdminFormLoader :multilang='true'/>
      </div>
      <div class="container" v-else>
        <div class="col-lg-12">
          <div class="card gutter-b border-0">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 my-1 ps-md-0">
                  <label class="label form-label">
                    {{ this.$t("form.news.image.label") }}
                  </label>
                  <span
                    class="float-end text-danger"
                    v-if="error && error.image_id"
                  >
                    {{ error.image_id[0] }}
                  </span>
                  <div class="">
                    <img
                      v-if="news_image_path"
                      v-bind:src="url + `${news_image_path}`"
                      class=""
                    />
                    <div
                      class="btn-media mb-3"
                      type="button"
                      name="button"
                      data-bs-toggle="modal"
                      data-bs-target="#selectNewsMedia"
                    >
                      {{ $t("form.select_media") }}
                    </div>
                    <AdminMediaModal
                      type="images"
                      bind_modal="image_id"
                      img_var="news_image_path"
                      modal_id="selectNewsMedia"
                      @selectImage="imageSelected"
                      redirect_panel="admin"
                    />
                  </div>

                  <span class=" heebo-light">
                    {{ $t("form.news.image.subheading") }}
                  </span>
                </div>
                <div class="col-md-6 my-1 pe-md-0">
                  <div role="group">
                    <label for="input-live" class="form-label"
                      >{{ this.$t("form.news.news_category.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error.news_category_id"
                    >
                      {{ error.news_category_id[0] }}
                    </span>

                    <AdminSearchSelectable :class="error && error.news_category_id ? 'error' : ''" apiMethod="activeNewsCategories" responseKey="news_categories"
                      :initialOptions="allActiveNewsCategories.news_categories" :placeholder="this.$t('form.news.news_category.placeholder')" v-model="formData.news_category_id" />


                    <span class="heebo-light">
                      {{ $t("form.news.news_category.subheading") }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div
                  class="col-md-6 my-1 ps-md-0 d-flex justify-content-center flex-column"
                >
                  <div class="d-flex align-items-center">
                    <label class="label form-label me-4 text-capitalize">
                      {{ this.$t("form.news.is_featured.label") }}
                    </label>

                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        v-model="formData.is_featured"
                        :checked="formData.is_featured ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                    </div>
                  </div>

                  <span class="heebo-light">
                    {{ $t("form.news.is_featured.subheading") }}
                  </span>
                </div>
                <div
                  class="col-md-6 my-1 pe-md-0 d-flex justify-content-center flex-column"
                >
                  <div class="d-flex align-items-center">
                    <label class="label form-label me-4 text-capitalize">
                      {{ this.$t("form.news.status.label") }}
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
                    {{ $t("form.news.status.subheading") }}
                  </span>
                </div>
              </div>
               <hr class="text-primary">
              <div class="row">
                <div class="col-lg-12 pt-2 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">{{ $t("form.multilanguage") }}</h2>
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
                                        $t("form.news.name.label")
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
                                        $t('form.news.name.placeholder')
                                      "
                                      trim
                                    />
                                    <span class="heebo-light">
                                      {{
                                        $t("form.news.name.subheading")
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
                                          "form.news.description.label"
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
                                          "form.news.description.subheading"
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
              type="button"
              class="btn btn-primary mb-3 px-3 py-2"
              @click="add"
              name="button"
            >
              {{ this.$t("form.add") }}
            </button>
            <!-- <button
              type="button"
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
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "newses.create",
    strategy: "create",
  },
  async fetch() {
    if (!this.allActiveMedia.media) {
      await this.fetchActiveMedia();
    }
    if (!this.allActiveNewsCategories.news_categories) {
      await this.fetchActiveNewsCategories();
    }
  },
  data() {
    return {
      editorConfig: {
        // The configuration of the editor.
      },
      url: "/backend",
      news_image_path: "",
      formData: {
        name: {},
        news_category_id: "",
        description: {},
        is_active: false,
        is_featured: false,
        image_id: "",
      },
      error: false,
    };
  },
  methods: {
    ...mapActions({
      addNewses: "Newses/addNewses",
      fetchActiveNewses: "General/fetchActiveNewses",
      fetchActiveNewsCategories: "General/fetchActiveNewsCategories",
      fetchActiveMedia: "General/fetchActiveMedia",
    }),
    imageSelected(id, path, img_resource, modal) {
      this.formData[modal] = id;
      this[img_resource] = path;
    },
    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/news"));
      }
    },
    async addAndContinue() {
      await this.addNewses(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.name = {};
          (this.news_category_id = ""), (this.formData.description = {});
          this.formData.is_active = false;
          this.formData.is_fetured = false;
          this.formData.image_id = "";
          this.news_image_path = "";
          this.$toast.success(res.message);
          this.fetchActiveNewses();
        }
      });
    },
  },

  mounted() {},
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
      allActiveNewsCategories: "General/allActiveNewsCategories",
      allActiveMedia: "General/allActiveMedia",
    }),
  },
};
</script>
