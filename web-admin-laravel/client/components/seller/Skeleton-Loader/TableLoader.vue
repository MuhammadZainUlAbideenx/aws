<template>
    <div class="container-fluid skeletion-effect">
        <div class="card gutter-b border-0">
          <div class="card-header p-0">
            <div class="row table-filter-row g-0 mx-0 justify-content-end">
              <!-- Small boxes (Stat box) -->
              <div class="col-md-6 col-lg-7">
                <div class="filter-bar skeletion-animation"></div>
              </div>
              <div class="col-md-6 col-lg-5 col-xlg-6 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                 <div class="circle-btn skeletion-animation"></div>
                  <div class="circle-btn skeletion-animation"></div>
                </div>
              </div>
            </div>
          </div>
            <div
      class="card-body  mt-2 data-tables-div py-0 m-0 rounded-md"
    >
      <div class="col-md-12">
        <div class="vgt-wrap">
          <!---->
          <div class="vgt-inner-wrap">
            <!---->
            <!---->
            <!---->
            <div class="vgt-fixed-header"><!----></div>
            <div class="vgt-responsive">
              <table id="vgt-table" class="vgt-table striped">
                <thead>
                  <tr>
                    <!---->
                    <th scope="col" class="line-numbers"></th>
                    <th><div class="heading skeletion-animation"></div></th>

                  <span v-if="image">   <th><div class="heading skeletion-animation"></div></th> </span>

                    <th><div class="heading skeletion-animation"></div></th>

                    <th><div class="heading skeletion-animation"></div></th>

                    <th><div class="heading skeletion-animation"></div></th>

                    <th><div class="heading skeletion-animation"></div></th>
                  </tr>
                  <!---->
                </thead>

                <tbody>
                  <!---->
                  <tr class="m-5">
                    <th class="line-numbers"><div class="icon skeletion-animation"></div></th>
                    <td class="vgt-left-align">
                      <div class="heading skeletion-animation"></div>
                    </td>
                  <span v-if="image">  <td class="vgt-left-align"><div class="image skeletion-animation"></div></td> </span>
                    <td class="vgt-left-align">
                      <div class="heading skeletion-animation"></div>
                    </td>
                    <td class="vgt-left-align"><div class="switch skeletion-animation"></div></td>
                    <td class="vgt-left-align">
                      <div class="content skeletion-animation"></div>
                    </td>
                    <td class="vgt-left-align">
                      <div class="icon skeletion-animation"></div>
                      <div class="icon skeletion-animation"></div>
                      <div class="icon skeletion-animation"></div>
                    </td>
                  </tr>

                  <tr class="m-5">
                    <th class="line-numbers"><div class="icon skeletion-animation"></div></th>
                    <td class="vgt-left-align">
                      <div class="heading skeletion-animation"></div>
                    </td>
                   <span v-if="image">  <td class="vgt-left-align"><div class="image skeletion-animation"></div></td> </span>
                    <td class="vgt-left-align">
                      <div class="heading skeletion-animation"></div>
                    </td>
                    <td class="vgt-left-align"><div class="switch skeletion-animation"></div></td>
                    <td class="vgt-left-align">
                      <div class="content skeletion-animation"></div>
                    </td>
                    <td class="vgt-left-align">
                      <div class="icon skeletion-animation"></div>
                      <div class="icon skeletion-animation"></div>
                      <div class="icon skeletion-animation"></div>
                    </td>
                  </tr>

                  <tr class="m-5">
                    <th class="line-numbers"><div class="icon skeletion-animation"></div></th>
                    <td class="vgt-left-align">
                      <div class="heading skeletion-animation"></div>
                    </td>
                  <span v-if="image">   <td class="vgt-left-align"><div class="image skeletion-animation"></div></td> </span>
                    <td class="vgt-left-align">
                      <div class="heading skeletion-animation"></div>
                    </td>
                    <td class="vgt-left-align"><div class="switch skeletion-animation"></div></td>
                    <td class="vgt-left-align">
                      <div class="content skeletion-animation"></div>
                    </td>
                    <td class="vgt-left-align">
                      <div class="icon skeletion-animation"></div>
                      <div class="icon skeletion-animation"></div>
                      <div class="icon skeletion-animation"></div>
                    </td>
                  </tr>

                  <tr class="m-5">
                    <th class="line-numbers"><div class="icon skeletion-animation"></div></th>
                    <td class="vgt-left-align">
                      <div class="heading skeletion-animation"></div>
                    </td>
                  <span v-if="image">   <td class="vgt-left-align"><div class="image skeletion-animation"></div></td> </span>
                    <td class="vgt-left-align">
                      <div class="heading skeletion-animation"></div>
                    </td>
                    <td class="vgt-left-align"><div class="switch skeletion-animation"></div></td>
                    <td class="vgt-left-align">
                      <div class="content skeletion-animation"></div>
                    </td>
                    <td class="vgt-left-align">
                      <div class="icon skeletion-animation"></div>
                      <div class="icon skeletion-animation"></div>
                      <div class="icon skeletion-animation"></div>
                    </td>
                  </tr>

                  <tr class="m-5">
                    <th class="line-numbers"><div class="icon skeletion-animation"></div></th>
                    <td class="vgt-left-align">
                      <div class="heading skeletion-animation"></div>
                    </td>
                    <span v-if="image"> <td class="vgt-left-align"><div class="image skeletion-animation"></div></td> </span>
                    <td class="vgt-left-align">
                      <div class="heading skeletion-animation"></div>
                    </td>
                    <td class="vgt-left-align"><div class="switch skeletion-animation"></div></td>
                    <td class="vgt-left-align">
                      <div class="content skeletion-animation"></div>
                    </td>
                    <td class="vgt-left-align">
                      <div class="icon skeletion-animation"></div>
                      <div class="icon skeletion-animation"></div>
                      <div class="icon skeletion-animation"></div>
                    </td>
                  </tr>
                  <!---->
                </tbody>
                <!---->
              </table>
            </div>

            <div class="vgt-wrap__footer vgt-clearfix">
              <div class="footer__row-count vgt-pull-left">
                 <div class="content skeletion-animation"></div>
              </div>
              <div class="footer__navigation vgt-pull-right">
                <div class="footer__navigation__page-info">
                   <div class="content skeletion-animation"></div>
                </div>
              </div>
            </div>
            <!---->
          </div>
        </div>
      </div>
    </div>
        </div>
      </div>
</template>

<script>
export default {
props:['image']
}
</script>

<style>

</style>
