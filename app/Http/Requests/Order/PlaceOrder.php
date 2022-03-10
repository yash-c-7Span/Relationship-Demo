<?php

namespace App\Http\Requests\Order;

use App\Traits\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlaceOrder extends FormRequest
{
    use ApiResponser;
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
        if($this->isMethod("POST")){
            $rules = [
                'address' => "required",
                'product_id' => [
                    "required",
                    "array",
                ],
                'product_id.*' => [
                    "required",
                    "numeric",
                    "exists:products,id"
                ],
                'quantity' => [
                    "required",
                    "array",
                ],
                'quantity.*' => [
                    "required",
                    "numeric",
                ]
            ];

            return $rules;
        }
    }
    public function failedValidation(Validator $validator){
        $errors = $validator->errors();
        $response = $this->error($errors->getMessages(), 422);
        throw new HttpResponseException($response);
    }
}
