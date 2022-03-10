<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SignUp extends FormRequest
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
        if ($this->isMethod('POST')) {
            
            $rules = [
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    'unique:users,email'
                ],
                'password' => [
                    'required',
                    'min:8',
                ],
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
