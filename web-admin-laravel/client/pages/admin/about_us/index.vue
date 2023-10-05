<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("form.about_us.create_about_us") }}
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
                  <nuxt-link :to="localePath('/admin/about_us')">{{ this.$t("sidebar.about_us") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("form.create") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.about_us.form_description") }}
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
            <div class="card gutter-b border-0" >
              <div class="card-body">

                <div class="row">
                  <div class="col-lg-12 px-0">
            <div class="" >
              <div class="px-0 pt-4">
               <h2 class="m-0 text-body bold">
                  Multilanguage
              </h2>
              <p>
                 <span class=" heebo-light">
                         {{ $t("lorem_ipsum") }}
                  </span>
              </p>
                <div class="row mb-2">
                  <div class="col-lg-12 px-0 d-flex ">
                    <ul class="nav nav-tabs d-inline-block" id="myTab" role="tablist ">
                      <li class="nav-item" role="presentation" v-for="(language,index) in allActiveLanguages.languages" :key="language.id">
                        <a class="nav-link" :class="index == 0 ? 'active':''" :id="language.code+'-tab'" data-bs-toggle="tab" :href="'#' + language.code" role="tab" :aria-controls="language.code" :aria-selected="index == 0 ? 'true':'false'">{{language.name}}</a>
                      </li>
                    </ul>

                        <div class="tab-content p-4" id="myTabContent">
                          <div class="tab-pane fade" :class="index == 0 ? 'active show':''" v-for="(language,index) in allActiveLanguages.languages" :id="language.code" :key="language.id" role="tabpanel" :aria-labelledby="language.code+'-tab'">

                              <div class="row">
                                <div class="col-md-12 my-1" >
                                  <div role="group ">
                                    <label for="input-live" class=" form-label">{{ $t("form.about_us.label") }}:</label>
                                    <span class="float-end text-danger"
                                          v-if="error && error['text.' + language.code]">
                                        {{ error['text.'+language.code][0] }}
                                      </span>
                                      <GlobalCkeditorNuxt v-model="formData.text[language.code]"/>
                                    <span class=" heebo-light">
                                        {{ $t("form.about_us.subheading") }}
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
                <!-- <div class="col-lg-12 pt-2 px-0">
                    <div class="px-0 pt-3">
                      <h2 class="m-0 text-body bold">{{ $t("form.multilanguage") }}</h2>
                      <p>
                        <span class="heebo-light">
                          {{ $t("lorem_ipsum") }}
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
                              v-for="(language, index) in allActiveLanguages.languages" :key="language.id">
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
                              v-for="(language, index ) in allActiveLanguages.languages" :id="language.code" :key="language.id" role="tabpanel" :aria-labelledby="language.code + '-tab'">

                              <div class="row">
                                <div class="col-md-12 my-1">
                                  <div role="group ">
                                    <label
                                      for="input-live"
                                      class="px-2 form-label"
                                      >{{
                                        $t(
                                          "form.about_us.about_us.label"
                                        )
                                      }}:</label
                                    >
                                    <span
                                      class="float-end text-danger"
                                      v-if="
                                        error &&
                                        error['about_us.' + language.code]
                                      "
                                    >
                                      {{
                                        error["about_us." + language.code][0]
                                      }}
                                    </span>
                                    <GlobalCkeditorNuxt
                                      v-model="
                                        formData.text[language.code]
                                      "
                                    />
                                    <span class="px-2 heebo-light">
                                      {{
                                        $t(
                                          "form.about_us.about_us.subheading"
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
                  </div> -->
                </div>
              </div>

            </div>
        </div>


         <div class="row">
          <div class="col-md-12 px-4 text-center text-md-end">
            <button type="button"
                    class="btn btn-primary mb-3 px-3 py-2"
                    @click="add"
                    name="button">
                {{ this.$t("form.update") }}
              </button>
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
      permission: 'about_us.create',
      strategy: 'create'
    },
    async fetch(){
        let data = await this.fetchAboutUs();
        this.formData.text = data.textTranslations

    },
    data() {
      return {
         editorConfig: {
             // The configuration of the editor.
         },
         url: '/backend',
         formData: {
           text:{},
         },
         error: false
      }
    },
    methods: {
      ...mapActions({
        addAboutUs: 'AboutUs/addAboutUs',
        fetchAboutUs: 'AboutUs/fetchAboutUs',
      }),
      async add() {
        await this.addAndContinue()
        if (!this.error) {
          this.$router.replace(this.localePath('/admin/about_us'))
        }
      },
      async addAndContinue() {
        console.log("omi formdata",this.formData);
        await this.addAboutUs(this.formData).then(res => {
          // some error occur
          if (res.response) {
            this.error = res.response.data.errors ?? res.response.data
            this.$toast.error(res.response.data.message)
          } else {
            this.error = false
            this.$toast.success(res.message)
          }
        })
      }
    },

    mounted() {},
    computed:{
      ...mapGetters({
        allActiveLanguages: 'General/allActiveLanguages',
      })
    }
  }

</script>
