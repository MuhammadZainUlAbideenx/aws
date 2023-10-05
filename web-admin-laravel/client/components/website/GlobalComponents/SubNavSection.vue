<template>
    <section class="sub-nav-section mt-5 mb-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-dark navbar-expand-lg bg-secondary rounded justify-content-between">
                        <div class="custom-nav" id="subnavbar">
                            <ul class="navbar-nav nav-links">
                                <li class="nav-item shop-item" @click="switchTab('reviews')">
                                    <a class="nav-link text-black" href="javascript:void(0)">{{$t('web.customer.product_detail.reviews')}}</a>
                                </li>
                                <li class="nav-item vendors-item shop" @click="switchTab('products')">
                                    <a class="nav-link text-black" href="javascript:void(0)">{{$t('web.customer.featured_vendor_profile.all_products')}}</a>
                                </li>

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    methods:{
        switchTab(data)
        {
            this.$emit('switchTab',data);
        }
    }
}
$(document).ready(function(){
    $("#subnavbar .shop-item a").click(function(){
        $("#subnavbar .shop-item").addClass("shop");
        $("#subnavbar .vendors-item").removeClass("shop");
    });
    $("#subnavbar .vendors-item a").click(function(){
        $("#subnavbar .vendors-item").addClass("shop");
        $("#subnavbar .shop-item").removeClass("shop");
    });
});
</script>

<style>

</style>
