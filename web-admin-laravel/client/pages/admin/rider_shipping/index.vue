<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("sidebar.rider_shipping.label") }}
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
                {{ this.$t("sidebar.rider_shipping.label") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("sidebar.rider_shipping.index_description") }}
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
            <div class="card gutter-b border-0 p-0 pt-3">
              <div class="card-body p-3">
                <div class="row">
                  <div role="group" class="col-md-6 my-1">
                    <label for="input-live" class="form-label">{{
                      $t("commission_type")
                    }}</label>
                    <span
                      class="float-end text-danger"
                      v-if="error && error.commission_type"
                    >
                      {{ error.commission_type[0] }}
                    </span>
                    <select
                      :class="error && error.commission_type ? 'error' : ''"
                      class="form-select"
                      v-model="formData.commission_type"
                    >
                      <option value="">
                        {{ $t("sidebar.rider_shipping.commission_type") }}
                      </option>
                      <option value="0">Percentage</option>
                      <option value="1">Fixed</option>
                    </select>
                    <span class="heebo-light">
                      {{ $t("form.rider_shipping.commission_type.subheading") }}
                    </span>
                  </div>
                  <div role="group" class="col-md-6 my-1">
                    <label for="input-live" class="form-label">{{
                      $t("rate")
                    }}</label>
                    <span
                      class="float-end text-danger"
                      v-if="error && error.rate"
                    >
                      {{ error.rate[0] }}
                    </span>
                    <input
                      :class="error && error.rate ? 'error' : ''"
                      class="form-control"
                      aria-describedby="input-live-help input-live-feedback"
                      v-model="formData.rate"
                      :placeholder="
                        this.$t('form.rider_shipping.rate.placeholder')
                      "
                      trim
                    />
                    <span class="heebo-light">
                      {{ $t("rate") }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" v-permission="'rider_shipping.index'">
              <div class="col-md-12 text-center text-md-end">
                <button
                  type="button"
                  class="btn btn-primary mb-3 px-3 py-2"
                  @click="update()"
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
<script>
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "rider_shipping.index",
    strategy: "index",
  },
  mounted() {},
  async fetch() {
   await this.getRiderShipping();
  },
  data() {
    return {
      options: [
        { value: 0, text: this.$t("form.rider_shipping.percentage") },
        { value: 1, text: this.$t("form.rider_shipping.fixed") },
      ],
      key: "",
      value: "",
      formData: {
        commission_type: "",
        rate: "",
      },
      error: false,
    };
  },
  methods: {
async getRiderShipping() {
      const data = await this.$generalService.getRiderShipping();
      if (data) {
        this.formData.rate = data.commission_rate;
        this.formData.commission_type = data.commission_type;
      }
    },
    async update() {
      const data = await this.$generalService.updateRiderCommission(this.formData);
   this.$toast.success(data.message);
    },
  },
  computed: {},
};
</script>
