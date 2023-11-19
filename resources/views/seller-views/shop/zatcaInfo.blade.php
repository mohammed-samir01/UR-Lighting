@extends('layouts.back-end.app-seller')
@section('title', translate('zatca'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/shop-info.png')}}" alt="">
                {{translate('shop_Info')}}
            </h2>
        </div>
        <!-- End Page Title -->

        @include('seller-views.shop.inline-menu')
        <form action="{{route('seller.zatca.get-csr')}}" method="POST">
        @csrf
        @method('POST')
       @include('zatca.info-zatca',['business_setting' => $business_setting])

        </form>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <form action="{{route('seller.zatca.compliance-invoice',['invoice' =>true])}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="text-right" style="margin-top: 20px">
                                    <button type="submit" class="btn btn-primary px-5">{{translate('invoice')}}</button>
                                    <label class="title-color d-flex mt-2">{{translate('response_zatca')}}</label>
                                    <textarea class="d-block mt-2"
                                              style="width: 100% ; height: 150px">{{$res->response_invoice??''}}</textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <form action="{{route('seller.zatca.compliance-invoice',['credit' =>true])}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="text-right" style="margin-top: 20px">
                                    <button type="submit"
                                            class="btn btn-primary px-5">{{translate('invoice_credit')}}</button>
                                    <label class="title-color d-flex mt-2">{{translate('response_zatca')}}</label>
                                    <textarea class="d-block mt-2" style="width: 100% ; height: 150px">{{$res->response_credit??''}}</textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <form action="{{route('seller.zatca.compliance-invoice',['debit' =>true])}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="text-right" style="margin-top: 20px">
                                    <button type="submit"
                                            class="btn btn-primary px-5">{{translate('invoice_debit')}}</button>
                                    <label class="title-color d-flex mt-2">{{translate('response_zatca')}}</label>
                                    <textarea class="d-block mt-2" style="width: 100% ; height: 150px">{{$res->response_debit??''}}</textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <form action="{{route('seller.zatca.get-cert')}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="text-right" style="margin-top: 20px">
                                    <button type="submit"
                                            class="btn btn-primary px-5">{{translate('demand_cert')}}</button>
                                    <label class="title-color d-flex mt-2">{{translate('response_cert')}}</label>
                                    <textarea class="d-block mt-2" style="width: 100% ; height: 150px">{{$res->response_cert??''}}</textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('script')
    <script>

    </script>
@endpush
