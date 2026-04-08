<?= view('frontend/inc/headerLink') ?>
   <!-- Breadcumb Section Start -->
      <main class="main-area fix">

        <!-- login-area -->
        <section class="login__area">
            <div class="container-fluid p-0">
                <div class="row gx-0">
                    <div class="col-md-6">
                       <div class="login__left-side"  data-background="<?=base_url('public/assets/template/');?>assets/img/bg/sd_bg.jpg">
                           <a href="<?=base_url();?>"><img src="<?=base_url('public/assets/template/');?>assets/img/logo.png" width="150" alt="logo"></a>
                            <div class="login__left-content">
                                <p>“Ayurveda is a natural system of healing that originated over 3,000 years ago in India”</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="login__form-wrap">
                            <h2 class="title">Create an account</h2>
                            <div class="login__form-social">
                                <!-- <a href="https://github.com/" target="_blank">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.7447 1.42792H16.2748L10.7473 7.74554L17.25 16.3424H12.1584L8.17053 11.1284L3.60746 16.3424H1.07582L6.98808 9.58499L0.75 1.42792H5.97083L9.57555 6.19367L13.7447 1.42792ZM12.8567 14.828H14.2587L5.20905 2.86277H3.7046L12.8567 14.828Z" fill="currentColor"></path>
                                    </svg>
                                </a>
                                <a href="https://www.facebook.com/" target="_blank">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 0C4.02948 0 0 4.02948 0 9C0 13.2206 2.90592 16.7623 6.82596 17.735V11.7504H4.97016V9H6.82596V7.81488C6.82596 4.75164 8.21232 3.3318 11.2198 3.3318C11.79 3.3318 12.7739 3.44376 13.1764 3.55536V6.04836C12.964 6.02604 12.595 6.01488 12.1367 6.01488C10.661 6.01488 10.0908 6.57396 10.0908 8.02728V9H13.0306L12.5255 11.7504H10.0908V17.9341C14.5472 17.3959 18.0004 13.6015 18.0004 9C18 4.02948 13.9705 0 9 0Z" fill="currentColor"></path>
                                    </svg>
                                </a> -->
                            </div>
                            <span class="divider">or</span>
                            <form  id="registerForm" method="POST" class="contact-form-items">
                                    <div class="row g-4">
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".3s">
                                            <div class="form-clt">
                                                <span>Your name*</span>
                                                <input type="text" name="name" id="name" placeholder="Enter your name">
                                                <div class="invalid-feedback" id="nameError"></div>
                                            </div>
                                        </div>
                                           <div class="col-lg-12 wow fadeInUp" data-wow-delay=".3s">
                                            <div class="form-clt">
                                                <span>Phone*</span>
                                                <input type="text" name="phone" id="phone" placeholder="Enter your phone Number name">
                                                <div class="invalid-feedback" id="phoneError"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".5s">
                                            <div class="form-clt">
                                                <span>Email address*</span>
                                                <input type="text" name="email" id="email" placeholder="Enter your email">
                                                <div class="invalid-feedback" id="emailError"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".7s">
                                            <div class="form-clt">
                                                <span>Password*</span>
                                                <input type="password" name="password" id="password" placeholder="********">
                                                <div class="invalid-feedback" id="passwordError"></div>
                                            </div>
                                        </div>
                                        <div class="account__check">
                                    <div class="account__check-remember">
                                        <input type="checkbox" class="form-check-input" name="reviewcheck"  id="reviewcheck">
                                        <label for="reviewcheck" class="form-check-label">I read and accept the <a href="<?=base_url('privacy-policy');?>">terms of use</a></label>
                                        <div class="invalid-feedback" id="reviewcheckError"></div>
                                    </div>
                                </div>
                                <button type="submit" class="tg-btn tg-btn-three black-btn">Create my account</button>

                                        <!-- <div class="col-lg-12 wow fadeInUp" data-wow-delay=".9s">
                                            <button type="submit" class="theme-btn style6">
                                                Sign Up
                                            </button>
                                        </div> -->
                                    </div>
                                </form>
                            <div class="account__switch">
                                <p>Remember your password?<a href="<?=base_url('login');?>">Sign in</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- login-area-end -->


    </main>




<?= view('frontend/inc/footerLink') ?>
<script src="<?=base_url('public/assets/template/');?>assets/js/auth.js"></script>
