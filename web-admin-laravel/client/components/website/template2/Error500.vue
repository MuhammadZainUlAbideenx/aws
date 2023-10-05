<template>
    <div class="row error-section">
          <div class="col-sm-12 text-center text-md-end d-flex flex-column align-items-center justify-content-center">
                <h2 class="error-2">OOPS!</h2>
                <h1 class="error-500">500 ERROR</h1>
                <h3 class="text-uppercase">Internal Server Error</h3>
                 <p >The server encountered an internal error</p>
              <NuxtLink to="/" class="btn btn-primary">Back to Home page</NuxtLink>
          </div>
      </div>
</template>
<style lang="scss" scoped>
@import "~bootstrap/scss/functions";
@import '~bootstrap/scss/bootstrap';
.error-section {
  margin: 70px auto;
  .error-500 {
    font-size: 9rem;
    font-weight: 900;
    color: #f4d395;
    line-height: 9rem;
    margin: 0;
  }
  .error-2 {
    font-size: 9rem;
    font-weight: 900;
    color: #d3d3d3;
    line-height: 8rem;
    margin: 0;
  }
  h3 {
    font-size: 63px;
    font-weight: 900;
  }
  p {
    font-size: 29px;
    font-weight: 500;
  }
  .btn-primary {
    border-radius: 5px;
    color: white;
    font-size: 17px;
    font-weight: bold;
  }

  @media only screen and (max-width: 992px) {
    .error-500 {
      font-size: 5rem !important;
      line-height: normal;
    }
    .error-2 {
      font-size: 6rem !important;
      line-height: normal;
    }
    h3 {
      font-size: 36px !important;
    }
    p {
      font-size: 28px !important;
    }
  }
  @media only screen and (max-width: 767px) {
    .error-500 {
      font-size: 3.5rem !important;
      line-height: 5rem !important;
    }
    .error-2 {
      font-size: 4rem !important;
      line-height: normal;
    }
    h3 {
      font-size: 25px !important;
    }
    p {
      font-size: 20px !important;
    }
  }
}
</style>
