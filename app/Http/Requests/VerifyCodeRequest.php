<?php

namespace App\Http\Requests;


class VerifyCodeRequest extends AbstractApiFormRequest
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
        return [
            //
           'phone_number' => [
                'string',
                'min:11',
                'required'
            ],
            'code' => [
                'required',
                'string',
                'digits:6'
            ]
        ];
    }
}
