<?php

namespace App\GraphQL\CustomQueries;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Invoice;
use App\Model\VetOffer;
use App\Model\VetRequest;

class Consultation
{

    public function currentAsClient($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $client_id = $args['client_id'];

        $vetRequests = VetRequest::where("client_id", $client_id)
        ->where("type", "CONSULTATION")
        ->where( function ($query){
            $query->where("status","ACCEPTED")
            ->where('client_completed', "NO")

            ->orWhere("status","COMPLETED")
            ->where('client_completed', "NO")

            ->orWhere("status","ACCEPTED")
            ->Where('client_completed', "YES");
        });
        if(isset($args['created_with_vet'])){
            $vetRequests = $vetRequests->where("created_with_vet", $args['created_with_vet']);
        }
        if($vetRequests->get()->isEmpty())
            return $vetRequests;
        $vetOfferIds = $vetRequests->pluck('accepted_vet_offer_id');
        $vetOfferIds = Invoice::where('payment_status', 'PAID')->whereIn('vet_offer_id', $vetOfferIds)->where('payment_for','VETERINARIAN')->pluck('vet_offer_id');
        
        $vetOffers = VetOffer::whereIn("id", $vetOfferIds);
        return $vetOffers;

    }

    public function previousAsClient($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $client_id = $args['client_id'];

        $vetRequests = VetRequest::where("client_id", $client_id)->where("type", "CONSULTATION")->where('client_completed', "YES")->where("status","COMPLETED");
        if(isset($args['created_with_vet'])){
            $vetRequests = $vetRequests->where("created_with_vet", $args['created_with_vet']);
        }
        if($vetRequests->get()->isEmpty())
            return $vetRequests;
        $vetOfferIds = $vetRequests->pluck('accepted_vet_offer_id');
        $vetOffers = VetOffer::whereIn("id", $vetOfferIds);
        return $vetOffers;
    }

    public function currentAsVet($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $vet_id = $args['vet_id'];
        $vetOffers = VetOffer::where("vet_id", $vet_id)->where("status", "ACCEPTED");

        if($vetOffers->get()->isEmpty())
            return $vetOffers;
        $vetOfferIds = $vetOffers->pluck('id');

        $invoices = Invoice::where('payment_status', 'PAID')->whereIn('vet_offer_id', $vetOfferIds)->where('payment_for','VETERINARIAN');

        if($invoices->get()->isEmpty())
            return $invoices;
        $vetOfferIds = $invoices->pluck('vet_offer_id');

        $vetRequests = VetRequest::
        where("type", "CONSULTATION")
        ->where( function ($query){
            $query->where("status","ACCEPTED")
            ->where('client_completed', "NO")

            ->orWhere("status","COMPLETED")
            ->where('client_completed', "NO")

            ->orWhere("status","ACCEPTED")
            ->where('client_completed', "YES");
        });
        
        // echo $vetRequests->toSql(); exit;

        if(isset($args['created_with_vet'])){
            $vetRequests = $vetRequests->where("created_with_vet", $args['created_with_vet']);
        }
        if($vetRequests->get()->isEmpty())
            return $vetRequests;
        $vetOfferIds = $vetRequests->pluck('accepted_vet_offer_id');
        $vetOffers = VetOffer::whereIn("id", $vetOfferIds)->where("vet_id", $vet_id);

        return $vetOffers;
    }

    public function previousAsVet($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $vet_id = $args['vet_id'];
        $vetOffers = VetOffer::where("vet_id", $vet_id)->where('status', "ACCEPTED");
        if($vetOffers->get()->isEmpty())
            return $vetOffers;
        $vetOfferIds = $vetOffers->pluck('id');

        $vetRequests = VetRequest::whereIn("accepted_vet_offer_id", $vetOfferIds)->where("type", "CONSULTATION")->where("status","COMPLETED")->where('client_completed', "YES");
        if(isset($args['created_with_vet'])){
            $vetRequests = $vetRequests->where("created_with_vet", $args['created_with_vet']);
        }
        if($vetRequests->get()->isEmpty())
            return $vetRequests;
        $vetOfferIds = $vetRequests->pluck('accepted_vet_offer_id');
        $vetOffers = VetOffer::whereIn("id", $vetOfferIds)->where("vet_id", $vet_id);

        return $vetOffers;
    }
}