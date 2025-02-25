<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('user/image/favicon.png') }}" type="image/png">
    <title>Royal Hotel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('user/vendors/linericon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/vendors/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/vendors/nice-select/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('user/vendors/owl-carousel/owl.carousel.min.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/responsive.css') }}">
</head>
<header class="header_area">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <!-- Brand and toggle get grouped for better mobile display -->
            <a class="navbar-brand logo_h" href="index.html"><img src="{{ asset('user/image/Logo.png')}}" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                <ul class="nav navbar-nav menu_nav ml-auto">
                    <li class="nav-item active"><a class="nav-link" href="{{ route('home.html') }}">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about.html') }}">Về chúng tôi</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('list.html') }}">Danh sách Homestay</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('booking.html') }}">Đặt phòng</a></li>
                    {{-- <li class="nav-item"><a class="nav-link" href="gallery.html">Gallery</a></li> --}}
                    {{-- <li class="nav-item submenu dropdown"> --}}
                    {{-- <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blog</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                            <li class="nav-item"><a class="nav-link" href="blog-single.html">Blog Details</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="elements.html">Elemests</a></li> --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact.html') }}">Liên hệ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('showFormlogin.html') }}">Đăng nhập</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<body>
    @yield('user_content')
    <!--================ start footer Area  =================-->
    <footer class="footer-area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-3  col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h6 class="footer_title">Nhóm 6-TMĐL</h6>
                        <p>Viết mô tả ở đây (nếu ngựa) </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h6 class="footer_title">Navigation Links</h6>
                        <div class="row">
                            <div class="col-4">
                                <ul class="list_style">
                                    <li><a href="#">Home</a></li>
                                    <li><a href="#">Feature</a></li>
                                    <li><a href="#">Services</a></li>
                                    <li><a href="#">Portfolio</a></li>
                                </ul>
                            </div>
                            <div class="col-4">
                                <ul class="list_style">
                                    <li><a href="#">Team</a></li>
                                    <li><a href="#">Pricing</a></li>
                                    <li><a href="#">Blog</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h6 class="footer_title">Newsletter</h6>
                        <p>For business professionals caught between high OEM price and mediocre print and graphic output, </p>
                        <div id="mc_embed_signup">
                            <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe_form relative">
                                <div class="input-group d-flex flex-row">
                                    <input name="EMAIL" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address '" required="" type="email">
                                    <button class="btn sub-btn"><span class="lnr lnr-location"></span></button>
                                </div>
                                <div class="mt-10 info"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget instafeed">
                        <h6 class="footer_title">InstaFeed</h6>
                        <ul class="list_style instafeed d-flex flex-wrap">
                            <li><img src="{{ asset('user/image/instagram/Image-01.jpg') }}" alt=""></li>
                            <li><img src="{{ asset('user/image/instagram/Image-02.jpg')}}" alt=""></li>
                            <li><img src="{{ asset('user/image/instagram/Image-03.jpg')}}" alt=""></li>
                            <li><img src="{{ asset('user/image/instagram/Image-04.jpg')}}" alt=""></li>
                            <li><img src="{{ asset('user/image/instagram/Image-05.jpg')}}" alt=""></li>
                            <li><img src="{{ asset('user/image/instagram/Image-06.jpg')}}" alt=""></li>
                            <li><img src="{{ asset('user/image/instagram/Image-07.jpg')}}" alt=""></li>
                            <li><img src="{{ asset('user/image/instagram/Image-08.jpg')}}" alt=""></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="border_line"></div>
        </div>
    </footer>
    <!--================ End footer Area  =================-->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('user/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('user/js/popper.js') }}"></script>
    <script src="{{ asset('user/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('user/vendors/owl-carousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('user/js/jquery.ajaxchimp.min.js')}}"></script>
    <script src="{{ asset('user/js/mail-script.js')}}"></script>
    <script src="{{ asset('user/vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ asset('user/vendors/nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{ asset('user/js/mail-script.js')}}"></script>
    <script src="{{ asset('user/js/stellar.js')}}"></script>
    <script src="{{ asset('user/vendors/lightbox/simpleLightbox.min.js')}}"></script>
    <script src="{{ asset('user/js/custom.js')}}"></script>
</body>

</html>