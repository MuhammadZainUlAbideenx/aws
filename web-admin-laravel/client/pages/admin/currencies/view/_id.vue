<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0 mb-2">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.currency.view_currency") }}
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
                <nuxt-link :to="localePath('/admin/currencies')">{{
                  this.$t("sidebar.currency")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.view") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.currency.view_description") }}
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
          <div class="card-body">
            <div class="row mb-2">
              <div class="show-table px-0 mb-0">
                <div class="row justify-content-end">
                  <div class="col-3">
                    <label for="input-live form-label">{{
                      this.$t("form.currency.name.label")
                    }}</label>
                  </div>
                  <div class="col-3"><p>{{ currency.name }}</p></div>
                  <div class="col-3">
                    <label for="input-live form-label">{{
                      this.$t("form.currency.direction.label")
                    }}</label>
                  </div>
                  <div class="col-3"><p>{{ currency.direction }}</p></div>
                  <div class="col-3">
                    <label for="input-live form-label">{{
                      this.$t("form.currency.code.label")
                    }}</label>
                  </div>
                  <div class="col-3"><p>{{ currency.code }}</p></div>
                  <div class="col-3">
                    <label for="input-live form-label">{{
                      this.$t("form.currency.symbol.label")
                    }}</label>
                  </div>
                  <div class="col-3"><p>{{ currency.symbol }}</p></div>
                  <div class="col-3">
                    <label for="input-live form-label">{{
                      this.$t("form.currency.decimal_places.label")
                    }}</label>
                  </div>
                  <div class="col-3"><p>{{ currency.decimal_places }}</p></div>
                  <div class="col-3">
                    <label for="input-live form-label">{{
                      this.$t("form.currency.status.label")
                    }}</label>
                  </div>
                  <div class="col-3">
                    <div class="form-switch d-flex align-items-center">
                      <input
                        class="form-check-input"
                        :checked="currency.is_active ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked" disabled
                      />
                    </div>
                  </div>
                  <div class="col-3">
                    <label for="input-live form-label">{{
                      this.$t("form.currency.is_default.label")
                    }}</label>
                  </div>
                  <div class="col-3">
                    <div class="form-switch d-flex align-items-center">
                      <input
                        class="form-check-input"
                        :checked="currency.is_default ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked" disabled
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
    permission: "currencies.index",
    strategy: "read",
  },
  data() {
    return {
      currency: "",
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.currencies.show(
      this.$route.params.id
    );
    this.currency = data;
  },
  methods: {},
  mounted() {},
};
</script>
