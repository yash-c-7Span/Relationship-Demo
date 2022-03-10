<?php

namespace App\Http\Requests\User;

use App\Traits\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class User extends FormRequest
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
        if($this->isMethod('POST')){
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
            'email' => [
                'required',
                "email",
                "unique:users,email",
            ],
            'password' => [
                "required",
                "min:8"
            ],
        ];
    }

    private function putRules(){
        $id = $this->route('user');
        return [
            'name' => "required",
            'email' => [
                "required",
                "email",
                "unique:users,email,$id",
            ],
            'password' => [
                "required",
                "min:8"
            ]
        ];
    }

}
