<template>
  <header class="header_layout_one">
    <div class="topbar">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="top-menu d-flex flex-row justify-content-between">
              <div class="locale d-flex flex-row">
                <div class="dropdown me-3">
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
                    id="navbarDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    {{ this.currentCurrency.code }}
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li
                      v-for="currency in availableCurrencies"
                      @click="changeCurrency(currency.code)"
                      :key="currency.code"
                    >
                      <a class="dropdown-item" href="#">{{ currency.name }}</a>
                    </li>
                  </ul>
                </div>
                <div class="dropdown">
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
                    id="navbarDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <div class="img-wrap me-1">
                      <img
                        :src="`/backend/api/flags/png100px/${currentLocale.code}.png`"
                        alt=""
                      />
                    </div>
                    {{ this.currentLocale.code }}
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li
                      v-for="locale in availableLocales"
                      :key="locale.code"
                      @click="changeLocale(locale.code)"
                    >
                      <a
                        class="dropdown-item d-flex align-items-center"
                        href="#"
                      >
                        <div class="img-wrap me-2">
                          <img
                            class="h-20px w-20px rounded-sm"
                            :src="`/backend/api/flags/png100px/${locale.code}.png`"
                            alt=""
                          />
                        </div>
                        {{ locale.name }}
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="info d-flex flex-row flex-row">
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

                <div v-else class="login">
                  <nuxt-link
                    :to="localePath('/login')"
                    class="d-flex flex-row align-items-center h-100 text-body"
                  >
                    {{ $t("login.login") }}
                  </nuxt-link>
                </div>
                <div class="register">
                  <a
                    class="
                      ps-2
                      d-flex
                      flex-row
                      align-items-center
                      h-100
                      text-body
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

                <div
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="search-bar py-4">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-3 col-6">
            <div class="logo">
              <nuxt-link
                to="/"
                v-if="allSettings.general_settings.name_or_logo == 1"
              >
                <img
                  :src="`/backend${allSettings.general_settings.logo_dark.original_media_path}`"
                  class=""
                  alt="..."
                  v-if="
                    this.themeData.dark &&
                    allSettings.general_settings.logo_dark
                  "
                />
                <img
                  :src="`/backend${allSettings.general_settings.logo.original_media_path}`"
                  class=""
                  alt="..."
                  v-else-if="allSettings.general_settings.logo"
                />
                <h2 v-else>{{ allSettings.general_settings.web_name }}</h2>
              </nuxt-link>
              <nuxt-link to="/" v-else>
                <h2>{{ allSettings.general_settings.web_name }}</h2>
              </nuxt-link>
            </div>
          </div>
          <div class="col-lg-5 col-6">
            <div class="header-search-warp" v-click-outside="externalClick">
              <div class="input-group header-search-bar">
                <input
                  id="example-search-input"
                  @input="searchWebProducts($event.target.value)"
                  class="
                    form-control
                    bg-secondary
                    border
                    rounded
                    ps-3
                    pe-5
                    d-lg-block d-none
                  "
                  autocomplete="off"
                  type="text"
                  :placeholder="this.$t('web.home.navbar.search.placeholder')"
                  v-model="search_product"
                />
                <input
                  @input="searchWebProducts($event.target.value)"
                  id="example-search-input"
                  class="
                    form-control
                    bg-secondary
                    border
                    rounded
                    ps-3
                    pe-5
                    d-lg-none d-block
                  "
                  type="text"
                  placeholder="Search"
                  v-model="search_product"
                  autocomplete="off"
                />
                <span
                  class="
                    input-group-ppend
                    position-absolute
                    top-50
                    end-0
                    translate-middle-y
                    me-3
                  "
                >
                  <fa :icon="['fas', 'search']" class="text-primary" />
                </span>
              </div>
              <div
                id="demo-autosuggest-autosuggest__results"
                class="autosuggest__results-container"
                v-if="searchedProducts.length > 0"
              >
                <div class="autosuggest__results">
                  <ul class="data-darren">
                    <li
                      id="demo-autosuggest-Human"
                      v-for="(product, index) in searchedProducts"
                      :key="index"
                    >
                      <div class="row g-0 align-items-center">
                        <div class="col-xl-3 col-4 p-3 h-100">
                          <div class="img-wrap rounded">
                            <img
                              :src="`/backend${product.media[0].original_media_path}`"
                              alt="DSADASDSDFDSFsdsddf"
                              class="w-sm-100 img-fluid rounded"
                              v-if="product.media.length > 0"
                            />
                            <img
                              v-else
                              src="~/assets/images/defult-product-img.png"
                              alt=""
                            />
                          </div>
                        </div>
                        <div class="col-xl-9 col-8 h-100">
                          <div class="row g-0 align-items-center">
                            <div
                              class="col-xl-8 h-100 d-flex align-items-center"
                            >
                              <div class="card-body ps-0 py-3">
                                <div class="rating mb-2">
                                  <GlobalRating
                                    :rating="product.reviews_average_rating"
                                  />
                                </div>
                                <nuxt-link :to="'/product/' + product.slug">
                                  <h6 @click="resetSearchResult" class="mb-1">
                                    {{ product.name }}
                                  </h6></nuxt-link
                                >

                                <div
                                  class="
                                    product-price
                                    d-flex
                                    align-items-center
                                    text-muted
                                  "
                                >
                                  <span
                                    class="fs-12 me-1"
                                    v-for="(
                                      category, index
                                    ) in product.categories"
                                    :key="index"
                                    >{{ category.name }}
                                  </span>
                                  <span v-if="product.flash_sale">
                                    <span class="price fw-normal"
                                      >{{ product.flash_sale.display_price }}
                                    </span>
                                    <span class="actual-price fw-normal">{{
                                      product.display_price
                                    }}</span>
                                  </span>
                                  <span v-else-if="product.special_sale">
                                    <span class="price fw-normal">{{
                                      product.special_sale.display_price
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
                            <div
                              class="
                                col-xl-4
                                p-xl-3
                                pb-3
                                d-xl-flex
                                justify-content-end
                              "
                            >
                              <button
                                @click="addToCart(product)"
                                class="
                                  btn btn-primary
                                  py-1
                                  text-white
                                  rounded
                                  fw-bold
                                  d-flex
                                  flex-row
                                  align-items-center
                                "
                              >
                                <fa
                                  :icon="['fas', 'shopping-bag']"
                                  class="me-2"
                                />
                                {{ $t("cart") }}
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
          <div class="col-lg-4 col-12">
            <div class="top-site-icons">
              <ul
                id="navAccordion"
                class="
                  m-0
                  p-0
                  d-flex
                  flex-row
                  align-items-center
                  justify-content-end
                  list-unstyled
                "
              >
                <li>
                  <nuxt-link to="/compare" class="nav-toggle" id="compare">
                    <fa :icon="['fas', 'exchange-alt']" /><span
                      class="badge bg-warning rounded-circle position-absolute"
                      >{{
                        allCompareProducts
                          ? allCompareProducts.products.length
                          : 0
                      }}</span
                    ><span>{{ this.$t("web.home.navbar.compare") }}</span>
                  </nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/wishlist" class="nav-toggle" id="wishlist">
                    <fa :icon="['fas', 'heart']" /><span
                      class="badge bg-warning rounded-circle position-absolute"
                      >{{
                        allWishlistItems ? allWishlistItems.meta.total : 0
                      }}</span
                    ><span>{{ this.$t("web.home.navbar.wishlist") }}</span>
                  </nuxt-link>
                </li>
                <li>
                  <a
                    class="dropdown-toggle nav-toggle"
                    id="cart"
                    data-bs-target="#cartcollapse"
                    data-bs-toggle="collapse"
                    href="#cartcollapse"
                    role="button"
                    aria-expanded="false"
                    aria-controls="cartcollapse"
                  >
                    <fa :icon="['fas', 'shopping-bag']" />
                    <span
                      class="badge bg-warning rounded-circle position-absolute"
                      >{{
                        allCartItems ? allCartItems.total_items_count : 0
                      }}</span
                    ><span>{{ this.$t("web.home.navbar.cart.heading") }} </span>
                  </a>
                  <div
                    class="collapse collapse-menu cart-items-container"
                    id="cartcollapse"
                    aria-labelledby="cart"
                    data-bs-parent="#navAccordion"
                  >
                    <button
                      class="btn-close"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#cartcollapse"
                      aria-expanded="false"
                      aria-controls="cartcollapse"
                    ></button>
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
                      <li
                        v-for="cart_item in allCartItems.cart_items"
                        :key="cart_item.id"
                      >
                        <div class="item-detail">
                          <h6 class="">
                            <nuxt-link
                              :to="`/product/${cart_item.product.slug}`"
                              class=""
                            >
                              {{ cart_item.product.name }}
                            </nuxt-link>
                          </h6>
                          <div class="item-s cart-items-container">
                            {{ cart_item.quantity }} x
                            {{ cart_item.single_price }}
                          </div>
                        </div>
                        <div
                          class="
                            item-img
                            img-wrap
                            flex-shrink-0
                            cart-items-container
                          "
                          v-if="
                            cart_item.product.media &&
                            cart_item.product.media[0] &&
                            cart_item.product.media[0].thumbnails
                          "
                        >
                          <img
                            class="img-fluid cart-items-container"
                            :src="`/backend${cart_item.product.media[0].thumbnails.small.thumbnail}`"
                            alt="Product Image"
                          />
                        </div>
                        <div
                          class="item-img img-wrap v cart-items-container"
                          v-else
                        >
                          <img
                            class="img-fluid cart-items-container"
                            src="~/assets/images/defult-product-img.png"
                            alt="Product Image"
                          />
                        </div>
                        <div
                          class="item-remove cart-items-container"
                          @click="removeFromCart(cart_item.id)"
                        >
                          <span class="btn-close cart-items-container"></span>
                        </div>
                      </li>
                    </ul>
                    <div
                      v-if="
                        allCartItems &&
                        allCartItems.cart_items.length > 0 &&
                        $auth.loggedIn &&
                        $gates.hasRole('customer')
                      "
                      class="
                        d-flex
                        flex-column
                        text-center
                        p-4
                        cart-items-container
                      "
                    >
                      <button
                        type="button"
                        v-on:click="proceedToCheckout"
                        class="
                          btn
                          bg-warning
                          rounded
                          py-2
                          lh-sm
                          fw-bold
                          text-uppercase
                          d-none d-lg-block
                        "
                      >
                        {{ this.$t("proceed_to_checkout") }}
                      </button>
                    </div>
                    <div v-else class="d-flex flex-column text-center p-4">
                      <button
                        v-if="
                          allCartItems && allCartItems.cart_items.length > 0
                        "
                        type="button"
                        class="
                          btn
                          bg-warning
                          rounded
                          py-2
                          lh-sm
                          fw-bold
                          text-uppercase
                          d-none d-lg-block
                        "
                        name="button"
                        data-bs-toggle="modal"
                        data-dismiss="cart"
                        data-bs-target="#DeleteItem24"
                      >
                        {{ this.$t("proceed_to_checkout") }}
                      </button>
                      <div v-else>
                        <p class="fs-6">{{ $t("cart_is_empty_message") }}</p>
                        <nuxt-link
                          to="/shop"
                          class="
                            btn
                            bg-warning
                            rounded
                            py-2
                            lh-sm
                            fw-bold
                            text-uppercase
                            d-none d-lg-block
                          "
                        >
                          Continue Shopping</nuxt-link
                        >
                      </div>

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
    <div class="main-menu navbar-dark bg-primary">
      <div class="container">
        <div class="row">
          <div class="col">
            <nav class="navbar navbar-expand-lg py-0">
              <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <span class="navbar-toggler-icon"></span>
              </button>
              <div
                class="collapse navbar-collapse justify-content-between"
                id="navbarNavDropdown"
              >
                <ul class="navbar-nav nav-categories">
                  <li class="nav-item categories-item dropdown">
                    <a
                      class="nav-link dropdown-toggle"
                      aria-current="page"
                      id="megamenu"
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                    >
                      <fa :icon="['fas', 'bars']" class="me-3" />{{
                        this.$t("web.home.navbar.categories.text")
                      }}
                    </a>
                    <div
                      class="dropdown-menu mega-menu"
                      aria-labelledby="megamenu"
                    >
                      <div class="row drop-wraper g-0">
                        <div class="col-5 drop-links p-4">
                          <div class="row">
                            <div class="col-6">
                              <div
                                class="list-det"
                                v-if="
                                  allMegaMenuItems &&
                                  allMegaMenuItems.categories_1
                                "
                              >
                                <!--  <h5 class="list-tit">{{ megaMenudata }}</h5> -->
                                <ul class="list-unstyled">
                                  <li
                                    @click="closeMenu"
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
                                <!-- <a class="v-all-link" href="#">{{ this.$t("web.home.navbar.view_all") }}</a> -->
                              </div>
                            </div>
                            <div class="col-6">
                              <div
                                class="list-det"
                                v-if="
                                  allMegaMenuItems &&
                                  allMegaMenuItems.categories_2
                                "
                              >
                                <!--  <h5 class="list-tit">{{ megaMenudata }}</h5> -->
                                <ul class="list-unstyled">
                                  <li
                                    v-for="category in allMegaMenuItems.categories_2" :key="category.id"
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
                                <!-- <a class="v-all-link" href="#">{{ this.$t("web.home.navbar.view_all") }}</a> -->
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col content-cards">
                          <div class="">
                            <h5 class="list-tit">Product name</h5>
                            <div class="card px-4">
                              <div class="row g-0 align-items-center">
                                <div
                                  class="col-md-5 d-flex justify-content-center"
                                >
                                  <img
                                    class="w-sm-100 img-fluid"
                                    src="~/assets/images/s-product-img1.png"
                                    alt="..."
                                  />
                                </div>
                                <div class="col-md-7">
                                  <div class="card-body p-0 ps-3">
                                    <h6>
                                      {{
                                        this.$t(
                                          "web.home.navbar.smart_phone.heading"
                                        )
                                      }}
                                    </h6>
                                    <div class="price">$60</div>
                                    <div
                                      class="
                                        icons
                                        d-flex
                                        flex-row
                                        align-items-center
                                      "
                                    >
                                      <a href="#" class="list-icon"
                                        ><fa :icon="['fas', 'heart']"
                                      /></a>
                                      <a href="#" class="list-icon"
                                        ><fa :icon="['fas', 'shopping-bag']"
                                      /></a>
                                    </div>
                                    <div class="rating">
                                      <GlobalRating rating="4" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <hr />
                          </div>
                          <div class="card px-4">
                            <div class="row g-0 align-items-center">
                              <div
                                class="col-md-5 d-flex justify-content-center"
                              >
                                <img
                                  class="w-sm-100 img-fluid"
                                  src="~/assets/images/s-product-img1.png"
                                  alt="..."
                                />
                              </div>
                              <div class="col-md-7">
                                <div class="card-body p-0 ps-3">
                                  <h6>
                                    {{
                                      this.$t(
                                        "web.home.navbar.smart_phone.heading"
                                      )
                                    }}
                                  </h6>
                                  <div class="price">$60</div>
                                  <div
                                    class="
                                      icons
                                      d-flex
                                      flex-row
                                      align-items-center
                                    "
                                  >
                                    <a href="#" class="list-icon"
                                      ><fa :icon="['fas', 'heart']"
                                    /></a>
                                    <a href="#" class="list-icon"
                                      ><fa :icon="['fas', 'shopping-bag']"
                                    /></a>
                                  </div>
                                  <div class="rating">
                                    <GlobalRating rating="4" />
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col content-offer">
                          <img
                            class="w-100 h-100"
                            src="~assets/images/mega-menu-offer-img.jpg"
                            alt=""
                            srcset=""
                          />
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="nav-item sale-off-nav">
                    <a class="nav-link" href="#">{{
                      this.$t("web.home.navbar.offitems.heading")
                    }}</a>
                  </li>
                </ul>
                <ul class="navbar-nav nav-links custom-link">
                  <li class="nav-item home-item dropdown">
                    <nuxt-link to="/" class="nav-link">
                      {{ this.$t("web.home.navbar.home.heading") }}
                    </nuxt-link>
                  </li>
                  <li class="nav-item shop-item dropdown">
                    <nuxt-link to="/shop" class="nav-link">
                      {{ this.$t("web.home.navbar.shop") }}
                    </nuxt-link>
                  </li>
                  <li
                    class="nav-item vendors-item dropdown"
                    v-if="
                      allSettings &&
                      allSettings.general_settings &&
                      allSettings.general_settings.is_multi_vendor == 1
                    "
                  >
                    <nuxt-link class="nav-link" to="/stores"
                      >{{ this.$t("web.home.navbar.stores") }}
                    </nuxt-link>
                  </li>
                  <li class="nav-item vendors-item dropdown">
                    <nuxt-link class="nav-link" to="/brands"
                      >{{ this.$t("web.home.navbar.brands") }}
                    </nuxt-link>
                  </li>

                  <li class="nav-item blog-item dropdown">
                    <nuxt-link to="/blog" class="nav-link">
                      {{ this.$t("web.home.navbar.blog") }}
                    </nuxt-link>
                  </li>
                  <li class="nav-item about-item dropdown">
                    <nuxt-link to="/aboutus" class="nav-link">
                      {{ this.$t("web.home.navbar.about") }}
                    </nuxt-link>
                  </li>
                  <li class="nav-item contact-item dropdown">
                    <nuxt-link to="/contact" class="nav-link">
                      {{ this.$t("web.home.navbar.contact") }}
                    </nuxt-link>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
// import LocaleDropdown from './LocaleDropdown'
export default {
  components: {
    // LocaleDropdown
  },
  props: ["themeData"],
  created() {},
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

  // computed: mapGetters({
  // }),

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
      localStorage.removeItem("compare_products");
      localStorage.removeItem("coupon_applied");
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
          await this.fetchCompareProducts({ compare_ids: null });
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
    },
    closeMenu() {

        $("#navbarNavDropdown").removeClass("show");

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
    $("#navbarNavDropdown .custom-link a.nav-link").click(function () {
        $("#navbarNavDropdown").removeClass("show");
    });
});
</script>
<style scoped>
</style>
