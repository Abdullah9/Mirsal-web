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
                        <div class="col-lg-6">{{ __('lang.client') }} </div>

                        <div class="col-lg-6 text-left">

                            <button type="button" class="btn btn-warning btn-sm waves-effect waves-light m-1"
                                data-toggle="modal"
                                data-target="#edit-client-{{ $data['client']->id }}">{{ __('lang.edit') }}</button>
                            <button type="button" class="btn btn-danger btn-sm waves-effect waves-light m-1"
                                data-toggle="modal"
                                data-target="#delete-client-{{ $data['client']->id }}">{{ __('lang.delete') }}</button>

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
                                                src="{{$data['client']->avatar}}" alt="" height="100px" width="100px">
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-4 text-strong">
                                                    {{ __('lang.name') }} :
                                                </div>
                                                <div class="col-8">
                                                    <strong>{{ $data['client']->name}}</strong>
                                                </div>
                                                <div class="col-4 text-strong">
                                                    {{ __('lang.phone') }} :
                                                </div>
                                                <div class="col-8">
                                                    <strong>{{ $data['client']->phone}}</strong>
                                                </div>
                                                <div class="col-4 text-strong">
                                                    {{ __('lang.email') }} :
                                                </div>
                                                <div class="col-8">
                                                    <strong>{{ $data['client']->email}}</strong>
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
        </div>
    </div>

</div>

<div class="modal fade" id="edit-client-{{ $data['client']->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <form action="{{ route('admins.clients.update', $data['client']->id ) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('PUT') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">{{ __('lang.edit_client') }}</h5>

                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.name') }}</label>
                        <input type="text" class="form-control" id="input-add-1" placeholder="Enter client Name "
                            name="name" value="{{ $data['client']->name}}">
                    </div>
                    <div class="form-group">
                        <label for="input-add-4">{{ __('lang.phone') }}: {{ $data['client']->phone}}</label>
                        <input type="text" class="form-control" id="input-add-4" placeholder="Enter client Phone "
                            name="phone" value="">
                        @if($errors->has('phone'))
                        <label id="input-5-error" class="error" for="input-5">{{ $errors->first('phone') }}</label>
                        @endIf
                    </div>
                    <div class="form-group">
                        <label for="input-add-3">{{ __('lang.password') }}</label>
                        <input type="password" class="form-control" id="input-add-3"
                            placeholder="Enter client password " name="password">
                    </div>
                    <div class="form-group">
                        <label for="input-add-2">{{ __('lang.email') }}: {{ $data['client']->email}}</label>
                        <input type="text" class="form-control" id="input-add-2" placeholder="Enter client email "
                            name="email" value="">
                        @if($errors->has('email'))
                        <label id="input-5-error" class="error" for="input-5">{{ $errors->first('email') }}</label>
                        @endIf
                    </div>
                    <div class="form-group">
                        <label for="input-add-5">{{ __('lang.avatar') }}</label>
                        <input type="file" class="form-control-file" id="input-add-5" placeholder="Enter client email "
                            name="avatar"></input>
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

<div class="modal fade" id="delete-client-{{ $data['client']->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <form action="{{ route('admins.clients.destroy', $data['client']->id) }}" method="POST"
                enctype="multipart/form-data">
                {{ method_field('DELETE') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-danger text-white">

                    {{ $data['client']->name }}
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{ __('lang.delete_client_text') }}
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
            var id = "<?php echo  $data['client']->id; ?>";
            if (err > 0) {


    $('#edit-client-'+id).modal({
    show: true
        });
}

});

</script>
@endsection
