@extends('layouts.back-end.app')

@section('title', translate('privacy_policy'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/Pages.png')}}" width="20" alt="">
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
                        <h5 class="mb-0">{{translate('privacy_policy')}}</h5>
                    </div>

{{--                    <form action="{{route('admin.business-settings.privacy-policy')}}" method="post">--}}
{{--                        @csrf--}}
                        <div class="card-body">
                            <text-editor :url='@json(route("admin.business-settings.privacy-policy"))' :data='@json($data)'></text-editor>

{{--                            <div class="form-group">--}}
{{--                                <input class="form-control btn--primary" type="submit" value="{{translate('submit')}}" name="btn">--}}
{{--                            </div>--}}

                        </div>
{{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{--ck editor--}}
{{--    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/ckeditor.js"></script>--}}
{{--    <script src="https://6valley.6amtech.com/vendor/ckeditor/ckeditor/ckeditor.js"></script>--}}
{{--    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>--}}
{{--    <script>--}}
{{--        $('#editor').ckeditor({--}}
{{--            contentsLangDirection : 'ltr',--}}
{{--            licenseKey: 'eDhsWWtZZkJyRElaZmpLL1FWalBwTU9FalhqbjFQc1ppcElhWkhkNmFobHZGdE1hK2ZkS2hGRklGa3F1LU1qQXlOREF4TWpJPQ==',--}}
{{--        });--}}

{{--    </script>--}}
    {{--ck editor--}}
@endpush

