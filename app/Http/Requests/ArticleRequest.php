<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'title'=>'required|min:3',
            'body'=>'required|min:5',
            //'user_id'=>'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'title.required'=>'please write the title',
            'body.required'=>'please write the content',
            'user_id.required'=>'please write the user id',
        ];
    }
}
