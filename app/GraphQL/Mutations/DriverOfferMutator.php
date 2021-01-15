<?php

namespace App\GraphQL\Mutations;

use App\Model\AdminSetting;
use App\Model\DriverOffer;
use App\Model\DriverRequest;
use App\Model\Invoice;

class DriverOfferMutator
{

    public function acceptDriverOffer($root, array $args)
    {
        $driver_offer_id = $args['driver_offer_id'];
        $admin_setting = AdminSetting::all()->first();
        $driver_offer = DriverOffer::find($driver_offer_id);
        $driver_request = DriverRequest::find($driver_offer->driver_request_id);

        if (isset($driver_offer_id)) {

            // $driver_offer->status = "ACCEPTED";
            // $driver_request->status = "ACCEPTED";
            $existingInvoice = Invoice::where('driver_offer_id', $driver_offer_id)->where('payment_for', 'DRIVER')->get();
            if ($existingInvoice->isEmpty()) {
                $invoice = new Invoice;
                $invoice->client_id = $driver_offer->DriverRequest->client_id;
                $invoice->driver_offer_id = $driver_offer_id;
                // $invoice->offer_id = $driver_offer_id;
                $invoice->payment_for = "Driver";
                $price = str_replace(',', "", $driver_offer->price);

                $first_payment_price = $price * ($admin_setting->first_payment_perc / 100);
                $payable_amount = $price - $first_payment_price;

                $amount_tax_price = $payable_amount * ($admin_setting->tax_perc / 100);
                $commission_tax_price = $first_payment_price * ($admin_setting->tax_perc / 100);

                $payable_amount_with_tax = $payable_amount + $amount_tax_price;
                $admin_commission_with_tax = $first_payment_price + $commission_tax_price;

                $tax_price = $first_payment_price * ($admin_setting->tax_perc / 100);

                $invoice->tax_price = $commission_tax_price;
                $invoice->tax_rate = $admin_setting->tax_perc;
                $invoice->first_payment_perc = $admin_setting->first_payment_perc;

                $invoice->service_provider_id = $driver_offer->driver_id;
                $invoice->provider_profit = $payable_amount_with_tax;
                $invoice->admin_commission = $admin_commission_with_tax;

                $invoice->amount_paid = $admin_commission_with_tax;

                $invoice->save();
                $invoice = Invoice::find($invoice->id);

                $driver_offer->tax_price = $tax_price;
                $driver_offer->first_payment_price = $admin_commission_with_tax;
                $driver_offer->save();
                $driver_request->save();
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