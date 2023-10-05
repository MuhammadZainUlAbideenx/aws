<template>
  <div class="container">
    <div v-if="error.statusCode === 404">
      <WebsiteTemplate1Error404 />
    </div>
    <div v-else-if="error.statusCode === 500">
      <WebsiteTemplate1Error500 />
    </div>
    <div v-else-if="error.statusCode === 429">
      <WebsiteTemplate1429 />
    </div>
    <div v-else>An error occurred {{ error }}</div>
  </div>
</template>

<script>
export default {
  props: ["error"],
  layout:"error_layout"
}
</script>
