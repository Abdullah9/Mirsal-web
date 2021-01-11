<?php

namespace App\Model;

use App\Events\DriverOfferCreated;
use App\Events\DriverOfferSaving;
use App\Model\AdminSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverOffer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'driver_id',
        'driver_request_id',
        'price',
        'status',
        'payment_status',
        'first_payment_price',
        'tax_price',
        'total',
        'rating_id',

    ];

    protected $dispatchesEvents = [
        'saving' => DriverOfferSaving::class,
        'created' => DriverOfferCreated::class,
    ];

    public function driver()
    {
        return $this->belongsTo('App\User', 'driver_id', 'id')->withTrashed();
    }

    public function driverRequest()
    {
        return $this->belongsTo('App\Model\DriverRequest')->withTrashed();
    }

    public function invoice()
    {
        return $this->hasOne('App\Model\Invoice');
    }

    public function rating()
    {
        return $this->belongsTo('App\Model\Rating', 'rating_id');
    }

    public function getPriceAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getFirstPaymentPercAttribute()
    {
        return AdminSetting::first()->first_payment_perc;
    }

    public function getStatusArAttribute()
    {
        return $this->statusTranslate($this->status);
    }

    public function statusTranslate($status)
    {
        $value = "";
        switch ($status) {
            case 'CANCELLED':
                $value = "ملغية";
                break;
            case 'PENDING':
                $value = "قيد الانتظار";
                break;
            case 'SKIPPED':
                $value = "تم تجاهلها";
                break;
            case 'ACCEPTED':
                $value = "تم قبولها";
                break;
            case 'COMPLETED':
                $value = "مكتملة ";
                break;
        }

        return $value;
    }
}