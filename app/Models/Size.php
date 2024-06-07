<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasUuids;

    protected $fillable = ['uniform_id', 'type', 'amount'];

    public function uniform()
    {
        return $this->belongsTo(Uniform::class);
    }
}