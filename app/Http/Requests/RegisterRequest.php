<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'nullable|string|max:255|unique:users,name',
            'email' => 'required|email|string|min:1|max:255|unique:users,email',
            'phone' => 'nullable|string|max:255|min:10|unique:users,phone|starts_with:+',
            'password' => 'required|string|confirmed|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255|min:1',
            'date_of_birth' => 'nullable|date|before:today',
        ];
    }

}
