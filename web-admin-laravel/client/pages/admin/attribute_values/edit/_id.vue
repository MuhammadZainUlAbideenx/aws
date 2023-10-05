<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.attribute_value.edit_attribute") }}
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
                  <nuxt-link :to="localePath('/admin/attribute_values')">{{
                    this.$t("sidebar.attribute_value")
                  }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.edit") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.attribute_value.edit_description") }}
              </p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- Main content -->
    <section class="content pb-5">
      <div class="container" v-if="$fetchState.pending">
        <div class="row">
          <div class="col-md-12">
            <AdminLoader />
          </div>
        </div>
      </div>
      <div class="container" v-else>
        <div class="row ">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body p-4">
                <div class="row">
                                  <div class="col-md-6 px-4">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.attribute_value.attribute.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.attribute_id"
                      >
                        {{ error.attribute_id[0] }}
                      </span>
                      <AdminSearchSelectable
                        :class="error && error.attribute_id ? 'error' : ''"
                        apiMethod="activeAttributes"
                        responseKey="attributes"
                        :initialOptions="allActiveAttributes.attributes"
                        :placeholder="
                          this.$t('form.attribute_value.attribute.placeholder')
                        "
                        :selectedOptions="selected_attribute"
                        v-model="formData.attribute_id"
                      />
                      <span class="heebo-light">
                        {{ $t("form.attribute_value.attribute.subheading") }}
                      </span>
                    </div>
                  </div>
<div
                  class="col-md-6 my-1 d-flex justify-content-center flex-column"
                >
                  <div class="d-flex align-items-center">
                    <label class="label form-label me-4 text-capitalize">
                      {{ this.$t("form.attribute_value.status.label") }}
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
                    {{ $t("form.attribute_value.status.subheading") }}
                  </span>
                </div>
                </div>

 <hr class="text-primary">
              <div class="row">
                <div class="col-lg-12">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">{{$t('form.multilanguage')}}</h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.manufacturer.website_url.subheading") }}
                        </span>
                      </p>
                      <div class="row mb-2">
                        <div class="col-lg-12 px-0 d-md-flex">
                          <ul
                            class="nav nav-tabs d-inline-block"
                            id="myTab"
                            role="tablist "
                          >
                            <li class="nav-item" role="presentation"
                              v-for="(language, index) in allActiveLanguages.languages" :key="index">
                              <a
                                class="nav-link"
                                :class="index == 0 ? 'active' : ''"
                                :id="language.code + '-tab'"
                                data-bs-toggle="tab"
                                :href="'#' + language.code"
                                role="tab"
                                :aria-controls="language.code"
                                :aria-selected="index == 0 ? 'true' : 'false'"
                                >{{ language.name }}</a
                              >
                            </li>
                          </ul>

                          <div class="tab-content p-4" id="myTabContent">
                            <div class="tab-pane fade" :class="index == 0 ? 'active show' : ''"
                              v-for="(language, index ) in allActiveLanguages.languages" :key="language.code" :id="language.code" role="tabpanel" :aria-labelledby="language.code + '-tab'">
                              <div class="row">
                                <div class="col-md-6 my-1">
                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t("form.attribute_value.name.label")
                                      }}:</label
                                    >
                                    <span
                                      class="float-end text-danger"
                                      v-if="
                                        error && error['name.' + language.code]
                                      "
                                    >
                                      {{ error["name." + language.code][0] }}
                                    </span>
                                    <input
                                      class="form-control"
                                      :class="
                                        error && error['name.' + language.code]
                                          ? 'error'
                                          : ''
                                      "
                                      v-model="formData.name[language.code]"
                                      aria-describedby="input-live-help input-live-feedback"
                                      :placeholder="
                                        $t('form.attribute_value.name.placeholder')
                                      "
                                      trim
                                    />
                                    <span class="heebo-light">
                                      {{
                                        $t("form.attribute_value.name.subheading")
                                      }}
                                    </span>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 my-1">
                                  <div role="group ">
                                    <label
                                      for="input-live"
                                      class="px-2 form-label"
                                      >{{
                                        $t(
                                          "form.attribute_value.description.label"
                                        )
                                      }}:</label
                                    >
                                    <span
                                      class="float-end text-danger"
                                      v-if="
                                        error &&
                                        error['description.' + language.code]
                                      "
                                    >
                                      {{
                                        error["description." + language.code][0]
                                      }}
                                    </span>
                                    <GlobalCkeditorNuxt
                                      v-model="
                                        formData.description[language.code]
                                      "
                                    />
                                    <span class="px-2 heebo-light">
                                      {{
                                        $t(
                                          "form.attribute_value.description.subheading"
                                        )
                                      }}
                                    </span>
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
                 </div>
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
            <button
              type="button" :disabled="disabled"
              class="btn btn-success mb-3 px-3 py-2"
              @click="updateAndContinue"
              name="button"
            >
              {{ this.$t("form.update_and_continue") }}
            </button>
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
    permission: "attribute_values.update",
    strategy: "update",
  },
  data() {

    return {
        selected_attribute:'',
      formData: {
        name: {},
        attribute_id:'',
        description: {},
        is_active: false,
      },
    disabled:false,
      error: false,
    };
  },
  async fetch() {
      if (!this.allActiveAttributes.attributes) {
      await this.fetchActiveAttributes();
    }
    const { data } = await this.$repositories.attribute_values.show(this.$route.params.id);
    // get and update data
    this.formData.name = data.nameTranslations;
    this.formData.description = data.descriptionTranslations;
    this.formData.is_active = data.is_active;
     if(data.attribute){
        this.formData.attribute_id = data.attribute.id
        this.selected_attribute = data.attribute
      }
  },
  methods: {
    ...mapActions({
      updateAttributeValues: "AttributeValues/updateAttributeValues",
       fetchActiveAttributes: "General/fetchActiveAttributes",
      fetchActiveAttributeValues: "General/fetchActiveAttributeValues",
    }),

    async update() {
      await this.updateAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/attribute_values"));
      }
    },
    async updateAndContinue() {
         this.disabled=true
      await this.updateAttributeValues({
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
          this.fetchActiveAttributeValues();
        }
      });
       this.disabled=false
    },
  },
  mounted() {},
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
      allActiveAttributes: "General/allActiveAttributes",
    }),
  },
};
</script>
