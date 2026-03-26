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
                                <p>“This software simplifies the website building process, making it a breeze to manage our
                                    online presence.”</p>
                                <h4 class="title">David Handerson</h4>
                                <span>Founder & CEO</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="login__form-wrap">
                            <h2 class="title">OTP Verification</h2>
                            <div class="login__form-social">
                              

                            </div>
                            <span class="divider">Enter your OTP to verify your email address</span>
                           <form id="verifyOtpForm" method="POST" class="contact-form-items">
                                    <div class="row g-4"> 
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".5s">
                                            <div class="form-clt">
                                                <span>OTP*</span>
                                                <input type="text" name="otp" id="otp" placeholder="Enter your OTP">
                                                <div class="invalid-feedback" id="otpError"></div>
                                            </div>
                                        </div>                                       
                                        <div class="col-lg-12 wow fadeInUp" data-wow-delay=".9s">
                                            <button type="submit" id="verifyOtpBtn" class="theme-btn style6 tg-btn tg-btn-three black-btn">
                                                Verify OTP
                                            </button>
                                          
                                        </div>
                                    </div>
                                </form>

                            <div class="account__switch">
                                <!-- <p>Have no account yet?<a href="<?=base_url('register');?>">Sign up</a></p> -->
                                <h5 class="contact-content__logtitle center flex">  Resend OTP  <a id="resendOtpBtn" style="color: #ddaf16ff;" >Click Here</a> | Don't Have an account? <a href="<?=base_url('register') ;?>">Sign Up</a> |</h5>
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
