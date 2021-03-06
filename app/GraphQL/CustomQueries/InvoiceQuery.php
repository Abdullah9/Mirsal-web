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

class InvoiceQuery
{
    public function __invoke($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $invoiceQuery = Invoice::query();
        $vetOfferQuery = VetOffer::query();
        $vetRequestQuery = VetRequest::query();
        if(isset($args['id'])){
            $invoiceQuery = $invoiceQuery->where('id',$args['id']);
        }

        if(isset($args['client_id'])){
            $invoiceQuery = $invoiceQuery->where("client_id", $args['client_id']);
        }

        if(isset($args['vet_offer_id'])){
            $invoiceQuery = $invoiceQuery->where("vet_offer_id", $args['vet_offer_id']);
        }

        if(isset($args['driver_offer_id'])){
            $invoiceQuery = $invoiceQuery->where("driver_offer_id", $args['driver_offer_id']);
        }

        if(isset($args['payment_status'])){
            $invoiceQuery = $invoiceQuery->where("driver_offer_id", $args['driver_offer_id']);
        }

        if(isset($args['payment_for'])){
            $invoiceQuery = $invoiceQuery->where("payment_for", $args['payment_for']);
        }

        if(isset($args['reference_id'])){
            $invoiceQuery = $invoiceQuery->where("reference_id", $args['reference_id']);
        }

        if(isset($args['created_with_vet'])){
            if(isset($args['client_id'])){
                $vetRequestIds = $vetRequestQuery->where("client_id", $args['client_id'])->where("created_with_vet", $args['created_with_vet'])->pluck("id");
            } else {
                $vetRequestIds = $vetRequestQuery->where("created_with_vet", $args['created_with_vet'])->pluck("id"); 
            }
            $vetOfferIds = $vetOfferQuery->whereIn("vet_request_id", $vetRequestIds)->pluck("id");
            $invoiceQuery = $invoiceQuery->whereNull('vet_offer_id')->orWhereIn("vet_offer_id", $vetOfferIds);
            // echo json_encode($vetOfferIds,true);exit;
        }

        

        return $invoiceQuery;
    }

}