@extends('layouts.payment')



@section('content')
<form
    action="{{URL::to('/')}}/return-url-mada?payment_reference={{$data['response']['id']}}&inv_id={{urlencode($data['inv_id'])}}"
    class="paymentWidgets" data-brands="MADA"></form>
@endsection

@push('head')

<script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$data['response']['id']}}"></script>

@endpush
