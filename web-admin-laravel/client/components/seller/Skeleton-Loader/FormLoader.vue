<template>
<div class="container skeletion-effect">
        <div class="col-lg-12">
            <div class="card gutter-b border-0" >
              <div class="card-body p-4">
                <div class="row">
                  <div class="col-md-6 my-1">
                    <label class="label skeletion-animation"></label>
                    <div class="input  skeletion-animation"></div>
                    <div class="subheading skeletion-animation"></div>
                  </div>
                 <div class="col-md-6 my-1">
                    <label class="label skeletion-animation"> </label>
                    <div class="input  skeletion-animation"> </div>
                    <div class="subheading skeletion-animation"></div>
                  </div>
                   <div class="col-md-6 my-1">
                    <label class="label skeletion-animation"></label>
                    <div class="input  skeletion-animation"></div>
                    <div class="subheading skeletion-animation"></div>
                  </div>
                 <div class="col-md-6 my-1">
                    <label class="label skeletion-animation"> </label>
                    <div class="input  skeletion-animation"> </div>
                    <div class="subheading skeletion-animation"></div>
                  </div>
                </div>
                <div class="row">
                   <div class="col-md-6  my-1 d-flex justify-content-center flex-column ">
                      <div class="d-flex align-items-center ">
                           <label class="label skeletion-animation"> </label>
                            <div class="switch skeletion-animation"> </div>
                      </div>
                      <div class="subheading skeletion-animation"></div>
                    </div>
                </div>

                <div v-if="multilang">
                 <hr class="text-primary">
                <div class="row">
                <div class="col-lg-12 py-2">
                    <div class="px-0 pt-3">
                      <h2 class=" skeletion-animation"></h2>
                        <div class="subheading skeletion-animation"></div>
                      <div class="row">
                        <div class="col-lg-12 px-0 pt-3 d-md-flex">
                          <ul
                            class="nav nav-tabs d-inline-block"
                            id="myTab"
                            role="tablist "
                          >
                            <div class="tabs"></div>
                            <div class="tabs"></div>
                            <div class="tabs"></div>
                          </ul>

                          <div class="tab-content p-4" id="myTabContent">
                            <div class="tab-pane fade active show" role="tabpanel" >
                              <div class="row">
                                <div class="col-md-6 my-1">
                                  <div role="group ">
                                    <label class="label skeletion-animation"></label>
                                    <div class="input  skeletion-animation"></div>
                                    <div class="subheading skeletion-animation"></div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 my-1">
                                    <div role="group ">
                                        <label class="label skeletion-animation"> </label>
                                        <div class="textarea  skeletion-animation"> </div>
                                        <div class="subheading skeletion-animation"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                </div>
              </div>

            </div>
        </div>


         <div class="row">
          <div class="col-md-12 d-flex justify-content-end px-4">
            <div class="button-add skeletion-animation"></div>
            <div class="button-continue skeletion-animation"></div>
          </div>
        </div>
      </div>
</template>

<script>
export default {
props:['multilang']
}
</script>

<style>

</style>
