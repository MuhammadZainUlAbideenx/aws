import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      options: [
        { value: '', text: this.$t('form.seo_page.seo_type.placeholder') },
        { value: 'product', text: this.$t('form.seo_page.seo_type.product') },
        { value: 'category', text: this.$t('form.seo_page.seo_type.category') },
        // { value: 'content_page', text: this.$t('form.seo_page.seo_type.content_page') },
        { value: 'static_page', text: this.$t('form.seo_page.seo_type.static_page') },
      ],
      static_pages_options: [
        { id: 'home_page', name: this.$t('form.seo_page.static_page.home_page') },
        { id: 'shop_page', name: this.$t('form.seo_page.static_page.shop_page') },
      ],
      formData: {
        seo_type:'',
        title:'',
        product_id:'',
        category_id:'',
        static_page_id:'',
        content_page_id:'',
        description: '',
        keywords: '',
        meta_tags:[]
      },
      loading:false,
      showSeo:false,
      error: false
    }
  },
  methods:{
    seoTypeChanged(){
      if(this.seo_type == 'product'){
        this.formData.category_id = ''
        this.formData.static_page_id = ''
        this.formData.content_page_id = ''
      }
      else if(this.seo_type == 'category'){
        this.formData.product_id = ''
        this.formData.static_page_id = ''
        this.formData.content_page_id = ''
      }
      else if(this.seo_type == 'static_page'){
        this.formData.product_id = ''
        this.formData.category_id = ''
        this.formData.content_page_id = ''
      }
      else if(this.seo_type == 'content_page'){
        this.formData.product_id = ''
        this.formData.category_id = ''
        this.formData.static_page_id = ''
      }
      else{
        this.formData.product_id = ''
        this.formData.category_id = ''
        this.formData.content_page_id = ''
        this.formData.static_page_id = ''
      }
      this.formData.title = ''
      this.formData.description = ''
      this.formData.keywords = ''
      this.formData.meta_tags = ''
      this.showSeo = false
    },
    async itemChanged(apikey,formDataKey){
      if(this.formData[formDataKey]){
        this.loading= true
      const { data } = await this.$repositories[apikey].show(this.formData[formDataKey])
      if(data && data.seo){
        this.formData.title = data.seo.title ? data.seo.title:''
        this.formData.description = data.seo.description ? data.seo.description:''
        this.formData.keywords = data.seo.keywords ? data.seo.keywords:''
        this.formData.meta_tags = data.seo.meta_tags ? data.seo.meta_tags:[]
      }
      this.loading = false
      this.showSeo = true
    }
    else{
      this.showSeo = false
      this.formData.title = ''
      this.formData.description = ''
      this.formData.keywords = ''
      this.formData.meta_tags = ''
      }
    },
    ...mapActions({
      addSeoPages: 'SeoPages/addSeoPages',
      fetchActiveSeoPages: 'General/fetchActiveSeoPages',
      fetchActiveProducts: 'General/fetchActiveProducts',
      fetchActiveCategories: 'General/fetchActiveCategories',
      fetchParentChildActiveCategories: 'General/fetchParentChildActiveCategories',
      fetchActiveContentPages: 'General/fetchActiveContentPages',
    }),
    increaseOne(i){
      return ++i
    },
    addMetaTag(){
      var obj = {name:'newMeta'}
      this.formData.meta_tags.push(obj)
    },
    removeMetaTag(i){
      this.formData.meta_tags.splice(i,1)
    },
    addMetaProperty(i){
      this.$set(this.formData.meta_tags[i],'newProp','new property')
    },
    removeMetaProperty(i,prop){
      this.$delete(this.formData.meta_tags[i],prop)
    },
    changeKey(i,prop,ev){
      if(ev.target.value.length > 0){
      var temp = {}
      for(const index in this.formData.meta_tags[i]){
        if(index == prop){
          temp[ev.target.value] = this.formData.meta_tags[i][index]
        }
        else{
          temp[index] = this.formData.meta_tags[i][index]
        }
      }
      this.$set(this.formData.meta_tags,i,temp)
      }
    },
    },
    computed: {
      ...mapGetters({
        allActiveProducts: 'General/allActiveProducts',
        allActiveCategories: 'General/allActiveCategories',
        allParentChildActiveCategories: 'General/allParentChildActiveCategories',
        allActiveContentPages: 'General/allActiveContentPages',
      }),
      metaTags() {
        return this.formData.meta_tags;
      },
    },


}
