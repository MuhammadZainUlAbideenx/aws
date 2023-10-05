<?php

namespace App\Http\Requests\Vendor\Riders;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBasicProfileRequest extends FormRequest
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
    public function rules()
    {

        return [
          'first_name' => 'required|string|max:25|min:3',
          'last_name' => 'required|string|max:25|min:3',
          'email' => 'required|email',
          'phone' => 'required|string|max:16',

        ];
    }
}
