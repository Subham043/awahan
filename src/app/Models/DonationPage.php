<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class DonationPage extends Model
{
    use HasFactory;
    protected $table = "donation_pages";
    protected $appends = ['image_path'];
    protected $fillable = [
        'donation_title',
        'image',
        'image_alt',
        'image_title',
        'slug',
        'funds_required',
        'fund_required_within',
        'campaigner_name',
        'campaigner_funds_collected',
        'beneficiary_name',
        'beneficiary_relationship_with_campaigner',
        'beneficiary_funds_collected',
        'donation_detail',
        'terms_condition',
        'user_id',
    ];

    protected function imagePath(): Attribute
    {
        return new Attribute(
            get: fn () => asset('storage/upload/donation_pages/'.$this->image)
        );
    }

    public function UploadedBy()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
    }
}
