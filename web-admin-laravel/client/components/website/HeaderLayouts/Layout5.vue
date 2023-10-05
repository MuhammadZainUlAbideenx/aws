<template>
  <header class="header_layout_five bg-primary">
    <div class="top-bar ">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-3 col-6 mb-dropdown ">


            <div class="logo">
              <nuxt-link to="/" v-if="allSettings.general_settings.name_or_logo == 1">
                <img :src="`/backend${allSettings.general_settings.logo_dark.original_media_path}`" class="" alt="..."
                  v-if="
                    this.themeData.dark &&
                    allSettings.general_settings.logo_dark
                  " />
                <img :src="`/backend${allSettings.general_settings.logo_dark.original_media_path}`" class="" alt="..."
                  v-else-if="allSettings.general_settings.logo" />
                <h2 v-else>{{ allSettings.general_settings.web_name }}</h2>
              </nuxt-link>
              <nuxt-link to="/" v-else>
                <h2>{{ allSettings.general_settings.web_name }}</h2>
              </nuxt-link>
            </div>


            <div class="d-flex align-items-center h-100 me-4 mb-dropdown-1 d-none">
                <div class="dropdown">
                  <a class="
                  dropdown-toggle
                  d-flex
                  flex-row
                  align-items-center
                  h-100
                  text-white

                  pt-0
                  border-0
                " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="img-wrap me-1">
                      <!-- <img width="23"
                        :src="`/backend/api/flags/png100px/${currentLocale.code}.png`"
                        alt=""
                        /> -->
                    </div>
                    <span class="text-capitalize">{{
                    this.currentLocale.code
                    }}</span>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li v-for="locale in availableLocales" :key="locale.code" @click="changeLocale(locale.code)">
                      <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="img-wrap me-2">
                          <img class="h-auto w-20px rounded-sm" :src="`/backend/api/flags/png100px/${locale.code}.png`"
                            alt="" />
                        </div>
                        {{ locale.name }}
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="dropdown ms-3">
                  <a class="
                  dropdown-toggle
                  d-flex
                  flex-row
                  align-items-center
                  h-100
                  text-white
                  ps-2
                  border-0
                " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ this.currentCurrency.code }}
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li v-for="currency in availableCurrencies" @click="changeCurrency(currency.code)"
                      :key="currency.code">
                      <a class="dropdown-item" href="#">{{ currency.name }}</a>
                    </li>
                  </ul>
                </div>
              </div>



          </div>
          <div class="col-lg-6 col-md-5 d-flex justify-content-center align-items-center col-12 search-order d-none d-md-block">
            <form action="" class="inputgrp-width mx-auto">
              <div class="input-group position-relative">
                <input type="text" class="form-control rounded" placeholder="" aria-label="Recipient's username"
                  aria-describedby="button-addon2">
              <div class="position-absolute svg-search">
                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="530px" height="50px"><path d="M 21 3 C 11.654545 3 4 10.654545 4 20 C 4 29.345455 11.654545 37 21 37 C 24.701287 37 28.127393 35.786719 30.927734 33.755859 L 44.085938 46.914062 L 46.914062 44.085938 L 33.875 31.046875 C 36.43682 28.068316 38 24.210207 38 20 C 38 10.654545 30.345455 3 21 3 z M 21 5 C 29.254545 5 36 11.745455 36 20 C 36 28.254545 29.254545 35 21 35 C 12.745455 35 6 28.254545 6 20 C 6 11.745455 12.745455 5 21 5 z"/></svg>
              </div>
              </div>
            </form>
          </div>
          <div class="col-lg-3 col-md-4 col-12 my-3">
            <div class="d-flex align-items-center h-100 justify-content-end mb-center">
              <div class="d-flex align-items-center h-100 me-4 d-none d-md-flex">
                <div class="dropdown">
                  <a class="
                  dropdown-toggle
                  d-flex
                  flex-row
                  align-items-center
                  h-100
                  text-white

                  pt-0
                  border-0
                " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="img-wrap me-1">
                      <!-- <img width="23"
                        :src="`/backend/api/flags/png100px/${currentLocale.code}.png`"
                        alt=""
                        /> -->
                    </div>
                    <span class="text-capitalize">{{
                    this.currentLocale.code
                    }}</span>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li v-for="locale in availableLocales" :key="locale.code" @click="changeLocale(locale.code)">
                      <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="img-wrap me-2">
                          <img class="h-auto w-20px rounded-sm" :src="`/backend/api/flags/png100px/${locale.code}.png`"
                            alt="" />
                        </div>
                        {{ locale.name }}
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="dropdown ms-3">
                  <a class="
                  dropdown-toggle
                  d-flex
                  flex-row
                  align-items-center
                  h-100
                  text-white
                  ps-2
                  border-0
                " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ this.currentCurrency.code }}
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li v-for="currency in availableCurrencies" @click="changeCurrency(currency.code)"
                      :key="currency.code">
                      <a class="dropdown-item" href="#">{{ currency.name }}</a>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="top-site-icons">
              <ul id="navAccordion" class="
                  m-0
                  p-0
                  d-flex
                  flex-row
                  align-items-center
                  justify-content-end
                  list-unstyled
                ">
                <li class="
                    border-light
                    d-none
                    ps-5
                    search-card
                    d-flex
                    align-items-end
                    flex-row flex-lg-column
                  " v-click-outside="externalClick">
                  <a id="search-input" data-bs-target="#cartcollapse2" data-bs-toggle="collapse" href="#cartcollapse2"
                    role="button" aria-expanded="false" aria-controls="cartcollapse2">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                      xmlns:svgjs="http://svgjs.com/svgjs" width="23" height="23" x="0" y="0"
                      viewBox="0 0 512.005 512.005" style="enable-background: new 0 0 512 512" xml:space="preserve"
                      class="text-white">
                      <g>
                        <g xmlns="http://www.w3.org/2000/svg">
                          <g>
                            <path
                              d="M505.749,475.587l-145.6-145.6c28.203-34.837,45.184-79.104,45.184-127.317c0-111.744-90.923-202.667-202.667-202.667    S0,90.925,0,202.669s90.923,202.667,202.667,202.667c48.213,0,92.48-16.981,127.317-45.184l145.6,145.6    c4.16,4.16,9.621,6.251,15.083,6.251s10.923-2.091,15.083-6.251C514.091,497.411,514.091,483.928,505.749,475.587z     M202.667,362.669c-88.235,0-160-71.765-160-160s71.765-160,160-160s160,71.765,160,160S290.901,362.669,202.667,362.669z"
                              fill="currentColor" data-original="currentColor" class=""></path>
                          </g>
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                      </g>
                    </svg>
                  </a>
                  <div class="collapse collapse-menu cart-items-container" id="cartcollapse2" aria-labelledby="cart"
                    data-bs-parent="#navAccordion">
                    <button class="btn-close" type="button" data-bs-toggle="collapse" data-bs-target="#cartcollapse2"
                      aria-expanded="false" aria-controls="cartcollapse2"></button>
                    <div class="list-head px-0 rounded cart-items-container bg-transparent">
                      <div class="search w-100">
                        <div class="bg-secondary p-3 rounded">
                          <input type="text" @input="searchWebProducts($event.target.value)" autocomplete="off"
                            :placeholder="
                              this.$t('web.home.navbar.search.placeholder')
                            " v-model="search_product" class="form-control bg-white border rounded py-2 px-3" />
                        </div>
                        <div id="demo-autosuggest-autosuggest__results" class="autosuggest__results-container"
                          v-if="searchedProducts.length > 0">
                          <div class="autosuggest__results">
                            <ul class="data-darren">
                              <li id="demo-autosuggest-Human" v-for="(product, index) in searchedProducts" :key="index">
                                <div class="row g-0 align-items-center">
                                  <div class="col-xl-4 col-4 pe-3 h-100">
                                    <div class="img-wrap rounded">
                                      <img :src="`/backend${product.media[0].original_media_path}`"
                                        alt="DSADASDSDFDSFsdsddf" class="w-sm-100 img-fluid rounded"
                                        v-if="product.media.length > 0" />
                                      <img v-else src="~/assets/images/defult-product-img.png" alt="" />
                                    </div>
                                  </div>
                                  <div class="col-xl-8 col-8 h-100">
                                    <div class="row g-0 align-items-center">
                                      <div class="
                                          col-xl-8 col-md-9 col-9
                                          h-100
                                          d-flex
                                          align-items-center
                                        ">
                                        <div class="card-body ps-0 py-3">
                                          <div class="rating mb-2">
                                            <GlobalRating :rating="
                                              product.reviews_average_rating
                                            " />
                                          </div>
                                          <nuxt-link :to="'/product/' + product.slug">
                                            <h6 @click="resetSearchResult" class="mb-1">
                                              {{ product.name }}
                                            </h6>
                                          </nuxt-link>

                                          <div class="
                                              product-price
                                              d-flex
                                              align-items-start
                                              justify-content-start
                                              text-muted
                                              flex-column
                                            ">
                                            <span class="fs-12 me-1" v-for="(
                                                category, index
                                              ) in product.categories" :key="index">{{ category.name }}
                                            </span>
                                            <span v-if="product.flash_sale">
                                              <span class="price fw-normal">{{
                                              product.flash_sale
                                              .display_price
                                              }}
                                              </span>
                                              <span class="actual-price fw-normal">{{
                                              product.display_price
                                              }}</span>
                                            </span>
                                            <span v-else-if="product.special_sale">
                                              <span class="price fw-normal">{{
                                              product.special_sale
                                              .display_price
                                              }}</span>
                                              <span class="actual-price fw-normal">{{
                                              product.display_price
                                              }}</span>
                                            </span>
                                            <span v-else-if="product.is_variable">
                                              <span class="price fw-normal">{{
                                              product.starting_from_price
                                              }}</span>
                                            </span>
                                            <span v-else>
                                              <span class="price fw-normal">{{
                                              product.display_price
                                              }}</span>
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="
                                          col-xl-4 col-md-3 col-3
                                          p-xl-2
                                          pb-3
                                          d-xl-flex
                                          justify-content-end
                                        ">
                                        <button @click="addToCart(product)" class="
                                            btn btn-primary
                                            py-1
                                            px-2
                                            text-white
                                            rounded
                                            fw-bold
                                          ">
                                          <fa :icon="['fas', 'shopping-bag']" class="" />
                                          <!-- {{ $t("cart") }} -->
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div v-if="search_product != '' && searchedProducts.length == 0 && !loading">
                          <div class="autosuggest__results-container text-center">
                            {{ this.$t("web.home.search.no_searched_data") }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div v-if="$auth.loggedIn && $gates.hasRole('customer')" class="logout">
                    <a class="
                        dropdown-toggle
                        d-flex
                        flex-row
                        align-items-center
                        h-100
                        text-body
                        border-left-c3
                      " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <img v-if="$auth.user.profile_image_path" class="rounded-circle border profile-photo w-100"
                        v-bind:src="url + `${$auth.user.profile_image_path}`" alt="profile_image" />
                      <img v-else src="~/assets/images/profile.jpg" class="rounded-circle border profile-photo w-100" />
                      <!-- {{ $auth.user.name }} -->
                    </a>
                    <div class="dropdown-menu profile-dropdown">
                      <nuxt-link :to="localePath('/customer/orders')" class="dropdown-item d-flex align-items-center">
                        <fa icon="shopping-cart" fixed-width class="me-1 fs-6" />
                        {{ $t("orders") }}
                      </nuxt-link>
                      <nuxt-link to="/customer/profile" class="dropdown-item d-flex align-items-center">
                        <fa icon="user-circle" fixed-width class="me-1 fs-6" />
                        {{ $t("my_profile") }}
                      </nuxt-link>
                      <nuxt-link to="/customer/wallet" class="dropdown-item d-flex align-items-center">
                        <fa icon="wallet" fixed-width class="me-1 fs-6" />
                        {{ $t("wallet") }}
                      </nuxt-link>
                      <nuxt-link to="/Compare" class="dropdown-item d-flex align-items-center">
                        <fa icon="exchange-alt" fixed-width class="me-1 fs-6" />
                        {{ $t("Compare") }}
                      </nuxt-link>
                      <nuxt-link to="/WishList" class="dropdown-item d-flex align-items-center">
                        <fa icon="heart" fixed-width class="me-1 fs-6" />
                        {{ $t("Wishlist") }}
                      </nuxt-link>

                      <div class="dropdown-divider" />
                      <a class="dropdown-item d-flex align-items-center" href="#" @click.prevent="logout">
                        <fa icon="sign-out-alt" fixed-width class="me-1 fs-6" />
                        {{ $t("logout") }}
                      </a>
                    </div>
                  </div>

                  <div v-else class="">
                    <nuxt-link :to="localePath('/login')" class="d-flex flex-row align-items-center h-100 text-body border-left-c2">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:svgjs="http://svgjs.com/svgjs" width="23" height="23" x="0" y="0" viewBox="0 0 512 512"
                        style="enable-background: new 0 0 512 512" xml:space="preserve" class="text-white">
                        <g>
                          <g xmlns="http://www.w3.org/2000/svg">
                            <g>
                              <path
                                d="M256,0c-74.439,0-135,60.561-135,135s60.561,135,135,135s135-60.561,135-135S330.439,0,256,0z M256,240    c-57.897,0-105-47.103-105-105c0-57.897,47.103-105,105-105c57.897,0,105,47.103,105,105C361,192.897,313.897,240,256,240z"
                                fill="currentColor" data-original="currentColor" class=""></path>
                            </g>
                          </g>
                          <g xmlns="http://www.w3.org/2000/svg">
                            <g>
                              <path
                                d="M423.966,358.195C387.006,320.667,338.009,300,286,300h-60c-52.008,0-101.006,20.667-137.966,58.195    C51.255,395.539,31,444.833,31,497c0,8.284,6.716,15,15,15h420c8.284,0,15-6.716,15-15    C481,444.833,460.745,395.539,423.966,358.195z M61.66,482c7.515-85.086,78.351-152,164.34-152h60    c85.989,0,156.825,66.914,164.34,152H61.66z"
                                fill="currentColor" data-original="currentColor" class=""></path>
                            </g>
                          </g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                        </g>
                      </svg>
                    </nuxt-link>
                  </div>
                </li>
                <!-- login end -->
                <li>
                  <nuxt-link to="/wishlist" class="nav-toggle position-relative" id="wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                      xmlns:svgjs="http://svgjs.com/svgjs" width="23" height="23" x="0" y="0" viewBox="0 0 512.001 512"
                      style="enable-background: new 0 0 512 512" xml:space="preserve" class="text-white">
                      <g transform="matrix(1,0,0,1,0,30)">
                        <path xmlns="http://www.w3.org/2000/svg"
                          d="m256 455.515625c-7.289062 0-14.316406-2.640625-19.792969-7.4375-20.683593-18.085937-40.625-35.082031-58.21875-50.074219l-.089843-.078125c-51.582032-43.957031-96.125-81.917969-127.117188-119.3125-34.644531-41.804687-50.78125-81.441406-50.78125-124.742187 0-42.070313 14.425781-80.882813 40.617188-109.292969 26.503906-28.746094 62.871093-44.578125 102.414062-44.578125 29.554688 0 56.621094 9.34375 80.445312 27.769531 12.023438 9.300781 22.921876 20.683594 32.523438 33.960938 9.605469-13.277344 20.5-24.660157 32.527344-33.960938 23.824218-18.425781 50.890625-27.769531 80.445312-27.769531 39.539063 0 75.910156 15.832031 102.414063 44.578125 26.191406 28.410156 40.613281 67.222656 40.613281 109.292969 0 43.300781-16.132812 82.9375-50.777344 124.738281-30.992187 37.398437-75.53125 75.355469-127.105468 119.308594-17.625 15.015625-37.597657 32.039062-58.328126 50.167969-5.472656 4.789062-12.503906 7.429687-19.789062 7.429687zm-112.96875-425.523437c-31.066406 0-59.605469 12.398437-80.367188 34.914062-21.070312 22.855469-32.675781 54.449219-32.675781 88.964844 0 36.417968 13.535157 68.988281 43.882813 105.605468 29.332031 35.394532 72.960937 72.574219 123.476562 115.625l.09375.078126c17.660156 15.050781 37.679688 32.113281 58.515625 50.332031 20.960938-18.253907 41.011719-35.34375 58.707031-50.417969 50.511719-43.050781 94.136719-80.222656 123.46875-115.617188 30.34375-36.617187 43.878907-69.1875 43.878907-105.605468 0-34.515625-11.605469-66.109375-32.675781-88.964844-20.757813-22.515625-49.300782-34.914062-80.363282-34.914062-22.757812 0-43.652344 7.234374-62.101562 21.5-16.441406 12.71875-27.894532 28.796874-34.609375 40.046874-3.453125 5.785157-9.53125 9.238282-16.261719 9.238282s-12.808594-3.453125-16.261719-9.238282c-6.710937-11.25-18.164062-27.328124-34.609375-40.046874-18.449218-14.265626-39.34375-21.5-62.097656-21.5zm0 0"
                          fill="currentColor" data-original="currentColor" class=""></path>
                      </g>
                    </svg>
                    <!-- <fa :icon="['far', 'heart']" /> -->

                    <div class="
                        d-flex
                        flex-column
                        ps-0
                        text-uppercase text-white
                        cart-new cart-new-sec
                        bg-primary
                      ">
                      <!-- <span class="head">{{
                        this.$t("web.home.navbar.wishlist")
                      }}</span> -->
                      <span class="number text-white" v-if="
                        allWishlistItems && allWishlistItems.meta.total > 0
                      ">{{
                        allWishlistItems ? allWishlistItems.meta.total : 0
                        }}
                      </span>
                    </div>
                    <!-- <div class="position-absolute badge-position">
                      <span class="badge bg-primary"></span>
                    </div> -->
                  </nuxt-link>
                </li>
                <li class="me-0">
                  <a class="dropdown-toggle nav-toggle position-relative" id="cart" data-bs-target="#cartcollapse"
                    data-bs-toggle="collapse" href="#cartcollapse" role="button" aria-expanded="false"
                    aria-controls="cartcollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                      xmlns:svgjs="http://svgjs.com/svgjs" width="23" height="23" x="0" y="0" viewBox="0 0 489 489"
                      style="enable-background: new 0 0 512 512" xml:space="preserve" class="text-white">
                      <g>
                        <g xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M440.1,422.7l-28-315.3c-0.6-7-6.5-12.3-13.4-12.3h-57.6C340.3,42.5,297.3,0,244.5,0s-95.8,42.5-96.6,95.1H90.3   c-7,0-12.8,5.3-13.4,12.3l-28,315.3c0,0.4-0.1,0.8-0.1,1.2c0,35.9,32.9,65.1,73.4,65.1h244.6c40.5,0,73.4-29.2,73.4-65.1   C440.2,423.5,440.2,423.1,440.1,422.7z M244.5,27c37.9,0,68.8,30.4,69.6,68.1H174.9C175.7,57.4,206.6,27,244.5,27z M366.8,462   H122.2c-25.4,0-46-16.8-46.4-37.5l26.8-302.3h45.2v41c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5v-41h139.3v41   c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5v-41h45.2l26.9,302.3C412.8,445.2,392.1,462,366.8,462z"
                            fill="currentColor" data-original="currentColor" class=""></path>
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                        <g xmlns="http://www.w3.org/2000/svg"></g>
                      </g>
                    </svg>
                    <!-- <fa :icon="['far', 'shopping-bag fa-fw']" /> -->
                    <div class="
                        d-flex
                        flex-column
                        ps-0
                        text-uppercase text-white
                        cart-new
                        bg-primary
                      ">
                      <!-- <span class="head"
                        >{{ this.$t("web.home.navbar.cart.heading") }}
                      </span> -->
                      <span class="number text-white" v-if="
                        allCartItems && allCartItems.total_items_count > 0
                      ">
                         <div class="position-absolute badge-position-1">
                      <span class="badge bg-white"></span>
                    </div></span>
                    </div>

                  </a>
                  <div class="collapse collapse-menu cart-items-container" id="cartcollapse" aria-labelledby="cart"
                    data-bs-parent="#navAccordion">
                    <button class="btn-close" type="button" data-bs-toggle="collapse" data-bs-target="#cartcollapse"
                      aria-expanded="false" aria-controls="cartcollapse"></button>
                    <div class="list-head rounded cart-items-container">
                      <div class="item-detail cart-items-container">
                        <h6 class="cart-items-container">
                          {{ $t("items")
                          }}<span class="cart-items-container">{{
                          allCartItems ? allCartItems.total_items_count : 0
                          }}</span>
                        </h6>
                      </div>
                      <div class="item-img">
                        <nuxt-link to="/cart">
                          {{ this.$t("web.home.navbar.cart.view") }}
                        </nuxt-link>
                      </div>
                    </div>
                    <ul v-if="allCartItems" class="cart-items-container">
                      <li v-for="cart_item in allCartItems.cart_items" :key="cart_item.id">
                        <div class="item-detail cart-items-container">
                          <h6 class="cart-items-container">
                            <nuxt-link :to="`/product/${cart_item.product.slug}`" class="cart-items-container">
                              {{ cart_item.product.name }}
                            </nuxt-link>
                          </h6>
                          <div class="item-s cart-items-container">
                            {{ cart_item.quantity }} x
                            {{ cart_item.single_price }}
                          </div>
                        </div>
                        <div class="
                            item-img
                            img-wrap
                            flex-shrink-0
                            cart-items-container
                          " v-if="
                            cart_item.product.media &&
                            cart_item.product.media[0] &&
                            cart_item.product.media[0].thumbnails
                          ">
                          <img class="img-fluid cart-items-container"
                            :src="`/backend${cart_item.product.media[0].thumbnails.small.thumbnail}`"
                            alt="Product Image" />
                        </div>
                        <div class="item-img img-wrap v cart-items-container" v-else>
                          <img class="img-fluid cart-items-container" src="~/assets/images/defult-product-img.png"
                            alt="Product Image" />
                        </div>
                        <div class="item-remove cart-items-container" @click="removeFromCart(cart_item.id)">
                          <span class="btn-close cart-items-container"></span>
                        </div>
                      </li>
                    </ul>
                    <div v-if="
                      allCartItems &&
                      allCartItems.cart_items.length > 0 &&
                      $auth.loggedIn &&
                      $gates.hasRole('customer')
                    " class="
                        d-flex
                        flex-column
                        text-center
                        p-4
                        cart-items-container
                      ">
                      <button type="button" v-on:click="proceedToCheckout" class="
                          btn btn-primary
                          shadow-none
                          border-0
                          px-3
                          py-2
                          text-white
                          rounded
                          text-uppercase
                          d-none d-lg-block
                        ">
                        {{ this.$t("proceed_to_checkout") }}
                      </button>
                    </div>
                    <div v-else class="d-flex flex-column text-center p-4">
                      <button v-if="
                        allCartItems && allCartItems.cart_items.length > 0
                      " type="button" class="
                          btn btn-primary
                          shadow-none
                          border-0
                          px-3
                          py-2
                          text-white
                          rounded
                          text-uppercase
                          d-none d-lg-block
                        " name="button" data-bs-toggle="modal" data-dismiss="cart" data-bs-target="#DeleteItem24">
                        {{ this.$t("proceed_to_checkout") }}
                      </button>
                      <WebsiteOrderFormStepsTemplate1AuthModalSidebar />
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            </div>


          </div>
        </div>
      </div>
    </div>








    <div class="bottom-nav">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-3 col-6 d-none d-md-block">
            <div class="dropdown">
              <button class="border-0 bg-transparent position-relative dropdown-toggle" type="button"
                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" >
                {{
                        this.$t("web.home.navbar.categories.text")
                      }}
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"  v-if=" allMegaMenuItems && allMegaMenuItems.categories_1 ">
                     <li
                     class="dropdown-item"
                                    v-for="category in allMegaMenuItems.categories_1"
                                    :key="category.id"
                                  >
                                    <nuxt-link
                                      :to="{
                                        path: '/shop',
                                        query: { category: category.slug },
                                      }"
                                      >{{ category.name }}</nuxt-link
                                    >
                     </li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-12 order-small-c">
            <nav class="navbar navbar-expand-md py-0">

              <button class="navbar-toggler ps-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-white">
                  <svg data-v-709ec6b1="" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars"
                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                    class="me-3 svg-inline--fa fa-bars fa-w-14">
                    <path data-v-709ec6b1="" fill="currentColor"
                      d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"
                      class=""></path>
                  </svg>
                </span>
              </button>
              <div class="top-menu d-flex flex-row justify-content-end d-none" v-if="!$auth.loggedIn">
              <div class="info d-flex flex-row flex-row justify-content-end">
                <div
                  v-if="$auth.loggedIn && $gates.hasRole('customer')"
                  class="logout"
                >
                  <a
                    class="
                      dropdown-toggle
                      d-flex
                      flex-row
                      align-items-center
                      h-100
                      text-body
                    "
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <img
                      v-if="$auth.user.profile_image_path"
                      class="rounded-circle border profile-photo me-2"
                      v-bind:src="url + `${$auth.user.profile_image_path}`"
                      alt="profile_image"
                    />
                    <img
                      v-else
                      src="~/assets/images/profile.jpg"
                      class="rounded-circle border profile-photo me-2"
                    />
                    {{ $auth.user.name }}
                  </a>
                  <div class="dropdown-menu">
                    <nuxt-link
                      :to="localePath('/customer/orders')"
                      class="dropdown-item d-flex align-items-center"
                    >
                      <fa icon="shopping-cart" fixed-width class="me-1 fs-6" />
                      {{ $t("orders") }}
                    </nuxt-link>
                    <nuxt-link
                      to="/customer/profile"
                      class="dropdown-item d-flex align-items-center"
                    >
                      <fa icon="user-circle" fixed-width class="me-1 fs-6" />
                      {{ $t("my_profile") }}
                    </nuxt-link>
                    <nuxt-link
                      to="/customer/wallet"
                      class="dropdown-item d-flex align-items-center"
                    >
                      <fa icon="wallet" fixed-width class="me-1 fs-6" />
                      {{ $t("wallet") }}
                    </nuxt-link>
                    <nuxt-link
                      to="/Compare"
                      class="dropdown-item d-flex align-items-center"
                    >
                      <fa icon="exchange-alt" fixed-width class="me-1 fs-6" />
                      {{ $t("Compare") }}
                    </nuxt-link>
                    <nuxt-link
                      to="/WishList"
                      class="dropdown-item d-flex align-items-center"
                    >
                      <fa icon="heart" fixed-width class="me-1 fs-6" />
                      {{ $t("Wishlist") }}
                    </nuxt-link>

                    <div class="dropdown-divider" />
                    <a
                      class="dropdown-item d-flex align-items-center"
                      href="#"
                      @click.prevent="logout"
                    >
                      <fa icon="sign-out-alt" fixed-width class="me-1 fs-6" />
                      {{ $t("logout") }}
                    </a>
                  </div>
                </div>

                <!-- <div v-else class="login">
                  <nuxt-link
                    :to="localePath('/login')"
                    class="d-flex flex-row align-items-center h-100 text-body"
                  >
                    {{ $t("login.login") }}
                  </nuxt-link>
                </div> -->
                <div class="register">
                  <a
                    class="
                      ps-2
                      d-flex
                      flex-row
                      align-items-center
                      h-100
                      text-white
                    "
                    v-if="
                      allSettings &&
                      allSettings.general_settings &&
                      allSettings.general_settings.is_multi_vendor == 1
                    "
                    href="/seller/login"
                    >{{ $t("become_a_seller") }}</a
                  >
                </div>

                <!-- <div
                  class="call-us"
                  v-if="
                    allSettings &&
                    allSettings.general_settings &&
                    allSettings.general_settings.contact_number
                  "
                >
                  <div
                    class="
                      d-flex
                      flex-row
                      align-items-center
                      h-100
                      text-capitalize
                    "
                  >
                    {{ $t("call_us_toll_free") }}:
                    <span class="text-primary ms-1">{{
                      allSettings.general_settings.contact_number
                    }}</span>
                  </div>
                </div> -->
              </div>
            </div>
              <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                <ul class="navbar-nav nav-links">
                  <li class="nav-item home-item dropdown">
                    <nuxt-link to="/" class="nav-link px-lg-3 text-uppercase text-white">
                      {{ this.$t("web.home.navbar.home.heading") }}
                    </nuxt-link>
                  </li>
                  <li class="nav-item shop-item dropdown">
                    <nuxt-link to="/shop" class="nav-link px-lg-3 text-uppercase text-white">
                      {{ this.$t("web.home.navbar.shop") }}
                    </nuxt-link>
                  </li>
                  <li class="nav-item vendors-item dropdown" v-if="
                    allSettings &&
                    allSettings.general_settings &&
                    allSettings.general_settings.is_multi_vendor == 1
                  ">
                    <nuxt-link class="nav-link px-lg-3 text-uppercase text-white" to="/stores">{{
                    this.$t("web.home.navbar.stores")
                    }}
                    </nuxt-link>
                  </li>
                  <li class="nav-item vendors-item dropdown">
                    <nuxt-link class="nav-link px-lg-3 text-uppercase text-white" to="/brands">{{
                    this.$t("web.home.navbar.brands")
                    }}
                    </nuxt-link>
                  </li>

                  <li class="nav-item blog-item dropdown">
                    <nuxt-link to="/blog" class="nav-link px-lg-3 text-uppercase text-white">
                      {{ this.$t("web.home.navbar.blog") }}
                    </nuxt-link>
                  </li>
                  <li class="nav-item about-item dropdown">
                    <nuxt-link to="/aboutus" class="nav-link px-lg-3 text-uppercase text-white">
                      {{ this.$t("web.home.navbar.about") }}
                    </nuxt-link>
                  </li>
                  <li class="nav-item contact-item dropdown">
                    <nuxt-link to="/contact" class="nav-link px-lg-3 text-uppercase text-white">
                      {{ this.$t("web.home.navbar.contact") }}
                    </nuxt-link>
                  </li>
                </ul>
              </div>

            </nav>
          </div>
          <div class="col-md-3 col-6 d-none d-md-block">
            <div class="top-menu d-flex flex-row justify-content-end d-none d-md-block" v-if="!$auth.loggedIn">
              <div class="info d-flex flex-row flex-row justify-content-end">
                <div
                  v-if="$auth.loggedIn && $gates.hasRole('customer')"
                  class="logout"
                >
                  <a
                    class="
                      dropdown-toggle
                      d-flex
                      flex-row
                      align-items-center
                      h-100
                      text-body
                    "
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <img
                      v-if="$auth.user.profile_image_path"
                      class="rounded-circle border profile-photo me-2"
                      v-bind:src="url + `${$auth.user.profile_image_path}`"
                      alt="profile_image"
                    />
                    <img
                      v-else
                      src="~/assets/images/profile.jpg"
                      class="rounded-circle border profile-photo me-2"
                    />
                    {{ $auth.user.name }}
                  </a>
                  <div class="dropdown-menu">
                    <nuxt-link
                      :to="localePath('/customer/orders')"
                      class="dropdown-item d-flex align-items-center"
                    >
                      <fa icon="shopping-cart" fixed-width class="me-1 fs-6" />
                      {{ $t("orders") }}
                    </nuxt-link>
                    <nuxt-link
                      to="/customer/profile"
                      class="dropdown-item d-flex align-items-center"
                    >
                      <fa icon="user-circle" fixed-width class="me-1 fs-6" />
                      {{ $t("my_profile") }}
                    </nuxt-link>
                    <nuxt-link
                      to="/customer/wallet"
                      class="dropdown-item d-flex align-items-center"
                    >
                      <fa icon="wallet" fixed-width class="me-1 fs-6" />
                      {{ $t("wallet") }}
                    </nuxt-link>
                    <nuxt-link
                      to="/Compare"
                      class="dropdown-item d-flex align-items-center"
                    >
                      <fa icon="exchange-alt" fixed-width class="me-1 fs-6" />
                      {{ $t("Compare") }}
                    </nuxt-link>
                    <nuxt-link
                      to="/WishList"
                      class="dropdown-item d-flex align-items-center"
                    >
                      <fa icon="heart" fixed-width class="me-1 fs-6" />
                      {{ $t("Wishlist") }}
                    </nuxt-link>

                    <div class="dropdown-divider" />
                    <a
                      class="dropdown-item d-flex align-items-center"
                      href="#"
                      @click.prevent="logout"
                    >
                      <fa icon="sign-out-alt" fixed-width class="me-1 fs-6" />
                      {{ $t("logout") }}
                    </a>
                  </div>
                </div>

                <!-- <div v-else class="login">
                  <nuxt-link
                    :to="localePath('/login')"
                    class="d-flex flex-row align-items-center h-100 text-body"
                  >
                    {{ $t("login.login") }}
                  </nuxt-link>
                </div> -->
                <div class="register">
                  <a
                    class="
                      ps-2
                      d-flex
                      flex-row
                      align-items-center
                      h-100
                      text-white
                    "
                    v-if="
                      allSettings &&
                      allSettings.general_settings &&
                      allSettings.general_settings.is_multi_vendor == 1
                    "
                    href="/seller/login"
                    >{{ $t("become_a_seller") }}</a
                  >
                </div>

                <!-- <div
                  class="call-us"
                  v-if="
                    allSettings &&
                    allSettings.general_settings &&
                    allSettings.general_settings.contact_number
                  "
                >
                  <div
                    class="
                      d-flex
                      flex-row
                      align-items-center
                      h-100
                      text-capitalize
                    "
                  >
                    {{ $t("call_us_toll_free") }}:
                    <span class="text-primary ms-1">{{
                      allSettings.general_settings.contact_number
                    }}</span>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  components: {

  },
  props: ["themeData"],
  created() { },
  mounted() {
    var compare_products = JSON.parse(localStorage.getItem("compare_products"));
    if (compare_products && compare_products.length > 0) {
      if (!this.allCompareProducts) {
        this.fetchCompareProducts({ compare_ids: compare_products });
      }
    }
    $(document).ready(function () {
      $(document).click(function (event) {
        var clickover = $(event.target);
        if (!clickover.hasClass("cart-items-container")) {
          document.getElementById("cartcollapse").classList.remove("show");
        }
      });
    });
  },
  async fetch() {
    if (!this.allMegaMenuItems) {
      await this.fetchMegaMenuItems();
    }
  },
  data() {
    return {
      url: "/backend",
      megaMenudata: {},
      appName: process.env.appName,
      error: false,
      searchedProducts: [],
      search_product: "",
      loading: false
    };
  },

  computed: {
    ...mapGetters({
      allLanguages: "Web/General/allLanguages",
      allCurrencies: "Web/General/allCurrencies",
      allDefaultSettings: "allDefaultSettings",
      allCartItems: "Web/Cart/allCartItems",
      allWishlistItems: "Web/Wishlist/allWishlistItems",
      allMegaMenuItems: "Web/General/allMegaMenuItems",
      allSettings: "allDefaultSettings",
      allCompareProducts: "Web/General/allCompareProducts",
    }),
    availableLocales() {
      return this.allLanguages.filter((i) => i.code !== this.$i18n.locale);
    },
    currentLocale() {
      return this.allLanguages.find((i) => i.code == this.$i18n.locale);
    },
    availableCurrencies() {
      var currency = this.$cookies.get("currency");
      if (!currency) {
        currency = this.allDefaultSettings.currency.code;
        this.$cookies.set("currency", currency);
      }
      const current = this.allCurrencies.find(
        (i) => i.code.toLowerCase() == currency.toLowerCase()
      );
      if (current) {
        return this.allCurrencies.filter(
          (i) => i.code.toLowerCase() !== currency.toLowerCase()
        );
      } else {
        const default_currency = this.allDefaultSettings.currency;
        this.$cookies.set("currency", default_currency.code);
        return this.allCurrencies.filter(
          (i) => i.code.toLowerCase() !== default_currency.code.toLowerCase()
        );
      }
    },
    currentCurrency() {
      var currency = this.$cookies.get("currency");
      if (!currency) {
        currency = this.allDefaultSettings.currency.code;
        this.$cookies.set("currency", currency);
      }
      const current = this.allCurrencies.find(
        (i) => i.code.toLowerCase() == currency.toLowerCase()
      );
      if (current) {
        return current;
      } else {
        this.$cookies.set("currency", this.allDefaultSettings.currency.code);
        return this.allDefaultSettings.currency;
      }
    },
  },



  methods: {
    ...mapActions({
      fetchCartItems: "Web/Cart/fetchCartItems",
      wishlistItemsOnLogout: "Web/Wishlist/wishlistItemsOnLogout",
      fetchMegaMenuItems: "Web/General/fetchMegaMenuItems",
      fetchCompareProducts: "Web/General/fetchCompareProducts",
    }),
    searchShop(e) {
      this.$store.commit("Web/General/updateShopSearch", e.target.value);
      if (this.$router.currentRoute.path != "/shop") {
        this.$router.replace({
          path: "/shop",
          query: { search: e.target.value },
        });
      }
    },
    async removeFromCart(cart_id) {
      await this.$webService.removeCartItem(cart_id).then(async (res) => {
        await this.fetchCartItems();
        this.$toast.success(res.message);
      });
    },
    changeCurrency(currency) {
      const current = this.allCurrencies.find(
        (i) => i.code.toLowerCase() == currency.toLowerCase()
      );
      if (current) {
        this.$cookies.set("currency", currency);
        this.$router.go();
      }
    },
    async changeLocale(locale) {
      const check = this.$i18n.locales.find((i) => i.code == locale);
      if (check) {
        await this.$i18n.setLocale(locale);
        var language = this.allLanguages.find((i) => i.code == locale);
        this.$emit("change_direction", language.direction);
        this.$router.go();
      }
    },
    async logout() {
      this.error = null;
      await this.$auth
        .logout("customer")
        .then(async () => {
          await this.$gates.setRoles([]);
          await this.$gates.setPermissions([]);
          this.$toast.success("You are logged out now");
          this.$router.replace("/login");
          this.wishlistItemsOnLogout();
          await this.fetchCartItems();
        })
        .catch((e) => (this.error = e.response.data));
    },
    proceedToCheckout() {
      this.$router.replace(this.localePath("/ProductOrder"));
    },
    async searchWebProducts(value) {
      this.loading = true
      const params = {
        search: this.search_product,
      };
      const { data } = await this.$webService.searchProducts(params);
      if (data) {
        this.searchedProducts = [];
        for (let index = 0; index < data.length; index++) {
          const element = data[index];
          if (element.variants.length == 0 && element.product_type == 2) {
          } else {
            this.searchedProducts.push(element);
          }
        }
        this.loading = false
      }
    },
    resetSearchResult() {
      this.search_product = "";
      this.searchedProducts = [];
      $(".search").toggleClass("search-toggle");
    },
    async addToCart(product) {
      if (product.is_available) {
        if (product.product_type == 2) {
          this.search_product = "";
          this.searchedProducts = [];
          this.$router.push(`/product/${product.slug}`);
        } else {
          await this.$webService
            .addCartItem({ product_id: product.id, quantity: 1 })
            .then(async (res) => {
              if (res.success) {
                this.$toast.success(res.message);
                await this.fetchCartItems();
              } else {
                this.$toast.error(res.message);
              }
            });
        }
      } else {
        this.$toast.error(this.$t("product_not_available"));
      }
    },
    externalClick(event) {
      this.search_product = "";
      this.searchedProducts = [];
      var closeElement = document.getElementById("cartcollapse2");
      closeElement.classList.remove("show")
    },
  },
  watch: {
    search_product: {
      handler(val) {
        if (val == "") {
          this.searchedProducts = [];
        }
      },
      deep: true,
    },
  },
};
$(document).ready(function () {
  $("#search-input").click(function () {
    $(".search").toggleClass("search-toggle");
    $(".autosuggest__results").toggleClass("d-none");
  });
});
</script>

<style scoped>

</style>
