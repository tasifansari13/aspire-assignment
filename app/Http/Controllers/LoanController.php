<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Loan\LoanApproveRequest;
use App\Http\Requests\Loan\LoanStoreRequest;
use App\Http\Requests\Loan\LoanShowRequest;
use App\Http\Requests\Loan\LoanPayRequest;
use App\Http\Requests\Loan\LoanIndexRequest;
use App\Services\LoanService;

class LoanController extends Controller
{
    private $loan;

    public function __construct(LoanService $loan){
        $this->loan = $loan;
    }

    public function loanRequest(LoanStoreRequest $request){
        try{
            $loanDetails = $this->loan->loanRequest($request);

            return [
                'message' => 'You loan request is successfull',
                'loan_details' => $loanDetails
            ];
        }
        catch(\Exception $e){
            logger()->error($e->getMessage(). $e->getFile() . $e->getLine());
            return response()->json(['message' => $e->getMessage(). $e->getFile() . $e->getLine()], 400);
        }
    }

    public function approve(LoanApproveRequest $request){
        try{
            return [
                'message' => 'You loan has been successfully approved',
                'loan_details' => $this->loan->approve($request->loan_id),
            ];
        }
        catch(\Exception $e){
            logger()->error($e->getMessage(). $e->getFile() . $e->getLine());
            return response()->json(['message' => 'Some error occured'], 400);
        }
    }

    public function show(LoanShowRequest $request, $loadId){
        try{
            return [
                'message' => 'Success',
                'loan_details' => $this->loan->show($loadId),
            ];
        }
        catch(\Exception $e){
            logger()->error($e->getMessage(). $e->getFile() . $e->getLine());
            return response()->json(['message' => 'Some error occured'], 400);
        }
    }

    public function pay(LoanPayRequest $request){
        try{
            return [
                'message' => 'Success',
                'loan_details' => $this->loan->pay($request),
            ];
        }
        catch(\Exception $e){
            logger()->error($e->getMessage(). $e->getFile() . $e->getLine());
            return response()->json(['message' => 'Some error occured'], 400);
        }
    }
}
