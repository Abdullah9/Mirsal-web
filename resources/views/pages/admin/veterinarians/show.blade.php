@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid">
    @if ($errors->any())
    <div class="row" style="direction:rtl;text-align:right;">
        <div class="col-md-6">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-uppercase text-info">
                    <div class="row">
                        <div class="col-lg-6">{{ __('lang.veterinarian') }} </div>

                        <div class="col-lg-6 text-left">

                            <button type="button" class="btn btn-warning btn-sm waves-effect waves-light m-1"
                                data-toggle="modal"
                                data-target="#edit-veterinarian-{{ $data['veterinarian']->id }}">{{ __('lang.edit') }}</button>
                            <button type="button" class="btn btn-danger btn-sm waves-effect waves-light m-1"
                                data-toggle="modal"
                                data-target="#delete-veterinarian-{{ $data['veterinarian']->id }}">{{ __('lang.delete') }}</button>
                            @if($data['veterinarian']->vet_status == "PENDING")
                            <button class="btn btn-success btn-sm waves-effect waves-light m-1" data-toggle="modal"
                                data-target="#accept-vet-{{ $data['veterinarian']->id }}">{{ __('lang.accept') }}</button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body bg-primary">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card ">
                                <div class="card-header text-uppercase text-info">
                                    {{ __('lang.information') }}
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3"><img class="rounded-circle"
                                                src="{{$data['veterinarian']->avatar}}" alt="" height="100px"
                                                width="100px"></div>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-4 text-strong">
                                                    {{ __('lang.name') }} :
                                                </div>
                                                <div class="col-8">
                                                    <strong>{{ $data['veterinarian']->name}}</strong>
                                                </div>
                                                <div class="col-4 text-strong">
                                                    {{ __('lang.phone') }} :
                                                </div>
                                                <div class="col-8">
                                                    <strong>{{ $data['veterinarian']->phone}}</strong>
                                                </div>
                                                <div class="col-4 text-strong">
                                                    {{ __('lang.email') }} :
                                                </div>
                                                <div class="col-8">
                                                    <strong>{{ $data['veterinarian']->email}}</strong>
                                                </div>

                                            </div>
                                        </div>



                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header text-uppercase text-info">
                                    {{ __('lang.image') }}
                                </div>
                                <div class="card-body img-centered">
                                    @if(isset($data['veterinarian']->national_id_url))
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <img class="img-thumbnail" src="{{ $data['veterinarian']->national_id_url}}"
                                                alt="Default" height="200px" width="230px">
                                        </div>

                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            {{ __('lang.nothing_found') }}
                                        </div>

                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header text-uppercase text-info">
                                    {{ __('lang.time_slots') }}
                                    <!-- <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create-time-slot"><i aria-hidden="true" class="fa fa-plus"></i></button> -->
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive text-black">
                                        <table class="datatable table">
                                            <thead class="thead-info">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <!-- <th scope="col">{{ __('lang.terms_and_conditions') }} {{ __('lang.en') }}</th> -->
                                                    <th scope="col">{{ __('lang.date') }}</th>
                                                    <th scope="col">{{ __('lang.from') }}</th>
                                                    <th scope="col">{{ __('lang.to') }}</th>
                                                    <!-- <th scope="col">{{ __('lang.action') }}</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data['veterinarian']->vetTimeSlots as $index => $timeSlot)
                                                <tr>
                                                    <td>{{ $timeSlot->id }}</td>
                                                    <td>{{ $timeSlot->available_date_ar}}</td>
                                                    <td>{{ $timeSlot->from}}</td>
                                                    <td>{{ $timeSlot->to}}</td>
                                                    <!-- <td> <button class="btn btn-warning  m-1" data-toggle="modal" data-target="#edit-time-slot-{{$timeSlot->id}}">{{ __('lang.edit') }}</button>
                                    <button type="button" class="btn btn-danger m-1" data-toggle="modal" data-target="#delete-time-slot-{{ $timeSlot->id }}">{{ __('lang.delete') }}</button> -->
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

<div class="modal fade" id="edit-veterinarian-{{ $data['veterinarian']->id }}" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <form action="{{ route('admins.veterinarians.update', $data['veterinarian']->id ) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('PUT') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">{{ __('lang.edit_veterinarian') }}</h5>

                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.name') }}</label>
                        <input type="text" class="form-control" id="input-add-1" placeholder="Enter veterinarian Name "
                            name="name" value="{{ $data['veterinarian']->name}}">
                    </div>
                    <div class="form-group">
                        <label for="input-add-4">{{ __('lang.phone') }}: {{ $data['veterinarian']->phone}}</label>
                        <input type="text" class="form-control" id="input-add-4" placeholder="Enter veterinarian Phone "
                            name="phone" value="">
                        @if($errors->has('phone'))
                        <label id="input-5-error" class="error" for="input-5">{{ $errors->first('phone') }}</label>
                        @endIf
                    </div>
                    <div class="form-group">
                        <label for="input-add-3">{{ __('lang.password') }}</label>
                        <input type="password" class="form-control" id="input-add-3"
                            placeholder="Enter veterinarian password " name="password">
                    </div>
                    <div class="form-group">
                        <label for="input-add-2">{{ __('lang.email') }}: {{ $data['veterinarian']->email}}</label>
                        <input type="text" class="form-control" id="input-add-2" placeholder="Enter veterinarian email "
                            name="email" value="">
                        @if($errors->has('email'))
                        <label id="input-5-error" class="error" for="input-5">{{ $errors->first('email') }}</label>
                        @endIf
                    </div>
                    <div class="form-group">
                        <label for="input-add-5">{{ __('lang.avatar') }}</label>
                        <input type="file" class="form-control-file" id="input-add-5"
                            placeholder="Enter veterinarian email " name="avatar"></input>
                        @if($errors->has('avatar'))
                        <label id="input-5-error" class="error" for="input-5">{{ $errors->first('avatar') }}</label>
                        @endIf
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

<div class="modal fade" id="delete-veterinarian-{{ $data['veterinarian']->id }}" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <form action="{{ route('admins.veterinarians.destroy', $data['veterinarian']->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('DELETE') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-danger text-white">

                    {{ $data['veterinarian']->name }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{ __('lang.delete_veterinarian_text') }}
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

@if($data['veterinarian']->vet_status == "PENDING")

<div class="modal fade" id="accept-vet-{{ $data['veterinarian']->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <form action="{{ route('admins.veterinarians.accept', $data['veterinarian']->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('PUT') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-success text-white">

                    {{ $data['veterinarian']->name }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{ __('lang.accept_vet_text') }}
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-inverse-success" data-dismiss="modal"><i
                            class="fa fa-times"></i> {{ __('lang.close') }}</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i>
                        {{ __('lang.save') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endif

@endsection


@section('script')
<script type="text/javascript">
    $( document ).ready(function() {
            var err = "<?php echo  $errors->any(); ?>";
            var id = "<?php echo  $data['veterinarian']->id; ?>";
            if (err > 0) {


    $('#edit-veterinarian-'+id).modal({
    show: true
        });
}

});

</script>
@endsection
