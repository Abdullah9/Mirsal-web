<?php

namespace App\Model;

use App\Events\DriverRequestSaving;
use App\Helpers\DateArFomatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'type',
        'animal_id',
        'size_id',
        'description',
        'quantity',
        'driver_offer_id',
        'address_to_id',
        'address_from_id',
        'preferred_date',
        'preferred_time',
        'image_id',
        'image_uri',
        'status',
        'client_completed',
    ];

    protected $dispatchesEvents = [
        'saving' => DriverRequestSaving::class,
    ];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($query) {
            foreach($query->driverOffers as $driverOffer) {
                $driverOffer->delete();
            }
        });
        
    }

    public function client()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function animal()
    {
        return $this->belongsTo('App\Model\Animal')->withTrashed();
    }

    public function size()
    {
        return $this->belongsTo('App\Model\Size');
    }

    public function driverOffers()
    {
        return $this->hasMany('App\Model\DriverOffer');
    }

    public function acceptedDriverOffer()
    {
        return $this->belongsTo('App\Model\DriverOffer', 'accepted_driver_offer_id');
    }

    public function addressFrom()
    {
        return $this->belongsTo('App\Model\Address', 'address_from_id', 'id');
    }

    public function addressTo()
    {
        return $this->belongsTo('App\Model\Address', 'address_to_id', 'id');
    }

    public function image()
    {
        return $this->belongsTo('App\Model\ImageFile');
    }

    // CANCELLED - ملغية
    // PENDING - قيد الانتظار
    // SKIPPED - تم تجاهلها
    // ACCEPTED -تم قبولها
    // COMPLETED - مكتملة

    public function getStatusArAttribute()
    {
        return $this->statusTranslate($this->status);
    }

    public function getFullPriceAttribute()
    {
        if ($this->acceptedDriverOffer()->exists()) {
            return $this->acceptedDriverOffer->price;
        }

        return null;
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

    public function getTypeArAttribute()
    {
        return $this->typeTranslate($this->type);
    }

    // SHARE تشاركي
    // PRIVATE - خاص
    public function typeTranslate($type)
    {
        $value = "";
        switch ($type) {
            case 'SHARE':
                $value = "تشاركي";
                break;
            case 'PRIVATE':
                $value = "خاص";
                break;
        }

        return $value;
    }

    public function getPreferredDateArAttribute()
    {
        $date = $this->preferred_date;
        return DateArFomatter::dateARFormat($date);
    }
}