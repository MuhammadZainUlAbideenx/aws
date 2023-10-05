<template>
  <div class="ms-2">
    <div v-for="cat in subCategories" :key="cat.id">
      <li :class="filterDataCategory == cat.slug ? 'active' : ''">
        <span @click="updateSelectedCategorySlug(cat.slug, cat.id)">{{
          cat.name
        }}</span>
      </li>
      <div v-if="cat.childrens">
        <WebsiteTemplate2ShopPageSidebarCategoryRecursive
          @updateFilterCategorySlug="updateFilterCategorySlug"
          @updateFilterCategoryId="updateFilterCategoryId"
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
    updateSelectedCategorySlug(catSlug, catId) {
      this.$emit("updateFilterCategorySlug", catSlug);
      this.$emit("updateFilterCategoryId", catId);
    },
    updateFilterCategorySlug(value) {
      this.$emit("updateFilterCategorySlug", value);
    },
    updateFilterCategoryId(value) {
      this.$emit("updateFilterCategoryId", value);
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
