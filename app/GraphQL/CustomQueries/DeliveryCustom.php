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

class DeliveryCustom
{

    public function currentAsClient($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $client_id = $args['client_id'];

        if(isset($args['type'])){
            $driverRequests = DriverRequest::where("client_id", $client_id)->where("type", $args['type'])->where("status","ACCEPTED")->where('client_completed', "NO");
        } else {
            $driverRequests = DriverRequest::where("client_id", $client_id)->where("status","ACCEPTED")->where('client_completed', "NO");
        }

        // $driverRequests = DriverRequest::where("client_id", $client_id)->where("type", $args['type'])->where("status","ACCEPTED");
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
        
        if(isset($args['type'])){
            $driverRequests = DriverRequest::where("client_id", $client_id)->where("type", $args['type'])->where('client_completed', "YES");
        } else {
            $driverRequests = DriverRequest::where("client_id", $client_id)->where('client_completed', "YES");
        }
        
        if($driverRequests->get()->isEmpty())
            return $driverRequests;
        $driverOfferIds = $driverRequests->pluck('accepted_driver_offer_id');
        $driverOffers = DriverOffer::whereIn("id", $driverOfferIds);
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

        if(isset($args['type'])){
            $driverRequests = DriverRequest::whereIn("accepted_driver_offer_id", $driverOfferIds)->where("type", $args['type'])->where("status","ACCEPTED")->where('client_completed', "NO");
        } else {
            $driverRequests = DriverRequest::whereIn("accepted_driver_offer_id", $driverOfferIds)->where("status","ACCEPTED")->where('client_completed', "NO");
        }
        
        if($driverRequests->get()->isEmpty())
            return $driverRequests;
        $driverOfferIds = $driverRequests->pluck('accepted_driver_offer_id');
        $driverOffers = DriverOffer::whereIn("id", $driverOfferIds)->where("driver_id", $driver_id);

        return $driverOffers;
    }

    public function previousAsDriver($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $driver_id = $args['driver_id'];
        $driverOffers = DriverOffer::where("driver_id", $driver_id)->whereIn('status', ["ACCEPTED", "COMPLETED"]);
        if($driverOffers->get()->isEmpty())
            return $driverOffers;
        $driverOfferIds = $driverOffers->pluck('id');

        if(isset($args['type'])){
            $driverRequests = DriverRequest::whereIn("accepted_driver_offer_id", $driverOfferIds)->where("type", $args['type'])->where('client_completed', "YES");
        } else {
            $driverRequests = DriverRequest::whereIn("accepted_driver_offer_id", $driverOfferIds)->where('client_completed', "YES");
        }
        
        if($driverRequests->get()->isEmpty())
            return $driverRequests;
        $driverOfferIds = $driverRequests->pluck('accepted_driver_offer_id');

        $driverOffers = DriverOffer::whereIn("id", $driverOfferIds)->where("driver_id", $driver_id);

        return $driverOffers;
    }
}