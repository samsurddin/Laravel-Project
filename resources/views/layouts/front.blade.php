<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Bootstrap CSS -->
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
        <!-- <link href="assets/vendor/bootstrap-5.0.2/css/bootstrap.min.css" rel="stylesheet"> -->

        <script src="https://unpkg.com/feather-icons"></script>
        {{-- <script defer src="assets/vendor/fontawesome-free-5.15.3-web/js/solid.js"></script>
        <script defer src="assets/vendor/fontawesome-free-5.15.3-web/js/fontawesome.js"></script> --}}

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;600;700&display=swap" rel="stylesheet">

        @stack('style')

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

        @livewireStyles

        <!-- Scripts -->
        {{-- <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body {{ $attributes->merge(['class' => 'font-sans antialiased']) }}>
        <header class="">
            <x-topbar email="itskawsar" phone="9090090" company="EIT Limited" />
            <div class="main_header py-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 h-25 logo">
                            <img src="/images/last_logo.png" alt="">
                        </div>
                        <div class="col-lg-7 search">
                            <x-search-form/>
                            <!-- <form action="" class="form-group">
                                <a href="">Categories</a>
                                <input type="text">
                                <button type="submit">search</button>
                            </form> -->
                        </div>
                        <div class="col-lg-2 quick-icons text-end">
                            <ul class="p-0 m-0">
                                <li class="d-inline-block user-icon">
                                    @if ($user = Auth::user())
                                    <a href="{{ route('profile.show') }}">
                                        Hello, {{ $user->name }}<br><strong>My Account</strong>
                                    </a>
                                    @else
                                    <a href="{{ route('login') }}">
                                        Hello, Friend<br><strong>Login Now</strong>
                                    </a>
                                    @endif
                                </li>
                                <li class="d-inline-block wishlist-icon">
                                    <a href=""><i data-feather="heart"></i></a>
                                </li>
                                <li class="d-inline-block cart-icon">
                                    <a href="{{ route('cart.index') }}" class=" position-relative">
                                        <i data-feather="shopping-cart"></i>
                                        @php
                                        $total_qty = getTotalQuantity();
                                        // dd($total_qty);
                                        @endphp
                                        @if ($total_qty > 0)
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                {{ $total_qty }}
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <x-menubar/>
        </header>

        <main class="">
            {{ $slot }}
        </main>

        <footer>
            <div class="footer-top mt-5 py-5 bg-brand-dark text-light">
                <div class="container-fluid">
                    <div class="row wrapper">
                        <div class="col-lg-4">
                            <!-- <h6>Eastern Information Technologies Limited</h6> -->
                            <div class="com-info-box mb-4">
                                <img src="/images/last_logo.png" alt="" class="logo mb-3" width="150px">
                                <p class="com-info mb-3">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing, elit. Et distinctio eius id quae ut ducimus, illo molestias quasi hic sit optio dolorum repellendus dicta excepturi non enim nulla dolore veniam!
                                </p>
                                <ul class="social links p-0 m-0">
                                    <li class="facebook">
                                        <a href="">
                                            <!-- <img height="32" width="32" src="https://unpkg.com/simple-icons@v5/icons/facebook.svg" /> -->
                                            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Facebook</title><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        </a>
                                    </li>
                                    <li class="twitter">
                                        <a href="">
                                            <!-- <img height="32" width="32" src="https://unpkg.com/simple-icons@v5/icons/twitter.svg" /> -->
                                            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Twitter</title><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                        </a>
                                    </li>
                                    <li class="instagram">
                                        <a href="">
                                            <!-- <img height="32" width="32" src="https://unpkg.com/simple-icons@v5/icons/instagram.svg" /> -->
                                            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Instagram</title><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                                        </a>
                                    </li>
                                    <li class="linkedin">
                                        <a href="">
                                            <!-- <img height="32" width="32" src="https://unpkg.com/simple-icons@v5/icons/linkedin.svg" /> -->
                                            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>LinkedIn</title><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                        </a>
                                    </li>
                                    <li class="youtube">
                                        <a href="">
                                            <!-- <img height="32" width="32" src="https://unpkg.com/simple-icons@v5/icons/youtube.svg" /> -->
                                            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>YouTube</title><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <p class="shadow-sm p-2 px-3 mb-5 text-white rounded warning"><span class="me-1"><i data-feather="alert-triangle"></i></span> All prices are subject to change without prior notice</p>
                        </div>
                        <div class="col-lg-4">
                            <h6>Contacts</h6>
                            <p class="address">
                                39, Kazi Babhan (4th Floor),<br>
                                New Elephant Road, Dhaka - 1205
                            </p>
                            <p>
                                <span class="fw-bold">Mobile: </span> <a href="tel:+88 01155155666">+88 01155 155 666</a> <br>
                                <span class="fw-bold">Telephone: </span> <a href="tel:+8802615566">+88 02 615 566</a> <br>
                                <span class="fw-bold">Email: </span>
                                <a href="mailto:sales@eit.com.bd">sales@eit.com.bd</a>, 
                                <a href="mailto:sales@eit.com.bd">sales@eit.com.bd</a>, 
                                <a href="mailto:sales@eit.com.bd">sales@eit.com.bd</a>, 
                                <a href="mailto:sales@eit.com.bd">sales@eit.com.bd</a>
                            </p>
                        </div>
                        <div class="col-lg-2">
                            <h6>Get to know</h6>
                            <ul class="links p-0 m-0">
                                <li><a href="">About Us</a></li>
                                <li><a href="">Warranty</a></li>
                                <li><a href="">Payment Method</a></li>
                                <li><a href="">Return &amp; Replacement</a></li>
                                <li><a href="">Privacy Policy</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-2">
                            <h6>Our Branches</h6>
                            <ul class="links p-0 m-0">
                                <li><a href="">Motijheel</a></li>
                                <li><a href="">IDB Branch</a></li>
                                <li><a href="">Factory &amp; Warehouse</a></li>
                                <li><a href="">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom copyright">
                
            </div>
        </footer>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="">
                        <div class="modal-header">
                            <h5 class="modal-title brand-font" id="staticBackdropLabel">Write review</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row g-3">
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Email</label>
                                <input type="email" class="form-control" id="inputEmail4">
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Password</label>
                                <input type="password" class="form-control" id="inputPassword4">
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                            </div>
                            <div class="col-12">
                                <label for="inputAddress2" class="form-label">Address 2</label>
                                <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                            </div>
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">City</label>
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                            <div class="col-md-4">
                                <label for="inputState" class="form-label">State</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choose...</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="inputZip" class="form-label">Zip</label>
                                <input type="text" class="form-control" id="inputZip">
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">
                                        Check me out
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-brand" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-brand">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Simple Modal -->
        <div class="modal fade" id="simpleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="simpleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="">
                        <div class="modal-header">
                            <h5 class="modal-title brand-font" id="simpleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row g-3">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-brand" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-brand">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="make_toast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- Optional JavaScript; choose one of the two! -->
        {{-- <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
        <script src="{{ mix('js/custom.js') }}" defer></script>

        <script>
            function make_toast(msg, type="success") {
                // console.log(type)
                // $(".toast").toast('hide')
                $(".toast").find('.toast-body').text(msg);
                $(".toast").addClass('bg-'+type);
                $('.toast').toast('show');
            }
            function distroy_toast(selector='.toast') {
                $(selector).toast('hide');
            }
        </script>

        @stack('script')

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <!-- <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
        {{-- <script defer src="assets/vendor/bootstrap-5.0.2/js/bootstrap.min.js"></script> --}}

        {{-- <script defer src="{{ asset('js/app.js') }}"></script> --}}
        {{-- <script defer src="assets/js/custom.js"></script> --}}
        {{-- <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
        {{-- <script defer src="{{ asset('js/app.js') }}"></script> --}}

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        -->
    </body>
</html>
