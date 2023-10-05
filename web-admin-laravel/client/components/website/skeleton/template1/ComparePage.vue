<template>
       <div class="container skeletion-effect">
          <div class="row">
            <div class="col-md-4">
                <div class="compare-item rounded skeletion-animation">
                    <div class="compare-item-wrap rounded overflow-hidden" >
                    <div class="compare-item-img">
                      <div class="img-wrap skeletion-animation">
                      </div>
                    </div>
                    <ul>
                      <li></li>
                      <li></li>
                      <li></li>
                    </ul>
                    <div class="vender-btns d-flex justify-content-center align-items-center">
                      <button  class="btn btn-warning rounded fw-bold d-flex align-items-center justify-content-center">
                        {{$t('web.customer.compare.explore_more')}}
                      </button>
                      <button class="btn btn-primary text-white rounded fw-bold d-flex align-items-center justify-content-center ms-3">
                        <fa :icon="['fas', 'shopping-bag']" class="me-2" /> {{$t('web.customer.compare.add_to_cart')}}
                      </button>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="compare-item rounded skeletion-animation">
                    <div class="compare-item-wrap rounded overflow-hidden" >
                    <div class="compare-item-img">
                      <div class="img-wrap skeletion-animation">
                      </div>
                    </div>
                    <ul>
                      <li></li>
                      <li></li>
                      <li></li>
                    </ul>
                    <div class="vender-btns d-flex justify-content-center align-items-center">
                      <button  class="btn btn-warning rounded fw-bold d-flex align-items-center justify-content-center">
                       {{$t('web.customer.compare.explore_more')}}
                      </button>
                      <button class="btn btn-primary text-white rounded fw-bold d-flex align-items-center justify-content-center ms-3">
                        <fa :icon="['fas', 'shopping-bag']" class="me-2" />  {{$t('web.customer.compare.add_to_cart')}}
                      </button>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="compare-item rounded skeletion-animation">
                    <div class="compare-item-wrap rounded overflow-hidden" >
                    <div class="compare-item-img">
                      <div class="img-wrap skeletion-animation">
                      </div>
                    </div>
                    <ul>
                      <li></li>
                      <li></li>
                      <li></li>
                    </ul>
                    <div class="vender-btns d-flex justify-content-center align-items-center">
                      <button  class="btn btn-warning rounded fw-bold d-flex align-items-center justify-content-center">
                         {{$t('web.customer.compare.explore_more')}}
                      </button>
                      <button class="btn btn-primary text-white rounded fw-bold d-flex align-items-center justify-content-center ms-3">
                        <fa :icon="['fas', 'shopping-bag']" class="me-2" />  {{$t('web.customer.compare.add_to_cart')}}
                      </button>
                    </div>
                  </div>
                </div>
            </div>
          </div>
      </div>
</template>
