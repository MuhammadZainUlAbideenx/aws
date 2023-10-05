<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("view_admin") }}
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
                <nuxt-link :to="localePath('/admin/admins')">{{
                  this.$t("sidebar.admin")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.view") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.admin.view_description") }}
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
      <AdminViewLoader/>
      </div>
      <div class="container" v-else>
        <div class="card gutter-b border-0">
          <div class="card-body ">
            <div class="row">
              <div class="show-table mb-3 px-0">
                <div class="row justify-content-end">
                  <div class="col-3">
                    {{ this.$t("form.admin.admin_type.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ admin.admin_type.display_name }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.admin.first_name.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ admin.first_name }}</p>
                  </div>
                  <div class="col-3">
                    {{ this.$t("form.admin.last_name.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ admin.last_name }}</p>
                  </div>

                  <div class="col-3">{{ this.$t("form.admin.dob.label") }}</div>
                  <div class="col-3">
                    <p>{{ admin.dob }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.admin.phone.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ admin.phone }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.admin.address.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ admin.address }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.admin.zip_code.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ admin.zip_code }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.admin.country.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ admin.country.name }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.admin.state.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ admin.state.name }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.admin.city.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ admin.city.name }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.admin.email.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ admin.email }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.admin.gender.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ admin.gender }}</p>
                  </div>

                  <div class="col-3">
                    <label class="label form-label pe-4">
                      {{ this.$t("form.admin.status.label") }}
                    </label>
                  </div>
                  <div class="col-3">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        :checked="admin.is_active ? 'checked' : ''"
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
    permission: "admins.index",
    strategy: "read",
  },
  data() {
    return {
      options: [
        { value: "", text: "Select your Positioning" },
        { value: "ltr", text: "Select ltr Positioning" },
        { value: "rtl", text: "Select rtl Positioning" },
      ],
      admin: "",
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.admins.show(
      this.$route.params.id
    );
    this.admin = data;
  },
  methods: {},
  mounted() {},
};
</script>
