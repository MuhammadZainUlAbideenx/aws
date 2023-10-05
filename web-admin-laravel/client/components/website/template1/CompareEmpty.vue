<template>
    <div>
        <div
            class="thanks-you-form bg-white-secondary-light text-center compare-empty"
        >
            <div class="compare-icon">
                <fa :icon="['fas', 'exclamation-circle']" />
            </div>

            <div>
                <h2 class=" text-uppercase fw-bold my-2">{{$t('web.customer.compare.compare_list_empty')}}</h2>
                <p class="fs-6">{{$t('web.customer.compare.no_products_found')}}</p>
                <nuxt-link
                    to="/shop"
                    class="btn bg-warning rounded py-2 lh-sm fw-bold text-uppercase"
                >
                    {{$t('web.customer.compare.continue_shopping')}}</nuxt-link
                >
            </div>
        </div>
    </div>
</template>
