@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admins.advertisements.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        {{ __('lang.advertisements') }}
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">

                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.arabic') }}
                                                </label>
                                                <input type="text" class="form-control"
                                                    placeholder="  {{ __('lang.arabic') }}" name="name_ar">


                                                @if ($errors->has('name_ar'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('name_ar') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.english') }}
                                                </label>
                                                <input type="text" class="form-control"
                                                    placeholder="  {{ __('lang.english') }}" name="name">

                                                @if ($errors->has('name'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.show') }}
                                                </label>
                                                <select name="display" class="form-control" dir="rtl">

                                                    <option value="1" selected>
                                                        {{ __('lang.enable') }}
                                                    </option>
                                                    <option value="0">
                                                        {{ __('lang.disable') }}
                                                    </option>

                                                </select>
                                                @if ($errors->has('display'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('display') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    {{ __('lang.description') }}
                                        </label>
                                        <textarea class="form-control" name="description" rows="2"
                                            id="description"></textarea>
                                        @if ($errors->has('description'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <img src="{{  asset('images/logos/logo.png') }}" id="preview"
                                            class="logo-icon img-centered">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.images') }}
                                        </label>
                                        <input type="file" class="form-control" name="image" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
        </div>
        <div class="card-footer">


            <button type="button" class="btn btn-inverse-warning" data-dismiss="modal"><i class="fa fa-times"></i>
                {{ __('lang.close') }}</button>
            <button type="submit" class="btn btn-inverse-success"><i class="fa fa-check-square-o"></i>
                {{ __('lang.save') }} </button>
        </div>
    </div>
    </form>
</div>
</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).on("click", ".browse", function() {
       var file = $(this).parents().find(".image");
       file.trigger("click");
    });

    $('input[type="file"]').change(function(e) {

        var fileName = e.target.files[0].name;
        $("#file").val(fileName);
        var reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById("preview").src = e.target.result;
        };

        reader.readAsDataURL(this.files[0]);
   });
</script>
@endsection