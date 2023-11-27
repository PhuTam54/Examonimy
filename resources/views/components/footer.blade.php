<!-- Footer Section Begin -->
<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Quick Link</h4>
                <a class="btn btn-link" href="">About Us</a>
                <a class="btn btn-link" href="">Contact Us</a>
                <a class="btn btn-link" href="">Privacy Policy</a>
                <a class="btn btn-link" href="">Terms & Condition</a>
                <a class="btn btn-link" href="">FAQs & Help</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Contact</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>8A Tôn Thất Thuyết, Mỹ Đình, Nam Từ Liêm, Hà Nội</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+84 65630471</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>phutamytb@gmail.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Gallery</h4>
                <div class="row g-2 pt-2">
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{ asset('storage/img/main-img/course-1.jpg') }}" alt="">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{ asset('storage/img/main-img/course-2.jpg') }}" alt="">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{ asset('storage/img/main-img/course-3.jpg') }}" alt="">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{ asset('storage/img/main-img/course-2.jpg') }}" alt="">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{ asset('storage/img/main-img/course-3.jpg') }}" alt="">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid bg-light p-1" src="{{ asset('storage/img/main-img/course-1.jpg') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Newsletter</h4>
                <p>Unlock your potential in the digital arena. Success is just a click away.</p>
                <div class="position-relative mx-auto" style="max-width: 400px;">
                    <form action="#">
                        @csrf
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">Examonimy</a>, All Right Reserved.

                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a><br><br>
                    Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="">Home</a>
                        <a href="">Cookies</a>
                        <a href="">Help</a>
                        <a href="">FQAs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--            <div class="col-lg-4 col-md-12">--}}
{{--                <div class="footer__widget">--}}
{{--                    <h6>Join Our Newsletter Now</h6>--}}
{{--                    <p>Get E-mail updates about our latest shop and special offers.</p>--}}
{{--                    <form action="#">--}}
{{--                        @csrf--}}
{{--                        <input type="text" placeholder="Enter your mail">--}}
{{--                        <button type="submit" class="site-btn">Subscribe</button>--}}
{{--                    </form>--}}
{{--                    <div class="footer__widget__social">--}}
{{--                        <a href="#"><i class="fa fa-facebook"></i></a>--}}
{{--                        <a href="#"><i class="fa fa-instagram"></i></a>--}}
{{--                        <a href="#"><i class="fa fa-twitter"></i></a>--}}
{{--                        <a href="#"><i class="fa fa-pinterest"></i></a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-12">--}}
{{--                <div class="footer__copyright">--}}
{{--                    <div class="footer__copyright__text"><p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->--}}
{{--                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>--}}
{{--                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p></div>--}}
{{--                    <div class="footer__copyright__payment"><img src=" {{ asset('storage/img/payment-item.png') }}" alt=""></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</footer>--}}
<!-- Footer Section End -->
