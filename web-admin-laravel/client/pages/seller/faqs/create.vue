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
              {{ this.$t("form.faq.create_new_faq") }}
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
                  <nuxt-link :to="localePath('/admin/faqs')">{{
                    this.$t("sidebar.faq")
                  }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.create") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.faq.form_description") }}
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
       <AdminFormLoader :multilang='true'/>
      </div>
      <div class="container" v-else>
        <div class="col-lg-12">
          <div class="card gutter-b border-0">
            <div class="card-body p-4">
              <div class="row">
                 <div class="col-md-6 my-1" >
                    <div role="group ">
                      <label for="input-live" class="  form-label">{{ $t("form.review.product.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['product_id']">
                          {{ error.product_id[0] }}
                        </span>
                        <AdminSearchSelectable :class="error && error.product_id ? 'error' : ''" apiMethod="activeProducts" responseKey="products"
                          :initialOptions="allActiveProducts.products" :placeholder="$t('form.review.product.placeholder')" v-model="formData.product_id" />
                      <span class="  heebo-light">
                          {{ $t("form.review.product.subheading") }}
                        </span>
                    </div>
                  </div>
                                  <div class="col-md-6 my-1 px-4 d-flex justify-content-center flex-column">
                  <div class="d-flex align-items-center">
                    <label class="label form-label me-4 text-capitalize">
                      {{ this.$t("form.faq.status.label") }}
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
                    {{ $t("form.faq.status.subheading") }}
                  </span>
                </div>
              </div>

               <hr class="text-primary">
              <div class="row">
                <div class="col-lg-12 py-2">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">{{ $t("form.multilanguage") }}</h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.faq.form_description") }}
                        </span>
                      </p>
                      <div class="row">
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
                            <div class="tab-pane fade" :class="index == 0 ? 'active show' : ''" :key="language.code"
                              v-for="(language, index ) in allActiveLanguages.languages" :id="language.code" role="tabpanel" :aria-labelledby="language.code + '-tab'">
                              <div class="row">
                                <div class="col-md-6 my-1">
                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t("form.faq.question.label")
                                      }}:</label
                                    >
                                    <span
                                      class="float-end text-danger"
                                      v-if="
                                        error && error['question.' + language.code]
                                      "
                                    >
                                      {{ error["question." + language.code][0] }}
                                    </span>
                                    <input
                                      class="form-control"
                                      :class="
                                        error && error['question.' + language.code]
                                          ? 'error'
                                          : ''
                                      "
                                      v-model="formData.question[language.code]"
                                      aria-describedby="input-live-help input-live-feedback"
                                      :placeholder="
                                        $t('form.faq.question.placeholder')
                                      "
                                      trim
                                    />
                                    <span class="heebo-light">
                                      {{
                                        $t("form.faq.question.subheading")
                                      }}
                                    </span>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 my-1">

                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t("form.faq.answer.label")
                                      }}:</label
                                    >
                                    <span
                                      class="float-end text-danger"
                                      v-if="
                                        error && error['answer.' + language.code]
                                      "
                                    >
                                      {{ error["answer." + language.code][0] }}
                                    </span>
                                    <input
                                      class="form-control"
                                      :class="
                                        error && error['answer.' + language.code]
                                          ? 'error'
                                          : ''
                                      "
                                      v-model="formData.answer[language.code]"
                                      aria-describedby="input-live-help input-live-feedback"
                                      :placeholder="
                                        $t('form.faq.answer.placeholder')
                                      "
                                      trim
                                    />
                                    <span class="heebo-light">
                                      {{
                                        $t("form.faq.answer.subheading")
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
        <div class="row">
          <div class="col-md-12 px-4 text-center text-md-end">
            <button
              type="button"
              class="btn btn-primary mb-3 px-3 py-2"
              @click="add"
              name="button"
            >
              {{ this.$t("form.add") }}
            </button>
            <button
              type="button"
              class="btn btn-success mb-3 px-3 py-2"
              @click="addAndContinue"
              name="button"
            >
              {{ this.$t("form.add_and_continue") }}
            </button>
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
    permission: "faqs.create",
    strategy: "create",
  },
  async fetch() {
    if(!this.allActiveProducts.products){
     await this.fetchActiveProducts();
      }
  },
  data() {
    return {
      editorConfig: {
        // The configuration of the editor.
      },
      url: "/backend",
      formData: {
        question: {},
        answer: {},
        product_id:'',
        is_active: false,
      },
      error: false,
    };
  },
  methods: {
    ...mapActions({
      addFaqs: "Faqs/addFaqs",
      fetchActiveFaqs: "General/fetchActiveFaqs",
     fetchActiveProducts: 'General/fetchActiveProducts',
    }),
    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/faqs"));
      }
    },
    async addAndContinue() {
      await this.addFaqs(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.question = {};
          this.formData.answer = {};
          this.formData.product_id = ''
          this.formData.is_active = false;
          this.$toast.success(res.message);
          this.fetchActiveFaqs();
        }
      });
    },
  },

  mounted() {},
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
        allActiveProducts: 'General/allActiveProducts',
    }),
  },
};
</script>
