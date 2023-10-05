<template >

  <div >
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">
              {{ this.$t("sidebar.setting") }}
            </h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item">
                  <nuxt-link :to="localePath('/admin/dashboard')">{{ this.$t("sidebar.home") }}</nuxt-link>
                </li>
                <li class="breadcrumb-item active">
                  {{ this.$t("sidebar.setting") }}
                </li>
              </ol>
              <p class="text-body-secondary">
                {{ this.$t("form.setting.form_description") }}
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
            <div class="card gutter-b border-0" >
              <div class="card-header gutter-b pb-0">
              <div class="text-end" v-if="allActiveSettings &&  allActiveSettings.settings && allActiveSettings.settings.environment && (allActiveSettings.settings.environment == 'local' || allActiveSettings.settings.environment == 'development')">
                <button type="button"  v-tooltip="{ content: 'Add New' }"  class="btn add btn-primary px-3 shadow  rounded-circle" name="button" data-bs-toggle="modal" data-bs-target="#addNewKey"> <fa :icon="['fas', 'plus']" fixed-width /></button>
                </div>
                <div class="modal fade in media-gallery-modal" id="addNewKey" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                  <div class="modal-content">
                    <div class="modal-header p-2">
                      <button type="button" class="btn rounded-circle btn-primary d-block ms-auto" data-bs-dismiss="modal" aria-label="Close">
                        <fa icon="times"  ></fa>
                      </button>
                    </div>
                    <div class="modal-body px-4">
                      <div class="row">
                        <div class="col-md-12 my-1 px-4">
                          <div role="group">
                            <label for="input-live" class="px-2 form-label">{{ this.$t("form.setting.key.label") }}:</label>
                            <span class="float-end text-danger"
                                  v-if="error && error.key">
                                {{ error.key[0] }}
                              </span>
                            <input :class="error && error.key ? 'error' : ''"
                                   class="form-control"
                                   aria-describedby="input-live-help input-live-feedback"
                                   v-model="key"
                                   :placeholder="this.$t('form.setting.key.placeholder')"
                                   trim />
                           <span class="px-2 heebo-light">
                               {{ $t("form.setting.key.subheading") }}
                           </span>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 my-1 px-4">
                          <div role="group">
                            <label for="input-live" class="px-2 form-label">{{ this.$t("form.setting.value.label") }}:</label>
                            <span class="float-end text-danger"
                                  v-if="error && error.value">
                              </span>
                            <input :class="error && error.value ? 'error' : ''"
                                   class="form-control"
                                   v-model="value"
                                   aria-describedby="input-live-help input-live-feedback"
                                   :placeholder="this.$t('form.setting.value.placeholder')"
                                   trim />
                           <span class="px-2 heebo-light">
                               {{ $t("form.setting.value.subheading") }}
                           </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer mt-3 mb-5 mx-2">
                      <button type="button" class="btn btn-danger py-2 px-4 shadow" data-bs-dismiss="modal">{{ $t("close") }}</button>
                      <button type="button" :data-bs-dismiss="this.key == '' || typeof this.formData[this.key] != 'undefined' ? '':'modal'" class="btn btn-primary py-2 px-4 shadow" @click="addNewKeyValue">{{ $t("add") }}</button>
                    </div>
                  </div>
                </div>
                </div>
              </div>
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-md-6 my-1" v-for="(setting,index) in formData" :key="index" v-if="index!='settings'">

                    <div role="group" v-if="index == 'vendor_commission_type' && allActiveSettings.settings.generalSettings.is_multi_vendor == 1">
                      <label for="input-live" class=" form-label">{{index}}</label>
                      <span class="float-end text-danger"
                            v-if="error && error[index]">
                          {{ error[index][0] }}
                        </span>
                        <select  :class="error && error[index] ? 'error' : ''"
                                class="form-select"
                                v-model="formData[index]">
                            <option :value="option.value" v-for="option in options">
                              {{ option.text }}
                            </option>
                          </select>
                     <span class=" heebo-light">
                         {{ index }}
                     </span>
                    </div>
                    <div role="group" v-else-if="index == 'date_format' ">
                      <label for="input-live" class=" form-label">{{index}}</label>
                      <span class="float-end text-danger"
                            v-if="error && error[index]">
                          {{ error[index][0] }}
                        </span>
                        <select  :class="error && error[index] ? 'error' : ''"
                                class="form-select"
                                v-model="formData[index]"
                                >
                            <option value="'d F, Y" >
                            13 September, 2021
                            </option>
                            <option value="d F, Y (l)" >
                             13 September, 2021 (Thursday)
                            </option>
                            <option value="l, h:i:s A">
                            Thursday, 11:04:09 AM
                            </option>
                              <option value="d F Y, h:i:s A">
                            13 September 2021, 11:05:00 AM
                            </option>
                               <option value="d/m/Y">
                            19/01/2021
                            </option>
                          </select>
                     <span class=" heebo-light">
                         {{ index }}
                     </span>
                    </div>
                    <div role="group" v-else-if="index == 'environment' ">
                      <label for="input-live" class=" form-label">{{index}}</label>
                      <span class="float-end text-danger"
                            v-if="error && error[index]">
                          {{ error[index][0] }}
                        </span>
                        <select  :class="error && error[index] ? 'error' : ''"
                                class="form-select"
                                v-model="formData[index]"
                                >
                            <option value="local" >
                              {{$t('form.store_settings.web_mode.local')}}
                            </option>
                            <option value="development" >
                              {{$t('form.store_settings.web_mode.development')}}
                            </option>
                            <option value="production">
                              {{$t('form.store_settings.web_mode.production')}}
                            </option>
                          </select>
                     <span class=" heebo-light">
                         {{ index }}
                     </span>
                    </div>
                    <div role="group" v-else-if="index == 'is_multi_vendor'">
                      <label for="input-live" class=" form-label">{{index}}</label>
                      <span class="float-end text-danger"
                            v-if="error && error[index]">
                          {{ error[index][0] }}
                        </span>
                      <input :class="error && error[index] ? 'error' : ''"
                             class="form-control"
                             v-on:change="multiVendorChange"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData[index]"
                             :placeholder="index"
                             trim />
                     <span class=" heebo-light">
                         {{ index }}
                     </span>
                    </div>
                    <div role="group" v-else>
                      <label for="input-live" class=" form-label">{{index}}</label>
                      <span class="float-end text-danger"
                            v-if="error && error[index]">
                          {{ error[index][0] }}
                        </span>
                      <input :class="error && error[index] ? 'error' : ''"
                             class="form-control"
                             aria-describedby="input-live-help input-live-feedback"
                             v-model="formData[index]"
                             :placeholder="index"
                             trim />
                     <span class=" heebo-light">
                         {{ index }}
                     </span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
             <div class="row" v-permission="'settings.update'">
                  <div class="col-md-12 text-center text-md-end">
                    <button type="button"
                            class="btn btn-primary mb-3 px-3 py-2"
                            @click="update()"
                            name="button">
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
  import { mapGetters, mapActions } from 'vuex'
  export default {
    layout: 'admin',
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'settings.index',
      strategy: 'index'
    },
    mounted(){
      if(this.allActiveSettings && this.allActiveSettings.settings && this.allActiveSettings.settings.generalSettings){
        this.formData.environment = this.allActiveSettings.settings.environment
        this.formData = {...this.formData,...this.allActiveSettings.settings.generalSettings}
      }
    },
    fetch(){

    },
    data() {
      return {
        options: [
          { value: 0, text: this.$t('form.setting.vendor_commission_type.category') },
          { value: 1, text: this.$t('form.setting.vendor_commission_type.sales') },
        ],
        key:'',
        value:'',
        formData:{
          environment:'',
          settings:'general_settings',
        },
        error: false
      }
    },
    methods: {
      ...mapActions({
        addSettings: 'Settings/addSettings',
        fetchActiveSettings: 'General/fetchActiveSettings',
        fetchActiveVendors: 'General/fetchActiveVendors',
      }),
      multiVendorChange(){
        if(parseInt(this.formData.is_multi_vendor) == parseInt(this.allActiveSettings.settings.generalSettings.is_multi_vendor)){
          return
        }
        else{
          if(parseInt(this.formData.is_multi_vendor) == 0){
            this.$toast.info(this.$t('by_changing_multi_vendor_store_to_single_store'))
          }
        else if(parseInt(this.formData.is_multi_vendor) == 1){
            this.$toast.success(this.$t('by_changing_single_store_to_multi_vendor'))
          }
        }
      },
      addNewKeyValue(){
        if(this.key){
          if(typeof this.allActiveSettings.settings.generalSettings[this.key] != 'undefined'  || typeof this.formData[this.key] != 'undefined'){
            this.$toast.error(this.$t('this_key_has_already_been_taken'))
          }
          else{
            this.$set(this.formData,this.key,this.value)
            this.key = ''
            this.value = ''
            this.$toast.success(this.$t('new_key_value_added_please_click_update_to_add_in_database'))
          }
        }
        else{
          this.$toast.error(this.$t('key_field_is_required'))
        }
      },
      async update() {
        try {
          await this.addSettings(this.formData)
          .then(
              res => {
                if (res.response) {
                  this.error = res.response.data.errors ?? res.response.data
                  this.$toast.error(res.response.data.message)
                } else {
                  this.fetchActiveSettings();
                  this.fetchActiveVendors();
                  this.error = false
                  this.$toast.success(res.message)
                }
              })
        } catch (e) {
        } finally {

        }

          }
    },
    computed:{
      ...mapGetters({
        allActiveSettings: 'General/allActiveSettings'
      }),
    },
    watch:{
      allActiveSettings(newVal,oldVal){
        this.formData = {...this.formData,...this.allActiveSettings.settings.generalSettings}
      }
    }
  }

</script>
