<?php

namespace App\Model;

use App\Events\VetOfferCreated;
use App\Events\VetOfferSaving;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VetOffer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vet_id',
        'vet_request_id',
        'price',
        'status',
        'payment_status',
    ];

    protected $dispatchesEvents = [
        'saving' => VetOfferSaving::class,
        'created' => VetOfferCreated::class,
    ];

    public function veterinarian()
    {
        return $this->belongsTo('App\User', 'vet_id')->withTrashed();
    }

    public function invoice()
    {
        return $this->hasOne('App\Model\Invoice');
    }

    public function vetRequest()
    {
        return $this->belongsTo('App\Model\VetRequest', 'vet_request_id')->withTrashed();
    }

    public function vetRequestAccepted()
    {
        return $this->hasOne('App\Model\VetRequest', 'accepted_vet_offer_id');
    }

    public function rating()
    {
        return $this->belongsTo('App\Model\Rating', 'rating_id');
    }

    public function getPriceAttribute($value)
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