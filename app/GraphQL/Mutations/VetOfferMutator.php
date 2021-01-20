<?php

namespace App\GraphQL\Mutations;

use App\Model\AdminSetting;
use App\Model\Invoice;
use App\Model\VetOffer;
use App\Model\VetRequest;
use App\Model\VetTimeSlot;

class VetOfferMutator
{

    public function acceptVetOffer($root, array $args)
    {
        $vet_offer_id = $args['vet_offer_id'];

        $admin_setting = AdminSetting::get()->first();
        $vet_offer = VetOffer::find($vet_offer_id);
        $vet_request = VetRequest::find($vet_offer->vet_request_id);
        $vetTimeSlotQuery = VetTimeSlot::query();
        // echo json_encode($vet_request); exit;
        if ($vet_request->type == "VISIT" && $vet_request->vet_time_slot_id != null) {
            $vetTimeSlot = $vetTimeSlotQuery->find($vet_request->vet_time_slot_id);
            if ($vetTimeSlot->taken == 1) {
                return array(
                    'status' => 0,
                    'message' => __('lang.time_slot_taken'),
                );
            } else {
                $vetTimeSlot->taken = 1;
                $vetTimeSlot->save();
            }
        }

        if (isset($vet_offer_id)) {

            // $vet_offer->status = "ACCEPTED";
            // $vet_request->status = "ACCEPTED";
            $existingInvoice = Invoice::where('vet_offer_id', $vet_offer_id)->where('payment_for', 'VETERINARIAN')->get();

            if ($existingInvoice->isEmpty()) {

                $price = str_replace(',', "", $vet_offer->price);
                //Amount calculation
                // $invoice->amount_paid = $price;
                // if ($vet_request->type == "VISIT") {
                    // $admin_commission = $price * ($admin_setting->admin_commission_perc / 100);
                    // $admin_commission = $price * ($admin_setting->first_payment_perc / 100);
                // }

                $admin_commission = $price * ($admin_setting->admin_commission_perc / 100);
                
                $payable_amount = $price - $admin_commission;

                $amount_tax_price = $payable_amount * ($admin_setting->tax_perc / 100);
                $commission_tax_price = $admin_commission * ($admin_setting->tax_perc / 100);

                $payable_amount_with_tax = $payable_amount + $amount_tax_price;
                $admin_commission_with_tax = $admin_commission + $commission_tax_price;

                $tax_percentage = $admin_setting->tax_perc / 100;

                $invoice = new Invoice;
                $invoice->client_id = $vet_offer->vetRequest->client_id;
                $invoice->vet_offer_id = $vet_offer_id;

                $invoice->payment_for = "VETERINARIAN";
                if ($vet_request->type == "VISIT") {
                    $invoice->amount_paid = $admin_commission_with_tax;
                } else {
                    $invoice->amount_paid = $payable_amount_with_tax + $admin_commission_with_tax;
                }
                
                $invoice->tax_price = $amount_tax_price + $commission_tax_price;
                $invoice->tax_rate = $admin_setting->tax_perc;

                $invoice->service_provider_id = $vet_offer->vet_id;
                $invoice->provider_profit = $payable_amount_with_tax;
                $invoice->admin_commission = $admin_commission_with_tax;
                // $invoice->amount_paid = $admin_commission_with_tax;
                $invoice->save();
                $invoice = Invoice::find($invoice->id);

                $vet_offer->tax_price = $amount_tax_price;
                $vet_offer->first_payment_price = $admin_commission_with_tax;
                $vet_offer->total = $payable_amount_with_tax + $admin_commission_with_tax;
                $vet_offer->save();
                $vet_request->save();
                return array(
                    'status' => 1,
                    'message' => "Success",
                    'invoice' => $invoice,
                );
            } else {

                return array(
                    'status' => 1,
                    'message' => "Success",
                    'invoice' => $existingInvoice->first(),
                );
            }

        }

        return array(
            'status' => 0,
            'message' => "Failed",

        );

    }

}