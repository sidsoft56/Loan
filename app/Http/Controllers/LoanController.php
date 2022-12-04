<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ApplyLoanRequest;
use App\Http\Requests\ApproveLoanRequest;
use App\Http\Requests\LoanDetailRequest;
use App\Http\Requests\PayInstallmentRequest;
use App\Models\Loan;
use App\Models\LoanPayment;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use DB;

class LoanController extends Controller
{
    
    /**
    * ApplyLoan api
    * @param  
    *   amount:@double
    *   term:@int     
    *   
    *
    * @return \Illuminate\Http\Response
    *   
    */

    public function ApplyLoan(ApplyLoanRequest $request)
    {
      
        Loan::create(array_merge($request->
            only('amount','term'),[
              'user_id'=>auth()->user()->id,
             ]));
        
       
        return sendResponse([], 'Loan request is register successfully.');
    }

    /**
    * ApproveLoan api
    * @param  
    *  loan_id:@int       
    *   
    *
    * @return \Illuminate\Http\Response
    *   
    */

    public function ApproveLoan(ApproveLoanRequest $request)
    {
        
        Loan::whereId($request->loan_id)->update([
            'status'=>'approved',
            'status_at'=>Carbon::now()
        ]);        
       
        return sendResponse([], 'Loan request is register successfully.');
    }
    
    /**
    * PayInstallment api
    * @param  
    *   amount:@double
    *   loan_id:@int     
    *   
    *
    * @return \Illuminate\Http\Response
    *   
    */

    public function PayInstallment(PayInstallmentRequest $request)
    {
        $PayedData=LoanPayment::whereLoanId($request->loan_id)->select(DB::RAW("count('id') as payed_term"),DB::RAW("sum('amount') as payed_amount"))->first();
        $PayedAmount=$PayedData->payed_amount;
        $PayedTerm=$PayedData->payed_term;

        $LoanData=Loan::whereId($request->loan_id)->first();
        $TotalAmount=$LoanData->amount;
        $TotalTerm=$LoanData->term;
        $RestAmount=$TotalAmount-$PayedAmount;
        $RestTerm=$TotalTerm-$PayedTerm;
        if($request->amount > $RestAmount){
         return sendError('Validation Error.', "Amount must be less than or equal to ".$RestAmount);
        }
        if($request->amount < ($RestAmount/$RestTerm)){
           return sendError('Validation Error.', "Amount must be greater than or equal to ".$RestAmount/$RestTerm);
        }

        LoanPayment::create(array_merge($request->
            only('amount','loan_id'),[
              'user_id'=>auth()->user()->id,
             ]));
        
       
        return sendResponse([], 'Paid successfully.');
    }


    /**
    * Loan Details api
    * @param  
    *  loan_id:@int       
    *   
    *
    * @return \Illuminate\Http\Response
    *   
    */

    public function LoanDetail(LoanDetailRequest $request)
    {
        
        $list =Loan::with('LoanPayment')->whereUserId(auth()->user()->id)
        ->when(request('loan_id'), function ($q) {
           return $q->whereId(request('loan_id'));
          })
        ->when(request('status'), function ($q) {
           return $q->whereStatus(request('status'));
          })->get();
          foreach($list as $value){
             $value->LoanInstallment=$this->installments($value->created_at,$value->term,$value->amount,$value->term-$value->LoanPayment->count(),$value->amount-$value->LoanPayment->sum('amount'));
          } 
         
        return sendResponse($list, 'Loan request is register successfully.');
    }

   private function installments($ApplyDate,$Allterm,$AllAmount,$restTerm,$restAmount){

         $NextDate=CarbonImmutable::create($ApplyDate)->addWeek($Allterm-$restTerm+1);
        
        $payment_detail=[];
        $paymentAmount=$restAmount/$restTerm;
        $i=0;
        while($restTerm > $i){
          $payment_detail[]= [
            'date'=>$NextDate->addWeek($i)->format('Y-m-d'),
            'amount'=>$paymentAmount?round($paymentAmount,2):0,
             ];

         
          $i++;
        }
        return $payment_detail;
    }

}
