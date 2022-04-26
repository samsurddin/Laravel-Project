<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255|unique:App\Models\Plan,name',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'price' => 'required|integer',
            'discount' => 'nullable|integer|min:0|max:100',
            'price_yearly' => 'nullable|integer',
            'discount_yearly' => 'nullable|integer|min:0|max:100'
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $plan = $this->route()->parameter('plan');

            $rules['name'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('App\Models\Plan')->ignore($plan),
            ];
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'plan name',
            'discount_yearly' => 'yearly discount',
            'price_yearly' => 'yearly price',
        ];
    }
}
