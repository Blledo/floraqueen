<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class VoucherRuleUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'reduction' => ['numeric'],
            'reduction_type' => ['string', Rule::in(['percent', 'fixed'])],
            'reduction_model' => ['string', Rule::in(['product', 'product_unit', 'shipping', 'cart'])],
            'model_id' => ['nullable', 'integer'],
            'min_qty' => ['integer'],
            'priority' => ['integer']
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
