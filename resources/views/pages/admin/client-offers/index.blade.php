@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-uppercase text-info">
                    {{ __('lang.client_offers') }}

                </div>
                <div class="card-body">
                    <div class="table-responsive text-black">
                        <table class="datatable table">
                            <thead class="thead-info">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('lang.buyer') }}</th>
                                    <th scope="col">{{ __('lang.product') }}</th>
                                    <th scope="col">{{ __('lang.price') }}</th>
                                    <th scope="col">{{ __('lang.seller') }}</th>
                                    <th scope="col">{{ __('lang.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['clientOffers'] as $index => $clientOffer )
                                <tr>
                                    <td>{{ $clientOffer->id }}</td>
                                    <td>{{ $clientOffer->buyer->name}}</td>
                                    <td>{{ $clientOffer->product->title}}</td>
                                    <td>{{ $clientOffer->offered_price}}</td>
                                    <td>{{ $clientOffer->product->seller->name}}</td>
                                    <td> <button class="btn btn-warning  m-1" data-toggle="modal"
                                            data-target="#edit-client-offer-{{ $clientOffer->id }}">{{ __('lang.edit') }}</button><button
                                            class="btn btn-danger  m-1" data-toggle="modal"
                                            data-target="#delete-client-offer-{{ $clientOffer->id }}">{{ __('lang.delete') }}</button>
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

@foreach($data['clientOffers'] as $index => $clientOffer )
<div class="modal fade" id="delete-client-offer-{{ $clientOffer->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <form action="{{ route('admins.client-offers.destroy', $clientOffer->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('DELETE') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-danger text-white">

                    {{ __('lang.client_offers') }} : {{ $clientOffer->buyer->name }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{ __('lang.delete_client_offer_text') }}
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-inverse-danger" data-dismiss="modal"><i
                            class="fa fa-times"></i> {{ __('lang.close') }}</button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-check-square-o"></i>
                        {{ __('lang.delete') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-client-offer-{{ $clientOffer->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <form action="{{ route('admins.client-offers.update', $clientOffer->id ) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('PUT') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">{{ __('lang.edit_veterinarian') }}</h5>

                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.price') }}</label>
                        <input type="text" class="form-control" id="input-add-1" name="offered_price"
                            value="{{ $clientOffer->offered_price}}">
                    </div>
                    <div class="form-group">
                        <label for="input-add-4">{{ __('lang.notes') }}</label>
                        <input type="text" class="form-control" id="input-add-4" name="note"
                            value="{{ $clientOffer->note}}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse-warning" data-dismiss="modal"><i
                            class="fa fa-times"></i> {{ __('lang.close') }}</button>
                    <button type="submit" class="btn btn-warning"><i class="fa fa-check-square-o"></i>
                        {{ __('lang.save') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach

@endsection
