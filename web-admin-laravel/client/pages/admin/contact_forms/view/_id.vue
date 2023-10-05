<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("contact_form.view_contact_form") }}
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
                <nuxt-link :to="localePath('/admin/contact_forms')">{{
                  this.$t("sidebar.contact_form")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.view") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("contact_form.view_description") }}
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
                  <div class="col-md-12 px-0">
                    <div class="show-table mb-3">
                      <div class="row justify-content-end">
                         <div class="col-6">
                          <label for="input-live form-label">{{
                            this.$t("form.contact_form.name.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p>{{ contact_form.name }}</p>
                        </div>
                        <div class="col-6">
                          <label for="input-live form-label">{{
                            this.$t("form.contact_form.email.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p>{{ contact_form.email }}</p>
                        </div>
                         <div class="col-6">
                          <label for="input-live form-label">{{
                            this.$t("form.contact_form.subject.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p>{{ contact_form.subject }}</p>
                        </div>
                        <div class="col-6">
                          <label for="input-live form-label">{{
                            this.$t("form.contact_form.message.label")
                          }}</label>
                        </div>
                        <div class="col-6">
                          <p>{{ contact_form.message }}</p>
                        </div>
                    </div>
                  </div>
                </div>
                </div>
                 <!-- <hr class="text-primary"> -->
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
    permission: "contact_forms.index",
    strategy: "read",
  },
  data() {
    return {
      contact_form: "",
      error: false,
    };
  },
  async fetch() {
    const { data } = await this.$repositories.contact_forms.show(
      this.$route.params.id
    );
    this.contact_form = data;
  },
  methods: {},
  mounted() {},
  computed: {
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
    }),
  },
};
</script>
