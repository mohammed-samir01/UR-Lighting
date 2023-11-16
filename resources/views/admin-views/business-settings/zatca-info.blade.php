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
            @include('zatca.info-zatca',['business_setting' => $business_setting])
        </form>

    </div>
@endsection

@push('script')
    <script>

    </script>
@endpush
