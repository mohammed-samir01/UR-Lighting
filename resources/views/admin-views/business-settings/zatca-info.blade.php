@extends('layouts.back-end.app')

@section('title', translate('SMS_Module_Setup'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{translate('3rd_party')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('admin-views.business-settings.third-party-inline-menu')
        <!-- End Inlile Menu -->
        <form action="{{route('admin.zatca.get-csr')}}" method="POST">
            @csrf
            @method('POST')
            @include('zatca.info-zatca',['business_setting' => $business_setting,'res' => $res])
        </form>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <form action="{{route('admin.zatca.compliance-invoice',['invoice' =>true])}}" method="POST">
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
                            <form action="{{route('admin.zatca.compliance-invoice',['credit' =>true])}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="text-right" style="margin-top: 20px">
                                    <button type="submit"
                                            class="btn btn-primary px-5">{{translate('invoice_credit')}}</button>
                                    <label class="title-color d-flex mt-2">{{translate('response_zatca')}}</label>
                                    <textarea class="d-block mt-2"
                                              style="width: 100% ; height: 150px">{{$res->response_credit??''}}</textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <form action="{{route('admin.zatca.compliance-invoice',['debit' =>true])}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="text-right" style="margin-top: 20px">
                                    <button type="submit"
                                            class="btn btn-primary px-5">{{translate('invoice_debit')}}</button>
                                    <label class="title-color d-flex mt-2">{{translate('response_zatca')}}</label>
                                    <textarea class="d-block mt-2"
                                              style="width: 100% ; height: 150px">{{$res->response_debit??''}}</textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <form action="{{route('admin.zatca.get-cert')}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="text-right" style="margin-top: 20px">
                                    <button type="submit"
                                            class="btn btn-primary px-5">{{translate('demand_cert')}}</button>
                                    <label class="title-color d-flex mt-2">{{translate('response_cert')}}</label>
                                    <textarea class="d-block mt-2"
                                              style="width: 100% ; height: 150px">{{$res->response_cert??''}}</textarea>
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
