export default {
  data() {
    return {

    }
  },
  methods: {
    onCopy: function (e) {
      this.$toast.success('You just copied: ' + e.text)
    },
    onError: function (e) {
      this.$toast.success('Failed to copy texts')
    },
  },

}
