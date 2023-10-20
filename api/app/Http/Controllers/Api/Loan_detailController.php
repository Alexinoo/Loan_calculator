<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Loan_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PgSql\Lob;
class Loan_detailController extends Controller
{
     
     public function CalculateEMI(Request $request){
            
        $loan_amount = $request->loan_amount;
        $payment_date = $request->payment_date;

        //ADDITIONAL CHARGES
        $processing_fees = (3/100) * $loan_amount;
        $excise_duty = (20/100) * $processing_fees;
        $legal_fees = 10000;
        $take_home_amount = $loan_amount - ($processing_fees + $excise_duty + $legal_fees );

        $arrData = array();

        foreach($request->bank as $bank){

            if($bank == 'Bank A'){

                  $interest_rate = null;
                  ($request->interest_type == 'Flat Rate')? $interest_rate = 20 : $interest_rate = 22 ;  

                    if($request->interest_type == 'Reducing Balance'){
                              if($request->payment_frequency == 'Annually'){
                                    $annual_interest =   $interest_rate/100; 
                                    $no_of_years = (int)$request->loan_period;
                                    $emi_amount = $this->ReducingFormula($loan_amount,$no_of_years,$annual_interest);
                                    // General return      
                                    $arrData[]= 
                                          $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$no_of_years,$payment_date,$emi_amount,$annual_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);

                              }else if($request->payment_frequency == 'Quarterly'){
                                    $quarterly_interest =   $interest_rate/400;                   
                                    $quarterly_periods =   (int)$request->loan_period * 4;                   
                                    $emi_amount = $this->ReducingFormula($loan_amount,$quarterly_periods,$quarterly_interest);
                                    // General Return
                                    $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$quarterly_periods,$payment_date,$emi_amount,$quarterly_interest,$processing_fees, $excise_duty,$legal_fees,$take_home_amount);
                                    
                              }else if($request->payment_frequency == 'Monthly'){                  
                                    $monthly_interest = $interest_rate/1200;
                                    $monthly_periods = (int)$request->loan_period * 12;
                                    $emi_amount = $this->ReducingFormula($loan_amount,$monthly_periods,$monthly_interest);
                                    // General Return
                                    $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$monthly_periods,$payment_date,$emi_amount,$monthly_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);
                              }else{
                                    $semiannually_interest = $interest_rate/200;
                                    $semiannually_periods = (int)$request->loan_period * 2;
                                    $emi_amount = $this->ReducingFormula($loan_amount,$semiannually_periods,$semiannually_interest);
                                    // General Return
                                     $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$semiannually_periods,$payment_date,$emi_amount,$semiannually_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);
                              }
                        }else{

                              // Flat Rate
                              if($request->payment_frequency == 'Annually'){      
                                    $annual_interest =   $interest_rate/100;
                                    $no_of_years = (int)$request->loan_period; 
                                    $emi_amount = $this->FlatRateFormula($loan_amount,$annual_interest,$no_of_years);
                                    // General return      
                                    $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$no_of_years,$payment_date,$emi_amount,$annual_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);
                              }else if($request->payment_frequency == 'Quarterly'){

                                    $quarterly_interest =   $interest_rate/400;                   
                                    $quarterly_periods =   (int)$request->loan_period * 4;                  
                                    $emi_amount = $this->FlatRateFormula($loan_amount,$quarterly_interest,$quarterly_periods);
                                    // General Return
                                    $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$quarterly_periods,$payment_date,$emi_amount,$quarterly_interest,$processing_fees, $excise_duty,$legal_fees,$take_home_amount);
                              }else if($request->payment_frequency == 'Monthly'){
                                    
                                    $monthly_interest = $interest_rate/1200;
                                    $monthly_periods = (int)$request->loan_period * 12;
                                    $emi_amount = $this->FlatRateFormula($loan_amount,$monthly_interest,$monthly_periods);
                                    // General Return
                                    $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$monthly_periods,$payment_date,$emi_amount,$monthly_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);
                              }else{
                                    $semiannually_interest = $interest_rate/200;
                                    $semiannually_periods = (int)$request->loan_period * 2;
                                    $emi_amount = $this->FlatRateFormula($loan_amount,$semiannually_interest,$semiannually_periods);
                                    // General Return
                                     $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$semiannually_periods,$payment_date,$emi_amount,$semiannually_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);
                        }
                   }     
                  
             }
            else{

                  $interest_rate = null;
                  ($request->interest_type == 'Flat Rate')? $interest_rate = 18 : $interest_rate = 25 ; 
                  
                   if($request->interest_type == 'Reducing Balance'){
                              if($request->payment_frequency == 'Annually'){
                                    $annual_interest =   $interest_rate/100; 
                                    $no_of_years = (int)$request->loan_period;
                                    $emi_amount = $this->ReducingFormula($loan_amount,$no_of_years,$annual_interest);
                                    // General return      
                                     $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$no_of_years,$payment_date,$emi_amount,$annual_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);

                              }else if($request->payment_frequency == 'Quarterly'){
                                    $quarterly_interest =   $interest_rate/400;                   
                                    $quarterly_periods =   (int)$request->loan_period * 4;                   
                                    $emi_amount = $this->ReducingFormula($loan_amount,$quarterly_periods,$quarterly_interest);
                                    // General Return
                                    $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$quarterly_periods,$payment_date,$emi_amount,$quarterly_interest,$processing_fees, $excise_duty,$legal_fees,$take_home_amount);
                                    
                              }else if($request->payment_frequency == 'Monthly'){                  
                                    $monthly_interest = $interest_rate/1200;
                                    $monthly_periods = (int)$request->loan_period * 12;
                                    $emi_amount = $this->ReducingFormula($loan_amount,$monthly_periods,$monthly_interest);
                                    // General Return
                                    $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$monthly_periods,$payment_date,$emi_amount,$monthly_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);
                              }else{
                                    $semiannually_interest = $interest_rate/200;
                                    $semiannually_periods = (int)$request->loan_period * 2;
                                    $emi_amount = $this->ReducingFormula($loan_amount,$semiannually_periods,$semiannually_interest);
                                    
                                    // General Return
                                    $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$semiannually_periods,$payment_date,$emi_amount,$semiannually_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);
                              }
                        }else{

                              // Flat Rate

                              if($request->payment_frequency == 'Annually'){      
                                    $annual_interest =   $interest_rate/100; 
                                    $no_of_years = $request->loan_period;
                                    $emi_amount = $this->FlatRateFormula($loan_amount,$annual_interest,$no_of_years);
                                    // General Return     
                                    $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$no_of_years,$payment_date,$emi_amount,$annual_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);
                              }else if($request->payment_frequency == 'Quarterly'){

                                    $quarterly_interest =   $interest_rate/400;                   
                                    $quarterly_periods =   (int)$request->loan_period * 4;                  
                                     $emi_amount = $this->FlatRateFormula($loan_amount,$quarterly_interest,$quarterly_periods);
                                    // General Return
                                    $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$quarterly_periods,$payment_date,$emi_amount,$quarterly_interest,$processing_fees, $excise_duty,$legal_fees,$take_home_amount);
                              }else if($request->payment_frequency == 'Monthly'){
                                    
                                    $monthly_interest = $interest_rate/1200;
                                    $monthly_periods = (int)$request->loan_period * 12;
                                    $emi_amount = $this->FlatRateFormula($loan_amount,$monthly_interest,$monthly_periods);
                                    // General Return
                                    $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$monthly_periods,$payment_date,$emi_amount,$monthly_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);
                              }else{
                                    $semiannually_interest = $interest_rate/200;
                                    $semiannually_periods = (int)$request->loan_period * 2;
                                    $emi_amount = $this->FlatRateFormula($loan_amount,$semiannually_interest,$semiannually_periods);
                                    // General Return
                                     $arrData[] = $this->GeneralFunction($bank,$loan_amount,$request->payment_frequency,$request->interest_type,$interest_rate,$semiannually_periods,$payment_date,$emi_amount,$semiannually_interest,$processing_fees,$excise_duty,$legal_fees,$take_home_amount);
                        }
                   }
            }
        }

        return response()->json($arrData);
       
     }


     // REDUCING BALANCE FORMULA
    //***********************************************************
    //              INTEREST * ((1 + INTEREST) ^ TOTALPAYMENTS)
    // EMI = LOAN * -------------------------------------------
    //                  ((1 + INTEREST) ^ TOTALPAYMENTS) - 1
    //***********************************************************

    private function ReducingFormula(float $loanAmount,int $totalPayments, float $interest)
    {  
    $numerator = $interest * pow((1 + $interest), $totalPayments); 
    $denominator = pow((1 + $interest), $totalPayments) - 1;
    $emi    = $loanAmount * ($numerator / $denominator);
    return $emi;
    }


     // FLAT RATE FORMULA
    //***********************************************************
    //
    // EMI = LOAN * INTEREST * N(12)
    //      ------------------------------------------------------
    //                   12
    //***********************************************************

    private function FlatRateFormula(float $loanAmount, float $interest,int $totalInstallments)
    {  

      $totInterest    =  $loanAmount * $interest * $totalInstallments; 
      $emi = ($loanAmount + $totInterest) / $totalInstallments; // (Principal + Interest ) / totalInstallments
      return $emi;
    }



    // Generic Return     
    private function GeneralFunction(string $bank_name,float $ln_amt,string $frequency,string $int_type,float $int_rate,int $period,string $pay_date,float $emi,float $actual_int,float $proc_fees,float $exc_duty,float $leg_fee,float $take_home){
      return array (
                     'bank'=> $bank_name,
                     'loan_amount' => $ln_amt,
                     'frequency'=>$frequency,
                     'interest_type'=>$int_type,
                     'interest' =>$int_rate,
                     'period' => $period,
                     'payment_date' => $pay_date,
                     'emi' => $emi,
                     'actual_interest'=>$actual_int,
                     'processing_fees' => $proc_fees,
                     'excise_duty' => $exc_duty,
                     'legal_fees' => $leg_fee,
                     'take_home_amount' => $take_home
      );
    }



   
}
