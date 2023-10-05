<?php

namespace App\Http\Requests\Web\CustomerProfile;

use Illuminate\Foundation\Http\FormRequest;

class CustomerProfile extends FormRequest
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
      $allAttributes['first_name'] = trans('messages.fields.first_name');
      $allAttributes['last_name'] = trans('messages.fields.last_name');
      $allAttributes['gender'] = trans('messages.fields.gender');
      $allAttributes['phone'] = trans('messages.fields.phone');
      $allAttributes['dob'] = trans('messages.fields.dob');

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
          'first_name' => 'required|string|max:15',
          'last_name' => 'required|string|max:15',
          'gender' => 'required',
          'dob' => 'required',
          'phone' => 'string|max:15',
          'is_credentials' => 'required',
          'password' => 'nullable|same:password_confirmation|min:8',
        ];
    }
}
