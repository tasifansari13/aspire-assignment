<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Payment;

class LoanService{

    public function index($user){
        return Loan::where('user_id', $user->id)->get();
    }

    public function enquiry(){
        $response = [];
        $response['max_loan_amount'] = config('constants.max_loan_amount');
        $response['max_tenure'] = config('constants.max_tenure');
        $response['interest_rates'] = config('constants.interest_rates');

        return $response;
    }

    public function loanRequest($request){
        $loan = Loan::create([
            'user_id' => $request->user_id,
            'tenure' => $request->tenure,
            'amount' => $request->amount,
            'loan_request_date' => date('Y-m-d')
        ]);
        $repayment_schedules = config('constants.repayment_schedules');
        foreach ($repayment_schedules as $date) {
          $payment = Payment::create([
              'loan_id' => $loan->id,
              'amount' => config('constants.repayment_amount'),
              'repayment_date' => $date
          ]);
        }
        return $this->getLoanDetails($loan);
    }

    public function approve($loan_id){
        $loan = Loan::findOrFail($loan_id);
        $loan->is_loan_approved = 1;
        $loan->save();
        return $this->getLoanDetails($loan);
    }

    public function show($loadId){
        $loan = Loan::findOrFail($loadId);
        return $this->getLoanDetails($loan);
    }

    public function getLoanDetails($loan){
        $response = [];
        $response['id'] = $loan->id;
        $response['tenure'] = $loan->tenure;
        $response['amount'] = $loan->amount;
        $response['is_loan_approved'] = ($loan->is_loan_approved == 0 ? 'No' : 'Yes');

        $payments = Payment::where('loan_id', $loan->id)->get();
        $transaction = [];
        $paid_amount = 0;
        foreach ($payments as $payment) {
          if($payment->payment_status == 1) {
            $paid_amount = ($paid_amount + $payment->amount);
          }
          $transaction[] = [
            'id' => $payment->id,
            'loan_id' => $payment->loan_id,
            'amount' => $payment->amount,
            'repayment_date' => $payment->repayment_date,
            'payment_status' => ($payment->payment_status == 0 ? 'Pending' : 'Paid'),
          ];
        }
        if($paid_amount >= $loan->amount) { // To update the loan status, if total payment is done
          $loan = Loan::findOrFail($loan->id);
          $loan->is_loan_paid = 1;
          $loan->save();
        }
        $response['is_loan_paid'] = ($loan->is_loan_paid == 0 ? 'No' : 'Yes');
        $response['total_paid_amount'] = $paid_amount;
        $response['balance_amount'] = ($loan->amount - $paid_amount);
        $response['payments'] = $transaction;

        return $response;
    }

    public function pay($request){
        $payment = Payment::where('loan_id', $request->get('loan_id'))->where('repayment_date', $request->get('repayment_date'))->first();
        // if(!empty($payment) && $payment->payment_status == 1) {
        //   abort(400, 'Payment done');
        // }
        $payment->amount = $request->get('amount');
        $payment->payment_status = 1;
        $payment->save();
        $loan = Loan::findOrFail($payment->loan_id);
        return $this->getLoanDetails($loan);
    }
}
