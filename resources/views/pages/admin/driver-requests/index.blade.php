@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-uppercase text-info">
                    {{ __('lang.delivery_requests') }}

                </div>
                <div class="card-body">
                    <div class="table-responsive text-black">
                        <table data-order='[[ 0, "desc" ]]' class="datatable table">
                            <thead class="thead-info">
                                <tr>
                                    <th scope="col">#</th>
                                    <!-- <th scope="col">{{ __('lang.terms_and_conditions') }} {{ __('lang.en') }}</th> -->
                                    <th scope="col">{{ __('lang.type') }}</th>
                                    <th scope="col">{{ __('lang.animal') }}</th>
                                    <th scope="col">{{ __('lang.description') }}</th>
                                    <th scope="col">{{ __('lang.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['driverRequests'] as $index => $driverRequest)
                                <tr>
                                    <td>{{ $driverRequest->id}}</td>
                                    <td>{{ $driverRequest->type}}</td>
                                    {{-- <td>{{ App::getLocale() === "ar" ? $driverRequest->animal->name_ar : $driverRequest->animal->name }}
                                    </td> --}}
                                    <td>{{ $driverRequest->animal->name_ar}}</td>

                                    <td>{{ $driverRequest->description}}</td>
                                    <td>
                                        <a class="btn btn-info"
                                            href="{{ route('admins.driver-requests.show', $driverRequest->id ) }}">{{ __('lang.view') }}</a>
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
@endsection
