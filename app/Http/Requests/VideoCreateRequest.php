<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoCreateRequest extends FormRequest
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
        $id = Auth::user()->channels()->first()->id;
        return [
            'name' => "required|string|max:255|unique:channels,name,$id",
            'slug' => "required|max:255|alpha_num|unique:channels,slug,$id",
            'description' => 'max:1000'
        ];
    }
}
