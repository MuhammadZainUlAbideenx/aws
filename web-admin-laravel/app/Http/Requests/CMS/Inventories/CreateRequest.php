<?php

namespace App\Http\Requests\CMS\Inventories;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

     public function attributes(){

       $allAttributes = [];
       //simple
       $allAttributes['stock'] = trans('messages.fields.stock');

      //variable

      //api_protection_settings

       // Single Lang Attribute Names
       return $allAttributes;
     }

    public function rules()
    {
      if($this->product_type == 1 || $this->product_type == 3 || $this->product_type == 4){
        //Simple
        return [
          'stock' => 'required',
          'product_id' => 'required|exists:products,id|unique:product_inventories,id',
        ];
      }
      else if($this->product_type == 2){
        //Variable
          return [
            'is_all_translations_required' => 'required|boolean',
            'is_multi_vendor' => 'required|boolean',
            'vendor_commission_type' => 'required_if:is_multi_vendor,1',
          ];
      }
    }
}
