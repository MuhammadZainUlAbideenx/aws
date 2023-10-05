<template>
  <div
    class="modal fade"
    :id="modal_id"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <AdminLoader v-if="loader" />
        <div v-else class="modal-body p-5 text-center">
          <!-- <div class="warning-icon text-white">
                            <fa :icon="['fas', 'trash-alt']" fixed-width />
                        </div> -->

          <div class="py-2">
            <h3>{{ $t("select_zip_file") }}</h3>
            <input
              type="file"
              accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed"
              @change="processFile($event)"
            />
          </div>
          <button class="btn btn-warning" @click="downloadSample">
            {{ $t("sample_zip") }}
          </button>
          <button
            :disabled="disabled"
            class="btn btn-secondary"
            @click="importSubmit"
          >
            {{ $t("Import") }}
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            {{ $t("web.customer.wallet.close") }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  props: ["modal_id", "api_prefix"],
  data: () => ({
    file: "",
    loader: false,
    disabled: true,
  }),
  methods: {
    ...mapActions({
      fetchProducts: "Products/fetchProducts",
      deleteProducts: "Products/deleteProducts",
      filterProducts: "Products/filterProducts",
      updateProductStatus: "Products/updateProductStatus",
      filterVendorProducts: "Products/filterVendorProducts",
    }),
    processFile(event) {
      this.file = event.target.files[0];
      this.disabled = false;
    },
    async importSubmit() {
      this.loader = true;
      var formData = new FormData();
      formData.append("file", this.file);
      await this.$generalService
        .importData(formData, this.api_prefix)
        .then((response) => {
          this.fetchProducts(this.page).then();
          this.loader = false;
        })
        .catch((e) => {
          console.log("error", e);
          this.loader = false;
        });
    },
    downloadSample() {
      const link = document.createElement("a");
      link.href = "/backend/api/media/samplecsv/products_sample.zip";
      console.log(link.href);
      link.download = "product_sample";
      link.click();
    },
  },
  computed: {
    ...mapGetters({
      allProducts: "Products/allProducts",
    }),
  },
};
</script>
