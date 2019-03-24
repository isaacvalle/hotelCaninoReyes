<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateDog extends FormRequest
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
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'name' => 'bail|string|min:3|max:100',
            'breed_id' => 'bail|numeric',
            'gender' => 'boolean',
            'picture' => 'url',
            'color_id' => 'numeric',
            'spots_color_id' => 'numeric',
            'size_id' => 'numeric',
            'sterialized' => 'boolean',
            'friendly' => 'boolean',
            'observations' => 'string|min:5|max:255'
        ];
    }
}
