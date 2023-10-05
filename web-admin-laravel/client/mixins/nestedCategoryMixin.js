import { mapGetters, mapActions } from 'vuex'
export default {
    data() {
        return {
            parentClickedID : ""
        }
      },
  methods: {
    handleCategories(event){
        this.checkAndRemoveIfParentCatChanged(event.target.value);
      const index = this.formData.categories.indexOf(parseInt(event.target.value))
      if(index > -1){
        this.formData.categories.splice(index, 1);
        if(event.target.attributes.childrens){
          this.removeChilds(parseInt(event.target.value))
        }
      }else{
        this.formData.categories.push(parseInt(event.target.value));
      }
     },
     // remove selected childs when parent category is being unchecked
     removeChilds(id){
       var childs =  document.querySelectorAll('input[parent="'+id+'"][type="checkbox"]');
       for (var i = 0; i < childs.length; i++) {
         const index = this.formData.categories.indexOf(parseInt(childs[i].value))
         if(index > -1){
           this.formData.categories.splice(index, 1);
         }
         childs[i].checked = false;
         if(childs[i].attributes.childrens){
           this.removeChilds(childs[i].value)
         }
         }
       },
       // check parent when of that category if child is selected
     checkAllParent(id){
        this.checkAndRemoveIfParentCatChanged(id);
       const index = this.formData.categories.indexOf(parseInt(id))
       if(index > -1){
       }else{
         this.formData.categories.push(parseInt(id));
         var elmnt = document.getElementById('category_'+parseInt(id))
         if(elmnt){
           elmnt.checked = true
           if(elmnt.attributes.parent && elmnt.attributes.parent.value){
             this.checkAllParent(elmnt.attributes.parent.value)
           }

         }
       }
      },
      // check all category on edit for the first time
      categoryMark(){
          for (var i = 0; i < this.formData.categories.length; i++) {
            var elmnt = document.getElementById('category_'+parseInt(this.formData.categories[i]))
            if(elmnt){
              elmnt.checked = true
            }
          }
      },
      checkAndRemoveIfParentCatChanged(id)
      {
        if (this.categories) {
            for (let index = 0; index < this.categories.length; index++) {
                const element = this.categories[index];
                if (element.id == id) {
                    this.parentClickedID  = id;
                }
            }
        }

      },
  },
  computed: {
    ...mapGetters({
      allActiveLanguages: 'General/allActiveLanguages',
      allActiveCategories: 'General/allActiveCategories',
    })
  },
  watch: {
    parentClickedID: {
       handler(newVal,OldVal){
        if (OldVal) {
            this.removeChilds(OldVal); // Remove Select Child Catregories
            // Remove Select Parent  Category
            var elmnt = document.getElementById('category_'+parseInt(OldVal))
             if(elmnt){
               elmnt.checked = false
            }
        }
        this.formData.categories = [];
        this.formData.categories.push(parseInt(newVal));

       },
       deep: true
    }
  }
}
