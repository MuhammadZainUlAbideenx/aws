<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.customer.view_customer") }}
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
                <nuxt-link :to="localePath('/admin/customers')">{{
                  this.$t("sidebar.customer")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.view") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.customer.view_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div v-if="$fetchState.pending">
        <AdminViewLoader />
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                  <div class="show-table px-0 mb-3">
                    <div class="row justify-content-end">
                      <div class="col-3">
                        <label for="input-live form-label">{{
                          this.$t("form.customer.first_name.label")
                        }}</label>
                      </div>
                      <div class="col-3">
                        <p>{{ customer.first_name }}</p>
                      </div>

                      <div class="col-3">
                        <label for="input-live form-label">{{
                          this.$t("form.customer.last_name.label")
                        }}</label>
                      </div>
                      <div class="col-3">
                        <p>{{ customer.last_name }}</p>
                      </div>

                      <div class="col-3">
                        <label for="input-live form-label">{{
                          this.$t("form.customer.dob.label")
                        }}</label>
                      </div>
                      <div class="col-3">
                        <p>{{ customer.dob }}</p>
                      </div>

                      <div class="col-3">
                        <label for="input-live form-label">{{
                          this.$t("form.customer.phone.label")
                        }}</label>
                      </div>
                      <div class="col-3">
                        <p>{{ customer.phone }}</p>
                      </div>

                      <div class="col-3">
                        <label for="input-live form-label">{{
                          this.$t("form.customer.address.label")
                        }}</label>
                      </div>
                      <div class="col-3">
                        <p
                          v-for="address in customer.addresses"
                          :key="address.id"
                        >
                          {{ address.address }} <br />
                        </p>
                      </div>

                      <div class="col-3">
                        <label for="input-live form-label">{{
                          this.$t("form.customer.email.label")
                        }}</label>
                      </div>
                      <div class="col-3">
                        <p>{{ customer.email }}</p>
                      </div>

                      <div class="col-3">
                        <label for="input-live form-label">{{
                          this.$t("form.customer.gender.label")
                        }}</label>
                      </div>
                      <div class="col-3">
                        <p>{{ customer.gender }}</p>
                      </div>

                      <div class="col-3">
                        <label class="label form-label pe-4">
                          {{ this.$t("form.customer.status.label") }}
                        </label>
                      </div>
                      <div class="col-3">
                        <div class="form-switch">
                          <input
                            class="form-check-input"
                            :checked="customer.is_active ? 'checked' : ''"
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
    permission: "customers.index",
    strategy: "read",
  },
  data() {
    return {
      options: [
        { value: "", text: "Select your Positioning" },
        { value: "ltr", text: "Select ltr Positioning" },
        { value: "rtl", text: "Select rtl Positioning" },
      ],
      customer: "",
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.customers.show(
      this.$route.params.id
    );
    this.customer = data;
  },
  methods: {},
  mounted() {},
};
</script>
