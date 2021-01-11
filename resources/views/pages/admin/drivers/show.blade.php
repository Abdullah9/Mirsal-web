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
                        <div class="col-lg-6">{{ __('lang.driver') }} </div>

                        <div class="col-lg-6 text-left">

                            <button type="button" class="btn btn-warning btn-sm waves-effect waves-light m-1"
                                data-toggle="modal"
                                data-target="#edit-driver-{{ $data['driver']->id }}">{{ __('lang.edit') }}</button>
                            <button type="button" class="btn btn-danger btn-sm waves-effect waves-light m-1"
                                data-toggle="modal"
                                data-target="#delete-driver-{{ $data['driver']->id }}">{{ __('lang.delete') }}</button>

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
                                                src="{{$data['driver']->avatar}}" alt="" height="100px" width="100px">
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-4 text-strong">
                                                    {{ __('lang.name') }} :
                                                </div>
                                                <div class="col-8">
                                                    <strong>{{ $data['driver']->name}}</strong>
                                                </div>
                                                <div class="col-4 text-strong">
                                                    {{ __('lang.phone') }} :
                                                </div>
                                                <div class="col-8">
                                                    <strong>{{ $data['driver']->phone}}</strong>
                                                </div>
                                                <div class="col-4 text-strong">
                                                    {{ __('lang.email') }} :
                                                </div>
                                                <div class="col-8">
                                                    <strong>{{ $data['driver']->email}}</strong>
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
                                    @if(isset($data['driver']->national_id_url))
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <img class="img-thumbnail" src="{{ $data['driver']->national_id_url}}"
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

                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="edit-driver-{{ $data['driver']->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <form action="{{ route('admins.drivers.update', $data['driver']->id ) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('PUT') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">{{ __('lang.edit_driver') }}</h5>

                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.name') }}</label>
                        <input type="text" class="form-control" id="input-add-1" placeholder="Enter driver Name "
                            name="name" value="{{ $data['driver']->name}}">
                    </div>
                    <div class="form-group">
                        <label for="input-add-4">{{ __('lang.phone') }}: {{ $data['driver']->phone}}</label>
                        <input type="text" class="form-control" id="input-add-4" placeholder="Enter driver Phone "
                            name="phone" value="">
                        @if($errors->has('phone'))
                        <label id="input-5-error" class="error" for="input-5">{{ $errors->first('phone') }}</label>
                        @endIf
                    </div>
                    <div class="form-group">
                        <label for="input-add-3">{{ __('lang.password') }}</label>
                        <input type="password" class="form-control" id="input-add-3"
                            placeholder="Enter driver password " name="password">
                    </div>
                    <div class="form-group">
                        <label for="input-add-2">{{ __('lang.email') }}: {{ $data['driver']->email}}</label>
                        <input type="text" class="form-control" id="input-add-2" placeholder="Enter driver email "
                            name="email" value="">
                        @if($errors->has('email'))
                        <label id="input-5-error" class="error" for="input-5">{{ $errors->first('email') }}</label>
                        @endIf
                    </div>
                    <div class="form-group">
                        <label for="input-add-5">{{ __('lang.avatar') }}</label>
                        <input type="file" class="form-control-file" id="input-add-5" placeholder="Enter driver email "
                            name="avatar"></input>
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

<div class="modal fade" id="delete-driver-{{ $data['driver']->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <form action="{{ route('admins.drivers.destroy', $data['driver']->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('DELETE') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-danger text-white">

                    {{ $data['driver']->name }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{ __('lang.delete_driver_text') }}
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

@endsection



@section('script')
<script type="text/javascript">
    $( document ).ready(function() {
            var err = "<?php echo  $errors->any(); ?>";
            var id = "<?php echo  $data['driver']->id; ?>";
            if (err > 0) {


    $('#edit-driver-'+id).modal({
    show: true
        });
}

});

</script>
@endsection
