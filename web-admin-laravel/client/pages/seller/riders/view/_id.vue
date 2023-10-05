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
            {{ this.$t("form.rider.view_rider") }}
          </h2>
        </div>
        <!-- /.col -->
        <div class="row">
          <div class="col-sm-12 px-0">
            <ol class="breadcrumb float-sm-right text-body">
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/rider/dashboard')">{{
                  this.$t("sidebar.home")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/seller/riders')">{{
                  this.$t("sidebar.rider")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.view") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.rider.view_description") }}
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
            <div class="row">
              <div class="show-table px-0 mb-3">
                <div class="row justify-content-end">
                  <!-- <div class="col-3">
                    {{ this.$t("form.rider.rider_type.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ rider.rider_type.display_name }}</p>
                  </div> -->

                  <div class="col-3">
                    {{ this.$t("form.rider.first_name.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ rider.first_name }}</p>
                  </div>
                  <div class="col-3">
                    {{ this.$t("form.rider.last_name.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ rider.last_name }}</p>
                  </div>

                  <div class="col-3">{{ this.$t("form.rider.dob.label") }}</div>
                  <div class="col-3">
                    <p>{{ rider.dob_format }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.rider.phone.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ rider.phone }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.rider.address.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ rider.address }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.rider.zip_code.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ rider.zip_code }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.rider.country.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ rider.country.name }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.rider.state.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ rider.state.name }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.rider.city.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ rider.city.name }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.rider.email.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ rider.email }}</p>
                  </div>

                  <div class="col-3">
                    {{ this.$t("form.rider.gender.label") }}
                  </div>
                  <div class="col-3">
                    <p>{{ rider.gender }}</p>
                  </div>

                  <div class="col-3">
                    <label class="label form-label pe-4">
                      {{ this.$t("form.rider.status.label") }}
                    </label>
                  </div>
                  <div class="col-3">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        :checked="rider.is_active ? 'checked' : ''"
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
  layout: "vendor",
  middleware: ["vendor"],
  meta: {
    permission: "riders.index",
    strategy: "read",
  },
  data() {
    return {
      options: [
        { value: "", text: this.$t('select_your_positioning') },
        { value: "ltr", text: this.$t('select_ltr_positioning') },
        { value: "rtl", text: this.$t('select_rtl_positioning') },
      ],
      rider: "",
      error: false,
        url: '/backend',
    };
  },
  async fetch() {
    const { data } = await this.$sellerRepositories.riders.show(
      this.$route.params.id
    );
    this.rider = data;
  },
  methods: {},
  mounted() {},
};
</script>
