<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta Data -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ $title ?? config('app.name', 'Laravel') }}</title> --}}

    {!! $seotags ?? '' !!}
	{!! $breadcrumbs ?? '' !!}
	{!! $jsonld ?? '' !!}

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset('frontend')}}/images/icons/favicon.png">

    <!-- WebFont.js -->
    <script>
        WebFontConfig = {
            google: {
                families: ['Poppins:400,500,600,700']
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];
            wf.src = '{{asset('frontend')}}/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <link rel="preload" href="{{asset('frontend')}}/vendor/fontawesome-free/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{asset('frontend')}}/vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{asset('frontend')}}/vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{asset('frontend')}}/fonts/wolmart87d5.woff?png09e" as="font" type="font/woff" crossorigin="anonymous">

    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/vendor/fontawesome-free/css/all.min.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{asset('frontend')}}/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/vendor/animate/animate.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/vendor/magnific-popup/magnific-popup.min.css">

    <!-- Default CSS -->
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/demo2.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/custome.css">

    @stack('css')
</head>

<body class="home">
    <div class="page-wrapper">
        <!-- Start of Header -->
        @include('frontend.partials.navbar')
        <!-- End of Header -->

        <!-- Start of Main -->
        
        <main class="main">
            {{ $slot }}
        </main>
        <!-- End of Main -->

        <!-- Start of Footer -->
        @include('frontend.partials.footer')
        <!-- End of Footer -->
    </div>
    <!-- End of .page-wrapper -->

    @include('frontend.partials.theme-switcher')

    <!-- Plugin JS File -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{asset('frontend')}}/vendor/jquery/jquery.min.js"></script>
    <script src="{{asset('frontend')}}/vendor/jquery.plugin/jquery.plugin.min.js"></script>
    <script src="{{asset('frontend')}}/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="{{asset('frontend')}}/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{asset('frontend')}}/vendor/jquery.countdown/jquery.countdown.min.js"></script>
    <script src="{{asset('frontend')}}/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="{{asset('frontend')}}/vendor/floating-parallax/parallax.min.js"></script>
    <script src="{{asset('frontend')}}/vendor/zoom/jquery.zoom.js"></script>

    @stack('js')

    <!-- Main Js -->
    <script src="{{asset('frontend')}}/js/main.min.js"></script>
    <script>
        (function() {
            function c() {
                var b = a.contentDocument || a.contentWindow.document;
                if (b) {
                    var d = b.createElement('script');
                    d.innerHTML =
                        "window.__CF$cv$params={r:'9c189b869bd4a138',t:'MTc2OTAxNzMzOQ=='};var a=document.createElement('script');a.src='../../cdn-cgi/challenge-platform/h/b/scripts/jsd/d251aa49a8a3/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";
                    b.getElementsByTagName('head')[0].appendChild(d)
                }
            }
            if (document.body) {
                var a = document.createElement('iframe');
                a.height = 1;
                a.width = 1;
                a.style.position = 'absolute';
                a.style.top = 0;
                a.style.left = 0;
                a.style.border = 'none';
                a.style.visibility = 'hidden';
                document.body.appendChild(a);
                if ('loading' !== document.readyState) c();
                else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c);
                else {
                    var e = document.onreadystatechange || function() {};
                    document.onreadystatechange = function(b) {
                        e(b);
                        'loading' !== document.readyState && (document.onreadystatechange = e, c())
                    }
                }
            }
        })();
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"version":"2024.11.0","token":"ecd4920e43e14654b78e65dbf8311922","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}'
        crossorigin="anonymous"></script>
</body>
</html>
