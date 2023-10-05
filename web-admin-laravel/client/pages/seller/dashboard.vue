<template >
  <div class="" v-if="!this.$auth.user.store">
    <SellerShopSettings />
  </div>
  <div class="" v-else-if="!this.$auth.user.is_active">
    <SellerShopDeactive />
  </div>
      <section v-else-if="$fetchState.pending" class="my-profile-page m-0">
     <AdminLoader />
  </section>
  <div v-else
    class="content d-flex flex-column flex-column-fluid my-5"
    id="tc_content"
  >
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
      <!--begin::Container-->
      <div class="container-fluid mb-5">
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-lg-6 col-xl-3">
                <div
                  class="card card-custom gutter-b theme-circle theme-circle-primary shadow"
                >
                  <div
                    class="card-body border-bottom border-success border-4 row mx-0"
                  >
                    <div class="col-8">
                      <h3 class="text-body font-weight-bold heebo-medium">
                        {{ this.$t("admin.dashboard.text1") }}
                      </h3>
                      <div class="">
                        <div class="d-flex align-items-center">
                          <span class="font-weight-bold font-size-h1 mr-3"
                            ><span
                              class="counter heebo-medium"
                              data-target="400"
                              >{{dashboardData ? dashboardData.orders:0}}</span
                            ></span
                          >
                        </div>
                      </div>
                    </div>
                    <div
                      class="col-4 d-flex align-items-baseline justify-content-end"
                    >
                      <span class="shadow rounded-circle p-3">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="20px"
                          height="20px"
                          viewBox="0 0 24 24"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          class="feather feather-globe"
                        >
                          <circle cx="12" cy="12" r="10"></circle>
                          <line x1="2" y1="12" x2="22" y2="12"></line>
                          <path
                            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"
                          ></path>
                        </svg>
                      </span>
                    </div>

                    <div class="mt-3">
                      {{ this.$t("admin.dashboard.text2") }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-xl-3">
                <div
                  class="card card-custom gutter-b theme-circle theme-circle-primary shadow"
                >
                  <div
                    class="card-body border-bottom border-danger border-4 row mx-0"
                  >
                    <div class="col-8">
                      <h3 class="text-body font-weight-bold heebo-medium">
                        {{ this.$t("admin.dashboard.text3") }}
                      </h3>
                      <div class="">
                        <div class="d-flex align-items-center">
                          <span class="font-weight-bold font-size-h1 mr-3"
                            ><span
                              class="counter heebo-medium"
                              data-target="400"
                              >{{dashboardData ? dashboardData.products:0}}</span
                            ></span
                          >
                        </div>
                      </div>
                    </div>
                    <div
                      class="col-4 d-flex align-items-baseline justify-content-end"
                    >
                      <span class="shadow rounded-circle p-3">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="20px"
                          height="20px"
                          viewBox="0 0 24 24"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          class="feather feather-globe"
                        >
                          <circle cx="12" cy="12" r="10"></circle>
                          <line x1="2" y1="12" x2="22" y2="12"></line>
                          <path
                            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"
                          ></path>
                        </svg>
                      </span>
                    </div>

                    <div class="mt-3">
                      {{ this.$t("admin.dashboard.text4") }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-xl-3">
                <div
                  class="card card-custom gutter-b theme-circle theme-circle-primary shadow"
                >
                  <div
                    class="card-body row border-bottom border-info border-4 mx-0"
                  >
                    <div class="col-8">
                      <h3 class="text-body font-weight-bold heebo-medium">
                        {{ this.$t("admin.dashboard.text6") }}
                      </h3>
                      <div class="">
                        <div class="d-flex align-items-center">
                          <span class="font-weight-bold font-size-h1 mr-3"
                            ><span
                              class="counter heebo-medium"
                              data-target="400"
                              >{{dashboardData ? dashboardData.customers:0}}</span
                            ></span
                          >
                        </div>
                      </div>
                    </div>
                    <div
                      class="col-4 d-flex align-items-baseline justify-content-end"
                    >
                      <span class="shadow rounded-circle p-3">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="20px"
                          height="20px"
                          viewBox="0 0 24 24"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          class="feather feather-globe"
                        >
                          <circle cx="12" cy="12" r="10"></circle>
                          <line x1="2" y1="12" x2="22" y2="12"></line>
                          <path
                            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"
                          ></path>
                        </svg>
                      </span>
                    </div>

                    <div class="mt-3">
                      {{ this.$t("admin.dashboard.text7") }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-xl-3">
                <div
                  class="card card-custom gutter-b theme-circle theme-circle-primary shadow"
                >
                  <div
                    class="card-body border-bottom border-warning border-4 row mx-0"
                  >
                    <div class="col-8">
                      <h3 class="text-body font-weight-bold heebo-medium">
                        {{ this.$t("admin.dashboard.text8") }}
                      </h3>
                      <div class="">
                        <div class="d-flex align-items-center">
                          <span class="font-weight-bold font-size-h1 mr-3"
                            ><span
                              class="counter heebo-medium"
                              data-target="400"
                              >{{dashboardData ? dashboardData.sales:0}}</span
                            ></span
                          >
                        </div>
                      </div>
                    </div>
                    <div
                      class="col-4 d-flex align-items-baseline justify-content-end"
                    >
                      <span class="shadow rounded-circle p-3">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="20px"
                          height="20px"
                          viewBox="0 0 24 24"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          class="feather feather-globe"
                        >
                          <circle cx="12" cy="12" r="10"></circle>
                          <line x1="2" y1="12" x2="22" y2="12"></line>
                          <path
                            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"
                          ></path>
                        </svg>
                      </span>
                    </div>

                    <div class="mt-3">
                      {{ this.$t("admin.dashboard.text9") }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <div class="row">
              <div class="col-lg-6 col-xl-9">
                <div class="card gutter-b border-0">
                  <div class="card-header align-items-center border-0">
                    <div class="card-title mb-0">
                      <!-- <h3 class="card-label text-body font-weight-bold mb-0">
                        {{ this.$t("admin.dashboard.text6") }}
                      </h3> -->
                    </div>
                  </div>
                  <div class="card-body p-4">
                    <div>
                      <div id="chart">
        <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
      </div>

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 col-xl-3 d-flex align-items-stretch">
                <div class="card gutter-b border-0">
                  <div class="card-header align-items-center border-0">
                    <div class="card-title mb-0">
                      <h3 class="card-label text-body font-weight-bold mb-0">
                        {{ this.$t("admin.dashboard.text10") }}
                      </h3>
                    </div>
                  </div>
                  <div class="card-body p-4">
                    <ul class="list-group scrollbar-1" style="height: 300px">
                      <li
                        class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2"
                      >
                        <div class="list-left d-flex align-items-center">
                          <span
                            class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-primary text-white mr-2"
                          >
                            <svg
                              width="20px"
                              height="20px"
                              viewBox="0 0 16 16"
                              class="bi bi-lightning-fill"
                              fill="currentColor"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"
                              />
                            </svg>
                          </span>
                          <div class="list-content ps-3">
                            <span class="list-title text-body">{{
                              this.$t("admin.dashboard.text12")
                            }}</span>
                          </div>
                        </div>
                        <span>{{ dashboardData.products ? dashboardData.products:0 }} </span>
                      </li>
                      <li
                        class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2"
                      >
                        <div class="list-left d-flex align-items-center">
                          <span
                            class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-secondary text-white mr-2"
                          >
                            <svg
                              width="20px"
                              height="20px"
                              viewBox="0 0 16 16"
                              class="bi bi-bar-chart-line-fill"
                              fill="currentColor"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z"
                              />
                            </svg>
                          </span>
                          <div class="list-content ps-3">
                            <span class="list-title text-body"
                              >{{ this.$t("admin.dashboard.text15") }}
                            </span>

                          </div>
                        </div>
                        <span>{{ dashboardData.sales ? dashboardData.sales:0 }}  </span>
                      </li>

                      <li
                        class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2"
                      >
                        <div class="list-left d-flex align-items-center">
                          <span
                            class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-warning text-white mr-2"
                          >
                            <svg
                              width="20px"
                              height="20px"
                              viewBox="0 0 16 16"
                              class="bi bi-lightning-fill"
                              fill="currentColor"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"
                              />
                            </svg>
                          </span>
                          <div class="list-content ps-3">
                            <span class="list-title text-body"
                              >{{ this.$t("admin.dashboard.text21") }}
                            </span>
                          </div>
                        </div>
                        <span>{{ dashboardData.customers ? dashboardData.customers:0 }} </span>
                      </li>
                      <!-- <li
                        class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-2"
                      >
                        <div class="list-left d-flex align-items-center">
                          <span
                            class="d-flex align-items-center justify-content-center rounded svg-icon w-45px h-45px bg-info text-white mr-2"
                          >
                            <svg
                              width="20px"
                              height="20px"
                              viewBox="0 0 16 16"
                              class="bi bi-lightning-fill"
                              fill="currentColor"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"
                              />
                            </svg>
                          </span>
                          <div class="list-content ps-3">
                            <span class="list-title text-body">{{
                              this.$t("admin.dashboard.text24")
                            }}</span>
                            <small class="text-muted d-block">{{
                              this.$t("admin.dashboard.text25")
                            }}</small>
                          </div>
                        </div>
                        <span>{{ this.$t("admin.dashboard.text26") }} </span>
                      </li> -->
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="row">
              <div class="col-sm-12">
                <div class="card gutter-b border-0">
                  <div class="card-header d-flex justify-content-between align-items-center  border-0">
  													<div class="card-title mb-0">
  														<h3 class="card-label font-weight-bold mb-0 text-body">Forms
  														</h3>
  													</div>

  												</div>
                  <div class="card-body pt-3">
                    <div class="container py-5">
                      <div class="row">
                        <div class="col-md-6 my-1">
                          <div role="group ">
                            <label for="input-live" class="form-label"
                              >{{ this.$t("admin.dashboard.text27") }} :</label
                            >

                            <input
                              aria-describedby="input-live-help input-live-feedback"
                              placeholder="lorem_ipsum"
                              trim=""
                              class="form-control"
                            />
                            <span class="heebo-light"
                              >{{ this.$t("admin.dashboard.text28") }}
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6 my-1">
                          <div role="group">
                            <label for="input-live" class="form-label"
                              >{{ this.$t("admin.dashboard.text29") }} :</label
                            >

                            <input
                              aria-describedby="input-live-help input-live-feedback"
                              placeholder="lorem_ipsum"
                              trim=""
                              class="form-control"
                            />
                            <span class="heebo-light">
                              {{ this.$t("admin.dashboard.text31") }}
                            </span>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 my-1">
                          <div role="group ">
                            <label for="input-live" class="form-label"
                              >{{ this.$t("admin.dashboard.text30") }}
                            </label>

                            <input
                              aria-describedby="input-live-help input-live-feedback"
                              placeholder="lorem_ipsum"
                              trim=""
                              class="form-control"
                            />
                            <span class="heebo-light">
                              {{ this.$t("admin.dashboard.text31") }}
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6 my-1">
                          <div role="group">
                            <label for="input-live" class="form-label"
                              >{{ this.$t("admin.dashboard.text31") }}
                            </label>
                                    <input
                              aria-describedby="input-live-help input-live-feedback"
                              placeholder="lorem_ipsum"
                              trim=""
                              class="form-control"
                            />
                            <span class="heebo-light"> lorem_ipsum </span>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 my-1">
                          <div role="group ">
                            <label for="input-live" class="form-label">{{
                              this.$t("admin.dashboard.text31")
                            }}</label>

                            <input
                              aria-describedby="input-live-help input-live-feedback"
                              placeholder="lorem_ipsum"
                              trim=""
                              class="form-control"
                            />
                            <span class="heebo-light">
                              {{ this.$t("admin.dashboard.text31") }}
                            </span>
                          </div>
                        </div>
                        <div class="col-md-6 my-1">
                          <div role="group">
                            <label for="input-live" class="form-label">
                              {{ this.$t("admin.dashboard.text31") }}
                            </label>

                            <input
                              aria-describedby="input-live-help input-live-feedback"
                              placeholder="lorem_ipsum"
                              trim=""
                              class="form-control"
                            />
                            <span class="heebo-light"> lorem_ipsum </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

            <!-- <div class="row">
              <div class="col-sm-12">
                <div class="card gutter-b border-0">
                  <div class="card-header d-flex justify-content-between align-items-center border-0">
                    <div class="card-title mb-0">
                      <h3 class="card-label mb-0 font-weight-bold text-body">
                        {{ this.$t("admin.dashboard.text31") }}
                      </h3>
                    </div>
                    <div class="card-toolbar">
                      <button
                        class="btn p-0"
                        type="button"
                        id="dropdownMenuButton"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        <span class="svg-icon">
                          <svg
                            width="20px"
                            height="20px"
                            viewBox="0 0 16 16"
                            class="bi bi-three-dots text-body"
                            fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"
                            />
                          </svg>
                        </span>
                      </button>
                      <div
                        class="dropdown-menu dropdown-menu-right"
                        aria-labelledby="dropdownMenuButton"
                      >
                        <a class="dropdown-item" href="#"
                          >{{ this.$t("admin.dashboard.text34") }}
                        </a>
                        <a class="dropdown-item" href="#"
                          >{{ this.$t("admin.dashboard.text32") }}
                        </a>
                        <a class="dropdown-item" href="#"
                          >{{ this.$t("admin.dashboard.text32") }}
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div>
                      <client-only>
                      <vue-good-table
                        mode="remote"
                        :columns="columns"
                        :rows="rows"
                        :line-numbers="true"
                        :pagination-options="{
                          mode: 'pages',
                          enabled: true,
                        }"
                        styleClass="vgt-table striped"
                        row-style-class="m-5"
                      />
                    </client-only>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";

export default {
  layout: "vendor",
  middleware: "vendor",
  async fetch(){
   await this.$generalService.getSellerDashboardData().then((res) => {
      this.dashboardData = res
    this.setGraphData();

    }).catch();
       this.fetchActiveMedia();

  },

  data() {
    return {
      dashboardData:null,
      columns: [
        {
          label: "Name",
          field: "name",
        },
        {
          label: "Age",
          field: "age",
        },
        {
          label: "Created On",
          field: "createdAt",
          dateInputFormat: "yyyy-MM-dd",
          dateOutputFormat: "MMM do yy",
        },
        {
          label: "Percent",
          field: "score",
        },
      ],
      rows: [
        { id: 1, name: "John", age: 20, createdAt: "", score: 0.03343 },
        {
          id: 2,
          name: "Jane",
          age: 24,
          createdAt: "2011-10-31",
          score: 0.03343,
        },
        {
          id: 3,
          name: "Susan",
          age: 16,
          createdAt: "2011-10-30",
          score: 0.03343,
        },
        {
          id: 4,
          name: "Chris",
          age: 55,
          createdAt: "2011-10-11",
          score: 0.03343,
        },
        {
          id: 5,
          name: "Dan",
          age: 40,
          createdAt: "2011-10-21",
          score: 0.03343,
        },
        {
          id: 6,
          name: "John",
          age: 20,
          createdAt: "2011-10-31",
          score: 0.03343,
        },
      ],
       series: [{
            name: 'Sales',
            data: []
          }],
          chartOptions: {
            chart: {
              height: 350,
              type: 'line',
            },
            stroke: {
              width: 7,
              curve: 'smooth'
            },
            xaxis: {
              type: 'datetime',
              categories: [],
              tickAmount: 10,
              labels: {
                formatter: function(value, timestamp, opts) {
                  return opts.dateFormatter(new Date(timestamp), 'dd MMM')
                }
              }
            },
            title: {
              text: 'Total Sales',
              align: 'left',
              style: {
                fontSize: "16px",
                color: '#666'
              }
            },
            fill: {
              type: 'gradient',
              gradient: {
                shade: 'dark',
                gradientToColors: [ '#022785'],
                shadeIntensity: 1,
                type: 'horizontal',
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100, 100, 100]
              },
            },
            markers: {
              size: 4,
              colors: ["#FFA41B"],
              strokeColors: "#fff",
              strokeWidth: 2,
              hover: {
                size: 7,
              }
            },
            yaxis: {
              min: '',
              max: '',
              title: {
                text: 'Engagement',
              },
            }
          },
    };
  },
  methods: {
      ...mapActions({
      fetchActiveMedia: 'General/fetchActiveMedia',
    }),
    setGraphData()
    {
       this.chartOptions.yaxis.min = this.dashboardData.min_sale_amount
        this.chartOptions.yaxis.max = this.dashboardData.max_sale_amount
        this.chartOptions.xaxis.categories = []
        this.series[0].data = []
        for (let index = 0; index < this.dashboardData.sales_details.length; index++) {
        const element =  this.dashboardData.sales_details[index];
        this.series[0].data.push(element.current_currency_sub_total)
        this.chartOptions.xaxis.categories.push(element.created_at)

      }
    }
  },
};
</script>
