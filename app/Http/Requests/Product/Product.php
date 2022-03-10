<?php

namespace App\Http\Requests\Product;

use App\Traits\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class Product extends FormRequest
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
            return $this->postRules();
        } else if($this->isMethod("PUT")){
            return $this->putRules();
        }
    }

    public function failedValidation(Validator $validator){
        $errors = $validator->errors();
        $response = $this->error($errors->getMessages(), 422);
        throw new HttpResponseException($response);
    }
    
    private function postRules(){
        return [
            'name' => "required",
            'description' => "required",
            'price' => [
                "required",
                "numeric",
            ],
            'is_active' => [
                "required",
                "in:0,1",
            ]
        ];
    }

    private function putRules(){
        return [
            'name' => "required",
            'description' => "required",
            'price' => [
                "required",
                "numeric",
            ],
            'is_active' => [
                "required",
                "in:0,1",
            ]
        ];
    }
}
