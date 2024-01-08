@php($overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews))


<div class="product-single-hover" >
    <div class="overflow-hidden position-relative">
        <div class="inline_product clickable rtl"
                style="background:{{$web_config['primary_color']}}10;">
            @if($product->discount > 0)
                        <span class="for-discoutn-value p-1 pl-2 pr-2">
                        @if ($product->discount_type == 'percent')
                                {{round($product->discount,(!empty($decimal_point_settings) ? $decimal_point_settings: 0))}}%
                            @elseif($product->discount_type =='flat')
                                {{\App\CPU\Helpers::currency_converter($product->discount)}}
                            @endif
                            {{translate('the_discount')}}
                        </span>
            @else
                <span class="for-discoutn-value-null"></span>
            @endif
{{--                @if(($product['product_type'] == 'physical') && ($product['current_stock']<=0))--}}
{{--                    <div class="d-flex"--}}
{{--                         style="top:0;position:absolute;{{Session::get('direction') === "ltr" ? 'right:0;' : 'left:0;'}}">--}}
{{--                    <span class="for-stock-value p-1 pl-2 pr-2"--}}
{{--                          style="{{Session::get('direction') === "ltr" ? 'border-radius:0px 5px' : 'border-radius:5px 0px'}};">--}}
{{--                        {{translate('out_of_stock')}}--}}
{{--                    </span>--}}
{{--                    </div>--}}
{{--                @endif--}}

                <a href="{{route('product',$product->slug)}}">
                    <img src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'">
                </a>
        </div>
        <div class="single-product-details">
            <div class="text-{{Session::get('direction') === "rtl" ? 'right pr-3' : 'left pl-3'}}">
                <a href="{{route('product',$product->slug)}}">
                    {{ Str::limit($product['name'], 23) }}
                </a>
            </div>
            <div class="rating-show justify-content-between text-center">
                <span class="d-inline-block font-size-sm text-body">
                    @for($inc=0;$inc<5;$inc++)
                        @if($inc<$overallRating[0])
                            <i class="sr-star czi-star-filled active"></i>
                        @else
                            <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                        @endif
                    @endfor
                    <label class="badge-style">( {{$product->reviews_count}} )</label>
                </span>
            </div>
            <div class="justify-content-between text-center">
                <div class="product-price text-center">
                    @if($product->discount > 0)
                        <strike style="font-size: 12px!important;color: #E96A6A!important;">
                            {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                        </strike><br>
                    @endif
                    <span class="text-accent">
                        {{\App\CPU\Helpers::currency_converter(
                            $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                        )}}
                    </span>
                    <span class="d-block">{{translate('out_of_stock')}}</span>
                </div>
            </div>

        </div>
        <div class="text-center quick-view" >
            @if(Request::is('product/*'))
                <a class="btn btn--primary btn-sm" href="{{route('product',$product->slug)}}">
                    <i class="czi-forward align-middle {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                    {{translate('view')}}
                </a>
            @else
                <a class="btn btn--primary btn-sm" href="javascript:"
                onclick="quickView('{{$product->id}}')">
                    <i class="czi-eye align-middle {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                    {{translate('quick_view')}}
                </a>
            @endif
        </div>
    </div>
</div>

