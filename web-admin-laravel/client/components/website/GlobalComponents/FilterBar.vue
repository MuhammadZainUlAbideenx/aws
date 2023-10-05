<template>
  <div class="d-md-flex justify-content-between filter-bar rounded">
    <div>
         <div class="form-group input-group align-items-center">
        <label class="form-label text-medium mb-0 me-3">{{$t('search')}}: </label>
        <input
          type="email"
          class="form-control"
          aria-describedby="emailHelp"
        />
        <div class="position-absolute top-50 end-0 translate-middle-y px-3">
          <fa icon="search" class="text-primary" fixed-width />
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between">
         <div class=" dropdown-fild d-flex align-items-center categories-dropdown me-4">
        <label class="form-label flex-shrink-0 text-medium mb-0 me-3">{{$t('categories')}}: </label>
        <select class="form-select pe-5" aria-label="Default select example">
         <option selected>{{$t('web.home.navbar.home.fashion')}} <span>&#38;</span> {{$t('clothing')}}</option>
          <option value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
      </div>

      <div class=" dropdown-fild d-flex align-items-center sort-by-dropdown">
        <label class="form-label flex-shrink-0  text-medium mb-0 me-3">Sort by: </label>
        <select class="form-select pe-5" aria-label="Default select example">
          <option selected>A to Z</option>
          <option value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>
