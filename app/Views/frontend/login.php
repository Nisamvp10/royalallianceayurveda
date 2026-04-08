<?= view('frontend/inc/headerLink') ?>
   <!-- Breadcumb Section Start -->
      
    <!-- main-area -->
    <main class="main-area fix">

        <!-- login-area -->
        <section class="login__area">
            <div class="container-fluid p-0">
                <div class="row gx-0">
                    <div class="col-md-6">
                        <div class="login__left-side"  data-background="<?=base_url('public/assets/template/');?>assets/img/br.jpg">
                           <a href="<?=base_url();?>"><img src="<?=base_url('public/assets/template/');?>assets/img/logo.png" width="150" alt="logo"></a>
                            <div class="login__left-content">
                                <p>“Ayurveda is a natural system of healing that originated over 3,000 years ago in India”</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="login__form-wrap">
                            <h2 class="title">Get Started Now</h2>
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
                            <span class="divider">Enter your Credentials to access your account</span>
                            <form action="#" class="login__form" id="loginForm" method="POST">
                                <div class="form__grp">
                                    <input type="email" placeholder="Your email" name="username" id="username">
                                    <div class="invalid-feedback" id="usernameError"></div>
                                </div>
                                <div class="form__grp">
                                    <input type="password" placeholder="Password" name="pwd" id="pwd">
                                    <div class="invalid-feedback" id="pwdError"></div>
                                </div>
                                <div class="account__check">
                                    <div class="account__check-remember d-none">
                                        <input type="checkbox" class="form-check-input" value="" id="terms-check">
                                    </div>
                                    <div class="account__check-forgot">
                                        <a href="<?=base_url('forgot-password');?>">Forgot Password?</a>
                                    </div>
                                </div>
                                <button type="submit" class="tg-btn tg-btn-three black-btn">Log in</button>
                            </form>
                            <div class="account__switch">
                                <p>Have no account yet?<a href="<?=base_url('register');?>">Sign up</a></p>
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
