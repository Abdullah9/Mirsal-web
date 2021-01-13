@extends('layouts.admin')
@section('css')
@endsection
@section('content')
<div class="container-fluid center">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('admins.advertisements.create')}}"
                                class="btn btn-success btn-round btn-md mt-2">{{ __('lang.advertisements') }} <i
                                    class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-black">
                        <table id="table" class=" datatable table">
                            <thead class="thead-info">
                                <tr>
                                    <th>{{ __('lang.english') }}</th>
                                    <th>{{ __('lang.arabic') }}</th>
                                    <th>{{ __('lang.show') }}</th>
                                    <th>{{ __('lang.view') }}</th>
                                    <th>{{ __('lang.update') }}</th>
                                    <th>{{ __('lang.delete') }}</th>






                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($advertisements as $advetisement)
                                <tr>
                                    <td>{{ $advetisement->id }}</td>
                                    <td>{{ $advetisement->name }}</td>
                                    <td>{{ $advetisement->name_ar }}</td>
                                    <td width="5%">
                                        @if ($advetisement->display == 1 )

                                        <a href="{{ route('admins.advertisements.show' , $advetisement->id )}}"
                                            class="btn btn-success m-1 btn-sm">

                                            {{ __('lang.enable') }}

                                        </a>
                                        @endif
                                        @if ($advetisement->display == 0 )
                                        <a href="{{ route('admins.advertisements.show' , $advetisement->id )}}"
                                            class="btn btn btn-danger m-1 btn-sm">

                                            {{ __('lang.disable') }}

                                        </a>

                                        @endif

                                    </td>
                                    <td width="5%">
                                        <button class="btn btn-info m-1 btn-sm" data-toggle="modal"
                                            data-target="#ViewModal" data-name="{{ $advetisement->name }}"
                                            data-name_ar="{{ $advetisement->name_ar }}"
                                            data-description="{{ $advetisement->description}}"
                                            data-display="{{ $advetisement->display}}"
                                            data-image="{{ $advetisement->image}}">
                                            {{ __('lang.view') }}
                                        </button>
                                    </td>
                                    <td width="5%">

                                        <a href="{{ route('admins.advertisements.edit' , $advetisement->id )}}"
                                            class="btn btn-warning m-1 btn-sm">
                                            {{ __('lang.update') }}
                                        </a>
                                    </td>

                                    <td width="5%">
                                        <form action="{{ route('admins.advertisements.destroy', $advetisement->id) }}"
                                            class="wbd-form" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger m-1 btn-sm">
                                                {{ __('lang.delete') }}
                                            </button>
                                        </form>
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
<div class="modal fade" id="ViewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span>&nbsp</span>
                <h5 class="modal-title float-right">{{ __('lang.advertisements') }}</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('lang.images') }}
                                </label>

                                <img class="img-thumbnail" id="proof-image" src="" alt="Default" height="200px"
                                    width="230px">


                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.arabic') }}
                                        </label>
                                        <textarea class="form-control" name="name_ar" rows="2" id="name_ar"
                                            disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.english') }}
                                        </label>
                                        <textarea class="form-control" name="name" rows="2" id="name"
                                            disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.show') }}
                                        </label>
                                        <textarea class="form-control" name="display" rows="2" id="display"
                                            disabled></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ __('lang.description') }}
                                        </label>
                                        <textarea class="form-control" name="description" rows="2" id="description"
                                            disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse-warning" data-dismiss="modal">
                    <i class="fa fa-times"></i>&nbsp{{ __('lang.close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $( document ).ready(function() {

     $('#ViewModal').on('show.bs.modal',function (e){
       var name = $(e.relatedTarget).data('name');
       var name_ar = $(e.relatedTarget).data('name_ar');
       var image = $(e.relatedTarget).data('image');
       var description = $(e.relatedTarget).data('description');
       var display = $(e.relatedTarget).data('display');


       var x = location.origin;
      var proof = x +'/storage/'+image;
      $('#proof-image').attr('src', proof);
       $(e.currentTarget).find('textarea[id="name"]').html(name);
       $(e.currentTarget).find('textarea[id="name_ar"]').html(name_ar);
       $(e.currentTarget).find('textarea[id="description"]').html(description);

       if(display==1){
         $(e.currentTarget).find('textarea[id="display"]').html('display');
       } else{
         $(e.currentTarget).find('textarea[id="display"]').html('hide');
       }
     });
   });
</script>
@endsection
