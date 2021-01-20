<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\VetRequestSaving;

class VetRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'type',
        'animal_id',
        'size_id',
        'description',
        'address_id',
        'vet_offer_id',
        'preferred_date',
        'preferred_time',
        'image_id',
        'status',
        'vet_time_slot_id',
        'accepted_vet_offer_id',
        'image_uri',
        'created_with_vet',
        'client_completed',
    ]; 

    protected $dispatchesEvents = [
        'saving' => VetRequestSaving::class, 
    ];

    public function client()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function animal()
    {
        return $this->belongsTo('App\Model\Animal');
    }

    public function size()
    {
        return $this->belongsTo('App\Model\Size');
    }

    public function address()
    {
        return $this->belongsTo('App\Model\Address','address_id','id');
    }

    public function vetOffers()
    {
        return $this->hasMany('App\Model\VetOffer');
    }

    public function acceptedVetOffer()
    {
        return $this->belongsTo('App\Model\VetOffer','accepted_vet_offer_id');
    }

    public function image()
    {
        return $this->belongsTo('App\Model\ImageFile');
    }

    public function vetTimeSlot()
    {
        return $this->belongsTo('App\Model\VetTimeSlot');
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
            case 'VISIT':
                $value = "زيارة";
                break;
            case 'CONSULTATION':
                $value = "استشارة";
                break;
        }

        return $value;
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
                $value = "مكتملة";
                break;
        }

        return $value;
    }


}
