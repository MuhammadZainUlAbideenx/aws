<template >
  <div class="" v-if="!this.$auth.user.store">
    <SellerShopSettings />
  </div>
  <div class="" v-else-if="!this.$auth.user.is_active">
    <SellerShopDeactive />
  </div>
  <div v-else>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.product.edit_product") }}
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
                <nuxt-link :to="localePath('/seller/products')">{{
                  this.$t("sidebar.product")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.edit") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.product.edit_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- Main content -->
    <section class="content pb-5">
      <div class="container" v-if="$fetchState.pending">
        <div class="row">
          <div class="col-md-12">
            <AdminProductMedia />
          </div>
        </div>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body p-0">
                   <!-- Steps start for simple product-->
                <ul
                  class="nav nav-pills order-profile-tabs my-4 mb-5"
                  id="pills-tab"
                  role="tablist"
                  v-if="product.product_type == 1"
                >
                  <li
                    class="nav-item col-md-6 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none active"
                      id="pills-home-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-home"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      >
                        <div
                          class="
                            barIconBg
                            position-absolute
                            d-flex
                            align-items-center
                            justify-content-center
                          "
                        >
                          <span class="text-white fw-bold">1</span>
                        </div>
                      </div>
                      <!-- <span class="text-dark order-head"> General Information</span> -->
                    </button>
                    <div class="text-dark order-head fw-bold float-end product-step-name">
                      {{$t('columns.product_info')}}
                    </div>
                  </li>
                  <li
                    class="nav-item col-md-6 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none active"
                      id="pills-home-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-home"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      >
                        <div
                          class="
                            barIconBg
                            position-absolute
                            d-flex
                            align-items-center
                            justify-content-center
                          "
                        >
                          <span class="fw-bold text-white">2</span>
                          <!-- <fa :icon="['fas', 'check']" fixed-width class="barIcon" /> -->
                        </div>
                      </div>
                      <!-- <span class="text-dark order-head"> General Information</span> -->
                    </button>
                    <span class="text-dark order-head fw-bold float-end product-step-name"
                      > {{$t('media_upload')}}</span
                    >
                  </li>
                  <!-- <li
                    class="nav-item col-md-4 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none"
                      id="pills-profile-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-profile"
                      type="button"
                      role="tab"
                      aria-controls="pills-profile"
                      aria-selected="false"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      ></div>
                    </button>
                  </li> -->
                </ul>
                <!-- Steps ends for simple product-->
                    <!-- Steps start for variable product-->
                <ul
                  class="nav nav-pills order-profile-tabs my-4 mb-5"
                  id="pills-tab"
                  role="tablist"
                  v-if="product.product_type == 2"
                >
                  <li
                    class="nav-item col-md-4 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none active"
                      id="pills-home-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-home"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      >
                        <div
                          class="
                            barIconBg
                            position-absolute
                            d-flex
                            align-items-center
                            justify-content-center
                          "
                        >
                          <span class="text-white fw-bold">1</span>
                        </div>
                      </div>
                      <!-- <span class="text-dark order-head"> General Information</span> -->
                    </button>
                    <div class="text-dark order-head fw-bold float-end product-step-name">
                     {{$t('columns.product_info')}}
                    </div>
                  </li>
                  <li
                    class="nav-item col-md-4 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none active"
                      id="pills-home-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-home"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      >
                        <div
                          class="
                            barIconBg
                            position-absolute
                            d-flex
                            align-items-center
                            justify-content-center
                          "
                        >
                          <span class="fw-bold text-white">2</span>
                          <!-- <fa :icon="['fas', 'check']" fixed-width class="barIcon" /> -->
                        </div>
                      </div>
                      <!-- <span class="text-dark order-head"> General Information</span> -->
                    </button>
                    <span class="text-dark order-head fw-bold float-end product-step-name"
                      > {{$t('media_upload')}}</span
                    >
                  </li>
                  <li
                    class="nav-item col-md-4 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none"
                      id="pills-profile-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-profile"
                      type="button"
                      role="tab"
                      aria-controls="pills-profile"
                      aria-selected="false"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      >
                        <div
                          class="
                            barIconBg
                            position-absolute
                            d-flex
                            align-items-center
                            justify-content-center
                          "
                        >
                          <span class="fw-bold">3</span>
                          <!-- <fa :icon="['fas', 'check']" fixed-width class="barIcon" /> -->
                        </div>
                      </div>
                    </button>
                    <span class="text-dark order-head fw-bold float-end product-step-name"
                      > {{$t('add_attributes')}}</span
                    >
                  </li>
                  <!-- <li
                    class="nav-item col-md-3 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none"
                      id="pills-profile-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-profile"
                      type="button"
                      role="tab"
                      aria-controls="pills-profile"
                      aria-selected="false"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      ></div>
                    </button>
                  </li> -->
                </ul>
                <!-- Steps ends for variable product-->
                <hr class="text-primary" />
                <div class="py-4">
                  <div class="d-grid mb-4">
                    <div
                      class="btn-media px-3 rounded py-4"
                      type="button"
                      name="button"
                      data-bs-toggle="modal"
                      data-bs-target="#selectProductMedia"
                    >
                      {{ $t("form.If_you_want_to_choose_image") }}
                      <span class="text-primary">
                        {{ $t("form.select_media") }}
                      </span>
                      {{ $t("form.gallery") }}
                    </div>
                  </div>
                  <AdminMediaMultipleModal
                    :product_name="product_name"
                    type="images"
                    modal_id="selectProductMedia"
                    @selectImage="imageSelected"
                    redirect_panel="seller"
                  />
                  <div class="row">
                    <div class="col-md-12 px-0">
                      <draggable
                        v-model="formData.media_array"
                        draggable=".item"
                      >
                        <div
                          v-for="(element, index) in formData.media_array"
                          :key="element.id"
                          class="row"
                        >
                          <div
                            class="col-md-6 col-12 py-4 px-0 mb-2"
                            style="cursor: pointer"
                          >
                            <div
                              class="
                                d-flex
                                align-items-center
                                justify-content-between
                                align-items-center
                              "
                            >
                              <p class="fw-bold text-dark h6 ps-4">
                                {{
                                  $t("form.product.product_media.sort_order")
                                }}
                                : {{ increaseOne(index) }}
                              </p>

                              <button
                                @click="removeImage(index)"
                                type="button"
                                class="btn p-0 btn-sm rounded-circle"
                                name="button"
                              >
                                <fa :icon="['fas', 'trash-alt']" fixed-width />
                              </button>
                            </div>
                            <div class="bg-secondary-light my-2 p-4 vendorCard">
                              <div class="row">
                                <div class="col-md-4">
                                  <div class="d-flex align-items-center h-100">
                                    <img
                                      class="imgSelected img-wrap"
                                      v-bind:src="url + `${element.path}`"
                                      alt=""
                                    />
                                  </div>
                                </div>
                                <div class="col-md-8">
                                  <div>
                                    <div>
                                      <label
                                        class="label form-label fw-bold"
                                        for=""
                                      >
                                          {{$t('columns.description')}}
                                        <!-- {{
                                    $t(
                                      "form.product.product_media.description.heading"
                                    )
                                  }} -->
                                      </label>
                                      <input
                                        type="text"
                                        class="form-control"
                                        v-model="
                                          formData.media_array[index]
                                            .description
                                        "
                                        :placeholder="
                                          $t(
                                            'form.product.product_media.description.placeholder'
                                          )
                                        "
                                      />
                                    </div>
                                    <div>
                                      <label
                                        class="label form-label fw-bold"
                                        for=""
                                      >
                                        {{$t('form.product.product_media.alt_text.heading')}}
                                        <!-- {{
                                        $t(
                                          "form.product.product_media.alt_text.heading"
                                        )
                                      }} -->
                                      </label>
                                      <input
                                        type="text"
                                        class="form-control"
                                        v-model="
                                          formData.media_array[index].alt_text
                                        "
                                        :placeholder="
                                          $t(
                                            'form.product.product_media.alt_text.placeholder'
                                          )
                                        "
                                      />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </draggable>
                    </div>
                  </div>
                </div>

                <!-- </div>
                </div> -->
                <!-- <div class="row">
                  <div class="col-md-12 mb-5 p-5">
                    <div>Multiple bar here</div>
                    <div>
                      <div class="d-grid">
                        <div
                          class="btn-media px-3 rounded"
                          type="button"
                          name="button"
                          data-bs-toggle="modal"
                          data-bs-target="#selectProductMedia"
                        >
                          {{ $t("form.If_you_want_to_choose_image") }}
                          <span class="text-primary">
                            {{ $t("form.select_media") }}
                          </span>
                          {{ $t("form.gallery") }}
                        </div>
                      </div>
                    </div>
                    <hr class="text-primary mb-5 product-media-seperator" />
                    <AdminMediaMultipleModal
                      :product_name="product_name"
                      type="images"
                      modal_id="selectProductMedia"
                      @selectImage="imageSelected"
                      redirect_panel="seller"
                    />
                    this is commented
                    <span class="px-2 heebo-light">
                        {{ $t("form.product.product_media.image.subheading") }}
                      </span>
                  </div>
                </div> -->

                <!-- <div class="row">
                  <div class="col-md-12">
                    <draggable v-model="formData.media_array" draggable=".item">
                      <div
                        v-for="(element, index) in formData.media_array"
                        :key="element.id"
                        class="item draggable"
                      >
                        <div
                          class="p-4 row selected-media"
                          style="cursor: pointer"
                        >
                          <div
                            class="
                              co1-12
                              d-flex
                              align-items-center
                              justify-content-between
                            "
                          >
                            <p class="fw-bold">
                              {{ $t("form.product.product_media.sort_order") }}
                              : {{ increaseOne(index) }}
                            </p>

                            <button
                              @click="removeImage(index)"
                              type="button"
                              class="btn p-0 btn-sm rounded-circle"
                              name="button"
                            >
                              <fa :icon="['fas', 'trash-alt']" fixed-width />
                            </button>
                          </div>
                          <div class="col-md-4">
                            <img v-bind:src="url + `${element.path}`" alt="" />
                          </div>
                          <div class="col-md-8 px-5 py-4">
                            <div class="row">
                              <div class="col-md-12 text-end"></div>
                              <div class="col-md-12">
                                <label class="label form-label" for="">{{
                                  $t(
                                    "form.product.product_media.description.heading"
                                  )
                                }}</label>
                                <input
                                  type="text"
                                  class="form-control"
                                  v-model="
                                    formData.media_array[index].description
                                  "
                                  :placeholder="
                                    $t(
                                      'form.product.product_media.description.placeholder'
                                    )
                                  "
                                />
                                <div class="my-5">
                                  <label class="label form-label" for="">{{
                                    $t(
                                      "form.product.product_media.alt_text.heading"
                                    )
                                  }}</label>
                                  <input
                                    type="text"
                                    class="form-control"
                                    v-model="
                                      formData.media_array[index].alt_text
                                    "
                                    :placeholder="
                                      $t(
                                        'form.product.product_media.alt_text.placeholder'
                                      )
                                    "
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </draggable>
                  </div>
                </div> -->
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 px-4 text-center text-md-end">
                <button
                  type="button"
                  :disabled="disabled"
                  class="btn btn-secondary mb-3 px-3 py-2"
                  @click="update"
                  name="button"
                >
                  {{ this.$t("form.update") }}
                </button>
                <!-- <button
                  type="button"
                  :disabled="disabled"
                  class="btn btn-success mb-3"
                  @click="updateAndContinue"
                  name="button"
                >
                  {{ this.$t("form.update_and_continue") }}
                </button> -->
                <button
                  v-if="product.product_type == 2"
                  type="button"
                  :disabled="disabled"
                  class="btn btn-success mb-3 px-3 py-2"
                  @click="updateAndNext"
                  name="button"
                >
                  {{ this.$t("form.add_and_continue") }}
                </button>
              </div>
            </div>
            <!-- <label class="label form-label">
                        {{ this.$t("form.product.product_media.image.label") }}
                      </label> -->
            <!-- <span
                      class="float-end text-danger"
                      v-if="error && error.image_id"
                    >
                      {{ error.image_id[0] }}
                    </span> -->
          </div>
        </div>
      </div>
    </section>

    <!-- /.content -->

    <!-- /.content -->
  </div>
</template>
<script >
import draggable from "vuedraggable";
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "vendor",
  middleware: "vendor",
  components: {
    draggable,
  },
  async fetch() {
    if (!this.allActiveMedia.media) {
      await this.fetchActiveMedia();
    }
    const { data } = await this.$sellerRepositories.products.show(
      this.$route.params.id
    );

    this.product = data;
    if (data.media) {
      this.product_name = data.name;
      for (var i = 0; i < data.media.length; i++) {
        var newObj = {
          media_id: data.media[i].pivot.media_id,
          path: data.media[i].small_thumbnail[0].thumbnail,
          description: data.media[i].pivot.description,
          alt_text: data.media[i].pivot.alt_text,
        };
        this.formData.media_array.push(newObj);
      }
    }
  },
  data() {
    return {
      url: "/backend",
      manufacturer_image_path: "",
      formData: {
        image_id: "",
        media_array: [],
      },
      disabled: false,
      product_name: "",
      error: "",
      product: "",
    };
  },
  methods: {
    ...mapActions({
      updateProductMedia: "Seller/Products/updateProductMedia",
      fetchActiveMedia: "General/fetchActiveMedia",
    }),
    async updateAndNext() {
      await this.updateAndContinue();
      if (!this.error) {
        this.$router.replace(
          this.localePath(
            "/seller/products/edit/" + this.$route.params.id + "/step3"
          )
        );
      }
    },
    async update() {
      await this.updateAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/seller/products"));
      }
    },
    increaseOne(index) {
      return index + 1;
    },
    imageSelected(id, path, description, alt) {
      var newobj = {
        media_id: id,
        path: path,
        description: description,
        alt_text: alt,
      };
      this.formData.media_array.push(newobj);
    },
    removeImage(index) {
      this.formData.media_array.splice(index, 1);
    },
    async updateAndContinue() {
      this.disabled = true;
      await this.updateProductMedia({
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
        }
      });
      this.disabled = false;
    },
  },
  mounted() {},
  computed: {
    ...mapGetters({
      allActiveMedia: "General/allActiveMedia",
    }),
  },
};
</script>
