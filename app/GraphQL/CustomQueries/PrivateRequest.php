<?php

namespace App\GraphQL\CustomQueries;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Invoice;
use App\Model\DriverOffer;
use App\Model\DriverRequest;

class PrivateRequest
{

    public function currentAsClient($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $client_id = $args['client_id'];

        $driverRequests = DriverRequest::where("client_id", $client_id)->where("type", "PRIVATE")->where("status","ACCEPTED");
        if($driverRequests->get()->isEmpty())
            return $driverRequests;
        $driverOfferIds = $driverRequests->pluck('accepted_driver_offer_id');
        $driverOfferIds = Invoice::where('payment_status', 'PAID')->whereIn('driver_offer_id', $driverOfferIds)->where('payment_for','DRIVER')->pluck('driver_offer_id');
        
        $driverOffers = DriverOffer::whereIn("id", $driverOfferIds);
        return $driverOffers;

    }

    public function previousAsClient($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $client_id = $args['client_id'];

        $driverRequests = DriverRequest::where("client_id", $client_id)->where("type", "PRIVATE")->where("status","COMPLETED");
        if($driverRequests->get()->isEmpty())
            return $driverRequests;
        $driverOfferIds = $driverRequests->pluck('accepted_driver_offer_id');
        $driverOffers = DriverOffer::whereIn("id", $driverOfferIds)->where("driver_id", $driver_id)->where("status", "COMPLETED")->pluck('id');
        return $driverOffers;
    }

    public function currentAsDriver($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $driver_id = $args['driver_id'];
        $driverOffers = DriverOffer::where("driver_id", $driver_id)->where("status", "ACCEPTED");

        if($driverOffers->get()->isEmpty())
            return $driverOffers;
        $driverOfferIds = $driverOffers->pluck('id');

        $invoices = Invoice::where('payment_status', 'PAID')->whereIn('driver_offer_id', $driverOfferIds)->where('payment_for','DRIVER');

        if($invoices->get()->isEmpty())
            return $invoices;
        $driverOfferIds = $invoices->pluck('driver_offer_id');

        $driverRequests = DriverRequest::whereIn("accepted_driver_offer_id", $driverOfferIds)->where("type", "PRIVATE")->where("status","ACCEPTED");
        if($driverRequests->get()->isEmpty())
            return $driverRequests;
        $driverOfferIds = $driverRequests->pluck('accepted_driver_offer_id');
        $driverOffers = DriverOffer::whereIn("id", $driverOfferIds)->where("driver_id", $driver_id);

        return $driverOffers;
    }

    public function previousAsDriver($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $driver_id = $args['driver_id'];
        $driverOffers = DriverOffer::where("driver_id", $driver_id)->where("status", "COMPLETED");
        
        return $driverOffers;
    }
}