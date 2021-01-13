@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-uppercase text-info">
                    {{ __('lang.cars') }}
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create-car"><i
                            aria-hidden="true" class="fa fa-plus"></i></button>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-black">
                        <table class="datatable table">
                            <thead class="thead-info">
                                <tr>
                                    <th scope="col">#</th>
                                    <!-- <th scope="col">{{ __('lang.terms_and_conditions') }} {{ __('lang.en') }}</th> -->
                                    <th scope="col">{{ __('lang.name') }}</th>
                                    <th scope="col">{{ __('lang.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['cars'] as $index => $car)
                                <tr>
                                    <td>{{ $car->id }}</td>
                                    <td>{{ $car->name_ar}}</td>
                                    <td>
                                        <button class="btn btn-warning  m-1" data-toggle="modal"
                                            data-target="#edit-car-{{$car->id}}">{{ __('lang.edit') }}</button>
                                        <button type="button" class="btn btn-danger m-1" data-toggle="modal"
                                            data-target="#delete-car-{{ $car->id }}">{{ __('lang.delete') }}</button>
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

@foreach ($data['cars'] as $car)

<div class="modal fade" id="edit-car-{{$car->id}}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <form action="{{ route('admins.cars.update', $car->id ) }}" method="POST" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">{{ __('lang.edit_car') }}</h5>

                </div>
                <div class="modal-body">
                    <!-- <div class="form-group">
                <label for="input-add-1">{{ __('lang.name') }} {{ __('lang.en') }}</label>
                <input type="text" class="form-control" id="input-add-1" placeholder="Enter car Name EN" name="name" value="{{ $car->name}}">

            </div> -->
                    <div class="form-group">
                        <label for="input-add-2">{{ __('lang.name') }}</label>
                        <input type="text" class="form-control" id="input-add-2" placeholder="Enter car Name AR"
                            name="name_ar" value="{{ $car->name_ar}}">

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

<div class="modal fade" id="delete-car-{{ $car->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <form action="{{ route('admins.cars.destroy', $car->id) }}" method="POST" enctype="multipart/form-data">
                {{ method_field('DELETE') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-danger text-white">

                    {{ $car->name_ar }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{ __('lang.delete_car_text') }}
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


@endforeach

<div class="modal fade" id="create-car" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <form action="{{ route('admins.cars.store') }}" method="POST" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white">{{ __('lang.create_car') }}</h5>

                </div>
                <div class="modal-body">
                    <!-- <div class="form-group">
                <label for="input-1">{{ __('lang.name') }} {{ __('lang.en') }}</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="input-1" placeholder="Enter car Name EN" name="name" value="">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> -->
                    <div class="form-group">
                        <label for="input-2">{{ __('lang.name') }}</label>
                        <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="input-2"
                            name="name_ar" value="">
                        @error('name_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse-success" data-dismiss="modal"><i
                            class="fa fa-times"></i> {{ __('lang.close') }}</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i>
                        {{ __('lang.save') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
