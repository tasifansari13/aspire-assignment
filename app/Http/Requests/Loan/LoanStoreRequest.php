<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;

class LoanStoreRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:10000|max:' . config('constants.max_loan_amount'),
            'tenure' => 'required|integer|min:3|max:' . config('constants.max_tenure'),
        ];
    }

    public function messages()
    {
      return [
            'user_id.required' => 'User Id is required',
        ];
    }
}
