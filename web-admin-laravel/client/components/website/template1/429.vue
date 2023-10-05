<template>
<div>
      <div class="row error-section">
          <div class="col-md-6 text-md-end d-flex flex-column ">
                <h1 class="error-404">429</h1>
                <span class="error-2">ERROR</span>
          </div>
          <div class="col-md-6 text-start d-flex align-items-center">
               <div >
                       <h3 class="text-uppercase">Too Many Requests </h3>
                        <p >System encountered an error due to too many Requests</p>
              <NuxtLink to="/" class="btn btn-primary">Back to Home page</NuxtLink>
            </div>

          </div>
      </div>
      </div>
</template>
<style lang="scss" scoped>
@import "~bootstrap/scss/functions";
@import '~bootstrap/scss/bootstrap';
.error-section {
  margin: 70px auto !important;
  .error-404 {
    font-size: 17rem !important;
    font-weight: bold !important;
    color: #f4d395 !important;
    line-height: 14rem !important;
  }
  .error-500 {
    font-size: 11rem !important;
    font-weight: bold !important;
    color: #f4d395 !important;
    line-height: 9rem !important;
  }
  .error-2 {
    font-size: 9rem !important;
    font-weight: bold !important;
    color: #d3d3d3 !important;
    line-height: 8rem !important;
  }
  h3 {
    font-size: 78px !important;
    font-weight: bold !important;
  }
  p {
    font-size: 31px !important;
  }
  .btn-primary {
    border-radius: 5px !important;
    color: white !important;
    font-size: 17px !important;
    font-weight: bold !important;
  }

  @media only screen and (max-width: 992px) {
    .error-404 {
      font-size: 11rem !important;
      line-height: 12rem !important;
    }
    .error-500 {
      font-size: 6rem !important;
    }
    .error-2 {
      font-size: 6rem !important;
    }
    h3 {
      font-size: 50px !important;
    }
    p {
      font-size: 28px !important;
    }
  }
  @media only screen and (max-width: 767px) {
    .error-404 {
      font-size: 8rem !important;
      line-height: 3rem !important;
    }
    .error-500 {
      font-size: 6rem !important;
      line-height: 5rem !important;
    }
    .error-2 {
      font-size: 4rem !important;
    }
    h3 {
      font-size: 40px !important;
    }
    p {
      font-size: 28px !important;
    }
  }
}
</style>
