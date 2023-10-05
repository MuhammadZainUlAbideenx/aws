<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row mb-2 g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.review.view_review") }}
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
                <nuxt-link :to="localePath('/admin/reviews')">{{
                  this.$t("sidebar.review")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.view") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.review.view_review") }}
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
                  <div class="show-table mb-3">
                    <div class="row justify-content-end">
                      <div class="col-3" v-if="review.customer">
                        <label for="input-live form-label">{{
                          this.$t("form.review.customer.label")
                        }}</label>
                      </div>
                      <div class="col-3" v-if="review.customer">
                        <p>{{ review.customer.name }}</p>
                      </div>

                      <div class="col-3" v-if="review.product">
                        <label for="input-live form-label">{{
                          this.$t("form.review.product.label")
                        }}</label>
                      </div>
                      <div class="col-3" v-if="review.product">
                        <p>{{ review.product.name }}</p>
                      </div>

                      <div class="col-3">
                        <label for="input-live form-label">{{
                          this.$t("form.review.description.label")
                        }}</label>
                      </div>
                      <div class="col-3">
                        <p>{{ review.description }}</p>
                      </div>

                      <div class="col-3">
                        <label for="input-live form-label">{{
                          this.$t("form.review.review_name.label")
                        }}</label>
                      </div>
                      <div class="col-3">
                        <p>{{ review.review.name }}</p>
                      </div>

                      <div class="col-3">
                        <label for="input-live form-label">{{
                          this.$t("form.review.rating.label")
                        }}</label>
                      </div>
                      <div class="col-3">
                        <p>{{ review.rating }}</p>
                      </div>

                      <div class="col-3">
                        <label class="label form-label pe-4">
                          {{ this.$t("form.review.status.label") }}
                        </label>
                      </div>
                      <div class="col-3">
                        <div class="form-switch">
                          <input
                            class="form-check-input"
                            :checked="review.is_active ? 'checked' : ''"
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
    permission: "reviews.index",
    strategy: "read",
  },
  data() {
    return {
      review: "",
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.reviews.show(
      this.$route.params.id
    );
    this.review = data;
  },
  methods: {},
  mounted() {},
};
</script>
