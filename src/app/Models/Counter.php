<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Counter extends Model
{
    use HasFactory;
    protected $table = "counters";
    protected $fillable = [
        'title',
        'counter',
        'user_id',
    ];


    public function UploadedBy()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
