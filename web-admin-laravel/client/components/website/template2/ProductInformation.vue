<template>
  <section class="product-information">
    <!-- <div class="container">
      <div class="row">
        <div class="col-12">
          <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button
                class="nav-link active"
                id="pills-home-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-home"
                type="button"
                role="tab"
                aria-controls="pills-home"
                aria-selected="true"
              >
                Description
              </button>
            </li>
            <li
              class="nav-item"
              v-if="product.refund_policy_web"
              role="presentation"
            >
              <button
                class="nav-link"
                id="pills-profile-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-profile"
                type="button"
                role="tab"
                aria-controls="pills-profile"
                aria-selected="false"
              >
                Refund Policy
              </button>
            </li>
            <li
              class="nav-item"
              role="presentation"
              v-if="product.reviews.length > 0"
            >
              <button
                class="nav-link"
                id="pills-contact-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-contact"
                type="button"
                role="tab"
                aria-controls="pills-contact"
                aria-selected="false"
              >
                Reviews
              </button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div
              class="tab-pane fade show active"
              id="pills-home"
              role="tabpanel"
              aria-labelledby="pills-home-tab"
              v-html="product.description_web"
            ></div>
            <div
              class="tab-pane fade"
              id="pills-profile"
              role="tabpanel"
              aria-labelledby="pills-profile-tab"
              v-html="product.refund_policy_web"
            >
              >
            </div>
            <div
              class="tab-pane fade"
              id="pills-contact"
              role="tabpanel"
              aria-labelledby="pills-contact-tab"
            >
              <div>
                <div
                  class="rev-content border-bottom"
                  v-for="review in product.reviews"
                  :key="review.id"
                >
                  <div class="rating mb-2">
                    <GlobalRating :rating="review.rating" />
                  </div>
                  <p class="mb-2">
                    {{ review.description }}
                  </p>
                  <h5 class="mb-1 text-primary" v-if="review.customer">
                    {{ review.customer.name }}
                  </h5>
                  <p class="post-date mb-0 opacity-5 fs-7">
                    {{ review.rating }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <div class="accordion-single">
        <div class="accordion" id="accordionExample">
                <div class="accordion-item p-2 rounded-0">
                    <h2 class="accordion-header p-1" id="headingOne">
                    <button class="accordion-button bg-transparent shadow-none fs-5 fw-bold py-2 px-3 done" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        {{$t('web.customer.product_detail.description')}}
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body pb-2">
                        <div v-html="product.description_web" ></div>
                    </div>
                    </div>
                </div>
                <div class="accordion-item p-2 rounded-0">
                    <h2 class="accordion-header p-1" id="headingTwo">
                    <button class="accordion-button bg-transparent collapsed shadow-none fs-5 fw-bold py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                         {{$t('web.customer.product_detail.refund_policy')}}
                    </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body pb-2">
                        <div v-html="product.refund_policy_web"></div>
                    </div>
                    </div>
                </div>
                <div class="accordion-item p-2 rounded-0">
                    <h2 class="accordion-header p-1" id="headingThree">
                    <button class="accordion-button bg-transparent collapsed shadow-none fs-5 fw-bold py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                         {{$t('web.customer.product_detail.reviews')}}
                    </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body pb-2">
                            <div
                                class="rev-content border-bottom"
                                v-for="review in product.reviews"
                                :key="review.id"
                                >
                                <div class="rating mb-2">
                                    <GlobalRating :rating="review.rating" />
                                </div>
                                <p class="mb-2">
                                    {{ review.description }}
                                </p>
                                <h5 class="mb-1 text-primary" v-if="review.customer">
                                    {{ review.customer.name }}
                                </h5>
                                <p class="post-date mb-0 opacity-5 fs-7">
                                    {{ review.rating }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
  </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["product"],

};
</script>
