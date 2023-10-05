<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header ">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.newsletter.edit_newsletter") }}
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
                  <nuxt-link :to="localePath('/admin/newsletters')">{{
                    this.$t("sidebar.newsletter")
                  }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.newsletter.edit_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- Main content -->
    <section class="content pb-5">
      <div  v-if="$fetchState.pending">
      <AdminFormLoader :multilang='true'/>
      </div>

      <div class="container" v-else>
        <div class="col-lg-12">
          <div class="card gutter-b border-0">
            <div class="card-body">
                <div class="row">
                 <div class="col-md-6 my-1 ps-md-0" >
                    <div role="group ">
                      <label for="input-live" class="  form-label">{{ $t("form.newsletter.email.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['email']">
                          {{ error.email[0] }}
                        </span>
                      <input class="form-control"
                             :class="error && error.email ? 'error' : ''"
                             v-model="formData.email"
                             aria-describedby="input-live-help input-live-feedback"
                             :placeholder="$t('form.newsletter.email.placeholder')"
                             trim
                             type="email" />
                      <span class="  heebo-light">
                          {{ $t("form.newsletter.email.subheading") }}
                        </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.newsletter.status.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.is_active"
                          :checked="formData.is_active ? 'checked' : ''"
                          type="checkbox"
                          @change="checkStatus"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>

                    <span class="heebo-light">
                      {{ $t("form.newsletter.status.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.newsletter.is_verified.label") }}
                      </label>

                      <div class="form-switch d-flex align-items-center">
                        <input
                          class="form-check-input"
                          v-model="formData.is_verified"
                          :checked="formData.is_verified ? 'checked' : ''"
                          type="checkbox"
                          @change="checkDefault"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.newsletter.is_verified.subheading") }}
                    </span>
                  </div>
                </div>

 <!-- <hr class="text-primary"> -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 px-4 text-center text-md-end">
            <button
              type="button" :disabled="disabled"
              class="btn btn-secondary mb-3 px-3 py-2"
              @click="update"
              name="button"
            >
              {{ this.$t("form.update") }}
            </button>
            <!-- <button
              type="button" :disabled="disabled"
              class="btn btn-success mb-3"
              @click="updateAndContinue"
              name="button"
            >
              {{ this.$t("form.update_and_continue") }}
            </button> -->
          </div>
        </div>
      </div>
    </section>

    <!-- /.content -->

    <!-- /.content -->
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";

export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "newsletters.update",
    strategy: "update",
  },
  data() {
    return {
      formData: {
        email: '',
        is_active: false,
        is_verified: false,
      },
       disabled:false,
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.newsletter.show(
      this.$route.params.id
    );
    // get and update data
    this.formData.email = data.email;
    this.formData.is_active = data.is_active;
    this.formData.is_verified = data.is_verified;
  },
  methods: {
    ...mapActions({
      updateNewsletters: "Newsletters/updateNewsletters",
      fetchActiveNewsletters: "General/fetchActiveNewsletters",
    }),
    checkDefault() {
      if (this.formData.is_verified == 1) {
        this.formData.is_active = 1;
      }
    },
    checkStatus() {
      if (this.formData.is_active == 0) {
        this.formData.is_verified = 0;
      }
    },
    async update() {
      await this.updateAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/newsletters"));
      }
    },
    async updateAndContinue() {
          this.disabled=true
      await this.updateNewsletters({
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
          this.fetchActiveNewsletters();
        }
      });
        this.disabled=false
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
