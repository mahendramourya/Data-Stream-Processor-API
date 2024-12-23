<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubsequenceResult extends Model
{
    protected $fillable = ['stream_id','subsequence','count'];
}
