@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-uppercase text-info">
                    {{ __('lang.veterinarians') }}
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#create-veterinarian"><i
                            aria-hidden="true" class="fa fa-plus"></i></button>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills nav-pills-info nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#piil-13"> <span
                                    class="hidden-xs">{{ __('lang.pending') }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#piil-14"> <span
                                    class="hidden-xs">{{ __('lang.accepted') }}</span></a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="piil-13" class="tab-pane active">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive text-black">
                                        <table class="datatable table" data-order='[[ 0, "desc" ]]'>
                                            <thead class="thead-info">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <!-- <th scope="col">{{ __('lang.terms_and_conditions') }} {{ __('lang.en') }}</th> -->
                                                    <th scope="col">{{ __('lang.name') }}</th>
                                                    <th scope="col">{{ __('lang.phone') }}</th>
                                                    <th scope="col">{{ __('lang.email') }}</th>
                                                    <th scope="col">{{ __('lang.status') }}</th>
                                                    <th scope="col">{{ __('lang.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data['pending_veterinarians'] as $index => $veterinarian)
                                                <tr>
                                                    <td>{{ $veterinarian->id }}</td>
                                                    <td>{{ $veterinarian->phone }}</td>
                                                    <td>{{ $veterinarian->name}}</td>
                                                    <td>{{ $veterinarian->email}}</td>
                                                    <td>{{ \App::getLocale() === "ar" ? $veterinarian->vet_status_ar : $veterinarian->vet_status }}
                                                    </td>
                                                    <td>
                                                        <!-- <button class="btn btn-warning  m-1" data-toggle="modal" data-target="#accept-vet-{{ $veterinarian->id }}">{{ __('lang.edit') }}</button> -->
                                                        <a class="btn btn-info  m-1"
                                                            href="{{ route('admins.veterinarians.show', $veterinarian->id ) }}">{{ __('lang.show') }}</a>
                                                    </td>
                                                </tr>



                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="piil-14" class="tab-pane fade">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive text-black">
                                        <table class="datatable table" data-order='[[ 0, "desc" ]]'>
                                            <thead class="thead-info">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <!-- <th scope="col">{{ __('lang.terms_and_conditions') }} {{ __('lang.en') }}</th> -->
                                                    <th scope="col">{{ __('lang.name') }}</th>
                                                    <th scope="col">{{ __('lang.phone') }}</th>
                                                    <th scope="col">{{ __('lang.email') }}</th>
                                                    <th scope="col">{{ __('lang.status') }}</th>
                                                    <th scope="col">{{ __('lang.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data['accepted_veterinarians'] as $index => $veterinarian)
                                                <tr>
                                                    <td>{{ $veterinarian->id }}</td>
                                                    <td>{{ $veterinarian->phone }}</td>
                                                    <td>{{ $veterinarian->name}}</td>
                                                    <td>{{ $veterinarian->email}}</td>
                                                    <td>{{ \App::getLocale() === "ar" ? $veterinarian->vet_status_ar : $veterinarian->vet_status }}
                                                    </td>
                                                    <td>
                                                        <!-- <button class="btn btn-warning  m-1" data-toggle="modal" data-target="#accept-vet-{{ $veterinarian->id }}">{{ __('lang.edit') }}</button> -->
                                                        <a class="btn btn-info  m-1"
                                                            href="{{ route('admins.veterinarians.show', $veterinarian->id ) }}">{{ __('lang.show') }}</a>
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


@foreach($data['pending_veterinarians'] as $index => $veterinarian)


@if($veterinarian->vet_status == "PENDING")

<div class="modal fade" id="accept-vet-{{ $veterinarian->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <form action="{{ route('admins.veterinarians.accept', $veterinarian->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('PUT') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-success text-white">

                    {{ $veterinarian->name }}
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

<div class="modal fade" id="edit-vet-{{ $veterinarian->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <form action="{{ route('admins.veterinarians.update', $veterinarian->id ) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('PUT') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">{{ __('lang.edit_veterinarian') }}</h5>

                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.name') }}</label>
                        <input type="text" class="form-control" id="input-add-1" placeholder="Enter Veterinarian Name "
                            name="name" value="{{ $veterinarian->name}}">
                    </div>
                    <div class="form-group">
                        <label for="input-add-4">{{ __('lang.phone') }}</label>
                        <input type="text" class="form-control" id="input-add-4" placeholder="Enter veterinarian Phone "
                            name="phone" value="{{ $veterinarian->phone}}">
                        @if($errors->has('phone'))
                        <label id="input-1-error" class="error" for="input-1">{{ $errors->first('phone') }}</label>
                        @endIf
                    </div>
                    <div class="form-group">
                        <label for="input-add-3">{{ __('lang.password') }}</label>
                        <input type="password" class="form-control" id="input-add-3"
                            placeholder="Enter veterinarian password " name="password">
                    </div>
                    <div class="form-group">
                        <label for="input-add-2">{{ __('lang.email') }}</label>
                        <input type="text" class="form-control" id="input-add-2" placeholder="Enter veterinarian email "
                            name="email" value="{{ $veterinarian->email}}">
                        @if($errors->has('email'))
                        <label id="input-1-error" class="error" for="input-1">{{ $errors->first('email') }}</label>
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

<div class="modal fade" id="delete-vet-{{ $veterinarian->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <form action="{{ route('admins.veterinarians.destroy', $veterinarian->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('DELETE') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-danger text-white">

                    {{ $veterinarian->name }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{ __('lang.delete_vet_text') }}
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

<div class="modal fade" id="create-veterinarian" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <form action="{{ route('admins.veterinarians.store') }}" method="POST" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white">{{ __('lang.create_veterinarian') }}</h5>

                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.name') }}</label>
                        <input type="text" class="form-control" id="input-add-1"
                            placeholder="{{ __('lang.input_name') }}" name="name">
                    </div>
                    <div class="form-group">
                        <label for="input-add-2">{{ __('lang.phone') }}</label>
                        <input type="text" class="form-control" id="input-add-2"
                            placeholder="{{ __('lang.input_phone') }}" name="phone">
                        @if($errors->has('phone'))
                        <label id="input-2-error" class="error" for="input-2">{{ $errors->first('phone') }}</label>
                        @endIf
                    </div>
                    <div class="form-group">
                        <label for="input-add-3">{{ __('lang.password') }}</label>
                        <input type="password" class="form-control" id="input-add-3" name="password">
                    </div>
                    <div class="form-group">
                        <label for="input-add-4">{{ __('lang.email') }}</label>
                        <input type="text" class="form-control" id="input-add-4"
                            placeholder="{{ __('lang.input_email') }}" name="email">
                        @if($errors->has('email'))
                        <label id="input-4-error" class="error" for="input-4">{{ $errors->first('email') }}</label>
                        @endIf
                    </div>
                    <div class="form-group">
                        <label for="input-add-5">{{ __('lang.avatar') }}</label>
                        <input type="file" class="form-control-file" id="input-add-5" name="avatar"></input>
                        @if($errors->has('avatar'))
                        <label id="input-5-error" class="error" for="input-5">{{ $errors->first('avatar') }}</label>
                        @endIf
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

@section('script')
<script type="text/javascript">
    $( document ).ready(function() {
            var err = "<?php echo  $errors->any(); ?>";
            if (err > 0) {


    $('#create-veterinarian').modal({
    show: true
        });
}

});

</script>
@endsection
