
<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.commission.edit_commission") }}
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
                <nuxt-link :to="localePath('/admin/commissions')">{{
                  this.$t("sidebar.commission")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.edit") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.commission.edit_description") }}
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
        <AdminFormLoader />
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div
                class="card-body"
                v-if="
                  allActiveSettings.settings.generalSettings.is_multi_vendor ==
                  1
                "
              >
                <div class="row" v-if="vendor_commission_type == 0">
                  <!-- Commission By category -->
                  <div class="col-sm-12 d-flex ">
                        <div class="col-md-8 d-flex align-items-center">
                            <h5 class="m-0 text-body bold" v-if="formData.commission_by_category.length == 0"> {{ $t("form.commission.no_data") }}</h5>
                  </div>
                  <div class="justify-content-end d-flex col-md-4" >
                    <button

                      type="button"
                      v-on:click="addField()"
                      class="
                        btn
                        add
                        btn-primary
                        me-1
                        p-3
                        me-3
                        shadow
                        rounded-circle
                      "
                      name="button"
                    >
                      <fa :icon="['fas', 'plus']" fixed-width />
                    </button>
                  </div>
                  </div>
                  <div
                    class="row p-4 commission-section mt-3"
                    v-for="(input, index) in formData.commission_by_category"
                    :key="`phoneInput-${index}`"
                  >
                    <div class="col-md-6 my-1">
                      <div role="group ">
                        <label for="input-live" class="form-label"
                          >{{
                            $t("form.commission.category.name.label")
                          }}:</label
                        >
                        <select
                          :class="
                            error &&
                            error[`commission_by_category.${index}.category_id`]
                              ? 'error'
                              : ''
                          "
                          class="form-select"
                          v-model="
                            formData.commission_by_category[index].category_id
                          "
                          @input="checkDuplicateCategory($event)"
                        >
                          <option value="">
                            {{
                              $t("form.commission.category.select.placeholder")
                            }}
                          </option>
                          <option
                            :value="category.id"
                            v-for="category in allParentActiveCategories.categories"
                            :key="category.name"
                          >
                            {{ category.name }}
                          </option>
                        </select>

                        <span class="heebo-light">
                          {{ $t("form.commission.category.name.subheading") }}
                        </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1">
                      <div role="group ">
                        <label for="input-live" class="form-label"
                          >{{ $t("form.commission.rate_type.label") }}:</label
                        >
                        <span
                          class="float-end text-danger"
                          v-if="
                            error &&
                            error[`commission_by_category.${index}.rate_type`]
                          "
                        >
                          {{
                            error[
                              `commission_by_category.${index}.rate_type`
                            ][0]
                          }}
                        </span>
                        <select
                          :class="
                            error &&
                            error[`commission_by_category.${index}.rate_type`]
                              ? 'error'
                              : ''
                          "
                          class="form-select"
                          v-model="
                            formData.commission_by_category[index].rate_type
                          "
                        >
                          <option value="">
                            {{ $t("form.commission.rate_type.placeholder") }}
                          </option>
                          <option
                            :value="option.value"
                            v-for="option in options"
                            :key="option.value"
                          >
                            {{ option.text }}
                          </option>
                        </select>
                        <span class="heebo-light">
                          {{ $t("form.commission.rate_type.subheading") }}
                        </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1">
                      <div role="group " v-if="formData.commission_by_category[index].rate_type == 1">
                        <label for="input-live" class="form-label"
                          >{{ $t("form.commission.rate_percentage.label") }}:</label
                        >
                        <span
                          class="float-end text-danger"
                          v-if="
                            error &&
                            error[`commission_by_category.${index}.rate`]
                          "
                        >
                          {{ error[`commission_by_category.${index}.rate`][0] }}
                        </span>
                         <div class="input-group">
                       <span class="input-group-text mb-3">
                        %</span
                      >
                        <input
                          class="form-control"
                          :class="
                            error &&
                            error[`commission_by_category.${index}.rate`]
                              ? 'error'
                              : ''
                          "
                          aria-describedby="input-live-help input-live-feedback"
                          type="number"
                          :placeholder="$t('form.commission.rate_percentage.placeholder')"
                          trim
                          v-model="formData.commission_by_category[index].rate"
                        /></div>
                        <span class="heebo-light">
                          {{ $t("form.commission.rate_percentage.subheading") }}
                        </span>
                      </div>
                       <div role="group " v-else>
                        <label for="input-live" class="form-label"
                          >{{ $t("form.commission.rate_fixed.label") }}:</label
                        >
                        <span
                          class="float-end text-danger"
                          v-if="
                            error &&
                            error[`commission_by_category.${index}.rate`]
                          "
                        >
                          {{ error[`commission_by_category.${index}.rate`][0] }}
                        </span>
                         <div class="input-group">
                       <span class="input-group-text mb-3">
                        {{ allActiveSettings.settings.current_currency }}</span
                      >
                        <input
                          class="form-control"
                          :class="
                            error &&
                            error[`commission_by_category.${index}.rate`]
                              ? 'error'
                              : ''
                          "
                          aria-describedby="input-live-help input-live-feedback"
                          type="number"
                          :placeholder="$t('form.commission.rate_fixed.placeholder')"
                          trim
                          v-model="formData.commission_by_category[index].rate"
                        />
                         </div>
                        <span class="heebo-light">
                          {{ $t("form.commission.rate_fixed.subheading") }}
                        </span>
                      </div>
                    </div>
                    <!-- fixed amount field when rate type is fixed. starts -->
                    <div class="col-md-6 my-1">
                      <div role="group " v-if="formData.commission_by_category[index].rate_type == 2">
                        <label for="input-live" class="form-label"
                          >{{ $t("form.commission.commission_amount_fixed.label") }}:</label
                        >
                         <div class="input-group">
                       <span class="input-group-text mb-3">
                        {{ allActiveSettings.settings.current_currency }}</span
                      >
                        <span
                          class="float-end text-danger"
                          v-if="
                            error &&
                            error[`commission_by_category.${index}.rate_type`]
                          "
                        >
                          {{ error[`commission_by_category.${index}.rate_type`][0] }}
                        </span>
                        <input
                          class="form-control"
                          :class="
                            error &&
                            error[`commission_by_category.${index}.rate_type`]
                              ? 'error'
                              : ''
                          "
                          aria-describedby="input-live-help input-live-feedback"
                          type="number"
                          :placeholder="$t('form.commission.commission_amount_fixed.placeholder')"
                          trim
                          v-model="formData.commission_by_category[index].commission_min_amount_fixed"
                        />
                         </div>
                        <span class="heebo-light">
                          {{ $t("form.commission.commission_amount_fixed.subheading") }}
                        </span>
                      </div>

                    </div>
                    <!-- fixed amount field when rate type is fixed. ends -->
                    <div class="col-md-6 my-1 ">
                      <div role="group" class="text-end">
                        <button
                            v-show="formData.commission_by_category.length > 0"
                            type="button"
                            v-on:click="removeField(index)"
                            class="
                              btn
                              add
                              btn-danger
                              me-1
                              p-0
                              custom-btn
                              shadow
                              rounded-circle

                            "
                            name="button"
                          >
                            <fa :icon="['fas', 'trash-alt']" fixed-width />
                          </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row" v-else-if="vendor_commission_type == 1">
                  <!-- Commission By no. of sales -->
                  <div
                    class="row p-4 commission-section"
                    v-for="(commission, index) in formData.commission_by_sale"
                    :key="index"
                  >
                    <div class="col-md-10 px-0">
                      <div class="row">
                        <div class="col-md-6 my-1 px-3">
                          <div role="group ">
                            <label for="input-live" class="form-label"
                              >{{
                                $t("form.commission.from_sale.label")
                              }}:</label
                            >
                            <span
                              class="float-end text-danger"
                              v-if="
                                error &&
                                error[`commission_by_sale.${index}.from_sale`]
                              "
                            >
                              {{
                                error[
                                  `commission_by_sale.${index}.from_sale`
                                ][0]
                              }}
                            </span>
                            <input
                              class="form-control"
                              :class="
                                error &&
                                error[`commission_by_sale.${index}.from_sale`]
                                  ? 'error'
                                  : ''
                              "
                              v-model="
                                formData.commission_by_sale[index].from_sale
                              "
                              :min="1"
                              type="number"
                              readonly
                              aria-describedby="input-live-help input-live-feedback"
                              :placeholder="
                                $t('form.commission.from_sale.placeholder')
                              "
                              trim
                            />
                            <span class="heebo-light">
                              {{ $t("form.commission.from_sale.subheading") }}
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6 my-1 px-3">
                          <div role="group">
                            <label for="input-live" class="form-label"
                              >{{ $t("form.commission.to_sale.label") }}:</label
                            >
                            <span
                              class="float-end text-danger"
                              v-if="
                                error &&
                                error[`commission_by_sale.${index}.to_sale`]
                              "
                            >
                              {{
                                error[`commission_by_sale.${index}.to_sale`][0]
                              }}
                            </span>
                            <input
                              :class="
                                error &&
                                error[`commission_by_sale.${index}.to_sale`]
                                  ? 'error'
                                  : ''
                              "
                              class="form-control"
                              v-model="
                                formData.commission_by_sale[index].to_sale
                              "
                              v-on:change="changeNext(index)"
                              type="number"
                              :disabled="
                                index < formData.commission_by_sale.length - 2
                              "
                              aria-describedby="input-live-help input-live-feedback"
                              :placeholder="
                                $t('form.commission.to_sale.placeholder')
                              "
                              trim
                            />
                            <span class="heebo-light">
                              {{ $t("form.commission.to_sale.subheading") }}
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6 my-1 px-3">
                          <div role="group">
                            <label for="input-live" class="form-label"
                              >{{
                                $t("form.commission.duration.label")
                              }}:</label
                            >
                            <span
                              class="float-end text-danger"
                              v-if="
                                error &&
                                error[`commission_by_sale.${index}.duration`] &&
                                index == 0
                              "
                            >
                              {{
                                error[`commission_by_sale.${index}.duration`][0]
                              }}
                            </span>
                            <input
                              :class="
                                error &&
                                error[`commission_by_sale.${index}.duration`]
                                  ? 'error'
                                  : ''
                              "
                              class="form-control"
                              :min="0"
                              :readonly="index > 0"
                              type="number"
                              v-model="duration"
                              v-on:change="setDuration($event)"
                              aria-describedby="input-live-help input-live-feedback"
                              :placeholder="
                                $t('form.commission.duration.placeholder')
                              "
                              trim
                            />
                            <span class="heebo-light">
                              {{ $t("form.commission.duration.subheading") }}
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6 my-1 px-3">
                          <div role="group">
                            <label for="input-live" class="form-label"
                              >{{
                                $t("form.commission.rate_type.label")
                              }}:</label
                            >
                            <span
                              class="float-end text-danger"
                              v-if="
                                error &&
                                error[`commission_by_sale.${index}.rate_type`]
                              "
                            >
                              {{
                                error[
                                  `commission_by_sale.${index}.rate_type`
                                ][0]
                              }}
                            </span>
                            <select
                              :class="
                                error &&
                                error[`commission_by_sale.${index}.rate_type`]
                                  ? 'error'
                                  : ''
                              "
                              class="form-select"
                              v-model="
                                formData.commission_by_sale[index].rate_type
                              "
                            >
                              <option value="">
                                {{
                                  $t("form.commission.rate_type.placeholder")
                                }}
                              </option>
                              <option
                                :value="option.value"
                                :key="option.value"
                                v-for="option in options"
                              >
                                {{ option.text }}
                              </option>
                            </select>
                            <span class="heebo-light">
                              {{ $t("form.commission.rate_type.subheading") }}
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6 my-1 px-3">
                          <div role="group">
                            <label for="input-live" class="form-label"
                              >{{ $t("form.commission.rate.label") }}:</label
                            >
                            <span
                              class="float-end text-danger"
                              v-if="
                                error &&
                                error[`commission_by_sale.${index}.rate`]
                              "
                            >
                              {{ error[`commission_by_sale.${index}.rate`][0] }}
                            </span>
                            <input
                              :class="
                                error &&
                                error[`commission_by_sale.${index}.rate`]
                                  ? 'error'
                                  : ''
                              "
                              class="form-control"
                              aria-describedby="input-live-help input-live-feedback"
                              v-model="formData.commission_by_sale[index].rate"
                              :min="0"
                              type="number"
                              :placeholder="
                                $t('form.commission.rate.placeholder')
                              "
                              trim
                            />
                            <span class="heebo-light">
                              {{ $t("form.commission.rate.subheading") }}
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div
                      class="
                        col-md-2
                        d-flex
                        align-items-start
                        justify-content-end
                      "
                    >
                      <button
                        v-if="index == formData.commission_by_sale.length - 1"
                        type="button"
                        v-on:click="addMore()"
                        class="
                          btn
                          add
                          btn-primary
                          me-1
                          p-3
                          me-3
                          shadow
                          rounded-circle
                        "
                        name="button"
                      >
                        <fa :icon="['fas', 'plus']" fixed-width />
                      </button>
                      <button
                        v-if="
                          index == formData.commission_by_sale.length - 1 &&
                          index != 0
                        "
                        type="button"
                        v-on:click="remove()"
                        class="
                          btn
                          add
                          btn-danger
                          me-1
                          p-3
                          shadow
                          rounded-circle
                        "
                        name="button"
                      >
                        <fa :icon="['fas', 'trash-alt']" fixed-width />
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 px-4 text-center text-md-end">
                <button
                  type="button"
                  :disabled="btn_disabled"
                  class="btn btn-secondary mb-3 px-3 py-2"
                  @click="update"
                  name="button"
                >
                  {{ $t("form.update") }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";
export default {
  name: "AddRemove",
  layout: "admin",
  middleware: ["admin", "permission",'onlyMultiVendor'],
  meta: {
    permission: "commissions.update",
    strategy: "update",
  },
  data() {
    return {
      options: [
        { value: 1, text: this.$t("form.commission.rate_type.percentage") },
        { value: 2, text: this.$t("form.commission.rate_type.fixed") },
      ],
      selectedCategoryIds: [],
      disabled: false,
      duration: 1,
      formData: {
        commission_by_category: [],
        commission_by_sale: [],
      },
      btn_disabled: false,
      error: false,
    };
  },
  async fetch() {
    if (!this.allActiveSettings.settings) {
      await this.fetchActiveSettings();
    }
    if (!this.allParentActiveCategories.categories) {
      await this.fetchParentActiveCategories();
    }

    if (
      this.allActiveSettings.settings.generalSettings.is_multi_vendor == "1"
    ) {
      if (
        this.allActiveSettings.settings.generalSettings
          .vendor_commission_type == 0
      ) {
        const { data } = await this.$repositories.commissions.show(1);
        this.formData.commission_by_category = data;
        return;
        // Review this before delete
        for (var i = 0; i < data.length; i++) {
          var objIndex = this.formData.commission_by_category.findIndex(
            (obj) => obj.category_id == data[i].category_id
          );

          if (objIndex != undefined) {
            this.formData.commission_by_category[objIndex].rate = data[i].rate;
            this.formData.commission_by_category[objIndex].rate_type = data[i]
              .rate_type
              ? data[i].rate_type
              : "";
          }
        }
      } else {
        const { data } = await this.$repositories.commissions.show(1);
        if (data.length == 0) {
          var obj = {
            from_sale: 1,
            to_sale: "",
            duration: this.duration,
            rate: "",
            rate_type: "",
          };
          this.formData.commission_by_sale.push(obj);
        } else {
          for (var i = 0; i < data.length; i++) {
            var obj = {
              to_sale: data[i].to_sale,
              from_sale: data[i].from_sale,
              duration: data[i].duration,
              rate: data[i].rate,
              rate_type: data[i].rate_type,
            };
            this.formData.commission_by_sale.push(obj);
          }
          this.duration = data[1].duration;
        }
      }
    }
  },
  methods: {
    ...mapActions({
      addCommissions: "Commissions/addCommissions",
      deleteCommissions: "Commissions/deleteCommissions",
      fetchActiveCategories: "General/fetchActiveCategories",
      fetchActiveCommissions: "General/fetchActiveCommissions",
      fetchActiveSettings: "General/fetchActiveSettings",
      fetchParentActiveCategories: "General/fetchParentActiveCategories",
    }),
    addField() {
      var obj = {
        id: "",
        category_id: "",
        rate: "",
        rate_type: "",
      };
      this.formData.commission_by_category.push(obj);
    },
    async removeField(index) {
      if (
        this.formData.commission_by_category[index].category_id &&
        this.formData.commission_by_category[index].id
      ) {
        await this.delete(this.formData.commission_by_category[index].id);
      }
      this.formData.commission_by_category.splice(index, 1);
    },
    addMore() {
      var last = this.formData.commission_by_sale.length;
      if (last < 1) {
        var obj = {
          from_sale: 1,
          to_sale: "",
          duration: this.duration,
          rate: "",
          rate_type: "",
        };
        this.formData.commission_by_sale.push(obj);
      } else {
        var obj = {
          from_sale:
            parseInt(this.formData.commission_by_sale[last - 1].to_sale) + 1,
          to_sale: "",
          duration: this.duration,
          rate: "",
          rate_type: "",
        };
        this.formData.commission_by_sale.push(obj);
        this.disabled = true;
      }
    },
    remove() {
      if (this.formData.commission_by_sale.length == 0) {
        this.$toast.error("You must Add an item 1st");
      } else if (this.formData.commission_by_sale.length > 1) {
        this.formData.commission_by_sale.splice(-1, 1);
      } else {
        this.$toast.error("Cant remove 1st item");
      }
    },
    changeNext(index) {
      if (
        this.formData.commission_by_sale[index].to_sale <=
        this.formData.commission_by_sale[index].from_sale
      ) {
        this.formData.commission_by_sale[index].to_sale =
          parseInt(this.formData.commission_by_sale[index].from_sale) + 1;
      }
      if (this.formData.commission_by_sale[index + 1] != undefined) {
        this.formData.commission_by_sale[index + 1].from_sale =
          parseInt(this.formData.commission_by_sale[index].to_sale) + 1;
        if (
          this.formData.commission_by_sale[index + 1].to_sale <=
          this.formData.commission_by_sale[index + 1].from_sale
        ) {
          this.formData.commission_by_sale[index + 1].to_sale =
            this.formData.commission_by_sale[index + 1].from_sale;
        }
      }
    },
    setDuration(e) {
      for (var i = 0; i < this.formData.commission_by_sale.length; i++) {
        this.formData.commission_by_sale[i].duration = e.target.value;
      }
    },
    async update() {
      this.btn_disabled = true;
      await this.addCommissions(this.formData).then((res) => {
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.fetchActiveSettings();
          this.error = false;
          this.$toast.success(res.message);
        }
      });
      this.btn_disabled = false;
    },
    async delete(commission_id) {
      this.btn_disabled = true;
      await this.deleteCommissions({
        filterData: this.formData,
        commission_id: commission_id,
      }).then((res) => {
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.fetchActiveSettings();
          this.$fetch();
          this.error = false;
          this.$toast.success(res.message);
        }
      });
      this.btn_disabled = false;
    },
    checkDuplicateCategory(event) {
      this.btn_disabled = false;
      for (
        let index = 0;
        index < this.formData.commission_by_category.length;
        index++
      ) {
        const element = this.formData.commission_by_category[index];
        if (element.category_id == event.target.value) {
          this.btn_disabled = true;
          this.$toast.error("Category Already Selected");
        }
      }
    },
  },
  computed: {
    ...mapGetters({
      allActiveSettings: "General/allActiveSettings",
      allActiveCategories: "General/allActiveCategories",
      allParentActiveCategories: "General/allParentActiveCategories",
    }),
    vendor_commission_type: function () {
      var vendor_commission_type;
      vendor_commission_type =
        this.allActiveSettings.settings.generalSettings.vendor_commission_type;
      return vendor_commission_type;
    },
  },
  mounted() {
    var obj = {
      id: "",
      category_id: "",
      rate: "",
      rate_type: "",
    };
    this.formData.commission_by_category.push(obj);
    if (
      this.allActiveSettings.settings.generalSettings.is_multi_vendor == "0"
    ) {
      this.$router.replace(this.localePath("/admin/dashboard"));
    }
  },
};
</script>
