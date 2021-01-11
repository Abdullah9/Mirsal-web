<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'seller_id',
        'address_id',
        'status',
        'type',
        'is_vip',
        'description',
        'duration_id',
        'price',
        'image_id',
        'contact_phone',
        'contact_email',
        'bank_name',
        'iban',
        'accepted_client_offer_id',
        'image_id',
        'image_uri',
        'quantity',
    ];

    public function seller()
    {
        return $this->belongsTo('App\User', 'seller_id')->withTrashed();
    }

    public function address()
    {
        return $this->belongsTo('App\Model\Address', 'address_id');
    }

    public function duration()
    {
        return $this->belongsTo('App\Model\Duration');
    }

    public function imageFile()
    {
        return $this->belongsTo('App\Model\ImageFile');
    }

    public function clientOffers()
    {
        return $this->hasMany('App\Model\ClientOffer');
    }

    // public function acceptedClientOffer()
    // {
    //     return $this->belongsTo('App\Model\ClientOffer', 'accepted_client_offer_id');
    // }

    // public function driverRequest()
    // {
    //     return $this->belongsTo('App\Model\DriverRequest');
    // }

    public function image()
    {
        return $this->belongsTo('App\Model\ImageFile');
    }

    // CANCELLED - ملغية
    // PENDING - قيد الانتظار
    // SOLD - تم البيع
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
            case 'SOLD':
                $value = "تم البيع";
                break;
        }

        return $value;
    }

    public function getTypeArAttribute()
    {
        return $this->typeTranslate($this->type);
    }

    public function typeTranslate($type)
    {
        $value = "";
        switch ($type) {
            case 'ANIMAL':
                $value = "حيوان";
                break;
            case 'PRODUCT':
                $value = "مسلتزمات الحيوانات";
                break;
        }

        return $value;
    }
}