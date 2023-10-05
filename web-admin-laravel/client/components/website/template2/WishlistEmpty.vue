<template>
    <div>
        <div
            class="thanks-you-form bg-white-secondary-light text-center wishlist-empty"
        >
            <div class="wishlist-icon">
                <fa :icon="['fas', 'exclamation-circle']" />
            </div>

            <div

            >
                <h2 class=" text-uppercase fw-bold my-2">{{$t('wishlist_empty')}}</h2>
                <p class="fs-6">{{$t('go_and_find_the_product_you_like')}}</p>
                <nuxt-link
                    to="/shop"
                    class="btn bg-warning rounded lh-sm fw-bold text-uppercase"
                >
                    {{$t('continue_shopping')}}</nuxt-link
                >
            </div>
        </div>
    </div>
</template>
