<template>
  <div class="vendorlistcard">
    <div class="card">
      <div class="img-wrap">
        <img
          v-if="vendor.store != null && vendor.store.cover_image"
          :src="`/backend${vendor.store.cover_image.original_media_path}`"
        />
        <img
          v-else
          class="w-sm-100 img-fluid"
          src="~/assets/images/placeholder.png"
          alt="..."
        />
      </div>

      <div class="content text-center">
        <div class="vendor-img">
          <img
            v-if="vendor.store != null && vendor.store.store_logo"
            :src="`/backend${vendor.store.store_logo.original_media_path}`"
          />
          <img
            v-else
            class="w-sm-100 img-fluid"
            src="~/assets/images/placeholder.png"
            alt="..."
          />
        </div>
        <h3 class="mb-0">{{ vendor.store ? vendor.store.name : "" }}</h3>
        <nuxt-link :to="`/store/${vendor.store.slug}`">
          {{ $t("view_store") }}
        </nuxt-link>
        <div class="d-flex align-items-end justify-content-between pt-4 ">
          <div class="text-start">
            <!-- <h5 class="mb-1">{{$t('positive_90')}}</h5> -->
            <h6 class="mb-1">{{$t('seller_rating')}}</h6>
            <GlobalRating :rating="vendor.reviews_average_rating" />
          </div>

          <div  @click="followVendor(vendor.id)">
            <button class="btn btn-warning px-4">
              <fa icon="heart" :class=" follow ? 'text-danger' : ''" fixed-width /> {{$t('follow')}}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  props: ["vendor"],
    data() {
    return {
        follow : false,
        data:{
            vendor_id:"",
            customer_id:"",
        }
    };
  },
   created()
  {
    this.follow = this.vendor.is_followed
  },
  methods:{
     async followVendor(vendor_id) {

    if (
        this.$auth.loggedIn &&
        this.$gates.hasRole('customer')
      ) {
         this.data.vendor_id = vendor_id
        this.data.customer_id = this.$auth.user.id
        await this.$webService
          .followVendor(this.data)
          .then(async (res) => {
                this.follow = res.data.is_follow;
              this.$toast.success(res.message);
          });
      } else {
        this.$toast.error(this.$t("please_login_first"));
      }
    },
  }
};
</script>
