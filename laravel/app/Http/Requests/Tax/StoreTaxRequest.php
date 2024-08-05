<?php

namespace App\Http\Requests\Tax;

use App\Enums\ResponseEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreTaxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'code' => 'unique:taxes,code',
            'rate' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên thuế',
            'code' => 'Mã thuế',
            'rate' => 'Tỉ lệ',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'messages' => $validator->errors(),
        ], ResponseEnum::UNPROCESSABLE_ENTITY));
    }
}