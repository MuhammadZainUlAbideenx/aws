<template>
  <section class="product-information">
    <div class="container">
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
               {{$t('web.customer.product_detail.description')}}
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
             {{$t('web.customer.product_detail.refund_policy')}}
              </button>
            </li>
            <!-- v-if="product.reviews.length > 0 " -->
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
               {{$t('web.customer.product_detail.reviews')}}
              </button>
            </li>
          </ul>
          <div class="tab-content mt-1" id="pills-tabContent">
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
              <!-- <div class="row">
                <div class="col-lg-8 pe-4 rightBorde">
                  <div class="row my-4">
                    <div class="col-md-4">
                      <p class="fw-bold h5 pb-1 ps-1">Product Rating</p>
                      <div class="d-flex align-items-center">
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <p class="fw-bold h5 pb-1 ps-1">Seller Rating</p>
                      <div class="d-flex align-items-center">
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <p class="fw-bold h5 pb-1 ps-1">Delivery Boy Rating</p>
                      <div class="d-flex align-items-center">
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                        <fa
                          :icon="['far', 'star']"
                          fixed-width
                          class="pe-2 h2 text-warning"
                        />
                      </div>
                    </div>
                  </div>
                  <p class="fw-bold h5 pb-2 ps-2">Write a Comment</p>
                  <div class="form-floating">
                    <textarea
                      class="form-control h4"
                      placeholder="Leave a comment here"
                      id="floatingTextarea2"
                      style="height: 100px; border: 0"
                    ></textarea>
                    <label for="floatingTextarea2"
                      >Tell us about your experience</label
                    >
                  </div>
                </div>
                <div class="col-lg-4 py-4 ps-4">
                  <p class="fw-bold h5 pb-1 text-center m-0">
                    Upload Your Images
                  </p>
                  <div class="row py-4">
                    <div class="col-4">
                      <div class="img-wrap">
                        <img
                          class="img-fluid"
                          src="~/assets/images/flash-product-img2.jpg"
                          alt=""
                        />
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="img-wrap">
                        <img
                          class="img-fluid"
                          src="~/assets/images/flash-product-img2.jpg"
                          alt=""
                        />
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="upload-btn-wrapper">
                        <button class="btn">
                          <img
                            class="img-fluid"
                            src="~/assets/images/uploader.png"
                            alt=""
                          />
                        </button>
                        <input type="file" accept="image/*" />
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-primary w-100 py-2 mt-3">
                    Submit
                  </button>
                </div>
              </div> -->
              <!-- BackEnd -->
              <!-- <div class="d-flex align-items-center float-end" v-if="$auth.loggedIn && $gates.hasRole('customer') ">
                             <nuxt-link to="" class="mb-0 me-2 text-dark">  <fa :icon="['far', 'smile']" class="me-2 text-primary" fixed-width />Write a review</nuxt-link>
                        </div> -->
              <div >
                <div
                  class="rev-content border-bottom"
                  v-for="review in product.reviews"
                  :key="review.id"
                >
                 <h5 class="mb-1 text-primary" v-if="review.customer">
                    {{ review.customer.name }}
                  </h5>
                  <div class="rating mb-2">
                    <GlobalRating :rating="review.rating" />
                  </div>
                  <p class="mb-2">
                    {{ review.description }}
                  </p>
                    <div v-if="review.images_url && review.images_url.length>0" >
                        <img class="mx-2" v-for="image_url in review.images_url" :key="image_url" height="100px" width="100px" :src="`/backend${image_url}`" alt="">
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  props: ["product"],
   created()
  {
  }
};
</script>
