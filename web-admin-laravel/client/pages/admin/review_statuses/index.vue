<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="row g-0">
                <div class="col-sm-12 px-0">
                    <h2 class="m-0 text-body bold">
                        {{ this.$t("sidebar.review_status") }}
                    </h2>
                </div>
                <!-- /.col -->
                <div class="row">
                    <div class="col-sm-12 px-0">
                        <ol class="breadcrumb float-sm-right text-body">
                            <li class="breadcrumb-item">
                                <a href="#">{{ this.$t("sidebar.home") }}</a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{ this.$t("sidebar.review_status") }}
                            </li>
                        </ol>
                        <p class="text-body-secondary">
                            {{ this.$t("form.review_status.index_description") }}
                        </p>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!-- /.row -->
        </div>

        <!-- Main content -->
        <section class="content">
            <div v-if="$fetchState.pending">
                <AdminTableLoader />
            </div>
            <div class="container-fluid" v-else>
                <div class="card gutter-b border-0">
                    <div class="card-header p-0">
                        <div class="row table-filter-row g-0">
                            <!-- Small boxes (Stat box) -->
                            <div class="col-lg-8">
                                <div class="d-flex flex-column flex-md-row">
                                    <select
                                        class="form-select custom-select"
                                        v-model="filterData.column"
                                    >
                                        <option value="" disabled>
                                            {{ $t("table.select_column") }}
                                        </option>
                                        <option value="name">
                                            {{ $t("columns.name") }}
                                        </option>
                                    </select>
                                    <div
                                        class="form-group position-relative col-md-8 col-lg-5"
                                    >
                                        <input
                                            class="form-control"
                                            v-model="filterData.search"
                                            @change="filter"
                                            type="search"
                                            :placeholder="
                                                this.$t('dataTables.Search')
                                            "
                                            @keyup="removeIcon"
                                        />
                                        <div
                                            v-bind:class="{
                                                'd-none': hideIcon,
                                            }"
                                            class="position-absolute search-input-custom"
                                        >
                                            <fa
                                                :icon="['fas', 'search']"
                                                fixed-width
                                                class=""
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-0 input-group">
                                    <div
                                        class="col-md-4 col-lg-3 form-group position-relative"
                                    ></div>
                                    <div class="vl"></div>

                                </div>
                            </div>
                            <div
                                class="col-lg-4 table-actions px-0"
                            >
                                <div slot="table-actions" class="align-middle">
                                    <div class="share">
                                        <nav>
                                            <span
                                                @click="
                                                    exportReviewStatuses('csv')
                                                "
                                            >
                                                <nuxt-link
                                                    to="#"
                                                    v-tooltip="{
                                                        content:
                                                            'Export CSV File',
                                                    }"
                                                >
                                                    <img
                                                        src="~/assets/images/csv.png"
                                                        alt=""
                                                        height="20px"
                                                        width="20px"
                                                    />
                                                </nuxt-link>
                                            </span>

                                            <span
                                                @click="
                                                    exportReviewStatuses('xlsx')
                                                "
                                            >
                                                <nuxt-link
                                                    to="#"
                                                    v-tooltip="{
                                                        content:
                                                            'Export Excel File',
                                                    }"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Tooltip on top"
                                                >
                                                    <img
                                                        src="~/assets/images/excel.png"
                                                        alt=""
                                                        height="20px"
                                                        width="20px"
                                                    />
                                                </nuxt-link>
                                            </span>

                                            <span
                                                @click="
                                                    exportReviewStatuses('pdf')
                                                "
                                            >
                                                <nuxt-link
                                                    to="#"
                                                    v-tooltip="{
                                                        content:
                                                            'Export PDF File',
                                                    }"
                                                >
                                                    <img
                                                        src="~/assets/images/pdf.png"
                                                        alt=""
                                                        height="20px"
                                                        width="20px"
                                                    />
                                                </nuxt-link>
                                            </span>

                                            <nuxt-link
                                                to="#"
                                                v-tooltip="{
                                                    content: 'Export File',
                                                }"
                                            >
                                                <fa
                                                    :icon="[
                                                        'fas',
                                                        'arrow-down',
                                                    ]"
                                                    fixed-width
                                                />
                                            </nuxt-link>
                                        </nav>
                                    </div>
                                    <nuxt-link
                                        v-permission="'review_statuses.create'"
                                        :to="
                                            localePath(
                                                '/admin/review_statuses/create'
                                            )
                                        "
                                    >
                                        <button
                                            type="button"
                                            v-tooltip="{
                                                content: 'Add Review Status',
                                            }"
                                            class="btn add px-3 rounded-circle"
                                            name="button"
                                        >
                                            <fa
                                                :icon="['fas', 'plus']"
                                                fixed-width
                                            />
                                        </button>
                                    </nuxt-link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="card-body mt-2 data-tables-div py-0 m-0 rounded-md"
                    >
                        <div class="col-md-12">
                            <vue-good-table
                                v-if="!$fetchState.pending"
                                mode="remote"
                                :columns="columns"
                                :rows="rows"
                                :totalRows="totalRows"
                                @on-page-change="onPageChange"
                                @on-sort-change="onSortChange"
                                @on-per-page-change="onPerPageChange"
                                :line-numbers="true"
                                :pagination-options="{
                                    mode: 'pages',
                                    enabled: true,
                                    perPage: filterData.perPage,
                                    setCurrentPage: filterData.page,
                                    nextLabel: pagination.nextLabel,
                                    prevLabel: pagination.prevLabel,
                                    rowsPerPageLabel:
                                        pagination.rowsPerPageLabel,
                                    ofLabel: pagination.ofLabel,
                                    pageLabel: pagination.pageLabel, // for 'pages' mode
                                    allLabel: pagination.allLabel,
                                }"
                                styleClass="vgt-table striped"
                                row-style-class="m-5"
                            >
                                <template slot="table-row" slot-scope="props">
                                    <div
                                        v-if="props.column.field == 'is_active'"
                                    >
                                        <div class="form-switch">
                                            <input
                                                class="form-check-input"
                                                @change="
                                                    (event) =>
                                                        changeReviewStatusStatus(
                                                            props.row.id,
                                                            event
                                                        )
                                                "
                                                :checked="
                                                    props.row.is_active == 1
                                                        ? 'checked'
                                                        : ''
                                                "
                                                type="checkbox"
                                                id="flexSwitchCheckChecked"
                                            />
                                            <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                                        </div>
                                    </div>
                                    <div
                                        v-else-if="
                                            props.column.field == 'is_default'
                                        "
                                    >
                                        <div class="form-switch">
                                            <input
                                                class="form-check-input"
                                                @change="
                                                    (event) =>
                                                        changeDefaultReviewStatus(
                                                            props.row.id,
                                                            event
                                                        )
                                                "
                                                :checked="
                                                    props.row.is_default == 1
                                                        ? 'checked'
                                                        : ''
                                                "
                                                type="checkbox"
                                                id="flexSwitchCheckChecked"
                                            />
                                            <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                                        </div>
                                    </div>
                                    <div
                                        v-else-if="
                                            props.column.field == 'actions'
                                        "
                                    >
                                        <nuxt-link
                                            v-permission="
                                                'review_statuses.index'
                                            "
                                            v-tooltip="{ content: 'Show' }"
                                            class="btn btn-sm rounded-circle text-primary"
                                            :to="
                                                localePath(
                                                    '/admin/review_statuses/view/' +
                                                        props.row.id
                                                )
                                            "
                                        >
                                            <fa
                                                :icon="['fas', 'eye']"
                                                fixed-width
                                            />
                                        </nuxt-link>
                                        <nuxt-link
                                            v-permission="
                                                'review_statuses.update'
                                            "
                                            v-tooltip="{ content: 'Edit' }"
                                            class="btn btn-sm rounded-circle text-success"
                                            :to="
                                                localePath(
                                                    '/admin/review_statuses/edit/' +
                                                        props.row.id
                                                )
                                            "
                                        >
                                            <fa
                                                :icon="['fas', 'edit']"
                                                fixed-width
                                            />
                                        </nuxt-link>
                                        <button
                                            v-permission="
                                                'review_statuses.delete'
                                            "
                                            type="button"
                                            v-tooltip="{ content: 'Delete' }"
                                            class="btn btn-sm rounded-circle text-danger"
                                            name="button"
                                            data-bs-toggle="modal"
                                            :data-bs-target="
                                                '#DeleteItem' + props.row.id
                                            "
                                        >
                                            <fa
                                                :icon="['fas', 'trash-alt']"
                                                fixed-width
                                            />
                                        </button>
                                        <AdminDeleteModal
                                            :modal_id="
                                                'DeleteItem' + props.row.id
                                            "
                                            @deleteClicked="
                                                deleteReviewStatus(props.row.id)
                                            "
                                            :delete_id="props.row.id"
                                        >
                                        </AdminDeleteModal>
                                    </div>
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
                                    </span>
                                </template>
                                <div slot="emptystate">
                                    {{ $t("table.table_empty_message") }}
                                </div>
                            </vue-good-table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import datatableMixin from "~/mixins/datatableMixin.js";
export default {
    layout: "admin",
    middleware: ["admin", "permission"],
    meta: {
        permission: "review_statuses.index",
        strategy: "read",
    },
    mixins: [datatableMixin],
    data() {
        return {
            columns: [
                {
                    label: this.$t("columns.name"),
                    field: "name",
                },
                {
                    label: this.$t("columns.status"),
                    field: "is_active",
                },
                {
                    label: this.$t("columns.is_default"),
                    field: "is_default",
                },

                {
                    label: this.$t("columns.created_at"),
                    field: "created_at",
                    sortable: false,
                    // type: 'date',
                    // dateInputFormat: 'Y-M-d',
                    // dateOutputFormat: 'MMM do yy',
                },
                {
                    label: this.$t("columns.actions"),
                    field: "actions",
                    sortable: false,
                },
            ],
        };
    },
    async fetch() {
        if (this.$gates.hasPermission("review_statuses.index")) {
            await this.fetchReviewStatuses(this.page).then();
        }
    },
    methods: {
        ...mapActions({
            fetchReviewStatuses: "ReviewStatuses/fetchReviewStatuses",
            fetchActiveReviewStatuses: "General/fetchActiveReviewStatuses",
            deleteReviewStatuses: "ReviewStatuses/deleteReviewStatuses",
            filterReviewStatuses: "ReviewStatuses/filterReviewStatuses",
            updateReviewStatusStatus: "ReviewStatuses/updateReviewStatusStatus",
            updateReviewStatusIsDefault:
                "ReviewStatuses/updateReviewStatusIsDefault",
        }),
        async exportReviewStatuses(type) {
            this.filterData.export = type;
            await this.$repositories.review_statuses.export(this.filterData);
        },
        async deleteReviewStatus(id) {
            await this.deleteReviewStatuses({
                filterData: this.filterData,
                review_status_id: id,
            })
                .then((response) => {
                    if (response.state == "fail") {
                        this.$toast.error(response.message);
                    }
                    if (response.state == "success") {
                        this.$toast.success(response.message);
                        this.fetchActiveReviewStatuses();
                    }
                })
                .catch((e) => {});
        },
        async filter() {
            await this.filterReviewStatuses(this.filterData).then(
                (response) => {
                    if (response.state == "fail") {
                        this.$toast.error(response.message);
                    }
                    if (response.state == "success") {
                    }
                }
            );
        },
        async changeReviewStatusStatus(id, event) {
            await this.updateReviewStatusStatus({
                filterData: this.filterData,
                review_status_id: id,
            })
                .then((response) => {
                    if (response.state == "fail") {
                        this.$toast.error(response.message);
                        event.target.checked = !event.target.checked;
                    }
                    if (response.state == "success") {
                        this.$toast.success(response.message);
                        this.fetchActiveReviewStatuses();
                    }
                })
                .catch((e) => {
                    event.target.checked = !event.target.checked;
                });
        },
        async changeDefaultReviewStatus(id, event) {
            await this.updateReviewStatusIsDefault({
                filterData: this.filterData,
                review_status_id: id,
            }).then((response) => {
                if (response.state == "fail") {
                    this.$toast.error(response.message);
                    event.target.checked = !event.target.checked;
                }
                if (response.state == "success") {
                    this.$toast.success(response.message);
                    this.fetchActiveReviewStatuses();
                }
            });
        },
    },

    computed: {
        ...mapGetters({
            allReviewStatuses: "ReviewStatuses/allReviewStatuses",
        }),
    },
    mounted() {},
    watch: {
        allReviewStatuses(newCount, oldCount) {
            if (
                this.allReviewStatuses &&
                this.allReviewStatuses != null &&
                this.allReviewStatuses.data != null
            ) {
                this.rows = this.allReviewStatuses.data;
                this.totalRows = this.allReviewStatuses.meta.total;
                if (
                    this.filterData.page !=
                    this.allReviewStatuses.meta.current_page
                ) {
                    this.filterData.page =
                        this.allReviewStatuses.meta.current_page;
                }
                if (
                    this.filterData.perPage !=
                    this.allReviewStatuses.meta.per_page
                ) {
                    this.filterData.perPage =
                        this.allReviewStatuses.meta.per_page;
                }
            }
        },
    },
};
</script>
