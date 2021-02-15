<?php

namespace App;

use App\Model\Invoice;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes, Notifiable;
    protected $guard = 'web';
    protected $fillable = [
        'name',
        'email',
        'password',
        'address_id',
        'avatar',
        'vet_status',
        'car_plate_number',
        'latitude',
        'longitude',
        'formatted_address',
        'national_id_url',
        'consultation_price',
        'visit_price',
    ];

    protected $hidden = [
        'password',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            foreach($user->VetRequests as $VetRequest) {
                $VetRequest->delete();
            }
            foreach($user->DriverRequests as $DriverRequest) {
                $DriverRequest->delete();
            }
            foreach($user->invoices as $invoice) {
                $invoice->delete();
            }
            
        });
        
    }

    public function devices()
    {
        return $this->hasMany('App\Model\Device');
    }

    public function userFile()
    {
        return $this->hasOne('App\Model\UserFile');
    }

    public function interests()
    {
        return $this->belongsToMany('App\Model\Interest', 'user_interests', 'user_id', 'interest_id');
    }

    public function getPhoneFormattedAttribute()
    {
        $trimmed_phone = substr($this->phone, 1);
        $new_phone_format = "+966" . $trimmed_phone;
        return $new_phone_format;
    }

    public function vetTimeSlots()
    {
        return $this->hasMany('App\Model\VetTimeSlot', 'vet_id');
    }

    public function getVetStatusArAttribute()
    {
        return $this->vetStatusTranslate($this->vet_status);
    }

    public function getNumberOfPaidServicesAttribute()
    {
        $numberOfPaidService = 0;
        $invoices = Invoice::where("service_provider_id", $this->id)->where('payment_status', 'PAID')->get();
        $numberOfPaidService = count($invoices);
        return $numberOfPaidService;
    }

    public function getTotalProfit()
    {
        $totalProfit = 0;
        $invoices = Invoice::where("service_provider_id", $this->id)->where('payment_status', 'PAID')->get();

        foreach ($invoices as $index => $invoice) {
            $totalProfit += str_replace(',', "", $invoice->provider_profit);
        }

        return number_format($totalProfit, 2);
    }

    public function getTotalAppCommission()
    {
        $totalAppCommission = 0;
        $invoices = Invoice::where("service_provider_id", $this->id)->where('payment_status', 'PAID')->get();

        foreach ($invoices as $index => $invoice) {
            $totalAppCommission += str_replace(',', "", $invoice->admin_commission);
        }

        return number_format($totalAppCommission, 2);
    }

    public function providerInvoices()
    {
        return $this->hasMany('App\Model\Invoice', 'service_provider_id');
    }

    public function acceptedInvoices()
    {
        return $this->providerInvoices()->where('payment_status', 'PAID');
    }

    public function invoices()
    {
        return $this->hasMany('App\Model\Invoice', 'client_id');
    }

    // REJECTED مرفوضة
    public function vetStatusTranslate($vet_status)
    {
        $value = "";
        switch ($vet_status) {
            case 'REJECTED':
                $value = "مرفوضة";
                break;
            case 'PENDING':
                $value = "قيد الانتظار";
                break;
            case 'ACCEPTED':
                $value = "تم قبولها";
                break;
        }

        return $value;
    }

    public function VetRequests()
    {
        return $this->hasMany('App\Model\VetRequest','client_id');
    }

    public function DriverRequests()
    {
        return $this->hasMany('App\Model\DriverRequest','client_id');
    }
    public function UserTokens()
    {
        return $this->hasMany('App\Model\UserToken');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}