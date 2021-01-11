<?php

namespace App\Model;

use App\Events\ClientOfferCreated;
use App\Events\ClientOfferSaving;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientOffer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'buyer_id',
        'product_id',
        'offered_price',
        'status',
        'payment_status',
        'note',
    ];

    protected $dispatchesEvents = [
        'saving' => ClientOfferSaving::class,
        'created' => ClientOfferCreated::class,
    ];

    public function buyer()
    {
        return $this->belongsTo('App\User', 'buyer_id')->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product')->withTrashed();
    }

    public function getOfferedPriceAttribute($value)
    {
        return number_format($value, 2);
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