@extends('layouts.admin')

@section('css')
@endsection

@section('content')
<div class="container-fluid" style="text-align:right; direction: rtl;">
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
        <div class="col-6">
            <div class="card">
                <div class="card-header text-uppercase text-info">
                    {{ __('lang.general_settings') }}
                    <button class="btn btn-warning waves-effect btn-sm waves-light m-1 text-white" data-toggle="modal"
                        data-target="#edit-general-setting">
                        {{ __('lang.edit') }}
                    </button>

                    <button class="btn btn-dark waves-effect btn-sm waves-light m-1 text-white float-left"
                        data-toggle="modal" data-target="#change-password">
                        {{ __('lang.change_password') }}
                    </button>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                        </div>
                        <!-- <div class="col-12">
                <strong> {{ __('lang.tax_perc') }} </strong> : <span>{{ $admin_setting->tax_perc}} </span>
            </div> -->
                        <div class="col-12">
                            <strong> {{ __('lang.first_payment') }} </strong> :
                            <span>{{ $admin_setting->first_payment_perc}} </span>
                        </div>
                        <div class="col-12">
                            <strong> {{ __('lang.admin_commission') }} </strong> :
                            <span>{{ $admin_setting->admin_commission_perc}} </span>
                        </div>

                        <div class="col-12 mt-4">
                            <strong> {{ __('lang.vet_offer_notes') }} </strong>
                        </div>
                        <div class="col-12">
                            <strong> {{ __('lang.en') }} </strong> : <span>{{ $admin_setting->vet_offer_note}} </span>
                        </div>
                        <div class="col-12">
                            <strong> {{ __('lang.ar') }} </strong> : <span>{{ $admin_setting->vet_offer_note_ar}}
                            </span>
                        </div>

                        <div class="col-12 mt-4">
                            <strong> {{ __('lang.driver_offers_notes') }} </strong>
                        </div>
                        <div class="col-12">
                            <strong> {{ __('lang.en') }} </strong> : <span>{{ $admin_setting->driver_offer_note}}
                            </span>
                        </div>
                        <div class="col-12">
                            <strong> {{ __('lang.ar') }} </strong> : <span>{{ $admin_setting->driver_offer_note_ar}}
                            </span>
                        </div>



                        <div class="col-12 mt-4">
                            <strong> {{ __('lang.terms_and_conditions') }} </strong>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <strong> {{ __('lang.en') }} </strong> :
                                </div>
                                <div class="col-12">
                                    <span>{{ $admin_setting->terms_and_conditions}} </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <strong> {{ __('lang.ar') }} </strong> :
                                </div>
                                <div class="col-12">
                                    <span>{{ $admin_setting->terms_and_conditions_ar}} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>


<div class="modal fade " id="edit-general-setting" aria-hidden="true" style="display: none;">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content border-warning">
            <form action="{{ route('admins.admin-settings.update', $admin_setting->id ) }}" method="POST">
                {{ method_field('PUT') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">{{ __('lang.general_settings') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <div class="form-group">
                <label for="input-add-1">{{ __('lang.tax_perc') }} </label>
                <input type="number" class="form-control" id="input-add-1"  name="tax_perc" value="{{ $admin_setting->tax_perc}}">
            </div> -->
                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.first_payment') }} </label>
                        <input type="number" class="form-control" id="input-add-1" name="first_payment_perc"
                            value="{{ $admin_setting->first_payment_perc}}">
                    </div>
                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.admin_commission') }} </label>
                        <input type="number" class="form-control" id="input-add-1" name="admin_commission_perc"
                            value="{{ $admin_setting->admin_commission_perc}}">
                    </div>

                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.vet_offer_notes') }} </label>
                        <input type="text" class="form-control" id="input-add-1" name="vet_offer_note"
                            value="{{ $admin_setting->vet_offer_note}}">
                    </div>

                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.vet_offer_notes') }} {{ __('lang.ar') }}</label>
                        <input type="text" class="form-control" id="input-add-1" name="vet_offer_note_ar"
                            value="{{ $admin_setting->vet_offer_note_ar}}">
                    </div>

                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.driver_offers_notes') }} </label>
                        <input type="text" class="form-control" id="input-add-1" name="driver_offer_note"
                            value="{{ $admin_setting->driver_offer_note}}">
                    </div>

                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.driver_offers_notes') }} {{ __('lang.ar') }}</label>
                        <input type="text" class="form-control" id="input-add-1" name="driver_offer_note_ar"
                            value="{{ $admin_setting->driver_offer_note_ar}}">
                    </div>

                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.terms_and_conditions') }} </label>
                        <textarea rows="5" class="form-control" id="basic-textarea-1"
                            name="terms_and_conditions">{{ $admin_setting->terms_and_conditions}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.terms_and_conditions_ar') }} </label>
                        <textarea rows="5" class="form-control" id="basic-textarea-2"
                            name="terms_and_conditions_ar">{{ $admin_setting->terms_and_conditions_ar}}</textarea>
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

<div class="modal fade" id="change-password" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-dark">
            <form action="{{ route('admins.admin-settings.change-password', 1 ) }}" method="POST">
                {{ method_field('PUT') }}
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">{{ __('lang.change_password') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.password') }} </label>
                        <input type="password" class="form-control" id="input-add-1" name="password" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="input-add-1">{{ __('lang.password_confirmation') }} </label>
                        <input type="password" class="form-control" id="input-add-1" name="password_confirmation"
                            value="" required>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse-dark" data-dismiss="modal"><i class="fa fa-times"></i>
                        {{ __('lang.close') }}</button>
                    <button type="submit" class="btn btn-dark"><i class="fa fa-check-square-o"></i>
                        {{ __('lang.save') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@section('script')

@endsection
