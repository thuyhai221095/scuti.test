<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRoleRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'project_id' => 'required',
                    'member_id' => 'required',
                    'role' => 'required'
                ];
            case 'PUT':
                return array(
                    'role' => 'required'
                );
            default:
                return [];
        }
    }

    public function messages()
    {
        return [
            'member_id.max' => 'The member field is required.'
        ];
    }
    // custom validation faild return
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            [
                'errors' => $errors
            ]
        ), 422);
    }
}
