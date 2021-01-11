<?php

namespace App\Http\Controllers;

use App\Helpers\HyperPayCopyAndPay;
use App\Model\DriverOffer;
use App\Model\DriverRequest;
use App\Model\Invoice;
use App\Model\VetOffer;
use App\Model\VetRequest;
use Illuminate\Http\Request;

class HyperPayPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function payInvoice(Request $request)
    {

        $inv_id = $request->inv_id;
        $invoice = Invoice::find($inv_id);
        $data = array();
        $response = HyperPayCopyAndPay::request(str_replace(',', "", $invoice->amount_paid), 'VISA/MASTERCARD');
        $data['response'] = $response;
        $data['inv_id'] = $inv_id;
        $amount = $invoice->amount_paid;
        $data['amount_paid'] = str_replace(',', "", $invoice->amount_paid);
        // var_dump($data); exit;
        return view('pages.pay-invoice')->with(compact('data'));

    }

    public function returnUrl(Request $request)
    {
        $inv_id = $request->inv_id;
        $invoice = Invoice::find($inv_id);
        $url = "mirsal://payment?invoiceId=" . $inv_id;
        $response = \App\Helpers\HyperPayCopyAndPay::paymentStatus($request->resourcePath, 'VISA/MASTERCARD');

        // var_dump($response); exit;

        $result_code = $response['result']['code'];
        if ($result_code == "000.000.000" || $result_code == "000.100.110" || $result_code == "000.000.100") {
            $arr_result = array(
                "status" => 1,
                "code" => $result_code,
                "message" => $response['result']['description'],
            );
            $invoice->reference_id = $response['id'];
            $invoice->payment_gateway = "HyperPay";
            $invoice->payment_status = "PAID";
            $invoice->save();

            if ($invoice->payment_for == "VETERINARIAN") {
                $vet_offer = VetOffer::find($invoice->vet_offer_id);
                $vet_request = VetRequest::find($vet_offer->vet_request_id);
                $vet_offer->status = "ACCEPTED";
                $vet_request->status = "ACCEPTED";
                $vet_request->accepted_vet_offer_id = $invoice->vet_offer_id;
                $vet_offer->save();
                $vet_request->save();

            }
            if ($invoice->payment_for == "DRIVER") {
                $driver_offer = DriverOffer::find($invoice->driver_offer_id);
                $driver_request = DriverRequest::find($driver_offer->driver_request_id);
                $driver_offer->status = "ACCEPTED";
                $driver_request->status = "ACCEPTED";
                $driver_request->accepted_driver_offer_id = $invoice->driver_offer_id;
                $driver_offer->save();
                $driver_request->save();
            }

            return redirect()->away($url);
        } else {

            $invoice->payment_response = $response['result']['description'];
            $invoice->save();

            $arr_result = array(
                "status" => 0,
                "code" => $result_code,
                "message" => $response['result']['description'],
            );
            return redirect()->away($url);
        }

        $arr_result = array(
            "status" => 0,
            "code" => "",
            "message" => $response['result']['description'],
        );
        // return json_encode($arr_result);

        return redirect()->away($url);

        // return view('pages.return-url')->with(compact('response'));
    }
    public function payInvoiceMada(Request $request)
    {

        $inv_id = $request->inv_id;
        $invoice = Invoice::find($inv_id);
        $data = array();
        $response = HyperPayCopyAndPay::request(str_replace(',', "", $invoice->amount_paid), 'MADA');
        $data['response'] = $response;
        $data['inv_id'] = $inv_id;
        $amount = $invoice->amount_paid;
        $data['amount_paid'] = str_replace(',', "", $invoice->amount_paid);
        // var_dump($data); exit;
        return view('pages.pay-invoice-mada')->with(compact('data'));

    }

    public function returnUrlMada(Request $request)
    {
        $inv_id = $request->inv_id;
        $invoice = Invoice::find($inv_id);
        $url = "mirsal://payment?invoiceId=" . $inv_id;
        $response = \App\Helpers\HyperPayCopyAndPay::paymentStatus($request->resourcePath, 'MADA');

        // var_dump($response); exit;

        $result_code = $response['result']['code'];
        if ($result_code == "000.000.000" || $result_code == "000.100.110" || $result_code == "000.000.100") {
            $arr_result = array(
                "status" => 1,
                "code" => $result_code,
                "message" => $response['result']['description'],
            );
            $invoice->reference_id = $response['id'];
            $invoice->payment_gateway = "HyperPay";
            $invoice->payment_status = "PAID";
            $invoice->save();

            if ($invoice->payment_for == "VETERINARIAN") {
                $vet_offer = VetOffer::find($invoice->vet_offer_id);
                $vet_request = VetRequest::find($vet_offer->vet_request_id);
                $vet_offer->status = "ACCEPTED";
                $vet_request->status = "ACCEPTED";
                $vet_request->accepted_vet_offer_id = $invoice->vet_offer_id;
                $vet_offer->save();
                $vet_request->save();

            }
            if ($invoice->payment_for == "DRIVER") {
                $driver_offer = DriverOffer::find($invoice->driver_offer_id);
                $driver_request = DriverRequest::find($driver_offer->driver_request_id);
                $driver_offer->status = "ACCEPTED";
                $driver_request->status = "ACCEPTED";
                $driver_request->accepted_driver_offer_id = $invoice->driver_offer_id;
                $driver_offer->save();
                $driver_request->save();
            }

            return redirect()->away($url);
        } else {

            $invoice->payment_response = $response['result']['description'];
            $invoice->save();

            $arr_result = array(
                "status" => 0,
                "code" => $result_code,
                "message" => $response['result']['description'],
            );
            return redirect()->away($url);
        }

        $arr_result = array(
            "status" => 0,
            "code" => "",
            "message" => $response['result']['description'],
        );
        // return json_encode($arr_result);

        return redirect()->away($url);

        // return view('pages.return-url')->with(compact('response'));
    }
}