export default {
    data() {
        return {
            hideIcon: 0,
            filterData: {
                id: '',
                search: '',
                column: '',
                page: 1,
                perPage: 10,
                sort: {
                    field: '',
                    type: ''
                },
                export: '',
                date_from: '',
                date_to: '',
                status: '',
                vendor_id: ''
            },
            pagination: {
                nextLabel: this.$t("pagination.nextLabel"),
                prevLabel: this.$t("pagination.prevLabel"),
                rowsPerPageLabel: this.$t("pagination.rowsPerPageLabel"),
                ofLabel: this.$t("pagination.ofLabel"),
                pageLabel: this.$t("pagination.pageLabel"),
                allLabel: this.$t("pagination.allLabel")
            },
            rows: [],
            totalRows: '',
        }
    },
    methods: {
        onPageChange(params) {
            this.filterData.page = params.currentPage
            this.filter()
        },
        onPerPageChange(params) {
            this.filterData.page = 1
            if (params.currentPerPage == -1) {
                this.filterData.perPage = this.totalRows ?? 0;
            } else {
                this.filterData.perPage = params.currentPerPage
            }
            this.filter()
            this.filterData.perPage = ""
        },
        onSortChange(params) {
            if (params[0].type == "none"){
                this.filterData.sort.type = ""
            }else{
                this.filterData.sort.type = params[0].type
            }
            this.filterData.sort.field = params[0].field
            this.filter();
        },
        removeIcon() {
            if (this.filterData.search != '') {
                this.hideIcon = 1;
            } else {
                this.hideIcon = 0;
            }
        }
    },

}
