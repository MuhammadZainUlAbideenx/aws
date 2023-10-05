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
            {{ this.$t("form.product.edit_product_attributes.label") }}
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
              {{ this.$t("form.product_attributes.edit_description") }}
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
            <AdminLoader />
          </div>
        </div>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body p-4">
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
                    <div
                      class="
                        text-dark
                        order-head
                        fw-bold
                        float-end
                        product-step-name
                      "
                    >
                      {{ $t("columns.product_info") }}
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
                          <span class="text-white fw-bold">2</span>
                          <!-- <fa :icon="['fas', 'check']" fixed-width class="barIcon" /> -->
                        </div>
                      </div>
                      <!-- <span class="text-dark order-head"> General Information</span> -->
                    </button>
                    <span
                      class="
                        text-dark
                        order-head
                        fw-bold
                        float-end
                        product-step-name
                      "
                    >
                      {{ $t("media_upload") }}</span
                    >
                  </li>
                  <!-- <li
                    class="nav-item col-md-4 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none active"
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
                    <div
                      class="
                        text-dark
                        order-head
                        fw-bold
                        float-end
                        product-step-name
                      "
                    >
                      {{ $t("columns.product_info") }}
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
                          <span class="text-white fw-bold">2</span>
                          <!-- <fa :icon="['fas', 'check']" fixed-width class="barIcon" /> -->
                        </div>
                      </div>
                      <!-- <span class="text-dark order-head"> General Information</span> -->
                    </button>
                    <span
                      class="
                        text-dark
                        order-head
                        fw-bold
                        float-end
                        product-step-name
                      "
                    >
                      {{ $t("media_upload") }}</span
                    >
                  </li>
                  <li
                    class="nav-item col-md-4 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none active"
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
                          <span class="text-white fw-bold">3</span>
                          <!-- <fa :icon="['fas', 'check']" fixed-width class="barIcon" /> -->
                        </div>
                      </div>
                    </button>
                    <span
                      class="
                        text-dark
                        order-head
                        fw-bold
                        float-end
                        product-step-name
                      "
                      >{{ $t("add_attributes") }}</span
                    >
                  </li>
                  <!-- <li
                    class="nav-item col-md-3 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none active"
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
                <div class="row">
                  <!-- <div class="col-md-6 my-1">
                    <div role="group">
                      <label for="input-live" class="form-label text-capitalize"
                        >Attribute Name</label
                      >
                      <div class="d-flex">
                        <input
                          type="text"
                          class="form-control w-75"
                          placeholder="Type Attribute Name Here"
                        />
                        <button
                          type="button"
                          class="btn btn-primary ms-4 h-100"
                        >
                          Add
                        </button>
                      </div>
                      <span class="heebo-light">
                        Please Enter SEO Meta Tag Key
                      </span>
                    </div>
                  </div> -->
                  <div class="row">
                    <div class="col-md-6 my-1">
                      <div role="group">
                        <label for="input-live" class="form-label">{{
                          $t("form.product_attributes.attribute.label")
                        }}</label>
                        <span
                          class="float-end text-danger"
                          v-if="error && error['attribute_id']"
                        >
                          {{ error.attribute_id[0] }}
                        </span>
                        <AdminSearchSelectable
                          :disabled="formData.edit"
                          :class="error && error.attribute_id ? 'error' : ''"
                          apiMethod="activeAttributes"
                          responseKey="attributes"
                          v-on:input="addAttribute"
                          :initialOptions="allActiveAttributes.attributes"
                          :placeholder="
                            $t('form.product_attributes.attribute.placeholder')
                          "
                          v-model="formData.attribute_id"
                        />
                        <span class="heebo-light">
                          {{
                            $t("form.product_attributes.attribute.subheading")
                          }}
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
                        pe-md-0
                      "
                      v-if="formData.product_type != 2"
                    >
                      <div class="d-flex align-items-center">
                        <label class="label form-label me-4 text-capitalize">
                          {{ this.$t("form.product.status.label") }}
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
                        {{ $t("form.product.status.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="row p-3">
                    <div class="col-md-12 px-0">
                      <div
                        class="card p-0 mb-4"
                        v-for="(attribute, att_index) in formData.attributes"
                        :key="attribute.attribute_id"
                      >
                        <div class="card-header bg-light p-4">
                          <div
                            class="
                              d-flex
                              align-items-center
                              justify-content-between
                            "
                          >
                            <h4 class="text-center text-capitalize mb-0">
                              {{ increaseOne(att_index) }} -
                              {{ attribute.name }}
                            </h4>
                            <button
                              type="button"
                              @click="removeAttribute(att_index)"
                              class="btn text-danger p-0 rounded-circle"
                              name="button"
                            >
                              <fa :icon="['fas', 'trash-alt']" fixed-width />
                            </button>
                            <button
                              v-if="
                                formData.attributes[att_index].values.length ==
                                0
                              "
                              type="button"
                              @click="addValue(attribute.id)"
                              class="btn text-danger p-0 rounded-circle"
                              name="button"
                            >
                              <fa :icon="['fas', 'plus']" fixed-width />
                            </button>
                          </div>
                        </div>
                        <div class="card-body bg-transparent p-4">
                          <div class="text-end mb-4">
                            <!-- v-if="val_index == Object.keys(value).length - 1" -->
                            <button
                              type="button"
                              @click="addValue(attribute.id)"
                              class="btn btn-primary p-2"
                              name="button"
                            >
                              {{ $t("form.setting.add_new") }}
                              <fa
                                class="ms-2"
                                :icon="['fas', 'plus']"
                                fixed-width
                              />
                            </button>
                          </div>
                          <div
                            class="row"
                            v-for="(value, val_index) in attribute.values"
                            :key="val_index"
                          >
                            <div class="col-12 px-0">
                              <div class="row">
                                <div
                                  class="
                                    col-lg-12
                                    px-0
                                    d-md-flex
                                    mb-3
                                    position-relative
                                  "
                                >
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
                                      :key="val_index + att_index + index"
                                    >
                                      <a
                                        class="nav-link"
                                        :class="index == 0 ? 'active' : ''"
                                        :id="
                                          language.code +
                                          att_index +
                                          val_index +
                                          '-tab'
                                        "
                                        data-bs-toggle="tab"
                                        :href="
                                          '#' +
                                          language.code +
                                          att_index +
                                          val_index
                                        "
                                        role="tab"
                                        :aria-controls="
                                          language.code + att_index + val_index
                                        "
                                        :aria-selected="
                                          index == 0 ? 'true' : 'false'
                                        "
                                        >{{ language.name }}</a
                                      >
                                    </li>
                                  </ul>

                                  <div
                                    class="tab-content px-4"
                                    id="myTabContent"
                                  >
                                    <div
                                      class="tab-pane fade"
                                      :class="index == 0 ? 'active show' : ''"
                                      :key="
                                        language.code + att_index + val_index
                                      "
                                      v-for="(
                                        language, index
                                      ) in allActiveLanguages.languages"
                                      :id="
                                        language.code + att_index + val_index
                                      "
                                      role="tabpanel"
                                      :aria-labelledby="
                                        language.code +
                                        att_index +
                                        val_index +
                                        '-tab'
                                      "
                                    >
                                      <div class="row">
                                        <div class="col-md-6 my-1">
                                          <div role="group ">
                                            <label
                                              for="input-live"
                                              class="form-label"
                                              >{{
                                                $t(
                                                  "form.product_attributes.name.label"
                                                )
                                              }}</label
                                            >
                                            <span
                                              class="float-end text-danger"
                                              v-if="
                                                error &&
                                                error[
                                                  'attributes.' +
                                                    att_index +
                                                    '.values.' +
                                                    val_index +
                                                    '.value.' +
                                                    language.code
                                                ]
                                              "
                                            >
                                              {{
                                                error[
                                                  "attributes." +
                                                    att_index +
                                                    ".values." +
                                                    val_index +
                                                    ".value." +
                                                    language.code
                                                ][0]
                                              }}
                                            </span>
                                            <input
                                              class="form-control"
                                              :class="
                                                error &&
                                                error[
                                                  'attributes.' +
                                                    att_index +
                                                    '.values.' +
                                                    val_index +
                                                    '.value.' +
                                                    language.code
                                                ]
                                                  ? 'error'
                                                  : ''
                                              "
                                              @change="
                                                ValueDefaultNameChanged(
                                                  index,
                                                  att_index,
                                                  val_index
                                                )
                                              "
                                              v-model="
                                                formData.attributes[att_index]
                                                  .values[val_index].value[
                                                  language.code
                                                ]
                                              "
                                              aria-describedby="input-live-help input-live-feedback"
                                              :placeholder="
                                                $t(
                                                  'form.product_attributes.name.placeholder'
                                                )
                                              "
                                              trim
                                            />
                                            <span class="heebo-light">
                                              {{
                                                $t(
                                                  "form.product_attributes.name.subheading"
                                                )
                                              }}
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <button
                                    v-if="val_index != 0"
                                    type="button"
                                    @click="
                                      removeValue(attribute.id, val_index)
                                    "
                                    class="
                                      btn btn-transparent
                                      p-1
                                      text-danger
                                      position-absolute
                                      end-0
                                    "
                                    name="button"
                                  >
                                    <fa :icon="['fas', 'times']" fixed-width />
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-5 mx-0">
                    <table
                      class="table table-striped custom-table"
                      v-if="formData.combinations.length > 0"
                    >
                      <tr class="">
                        <th>{{$t('combination')}}</th>
                        <th class="px-2">{{$t('price')}}</th>
                        <th class="px-2">{{$t('sku')}}</th>
                        <th class="px-2">{{$t('stock')}}</th>
                        <th class="px-2">{{$t('delete')}}</th>
                      </tr>
                      <tr
                        v-for="(comb, index) in formData.combinations"
                        :key="index"
                      >
                        <td>{{ comb.name_combination }}</td>
                        <td class="px-2 py-2">
                          <input
                            type="number"
                            class="form-control border-1 h-auto my-0 p-2"
                            :class="
                              error && error['combinations.' + index + '.price']
                                ? 'error'
                                : ''
                            "
                            v-model="formData.combinations[index].price"
                            aria-describedby="input-live-help input-live-feedback"
                            :placeholder="
                              $t('form.product_attributes.price.placeholder')
                            "
                            trim
                          />
                          <span
                            class="float-end text-danger fs-6 p-0"
                            v-if="error && error[`combinations.${index}.price`]"
                          >
                            {{ error[`combinations.${index}.price`][0] }}
                          </span>
                        </td>
                        <td class="px-2">
                          <input
                            class="form-control border-1 h-auto my-0 p-2"
                            :class="
                              error && error['combinations.' + index + '.sku']
                                ? 'error'
                                : ''
                            "
                            v-model="formData.combinations[index].sku"
                            aria-describedby="input-live-help input-live-feedback"
                            :placeholder="
                              $t('form.product_attributes.sku.placeholder')
                            "
                            trim
                          />
                          <span
                            class="float-end text-danger fs-6 p-0"
                            v-if="error && error[`combinations.${index}.sku`]"
                          >
                            {{ error[`combinations.${index}.sku`][0] }}
                          </span>
                        </td>
                        <td class="px-2">
                          <input
                            class="form-control border-1 h-auto my-0 p-2"
                            :class="
                              error && error['combinations.' + index + '.stock']
                                ? 'error'
                                : ''
                            "
                            v-model="formData.combinations[index].stock"
                            aria-describedby="input-live-help input-live-feedback"
                            :placeholder="
                              $t('form.product_attributes.stock.placeholder')
                            "
                            trim
                          />
                          <span
                            class="float-end text-danger fs-6 p-0"
                            v-if="error && error[`combinations.${index}.stock`]"
                          >
                            {{ error[`combinations.${index}.stock`][0] }}
                          </span>
                        </td>
                        <td>
                          <button
                            type="button"
                            @click="removeCombination(index)"
                            class="
                              btn btn-transparent
                              p-1
                              text-danger
                              rounded-circle
                            "
                            name="button"
                          >
                            <fa :icon="['fas', 'trash-alt']" fixed-width />
                          </button>
                        </td>
                      </tr>
                    </table>
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
    const { data } = await this.$sellerRepositories.products.show(
      this.$route.params.id
    );

    this.formData.attributes = data.attributes;
    this.formData.combinations = data.variants;
    // if(this.formData.attributes.length >= 1){
    //   this.createCombinations()
    // }
    this.product = data;
    if (!this.allActiveAttributes.attributes) {
      await this.fetchActiveAttributes();
    }
  },
  data() {
    return {
      formData: {
        attribute_id: "",
        attributes: [],
        combinations: [],
      },
      disabled: false,
      product: "",
      error: "",
    };
  },
  methods: {
    ...mapActions({
      updateProductAttribute: "Seller/Products/updateProductAttribute",
      addProductAttribute: "Seller/Products/addProductAttribute",
      fetchActiveAttributes: "General/fetchActiveAttributes",
    }),
    increaseOne(i) {
      return ++i;
    },
    ValueDefaultNameChanged(lang_ind, att_ind, val_ind) {
      // if default language name is changed so its slug also change
      if (lang_ind == 0) {
        // if value is not added to database and being updated then create slug
        if (
          !this.formData.attributes[att_ind].values[val_ind].id ||
          this.formData.attributes[att_ind].values[val_ind].id == null
        ) {
          var name =
            this.formData.attributes[att_ind].values[val_ind].value[
              this.allActiveLanguages.languages[0].code
            ];
          var genuine_name_slug = this.slugify(name);
          var name_slug = this.slugify(name);
          var check = 0;
          var values = this.formData.attributes.map(function (a, i) {
            // get all values except whose name is changed
            if (i == att_ind) {
              return a.values.filter(function (val, inde) {
                return inde != val_ind;
              });
            } else {
              return a.values;
            }
          });
          values = [].concat.apply([], values);
          var counter = 0;
          var check = 0;
          // if slug already exists in any of other value then add a 1 into slug
          while (check == 0) {
            var ind = values.findIndex((val) => val.slug == name_slug);
            if (ind != -1) {
              counter = counter + 1;
              name_slug = genuine_name_slug + counter;
            } else {
              check = 1;
            }
          }
          this.formData.attributes[att_ind].values[val_ind].slug = name_slug;
        }
        this.createCombinations();
      }
    },
    addAttribute(e, a) {
      const attr = this.formData.attributes.findIndex((att) => att.id == e);
      if (attr != -1) {
        this.$toast.success("attribute_already exist");
      } else {
        const obj = {
          id: e,
          name: a.name,
          values: [],
        };
        this.formData.attributes.push(obj);
      }
      this.formData.attribute_id = "";
    },
    removeAttribute(i) {
      this.formData.attributes.splice(i, 1);
      this.createCombinations();
    },
    addValue(e) {
      const attr = this.formData.attributes.findIndex((att) => att.id == e);
      this.formData.attributes[attr].values.push({ value: {}, slug: "" });
    },
    removeValue(att_id, val_ind) {
      const attr = this.formData.attributes.findIndex(
        (att) => att.id == att_id
      );
      this.formData.attributes[attr].values.splice(val_ind, 1);
      this.createCombinations();
    },
    initFormData() {
      this.formData.attribute_id = "";
      this.formData.attributes = [];
    },
    slugify(str) {
      str = str.replace(/^\s+|\s+$/g, "");
      str = str.toLowerCase();
      var from =
        "ÁÄÂÀÃÅČÇĆĎÉĚËÈÊẼĔȆÍÌÎÏŇÑÓÖÒÔÕØŘŔŠŤÚŮÜÙÛÝŸŽáäâàãåčçćďéěëèêẽĕȇíìîïňñóöòôõøðřŕšťúůüùûýÿžþÞĐđßÆa·/_,:;";
      var to =
        "AAAAAACCCDEEEEEEEEIIIINNOOOOOORRSTUUUUUYYZaaaaaacccdeeeeeeeeiiiinnooooooorrstuuuuuyyzbBDdBAa------";
      for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
      }
      str = str
        .replace(/[^a-z0-9 -]/g, "")
        .replace(/\s+/g, "-")
        .replace(/-+/g, "-");
      return str;
    },
    removeCombination(i) {
      this.formData.combinations.splice(i, 1);
    },
    createCombinations() {
      const attributes = this.formData.attributes;
      const old_combinations = this.formData.combinations;
      this.formData.combinations = [];
      if (attributes.length >= 1) {
        var arr = attributes.map(function (a) {
          return a.values;
        });
        // Number of arrays
        let n = arr.length;

        // To keep track of next element in
        // each of the n arrays
        let indices = new Array(n);

        // Initialize with first element's index
        for (let i = 0; i < n; i++) indices[i] = 0;

        var result = [];
        while (true) {
          var obj = {};
          var name_comb = "";
          var slug_comb = "";
          var und = 0;
          for (let i = 0; i < n; i++)
            // if not empty value
            if (
              arr[i][indices[i]].value[
                this.allActiveLanguages.languages[0].code
              ] != undefined
            ) {
              name_comb =
                name_comb +
                arr[i][indices[i]].value[
                  this.allActiveLanguages.languages[0].code
                ] +
                "-";
              slug_comb = slug_comb + arr[i][indices[i]].slug + "-";
            } else {
              und = 1;
            }
          // name combination, slug combination and price
          if (und == 0) {
            name_comb = name_comb.slice(0, -1);
            slug_comb = slug_comb.slice(0, -1);
            obj.name_combination = name_comb;
            obj.variant = slug_comb;
            var old_ind = old_combinations.findIndex(
              (comb) => comb.variant == slug_comb
            );
            if (old_ind != -1) {
              if (old_combinations[old_ind].price != "") {
                obj.price = old_combinations[old_ind].price;
              } else {
                obj.price = "";
              }
              if (old_combinations[old_ind].sku != "") {
                obj.sku = old_combinations[old_ind].sku;
              } else {
                obj.sku = "";
              }
              if (old_combinations[old_ind].stock != "") {
                obj.stock = old_combinations[old_ind].stock;
              } else {
                obj.stock = "";
              }
            } else {
              obj.price = "";
              obj.sku = "";
              obj.stock = "";
            }
            this.formData.combinations.push(obj);
          }

          // Find the rightmost array that has more
          // elements left after the current element
          // in that array
          let next = n - 1;
          while (next >= 0 && indices[next] + 1 >= arr[next].length) next--;

          // No such array is found so no more
          // combinations left
          if (next < 0) return;

          // If found move to next element in that
          // array
          indices[next]++;

          // For all arrays to the right of this
          // array current index again points to
          // first element
          for (let i = next + 1; i < n; i++) indices[i] = 0;
        }
      }

      return result;
    },
    async update() {
      this.disabled = true;
      // If any attribue is empty show error
      for (let index = 0; index < this.formData.attributes.length; index++) {
        const element = this.formData.attributes[index];
        if (element.values.length == 0) {
          this.$toast.error("Attribute Values Cannot be Empty");
          this.disabled = false;
          return false;
        }
      }
      await this.updateProductAttribute({
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
          // this.initFormData()
          this.formData.attributes = res.product.attributes;
          this.error = false;
          this.$toast.success(res.message);
          this.$router.replace(this.localePath("/seller/products"));
        }
      });
      this.disabled = false;
    },
  },
  mounted() {},
  computed: {
    ...mapGetters({
      allActiveAttributes: "General/allActiveAttributes",
      allActiveLanguages: "General/allActiveLanguages",
    }),
  },
};
</script>
