<?= view('frontend/inc/headerLink') ?>
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
                            <h2 class="title">Forgot Password</h2>
                            <div class="login__form-social">
                              

                            </div>
                            <span class="divider">Enter your email address to reset your password</span>
                            <form id="forgotPasswordForm" method="POST" class="contact-form-items">
                                    <div class="row g-4"> 
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".5s">
                                            <div class="form-clt">
                                                <span>Email address*</span>
                                                <input type="text" name="username" id="username" placeholder="Enter your email">
                                                <div class="invalid-feedback" id="usernameError"></div>
                                            </div>
                                        </div>                                       
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".9s">
                                            <button type="submit" id="forgotPasswordBtn" class="theme-btn style6 tg-btn tg-btn-three black-btn">
                                                Send Reset Code
                                            </button>
                                        </div>
                                    </div>
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
