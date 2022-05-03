<x-front-layout class='product product-single single-template product-{{$product->id}}'>
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
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="product bg-white py-5 wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="product__thumbnails zooma-thumbnail col-lg-1"></div>
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

                        <form class="cart my-2 py-2 text-center" action="{{ route('cart.store', app()->getLocale()) }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="quantity d-inline-block">
                                <label class="screen-reader-text" for="quantity_60e4a5e54f315">Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-minus">-</button>
                                    </span>
                                    <input type="text" id="quantity_60e4a5e54f315" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" aria-labelledby="quantity" style="text-align: center;">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-plus">+</button>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="single_add_to_cart_button button alt btn tz-info d-inline-block">
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
                </div>
            </div>
        </div>
    </div>

    <section class="two-col">
        <div class="container-fluid">
            <div class="row wrapper">
                <div class="col-lg-9">
                    <div class="product-description">
                        <ul class="desc-links p-0 m-0 py-2" id="product_desc_nav">
                            <li data-area="specification"><a href="#specification">Specification</a></li>
                            <li data-area="description"><a href="#description">Description</a></li>
                            <li data-area="what-is"><a href="#what-is">What is</a></li>
                            <li class="hidden-xs" data-area="ask-question"><a href="#ask-question">Questions</a></li>
                            <li data-area="write-review"><a href="#write-review">Reviews (26)</a></li>
                            <li data-area="write-review"><a href="#product-compare">Compare</a></li>
                        </ul>
                        <div class="desc-content ms-3">
                            <section class="specification bg-white m-tb-15 p-4 mb-4 rounded" id="specification">
                                <div class="section-head">
                                    <h2 class="brand-font">Specification Info</h2>
                                </div>
                                <div class="specification" itemprop="description">
                                    <div>
                                        @php
                                        // dd($product->specifications->sortBy('head_id')->toArray());
                                        $pro_spec_new_val = [];
                                        foreach ($product->specifications->sortBy('head_id') as $pro_spec) {
                                            $head_id = 0;
                                            $head_name = 'General';
                                            if (!empty($pro_spec->head_id)) {
                                                $head_name = $pro_spec->parent()->first()->name;
                                                $head_id = $pro_spec->head_id;
                                            }
                                            // echo $head_id;
                                            $pro_spec_new_val[$head_id]['head'] = $head_name;
                                            $pro_spec_new_val[$head_id]['value'][] = [$pro_spec->name, $pro_spec->pivot->value];
                                        }
                                        @endphp

                                        <table class="spec_data">
                                            @foreach ($pro_spec_new_val as $pspec)
                                                <tr>
                                                    <td class="heading-row" colspan="2">{{ $pspec['head'] }}</td>
                                                </tr>
                                                @foreach ($pspec['value'] as $sval)
                                                <tr>
                                                    <td class="name">{{ $sval[0] }}</td>
                                                    <td class="value">{!! $sval[1] !!}</td>
                                                </tr>
                                                @endforeach
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </section>

                            <section class="description bg-white m-tb-15 p-4 mb-4 rounded" id="description">
                                <div class="section-head">
                                    <h2 class="brand-font">Product Description</h2>
                                </div>
                                <div class="full-description" itemprop="description">
                                    {!! $product->description !!}
                                </div>
                            </section>

                            <section class="what_is bg-white m-tb-15 p-4 mb-4 rounded" id="what-is">
                                <div class="section-head">
                                    <h2 class="brand-font">{{ $product->what_is_q }}</h2>
                                </div>
                                <div class="full-description" itemprop="description">
                                    {!! $product->what_is_a !!}
                                </div>
                            </section>

                            <section class="ask-question q-n-r-section bg-white m-tb-15 p-4 mb-4 rounded" id="ask-question">
                                <div class="section-head justify-content-between d-flex mb-3">
                                    <div class="title-n-action d-inline-block">
                                        <h2 class="brand-font">Questions</h2>
                                        <p class="section-blurb">Have question about this product? Get specific details about this product from expert.</p>
                                        <div class="q-search">
                                            <form action="" class="form-group">
                                                <div class="input-group">
                                                    <input name="question-search" type="text" class="form-control" placeholder="Looking for an answer? Type here...">
                                                    <button type="submit" class="input-group-text"><i data-feather="search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="q-action d-inline-block">
                                        <a href="#" class="btn btn-outline-brand"><i data-feather="help-circle"></i> <span class="btn-text ps-2">Ask Question</span></a>
                                    </div>
                                </div>
                                <div id="question">
                                    <div class="question-wrap">
                                        <div class="q-item">
                                            <h5 class="question">
                                                <span class="hint fw-bold me-2">Q:</span> My one is Surface Pro 3. Is it OK for it. How can I  check before payment.
                                            </h5>
                                            <p class="answer m-0">
                                                <span class="hint fw-bold me-2">A:</span> Sorry sir, you cannot use it with Surface Pro 3. For more information please contact at 09614222333 (10 AM - 7 PM). Thank you.
                                            </p>
                                        </div>
                                        <div class="q-item">
                                            <h5 class="question">
                                                <span class="hint fw-bold me-2">Q:</span> My one is Surface Pro 3. Is it OK for it. How can I  check before payment.
                                            </h5>
                                            <p class="answer m-0">
                                                <span class="hint fw-bold me-2">A:</span> Sorry sir, you cannot use it with Surface Pro 3. For more information please contact at 09614222333 (10 AM - 7 PM). Thank you.
                                            </p>
                                        </div>
                                        <div class="q-item">
                                            <h5 class="question">
                                                <span class="hint fw-bold me-2">Q:</span> My one is Surface Pro 3. Is it OK for it. How can I  check before payment.
                                            </h5>
                                            <p class="answer m-0">
                                                <span class="hint fw-bold me-2">A:</span> Sorry sir, you cannot use it with Surface Pro 3. For more information please contact at 09614222333 (10 AM - 7 PM). Thank you.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="review  q-n-r-section bg-white m-tb-15 p-4 mb-4 rounded" id="write-review">
                                <div class="section-head justify-content-between d-flex mb-3">
                                    <div class="title-n-action d-inline-block">
                                        <h2 class="brand-font">Customer Reviews (26)</h2>
                                        <p class="section-blurb">Get specific details about this product from customers who own it.</p>
                                        <div class="average-rating">
                                            <div class="ratings">
                                                <div class="rating-box d-inline-block me-2 fill-link">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half"></i>
                                                </div>
                                                <div class="rating-count text-muted d-inline-block">
                                                    Based on 26 reviews
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="q-action d-inline-block">
                                        <a href="#" class="btn btn-outline-brand" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i data-feather="file-plus"></i><span class="btn-text ps-2">Write a Review</span></a>
                                    </div>
                                </div>
                                <div id="review">
                                    <div class="customer-reviews mt-4">
                                        <div class="review-item">
                                            <div class="row justify-content-between">
                                                <div class="user-profile col-lg-6 mb-2">
                                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Nnx8ZmFjZXxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=40&h=40&q=60" alt="" class="rounded-circle profile-pic me-2">
                                                    <div class="profile-info d-inline-block align-top">
                                                        <p class="fw-bold m-0">Michael Dam</p>
                                                        <p class="profile-meta m-0">
                                                            <small>
                                                                <span class="user-address text-muted me-2">USA</span>
                                                                <span class="date text-muted">5th April 2021</span>
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="user-rating col-lg-6 text-end">
                                                    <div class="rating-box d-inline-block me-2 small">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-text">
                                                <p class="m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, omnis, nobis. Dicta, esse, libero? Autem, ratione. Officiis mollitia, labore repudiandae architecto qui laborum dolorum atque magnam veritatis ex at perspiciatis.</p>
                                            </div>
                                        </div>
                                        <div class="review-item">
                                            <div class="row justify-content-between">
                                                <div class="user-profile col-lg-6 mb-2">
                                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Nnx8ZmFjZXxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=40&h=40&q=60" alt="" class="rounded-circle profile-pic me-2">
                                                    <div class="profile-info d-inline-block align-top">
                                                        <p class="fw-bold m-0">Michael Dam</p>
                                                        <p class="profile-meta m-0">
                                                            <small>
                                                                <span class="user-address text-muted me-2">USA</span>
                                                                <span class="date text-muted">5th April 2021</span>
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="user-rating col-lg-6 text-end">
                                                    <div class="rating-box d-inline-block me-2 small">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-text">
                                                <p class="m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, omnis, nobis. Dicta, esse, libero? Autem, ratione. Officiis mollitia, labore repudiandae architecto qui laborum dolorum atque magnam veritatis ex at perspiciatis.</p>
                                                <ul class="attachments m-0 p-0 mt-2">
                                                    <li class="d-inline-block me-2">
                                                        <a href=""><img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NXx8Y29tcHV0ZXJ8ZW58MHx8MHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt=""></a>
                                                    </li>
                                                    <li class="d-inline-block me-2">
                                                        <a href=""><img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8Y29tcHV0ZXJ8ZW58MHx8MHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt=""></a>
                                                    </li>
                                                    <li class="d-inline-block me-2">
                                                        <a href=""><img src="https://images.unsplash.com/photo-1515378960530-7c0da6231fb1?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8Y29tcHV0ZXJ8ZW58MHx8MHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt=""></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="review-item">
                                            <div class="row justify-content-between">
                                                <div class="user-profile col-lg-6 mb-2">
                                                    <img src="https://images.unsplash.com/photo-1567186937675-a5131c8a89ea?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Nnx8ZmFjZXxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=40&h=40&q=60" alt="" class="rounded-circle profile-pic me-2">
                                                    <div class="profile-info d-inline-block align-top">
                                                        <p class="fw-bold m-0">Michael Dam</p>
                                                        <p class="profile-meta m-0">
                                                            <small>
                                                                <span class="user-address text-muted me-2">USA</span>
                                                                <span class="date text-muted">5th April 2021</span>
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="user-rating col-lg-6 text-end">
                                                    <div class="rating-box d-inline-block me-2 small">
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-text">
                                                <p class="m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, omnis, nobis. Dicta, esse, libero? Autem, ratione. Officiis mollitia, labore repudiandae architecto qui laborum dolorum atque magnam veritatis ex at perspiciatis.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="compare  q-n-r-section bg-white m-tb-15 p-4 mb-4 rounded" id="product-compare">
                                <div class="section-head justify-content-between d-flex mb-3">
                                    <div class="title-n-action d-inline-block">
                                        <h2 class="brand-font">Compare with similar items</h2>
                                        <p class="section-blurb">Get specific details about this product from customers who own it.</p>
                                        <div class="average-rating"></div>
                                    </div>
                                    <div class="q-action d-inline-block">
                                        <a href="#" class="btn btn-outline-brand"><i data-feather="shopping-cart"></i> <span class="btn-text ps-2">Buy Now</span></a>
                                    </div>
                                </div>
                                <div id="compare">
                                    <table class="table table-striped" style="table-layout: fixed;">
                                        <tr class="d-none"></tr>
                                        <tr>
                                            <th scope="row"></th>
                                            <td>
                                                <img src="https://images.unsplash.com/photo-1525548002014-e18135d814d7?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" class="card-img-top" alt="...">
                                            </td>
                                            <td>
                                                <img src="https://images.unsplash.com/photo-1523688939046-b05f7d854f84?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" class="card-img-top" alt="...">
                                            </td>
                                            <td>
                                                <img src="https://images.unsplash.com/photo-1589466725882-f47191476e8c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" class="card-img-top" alt="...">
                                            </td>
                                            <td>
                                                <img src="https://images.unsplash.com/photo-1537498425277-c283d32ef9db?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" class="card-img-top" alt="...">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"></th>
                                            <td>
                                                <h5 class="card-title brand-font">Fantech FTK-801 USB Numeric Keypad</h5>
                                            </td>
                                            <td>
                                                <h5 class="card-title brand-font">Xtreme KB6109 Black Wired Keyboard with Bangla</h5>
                                            </td>
                                            <td>
                                                <h5 class="card-title brand-font">Micropack K203 Black Basic USB Keyboard with Bangla</h5>
                                            </td>
                                            <td>
                                                <h5 class="card-title brand-font">Fantech AC4101L Black Keyboard Wristpad</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"></th>
                                            <td>
                                                <p class="card-text">Best quality charger adapter for TOSHIBA brand different Series Laptop. 6 Month warranty.</p>
                                            </td>
                                            <td>
                                                <p class="card-text">Dedicated buttons for Windows shortcuts, media controls, screen brightness,Right click button</p>
                                            </td>
                                            <td>
                                                <p class="card-text">Dimension 11.60 in (295 mm) x 8.50 in (216 mm) x 0.19 in (4.65 mm) </p>
                                            </td>
                                            <td>
                                                <p class="card-text">The next generation of Type Cover, made for Surface Pro, offers the most advanced Surface typing experience yet.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"></th>
                                            <td>
                                                <p class="d-grid m-0"><a href="#" class="btn btn-brand"><i data-feather="book-open"></i><span class="btn-text ps-2">Details</span></a></p>
                                            </td>
                                            <td>
                                                <p class="d-grid m-0"><a href="#" class="btn btn-brand"><i data-feather="book-open"></i><span class="btn-text ps-2">Details</span></a></p>
                                            </td>
                                            <td>
                                                <p class="d-grid m-0"><a href="#" class="btn btn-brand"><i data-feather="book-open"></i><span class="btn-text ps-2">Details</span></a></p>
                                            </td>
                                            <td>
                                                <p class="d-grid m-0"><a href="#" class="btn btn-brand"><i data-feather="book-open"></i><span class="btn-text ps-2">Details</span></a></p>
                                            </td>
                                        </tr>
                                        <tr class="icon-fill-brand">
                                            <th scope="row">Rating</th>
                                            <td>
                                                <i data-feather="star"></i><i data-feather="star"></i><i data-feather="star"></i><i data-feather="star"></i> (24)
                                            </td>
                                            <td>
                                                <i data-feather="star"></i><i data-feather="star"></i><i data-feather="star"></i><i data-feather="star"></i><i data-feather="star"></i> (3)
                                            </td>
                                            <td>
                                                <i data-feather="star"></i><i data-feather="star"></i><i data-feather="star"></i><i data-feather="star"></i><i data-feather="star"></i> (1559)
                                            </td>
                                            <td>
                                                <i data-feather="star"></i><i data-feather="star"></i><i data-feather="star"></i> (56)
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Price</th>
                                            <td>tk 38,000</td>
                                            <td>tk 38,000</td>
                                            <td>tk 38,000</td>
                                            <td>tk 38,000</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">CPU Model Manufacturer</th>
                                            <td>AMD</td>
                                            <td>Intel</td>
                                            <td>AMD</td>
                                            <td>Intel</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">CPU Speed</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Display Resolution Maximum</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Display Resolution Maximum</th>
                                            <td>1920x1080 pixel</td>
                                            <td>1920x1080 pixel</td>
                                            <td>1920x1080 pixel</td>
                                            <td>1920x1080 pixel</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Screen Size</th>
                                            <td>15.6 inches</td>
                                            <td>15.6 inches</td>
                                            <td>15.6 inches</td>
                                            <td>15.6 inches</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Hard Disk Size</th>
                                            <td>128 GB</td>
                                            <td>128 GB</td>
                                            <td>128 GB</td>
                                            <td>128 GB</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Item Weight</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">RAM Type</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                            <td>@fat</td>
                                        </tr>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sidebar">
                        <ul class="backto-links p-0 m-0 py-2 my-1">
                            <li class="d-grid"><a href="" class="btn btn-brand"><i data-feather="check-circle"></i><span class="btn-text ms-2">Request a price match</span></a></li>
                        </ul>
                        <div class="sidebar-content">
                            <section class="bg-white rounded p-4 mb-4 pt-0 pb-2">
                                <div class="sidebar-title">
                                    <h6 class="border-bottom py-3">Related Products</h6>
                                </div>
                                <div class="sidebar-body">
                                    <div class="product-row row my-3">
                                        <div class="product-image col-lg-4">
                                            <a href="">
                                                <img src="https://images.unsplash.com/photo-1560762484-813fc97650a0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTh8fGNvbXB1dGVyfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=80&h=80&q=60" alt="">
                                            </a>
                                        </div>
                                        <div class="product-info col-lg-8">
                                            <a href="">
                                                <p class="product-title title brand-font">Microsoft Surface Pro Type Cover Keyboard - Black</p>
                                                <p class="product-price">tk 13,000</p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-row row my-3">
                                        <div class="product-image col-lg-4">
                                            <a href="">
                                                <img src="https://images.unsplash.com/photo-1560762484-813fc97650a0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTh8fGNvbXB1dGVyfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=80&h=80&q=60" alt="">
                                            </a>
                                        </div>
                                        <div class="product-info col-lg-8">
                                            <a href="">
                                                <p class="product-title title brand-font">Microsoft Surface Pro Type Cover Keyboard - Black</p>
                                                <p class="product-price">tk 13,000</p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-row row my-3">
                                        <div class="product-image col-lg-4">
                                            <a href="">
                                                <img src="https://images.unsplash.com/photo-1560762484-813fc97650a0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTh8fGNvbXB1dGVyfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=80&h=80&q=60" alt="">
                                            </a>
                                        </div>
                                        <div class="product-info col-lg-8">
                                            <a href="">
                                                <p class="product-title title brand-font">Microsoft Surface Pro Type Cover Keyboard - Black</p>
                                                <p class="product-price">tk 13,000</p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-row row my-3">
                                        <div class="product-image col-lg-4">
                                            <a href="">
                                                <img src="https://images.unsplash.com/photo-1560762484-813fc97650a0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTh8fGNvbXB1dGVyfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=80&h=80&q=60" alt="">
                                            </a>
                                        </div>
                                        <div class="product-info col-lg-8">
                                            <a href="">
                                                <p class="product-title title brand-font">Microsoft Surface Pro Type Cover Keyboard - Black</p>
                                                <p class="product-price">tk 13,000</p>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-row row my-3">
                                        <div class="product-image col-lg-4">
                                            <a href="">
                                                <img src="https://images.unsplash.com/photo-1560762484-813fc97650a0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTh8fGNvbXB1dGVyfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=80&h=80&q=60" alt="">
                                            </a>
                                        </div>
                                        <div class="product-info col-lg-8">
                                            <a href="">
                                                <p class="product-title title brand-font">Microsoft Surface Pro Type Cover Keyboard - Black</p>
                                                <p class="product-price">tk 13,000</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="bg-white rounded p-4 mb-4 pt-0 pb-2">
                                <div class="sidebar-title">
                                    <h6 class="border-bottom py-3">Banner</h6>
                                </div>
                                <div class="sidebar-body my-3">
                                    <a href="">
                                        <img src="https://images.unsplash.com/photo-1560762484-813fc97650a0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTh8fGNvbXB1dGVyfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=250&h=150&q=60" alt="">
                                    </a>
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
                                    <div class="video-row my-3">
                                        <a href="" class="">
                                            <img src="https://images.unsplash.com/photo-1560762484-813fc97650a0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTh8fGNvbXB1dGVyfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=250&h=150&q=60" alt="">
                                            <p class="title video-title brand-font">Microsoft Surface Pro Type Cover Keyboard - Black</p>
                                        </a>
                                    </div>
                                    <div class="video-row my-3">
                                        <a href="" class="">
                                            <img src="https://images.unsplash.com/photo-1560762484-813fc97650a0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTh8fGNvbXB1dGVyfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=250&h=150&q=60" alt="">
                                            <p class="title video-title brand-font">Microsoft Surface Pro Type Cover Keyboard - Black</p>
                                        </a>
                                    </div>
                                    <div class="video-row my-3">
                                        <a href="" class="">
                                            <img src="https://images.unsplash.com/photo-1560762484-813fc97650a0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTh8fGNvbXB1dGVyfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=250&h=150&q=60" alt="">                                                    <p class="title video-title brand-font">Microsoft Surface Pro Type Cover Keyboard - Black</p>
                                        </a>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('script')
        <script>
        window.addEventListener('scroll', function() {
            // console.log('scrolled')
            if (window.scrollY > 920) {
                // console.log('scrolled > 250')
                document.getElementById('product_desc_nav').classList.add('fixed-top');
                // add padding top to show content behind navbar
                navbar_top = document.querySelector('#navbar_top').offsetHeight;
                navbar_height = document.querySelector('.desc-links').offsetHeight;
                document.getElementById('product_desc_nav').style.top = navbar_top + 'px';
                // document.getElementById('product_desc_nav').style.paddingTop = navbar_height + 'px';
            } else {
                // console.log('scrolled < 50')
                document.getElementById('product_desc_nav').classList.remove('fixed-top');
                // remove padding top from body
                document.getElementById('product_desc_nav').style.paddingTop = '0';
            } 
        });
        </script>
    @endpush
</x-front-layout>