<x-frontend-layout title="Home Page" :breadcrumbs="$breadcrumbs" :seotags="$seotags">
        <div class="intro-section">
            <div class="swiper-container swiper-theme nav-inner pg-inner animation-slider pg-xxl-hide pg-show nav-xxl-show nav-hide"
                data-swiper-options="{
                'slidesPerView': 1,
                'autoplay': {
                    'delay': 4000,
                    'disableOnInteraction': false }
                }">
                <div class="swiper-wrapper row gutter-no cols-1">
                    <div class="swiper-slide banner banner-fixed intro-slide intro-slide1"
                        style="background-image: url({{asset('frontend')}}/images/demos/demo2/slides/slide-1.jpg); background-color: #f1f0f0;">
                        <div class="container">
                            <figure class="slide-image floating-item slide-animate"
                                data-animation-options="{
                                'name': 'fadeInDownShorter', 'duration': '1s'
                            }"
                                data-options="{'relativeInput':true,'clipRelativeInput':true,'invertX':true,'invertY':true}"
                                data-child-depth="0.2">
                                <img src="{{asset('frontend')}}/images/demos/demo2/slides/ski.png" alt="Ski" width="729"
                                    height="570" />
                            </figure>
                            <div class="banner-content text-right y-50 ml-auto">
                                <h5 class="banner-subtitle text-uppercase font-weight-bold mb-2 slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInUpShorter', 'duration': '1s'
                                }">
                                    Deals And Promotions</h5>
                                <h3 class="banner-title ls-25 mb-6 slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInUpShorter', 'duration': '1s'
                                }">
                                    Fashion <span class="text-primary">Skiwears</span> for the ardent Sports
                                    devotees
                                </h3>
                                <a href="shop-banner-sidebar.html"
                                    class="btn btn-dark btn-outline btn-rounded btn-icon-right slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInUpShorter', 'duration': '1s'
                                }">
                                    Shop Now<i class="w-icon-long-arrow-right"></i></a>
                            </div>
                            <!-- End of .banner-content -->
                        </div>
                        <!-- End of .container -->
                    </div>
                    <!-- End of .intro-slide1 -->

                    <div class="swiper-slide banner banner-fixed intro-slide intro-slide2"
                        style="background-image: url({{asset('frontend')}}/images/demos/demo2/slides/slide-2.jpg); background-color: #d9ddd9;">
                        <div class="container">
                            <figure class="slide-image floating-item slide-animate"
                                data-animation-options="{
                                'name': 'fadeInUpShorter', 'duration': '1s'
                            }"
                                data-options="{'relativeInput':true,'clipRelativeInput':true,'invertX':true,'invertY':true}"
                                data-child-depth="0.2">
                                <img src="{{asset('frontend')}}/images/demos/demo2/slides/woman.png" alt="Ski"
                                    width="865" height="732" />
                            </figure>
                            <div class="banner-content y-50">
                                <h5 class="banner-subtitle text-uppercase font-weight-bold mb-2 slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInRightShorter', 'duration': '1s', 'delay': '.5s'
                                }">
                                    News And Inspiration</h5>
                                <h3 class="banner-title ls-25 mb-2 text-uppercase lh-1 slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInRightShorter', 'duration': '1s', 'delay': '.7s'
                                }">
                                    Natural Sound</h3>
                                <div class="banner-price-info font-weight-bold text-dark ls-25 slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInRightShorter', 'duration': '1s', 'delay': '.9s'
                                }">
                                    Sale up to
                                    <span class="text-primary font-weight-bolder text-uppercase ls-normal">30%
                                        Off</span>
                                </div>
                                <p class="font-weight-normal text-default ls-25 slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInRightShorter', 'duration': '1s', 'delay': '1.1s'
                                }">
                                    Free returns extended to 30 days after delivery</p>
                                <a href="shop-banner-sidebar.html"
                                    class="btn btn-dark btn-outline btn-rounded btn-icon-right slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInRightShorter', 'duration': '1s', 'delay': '1.3s'
                                }">
                                    Shop Now<i class="w-icon-long-arrow-right"></i></a>
                            </div>
                            <!-- End of .banner-content -->
                        </div>
                        <!-- End of .container -->
                    </div>
                    <!-- End of .intro-slide2 -->

                    <div class="swiper-slide banner banner-fixed intro-slide intro-slide3"
                        style="background-image: url({{asset('frontend')}}/images/demos/demo2/slides/slide-3.jpg); background-color: #d0cfcb;">
                        <div class="container">
                            <figure class="slide-image floating-item slide-animate"
                                data-animation-options="{
                                'name': 'fadeInRightShorter', 'duration': '1s'
                            }"
                                data-options="{'relativeInput':true,'clipRelativeInput':true,'invertX':true,'invertY':true}"
                                data-child-depth="0.2">
                                <img src="{{asset('frontend')}}/images/demos/demo2/slides/man.png" alt="Ski" width="527"
                                    height="481" />
                            </figure>
                            <div class="banner-content y-50">
                                <h5 class="banner-subtitle text-uppercase font-weight-bold slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInRightShorter', 'duration': '1s'
                                }">
                                    Top Monthly Seller</h5>
                                <h4 class="banner-title ls-25 slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInRightShorter', 'duration': '1s'
                                }">
                                    Sumsung 52 Inches Full HD <span class="text-primary">Smart LED</span> TV</h4>
                                <p class="font-weight-normal text-dark slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInRightShorter', 'duration': '1s'
                                }">
                                    Only until the end of this week.</p>
                                <a href="shop-banner-sidebar.html"
                                    class="btn btn-dark btn-outline btn-rounded btn-icon-right slide-animate"
                                    data-animation-options="{
                                    'name': 'fadeInRightShorter', 'duration': '1s'
                                }">Shop
                                    Now<i class="w-icon-long-arrow-right"></i></a>
                            </div>
                            <!-- End of .banner-content -->
                        </div>
                        <!-- End of .container -->
                    </div>
                    <!-- End of .intro-slide3 -->
                </div>
                <div class="swiper-pagination"></div>
                <button class="swiper-button-next"></button>
                <button class="swiper-button-prev"></button>
            </div>
        </div>
        <!-- End of .intro-section -->

        <div class="container">
            <div class="swiper-container swiper-theme icon-box-wrapper appear-animate br-sm mt-6 mb-10"
                data-swiper-options="{
                    'loop': true,
                    'slidesPerView': 1,
                    'autoplay': {
                        'delay': 4000,
                        'disableOnInteraction': false
                    },
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 2
                        },
                        '768': {
                            'slidesPerView': 3
                        },
                        '1200': {
                            'slidesPerView': 4
                        }
                    }
                }">
                <div class="swiper-wrapper row cols-md-4 cols-sm-3 cols-1">
                    <div class="swiper-slide icon-box icon-box-side text-dark">
                        <span class="icon-box-icon icon-shipping">
                            <i class="w-icon-truck"></i>
                        </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title">Free Shipping & Returns</h4>
                            <p class="text-default">For all orders over $99</p>
                        </div>
                    </div>
                    <div class="swiper-slide icon-box icon-box-side text-dark">
                        <span class="icon-box-icon icon-payment">
                            <i class="w-icon-bag"></i>
                        </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title">Secure Payment</h4>
                            <p class="text-default">We ensure secure payment</p>
                        </div>
                    </div>
                    <div class="swiper-slide icon-box icon-box-side text-dark icon-box-money">
                        <span class="icon-box-icon icon-money">
                            <i class="w-icon-money"></i>
                        </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title">Money Back Guarantee</h4>
                            <p class="text-default">Any back within 30 days</p>
                        </div>
                    </div>
                    <div class="swiper-slide icon-box icon-box-side text-dark icon-box-chat">
                        <span class="icon-box-icon icon-chat">
                            <i class="w-icon-chat"></i>
                        </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title">Customer Support</h4>
                            <p class="text-default">Call or email us 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Iocn Box Wrapper -->

            <div class="banner-product-wrapper appear-animate row mb-8">
                <div class="col-xl-5col col-md-4 mb-4">
                    <div class="categories h-100">
                        <h2 class="title text-left">Clothes &amp; Fashion Apparel</h2>
                        <ul class="list-style-none mb-4">
                            <li><a href="shop-banner-sidebar.html">Accessories</a></li>
                            <li><a href="shop-banner-sidebar.html">Bodyclothes</a></li>
                            <li><a href="shop-banner-sidebar.html">Dress &amp; Skirts</a></li>
                            <li><a href="shop-banner-sidebar.html">Jeans</a></li>
                            <li><a href="shop-banner-sidebar.html">Jumpers</a></li>
                            <li><a href="shop-banner-sidebar.html">Knitwears</a></li>
                            <li><a href="shop-banner-sidebar.html">Lounge &amp; Underwear</a></li>
                            <li><a href="shop-banner-sidebar.html">Shoes</a></li>
                            <li><a href="shop-banner-sidebar.html">T-shirts</a></li>
                        </ul>
                        <a href="shop-boxed-banner.html"
                            class="btn btn-dark btn-link btn-underline btn-icon-right font-weight-bolder text-capitalize ls-50">
                            Browse All<i class="w-icon-long-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-xl-5col4 col-md-8 mb-4">
                    <div class="row">
                        @foreach($products as $product)
                            @include('frontend.partials.prodcut-item1', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- End of Banner Product Wrapper -->

            <h2 class="title text-left text-capitalize mb-5 appear-animate">Your Recent Views</h2>
            <div class="swiper-container swiper-theme appear-animate viewed-products mb-7"
                data-swiper-options="{
                    'spaceBetween': 20,
                    'slidesPerView': 2,
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 3
                        },
                        '768': {
                            'slidesPerView': 5
                        },
                        '992': {
                            'slidesPerView': 6
                        },
                        '1200': {
                            'slidesPerView': 8
                        }
                    }
                }">
                <div class="swiper-wrapper row cols-xl-8 cols-lg-6 cols-md-4 cols-2">
                    <div class="swiper-slide">
                        <div class="product text-center product-absolute">
                            <figure class="product-media">
                                <a
                                    href="https://www.portotheme.com/html/wolmart/product-defaproduct-default.html">
                                    <img src="{{asset('frontend')}}/images/demos/demo2/products/3-5-1.jpg" alt="Category image"
                                        width="300" height="338" style="background-color: #fff" />
                                </a>
                            </figure>
                            <h4 class="product-name">
                                <a href="product-default.html">Charge &amp; Alarm Machine</a>
                            </h4>
                        </div>
                    </div>
                    <!-- End of Product Wrap -->
                    <div class="swiper-slide">
                        <div class="product text-center product-absolute">
                            <figure class="product-media">
                                <a
                                    href="https://www.portotheme.com/html/wolmart/product-defaproduct-default.html">
                                    <img src="{{asset('frontend')}}/images/demos/demo2/products/4-2-1.jpg" alt="Category image"
                                        width="300" height="338" style="background-color: #fff" />
                                </a>
                            </figure>
                            <h4 class="product-name">
                                <a href="product-default.html">Women's Comforter</a>
                            </h4>
                        </div>
                    </div>
                    <!-- End of Product Wrap -->
                    <div class="swiper-slide">
                        <div class="product text-center product-absolute">
                            <figure class="product-media">
                                <a
                                    href="https://www.portotheme.com/html/wolmart/product-defaproduct-default.html">
                                    <img src="{{asset('frontend')}}/images/demos/demo2/products/3-2-1.jpg" alt="Category image"
                                        width="300" height="338" style="background-color: #fff" />
                                </a>
                            </figure>
                            <h4 class="product-name">
                                <a href="product-default.html">Gold Watch</a>
                            </h4>
                        </div>
                    </div>
                    <!-- End of Product Wrap -->
                    <div class="swiper-slide">
                        <div class="product text-center product-absolute">
                            <figure class="product-media">
                                <a
                                    href="https://www.portotheme.com/html/wolmart/product-defaproduct-default.html">
                                    <img src="{{asset('frontend')}}/images/demos/demo2/products/3-6-1.jpg" alt="Category image"
                                        width="300" height="338" style="background-color: #fff" />
                                </a>
                            </figure>
                            <h4 class="product-name">
                                <a href="product-default.html">Mini Wireless Earphone</a>
                            </h4>
                        </div>
                    </div>
                    <!-- End of Product Wrap -->
                    <div class="swiper-slide">
                        <div class="product text-center product-absolute">
                            <figure class="product-media">
                                <a
                                    href="https://www.portotheme.com/html/wolmart/product-defaproduct-default.html">
                                    <img src="{{asset('frontend')}}/images/demos/demo2/products/4-1-1.jpg" alt="Category image"
                                        width="300" height="338" style="background-color: #fff" />
                                </a>
                            </figure>
                            <h4 class="product-name">
                                <a href="product-default.html">White Schoolbag</a>
                            </h4>
                        </div>
                    </div>
                    <!-- End of Product Wrap -->
                    <div class="swiper-slide">
                        <div class="product text-center product-absolute">
                            <figure class="product-media">
                                <a
                                    href="https://www.portotheme.com/html/wolmart/product-defaproduct-default.html">
                                    <img src="{{asset('frontend')}}/images/demos/demo2/products/3-7-1.jpg" alt="Category image"
                                        width="300" height="338" style="background-color: #fff" />
                                </a>
                            </figure>
                            <h4 class="product-name">
                                <a href="product-default.html">High Quality Screen Tablet</a>
                            </h4>
                        </div>
                    </div>
                    <!-- End of Product Wrap -->
                    <div class="swiper-slide">
                        <div class="product text-center product-absolute">
                            <figure class="product-media">
                                <a
                                    href="https://www.portotheme.com/html/wolmart/product-defaproduct-default.html">
                                    <img src="{{asset('frontend')}}/images/demos/demo2/products/4-4.jpg" alt="Category image"
                                        width="300" height="338" style="background-color: #fff" />
                                </a>
                            </figure>
                            <h4 class="product-name">
                                <a href="product-default.html">Beyond OTP Shirt</a>
                            </h4>
                        </div>
                    </div>
                    <!-- End of Product Wrap -->
                    <div class="swiper-slide">
                        <div class="product text-center product-absolute">
                            <figure class="product-media">
                                <a
                                    href="https://www.portotheme.com/html/wolmart/product-defaproduct-default.html">
                                    <img src="{{asset('frontend')}}/images/demos/demo2/products/4-3.jpg" alt="Category image"
                                        width="300" height="338" style="background-color: #fff" />
                                </a>
                            </figure>
                            <h4 class="product-name">
                                <a href="product-default.html">Blue Training Shoes</a>
                            </h4>
                        </div>
                    </div>
                    <!-- End of Product Wrap -->
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <!-- End of Swiper Container -->

            <h2 class="title text-left mb-5 appear-animate">Our Clients</h2>
            <div class="swiper-container swiper-theme brands-wrapper br-sm mb-10 appear-animate"
                data-swiper-options="{
                'loop': true,
                'spaceBetween': 20,
                'slidesPerView': 2,
                'autoplay': {
                    'delay': 4000,
                    'disableOnInteraction': false
                },
                'breakpoints': {
                    '576': {
                        'slidesPerView': 3
                    },
                    '768': {
                        'slidesPerView': 4
                    },
                    '992': {
                        'slidesPerView': 6
                    },
                    '1200': {
                        'slidesPerView': 8
                    }
                }
            }">
                <div class="swiper-wrapper row cols-xl-8 cols-lg-6 cols-md-4 cols-sm-3 cols-2">
                    <div class="swiper-slide">
                        <figure>
                            <img src="{{asset('frontend')}}/images/demos/demo2/brands/1.png" alt="Brand" width="290"
                                height="100" />
                        </figure>
                    </div>
                    <div class="swiper-slide">
                        <figure>
                            <img src="{{asset('frontend')}}/images/demos/demo2/brands/2.png" alt="Brand" width="290"
                                height="100" />
                        </figure>
                    </div>
                    <div class="swiper-slide">
                        <figure>
                            <img src="{{asset('frontend')}}/images/demos/demo2/brands/3.png" alt="Brand" width="290"
                                height="100" />
                        </figure>
                    </div>
                    <div class="swiper-slide">
                        <figure>
                            <img src="{{asset('frontend')}}/images/demos/demo2/brands/4.png" alt="Brand" width="290"
                                height="100" />
                        </figure>
                    </div>
                    <div class="swiper-slide">
                        <figure>
                            <img src="{{asset('frontend')}}/images/demos/demo2/brands/5.png" alt="Brand" width="290"
                                height="100" />
                        </figure>
                    </div>
                    <div class="swiper-slide">
                        <figure>
                            <img src="{{asset('frontend')}}/images/demos/demo2/brands/6.png" alt="Brand" width="290"
                                height="100" />
                        </figure>
                    </div>
                    <div class="swiper-slide">
                        <figure>
                            <img src="{{asset('frontend')}}/images/demos/demo2/brands/7.png" alt="Brand" width="290"
                                height="100" />
                        </figure>
                    </div>
                    <div class="swiper-slide">
                        <figure>
                            <img src="{{asset('frontend')}}/images/demos/demo2/brands/8.png" alt="Brand" width="290"
                                height="100" />
                        </figure>
                    </div>
                </div>
            </div>
            <!-- End of Brands Wrapper -->

        </div>
        <!-- End of Container -->
    </main>
</x-frontend-layout>
