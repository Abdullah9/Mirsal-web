@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-uppercase text-info">
                    <div class="row">
                        <div class="col-lg-6">{{ __('lang.service_provider') }} </div>
                    </div>
                </div>

                <div class="card-body bg-primary">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card ">
                                <div class="card-header text-uppercase text-info">
                                    {{ __('lang.information') }}
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-2"><img class="rounded-circle"
                                                src="{{$data['service_provider']->avatar}}" alt="" height="100px"
                                                width="100px"></div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-2 text-strong">
                                                    {{ __('lang.name') }} :
                                                </div>
                                                <div class="col-10">
                                                    <strong>{{ $data['service_provider']->name}}</strong>
                                                </div>
                                                <div class="col-2 text-strong">
                                                    {{ __('lang.phone') }} :
                                                </div>
                                                <div class="col-10">
                                                    <strong>{{ $data['service_provider']->phone}}</strong>
                                                </div>
                                                <div class="col-2 text-strong">
                                                    {{ __('lang.email') }} :
                                                </div>
                                                <div class="col-10">
                                                    <strong>{{ $data['service_provider']->email}}</strong>
                                                </div>
                                                <div class="col-2 text-strong">
                                                    {{ __('lang.role') }} :
                                                </div>
                                                <div class="col-10">
                                                    @if($data['service_provider']->role == "VETERINARIAN")
                                                    <strong>{{ __('lang.veterinarian') }}</strong>
                                                    @elseif($data['service_provider']->role == "DRIVER")
                                                    <strong>{{ __('lang.driver') }}</strong>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>



                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header text-uppercase text-info">
                                    {{ __('lang.paid_invoices') }}
                                    <!-- <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create-time-slot"><i aria-hidden="true" class="fa fa-plus"></i></button> -->
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive text-black">
                                        <table class="datatable table">
                                            <thead class="thead-info">
                                                <tr>
                                                    <th scope="col">#</th>

                                                    <th scope="col">{{ __('lang.status') }}</th>
                                                    <th scope="col">{{ __('lang.provider_profit') }}</th>
                                                    <th scope="col">{{ __('lang.app_commission') }}</th>
                                                    {{-- <th scope="col">{{ __('lang.edit') }} {{ __('lang.status') }}
                                                    </th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data['service_provider']->providerInvoices as $index =>
                                                $invoice)
                                                <tr>
                                                <tr>
                                                    <td>
                                                        {{-- <form id="update_invoice{{ $invoice->id}}"
                                                        action="{{ route('admin.client-offers.update', $invoice->id) }}"
                                                        method="POST">
                                                        {{ csrf_field() }} --}}
                                                        @if($invoice->payment_status == PAID)
                                                        <button class="btn btn-warning  m-1"
                                                            onclick="paidStatus('{{ $invoice->id }}')">{{ __('lang.paid') }}</button>
                                                        @endIf
                                                        @if($invoice->payment_status == PENDING)

                                                        <button class="btn btn-danger  m-1"
                                                            onclick="pendingStatus('{{ $invoice->id }}')">{{ __('lang.pending') }}</button>
                                                        @endIf
                                                        {{--
                                                        <input type="hidden" name="payment_status"
                                                            id="invoice_{{ $invoice->id}}" class="expert_id" value="">
                                                        --}}


                                                        {{-- </form> --}}
                                                    </td>

                                                    <td>{{ $invoice->id }}</td>
                                                    <td>{{ $invoice->provider_profit}}</td>
                                                    <td>{{ $invoice->admin_commission}}</td>
                                                    <td>{{ $invoice->payment_status}}</td>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
{{-- <script type="text/javascript">
    function paidStatus(id){


      $('#invoice_'+id).attr('value', 'PENDING');
      $('form#update_invoice'+id).submit();

    }
    function pendingStatus(id){


      $('#invoice_'+id).attr('value', 'PAID');
      $('form#update_invoice'+id).submit();

}
</script> --}}
@endsection
