<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Loan;
use App\Models\Transaction;
use App\Services\LoanService;

class LoanPayRequest extends FormRequest
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
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:3333.33|max:' . config('constants.max_loan_amount'),
            'repayment_date' => 'required|in:'.implode(',', array_values(config('constants.repayment_schedules')))
        ];
    }
}
