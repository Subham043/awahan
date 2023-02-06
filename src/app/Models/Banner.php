<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Banner extends Model
{
    use HasFactory;
    protected $table = "banners";
    protected $appends = ['image_path'];
    protected $fillable = [
        'image',
        'alt',
        'title',
        'user_id',
    ];

    protected function imagePath(): Attribute
    {
        return new Attribute(
            get: fn () => asset('storage/upload/banner/'.$this->image),
        );
    }

    public function UploadedBy()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
