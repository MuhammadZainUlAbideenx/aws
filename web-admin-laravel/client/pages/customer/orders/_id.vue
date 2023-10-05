
<template>
  <section class="order-detail m-0" v-if="$fetchState.pending">
    <WebsiteGlobalComponentsBreadCrumb :page="`order_details`" />
    <!--   <WebsiteOrderFormStepsStepWidget /> -->
    <Component
      :is="`WebsiteSkeleton${currentlyActiveTemplate}OrderDetailPage`"
    />
  </section>

  <section v-else class="order-detail mt-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`order_details`" />
    <!--  <WebsiteOrderFormStepsStepWidget /> -->

    <ul
      v-if="detail.order_status.status_code != 20 && detail.sub_order ==  false"
      class="nav nav-pills order-profile-tabs mt-5 mb-5"
      id="pills-tab"
      role="tablist"
    >
      <li class="nav-item col-md-3 col-12 mb-md-0 mb-4" role="presentation">
        <button
          class="w-100 p-md-0 pe-none"
          :class="{
            active:
              detail.order_status.status_code == 0 ||
              detail.order_status.status_code > 0,
          }"
          id="pills-home-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-home"
          type="button"
          role="tab"
          aria-controls="pills-home"
          aria-selected="true"
        >
          <span class="text-dark order-head fw-bold">{{$t('web.customer.orders.filter.in_review')}}</span>
          <div class="border-top-nav position-relative mb-3">
            <div
              class="
                barIconBg
                position-absolute
                d-flex
                align-items-center
                justify-content-center
              "
            >
              <fa :icon="['fas', 'check']" fixed-width class="barIcon" />
            </div>
          </div>
          <!-- <span class="text-dark order-head"> General Information</span> -->
        </button>
      </li>
      <li class="nav-item col-md-3 col-12 mb-md-0 mb-4" role="presentation">
        <button
          class="w-100 p-md-0 pe-none"
          :class="{
            active:
              detail.order_status.status_code == 1 ||
              detail.order_status.status_code == 2 ||
              detail.order_status.status_code == 3 ||
              detail.order_status.status_code > 3,
          }"
          id="pills-home-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-home"
          type="button"
          role="tab"
          aria-controls="pills-home"
          aria-selected="true"
        >
          <span class="text-dark order-head fw-bold">{{$t('web.customer.orders.filter.in_process')}}</span>
          <div class="border-top-nav position-relative mb-3">
            <div
              class="
                barIconBg
                position-absolute
                d-flex
                align-items-center
                justify-content-center
              "
            >
              <fa :icon="['fas', 'check']" fixed-width class="barIcon" />
            </div>
          </div>
          <!-- <span class="text-dark order-head"> General Information</span> -->
        </button>
      </li>
      <li class="nav-item col-md-3 col-12 mb-md-0 mb-4" role="presentation">
        <button
          class="w-100 p-md-0 pe-none"
          :class="{
            active:
              detail.order_status.status_code == 4 ||
              detail.order_status.status_code == 5 ||
              detail.order_status.status_code > 5,
          }"
          id="pills-profile-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-profile"
          type="button"
          role="tab"
          aria-controls="pills-profile"
          aria-selected="false"
        >
          <span class="text-dark order-head fw-bold">{{$t('web.customer.orders.filter.in_transit')}}</span>
          <div class="border-top-nav position-relative mb-3">
            <div
              class="
                barIconBg
                position-absolute
                d-flex
                align-items-center
                justify-content-center
              "
            >
              <fa :icon="['fas', 'check']" fixed-width class="barIcon" />
            </div>
          </div>
        </button>
      </li>
      <li class="nav-item col-md-3 col-12 mb-md-0 mb-4" role="presentation">
        <button
          class="w-100 p-md-0 pe-none"
          :class="{
            active:
              detail.order_status.status_code == 6 ||
              (detail.order_status.status_code == 7 &&
                detail.order_status.status_code > 0),
          }"
          id="pills-contact-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-contact"
          type="button"
          role="tab"
          aria-controls="pills-contact"
          aria-selected="false"
        >
          <span class="text-dark barTxt fw-bold"> {{$t('web.customer.orders.filter.delivered')}} </span>
          <div class="border-top-nav2 position-relative mb-3">
            <div
              class="
                barIconBg
                position-absolute
                d-flex
                align-items-center
                justify-content-center
              "
            >
              <fa :icon="['fas', 'check']" fixed-width class="barIcon" />
            </div>
          </div>
        </button>
      </li>
    </ul>
   <ul
      v-else-if="detail.order_status.status_code != 20 && detail.sub_order_detail"
      class="nav nav-pills order-profile-tabs mt-4 pt-5 mb-5"
      id="pills-tab"
      role="tablist"
    >
      <li class="nav-item col-md-3 col-12 mb-md-0 mb-4" role="presentation">
        <button
          class="w-100 p-md-0 pe-none"
          :class="{
            active:
              sub_order_status == 0 ||
              sub_order_status > 0,
          }"
          id="pills-home-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-home"
          type="button"
          role="tab"
          aria-controls="pills-home"
          aria-selected="true"
        >
          <span class="text-dark order-head fw-bold">{{$t('web.customer.orders.filter.in_review')}}</span>
          <div class="border-top-nav position-relative mb-3">
            <div
              class="
                barIconBg
                position-absolute
                d-flex
                align-items-center
                justify-content-center
              "
            >
              <fa :icon="['fas', 'check']" fixed-width class="barIcon" />
            </div>
          </div>

        </button>
      </li>
      <li class="nav-item col-md-3 col-12 mb-md-0 mb-4" role="presentation">
        <button
          class="w-100 p-md-0 pe-none"
          :class="{
            active:
              sub_order_status == 1 ||
              sub_order_status == 2 ||
              sub_order_status == 3 ||
              sub_order_status > 3,
          }"
          id="pills-home-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-home"
          type="button"
          role="tab"
          aria-controls="pills-home"
          aria-selected="true"
        >
          <span class="text-dark order-head fw-bold">{{$t('web.customer.orders.filter.in_process')}}</span>
          <div class="border-top-nav position-relative mb-3">
            <div
              class="
                barIconBg
                position-absolute
                d-flex
                align-items-center
                justify-content-center
              "
            >
              <fa :icon="['fas', 'check']" fixed-width class="barIcon" />
            </div>
          </div>

        </button>
      </li>
      <li class="nav-item col-md-3 col-12 mb-md-0 mb-4" role="presentation">
        <button
          class="w-100 p-md-0 pe-none"
          :class="{
            active:
              sub_order_status == 4 ||
              sub_order_status == 5 ||
              sub_order_status > 5,
          }"
          id="pills-profile-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-profile"
          type="button"
          role="tab"
          aria-controls="pills-profile"
          aria-selected="false"
        >
          <span class="text-dark order-head fw-bold">{{$t('web.customer.orders.filter.in_transit')}}</span>
          <div class="border-top-nav position-relative mb-3">
            <div
              class="
                barIconBg
                position-absolute
                d-flex
                align-items-center
                justify-content-center
              "
            >
              <fa :icon="['fas', 'check']" fixed-width class="barIcon" />
            </div>
          </div>
        </button>
      </li>
      <li class="nav-item col-md-3 col-12 mb-md-0 mb-4" role="presentation">
        <button
          class="w-100 p-md-0 pe-none"
          :class="{
            active:
              sub_order_status == 6 ||
              (sub_order_status == 7 &&
                sub_order_status > 0),
          }"
          id="pills-contact-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-contact"
          type="button"
          role="tab"
          aria-controls="pills-contact"
          aria-selected="false"
        >
          <span class="text-dark barTxt fw-bold"> {{$t('web.customer.orders.filter.delivered')}} </span>
          <div class="border-top-nav2 position-relative mb-3">
            <div
              class="
                barIconBg
                position-absolute
                d-flex
                align-items-center
                justify-content-center
              "
            >
              <fa :icon="['fas', 'check']" fixed-width class="barIcon" />
            </div>
          </div>
        </button>
      </li>
    </ul>
    <ul
      v-else
      class="nav nav-pills order-profile-tabs mt-5 mb-5"
      id="pills-tab"
      role="tablist"
    >
      <li class="nav-item col-md-6 col-12 mb-md-0 mb-4" role="presentation">
        <button
          class="w-100 p-md-0 pe-none active"
          id="pills-home-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-home"
          type="button"
          role="tab"
          aria-controls="pills-home"
          aria-selected="true"
        >
          <span class="text-dark order-head fw-bold"
            >{{$t('web.customer.orders.filter.cancelled')}} ({{ detail.order_status_reason }})
          </span>
          <div class="border-top-danger position-relative mb-3">
            <div
              class="
                barIconBg
                position-absolute
                d-flex
                align-items-center
                justify-content-center
              "
            >
              <fa :icon="['fas', 'times']" fixed-width class="barIcon" />
            </div>
          </div>
        </button>
      </li>
      <li class="nav-item col-md-6 col-12 mb-md-0 mb-4" role="presentation">
        <button
          class="w-100 p-md-0 pe-none active"
          id="pills-home-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-home"
          type="button"
          role="tab"
          aria-controls="pills-home"
          aria-selected="true"
        >
          <span class="text-dark order-head fw-bold">&nbsp;</span>
          <div class="border-top-danger2 position-relative mb-3"></div>
          <!-- <span class="text-dark order-head"> General Information</span> -->
        </button>
      </li>
    </ul>
    <div class="container" v-if="!detail.sub_order">
      <div class="p-3 shadow rounded">
        <div class="bg-secondary px-3 py-1 mb-3">
          <div class="row py-3 border-bottom">
            <div class="col-lg-8 mb-lg-0 mb-2">
              <div class="row">
                <div class="col-md-4">
                  <span
                    v-if="detail.number"
                    class="text-primary fw-bold text_size"
                  >
                    {{$t('web.customer.orders.filter.order')}}: {{ detail.number }}</span
                  >
                </div>
                <div class="col-md-4 px-0">
                  <span class="text-success fw-bold text_size">
                    {{$t('web.customer.orders.view_page.created_date')}} &nbsp;
                    <span class="text-muted"> {{ detail.created_at }} </span>
                  </span>
                </div>
                <div class="col-md-4">
                  <span class="text-muted fw-bold text_size d-none">
                     {{$t('web.customer.orders.view_page.tracking_no')}}: &nbsp; {{ detail.number }}
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <span
                class="text-success fw-bold text_size"
                v-if="detail.vendor.store"
              >
                By: &nbsp;
                <span class="text-primary">
                  {{ detail.vendor.store.name }}
                </span>
              </span>
            </div>
            <div
              class="col-lg-2"
              v-if="
                detail.order_status.status_code == 5
              "
            >
              <div class="d-flex justify-content-lg-end align-items-center">
                <nuxt-link
                  to=""
                  class="mb-0 me-2 text-dark d-flex align-items-center"
                >
                  <fa
                    :icon="['fas', 'comments']"
                    class="me-2 text-primary fs-5"
                    fixed-width
                  /><span
                    @click="openForm(detail.rider.id,detail.number)"
                    class="text_size fw-bold dark_border letter_spacing"
                    > {{$t('web.customer.orders.view_page.chat_with_rider')}}</span
                  ></nuxt-link
                >
              </div>
            </div>
          </div>
          <div class="row">
            <div
              class="col-12"
              v-if="detail.order_products"
              v-for="product in detail.order_products"
              :key="product.id"
            >
              <WebsiteGlobalComponentsOrderDetailCard
                :detail="detail"
                :product="product"
              />
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-md-6">
            <div
              class="bg-secondary rounded px-5 py-4 mb-4"
              v-if="detail.addresses.shipping"
            >
              <h4 class="text-primary text-uppercase fw-bold pb-2">
                {{$t('form.orders.shipping_address.label')}}
              </h4>
                <div  class="d-flex align-items-center pb-1">
                  <p class="p-0 text-muted fw-bold me-5"> {{$t('form.orders.shipping_name.label')}}: </p>
                  <p class="fw-normal text-muted"> {{ detail.addresses.shipping.name }}</p>
                </div>
                <div  class="d-flex align-items-center pb-1">
                  <p class="p-0 text-muted fw-bold me-4"> {{$t('form.orders.shipping_phone.label')}}: </p>
                  <p class="fw-normal text-muted"> {{ detail.addresses.shipping.phone }}</p>
                </div>
               <div  class="d-flex pb-1">
                  <p class="p-0 text-muted fw-bold me-4">{{$t('form.orders.shipping_address.label')}}: </p>
                  <p class="fw-normal text-muted"> {{ detail.addresses.shipping.address }}</p>
                </div>
                <div class="d-flex align-items-center pb-1" v-if="detail.addresses.shipping.near_by">
                     <p class="p-0 text-muted fw-bold me-4">{{$t('form.orders.shipping_address.near_by')}}: </p>
                    <p class="fw-normal text-muted"> {{ detail.addresses.shipping.near_by }}</p>
                </div>
            </div>
            <div
              class="bg-secondary rounded px-5 py-4 mb-md-0 mb-4"
              v-if="detail.addresses.billing"
            >
              <h4 class="text-primary text-uppercase fw-bold pb-2">
                {{$t('form.orders.billing_address.label')}}
              </h4>
                <div  class="d-flex align-items-center pb-1">
                  <p class="p-0 text-muted fw-bold me-4"> {{$t('form.orders.billing_name.label')}}: </p>
                  <p class="fw-normal text-muted"> {{ detail.addresses.billing.name }}</p>
                </div>
                <div  class="d-flex align-items-center pb-1" >
                  <p class="p-0 text-muted fw-bold me-2">{{$t('form.orders.billing_phone.label')}}: </p>
                  <p class="fw-normal text-muted ">   {{ detail.addresses.billing.phone }}</p>
                </div>
                <div  class="d-flex pb-1">
                  <p class="p-0 text-muted fw-bold me-2">{{$t('form.orders.billing_address.label')}}: </p>
                  <p class="fw-normal text-muted ">  {{ detail.addresses.billing.address }}</p>
                </div>
                <div  class="d-flex align-items-center pb-1" v-if="detail.addresses.billing.near_by">
                  <p class="p-0 text-muted fw-bold me-2">{{$t('form.orders.billing_address.near_by')}}: </p>
                  <p class="fw-normal text-muted">  {{ detail.addresses.billing.near_by }}</p>
                </div>

            </div>
          </div>
          <div class="col-md-6">
            <div class="greenBg rounded py-3 px-2 h-100">
              <div class="text-primary border-bottom mb-2">
                <h4 class="text-primary text-uppercase fw-bold px-4 py-2">
                  {{$t('form.orders.order_time_currency_display_total.label')}}
                </h4>
              </div>
              <div class="px-4 py-3 border-bottom">
                <div
                  class="d-flex align-items-center justify-content-between pb-1"
                >
                  <p class="p-0 text-muted">{{$t('form.orders.order_time_currency_display_sub_total.label')}}</p>
                  <p class="p-0 text-muted">
                    {{ detail.order_time_currency_display_sub_total_1 }}
                  </p>
                </div>
                <div
                  class="d-flex align-items-center justify-content-between pb-1"
                >
                  <p class="p-0 text-muted">{{$t('web.customer.orders.view_page.shipping_fee')}}</p>
                  <p class="p-0 text-muted">
                    {{ detail.order_time_currency_shipping_price_1 }}
                  </p>
                </div>
                <div
                  class="d-flex align-items-center justify-content-between pb-1"
                  v-if="detail.coupon"
                >
                  <p class="p-0 text-muted">{{$t('form.orders.discount.label')}}</p>
                  <p class="p-0 text-muted">
                  {{ detail.discount_amount }}
                  </p>
                </div>
                <!-- <div class="d-flex align-items-center justify-content-between">
                  <p class="p-0 text-muted">Tax</p>
                  <p class="p-0 text-muted">$2</p>
                </div> -->
              </div>

              <div class="px-4 py-4">
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="text-muted fw-bold"> {{$t('form.orders.order_time_currency_display_total.label')}}</h5>
                  <h5 class="text-primary fw-bold">
                    {{ detail.order_time_currency_display_total }}
                  </h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container" v-else>
      <!----Accordion starts ---->
      <div
        class=""
        v-for="sub_order in detail.sub_order_detail"
        :key="sub_order.id"
      >
        <div class="bg-secondary px-3 py-1 mb-3">
          <div
            class="accordion accordion-flush"
            :id="`accordionFlushExample${sub_order.id}`"
          >
            <div class="accordion-item">
              <h2
                class="accordion-header"
                :id="`flush-headingOne${sub_order.id}`"
              >
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  :data-bs-target="`#flush-collapseOne${sub_order.id}`"
                  aria-expanded="false"
                  aria-controls="flush-collapseOne"
                >
                  <div class="row py-3 w-100 align-items-center">
                    <div class="col-md-3">
                      <span
                        v-if="sub_order.number"
                        class="text-primary fw-bold text_size"
                      >
                       {{$t('web.customer.orders.view_page.consignment_number')}}: {{ sub_order.number }}</span
                      >
                    </div>
                    <div class="col-md-2">
                      <span class="text-success fw-bold text_size">
                         {{$t('web.customer.orders.view_page.price')}} &nbsp;
                        <span class="text-muted">
                          {{ sub_order.order_time_currency_display_sub_total_1 }}
                        </span>
                      </span>
                    </div>
                    <div class="col-md-2">
                      <span class="text-success fw-bold text_size">
                        {{$t('web.customer.orders.view_page.order_status')}} &nbsp;
                        <span class="text-muted">
                          {{ sub_order.order_status.name }}
                        </span>
                      </span>
                    </div>
                    <div class="col-md-2">
                      <span
                        class="text-success fw-bold text_size"
                        v-if="sub_order.vendor.store"
                      >
                        {{$t('web.customer.orders.view_page.by')}}: &nbsp;
                        <span class="text-primary">
                          {{ sub_order.vendor.store.name }}
                        </span>
                      </span>
                    </div>

                    <div class="col-md-3">
                      <div
                        class="d-flex justify-content-lg-end align-items-center"
                        v-if="
                          sub_order.order_status.status_code == 5
                        "
                      >
                        <nuxt-link
                          to=""
                          class="mb-0 me-2 text-dark d-flex align-items-center"
                        >
                          <fa
                            :icon="['fas', 'comments']"
                            class="me-2 text-primary fs-5"
                            fixed-width
                          /><span
                            @click="openForm(sub_order.rider.id,sub_order.number)"
                            class="text_size fw-bold dark_border letter_spacing"
                            >{{$t('web.customer.orders.view_page.chat_with_rider')}}</span
                          ></nuxt-link
                        >
                      </div>
                    </div>
                  </div>
                </button>
              </h2>
              <div
                :id="`flush-collapseOne${sub_order.id}`"
                class="accordion-collapse collapse"
                aria-labelledby="flush-headingOne"
                :data-bs-parent="`#accordionFlushExample${sub_order.id}`"
              >
                <div class="accordion-body">
                  <div class="row">
                    <div
                      class="col-12"
                      v-if="sub_order.order_products"
                      v-for="product in sub_order.order_products"
                      :key="product.id"
                    >
                      <WebsiteGlobalComponentsOrderDetailCard
                        :detail="sub_order"
                        :product="product"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!------Accordion ends---->
      <div class="p-0 rounded">
        <div class="row mt-0">
          <div class="col-md-6">
            <div
              class="bg-secondary rounded px-5 py-4 mb-4"
              v-if="detail.addresses.shipping"
            >
              <h4 class="text-primary text-uppercase fw-bold pb-2">
                {{$t('form.orders.shipping_address.label')}}
              </h4>
              <h4 class="fw-normal text-muted pb-1">
                {{ detail.addresses.shipping.name }}
              </h4>
              <p class="text-muted text_size fw-bold mb-1">
                {{ detail.addresses.shipping.address }}
              </p>
              <p class="text-muted text_size fw-bold m-0">
                {{ detail.addresses.shipping.phone }}
              </p>
            </div>

            <div
              class="bg-secondary rounded px-5 py-4 mb-md-0 mb-4"
              v-if="detail.addresses.shipping"
            >
              <h4 class="text-primary text-uppercase fw-bold pb-2">
                {{$t('form.orders.billing_address.label')}}
              </h4>
              <h4 class="fw-normal text-muted pb-1">
                {{ detail.addresses.billing.name }}
              </h4>
              <p class="text-muted text_size fw-bold mb-1">
                {{ detail.addresses.billing.address }}
              </p>
              <p class="text-muted text_size fw-bold m-0">
                {{ detail.addresses.billing.phone }}
              </p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="greenBg rounded py-3 px-2 h-100">
              <div class="text-primary border-bottom mb-2">
                <h4 class="text-primary text-uppercase fw-bold px-4 py-2">
                  {{$t('form.orders.order_time_currency_display_total.label')}}
                </h4>
              </div>
              <div class="px-4 py-3 border-bottom">
                <div
                  class="d-flex align-items-center justify-content-between pb-1"
                >
                  <p class="p-0 text-muted">{{$t('form.orders.order_time_currency_display_sub_total.label')}}</p>
                  <p class="p-0 text-muted">
                    {{ detail.order_time_currency_display_sub_total_1 }}
                  </p>
                </div>
                <div
                  class="d-flex align-items-center justify-content-between pb-1"
                >
                  <p class="p-0 text-muted">{{$t('web.customer.orders.view_page.shipping_fee')}}</p>
                  <p class="p-0 text-muted">
                    {{ detail.order_time_currency_shipping_price_1 }}
                  </p>
                </div>
                <div
                  class="d-flex align-items-center justify-content-between pb-1"
                  v-if="detail.coupon"
                >
                  <p class="p-0 text-muted">{{$t('form.orders.discount.label')}}</p>
                  <p class="p-0 text-muted">
                    {{ detail.discount_amount }}
                  </p>
                </div>
                <!-- <div class="d-flex align-items-center justify-content-between">
                  <p class="p-0 text-muted">Tax</p>
                  <p class="p-0 text-muted">$2</p>
                </div> -->
              </div>

              <div class="px-4 py-4">
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="text-muted fw-bold">{{$t('form.orders.order_time_currency_display_total.label')}}</h5>
                  <h5 class="text-primary fw-bold">
                    {{ detail.order_time_currency_display_total }}
                  </h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="chat-popup" id="myForm">
      <div class="form-container">
        <div
          class="
            bg-primary
            rounded-top
            d-flex
            align-items-center
            p-3
            position-relative
          "
        >
          <h4 class="text-white mb-0">{{$t('web.customer.orders.view_page.chat')}}</h4>
          <button
            type="button"
            class="btn-close position-absolute end-0 top-0 me-2 mt-2"
            @click="closeForm()"
          ></button>
        </div>

        <div class="chat-history bg-white py-2"  v-chat-scroll>
          <ul
            class="mb-0 list-group list-unstyled"
            v-for="message in messages"
            :key="message.id"

          >
            <li
              v-if="$auth.user.id == message.sender_id"
              class="
                clearfix
                list-style-none
                m-2
                p-2
                px-3
                ms-5
                rounded
                bg-info bg-opacity-10
                text-muted
              "
            >
              <div class="message-data text-end">
                <!-- <span class="message-data-time"
                                      >{{message.created_at}}</span
                                    > -->
              </div>
              <div class="message other-message float-end text-break">
                {{ message.message }}
              </div>
            </li>
            <li
              v-else
              class="
                clearfix
                list-style-none
                m-2
                p-2
                px-3
                me-5
                rounded-pill
                bg-warning bg-opacity-10
                text-muted
              "
            >
              <div class="message-data">
                <!-- <span class="message-data-time"
                                      >{{message.created_at}}</span
                                    > -->
              </div>
              <div class="message my-message text-break">
                {{ message.message }}
              </div>
            </li>
          </ul>
        </div>
        <!-- <label for="msg"><b>Message</b></label> -->
        <div class="position-relative p-2 border-top">
          <input
            type="text"
            placeholder="Type Message..."
            class="form-control"
            @keyup.enter="sendRiderMessage"
            v-model="newMessage"
          />
          <button type="button" v-on:click="sendRiderMessage" class="btn">
            <fa :icon="['fa', 'paper-plane']" />
          </button>
        </div>
      </div>
    </div>
    <WebsiteTemplate1NewsLetterSection />
  </section>
</template>


<script>
import { mapGetters, mapActions } from "vuex";
export default {
  auth: false,
  data() {
    return {
      currentlyActiveTemplate: "",
      key: 1,
      detail: {},
      seo: {},
      order_id: this.$route.params.id,
      messages: [],
      newMessage: "",
      sub_order_status: "",
      selected_chat_rider_id:"",
      selected_chat_consignment_number:"",
    };
  },
  head() {
    return this.seo;
  },
  async fetch() {
    const { data } = await this.$webService.CustomerOrderDetail(
      this.$route.params.id
    );
    this.detail = data;
this.detail.sub_order_detail.forEach((value) => {
    if (value.order_status.status_code == 1 || value.order_status.status_code == 2 || value.order_status.status_code == 3 || value.order_status.status_code == 4 || value.order_status.status_code == 5 || value.order_status.status_code == 6 || value.order_status.status_code == 7){
        this.sub_order_status = value.order_status.status_code;
    }
});
  },
  created() {
    this.$echo.channel(this.$config.PUSHER_APP_CHANNEL_NAME).listen(this.$config.PUSHER_APP_EVENT_NAME, (e) => {
      if (e.message.receiver_id == this.$auth.user.id  && e.message.order_number == this.selected_chat_consignment_number) {
        this.messages.push({
          message: e.message.message,
          receiver_id: e.message.receiver_id,
        });
      }
    });
    this.currentlyActiveTemplate =
      this.allSettings.general_settings.currently_active_theme;
  },
  methods: {
    openForm(rider_id,consignment_number) {
        this.selected_chat_rider_id = rider_id
        this.selected_chat_consignment_number = consignment_number
      this.fetchRiderMessages(rider_id);
      document.getElementById("myForm").style.display = "block";
    },
    closeForm() {
      document.getElementById("myForm").style.display = "none";
    },
    async sendRiderMessage() {
      if (this.newMessage != "") {
        var message = this.newMessage;
        this.newMessage = "";
        this.messages.push({
          message: message,
          sender_id: this.$auth.user.id,
        });

        var payload = {
          sender_id: this.$auth.user.id,
          receiver_id: this.selected_chat_rider_id,
          message: message,
          user_type: "customer",
          order_number: this.selected_chat_consignment_number,
        };

        await this.$webService.sendMessage(payload).then(async (res) => {});
      } else {
        this.$toast.error("Please Type Message");
      }
    },
    async fetchRiderMessages(rider_id) {
      const params = {
        sender_id: this.$auth.user.id,
        receiver_id: rider_id,
        user_type: "customer",
        order_number: this.selected_chat_consignment_number,
      };
      const { data } = await this.$webService.fetchMessages(params);
      if (data) {
        this.messages = data;
      }
    },
  },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
};
</script>


<style scoped>
body {
  font-family: Arial, Helvetica, sans-serif;
}
* {
  box-sizing: border-box;
}

/* Button used to open the chat form - fixed at the bottom of the page */

/* The popup chat - hidden by default */
.chat-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  z-index: 9;
  border-radius: 0.4rem 0.4rem 0 0;
  box-shadow: 0 0 1rem 0 rgba(0, 0, 0, 0.1);
  background-color: white;
}
.chat-popup .chat-history {
  max-height: 380px;
  overflow: hidden auto;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
}

/* Full-width textarea */
.form-container textarea {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
  resize: none;
  min-height: 200px;
}

/* When the textarea gets focus, do something */
.form-container textarea:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/send button */
.form-container .btn {
  position: absolute;
  top: 8px;
  right: 8px;
  color: var(--primary);
  font-size: 1.2rem;
}
.form-container .form-control {
  padding-right: 2.5rem;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover,
.open-button:hover {
  opacity: 1;
}
</style>
