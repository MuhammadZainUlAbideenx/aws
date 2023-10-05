<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("sidebar.theme_settings") }}
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
              <li class="breadcrumb-item active">
                {{ this.$t("sidebar.theme_settings") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.theme_settings.form_description") }}
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
        <AdminFormLoader />
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">

            <div class="card gutter-b border-0 p-0 pt-3">
              <div class="card-body p-3">
                 <div class="row ">
                  <h2 class="text-center">{{$t('form.theme_settings.label')}}: </h2>
             </div>
              <div
                    class="col-md-6 my-1">
                   <div
                      role="group"
                    >
                      <label for="input-live" class="form-label">{{
                        $t("currently_active_theme")
                      }}</label>
                      <span
                        class="float-end text-danger"
                        v-if="error && error[index]"
                      >
                        {{ error[index][0] }}
                      </span>
                      <select
                        :class="error && error[index] ? 'error' : ''"
                        class="form-select"
                       v-model="formData.currently_active_theme"
                      >
                        <option value="Template1">{{
                        $t("form.theme_settings.template1")
                      }}</option>
                        <option value="Template2">{{
                        $t("form.theme_settings.template2")
                      }}</option>

                      </select>
                      <span class="heebo-light">
                    {{
                        $t("currently_active_theme")
                      }}
                      </span>
                    </div>
              </div>
                <div class="row">
                  <h2>{{
                        $t("form.theme_settings.header")
                      }} </h2>
                   <div
                    class="col-md-6 my-1">
                  <div role="group">
                    <label for="input-live" class="form-label"> {{
                        $t("form.theme_settings.for_web")
                      }} </label>
                    <span
                      class="float-end text-danger"
                      v-if="error && error[index]"
                    >
                      {{ error[index][0] }}
                    </span>
                    <select
                      :class="error && error[index] ? 'error' : ''"
                      class="form-select"
                      v-model="formData.header_layout_web"
                      @change="getHeaderWebImageUrl()"
                    >
                      <option value="Layout1">{{
                        $t("form.theme_settings.layout1")
                      }} </option>
                      <option value="Layout2">{{
                        $t("form.theme_settings.layout2")
                      }}</option>
                      <option value="Layout3">{{
                        $t("form.theme_settings.layout3")
                      }}</option>
                      <option value="Layout4">{{
                        $t("form.theme_settings.layout4")
                      }}</option>
                      <option value="Layout5">{{
                        $t("form.theme_settings.layout5")
                      }}</option>
                      <option value="Layout6">{{
                        $t("form.theme_settings.layout6")
                      }}</option>
                        <option value="Layout7">{{
                        $t("form.theme_settings.layout7")
                      }}</option>
                        <option value="Layout8">{{
                        $t("form.theme_settings.layout8")
                      }}</option>
                        <option value="Layout9">{{
                        $t("form.theme_settings.layout9")
                      }}</option>
                        <option value="Layout10">{{
                        $t("form.theme_settings.layout10")
                      }}</option>
                    </select>
                    <span class="heebo-light">
                   {{
                        $t("form.theme_settings.for_web")
                      }}
                    </span>
                  </div>
                  <div >
                     <img :src="header_layout_web_image_url" alt="" width="100%" height="50" class="rounded" style="border: 1px solid black;">
                  </div>
                  </div>
                   <div
                    class="col-md-6 my-1">
                   <div role="group">
                    <label for="input-live" class="form-label">  {{
                        $t("form.theme_settings.for_mobile")
                      }} </label>
                    <span
                      class="float-end text-danger"
                      v-if="error && error[index]"
                    >
                      {{ error[index][0] }}
                    </span>
                    <select
                      :class="error && error[index] ? 'error' : ''"
                      class="form-select"
                      v-model="formData.header_layout_mobile"
                        @change="getHeaderMobileImageUrl()"
                    >
                   <option value="Layout1">{{
                        $t("form.theme_settings.layout1")
                      }} </option>
                      <option value="Layout2">{{
                        $t("form.theme_settings.layout2")
                      }}</option>
                      <option value="Layout3">{{
                        $t("form.theme_settings.layout3")
                      }}</option>
                      <option value="Layout4">{{
                        $t("form.theme_settings.layout4")
                      }}</option>
                      <option value="Layout5">{{
                        $t("form.theme_settings.layout5")
                      }}</option>
                      <option value="Layout6">{{
                        $t("form.theme_settings.layout6")
                      }}</option>
                       <option value="Layout7">{{
                        $t("form.theme_settings.layout7")
                      }}</option>
                       <option value="Layout8">{{
                        $t("form.theme_settings.layout8")
                      }}</option>
                       <!-- <option value="Layout9">{{
                        $t("form.theme_settings.layout9")
                      }}</option>
                       <option value="Layout10">{{
                        $t("form.theme_settings.layout10")
                      }}</option> -->
                    </select>
                    <span class="heebo-light">
                    {{
                        $t("form.theme_settings.for_mobile")
                      }}
                    </span>
                  </div>
                   <div>
                     <img :src="header_layout_mobile_image_url" alt="" width="100%" class="rounded" style="border: 1px solid black;">
                  </div>
                  </div>
                </div>
              </div>
              <div class="card-body p-3">
                <div class="row">
                  <h2>{{
                        $t("form.theme_settings.footer")
                      }} </h2>
                   <div
                    class="col-md-6 my-1">
                  <div role="group">
                    <label for="input-live" class="form-label"> {{
                        $t("form.theme_settings.for_web")
                      }} </label>
                    <span
                      class="float-end text-danger"
                      v-if="error && error[index]"
                    >
                      {{ error[index][0] }}
                    </span>
                    <select
                      :class="error && error[index] ? 'error' : ''"
                      class="form-select"
                      v-model="formData.footer_layout_web"
                       @change="getFotterWebImageUrl()"
                    >
                    <option value="Layout1">{{
                        $t("form.theme_settings.layout1")
                      }} </option>
                      <option value="Layout2">{{
                        $t("form.theme_settings.layout2")
                      }}</option>
                      <option value="Layout3">{{
                        $t("form.theme_settings.layout3")
                      }}</option>
                      <option value="Layout4">{{
                        $t("form.theme_settings.layout4")
                      }}</option>
                    <option value="Layout5">{{
                        $t("form.theme_settings.layout5")
                      }}</option>
                        <option value="Layout6">{{
                        $t("form.theme_settings.layout6")
                      }}</option>
                       <option value="Layout7">{{
                        $t("form.theme_settings.layout7")
                      }}</option>
                       <option value="Layout8">{{
                        $t("form.theme_settings.layout8")
                      }}</option>
                       <option value="Layout9">{{
                        $t("form.theme_settings.layout9")
                      }}</option>
                       <option value="Layout10">{{
                        $t("form.theme_settings.layout10")
                      }}</option>
                    </select>
                    <span class="heebo-light">
                    {{
                        $t("form.theme_settings.for_web")
                      }}
                    </span>
                  </div>
                   <div>
                     <img :src="footer_layout_web_image_url" alt="" width="100%" height="150" class="rounded" style="border: 1px solid black;">
                  </div>
                  </div>

                </div>
              </div>
                <div class="card-body p-3" v-if="formData.currently_active_theme == 'Template2' ">
                <div class="row">
                  <h2>{{
                        $t("form.theme_settings.category_smart_banners")
                      }}</h2>
                   <div
                    class="col-md-6 my-1">
                  <div role="group">
                    <label for="input-live" class="form-label">{{
                        $t("form.theme_settings.for_web")
                      }}</label>
                    <span
                      class="float-end text-danger"
                      v-if="error && error[index]"
                    >
                      {{ error[index][0] }}
                    </span>
                    <select
                      :class="error && error[index] ? 'error' : ''"
                      class="form-select"
                      v-model="formData.smart_category_banner"
                          @change="getCatSmartBannerMobileImageUrl()"
                    >
                   <option value="Layout1">{{
                        $t("form.theme_settings.layout1")
                      }} </option>
                      <option value="Layout2">{{
                        $t("form.theme_settings.layout2")
                      }}</option>
                      <option value="Layout3">{{
                        $t("form.theme_settings.layout3")
                      }}</option>
                      <option value="Layout4">{{
                        $t("form.theme_settings.layout4")
                      }}</option>
                      <option value="Layout5">{{
                        $t("form.theme_settings.layout5")
                      }}</option>
                        <!-- <option value="Layout6">{{
                        $t("form.theme_settings.layout6")
                      }}</option>
                       <option value="Layout7">{{
                        $t("form.theme_settings.layout7")
                      }}</option>
                       <option value="Layout8">{{
                        $t("form.theme_settings.layout8")
                      }}</option>
                       <option value="Layout9">{{
                        $t("form.theme_settings.layout9")
                      }}</option>
                       <option value="Layout10">{{
                        $t("form.theme_settings.layout10")
                      }}</option> -->
                    </select>
                    <span class="heebo-light">
                   {{
                        $t("form.theme_settings.for_web")
                      }}
                    </span>
                  </div>
                   <div>
                     <img :src="cat_smart_banner_layout_mobile_image_url" alt="" width="100%" height="150" class="rounded" style="border: 1px solid black;">
                  </div>
                  </div>

                </div>
              </div>
              <!-- web product cards starts -->
                  <div class="card-body p-3">
                <div class="row">
                  <h2>{{
                        $t("form.theme_settings.product_cards")
                      }}</h2>
                   <div
                    class="col-md-6 my-1">
                  <div role="group">
                    <label for="input-live" class="form-label">{{
                        $t("form.theme_settings.for_web")
                      }}</label>
                    <span
                      class="float-end text-danger"
                      v-if="error && error[index]"
                    >
                      {{ error[index][0] }}
                    </span>
                    <select
                      :class="error && error[index] ? 'error' : ''"
                      class="form-select"
                      v-model="formData.product_card_web"
                          @change="getProductCardWebImageUrl()"
                    >
                   <option value="Layout1">{{
                        $t("form.theme_settings.layout1")
                      }} </option>
                      <option value="Layout2">{{
                        $t("form.theme_settings.layout2")
                      }}</option>
                      <option value="Layout3">{{
                        $t("form.theme_settings.layout3")
                      }}</option>
                      <option value="Layout4">{{
                        $t("form.theme_settings.layout4")
                      }}</option>
                      <option value="Layout5">{{
                        $t("form.theme_settings.layout5")
                      }}</option>
                        <!-- <option value="Layout6">{{
                        $t("form.theme_settings.layout6")
                      }}</option>
                       <option value="Layout7">{{
                        $t("form.theme_settings.layout7")
                      }}</option>
                       <option value="Layout8">{{
                        $t("form.theme_settings.layout8")
                      }}</option>
                       <option value="Layout9">{{
                        $t("form.theme_settings.layout9")
                      }}</option>
                       <option value="Layout10">{{
                        $t("form.theme_settings.layout10")
                      }}</option> -->
                    </select>
                    <span class="heebo-light">
                   {{
                        $t("form.theme_settings.for_web")
                      }}
                    </span>
                  </div>
                   <div>
                     <img :src="product_card_layout_web_image_url" alt="" width="100%" height="150" class="rounded" style="border: 1px solid black;">
                  </div>
                  </div>

                </div>
              </div>
              <!-- web product cards ends -->
                <!-- mobile product cards starts -->
                  <div class="card-body p-3">
                <div class="row">
                  <h2>{{
                        $t("form.theme_settings.product_cards")
                      }}</h2>
                   <div
                    class="col-md-6 my-1">
                  <div role="group">
                    <label for="input-live" class="form-label">{{
                        $t("form.theme_settings.for_mobile")
                      }}</label>
                    <span
                      class="float-end text-danger"
                      v-if="error && error[index]"
                    >
                      {{ error[index][0] }}
                    </span>
                    <select
                      :class="error && error[index] ? 'error' : ''"
                      class="form-select"
                      v-model="formData.product_card_mobile"
                          @change="getProductCardMobileImageUrl()"
                    >
                   <option value="Layout1">{{
                        $t("form.theme_settings.layout1")
                      }} </option>
                      <option value="Layout2">{{
                        $t("form.theme_settings.layout2")
                      }}</option>
                      <option value="Layout3">{{
                        $t("form.theme_settings.layout3")
                      }}</option>
                      <option value="Layout4">{{
                        $t("form.theme_settings.layout4")
                      }}</option>
                      <!-- <option value="Layout5">{{
                        $t("form.theme_settings.layout5")
                      }}</option> -->
                        <!-- <option value="Layout6">{{
                        $t("form.theme_settings.layout6")
                      }}</option>
                       <option value="Layout7">{{
                        $t("form.theme_settings.layout7")
                      }}</option>
                       <option value="Layout8">{{
                        $t("form.theme_settings.layout8")
                      }}</option>
                       <option value="Layout9">{{
                        $t("form.theme_settings.layout9")
                      }}</option>
                       <option value="Layout10">{{
                        $t("form.theme_settings.layout10")
                      }}</option> -->
                    </select>
                    <span class="heebo-light">
                   {{
                        $t("form.theme_settings.for_mobile")
                      }}
                    </span>
                  </div>
                   <div>
                     <img :src="product_card_layout_mobile_image_url" alt="" height="150" class="rounded" style="border: 1px solid black;">
                  </div>
                  </div>

                </div>
              </div>
              <!--mobile product cards ends -->
            </div>
            <div class="row" v-permission="'settings.update'">
              <div class="col-md-12 text-center text-md-end">
                <button
                  type="button"
                  class="btn btn-primary mb-3 px-3 py-2"
                  @click="update()"
                  name="button"
                >
                  {{ this.$t("form.update") }}
                </button>
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
// import CkeditorNuxt from "@/components/global/ckeditorNuxt";
import { mapGetters, mapActions } from "vuex";
import static_data from "../static_data.json"
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "theme_settings.index",
    strategy: "index",
  },

   async fetch() {
     await this.fetchActiveThemeSettings();
    this.allActiveThemeSettings.forEach(element => {
        if(element.name == 'header_layout_web'){
            this.formData.header_layout_web = element.value
        }
        if(element.name == 'header_layout_mobile'){
            this.formData.header_layout_mobile = element.value
        }
        if(element.name == 'footer_layout_web'){
            this.formData.footer_layout_web = element.value
        }
         if(element.name == 'currently_active_theme'){
            this.formData.currently_active_theme = element.value
        }
         if(element.name == 'smart_category_banner'){
            this.formData.smart_category_banner = element.value
        }
        if(element.name == 'product_card_web'){
            this.formData.product_card_web = element.value
        }
          if(element.name == 'product_card_mopbile'){
            this.formData.product_card_mobile = element.value
        }

        this.getHeaderWebImageUrl();
        this.getHeaderMobileImageUrl();
        this.getCatSmartBannerMobileImageUrl();
        this.getFotterWebImageUrl();
        this.getProductCardWebImageUrl();
        this.getProductCardMobileImageUrl();

    });
    },
    created()
    {
        this.static_data = static_data
    },
  data() {
    return {
      formData: {
        header_layout_web: "Layout1",
        header_layout_mobile: "Layout1",
        footer_layout_web: "Layout1",
        currently_active_theme: "Template1",
        smart_category_banner: "Layout1",
        product_card_web: "Layout1",
        product_card_mobile: "Layout1",
      },
      error: false,
      static_data: {},
      header_layout_web_image_url:"",
      header_layout_mobile_image_url:"",
      footer_layout_web_image_url:"",
      cat_smart_banner_layout_mobile_image_url:"",
      product_card_layout_web_image_url:"",
      product_card_layout_mobile_image_url:""
    };
  },

  methods: {
    ...mapActions({
      updateThemeSettings: "ThemeSettings/updateThemeSettings",
      fetchActiveThemeSettings: "General/fetchActiveThemeSettings",
    }),
    async update() {
      try {
        await this.updateThemeSettings(this.formData).then((res) => {
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data;
            this.$toast.error(res.response.data.message);
          } else {

            this.error = false;
            this.$toast.success(res.message);
          }
        });
      } catch (e) {
      } finally {
      }
    },
    getHeaderWebImageUrl()
    {
        this.header_layout_web_image_url = static_data.web_header_images_url[this.formData.header_layout_web]
    },
    getHeaderMobileImageUrl()
    {
        this.header_layout_mobile_image_url = static_data.mobile_header_images_url[this.formData.header_layout_mobile]
    },
    getCatSmartBannerMobileImageUrl()
    {
        this.cat_smart_banner_layout_mobile_image_url = static_data.smart_category_banner_images_url[this.formData.smart_category_banner]
    },
     getFotterWebImageUrl()
    {
        this.footer_layout_web_image_url = static_data.web_footer_images_url[this.formData.footer_layout_web]
    },
     getProductCardWebImageUrl()
    {
        this.product_card_layout_web_image_url = static_data.product_card_web_images_url[this.formData.product_card_web]
    },
     getProductCardMobileImageUrl()
    {
        this.product_card_layout_mobile_image_url = static_data.product_card_mobile_images_url[this.formData.product_card_mobile]
    }
  },
  computed: {
    ...mapGetters({
      allActiveSettings: "General/allActiveSettings",
      allActiveThemeSettings: "General/allActiveThemeSettings",
    }),
  },
 watch:{
     'formData.currently_active_theme': function (newVal, oldVal){
        if (newVal == "Template1") {
            this.formData.smart_category_banner = "Layout1"
        }
     }
 }
};
</script>
