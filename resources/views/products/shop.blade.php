<x-front-layout>
    <section class="section-header py-4 wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    @php
                        // $images = $product->images;
                        // dd($product->specifications()->get())
                        // dd($images)
                    @endphp
                    <!-- <h1 class="section-title">
                        Lenovo Ideapad 320 Core i3 Laptop
                    </h1> -->
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Shop</a></li>
                            <li class="breadcrumb-item"><a href="#">Consumer Electrics</a></li>
                            <li class="breadcrumb-item"><a href="#">Audios & Theaters</a></li>
                            <li class="breadcrumb-item"><a href="#">Headphone</a></li>
                            <li class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="cat-carousel bg-white py-4 wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Set up your HTML -->
                    <div class="owl-carousel">
                        @foreach ($categories as $all_cat)
                        @php
                            // dd($all_cat)
                        @endphp
                        <div>
                            <a href="{{ route('categories.show', [app()->getLocale(), $all_cat['slug']]) }}">
                                <img src="https://images.unsplash.com/photo-1551739440-5dd934d3a94a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=100&h=100&q=60" alt="{{ $all_cat['name'] }}">
                                <span class="cat-name">{{ $all_cat['name'] }}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{-- <div class="product__thumbnails zooma-thumbnail col-lg-1"></div>
                <div class="product__focus zooma-main col-lg-5">
                    @foreach ($product->images as $img)
                        <img src="{{ $img->url }}" alt="{{ $img->alt }}" title="{{ $img->name }}" />
                    @endforeach
                </div>
                <div class="product__details col-lg-6">
                    <h1 itemprop="name" class="product-name brand-font">{{ $product->name }}</h1>
                    <div class="box-review form-group">
                        <div class="ratings d-inline-block me-3">
                            <div class="rating-box d-inline-block me-2 fill-link">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half"></i>
                            </div>
                            <div class="rating-count text-muted d-inline-block">
                                26 reviews
                            </div>
                        </div>
                    </div>
                    <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer" class="mt-2">
                        <p class="price">
                            @if (!empty($product->sale_price))
                                <ins>
                                    <span class="label">Special Price: </span>
                                    <span class="amount">
                                        <bdi>@money($product->sale_price)</bdi>
                                    </span>
                                </ins>
                                <span class="extra-small fill-muted mx-2"><i data-feather="circle"></i></span>
                                <del>
                                    <span class="label">Regular Price: </span>
                                    <span class="amount">
                                        <bdi>@money($product->regular_price)</bdi>
                                    </span>
                                </del>
                            @else
                                <ins>
                                    <span class="label">Regular Price: </span>
                                    <span class="amount">
                                        <bdi>@money($product->regular_price)</bdi>
                                    </span>
                                </ins>
                            @endif
                        </p>
                        <meta itemprop="price-currency" content="USD">
                    </div>
                    <div class="summery">
                        <div class="short-description">
                            {!! $product->short_description !!}
                        </div>

                        <form class="cart my-2 py-2 text-center" action="" method="post" enctype="multipart/form-data">

                            <div class="quantity d-inline-block">
                                <label class="screen-reader-text" for="quantity_60e4a5e54f315">Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-minus">-</button>
                                    </span>
                                    <input type="text" id="quantity_60e4a5e54f315" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" aria-labelledby="Robin Shirt quantity" style="text-align: center;">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-plus">+</button>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" name="add-to-cart" value="93" class="single_add_to_cart_button button alt btn tz-info d-inline-block">
                                <i data-feather="shopping-cart"></i> <span class="btn-text ps-2">Add to cart</span>
                            </button>

                            <div class="actions-button d-inline-block ">
                                <a href="" data-rel="tooltip" data-product-id="93" data-product-type="simple" data-original-product-id="93" class="add_to_wishlist single_add_to_wishlist ms-2 btn btn-outline-secondary" data-product-title="Sound Intone I65 Earphone White Version" title="" data-original-title="Add to Wishlist">
                                    <i data-feather="heart"></i> <span class="btn-text ps-2">Add to Wishlist</span>
                                </a>
                                <!-- <a href="" class="download ms-2 btn btn-outline-secondary" title="" data-product_id="93" data-original-title="Download Specification PDF"> -->
                                <a href="" class="download ms-2 btn btn-outline-secondary" title="" data-product_id="93" data-original-title="Download Specification PDF">
                                    <span class="pdf-icon">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 37.622 37.622" xml:space="preserve">
                                            <path d="M37.306,27.558c-1.339-2.418-7.203-3.958-12.381-4.25c-0.468-0.501-0.943-1.028-1.43-1.582
                                                c-4.45-5.088-6.252-12.482-6.925-16.399c-0.08-0.83-0.168-1.52-0.242-2.034c-0.06-0.409-0.186-1.262-1.073-1.262
                                                c-0.284,0-0.558,0.122-0.753,0.339c-0.316,0.361-0.269,0.749-0.213,1.197c0.063,0.514,0.158,1.202,0.293,1.987
                                                c0.379,3.977,0.558,11.549-2.503,17.564c-0.319,0.627-0.637,1.229-0.953,1.803c-5.728,1.666-10.35,4.637-11.027,7.101
                                                c-0.245,0.892-0.032,1.747,0.601,2.409c0.737,0.77,1.607,1.16,2.586,1.16c2.71,0,5.799-3.018,9.181-8.967
                                                c1.506-0.396,3.001-0.672,4.446-0.818c0.563-0.057,1.474-0.176,2.034-0.262c1.543-0.238,3.289-0.334,5.083-0.275
                                                c4.152,4.316,7.547,6.504,10.091,6.504c1.366-0.001,2.497-0.667,3.183-1.875C37.726,29.15,37.728,28.318,37.306,27.558z
                                                 M3.285,33.591c-0.424,0-0.786-0.172-1.141-0.543c-0.145-0.151-0.177-0.281-0.117-0.495c0.349-1.269,3.281-3.444,7.566-5.023
                                                C7.172,31.35,4.855,33.591,3.285,33.591z M18.64,23.57c-0.532,0.082-1.396,0.194-1.93,0.25c-0.971,0.096-1.969,0.249-2.976,0.455
                                                c0.042-0.082,0.084-0.165,0.126-0.248c1.501-2.949,2.431-6.485,2.775-10.538c1.377,3.854,3.173,7.06,5.354,9.554
                                                c0.064,0.074,0.131,0.149,0.195,0.225C20.925,23.298,19.737,23.401,18.64,23.57z M35.56,28.916
                                                c-0.332,0.588-0.804,0.861-1.481,0.861h-0.001c-1.59,0-4.035-1.505-6.962-4.265c4.53,0.569,7.847,1.94,8.442,3.015
                                                C35.644,28.683,35.644,28.766,35.56,28.916z"/>
                                        </svg>
                                    </span>
                                    <span class="d-none">Download</span>
                                </a>
                            </div>
                        </form>
                        <div class="product-meta">
                            <div class="capsule rounded-pill btn btn-light">
                                <span class="name me-2">Brand:</span><span class="value"><a href="" class="">{{ $product->brand->name }}</a></span>
                            </div>
                            <div class="capsule rounded-pill btn btn-light">
                                <span class="name me-2">Categories:</span><span class="value">
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($product->categories as $cat)
                                        @php
                                            $i++;
                                        @endphp
                                        <a href="" class="">{{ $cat->name }}</a>
                                        @if ($i<count($product->categories))
                                            , 
                                        @endif
                                    @endforeach
                                </span>
                            </div>
                            <div class="capsule rounded-pill btn btn-light">
                                <span class="name me-2">Availability:</span>
                                @if ($product->stock_available == 'yes')    
                                    <span class="value text-success">In stock</span>
                                @else    
                                    <span class="value text-danger">Stock out</span>
                                @endif
                            </div>
                            <hr>
                            <div class="capsule rounded-pill btn btn-light">
                                <span class="name me-2">SKU:</span><span class="value">{{ $product->sku }}</span>
                            </div>
                            <div class="capsule rounded-pill btn btn-light product-share">
                                <span class="name me-2">Share</span>
                                <span class="value">
                                    <a rel="noopener noreferrer nofollow" href="https://www.facebook.com/sharer/sharer.php?u=https://..." target="_blank" class="social-icon facebook px-1">
                                        <i data-feather="facebook"></i>
                                    </a>

                                    <a rel="noopener noreferrer nofollow" href="https://twitter.com/share?url=https://..." target="_blank" class="social-icon twitter px-1">
                                        <i data-feather="twitter"></i>
                                    </a>

                                    <a rel="noopener noreferrer nofollow" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=https://..." target="_blank" class="social-icon linkedin px-1">
                                        <i data-feather="linkedin"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <section class="two-col">
        <div class="container-fluid">
            <div class="row wrapper">
                <div class="col-lg-3">
                    <div class="sidebar">
                        {{-- <ul class="backto-links p-0 m-0 py-2 my-1">
                            <li class="d-grid"><a href="" class="btn btn-brand"><i data-feather="check-circle"></i><span class="btn-text ms-2">Request a price match</span></a></li>
                        </ul> --}}
                        <div class="sidebar-content">
                            <section class="bg-white rounded p-4 my-4 pt-0 pb-2">
                                <div class="sidebar-title">
                                    <h6 class="border-bottom py-3">Related Products</h6>
                                </div>
                                <div class="sidebar-body">
                                    @include('products.categories-trees', ['category_tree' => $category_tree])
                                </div>
                            </section>
                            <section class="bg-white rounded p-4 mb-4 pt-0 pb-2">
                                <div class="sidebar-title">
                                    <h6 class="border-bottom py-3">Brands</h6>
                                </div>
                                <div class="sidebar-body my-3">
                                    <ul class="brands">
                                        @foreach ($brands as $brand)
                                        <li class="brand {{ (!empty($selected_brand) && $selected_brand==$brand->id)?'active':'' }}"><a href="{{ route('shop.brand', [app()->getLocale(), $brand->id]) }}">{{ $brand->name }}</a></li>
                                        @endforeach
                                    </ul>
                                    {{-- <a href="">
                                        <img src="https://images.unsplash.com/photo-1560762484-813fc97650a0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTh8fGNvbXB1dGVyfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=250&h=150&q=60" alt="">
                                    </a> --}}
                                </div>
                            </section>
                            <section class="bg-white rounded p-4 mb-4 pt-0 pb-2">
                                <div class="sidebar-title">
                                    <h6 class="border-bottom py-3">Avg. Customer Rating</h6>
                                </div>
                                <div class="sidebar-body">
                                    <ul class="rating-filter">
                                    @foreach ($rating_filter as $rf_k => $rf_v)
                                        <li><a href="{{ $rf_k }}">@php echo str_repeat('<i class="fas fa-star"></i>', $rf_k) @endphp {{ $rf_v }}</a></li>
                                    @endforeach
                                    </ul>
                                </div>
                            </section>
                            <section class="bg-white rounded p-4 mb-4 pt-0 pb-2">
                                <div class="sidebar-title">
                                    <h6 class="border-bottom py-3">Avg. Customer Rating</h6>
                                </div>
                                <div class="sidebar-body">
                                    <ul class="pricing-filter mb-4">
                                    @foreach ($price_filter as $pfk => $pf)
                                        <li><a href="{{ route('shop.index', app()->getLocale()).'?min='.$pf['min'] . '&max=' . $pf['max'] }}" data-min="{{ $pf['min'] }}" data-max="{{ $pf['max'] }}">{{ $pf['label'] }}</a></li>
                                    @endforeach
                                    </ul>
                                    <input type="text" min="{{ $product_min_max_price[0] }}" max="{{ $product_min_max_price[1] }}" id="sampleSlider" />
                                    <a id="price_filter_btn" href="{{ route('shop.index', app()->getLocale()).'?min='.$product_min_max_price[0] . '&max=' . $product_min_max_price[1] }}" class="btn btn-brand btn-sm">Apply price filter</a>
                                </div>
                            </section>
                            <section class="bg-white rounded p-4 mb-4 pt-0 pb-2">
                                <div class="sidebar-title">
                                    <h6 class="border-bottom py-3">Videos for this products</h6>
                                </div>
                                <div class="sidebar-body">
                                    <div class="video-row my-3">
                                        <a href="" class="">
                                            <img src="https://images.unsplash.com/photo-1560762484-813fc97650a0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTh8fGNvbXB1dGVyfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=250&h=150&q=60" alt="">
                                            <p class="title video-title brand-font">Microsoft Surface Pro Type Cover Keyboard - Black</p>
                                        </a>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 product-list">
                    <div class="row">
                        @php
                            // dd(!$products->isEmpty());
                        @endphp
                        @if (!$products->isEmpty())
                            @foreach ($products as $product)
                            <div class="col-md-4">
                                <div class="product-item">
                                    <div class="img-box position-relative">
                                        <a href="{{ route('product.single', [app()->getLocale(), $product->slug]) }}" class="single-product-link"><img src="http://localhost:8000/admin/assets/images/login/1.jpg" alt="{{ $product->name }}"></a>
                                        {{-- {{ $product->featured_img }} --}}
                                        <div class="hidden-btns overflow-hidden">
                                            <a href="{{ $product->featured_img }}" class="wishlist float-start btn btn-sm btn-brand" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                            <a href="{{ $product->featured_img }}" class="compare float-end btn btn-sm btn-brand" title="Share it"><i class="fas fa-retweet"></i></a>
                                        </div>
                                    </div>
                                    <h5 class="title"><a href="{{ route('product.single', [app()->getLocale(), $product->slug]) }}" class="single-product-link">{{ $product->name }}</a></h5>
                                    <div class="short-desc">{!! $product->short_description !!}</div>
                                    <div class="price-review overflow-hidden">
                                        <div class="price float-start">
                                            <span><bdi>@money($product->sale_price)</bdi></span>
                                            <span><bdi>@money($product->regular_price)</bdi></span>
                                        </div>
                                        <div class="review float-end">{!! str_repeat('<i class="fas fa-star"></i>', 5) !!}</div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('cart.index', app()->getLocale()).'?add-to-cart='.$product->id }}" class="btn fw-bold tz-info d-inline-block">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            {{ $products->links() }}
                        @else
                            <div class="col-md-12">
                                <div class="alert alert-warning my-4">No products found.</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('style')
    <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel2-2.3.4/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel2-2.3.4/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/range-slider/css/rSlider.min.css') }}">

    <style>
        .owl-carousel .owl-nav .owl-next, .owl-carousel .owl-nav .owl-prev {
            border-radius: 5px;
            position: absolute;
            overflow: hidden;
            margin: 5px;
            top: 30%;
        }
        .owl-carousel .owl-nav .owl-next span, .owl-carousel .owl-nav .owl-prev span {
            font-size: 36px !important;
            background: #fff !important;
            line-height: .8;
            padding: 0px 10px;
        }
        .owl-carousel .owl-nav .owl-next {
            right: 0;
        }
        .owl-carousel .owl-nav button.owl-next.disabled, .owl-carousel .owl-nav button.owl-prev.disabled {
            opacity: .7;
            cursor: default;
        }

        .owl-carousel.owl-drag .owl-item span {
            position: absolute;
            bottom: 0;
            left: 0;
            background: #232f3fe6;
            display: block;
            width: 100%;
            padding: 10px 5px;
            color: #fff;
            display: none;
        }
        .owl-carousel.owl-drag .owl-item a {
            text-align: center;
            display: inherit;
            position: relative;
        }

        .sidebar ul {
            padding: 0;
        }
        .sidebar ul li {
            display: block;
        }
        .sidebar ul.is_child {
            padding-left: 1.2rem;
            display: none;
        }
        .sidebar ul li a {
            padding: 5px 0;
            display: block;
        }
        .sidebar ul li a:hover, .sidebar ul li.active a {
            background: #31445d;
            padding: 5px 8px;
            color: #fff !important;
        }
        .sidebar ul li a svg, .review svg {
            fill: #ff6d32;
        }
        .sidebar ul li a:hover svg {
            fill: #fff;
        }
        .rs-container .rs-selected {
            background-color: #31445d;
            border: 1px solid #232f3f;
        }
        .rs-tooltip {
            border-color: #31445d;
            background: #31445d;
            color: #fff;
            font-size: 10px;
            padding: 2px;
            height: auto;
            min-width: 45px;
            top: 8px;
        }
        .rs-container .rs-pointer {
            height: 15px;
        }
        .rs-container .rs-bg, .rs-container .rs-selected {
            height: 5px;
        }
        .rs-container .rs-pointer::after, .rs-container .rs-pointer::before {
            height: 4px;
        }
        .rs-container .rs-scale span ins {
            font-size: 10px;
        }

        .product-list .table table > tbody > tr, .product-list table.table > tbody > tr {
            display: none;
        }
        .product-list .table table > tbody > tr:nth-child(-n+3), .product-list table.table > tbody > tr:nth-child(-n+3) {
            display: inherit;
        }
        .product-item {
            background: #fff;
            padding: 15px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .product-item .img-box {
            overflow: hidden;
            margin-bottom: 15px;
        }
        .product-item .img-box img {
            width: 100%;
        }
        h5.title {
            font-size: 14px;
            font-weight: bold;
            line-height: inherit;
        }
        .short-desc {
            font-size: 85%;
        }
        .short-desc p {
            display: none;
        }
        .price-review {
            margin: 10px 0;
        }
        .price-review .price {
            font-size: 16px;
            font-weight: bold;
        }
        .price-review .price span:last-child {
            color: #9e9e9e;
            text-decoration: line-through;
            font-weight: normal;
        }
        .hidden-btns {
            display: none;
            position: absolute;
            bottom: 0px;
            width: 100%;
            padding: 10px;
        }
    </style>
    @endpush

    @push('script')
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script> --}}
    <script defer src="{{ asset('plugins/OwlCarousel2-2.3.4/owl.carousel.min.js') }}"></script>
    <script defer src="{{ asset('plugins/range-slider/js/rSlider.min.js') }}"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            (function($) {
                $(".owl-carousel").owlCarousel({
                    // center:true,
                    items:2,
                    loop:false,
                    dots:false,
                    nav:true,
                    margin:10,
                    responsive:{
                        600:{
                            items:10
                        }
                    }
                });

                var mySlider = new rSlider({
                    target: '#sampleSlider',
                    // values: [0, 2500, 5000, 10000, 12500, 15000, 17500, 20000, 225000, 25000, 27500, 30000],
                    values: {min: 0, max: {{ $product_min_max_price[1] }}},
                    range: true,
                    step: 5000,
                    tooltip: true,
                    scale: false,
                    labels: false,
                    set: [{{ $product_min_max_price[0] }}, {{ $product_min_max_price[1] }}]
                });

                $('#price_filter_btn').click(function(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();

                    var slider = mySlider.getValue().split(',');

                    var url = $(this).attr('href').split('?')[0];

                    const params = new URLSearchParams({
                        min: slider[0], 
                        max: slider[1]
                    }).toString();

                    window.location.href = url+'?'+params;
                });

                $('.owl-item').find('a').hover(function() {
                    $(this).find('span.cat-name').slideDown('fast');
                }, function() {
                    $(this).find('span.cat-name').slideUp('fast');
                });

                $('ul.cat-tree').find('a').hover(function() {
                    console.log('hoverd')
                    if ($(this).next('ul').hasClass('is_child') && $(this).hasClass('hovered') == false) {
                        if ($(this).parents('li').hasClass('hovered') == false) {
                            $(this).closest('ul.cat-tree').find('li').removeClass('hovered')
                            $('ul.cat-tree.is_child').slideUp('fast');
                        }
                        $(this).next('ul.is_child').slideDown('fast');
                        $(this).closest('li').addClass('hovered');
                    }
                }, function() {
                    // $(this).next('ul.is_child').delay(1000, function(e) {
                    //     $(this).hover(function(e) {
                    //         e.preventDefault();
                    //         e.stopImmediatePropagation();
                    //     }, function() {
                    //         /* Stuff to do when the mouse leaves the element */
                    //     });
                    // }).slideUp('slow');
                });

                $('.product-item').hover(function() {
                    $(this).find('.hidden-btns').stop().slideDown('fast')
                }, function() {
                    $(this).find('.hidden-btns').stop().slideUp('slow')
                });
            })(jQuery);
        });
    </script>
    @endpush
</x-front-layout>