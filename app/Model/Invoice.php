<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'vet_offer_id',
        'driver_offer_id',
        'reference_id',
        'amount_paid',
        'payment_gateway',
        'payment_status',
    ]; 

    public function client()
    {
        return $this->belongsTo('App\User','client_id');
    }

    public function vetOffer()
    {   
        return $this->belongsTo('App\Model\VetOffer','vet_offer_id')->withTrashed();
    }

    public function driverOffer()
    {   
        return $this->belongsTo('App\Model\DriverOffer','driver_offer_id')->withTrashed();
    }

    public function getAmountPaidAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getPaymentStatusArAttribute()
    {
        return $this->statusTranslate($this->payment_status);
    }

    public function statusTranslate($status)
    {   
        $value = "";
        switch ($status) {
            case 'PAID':
                $value = "مدفوع";
                break;
            case 'PENDING':
                $value = "قيد الانتظار";
                break;
        }

        return $value;
    }

    public function getFullPriceAttribute()
    {   
        if($this->payment_for == "VETERINARIAN"){
            if($this->vetOffer()->exists())
                return $this->vetOffer->price;
            return null;
        }
        if($this->payment_for == "DRIVER"){
            if($this->driverOffer()->exists())
                return $this->driverOffer->price;
            return null;
        }
        return null;
            
    }
}
