<template>
  <main></main>
</template>

<script>
export default {
  middleware: 'auth',
  async fetch() {
    await this.$axios
      .$get(
        `/api/email/verify/${this.$route.params.id}/${this.$route.params.hash}?expires=${this.$route.query.expires}&signature=${this.$route.query.signature}`
      )
      .then(() => {
        this.$toast.success(this.$t('your_have_successfully_verified_your_account'))
        this.$router.push('/profile')
      })
      .catch((e) => {
        this.$toast.error(e.response.data.message)
        this.$router.push('/profile')
      })
  },
}
</script>
