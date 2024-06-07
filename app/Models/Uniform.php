<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Uniform extends Model
{
    use HasUuids;

    protected $fillable = ['name'];

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function withdraw()
    {
        return $this->hasMany(Withdraw::class);
    }
}