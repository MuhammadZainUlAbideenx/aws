<template>
  <main>
    <div class="container mx-auto pt-8">
      <div
        v-if="!loggedInUser.verified"
        class="w-full px-6 py-3 rounded-sm border text-yellow-800 bg-yellow-300 border-yellow-400"
        role="alert"
      >
        {{$t('before_proceeding')}}
        <button
          class="text-blue-700 cursor-pointer hover:text-blue-600 focus:outline-none focus:underline transition ease-in-out duration-150"
          @click="resendVerificationEmail"
        >
          {{$t('click_here_to_request_another')}}</button
        >
      </div>
  <div class="mt-6"></div>

      <div class="mt-6">{{$t('logged_in_user_name')}}: {{ loggedInUser.name }}</div>
      <div class="mt-6">{{$t('logged_in_user_email')}}: {{ loggedInUser.email }}</div>

      <button
            class="block duration-150 ease-in-out focus:bg-gray-100 focus:outline-none hover:bg-gray-100 leading-5 px-4 py-2 text-gray-700 text-left text-sm transition w-full"
            @click="logout"
          >
            {{$t('sign_out')}}
          </button>
      <nuxt-link
        :to="localePath('/login')"
        class="text-blue-600 font-bold mx-2 text-sm hover:text-blue-500"
      >
        {{$t('login')}}
      </nuxt-link>
    </div>
  </main>
</template>

<script>
export default {
  middleware: 'customer',
  async fetch() {
    await this.$auth
      .fetchUser()
      .then((response) => (this.loggedInUser = response.data.data))
  },

  data() {
    return {
      loggedInUser: this.$auth.user.data,
      checkRoles: this.$auth.roles
    }
  },
  created(){
  },
  methods: {
    async resendVerificationEmail() {
      await this.$axios
        .$post('/backend/api/email/resend')
        .then(() => {
          this.$toast.success(this.$t('a_fresh_verification_link_has_been_sent_to_your_email_address'))
        })
        .catch((e) => {
          this.$toast.error(e.response.data.message)
        })
    },
    async logout() {
      this.error = null

      await this.$auth
        .logout('laravelPassportPassword')
        .then(() => {
          this.$toast.success(
            this.$t('You are logged out now')
          )
          this.$router.push('/')})
        .catch((e) => (this.error = e.response.data))
    },
  },
}
</script>
