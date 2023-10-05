<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.slider_image.create_new_slider_image") }}
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
                <nuxt-link :to="localePath('/admin/slider_images')">{{
                  this.$t("sidebar.slider_image")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.create") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.slider_image.form_description") }}
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
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.slider_image.slider_type.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.slider_type"
                      >
                        {{ error.slider_type[0] }}
                      </span>
                      <v-select
                        class=""
                        :placeholder="
                          this.$t('form.slider_image.slider_type.placeholder')
                        "
                        v-model="formData.slider_type"
                        :reduce="(opt) => opt.value"
                        label="value"
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
                        {{ $t("form.slider_image.slider_type.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.slider_image.url_type.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.url_type"
                      >
                        {{ error.url_type[0] }}
                      </span>
                      <v-select
                        class=""
                        :placeholder="
                          this.$t('form.slider_image.url_type.placeholder')
                        "
                        v-model="formData.url_type"
                        :reduce="(opt) => opt.value"
                        label="value"
                        :options="url_type_options"
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
                        {{ $t("form.slider_image.url_type.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label class="label form-label">
                        {{ this.$t("form.slider_image.expiry_date.label") }}
                      </label>
                      <span
                        class="float-end text-danger"
                        v-if="error && error.expiry_date"
                      >
                        {{ error.expiry_date[0] }}
                      </span>
                      <datetime
                        :placeholder="
                          this.$t('form.slider_image.expiry_date.placeholder')
                        "
                        input-class="form-control"
                        type="datetime"
                        use12-hour
                        v-model="formData.expiry_date"
                        value-zone="local"

                      ></datetime>
                      <span class="heebo-light">
                        {{ $t("form.slider_image.expiry_date.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label"
                        >{{
                          this.$t("form.slider_image.website_url.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.website_url"
                      >
                        {{ error.website_url[0] }}
                      </span>
                      <input
                        :class="error && error.website_url ? 'error' : ''"
                        class="form-control"
                        aria-describedby="input-live-help input-live-feedback"
                        v-model="formData.website_url"
                        :placeholder="
                          this.$t('form.slider_image.website_url.placeholder')
                        "
                        trim
                      />
                      <span class="px-2 heebo-light">
                        {{ $t("form.slider_image.website_url.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="px-2 form-label"
                        >{{
                          this.$t("form.slider_image.discount.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.discount"
                      >
                        {{ error.discount[0] }}
                      </span>
                      <input
                        :class="error && error.discount ? 'error' : ''"
                        class="form-control"
                        type="number"
                        aria-describedby="input-live-help input-live-feedback"
                        v-model="formData.discount"
                        :placeholder="
                          this.$t('form.slider_image.discount.placeholder')
                        "
                        trim
                      />
                      <span class="px-2 heebo-light">
                        {{ $t("form.slider_image.discount.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div
                    class="
                      col-md-6
                      my-1
                      d-flex
                      justify-content-center
                      flex-column
                    "
                  >
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.slider_image.status.label") }}
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
                      {{ $t("form.slider_image.status.subheading") }}
                    </span>
                  </div>
                </div>
                <hr class="text-primary" />
                <div class="col-lg-12 py-3">
                  <div class="px-0 pt-3">
                    <h2 class="m-0 text-body bold">
                      {{ $t("form.multilanguage") }}
                    </h2>
                    <p>
                      <span class="heebo-light">
                        {{ $t("form.slider_image.form_description") }}
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
                            :key="language.code"
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
                                  <label for="input-live" class="form-label"
                                    >{{
                                      $t("form.slider_image.image.label")
                                    }}:</label
                                  >
                                  <span
                                    class="float-end text-danger"
                                    v-if="
                                      error && error['image.' + language.code]
                                    "
                                  >
                                    {{ error["image." + language.code][0] }}
                                  </span>
                                  <div>
                                    <img
                                      v-if="images[language.code]"
                                      v-bind:src="
                                        url + `${images[language.code]}`
                                      "
                                      class="tab-img"
                                    />
                                    <button
                                      class="btn btn-primary px-3 py-2"
                                      type="button"
                                      name="button"
                                      data-bs-toggle="modal"
                                      :data-bs-target="
                                        '#selectSliderImageMedia' +
                                        language.code
                                      "
                                    >
                                      {{ $t("form.select_media") }}
                                    </button>

                                    <AdminMediaModal
                                      type="images"
                                      :bind_modal="language.code"
                                      :img_var="language.code"
                                      :modal_id="
                                        'selectSliderImageMedia' + language.code
                                      "
                                      @selectImage="imageSelected"
                                      redirect_panel="admin"
                                    />
                                  </div>
                                  <span class="heebo-light">
                                    {{
                                      $t("form.slider_image.image.subheading")
                                    }}
                                  </span>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6 my-1">
                                <div role="group ">
                                  <label for="input-live" class="form-label"
                                    >{{
                                      $t("form.slider_image.name.label")
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
                                      $t('form.slider_image.name.placeholder')
                                    "
                                    trim
                                  />
                                  <span class="heebo-light">
                                    {{
                                      $t("form.slider_image.name.subheading")
                                    }}
                                  </span>
                                </div>
                              </div>
                              <div class="col-md-6 my-1">
                                <div role="group ">
                                  <label for="input-live" class="form-label"
                                    >{{
                                      $t("form.slider_image.heading.label")
                                    }}:</label
                                  >
                                  <span
                                    class="float-end text-danger"
                                    v-if="
                                      error && error['heading.' + language.code]
                                    "
                                  >
                                    {{ error["heading." + language.code][0] }}
                                  </span>
                                  <input
                                    class="form-control"
                                    :class="
                                      error && error['heading.' + language.code]
                                        ? 'error'
                                        : ''
                                    "
                                    v-model="formData.heading[language.code]"
                                    aria-describedby="input-live-help input-live-feedback"
                                    :placeholder="
                                      $t(
                                        'form.slider_image.heading.placeholder'
                                      )
                                    "
                                    trim
                                  />
                                  <span class="heebo-light">
                                    {{
                                      $t("form.slider_image.heading.subheading")
                                    }}
                                  </span>
                                </div>
                              </div>
                              <div class="col-md-6 my-1">
                                <div role="group ">
                                  <label for="input-live" class="form-label"
                                    >{{
                                      $t("form.slider_image.button_text.label")
                                    }}:</label
                                  >
                                  <span
                                    class="float-end text-danger"
                                    v-if="
                                      error &&
                                      error['button_text.' + language.code]
                                    "
                                  >
                                    {{
                                      error["button_text." + language.code][0]
                                    }}
                                  </span>
                                  <input
                                    class="form-control"
                                    :class="
                                      error &&
                                      error['button_text.' + language.code]
                                        ? 'error'
                                        : ''
                                    "
                                    v-model="
                                      formData.button_text[language.code]
                                    "
                                    aria-describedby="input-live-help input-live-feedback"
                                    :placeholder="
                                      $t(
                                        'form.slider_image.button_text.placeholder'
                                      )
                                    "
                                    trim
                                  />
                                  <span class="heebo-light">
                                    {{
                                      $t(
                                        "form.slider_image.button_text.subheading"
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
              <!-- <button type="button"
                            class="btn btn-success mb-3"
                            @click="addAndContinue"
                            name="button">
                        {{ this.$t("form.add_and_continue") }}
                      </button> -->
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
    permission: "slider_images.create",
    strategy: "create",
  },
  async fetch() {
    if (!this.allActiveMedia.media) {
      await this.fetchActiveMedia();
    }
  },
  data() {
    return {
      images: {},
      options: [

        { value: 1, text: this.$t("form.slider_image.slider_type.type_1") },
        { value: 2, text: this.$t("form.slider_image.slider_type.type_2") },
        { value: 3, text: this.$t("form.slider_image.slider_type.type_3") },
        { value: 4, text: this.$t("form.slider_image.slider_type.type_4") },
        { value: 5, text: this.$t("form.slider_image.slider_type.type_5") },
      ],
      url_type_options: [

        { value: 1, text: this.$t("form.slider_image.url_type.internal") },
        { value: 2, text: this.$t("form.slider_image.url_type.external") },
      ],
      editorConfig: {
        // The configuration of the editor.
      },
      url: "/backend",
      slider_image_image_path: "",
      formData: {
        slider_type: "",
        name: {},
        heading: {},
        button_text: {},
        website_url: "",
        discount: "",
        url_type: "",
        expiry_date: "",
        image: {},
        is_active: false,
      },
      error: false,
    };
  },
  methods: {
    ...mapActions({
      addSliderImages: "SliderImages/addSliderImages",
      fetchActiveSliderImages: "General/fetchActiveSliderImages",
      fetchActiveMedia: "General/fetchActiveMedia",
    }),
    imageSelected(id, path, img_resource, modal) {
      this.formData.image[modal] = id;
      this.images[img_resource] = path;
      this.$forceUpdate();
    },
    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/slider_images"));
      }
    },
    async addAndContinue() {
      await this.addSliderImages(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.expiry_date = "";
          this.formData.is_active = false;
          this.formData.slider_type = "";
          this.formData.image = {};
          this.formData.name = {};
          this.formData.heading = {};
          this.formData.button_text = {};
          this.formData.website_url = "";
          this.formData.discount = "";
          this.slider_image_image_path = "";
          this.$toast.success(res.message);
          this.fetchActiveSliderImages();
        }
      });
    },
  },

  mounted() {},
  watch: {
    "formData.url_type": function (newVal, oldVal) {
      if (newVal == 1) {
        this.formData.website_url = "/";
      } else {
        this.formData.website_url = "";
      }
    },
  },
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
      allActiveMedia: "General/allActiveMedia",
    }),
  },
};
</script>
