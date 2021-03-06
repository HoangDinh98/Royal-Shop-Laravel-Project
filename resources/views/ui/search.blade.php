@extends ('layouts.ui')
@section('content')
<section id="featuredProduct">
    <!-- Dot Indicators -->
    <h3 class="title"><span>Kết quả tìm kiếm cho "{{$keyword}}"</span></h3>
    @if(count($products) ==0)
    <p> Có <b>{{ $products->total() }}</b> kết quả cho từ khóa "{{$keyword}}"</p>
    @else
    <p> Có <b>{{ $products->total() }}</b> kết quả cho từ khóa "{{$keyword}}"</p>
    <div class="item active"> 
            <div class="item">
                <div class="row">
                    @foreach($products as $product)
                    <div class="span3 product-box">
                        <div class="well well-small">
                            <div class="displayStyle">
                                <div class="cptn18">
                                    <a class="" href="{{ route('product.index', $product->id)}}">
                                        <img id="product-img-{{$product->id}}" src="{{ $product->thumbnail() ? asset($product->thumbnail()->path): 'http://placehold.it/270x270' }}">
                                        <h5>{{ $product->name }}</h5>
                                        <div class="price-area">
                                            @php
                                            $current_price = $product->price*(1 - 0.01*$product->promotion->value)
                                            @endphp
                                            <span class="price">{{ Helper::vn_currencyunit($current_price) }}</span>
                                            @if($product->promotion->value > 0)
                                            <span><del>{{ Helper::vn_currencyunit($product->price) }}</del></span>
                                            <div class="corner-ribbon"><span>{{ '- '.$product->promotion->value.' %' }}</span></div>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="cptn">
                                        <span class="btn btn-warning addcart" data-id="{{$product->id}}">Thêm vào <i class="icon-shopping-cart"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    <div class="pagination pagination-centered">
        {{$products-> appends (Request :: except ('page')) -> render()}}
    </div>
    @endif
</section>
@include('ui.sticky_cart')
@include('ui.notify_modal')
@include('ui.error_modal')
@endsection