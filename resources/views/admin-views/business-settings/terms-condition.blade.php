@extends('layouts.back-end.app')

@section('title', translate('terms_and_condition'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/Pages.png')}}" alt="">
                {{translate('pages')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Inlile Menu -->
        @include('admin-views.business-settings.pages-inline-menu')
        <!-- End Inlile Menu -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{translate('terms_and_condition')}}</h5>
                    </div>
                    <div class="card-body">
                        <text-editor :url='@json(route("admin.business-settings.update-terms"))' :data='@json($data)'></text-editor>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
