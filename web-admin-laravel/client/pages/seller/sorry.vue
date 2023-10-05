<template>

  <div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary px-3 py-2" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary px-3 py-2 ">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <div class="top-right links">
    </div>

    <div class="text-center">
      <div class="title mb-4">
        <span class="laravel">Laravel</span><span class="nuxt">Nuxt</span>
        <!-- {{ title }} -->
      </div>

      <div class="links">
        <a href="#">500 error - An error occured</a>
      </div>
    </div>
  </div>

</template>

<script>

  export default {
    auth: false,
    head() {
      return { title: this.$t('home') }
    },

    data: () => ({
      title: process.env.appName
    }),
    created() {
    }
  }

</script>

<style scoped>

  .top-right {
    position: absolute;
    right: 10px;
    top: 18px;
  }

  .title {
    font-size: 85px;
  }

  .laravel {
    color: #2e495e;
  }

  .nuxt {
    color: #00c48d;
  }

</style>
