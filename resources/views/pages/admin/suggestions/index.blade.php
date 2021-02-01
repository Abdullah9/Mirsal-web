@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-uppercase text-info">
                {{ __('lang.suggestions') }} 

                </div>
                <div class="card-body">
                    <div class="table-responsive text-black">
                    <table data-order='[[ 0, "desc" ]]' class="datatable table">
                        <thead class="thead-info">
                        <tr>
                            <th scope="col">#</th>
                            <!-- <th scope="col">{{ __('lang.terms_and_conditions') }} {{ __('lang.en') }}</th> -->
                            <th scope="col">{{ __('lang.name') }}</th>
                            <th scope="col">{{ __('lang.phone') }}</th>
                            <th scope="col">{{ __('lang.message') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['suggestions'] as $index => $suggestion)
                            <tr>
                            <td>{{ $suggestion->id }}</td>
                            <td>{{ $suggestion->name }}</td>
                            <td>{{ $suggestion->phone }}</td>
                            <td>{{ $suggestion->message }}</td>
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
