<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProjectRequest extends FormRequest
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
                return array(
                    'name' => [
                        'required',
                        'max:10',
                        'regex:/^([A-Za-z0-9\s\-\.\(\)]*)$/',
                        'unique:tbl_projects,name'
                    ],
                    'infomation' => 'max:300',
                    'deadline' => 'date|after_or_equal:'.date("Y-m-d"),
                    'type' => 'required',
                    'status' => 'required'
                );
            case 'PUT':
                return array(
                    'name' => [
                        'required',
                        'max:10',
                        'regex:/^([A-Za-z0-9\s\-\.\(\)]*)$/',
                        'unique:tbl_projects,name,'. $this->segment(3)
                    ],
                    'infomation' => 'max:300',
                    'deadline' => 'date|after_or_equal:'.date("Y-m-d"),
                    'type' => 'required',
                    'status' => 'required'
                );
            default:
                return [];
        }
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
