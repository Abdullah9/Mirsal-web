@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills nav-pills-info nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#piil-13"> <span
                                    class="hidden-xs">{{ __('lang.vip') }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#piil-14"> <span
                                    class="hidden-xs">{{ __('lang.animals') }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#piil-15"><span
                                    class="hidden-xs">{{ __('lang.goods') }}</span></a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="piil-13" class="tab-pane active">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive text-black">
                                        <table data-order='[[ 0, "desc" ]]' class="datatable table">
                                            <thead class="thead-info">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <!-- <th scope="col">{{ __('lang.terms_and_conditions') }} {{ __('lang.en') }}</th> -->
                                                    <th scope="col">{{ __('lang.type') }}</th>
                                                    <th scope="col">{{ __('lang.title') }}</th>
                                                    <th scope="col">{{ __('lang.description') }}</th>
                                                    <th scope="col">{{ __('lang.price') }}</th>
                                                    <th scope="col">{{ __('lang.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data['vips'] as $index => $product)
                                                <tr>
                                                    <td>{{ $product->id }}</td>
                                                    <td>{{ \App::getLocale() === "ar" ? $product->type_ar : $product->type }}
                                                    </td>
                                                    <td>{{ $product->title}}</td>
                                                    <td>{!! Str::limit($product->description, 20, ' ...') !!}</td>

                                                    <td>{{ $product->price}}</td>
                                                    <td>
                                                        <a class="btn btn-info"
                                                            href="{{ route('admins.products.show', $product->id ) }}">{{ __('lang.view') }}</a>
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
                                        <table data-order='[[ 0, "desc" ]]' class="datatable table">
                                            <thead class="thead-info">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <!-- <th scope="col">{{ __('lang.terms_and_conditions') }} {{ __('lang.en') }}</th> -->
                                                    <th scope="col">{{ __('lang.type') }}</th>
                                                    <th scope="col">{{ __('lang.title') }}</th>
                                                    <th scope="col">{{ __('lang.description') }}</th>
                                                    <th scope="col">{{ __('lang.price') }}</th>
                                                    <th scope="col">{{ __('lang.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data['animals'] as $index => $product)
                                                <tr>
                                                    <td>{{ $index }}</td>
                                                    <td>{{ \App::getLocale() === "ar" ? $product->type_ar : $product->type }}
                                                    </td>
                                                    <td>{{ $product->title}}</td>
                                                    <td>{{ $product->description}}</td>
                                                    <td>{{ $product->price}}</td>
                                                    <td>
                                                        <a class="btn btn-info"
                                                            href="{{ route('admins.products.show', $product->id ) }}">{{ __('lang.view') }}</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="piil-15" class="tab-pane fade">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive text-black">
                                        <table data-order='[[ 0, "desc" ]]' class="datatable table">
                                            <thead class="thead-info">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <!-- <th scope="col">{{ __('lang.terms_and_conditions') }} {{ __('lang.en') }}</th> -->
                                                    <th scope="col">{{ __('lang.type') }}</th>
                                                    <th scope="col">{{ __('lang.title') }}</th>
                                                    <th scope="col">{{ __('lang.description') }}</th>
                                                    <th scope="col">{{ __('lang.price') }}</th>
                                                    <th scope="col">{{ __('lang.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data['products'] as $index => $product)
                                                <tr>
                                                    <td>{{ $index }}</td>
                                                    <td>{{ \App::getLocale() === "ar" ? $product->type_ar : $product->type }}
                                                    </td>
                                                    <td>{{ $product->title}}</td>
                                                    <td>{{ $product->description}}</td>
                                                    <td>{{ $product->price}}</td>
                                                    <td>
                                                        <a class="btn btn-info"
                                                            href="{{ route('admins.products.show', $product->id ) }}">{{ __('lang.view') }}</a>
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
    <div class="row">
        <div class="col-12">

        </div>
    </div>
</div>
@endsection
