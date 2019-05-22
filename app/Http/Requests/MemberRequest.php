<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class MemberRequest extends FormRequest
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
        switch ($this->segment(2)) {
            case 'member':
                return array(
                    'name' => [
                        'required',
                        'max:50',
                        'regex:/^([A-Za-z0-9\s\-\.\(\)]*)$/',
                        'unique:tbl_members,name'
                    ],
                    'infomation' => 'max:300',
                    'date_of_birth' => [
                        'required',
                        'date',
                        'before_or_equal:now',
                        'after:-60 years'
                    ],
                    'phone' => [
                        'required',
                        'regex:/^([0-9\s\-\+\.\(\)]*)$/',
                        'max:20',
                        'unique:tbl_members,phone'
                    ],
                    'avatar' => 'image|mimes:jpeg,png,jpg|max:10240',
                    'position' => 'required'
                );
                
            case 'updateMember':
                $id = $this->segment(3);
                return array(
                    'name' => 'required|max:50|regex:/^([A-Za-z0-9\s\-\.\(\)]*)$/|unique:tbl_members,name,'.$id,
                    'infomation' => 'max:300',
                    'date_of_birth' => 'required|date|before:now|after:-60 years',
                    'phone' => 'required|regex:/^([0-9\s\-\+\.\(\)]*)$/|max:20|unique:tbl_members,phone,'.$id,
                    'avatar' => 'image|mimes:jpeg,png,jpg|max:10240',
                    'position' => 'required'
                );
            default:
                return [];
        }
    }

    public function messages()
    {
        return [
            'avatar.max' => 'Maximum file size to upload is 10MB (10240 KB). '
        ];
    }
    // custom validation faild return
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator) )->errors();
        throw new HttpResponseException(response()->json(
            [
                'errors' => $errors
            ]
        ), 422);
    }
}
