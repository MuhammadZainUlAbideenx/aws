<template>
    <div>

            <div class="thanks-you-form rounded bg-white-secondary-light text-center order-empty">
                <div class="no-order-icon">
                  <fa :icon="['fas', 'archive']"/>
                </div>
                <h2 class="text-uppercase fw-bold my-2 display-5">{{$t('no_orders')}}</h2>
                <p class="fs-6"> {{$t('seems_like_you_have_not_placed_any_orders_yet')}}</p>
                <nuxt-link to="/shop" class="btn bg-warning rounded lh-sm fw-bold text-uppercase"> {{$t('continue_shopping')}}</nuxt-link>
            </div>

    </div>
</template>
