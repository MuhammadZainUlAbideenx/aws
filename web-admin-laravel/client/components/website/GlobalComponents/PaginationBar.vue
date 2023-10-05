<template>
  <section class="pagination-sec">
    <div class="row">
      <div class="col-6">
        <div class="d-flex align-items-center h-100">
          <div class="page-items text_size text-uppercase fw-bold">
            {{$t('show')}} <span>{{ orders.data.length }}</span> {{$t('of')}}
            <span>{{ orders.meta.total }}</span>
          </div>
        </div>
      </div>
      <div class="col-6">
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-end m-0">
            <li class="page-item " :class="[(orders.links.prev == null ?  'disabled' : '')] " >
              <a
                class="page-link"
                href="javascript:void(0);"
                @click="backPage()"
                tabindex="-1"
                aria-disabled="true"
                >{{$t('pagination.prevLabel')}}</a
              >
            </li>
            <!-- <li class="page-item active">
              <a class="page-link" href="#">1</a>
            </li> -->
            <li
              class="page-item"
              :class="activatedPage == index + 1 ? 'active' : ''"
              v-for="(order, index) in orders.meta.last_page"
              :key="order.id"
            >
              <a
                class="page-link"
                href="javascript:void(0);"
                @click="filterData(index)"
                >{{ index + 1 }}</a
              >
            </li>
            <li class="page-item" :class="[(orders.links.next == null ?  'disabled' : '')] ">
              <a
                class="page-link"
                href="javascript:void(0);"
                @click="nextPage()"
                >{{$t('pagination.nextLabel')}}</a
              >
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  props: ["orders"],
  data() {
    return {
      activatedPage: "",
    };
  },
  mounted() {
    for (let index = 0; index < this.orders.meta.links.length; index++) {
      if (this.orders.meta.links[index].active) {
        this.activatedPage = this.orders.meta.links[index].label;
      }
    }
  },
  methods: {
    filterData(index) {
      index = index + 1;
      this.$emit("updateFilter", index);
    },
    nextPage() {
      this.activatedPage = parseInt(this.activatedPage) + 1;
      this.$emit("updateFilter", this.activatedPage);
    },
    backPage() {
      this.activatedPage = parseInt(this.activatedPage) - 1;
      this.$emit("updateFilter", this.activatedPage);
    },
  },
};
</script>

<style>
</style>
