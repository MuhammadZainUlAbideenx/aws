<template>
  <div class="login py-5">
    <div class="row m-0 d-flex align-items-center justify-content-center px-3 px-md-0">
      <div class="w-615px">
        <div class="border border-white rounded">
          <div class="py-4 bg-white rounded">
            <div class="container py-2">
              <h3 class="text-center text-primary heebo-bold">{{$t('logo_here')}}</h3>
              <p class="text-center pb-4 mb-0" v-if="$fetchState.pending">
                  <AdminLoader />
                {{$t('clearing')}}
              </p>
              <p v-else>
                {{$t('done_clearing_cache')}}
              </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script>

  export default {
    layout: 'admin',
    middleware: ['admin'],
  //  auth: false,
    data() {
      return {
        error: false
      }
    },
    mounted() {},
    async fetch() {
    const cleared = await this.$generalService.cacheClear().then(
      (res) =>{
        if(res.state == "fail"){
          this.$toast.error(res.message);
        }
        if(res.state == "success"){
          this.$toast.success(res.message);
          this.$router.replace(this.localePath('/admin/dashboard'))
        }
      }
    )
  },
    methods: {
    },
  }
</script>
