<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.language.create_new_language") }}
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
                <nuxt-link :to="localePath('/admin/languages')">{{
                  this.$t("sidebar.language")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.create") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.language.form_description") }}
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
         <AdminFormLoader/>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group ">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.language.name.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.name"
                      >
                        {{ error.name[0] }}
                      </span>
                      <input
                        class="form-control"
                        :class="error && error.name ? 'error' : ''"
                        v-model="formData.name"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="this.$t('form.language.name.placeholder')"
                        trim
                      />
                      <span class="heebo-light">
                        {{ this.$t("form.language.name.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.language.code.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.code"
                      >
                        {{ error.code[0] }}
                      </span>
                      <v-select
                        class=""
                        :placeholder="this.$t('form.language.code.placeholder')"
                        v-model="formData.code"
                        :reduce="(opt) => opt.code"
                        label="code"
                        :options="allActiveLanguageCodes.language_codes"
                      >
                        <template slot="no-options">
                          {{ $t("form.search_select.no_options") }}
                        </template>
                        <template slot="option" slot-scope="option">
                          <div class="d-center">
                            {{ option.code }}
                          </div>
                        </template>
                        <template slot="selected-option" slot-scope="option">
                          <div class="selected d-center">
                            {{ option.code }}
                          </div>
                        </template>
                      </v-select>
                      <span class="heebo-light">
                        {{ $t("form.language.code.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.language.direction.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.direction"
                      >
                        {{ error.direction[0] }}
                      </span>
                      <v-select
                        :placeholder="this.$t('form.language.direction.placeholder')"
                        v-model="formData.direction"
                        :reduce="(opt) => opt.value"
                        label="direction"
                        :options="options"
                      >
                        <template slot="no-options">
                          {{ $t("form.search_select.no_options") }}
                        </template>
                        <template slot="option" slot-scope="option">
                          <div class="d-center">
                            {{ option.value }}
                          </div>
                        </template>
                        <template slot="selected-option" slot-scope="option">
                          <div class="selected d-center">
                            {{ option.value }}
                          </div>
                        </template>
                      </v-select>
                      <span class="heebo-light">
                        {{ $t("form.language.direction.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div
                    class="col-md-6 my-1 d-flex justify-content-center flex-column pe-md-0"
                  >
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.language.status.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.is_active"
                          :checked="formData.is_active ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>

                    <span class="heebo-light">
                      {{ $t("form.language.status.subheading") }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 px-4 text-md-end">
                <button :disabled="disabled"
                  type="button"
                  class="btn btn-primary mb-3 px-3 py-2"
                  @click="add"
                  name="button"
                >
                  {{ this.$t("form.add") }}
                </button>
                <!-- <button :disabled="disabled"
                  type="button"
                  class="btn btn-success mb-3"
                  @click="addAndContinue"
                  name="button"
                >
                  {{ this.$t("form.add_and_continue") }}
                </button> -->
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
    permission: "languages.create",
    strategy: "create",
  },
  async asyncData({ params }) {},
  async fetch() {
    if (!this.allActiveLanguageCodes.language_codes) {
      await this.fetchActiveLanguageCodes();
    }
  },
  data() {
    return {
      options: [
        { value: "ltr", text: "Select ltr Positioning" },
        { value: "rtl", text: "Select rtl Positioning" },
      ],
      formData: {
        name: "",
        code: "",
        direction: "",
        is_default: false,
        is_active: false,
        image_id: 1,
      },
      disabled:false,
      error: false,
    };
  },
  methods: {
    ...mapActions({
      addLanguages: "Languages/addLanguages",
      fetchActiveLanguages: "General/fetchActiveLanguages",
      fetchActiveLanguageCodes: "General/fetchActiveLanguageCodes",
    }),
    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/languages"));
      }
    },
    async addAndContinue() {
        this.disabled=true
      await this.addLanguages(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.name = "";
          this.formData.code = "";
          this.formData.direction = "";
          this.formData.is_default = false;
          this.formData.is_active = false;
          this.$toast.success(res.message);
          this.fetchActiveLanguages();
        }
      });
      this.disabled=false
    },
  },
  computed: {
    ...mapGetters({
      allLanguages: "Languages/allLanguages",
      allActiveLanguageCodes: "General/allActiveLanguageCodes",
    }),
  },
  mounted() {},
};
</script>
