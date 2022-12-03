<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class paymentrequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'status_code' => config('constants.validation_codes.unprocessable_entity'),
                'message' => $validator->errors()->all()[0]
            ], config('constants.validation_codes.unprocessable_entity'))
        );
    }
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => "required|min:5|max:30|email",
            'firstname' => 'required',
            'lastname' => 'required',
            'phoneno' => 'required|min:10|',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required|numeric',
        ];
    }
}
