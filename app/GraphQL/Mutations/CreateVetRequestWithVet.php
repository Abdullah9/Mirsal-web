<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Model\DriverOffer;
use App\Model\DriverRequest;
use App\Model\Invoice;
use App\Model\AdminSetting;

use App\Model\VetRequest;
use App\Model\VetOffer;
use App\Model\Address;
use App\User;
use App\GraphQL\Mutations\VetOfferMutator;

class CreateVetRequestWithVet
{
    
    public function createWithVet($root, array $args)
    {
        // echo json_encode($args); exit;
        if(isset($args['address'])){
            $address = Address::create($args['address']['create']);
            $args['address_id'] = $address->id;
        }
        
        $args['created_with_vet'] = 1;
        $vet_request = VetRequest::create($args);
        $vet = User::find($args['vet_id']);


        $price = "0";
        if($args["type"] == "CONSULTATION"){
            $price = $vet->consultation_price;
        }
        if($args["type"] == "VISIT"){
            $price = $vet->visit_price;
        }

        $vet_offer = VetOffer::create(
            array(
                "vet_id" => $args['vet_id'],
                "vet_request_id" => $vet_request->id,
                "price" => $price,
            )
        );

        // $vet_request->accepted_vet_offer_id = $vet_offer->id;
        // $vet_request->save();
        $input = array(
            "vet_offer_id" => $vet_offer->id,
        );
        $vetOfferMutator = new VetOfferMutator;
        $return_vetOfferMutator = $vetOfferMutator->acceptVetOffer("",$input);


        $arr = array(
            "vet_request" => $vet_request,
            "invoice" => $return_vetOfferMutator['invoice'],
        );

        return $arr;
        
    }

}
