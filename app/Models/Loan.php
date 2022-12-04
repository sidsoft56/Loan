<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'term',
        'user_id',
        'approved_at',
    ];

    public function LoanPayment()
    {
        return $this->hasMany('App\Models\LoanPayment');
    }
}
