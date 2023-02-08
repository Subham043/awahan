<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Donation extends Model
{
    use HasFactory;
    protected $table = "donations";
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'amount',
        'order_id',
        'receipt',
        'payment_id',
        'status',
        'donation_page_id',
    ];
    protected $attributes = [
        'status' => 1,
    ];

    protected $appends = ['payment_status'];

    protected function paymentStatus(): Attribute
    {
        return new Attribute(
            get: fn () => PaymentStatusEnum::getValue($this->status),
        );
    }

    public function DonationPage()
    {
        return $this->belongsTo('App\Models\DonationPage', 'donation_page_id')->withDefault();
    }
}
