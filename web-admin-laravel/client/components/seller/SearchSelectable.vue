<template >
  <v-select
    class=""
    @input="(event) => sendWholeObj(event)"
    :value="value"
    :reduce="(opt) => opt.id"
    :multiple="multiple"
    :placeholder="placeholder"
    :disabled="disabled"
    :label="show_key"
    :filterable="false"
    :options="options.data"
    @search="onSearch"
  >
    <template slot="no-options">
      {{ $t("form.search_select.no_options") }}
    </template>
    <template slot="option" slot-scope="option">
      <div class="d-center">
        {{ option[show_key] }}
      </div>
    </template>
    <template slot="selected-option" slot-scope="option">
      <div class="selected d-center">
        {{ option[show_key] }}
      </div>
    </template>
    <template #list-footer>
      <div class="text-center">
        <button
          type="button"
          class="btn btn-transparent text-primary"
          name="button"
          @click="loadMore"
          v-show="
            options &&
            options.links &&
            options.links.next &&
            options.meta &&
            options.meta.total != options.data.length
          "
        >
          {{$t('load_more')}}
        </button>
      </div>
    </template>
  </v-select>
</template>
<script type="text/javascript">
export default {
  data() {
    return {
        loadMoreClicked: false,
      options: {
        data: [],
      },
      selectedData:"",
      searchData: {
        page: 1,
        search: "",
      },
    };
  },
  props: {
    value: {
      required: false,
    },
    show_key: {
      required: false,
      default: "name",
    },
    initialOptions: {
      required: false,
    },
    selectedOptions: {
      required: false,
    },
    search_id: {
      required: false,
    },
    multiple: {
      required: false,
    },
    disabled: {
      required: false,
    },
    apiMethod: {
      required: false,
    },
    responseKey: {
      required: false,
    },
    placeholder: {
      required: false,
    },
  },
  mounted() {
      if (this.initialOptions) {
          this.options = { ...this.initialOptions };
    }
    if (this.selectedOptions) {
        this.options.data = this.options.data.concat(this.selectedOptions);
      this.makeConcatedOptionsUnique();
    }
  },
  methods: {
    async sendWholeObj(e) {

             const opt = this.options.data.find((opt) => opt.id == e);
            this.$emit("input", e, opt);
            this.selectedData = opt
            if (e === null) {
                this.searchData.search = ''
                 await this.callApi(true);
            }

    },
    async onSearch(search, loading) {
        this.loadMoreClicked = false
      this.searchData.page = 1;
      if (search) {
      this.searchData.search = search;
      }
      else
      {
         this.searchData.search = "";
      }
      loading(true);
      await this.callApi(loading,search);
    },
    async callApi(loading,search) {
      if (this.search_id) {
        await this.$generalService[this.apiMethod](
          this.search_id,
          this.searchData
        ).then((response) => {
          this.options.meta = response[this.responseKey][this.responseKey].meta;
          this.options.links =
            response[this.responseKey][this.responseKey].links;
            if(this.loadMoreClicked)
            {
                this.options.data = this.options.data.concat(response[this.responseKey][this.responseKey].data)
            }
            else
            {
                this.options.data = response[this.responseKey][this.responseKey].data
            }
          this.makeConcatedOptionsUnique();
          this.searchData.page =
            response[this.responseKey][this.responseKey].meta.current_page;
            if (!search) {

                this.options.data.push(this.selectedData);
            }
          if (loading) {
            loading(false);
          }
        }).catch((e) => {
      });
      } else {
        await this.$generalService[this.apiMethod](this.searchData).then(
          (response) => {
            this.options.meta =
              response[this.responseKey][this.responseKey].meta;
            this.options.links =
              response[this.responseKey][this.responseKey].links;
            if(this.loadMoreClicked)
            {
                this.options.data = this.options.data.concat(response[this.responseKey][this.responseKey].data)
            }
            else
            {
                this.options.data = response[this.responseKey][this.responseKey].data
            }
            this.makeConcatedOptionsUnique();
            this.searchData.page =
              response[this.responseKey][this.responseKey].meta.current_page;
            if (!search) {

                this.options.data.push(this.selectedData);
            }

            if (loading) {
              loading(false);
            }
          }
        ).catch((e) => {
      });
      }
    },
    makeConcatedOptionsUnique() {
      const key = "id";
      const arrayUniqueByKey = [
        ...new Map(this.options.data.map((item) => [item[key], item])).values(),
      ];
      this.options.data = arrayUniqueByKey;
    },
    async loadMore() {
        this.loadMoreClicked = true
      if (this.options && this.options.links && this.options.links.next) {
        this.searchData.page += 1;
        this.callApi();
      }
    },
  },
};

</script>
<style scoped>
</style>
