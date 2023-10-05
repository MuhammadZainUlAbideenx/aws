<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.permission.edit_permission") }}
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
                <nuxt-link :to="localePath('/admin/roles')">{{
                  this.$t("sidebar.role")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item">
                <nuxt-link to="#">{{
                  this.$t("sidebar.permission")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.edit") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("permission.index_description") }}
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
        <AdminPermissionTable />
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body px-0">
                <div class="table-responsive permission-table">
                  <table class="table table-striped">
                    <thead>
                      <tr class="px-3">
                        <th rowspan="2">
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                v-model="checkAllPermissions"
                                @click="selectAllpermissions"
                                id="exampleCheck6"
                              />
                              <label
                                class="form-check-label"
                                for="exampleCheck6"
                              >
                                {{ $t("select_all") }}</label
                              >
                            </div>
                          </div>
                        </th>

                        <th>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                @change="toggleColumnSelect('Index', 'index')"
                                v-model="checkAllIndexPermissions"
                                id="exampleCheck1"
                              />
                              <label
                                class="form-check-label"
                                for="exampleCheck1"
                              ></label>
                            </div>
                          </div>
                        </th>
                        <th>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                @change="toggleColumnSelect('Create', 'create')"
                                v-model="checkAllCreatePermissions"
                                id="exampleCheck2"
                              />
                              <label
                                class="form-check-label"
                                for="exampleCheck2"
                              ></label>
                            </div>
                          </div>
                        </th>
                        <th>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                @change="toggleColumnSelect('Update', 'update')"
                                v-model="checkAllUpdatePermissions"
                                id="exampleCheck3"
                              />
                              <label
                                class="form-check-label"
                                for="exampleCheck3"
                              ></label>
                            </div>
                          </div>
                        </th>
                        <th>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                @change="toggleColumnSelect('Delete', 'delete')"
                                v-model="checkAllDeletePermissions"
                                id="exampleCheck4"
                              />
                              <label
                                class="form-check-label"
                                for="exampleCheck4"
                              ></label>
                            </div>
                          </div>
                        </th>
                        <th>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                @change="
                                  toggleColumnSelect('Status', 'is_active')
                                "
                                v-model="checkAllStatusPermissions"
                                id="exampleCheck5"
                              />
                              <label
                                class="form-check-label"
                                for="exampleCheck5"
                              ></label>
                            </div>
                          </div>
                        </th>
                      </tr>
                      <tr class="border-0">
                        <th class="pt-0">Show</th>
                        <th class="pt-0">Create</th>
                        <th class="pt-0">Update</th>
                        <th class="pt-0">Delete</th>
                        <th class="pt-0">Change Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(crud, index) in cruds" :key="index">
                        <th scope="row">{{ crud }}</th>
                        <td>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                @change="anyCheckBoxClicked"
                                v-model="formData.permissions[crud + '.index']"
                                class="form-check-input"
                                :id="'exampleCheck1' + crud + '.index'"
                              />
                              <label
                                class="form-check-label"
                                :for="'exampleCheck1' + crud + '.index'"
                              ></label>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                @change="anyCheckBoxClicked"
                                v-model="formData.permissions[crud + '.create']"
                                :id="'exampleCheck1' + crud + '.create'"
                              />
                              <label
                                class="form-check-label"
                                :for="'exampleCheck1' + crud + '.create'"
                              ></label>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                @change="anyCheckBoxClicked"
                                v-model="formData.permissions[crud + '.update']"
                                :id="'exampleCheck1' + crud + '.update'"
                              />
                              <label
                                class="form-check-label"
                                :for="'exampleCheck1' + crud + '.update'"
                              ></label>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                @change="anyCheckBoxClicked"
                                v-model="formData.permissions[crud + '.delete']"
                                :id="'exampleCheck1' + crud + '.delete'"
                              />
                              <label
                                class="form-check-label"
                                :for="'exampleCheck1' + crud + '.delete'"
                              ></label>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                @change="anyCheckBoxClicked"
                                v-model="
                                  formData.permissions[crud + '.is_active']
                                "
                                :id="'exampleCheck1' + crud + '.is_active'"
                              />
                              <label
                                class="form-check-label"
                                :for="'exampleCheck1' + crud + '.is_active'"
                              ></label>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr v-for="set in settings_index_update" :key="set">
                        <th scope="row">{{ set }}</th>
                        <td>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                @change="anyCheckBoxClicked"
                                v-model="formData.permissions[set + '.index']"
                                :id="'exampleCheck1' + set + '.index'"
                              />
                              <label
                                class="form-check-label"
                                :for="'exampleCheck1' + set + '.index'"
                              ></label>
                            </div>
                          </div>
                        </td>
                        <td></td>
                        <td>
                          <div class="col-sm-6">
                            <div class="form-check">
                              <input
                                type="checkbox"
                                class="form-check-input"
                                @change="anyCheckBoxClicked"
                                v-model="formData.permissions[set + '.update']"
                                :id="'exampleCheck1' + set + '.update'"
                              />
                              <label
                                class="form-check-label"
                                :for="'exampleCheck1' + set + '.update'"
                              ></label>
                            </div>
                          </div>
                        </td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 px-4 text-center text-md-end">
            <button
              type="button"
              class="btn btn-secondary mb-3 px-3 py-2"
              @click="update"
              name="button"
            >
              {{ this.$t("form.update") }}
            </button>
            <button
              type="button"
              class="btn btn-success mb-3 px-3 py-2"
              @click="updateAndContinue"
              name="button"
            >
              {{ this.$t("form.update_and_continue") }}
            </button>
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
    permission: "roles.update",
    strategy: "update",
  },
  data() {
    return {
      cruds: [
        "languages",
        "manufacturers",
        "products",
        "units",
        "attributes",
        "attribute_values",
        "categories",
        "tax_classes",
        "vendors",
        "order_statuses",
        "orders",
        "roles",
        "currencies",
        "coupons",
        "slider_images",
        "static_banners",
        "zones",
        "newsletters",
        "countries",
        "cities",
        "states",
        "tax_rates",
        "parallax_banners",
        "customers",
        "reviews",
        "admins",
        "news_categories",
        "about_us",
        "term_condition",
        "privacy_policy",
        "refund_policy",
        "newses",
        "faqs",
        "addresses",
        "content_pages",
        "coupons",
        "review_statuses",
        "application_banners",
        "splash_screens",
        "application_parallax_banners",
        "application_slider_images",
        "content_application_pages",
        "brands",
        "riders",
        "shipping_methods",
        "payment_methods",
        "contact_forms",
        "reports",
        "sales",
        "payout_requests",
        "rider_payout_requests",
        "live_chat",
      ],
      settings_index_update: [
        "theme_settings",
        "settings",
        "media_settings",
        "commissions",
        "seo_pages",
        "store_settings",
        "facebook_settings",
        "google_settings",
        "alert_settings",
        "api_protection_settings",
        "social_login_settings",
        "main_settings",
        "inventories",
        "rider_shipping",
      ],
      other_permissions: [],
      formData: {
        permissions: {},
      },
      error: false,
      checkAllPermissions: false,
      isAnyPermissionFalse: false,
      checkAllIndexPermissions: true,
      checkAllUpdatePermissions: true,
      checkAllCreatePermissions: true,
      checkAllStatusPermissions: true,
      checkAllDeletePermissions: true,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.roles.show(this.$route.params.id);
    // get and update data
    for (var i = 0; i < data.permissions.length; i++) {
      this.formData.permissions[data.permissions[i]["name"]] = true;
    }
    if (
      data.permissions.length ==
      this.cruds.length * 5 + this.settings_index_update.length * 2
    ) {
      this.checkAllPermissions = true;
      this.isAnyPermissionFalse = false;
    }
    this.anyCheckBoxClicked();
  },
  methods: {
    selectAllpermissions() {
      if (!this.checkAllPermissions) {
        this.makeEveryPermissionTrue();
      } else {
        this.makeEveryPermissionFalse();
      }
    },
    anyCheckBoxClicked(e) {
      for (var i = 0; i < this.cruds.length; i++) {
        if (!this.formData.permissions[`${this.cruds[i]}.index`]) {
          this.isAnyPermissionFalse = true; //if any of the permission is false
        }
        if (!this.formData.permissions[`${this.cruds[i]}.create`]) {
          this.isAnyPermissionFalse = true; //if any of the permission is false
        }
        if (!this.formData.permissions[`${this.cruds[i]}.update`]) {
          this.isAnyPermissionFalse = true; //if any of the permission is false
        }
        if (!this.formData.permissions[`${this.cruds[i]}.delete`]) {
          this.isAnyPermissionFalse = true; //if any of the permission is false
        }
        if (!this.formData.permissions[`${this.cruds[i]}.is_active`]) {
          this.isAnyPermissionFalse = true; //if any of the permission is false
        }
      }
      for (var i = 0; i < this.settings_index_update.length; i++) {
        if (
          !this.formData.permissions[`${this.settings_index_update[i]}.index`]
        ) {
          this.isAnyPermissionFalse = true; //if any of the permission is false
        }
        if (
          !this.formData.permissions[`${this.settings_index_update[i]}.update`]
        ) {
          this.isAnyPermissionFalse = true; //if any of the permission is false
        }
      }
      if (this.isAnyPermissionFalse) {
        this.checkAllPermissions = false;
        this.isAnyPermissionFalse = false;
        this.checkColumnsToBeSelected();
      } else {
        this.makeEveryPermissionTrue();
      }
      this.$forceUpdate();
    },
    makeEveryPermissionTrue() {
      for (var i = 0; i < this.cruds.length; i++) {
        this.$set(this.formData.permissions, `${this.cruds[i]}.index`, true);
        this.$set(this.formData.permissions, `${this.cruds[i]}.create`, true);
        this.$set(this.formData.permissions, `${this.cruds[i]}.update`, true);
        this.$set(this.formData.permissions, `${this.cruds[i]}.delete`, true);
        this.$set(
          this.formData.permissions,
          `${this.cruds[i]}.is_active`,
          true
        );
      }
      for (var i = 0; i < this.settings_index_update.length; i++) {
        this.$set(
          this.formData.permissions,
          `${this.settings_index_update[i]}.index`,
          true
        );
        this.$set(
          this.formData.permissions,
          `${this.settings_index_update[i]}.update`,
          true
        );
      }
      this.checkAllPermissions = true;
      this.checkAllIndexPermissions = true;
      this.checkAllUpdatePermissions = true;
      this.checkAllCreatePermissions = true;
      this.checkAllStatusPermissions = true;
      this.checkAllDeletePermissions = true;
    },
    makeEveryPermissionFalse() {
      for (var i = 0; i < this.cruds.length; i++) {
        this.formData.permissions[`${this.cruds[i]}.index`] = false;
        this.formData.permissions[`${this.cruds[i]}.create`] = false;
        this.formData.permissions[`${this.cruds[i]}.update`] = false;
        this.formData.permissions[`${this.cruds[i]}.delete`] = false;
        this.formData.permissions[`${this.cruds[i]}.is_active`] = false;
      }
      for (var i = 0; i < this.settings_index_update.length; i++) {
        this.formData.permissions[
          `${this.settings_index_update[i]}.index`
        ] = false;
        this.formData.permissions[
          `${this.settings_index_update[i]}.update`
        ] = false;
      }
      this.checkAllPermissions = false;
      this.checkAllIndexPermissions = false;
      this.checkAllUpdatePermissions = false;
      this.checkAllCreatePermissions = false;
      this.checkAllStatusPermissions = false;
      this.checkAllDeletePermissions = false;
    },
    toggleColumnSelect(column, column2) {
      if (this[`checkAll${column}Permissions`]) {
        for (var i = 0; i < this.cruds.length; i++) {
          this.formData.permissions[`${this.cruds[i]}.${column2}`] = true;
        }
        for (var i = 0; i < this.settings_index_update.length; i++) {
          this.formData.permissions[
            `${this.settings_index_update[i]}.${column2}`
          ] = true;
        }
      } else {
        for (var i = 0; i < this.cruds.length; i++) {
          this.formData.permissions[`${this.cruds[i]}.${column2}`] = false;
        }
        for (var i = 0; i < this.settings_index_update.length; i++) {
          this.formData.permissions[
            `${this.settings_index_update[i]}.${column2}`
          ] = false;
        }
      }
      this.anyCheckBoxClicked();
    },
    checkColumnsToBeSelected() {
      this.checkAllIndexPermissions = true;
      this.checkAllUpdatePermissions = true;
      this.checkAllCreatePermissions = true;
      this.checkAllStatusPermissions = true;
      this.checkAllDeletePermissions = true;
      for (var i = 0; i < this.cruds.length; i++) {
        if (!this.formData.permissions[`${this.cruds[i]}.index`]) {
          this.checkAllIndexPermissions = false;
        }
        if (!this.formData.permissions[`${this.cruds[i]}.create`]) {
          this.checkAllCreatePermissions = false;
        }
        if (!this.formData.permissions[`${this.cruds[i]}.update`]) {
          this.checkAllUpdatePermissions = false;
        }
        if (!this.formData.permissions[`${this.cruds[i]}.delete`]) {
          this.checkAllDeletePermissions = false;
        }
        if (!this.formData.permissions[`${this.cruds[i]}.is_active`]) {
          this.checkAllStatusPermissions = false;
        }
      }
      for (var i = 0; i < this.settings_index_update.length; i++) {
        if (
          !this.formData.permissions[`${this.settings_index_update[i]}.index`]
        ) {
          this.checkAllIndexPermissions = false;
        }
        if (
          !this.formData.permissions[`${this.settings_index_update[i]}.update`]
        ) {
          this.checkAllUpdatePermissions = false;
        }
      }
    },
    ...mapActions({
      updateRoles: "Roles/updateRoles",
    }),

    async update() {
      await this.updateAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/roles"));
      }
    },
    async updateAndContinue() {
      await this.updateRoles({
        formData: this.formData,
        id: this.$route.params.id,
      }).then(async (res) => {
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
    },
  },
  mounted() {},
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
    }),
  },
};
</script>
