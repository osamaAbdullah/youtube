<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChannelUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

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
