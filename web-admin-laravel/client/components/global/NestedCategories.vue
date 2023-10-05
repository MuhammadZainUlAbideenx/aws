<template>
  <div class="treeview js-treeview">
    <ul class="list-group list-group-root well">
      <li class="" v-for="category in categories" :key="category.id">
            <div class="shadow-md form-check">
            <input class="form-check-input" :id="'category_'+category.id" type="checkbox" :childrens="category.childrens.length > 0 ? true:false" :parent="parent" @input="event => $emit('input', event)" :value="category.id">
                <label class="form-check-label d-flex align-items-center" :for="'category_'+category.id"> {{category.name}}</label>
            </div>
          <ul class="tree-sub-child" v-if="category.childrens && category.childrens.length > 0">
            <NestedCategories :parent="category.id" @checkParent="checkParent" @input="childInput" :categories="category.childrens" />
          </ul>
      </li>
    </ul>

  </div>
</template>
<script>

export default {
  name:'NestedCategories',
  components: {
  },
  props: {
    categories:'',
    parent:'',
  },
  data() {
    return {

    }
  },
  methods:{
    childInput(event){
      this.$emit('input', event)
      if(event.target.attributes.parent && event.target.checked == true){
        this.$emit('checkParent', event.target.attributes.parent.value)
      }
    },
    checkParent(id){
      this.$emit('checkParent', id)
    }
  },
};
</script>
