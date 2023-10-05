<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.seo_page.view_seo_page") }}
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
                  <nuxt-link :to="localePath('/admin/seo_pages')">{{ this.$t("sidebar.seo_page") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.view") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.seo_page.view_description") }}
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
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                       <div class="show-table px-0 mb-3">
                <div class="row justify-content-end">
                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.seo_page.title.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ seo_page.seo.title }}</p></div>

                    <div class="col-3"  v-if=" seo_page.seo.category">
                      <label for="input-live form-label">{{
                        this.$t("form.seo_page.category.label")
                      }}</label>
                  </div>
                  <div class="col-3 " v-if=" seo_page.seo.category"><p>{{ seo_page.seo.category }}</p></div>

                  <div class="col-3" v-if=" seo_page.seo.product">
                      <label for="input-live form-label">{{
                        this.$t("form.seo_page.product.label")
                      }}</label>
                  </div>
                  <div class="col-3" v-if=" seo_page.seo.product"><p>{{ seo_page.seo.product.name }}</p></div>


                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.seo_page.content_page.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ seo_page.seo.content_page }}</p></div>

                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.seo_page.keywords.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ seo_page.seo.keywords }}</p></div>

                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.seo_page.description.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ seo_page.seo.description }}</p></div>

                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.seo_page.meta_tags.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ seo_page.seo.meta_tags.name }}</p></div>

                  <div class="col-3">
                      <label for="input-live form-label">{{
                        this.$t("form.seo_page.seo_type.label")
                      }}</label>
                  </div>
                  <div class="col-3"><p>{{ seo_page.seo.seo_type}}</p></div>
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
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'seo_pages.index',
      strategy: 'read'
    },
    data() {
      return {
        options: [
          { value: '', text: 'Select your Positioning' },
          { value: 'ltr', text: 'Select ltr Positioning' },
          { value: 'rtl', text: 'Select rtl Positioning' }
        ],
        seo_page: '',
        error: false
      }
    },
    async fetch() {
      const { data } = await this.$repositories.seo_pages.show(this.$route.params.id)
      this.seo_page = data
    },
    methods: {},
    mounted() {}
  }

</script>
