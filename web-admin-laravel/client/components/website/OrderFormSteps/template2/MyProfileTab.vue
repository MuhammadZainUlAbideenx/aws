<template>
  <div  v-if="$fetchState.pending">
        <AdminFormLoader/>
      </div>
  <div v-else class="my-profile-tab">
    <form class="row g-4 needs-validation">
      <div class="col-md-6">
        <span class="float-end text-danger"
              v-if="error.first_name">
            {{ error.first_name[0] }}
          </span>
        <label for="validationServer02" class="form-label">{{$t('form.customer.first_name.label')}}</label>
        <input type="text" v-model='profile.first_name' class="form-control" id="validationServer02"  :placeholder="$t('form.customer.first_name.placeholder')" required>
      </div>
      <div class="col-md-6">
        <span class="float-end text-danger"
              v-if="error.last_name">
            {{ error.last_name[0] }}
          </span>
        <label for="validationServerUsername" class="form-label">{{$t('form.customer.last_name.label')}}</label>
        <div class="input-group has-validation">
          <input type="text" v-model='profile.last_name' class="form-control" id="validationServerUsername" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" :placeholder="$t('form.customer.last_name.placeholder')" required>
          <div id="validationServerUsernameFeedback" class="invalid-feedback">
          {{$t('form.customer.choose_username')}}
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div role="group">
        <label class="label form-label">
            {{ this.$t("form.customer.dob.label") }}
          </label>
          <span class="float-end text-danger"
                v-if="error.dob">
                {{ error.dob[0] }}
          </span>
          <datetime :min-datetime="now.min_date" :max-datetime="now.max_date" :placeholder="this.$t('form.customer.dob.placeholder')" input-class="form-control" value-zone="local" type="date" v-model="profile.dob"></datetime>
     </div>
      </div>
      <div class="col-md-6">
        <span class="float-end text-danger"
              v-if="error.phone">
            {{ error.phone[0] }}
          </span>
        <label for="validationServerUsername" class="form-label">{{$t('form.customer.contact.label')}} #</label>
        <div class="input-group has-validation">
          <input type="text" v-model='profile.phone' class="form-control" id="validationServerUsername"  :placeholder="$t('form.customer.contact.placeholder')" >
        </div>
      </div>
      <div class="col-md-6">
        <div role="group">
          <label for="input-live" class="form-label text-capitalize">{{ this.$t("form.customer.gender.label") }}:</label>
          <div class="d-flex">
            <div class="form-check me-4">
              <input class="form-check-input" type="radio" value="male" name="gender-radio" id="radio-male" v-model="profile.gender">
              <label class="form-check-label" for="radio-male">
                {{ $t("form.customer.gender.male") }}
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="female" name="gender-radio" id="radio-female" v-model="profile.gender">
              <label class="form-check-label" for="radio-female">
                {{ $t("form.customer.gender.female") }}
              </label>
            </div>
          </div>
        </div>
    <div class="col-md-6 mb-3 px-0 mt-4">
                <div class="d-flex align-items-center mb-2">
                <label class="label form-label me-4 text-capitalize mb-0">
                    {{ this.$t("form.admin.is_credentials.label") }}
                </label>

                <div class="form-switch">
                    <input
                    class="form-check-input"
                    v-model="profile.is_credentials"
                    :checked="profile.is_credentials ? 'checked' : ''"
                    type="checkbox"
                    id="flexSwitchCheckChecked"
                    />
                </div>
                </div>
                <span class="heebo-light">
                {{ $t("form.admin.is_credentials.subheading") }}
                </span>
            </div>
      </div>
            <div class="row g-4" v-if="profile.is_credentials">
          <div class="col-md-6">
          <div role="group">
            <label for="input-live" class="form-label"
              >{{ this.$t("form.admin.old_password.label") }}:</label
            >
            <span class="float-end text-danger" v-if="error && error.old_password">
              {{ error.old_password[0] }}
            </span>
            <input
              :class="error && error.old_password ? 'error' : ''"
              class="form-control"
              v-model="profile.old_password"
              type="password"
              aria-describedby="input-live-help input-live-feedback"
              :placeholder="this.$t('form.admin.old_password.placeholder')"
              trim
            />

          </div>
        </div>
        <div class="col-md-6">
          <div role="group">
            <label for="input-live" class="form-label"
              >{{ this.$t("form.admin.password.label") }}:</label
            >
            <span class="float-end text-danger" v-if="error && error.password">
              {{ error.password[0] }}
            </span>
            <input
              :class="error && error.password ? 'error' : ''"
              class="form-control"
              v-model="profile.password"
              type="password"
              aria-describedby="input-live-help input-live-feedback"
              :placeholder="this.$t('form.admin.password.placeholder')"
              trim
            />
          </div>
        </div>

        <div class="col-md-6">
          <div role="group">
            <label for="input-live" class="form-label"
              >{{ this.$t("form.admin.password_confirmation.label") }}:</label
            >
            <span
              class="float-end text-danger"
              v-if="error && error.password_confirmation"
            >
              {{ error.confirm_password[0] }}
            </span>
            <input
              :class="error && error.password_confirmation ? 'error' : ''"
              class="form-control"
              v-model="profile.password_confirmation"
              type="password"
              aria-describedby="input-live-help input-live-feedback"
              :placeholder="
                this.$t('form.admin.password_confirmation.placeholder')
              "
              trim
            />
          </div>
        </div>
            </div>
      <div class="d-flex justify-content-end">
        <a class="btn btn-primary text-white rounded py-2 px-3 lh-sm fw-bold text-uppercase mt-3"
                  @click='updateProfile()'
                  v-tooltip="{ content: 'Update Customer' }"
        >
              {{$t('update')}}
        </a>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      message:'',
      profile:{
        first_name :'',
        last_name :'',
        gender :'',
        dob :'',
        phone :'',
        is_credentials: false,
        old_password: "",
        password: "",
        password_confirmation: "",
      },
      error:'',
    }
  },
  async fetch() {
    const { data } = await this.$webService.customerProfile()
    if(data){
      this.profile.first_name = data.first_name
      this.profile.last_name = data.last_name
      this.profile.gender = data.gender
      this.profile.dob = data.dob
      this.profile.phone = data.phone
    }
  },
  methods:{
  async updateProfile() {
      if (
        (this.profile.is_credentials && this.profile.password == "") ||
        (this.profile.is_credentials &&
          this.profile.password_confirmation == "")
      ) {
        this.$toast.error(this.$t("password_field_is_required"));
      } else {
        await this.$webService
          .customerProfileUpdate(this.profile)
          .then((res) => {
            // some error occur
            if (res.response) {
              this.error = res.response.data.errors ?? res.response.data;
              this.$toast.error(res.response.data.message);
            } else {
              this.error = "";
              this.profile.is_credentials = false;
              this.profile.password = "";
              this.profile.password_confirmation = "";
              this.$toast.success(res.message);
            }
          })
          .catch((error) => {
            this.error = error.response.data.errors;
          });
      }
    },
  },
  computed: {
      now: function () {
                var max_date = new Date();
                var min_date = new Date();
                min_date.setYear(min_date.getFullYear()-100);
                max_date.setYear(max_date.getFullYear()-10);
                var max_date = new Date(max_date).toISOString();
                var min_date = new Date(min_date).toISOString();
                return {
                  min_date: min_date,
                  max_date: max_date
                };
      },
  },
   watch:{
     'profile.is_credentials': function (newVal, oldVal){
      this.profile.old_password = "";
      this.profile.password = "";
      this.profile.password_confirmation = "";
     },

 }
}
</script>

<style>

</style>
