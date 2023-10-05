import createRepository from '~/services/repository.js'
import createSellerRepository from '~/services/sellerRepository.js'
import createMedia from '~/services/media.js'
import createGeneral from '~/services/general.js'
import createWeb from '~/services/web.js'
import createVendor from '~/services/vendor.js'


export default (ctx, inject) => {
  const repositoryWithAxios = createRepository(ctx.$axios)
  const sellerRepositoryWithAxios = createSellerRepository(ctx.$axios)
  const mediaWithAxios = createMedia(ctx.$axios)
  const generalWithAxios = createGeneral(ctx.$axios)
  const webWithAxios = createWeb(ctx.$axios)
  const vendorWithAxios = createVendor(ctx.$axios)
  const repositories = {
    posts: repositoryWithAxios('posts'),
    users: repositoryWithAxios('users'),
    languages: repositoryWithAxios('languages'),
    products: repositoryWithAxios('products'),
    units: repositoryWithAxios('units'),
    attributes: repositoryWithAxios('attributes'),
    attribute_values: repositoryWithAxios('attribute_values'),
    manufacturers: repositoryWithAxios('manufacturers'),
    categories: repositoryWithAxios('categories'),
    tax_classes: repositoryWithAxios('tax_classes'),
    settings: repositoryWithAxios('settings'),
    themeSettings: repositoryWithAxios('themeSettings'),
    vendors: repositoryWithAxios('vendors'),
    orders: repositoryWithAxios('orders'),
    payoutRequests: repositoryWithAxios('payoutRequests'),
    riderPayoutRequests: repositoryWithAxios('riderPayoutRequests'),
    order_statuses: repositoryWithAxios('order_statuses'),
    newsletter: repositoryWithAxios('newsletter'),
    roles: repositoryWithAxios('roles'),
    permissions: repositoryWithAxios('permissions'),
    currencies: repositoryWithAxios('currencies'),
    slider_images: repositoryWithAxios('slider_images'),
    static_banners: repositoryWithAxios('static_banners'),
    countries: repositoryWithAxios('countries'),
    zones: repositoryWithAxios('zones'),
    tax_rates: repositoryWithAxios('tax_rates'),
    cities: repositoryWithAxios('cities'),
    states: repositoryWithAxios('states'),
    coupons: repositoryWithAxios('coupons'),
    parallax_banners: repositoryWithAxios('parallax_banners'),
    customers: repositoryWithAxios('customers'),
    admins: repositoryWithAxios('admins'),
    addresses: repositoryWithAxios('addresses'),
    news: repositoryWithAxios('news'),
    news_categories: repositoryWithAxios('news_categories'),
    about_us: repositoryWithAxios('about_us'),
    term_condition: repositoryWithAxios('term_condition'),
    refund_policy: repositoryWithAxios('refund_policy'),
    privacy_policy: repositoryWithAxios('privacy_policy'),
    content_pages: repositoryWithAxios('content_pages'),
    commissions: repositoryWithAxios('commissions'),
    seo_pages: repositoryWithAxios('seo_pages'),
    reviews: repositoryWithAxios('reviews'),
    review_statuses: repositoryWithAxios('review_statuses'),
    application_banners: repositoryWithAxios('application_banners'),
    application_parallax_banners: repositoryWithAxios('application_parallax_banners'),
    application_slider_images: repositoryWithAxios('application_slider_images'),
    content_application_pages: repositoryWithAxios('content_application_pages'),
    brands: repositoryWithAxios('brands'),
    shipping_methods: repositoryWithAxios('shipping_methods'),
    payment_methods: repositoryWithAxios('payment_methods'),
    contact_forms: repositoryWithAxios('contact_forms'),

    inventories: repositoryWithAxios('inventories'),
    faqs: repositoryWithAxios('faqs'),
    riders: repositoryWithAxios('riders'),
  }
  const sellerRepositories = {
    products: sellerRepositoryWithAxios('products'),
    orders: sellerRepositoryWithAxios('orders'),
    riders: sellerRepositoryWithAxios('riders'),
    reviews: sellerRepositoryWithAxios('reviews'),
    riderPayoutRequests: sellerRepositoryWithAxios('riderPayoutRequests'),
  }
  inject('media', mediaWithAxios)
  inject('webService',webWithAxios)
  inject('vendorService',vendorWithAxios)
  inject('repositories', repositories)
  inject('sellerRepositories', sellerRepositories)
  inject('generalService', generalWithAxios)

}
