<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TenantRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'domain' => 'required|string|regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i|unique:App\Models\Tenant,domain',
            'status' => 'required',
            'user_id' => 'required',
            'plan_id' => 'required'
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $tenant = $this->route()->parameter('tenant');

            $rules['domain'] = [
                'required',
                'string',
                'max:255',
                'regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i',
                Rule::unique('App\Models\Tenant')->ignore($tenant),
            ];
        }

        return $rules;
    }
}
