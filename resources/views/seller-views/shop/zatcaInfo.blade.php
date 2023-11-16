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


    </div>
@endsection

@push('script')
    <script>

    </script>
@endpush
