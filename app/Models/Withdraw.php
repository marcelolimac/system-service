<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'withdrawal_amount',
        'exit_date',
        'delivery_date',
        'employee_id',
        'uniform_id',
        'size_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function uniform()
    {
        return $this->belongsTo(Uniform::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
