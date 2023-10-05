<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.newsletter.create_new_newsletter") }}
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
                  {{ this.$t("form.create") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.newsletter.form_description") }}
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
              class="btn btn-primary mb-3 px-3 py-2"
              @click="add"
              name="button"
            >
              {{ this.$t("form.add") }}
            </button>
            <!-- <button
              type="button" :disabled="disabled"
              class="btn btn-success mb-3"
              @click="addAndContinue"
              name="button"
            >
              {{ this.$t("form.add_and_continue") }}
            </button> -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script >
// import CkeditorNuxt from "@/components/global/ckeditorNuxt";
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "newsletters.create",
    strategy: "create",
  },
  fetch() {},
  data() {
    return {
      editorConfig: {
        // The configuration of the editor.
      },
      formData: {
        email: '',
        is_active: false,
        is_verified: false,
      },
      disabled:false,
      error: false,
    };
  },
  methods: {
    ...mapActions({
      addNewsletters: "Newsletters/addNewsletters",
      fetchActiveNewsletters: "General/fetchActiveNewsletters",
    }),

    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/newsletters"));
      }
    },
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
    async addAndContinue() {
         this.disabled=true
      await this.addNewsletters(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.email = '';
          this.formData.is_active = false;
          this.formData.is_verified = false;
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
