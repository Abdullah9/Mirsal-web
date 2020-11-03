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

        $vetRequests = VetRequest::where("client_id", $client_id)->where("type", "CONSULTATION")->where("status","ACCEPTED");
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

        $vetRequests = VetRequest::where("client_id", $client_id)->where("type", "CONSULTATION")->where("status","COMPLETED");
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

        $vetRequests = VetRequest::whereIn("accepted_vet_offer_id", $vetOfferIds)->where("type", "CONSULTATION")->where("status","ACCEPTED");
        if($vetRequests->get()->isEmpty())
            return $vetRequests;
        $vetOfferIds = $vetRequests->pluck('accepted_vet_offer_id');
        $vetOffers = VetOffer::whereIn("id", $vetOfferIds)->where("vet_id", $vet_id);

        return $vetOffers;
    }

    public function previousAsVet($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $vet_id = $args['vet_id'];
        $vetOffers = VetOffer::where("vet_id", $vet_id)->where("status", "COMPLETED");
        
        return $vetOffers;
    }
}