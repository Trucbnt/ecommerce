<?php

namespace App\Http\Requests\Brand;

use App\Enums\ResponseEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBrandRequest extends FormRequest
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
            'canonical' => 'unique:brands,canonical,' . $this->brand,
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên thương hiệu',
            'canonical' => 'Đường dẫn',
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
