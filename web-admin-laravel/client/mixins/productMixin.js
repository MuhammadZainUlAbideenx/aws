import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      product_type_options:[
        { value: 1, text: this.$t('form.product.product_type.simple') },
        { value: 2, text: this.$t('form.product.product_type.variable') },
        // { value: 3, text: this.$t('form.product.product_type.external') },
        // { value: 4, text: this.$t('form.product.product_type.digital') },
      ],
      selected_vendor:'',
      selected_tax_class:'',
      selected_manufacturer:'',
      is_variable:1,
      selected_related_products:'',
      selected_brand:'',
      selectedOptions:'',
      selected_unit:'',
      categories:[],
      formData: {
        name: {},
        short_description:{},
        description:{},
        refund_policy:{},
        categories:[],
        weight: '',
        unit_id: '',
        price:'',
        stock:'',
        sku:'',
        modal:'',
        shipping_weight:'',
        manufacturer_id:'',
        brand_id:'',
        vendor_id:'',
        available_date:'',
        tax_class_id:'',
        min_order:1,
        max_order:'',
        product_type:1,
        is_feature: false,
        is_active: false,
        flash_sale:{
          exists:false,
          start_date:'',
          expire_date:'',
          product_price:0,
          description:'',
          is_active:true
        },
        special_sale:{
          exists:false,
          expire_date:'',
          special_price:'',
          is_active:true
        },
        related_products: '',
      },
      error: false,
      key:1,
      addContinue: false
    }
  },
  methods:{
    ...mapActions({
      fetchActiveCategories: 'General/fetchActiveCategories',
      fetchActiveManufacturers: 'General/fetchActiveManufacturers',
      fetchActiveBrands: 'General/fetchActiveBrands',
      fetchActiveVendors: 'General/fetchActiveVendors',
      fetchActiveUnits: 'General/fetchActiveUnits',
      fetchActiveTaxClasses: 'General/fetchActiveTaxClasses',
      fetchActiveProducts: 'General/fetchActiveProducts',
    }),
    reInitData(){
        this.formData.name =  {}
        this.formData.short_description = {}
        this.formData.description = {}
        this.formData.refund_policy = {}
        this.formData.categories = []
        this.formData.weight =  ''
        this.formData.unit_id =  ''
        this.formData.price = ''
        this.formData.stock = ''
        this.formData.modal = ''
        this.formData.manufacturer_id = ''
        this.formData.brand_id = ''
        this.formData.tax_class_id = ''
        this.formData.min_order = 1
        this.formData.max_order = ''
        this.formData.available_date = ''
        this.formData.product_type = 0
        this.formData.is_feature =  false
        this.formData.is_active =  false
        this.formData.vendor_id = ''
        this.formData.flash_sale.exists = false
        this.formData.flash_sale.start_date = ''
        this.formData.flash_sale.expire_date = ''
        this.formData.flash_sale.product_price = ''
        this.formData.flash_sale.description = ''
        this.formData.flash_sale.is_active = true
        this.formData.special_sale.exists = false,
        this.formData.special_sale.expire_date = '',
        this.formData.special_sale.special_price = '',
        this.formData.special_sale.is_active = true,
        this.key = this.key + 1
    },
  async vendorChange(){
    if (this.formData.vendor_id == '' || this.formData.vendor_id == null){
      this.categories = this.allActiveCategories.categories
    }
    else{
        const categories = await this.$generalService.vendorCategories(this.formData.vendor_id)
        if(categories)
        {
            this.categories = categories.data[0].categories

        }
  }
    this.formData.categories = []
    this.key = this.key + 1
  }
},
  computed: {
    ...mapGetters({
      allActiveLanguages: 'General/allActiveLanguages',
      allActiveManufacturers: 'General/allActiveManufacturers',
      allActiveBrands: 'General/allActiveBrands',
      allActiveVendors: 'General/allActiveVendors',
      allActiveCategories: 'General/allActiveCategories',
      allActiveUnits: 'General/allActiveUnits',
      allActiveTaxClasses: 'General/allActiveTaxClasses',
      allActiveSettings: 'General/allActiveSettings',
      allActiveProducts: 'General/allActiveProducts',
    }),
  },
  watch:{
    async allActiveCategories(newCount, oldCount) {
      if(this.allActiveSettings.is_multi_vendor == 1 || this.allActiveSettings.is_multi_vendor == '1'){
        if(this.formData.vendor_id != ''){
          const vendor = await this.$general.vendorCategories(this.formData.vendor_id)
          this.categories == vendor.categories
        }
        else{
          this.categories = this.allActiveCategories.categories
        }
      }
      else{
        this.categories = this.allActiveCategories.categories
      }
    },

  },

}
