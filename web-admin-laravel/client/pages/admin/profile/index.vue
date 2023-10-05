<template >
  <!-- Main content -->
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.admin.profile.edit") }}
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
                <nuxt-link :to="localePath('/admin/profile')">{{
                  this.$t("sidebar.admin")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.edit") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.admin.edit_description") }}
            </p>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <div v-if="$fetchState.pending">
      <AdminFormLoader :multilang="true" />
    </div>
    <div class="container" v-else>
      <div class="row">
        <div class="col-lg-12">
          <div class="card gutter-b border-0">
            <div class="card-body p-4">
              <!-- <h3 class="">{{ $t("form.admin.personal_details.heading") }}</h3> -->
              <!-- <hr /> -->
              <div class="row">
                <div class="row">
                  <div class="col-md-6 my-1">
                    <div role="group ">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.admin.first_name.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.first_name"
                      >
                        {{ error.first_name[0] }}
                      </span>
                      <input
                        class="form-control"
                        :class="error && error.first_name ? 'error' : ''"
                        v-model="formData.first_name"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.admin.first_name.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ this.$t("form.admin.first_name.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group ">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.admin.last_name.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.last_name"
                      >
                        {{ error.last_name[0] }}
                      </span>
                      <input
                        class="form-control"
                        :class="error && error.last_name ? 'error' : ''"
                        v-model="formData.last_name"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.admin.last_name.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ this.$t("form.admin.last_name.subheading") }}
                      </span>
                    </div>
                  </div>
                     <div class="col-md-6 my-1">
                      <div role="group">
                        <label for="input-live" class="form-label"
                          >{{ this.$t("form.admin.email.label") }}:</label
                        >
                        <span
                          class="float-end text-danger"
                          v-if="error && error.email"
                        >
                          {{ error.email[0] }}
                        </span>
                        <input
                          :class="error && error.email ? 'error' : ''"
                          class="form-control"
                          v-model="formData.email"
                          aria-describedby="input-live-help input-live-feedback"
                          :placeholder="
                            this.$t('form.admin.email.placeholder')
                          "
                          trim
                        />
                        <span class="heebo-light">
                          {{ $t("form.admin.email.subheading") }}
                        </span>
                      </div>
                    </div>
                  <div class="col-md-6 my-1">
                    <div role="group ">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.admin.phone.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.phone"
                      >
                        {{ error.phone[0] }}
                      </span>
                      <input
                        type="number"
                        class="form-control"
                        :class="error && error.phone ? 'error' : ''"
                        v-model="formData.phone"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="this.$t('form.admin.phone.placeholder')"
                        trim
                      />
                      <span class="heebo-light">
                        {{ this.$t("form.admin.phone.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1">
                    <div role="group">
                      <label class="label form-label">
                        {{ this.$t("form.admin.dob.label") }}
                      </label>
                      <span
                        class="float-end text-danger"
                        v-if="error && error.dob"
                      >
                        {{ error.dob[0] }}
                      </span>
                      <datetime
                        :min-datetime="now.min_date"
                        :max-datetime="now.max_date"
                        :placeholder="this.$t('form.admin.dob.placeholder')"
                        input-class="form-control"
                        type="date"
                        v-model="formData.dob"
                        value-zone="local"
                      ></datetime>
                      <span class="heebo-light">
                        {{ $t("form.admin.dob.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1">
                    <label class="label form-label">
                      {{ this.$t("form.admin.profile.image.label") }}
                    </label>
                    <span
                      class="float-end text-danger"
                      v-if="error && error.profile_image_path"
                    >
                      {{ error.profile_image_path[0] }}
                    </span>
                    <div class="">
                      <img
                        height="60"
                        width="60"
                        class="dropzone-previews d-none"
                        :placeholder="
                          this.$t('web.customer.profile_image.placeholder')
                        "
                        alt="profile_image"
                      />
                      <dropzone
                        id="drop1"
                        :options="profile_update"
                        @vdropzone-complete="afterComplete"
                      ></dropzone>
                    </div>
                    <span class="px-2 heebo-light">
                      {{ $t("form.admin.profile.image.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 mb-3 px-4">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.admin.is_credentials.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.is_pass"
                          :checked="formData.is_pass ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.admin.is_credentials.subheading") }}
                    </span>
                  </div>
                  <div class="row" v-if="formData.is_pass">
                    <div class="col-md-6 my-1">
                      <div role="group">
                        <label for="input-live" class="form-label"
                          >{{ this.$t("form.admin.password.label") }}:</label
                        >
                        <span
                          class="float-end text-danger"
                          v-if="error && error.password"
                        >
                          {{ error.password[0] }}
                        </span>
                        <input
                          :class="error && error.password ? 'error' : ''"
                          class="form-control"
                          v-model="formData.password"
                          type="password"
                          aria-describedby="input-live-help input-live-feedback"
                          :placeholder="
                            this.$t('form.admin.password.placeholder')
                          "
                          trim
                        />
                        <span class="heebo-light">
                          {{ $t("form.admin.password.subheading") }}
                        </span>
                      </div>
                    </div>
                    <div class="col-md-6 my-1">
                      <div role="group">
                        <label for="input-live" class="form-label"
                          >{{
                            this.$t("form.admin.password_confirmation.label")
                          }}:</label
                        >
                        <span
                          class="float-end text-danger"
                          v-if="error && error.password_confirmation"
                        >
                          {{ error.confirm_password[0] }}
                        </span>
                        <input
                          :class="
                            error && error.password_confirmation ? 'error' : ''
                          "
                          class="form-control"
                          v-model="formData.password_confirmation"
                          type="password"
                          aria-describedby="input-live-help input-live-feedback"
                          :placeholder="
                            this.$t(
                              'form.admin.password_confirmation.placeholder'
                            )
                          "
                          trim
                        />
                        <span class="heebo-light">
                          {{
                            $t("form.admin.password_confirmation.subheading")
                          }}
                        </span>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-md-12 px-4 text-center text-md-end">
                  <button
                    type="button"
                    :disabled="disabled"
                    class="btn btn-secondary mb-3 px-3 py-2"
                    @click="update"
                    name="button"
                  >
                    {{ this.$t("form.update") }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content -->

  <!-- /.content -->
</template>
  <script >
  import Dropzone from "nuxt-dropzone";
  import "nuxt-dropzone/dropzone.css";
  import { mapGetters, mapActions } from "vuex";
  export default {
    layout: "admin",
    middleware: "admin",
    data() {
      return {
        min_date:'',
        max_date:'',
        url: '/backend',
        profile_image_path:'',
        profile_update: {
          headers: "",
          url: "/backend/api/admin/updateProfileImage",
          dictDefaultMessage:
          "Drop Profile Image here",
            uploadMultiple:false,
            parallelUploads:1,
            previewsContainer:'.dropzone-previews'
        },
        formData: {
          dob:"",
          first_name: "",
          last_name: "",
          password_confirmation:"",
          password: "",
          phone:'',
          is_pass:false,
        },
        disabled:false,
        error: false,
      };
    },
    async fetch() {
      this.profile_update.headers = this.$axios.defaults.headers.common;
      const { data } = await this.$generalService.getAdminProfile();
      // get and update data
      this.formData.first_name = data.first_name;
      this.formData.last_name = data.last_name;
    //  this.formData.email = data.email;
    this.formData.phone = data.phone;
    this.formData.dob = data.dob;
  },
  components: {
    Dropzone,
  },
  methods: {
    ...mapActions({}),
    async afterComplete(file) {
      setTimeout(
        function () {
          this.removeFile(file);
        }.bind(this),
        3000
      );
      if (file.status == "error") {
        var res = JSON.parse(file.xhr.response);
        this.$toast.error(res.message);
        if (res.errors) {
          for (const [key, value] of Object.entries(res.errors)) {
            this.$toast.error(value);
          }
        }
      } else {
        var res = JSON.parse(file.xhr.response);
        this.profile_image_path = res.profile_image_path;
        this.fetchU();
        this.$toast.success(res.message);
      }
    },
    removeFile: function (file) {
      file.previewElement.remove();
    },
    async fetchU() {
      await this.$auth.fetchUser();
    },
    async update() {
      this.disabled = true;
      await this.$generalService
        .updateAdminProfile(this.formData)
        .then((res) => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data;
            this.$toast.error(res.response.data.message);
          } else if (res.state == "fail") {
            this.$toast.error(res.message);
          } else {
            this.error = false;
            this.$toast.success(res.message);
            this.$router.replace(this.localePath("/admin/dashboard"));
            this.fetchU();
          }
        })
        .catch((error) => {
          this.error = true;
          this.error = error.response.data.errors;
        });
      this.disabled = false;
    },
  },
  computed: {
    ...mapGetters({}),
    now: function () {
      var max_date = new Date();
      var min_date = new Date();
      min_date.setYear(min_date.getFullYear() - 100);
      max_date.setYear(max_date.getFullYear() - 2);
      var max_date = new Date(max_date).toISOString();
      var min_date = new Date(min_date).toISOString();
      return {
        min_date: min_date,
        max_date: max_date,
      };
    },
  },
  watch: {},
  mounted() {},
};
</script>
