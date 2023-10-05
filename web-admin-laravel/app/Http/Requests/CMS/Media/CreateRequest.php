<?php

namespace App\Http\Requests\CMS\Media;

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
      if($this->file && strstr($this->file->getMimeType(),'image/')){
        return[
          'file' => trans('messages.fields.image'),
        ];
      }
      else if($this->file && strstr($this->file->getMimeType(),'video/')) {
        return [
          'file' => trans('messages.fields.video'),
        ];
      }else{
        return [
          'file' => trans('messages.fields.file'),
        ];
      }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      if($this->file && strstr($this->file->getMimeType(),'image/')){
        return[
          'file' => 'required|image|file|max:2048',
        ];
      }
      else if($this->file && strstr($this->file->getMimeType(),'video/')) {
        return [
          'file' => 'required|file|max:5048',
        ];
      }else{
        return [
          'file' => 'required|file|image|max:2048',
        ];
      }
    }
}
