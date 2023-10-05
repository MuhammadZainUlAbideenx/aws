<?php

namespace App\Http\Requests\CMS\SeoPages;

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
    public function attributes(){

      $allAttributes = [];
      $allAttributes['title'] = trans('messages.fields.title');
      $allAttributes['description'] = trans('messages.fields.description');
      $allAttributes['keywords'] = trans('messages.fields.keywords');
      $allAttributes['seo_type'] = trans('messages.fields.seo_type');
      $allAttributes['product_id'] = trans('messages.fields.product');
      $allAttributes['category_id'] = trans('messages.fields.category');
      $allAttributes['static_page'] = trans('messages.fields.static_page');
      $allAttributes['content_page_id'] = trans('messages.fields.content_page');
      $allAttributes['meta_tags'] = trans('messages.fields.is_active');
      // Single Lang Attribute Names

      return $allAttributes;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'title' => 'required|string',
          'description' => 'required|string',
          'keywords' => 'required|string',
          'seo_type' => 'required',
          'product_id' => 'nullable',
          'category_id' => 'nullable',
          'static_page' => 'nullable',
          'content_page_id' => 'nullable',
          'meta_tags' => 'nullable',

        ];
    }
}
