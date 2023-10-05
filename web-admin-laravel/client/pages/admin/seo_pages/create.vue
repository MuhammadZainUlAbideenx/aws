<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.seo_page.create_new_seo_page") }}
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
              <li class="breadcrumb-item active">
                {{ this.$t("sidebar.seo_page") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.seo_page.form_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content seo-section pb-5">
      <div v-if="$fetchState.pending">
          <AdminFormLoader/>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.seo_page.seo_type.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.seo_type"
                      >
                        {{ error.seo_type[0] }}
                      </span>
                      <v-select
                        v-on:input="seoTypeChanged"
                        class=""
                        :placeholder="
                          this.$t('form.seo_page.seo_type.placeholder')
                        "
                        v-model="formData.seo_type"
                        :reduce="(opt) => opt.value"
                        label="seo_type"
                        :options="options"
                      >
                        <template slot="no-options">
                          {{ $t("form.search_select.no_options") }}
                        </template>
                        <template slot="option" slot-scope="option">
                          <div class="d-center">
                            {{ option.text }}
                          </div>
                        </template>
                        <template slot="selected-option" slot-scope="option">
                          <div class="selected d-center">
                            {{ option.text }}
                          </div>
                        </template>
                      </v-select>
                      <span class="heebo-light">
                        {{ $t("form.seo_page.seo_type.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div
                    class="col-md-6 my-1 pe-md-0"
                    v-if="formData.seo_type == 'product'"
                  >
                    <div role="group ">
                      <div class="d-flex align-items-center">
                        <label class="label form-label me-4 text-capitalize">
                          {{ $t("form.seo_page.product.label") }}
                        </label>
                      </div>
                      <span
                        class="float-end text-danger"
                        v-if="error && error['product_id']"
                      >
                        {{ error.product[0] }}
                      </span>
                      <AdminSearchSelectable
                        key="1"
                        @input="itemChanged('products', 'product_id')"
                        :class="error && error.product_id ? 'error' : ''"
                        apiMethod="activeProducts"
                        responseKey="products"
                        :initialOptions="allActiveProducts.products"
                        :placeholder="
                          this.$t('form.seo_page.product.placeholder')
                        "
                        v-model="formData.product_id"
                      />
                      <span class="heebo-light">
                        {{ $t("form.seo_page.product.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div
                    class="col-md-6 my-1 pe-md-0"
                    v-if="formData.seo_type == 'category'"
                  >
                    <div role="group ">
                      <div class="d-flex align-items-center">
                        <label class="label form-label me-4 text-capitalize">
                          {{ $t("form.seo_page.category.label") }}
                        </label>
                      </div>
                      <span
                        class="float-end text-danger"
                        v-if="error && error['category_id']"
                      >
                        {{ error.category[0] }}
                      </span>
                      <AdminSearchSelectable
                        key="2"
                        @input="itemChanged('categories', 'category_id')"
                        :class="error && error.category_id ? 'error' : ''"
                        apiMethod="activeParentChildCategories"
                        responseKey="categories"
                        :initialOptions="allParentChildActiveCategories.categories"
                        :placeholder="
                          this.$t('form.seo_page.category.placeholder')
                        "
                        v-model="formData.category_id"
                      />
                      <span class="heebo-light">
                        {{ $t("form.seo_page.category.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div
                    class="col-md-6 my-1 pe-md-0"
                    v-if="formData.seo_type == 'content_page'"
                  >
                    <div role="group ">
                      <div class="d-flex align-items-center">
                        <label class="label form-label me-4 text-capitalize">
                          {{ $t("form.seo_page.content_page.label") }}
                        </label>
                      </div>
                      <span
                        class="float-end text-danger"
                        v-if="error && error['content_page_id']"
                      >
                        {{ error.content_page[0] }}
                      </span>
                      <AdminSearchSelectable
                        key="3"
                        @input="itemChanged('content_pages', 'content_page_id')"
                        :class="error && error.content_page_id ? 'error' : ''"
                        apiMethod="allActiveContentPages"
                        responseKey="content_pages"
                        :initialOptions="allActiveContentPages.content_pages"
                        :placeholder="
                          this.$t('form.seo_page.content_page.placeholder')
                        "
                        v-model="formData.content_page_id"
                      />
                      <span class="heebo-light">
                        {{ $t("form.seo_page.content_page.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div
                    class="col-md-6 my-1 pe-md-0"
                    v-if="formData.seo_type == 'static_page'"
                  >
                    <div role="group ">
                      <div class="d-flex align-items-center">
                        <label class="label form-label me-4 text-capitalize">
                          {{ $t("form.seo_page.static_page.label") }}
                        </label>
                      </div>
                      <span
                        class="float-end text-danger"
                        v-if="error && error['static_page_id']"
                      >
                        {{ error.static_page[0] }}
                      </span>
                      <v-select
                        :class="error && error.static_page_id ? 'error' : ''"
                        @input="itemChanged('seo_pages', 'static_page_id')"
                        v-model="formData.static_page_id"
                        :reduce="(opt) => opt.id"
                        label="name"
                        :options="static_pages_options"
                      >
                        <template slot="no-options">
                          {{ $t("form.search_select.no_options") }}
                        </template>
                        <template slot="option" slot-scope="option">
                          <div class="d-center">
                            {{ option.name }}
                          </div>
                        </template>
                        <template slot="selected-option" slot-scope="option">
                          <div class="selected d-center">
                            {{ option.name }}
                          </div>
                        </template>
                      </v-select>
                      <span class="heebo-light">
                        {{ $t("form.seo_page.static_page.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row" v-if="loading">
                  <div class="col-md-12">
                    <AdminLoader />
                  </div>
                </div>
                <div v-else>
                  <div v-if="showSeo">
                    <div class="row">
                      <div class="col-lg-12 py-3 px-0">
                        <h2 class="m-0 text-body bold">{{ $t("form.seo") }}</h2>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 my-1 ps-md-0">
                        <div role="group">
                          <label for="input-live" class="form-label"
                            >{{ this.$t("form.seo_page.title.label") }}:</label
                          >
                          <span
                            class="float-end text-danger"
                            v-if="error && error.title"
                          >
                            {{ error.title[0] }}
                          </span>
                          <input
                            :class="error && error.title ? 'error' : ''"
                            class="form-control"
                            v-model="formData.title"
                            aria-describedby="input-live-help input-live-feedback"
                            :placeholder="
                              this.$t('form.seo_page.title.placeholder')
                            "
                            trim
                          />
                          <span class="heebo-light">
                            {{ $t("form.seo_page.title.subheading") }}
                          </span>
                        </div>
                      </div>
                      <div class="col-md-6 my-1 pe-md-0">
                        <div role="group">
                          <label for="input-live" class="form-label"
                            >{{
                              this.$t("form.seo_page.description.label")
                            }}:</label
                          >
                          <span
                            class="float-end text-danger"
                            v-if="error && error.description"
                          >
                            {{ error.description[0] }}
                          </span>
                          <textarea
                            :class="error && error.description ? 'error' : ''"
                            class="form-control"
                            v-model="formData.description"
                            aria-describedby="input-live-help input-live-feedback"
                            :placeholder="
                              this.$t('form.seo_page.description.placeholder')
                            "
                            trim
                          >
                          </textarea>
                          <span class="heebo-light">
                            {{ $t("form.seo_page.description.subheading") }}
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 my-1  ps-md-0">
                        <div role="group">
                          <label for="input-live" class="form-label">{{
                            this.$t("form.seo_page.keywords.label")
                          }}</label>
                          <span
                            class="float-end text-danger"
                            v-if="error && error.keywords"
                          >
                            {{ error.keywords[0] }}
                          </span>
                          <textarea
                            :class="error && error.keywords ? 'error' : ''"
                            class="form-control"
                            v-model="formData.keywords"
                            aria-describedby="input-live-help input-live-feedback"
                            :placeholder="
                              this.$t('form.seo_page.keywords.placeholder')
                            "
                            trim
                          >
                          </textarea>
                          <span class="heebo-light">
                            {{ $t("form.seo_page.keywords.subheading") }}
                          </span>
                        </div>
                      </div>
                    </div>
                    <hr class="text-primary" />
                    <div class="row">
                      <div
                        class="col-md-12 py-3 px-0 d-flex justify-content-between"
                      >
                        <div class="px-0 pt-3">
                          <h3 class="m-0 text-body bold px-0">
                            {{ $t("form.meta_tags") }}
                          </h3>
                        </div>
                        <div>
                          <button
                            type="button"
                            @click="addMetaTag"
                            class="btn add btn-primary px-3 shadow rounded-circle"
                            name="button"
                          >
                            <fa :icon="['fas', 'plus']" fixed-width />
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 px-0">
                        <div
                          class="row meta-tag-section py-3"
                          v-for="(tag, index) in metaTags"
                          :key="index"
                        >
                          <div
                            class="col-md-12 px-4 d-flex align-items-center justify-content-between"
                          >
                            <h4 class="text-center text-capitalize">
                              {{ increaseOne(index) }}- {{ tag.name }}
                            </h4>
                            <button
                              type="button"
                              @click="removeMetaTag(index)"
                              class="btn text-danger px-2 rounded-circle"
                              name="button"
                            >
                              <fa :icon="['fas', 'times']" fixed-width />
                            </button>
                          </div>
                          <div class="col-md-12">
                            <div
                              class="row"
                              v-for="(prop, key, ind) in tag"
                              :key="`${ind}_${index}`"
                            >
                              <div class="col-11 px-0">
                                <div class="row">
                                  <div class="col-md-6 my-1">
                                    <div role="group ">
                                      <label
                                        for="input-live"
                                        class="form-label"
                                        >{{
                                          $t("form.seo_page.key.label")
                                        }}</label
                                      >
                                      <input
                                        class="form-control"
                                        aria-describedby="input-live-help input-live-feedback"
                                        :placeholder="
                                          $t('form.seo_page.key.placeholder')
                                        "
                                        :disabled="ind == 0"
                                        :value="key"
                                        @change="changeKey(index, key, $event)"
                                        trim
                                      />
                                      <span class="heebo-light">
                                        {{ $t("form.seo_page.key.subheading") }}
                                      </span>
                                    </div>
                                  </div>
                                  <div class="col-md-6 my-1">
                                    <div role="group ">
                                      <label
                                        for="input-live"
                                        class="form-label"
                                        >{{
                                          $t("form.seo_page.value.label")
                                        }}</label
                                      >
                                      <span
                                        class="float-end text-danger"
                                        v-if="
                                          error &&
                                          error[`meta_tags.${index}.${key}`]
                                        "
                                      >
                                        {{
                                          error[`meta_tags.${index}.${key}`][0]
                                        }}
                                      </span>
                                      <input
                                        class="form-control"
                                        :class="
                                          error &&
                                          error[`meta_tags.${index}.${key}`]
                                            ? 'error'
                                            : ''
                                        "
                                        aria-describedby="input-live-help input-live-feedback"
                                        :placeholder="
                                          $t('form.seo_page.value.placeholder')
                                        "
                                        v-model="formData.meta_tags[index][key]"
                                        trim
                                      />
                                      <span class="heebo-light">
                                        {{
                                          $t("form.seo_page.value.subheading")
                                        }}
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div
                                class="col-1 d-flex align-items-center justify-content-end px-0"
                              >
                                <button
                                  v-if="ind == Object.keys(tag).length - 1"
                                  type="button"
                                  @click="addMetaProperty(index)"
                                  class="btn add text-white rounded-circle"
                                  name="button"
                                >
                                  <fa :icon="['fas', 'plus']" fixed-width />
                                </button>
                                <button
                                  v-if="ind != 0"
                                  type="button"
                                  @click="removeMetaProperty(index, key)"
                                  class="btn add ms-3 text-danger rounded-circle"
                                  name="button"
                                >
                                  <fa
                                    :icon="['fas', 'trash-alt']"
                                    fixed-width
                                  />
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
            </div>
            <div class="row">
              <div class="col-md-12 px-4 text-center text-md-end">
                <button
                  type="button"
                  class="btn btn-primary mb-3 px-3 py-2"
                  @click="add"
                  name="button"
                >
                  {{ this.$t("form.update") }}
                </button>
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
import seoMixin from "~/mixins/seoMixin.js";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "seo_pages.create",
    strategy: "create",
  },
  mixins: [seoMixin],
  async asyncData({ params }) {},
  async fetch() {
    if (!this.allActiveProducts.products) {
      await this.fetchActiveProducts();
    }
    if (!this.allParentChildActiveCategories.categories) {
      await this.fetchParentChildActiveCategories();
    }
    if (!this.allActiveContentPages.content_pages) {
      await this.fetchActiveContentPages();
    }
  },
  data() {
    return {};
  },
  methods: {
    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/seo_pages"));
      }
    },
    async addAndContinue() {
      await this.addSeoPages(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.title = "";
          this.formData.description = "";
          this.formData.keywords = "";
          this.formData.seo_type = "";
          this.formData.product = "";
          this.formData.category = "";
          this.formData.static_page = "";
          this.formData.content_page = "";
          this.formData.meta_tags = [];
          this.showSeo = false;
          this.$toast.success(res.message);
          this.fetchActiveSeoPages();
        }
      });
    },
  },

  mounted() {},
};
</script>
