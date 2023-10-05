<template>
  <div class="ms-3 text-muted">
    <div v-for="cat in subCategories" :key="cat.id">
      <li :class="filterDataCategory == cat.slug ? 'active' : ''">
        <span @click="updateSelectedCategorySlug(cat.slug, cat.id, cat.name)">{{
          cat.name
        }}</span>
      </li>
      <div v-if="cat.childrens">
        <WebsiteTemplate1ShopPageSidebarCategoryRecursive
          @updateFilterCategorySlug="updateFilterCategorySlug"
          @updateFilterCategoryId="updateFilterCategoryId"
          @updateFilterCategoryName="updateFilterCategoryName"
          :subCategories="cat.childrens"
          :filterDataCategory="cat.slug"
        />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["subCategories", "filterDataCategory"],
  data() {
    return {};
  },
  methods: {
    updateSelectedCategorySlug(catSlug, catId, catName) {
      this.$emit("updateFilterCategorySlug", catSlug);
      this.$emit("updateFilterCategoryId", catId);
      this.$emit("updateFilterCategoryName", catName);
    },
    updateFilterCategorySlug(value) {
      this.$emit("updateFilterCategorySlug", value);
    },
    updateFilterCategoryId(value) {
      this.$emit("updateFilterCategoryId", value);
    },
     updateFilterCategoryName(value) {
      this.$emit("updateFilterCategoryName", value);
    },
  },
  watch: {
    filterDataCategory: {
      // the callback will be called immediately after the start of the observation
      // immediate: true,
      handler(val, oldVal) {
      },
    },
  },
};
</script>

<style>
</style>
