<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header"  >
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.vendor.view_vendor") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{ this.$t("sidebar.home") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/vendors')">{{ this.$t("sidebar.vendor") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.view") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.vendor.view_description") }}
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
       <AdminViewLoader :multilang='true' />
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                   <div class="row">
                <div class="col-sm-12">
                    <div class="show-table px-0">
                      <div class="row justify-content-end">
                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.vendor.name.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{vendor.name}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.vendor.email.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{vendor.email}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.vendor.store_name.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{vendor.store_details.name}}</p>
                        </div>


                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.vendor.store_address.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{vendor.store_details.address}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.vendor.store_city.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{vendor.store_details.city.name}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.vendor.store_phone.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{vendor.store_details.phone}}</p>
                        </div>


                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.vendor.contact_phone.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{vendor.contact_phone}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.vendor.postal_code.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{vendor.store_details.postal_code}}</p>
                        </div>

                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.vendor.store_headline.label") }}
                          </label>
                        </div>
                        <div class="col-3">
                          <p>{{vendor.store_details.headline}}</p>
                        </div>
                        <div class="col-3">
                          <label class="label form-label">
                            {{ this.$t("form.vendor.categories.label") }}
                          </label>
                        </div>
                        <div class="col-3" v-if="vendor.display_categories">
                            <div class="d-flex">
                            <p
                              v-for="category in vendor.display_categories"
                            >
                             {{category.name}}
                            </p>
                          </div>
                          <p></p>
                        </div>

                        <div class="col-3">
                          <label for="input-live " class="form-label">{{
                         this.$t("form.vendor.status.label")
                          }}</label>
                        </div>
                        <div class="col-3">
                           <div class="form-switch">
                            <input
                              class="form-check-input"
                              :checked="vendor.is_active ? 'checked' : ''"
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
                     <hr class="text-primary">
                <div class="row w-100">
                  <div class="col-lg-12">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">
                        {{ $t("form.multilanguage") }}
                      </h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("form.vendor.form_description") }}
                        </span>
                      </p>
                    </div>
                    <div class="d-md-flex">
                      <div class="row">
                        <div class="col-md-12 px-0">
                          <ul
                            class="nav nav-tabs px-0"
                            id="myTab"
                            role="tablist"
                          >
                            <li
                              class="nav-item"
                              role="presentation"
                              v-for="(
                                language, index
                              ) in allActiveLanguages.languages"
                            >
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
                        </div>
                      </div>
                      <div class="row w-100">
                        <div class="col-lg-12 px-0">

                              <div class="tab-content p-4" id="myTabContent">
                                <div
                                  class="tab-pane fade"
                                  :class="index == 0 ? 'active show' : ''"
                                  v-for="(
                                    language, index
                                  ) in allActiveLanguages.languages"
                                  :id="language.code"
                                  role="tabpanel"
                                  :aria-labelledby="language.code + '-tab'"
                                >
                                  <div class="row">
                                    <div class="col-md-12 my-1">
                                      <div role="group ">
                                        <div role="group">
                                          <label for="input-live form-label">{{
                                            $t(
                                              "form.vendor.description.label"
                                            )
                                          }}</label>
                                          <div
                                            class="py-3 px-3 shadow-sm rounded border mt-2 show-text-area"
                                            v-html="
                                              vendor
                                                .store_details.descriptionTranslations[
                                                language.code
                                              ]
                                            "
                                          ></div>
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
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

</template>
<script >

  import { mapGetters, mapActions } from 'vuex'
  export default {
    layout: 'admin',
    middleware: ['admin', 'permission','onlyMultiVendor'],
    meta: {
      permission: 'vendors.index',
      strategy: 'read'
    },
    data() {
      return {
        vendor: '',
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.vendors.show(this.$route.params.id)
      this.vendor = data
    },
    methods: {},
    mounted() {},
   computed:{
    ...mapGetters({
      allActiveLanguages: 'General/allActiveLanguages',
    })
  }
  }

</script>
