<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan_detail extends Model
{
    use HasFactory;

    protected $table = 'loan_details';

    protected $fillable = [
            'bank_name',
            'loan_amount', 5, 2,
            'payment_frequency',
            'loan_period',
            'start_date',
            'interest_type',
            'interest_rate'
    ];
}
