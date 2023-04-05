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
            'email' => 'nullable|email|string|min:1|max:255|unique:users,email',
            'phone' => 'nullable|string|max:255|min:10|unique:users,phone|starts_with:+',
            'password' => 'required|string|confirmed|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255|min:1',
            'date_of_birth' => 'nullable|date|before:today',
        ];
    }

    /**
     * extra validation
     *
     * @param $validator
     */
    public function withValidator($validator)
    {
        // validate at least user has provided email, or username
        $validator->after(function ($validator)
        {
            $email = $validator->attributes()['email'] ?? null;
            $username = $validator->attributes()['name'] ?? null;

            if(! $email && ! $username)
            {
                $message = trans('auth.email_name_required');
                $validator->errors()->add('email', $message);
                $validator->errors()->add('name', $message);
            }
        });
    }
}
