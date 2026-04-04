<?= view('frontend/inc/header') ?>

    <!-- main-area -->
    <main class="main-area fix">

             <section class="breadcrumb__area breadcrumb__bg" data-background="<?=base_url('public/assets/template/');?>assets/img/br.jpg">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-10">
                            <div class="breadcrumb__content">
                                <h2 class="title">Contact Us</h2>
                                <nav class="breadcrumb">
                                    <span property="itemListElement" typeof="ListItem">
                                        <a href="<?=base_url();?>">Home</a>
                                    </span>
                                    <span class="breadcrumb-separator">|</span>
                                    <span property="itemListElement" typeof="ListItem">Contact</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>


                </section>
           
             
            <section class="contact__area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="contact__info-wrap">
                                <div class="contact__info-item">
                                 <h4 class="title">Kerala</h4>
                                    <p><?=getappdata('address')?> <?=getappdata('city')?> <?=getappdata('state')?> <?=getappdata('zip_code')?></p>
                                    <ul class="list-wrap">
                                        <li>
                                            <a href="tel:<?=getappdata('phone')?>"><?=getappdata('phone')?></a>
                                        </li>
                                        <li>
                                            <a href="mailto:<?=getappdata('email')?>"><?=getappdata('email')?></a>
                                        </li>
                                        <!-- <li>
                                            <a href="mailto:sales@royalallianceayurveda.com">sales@royalallianceayurveda.com</a>
                                        </li> -->
                                    </ul>
                                    <div class="shape">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="174" height="210" viewBox="0 0 174 210" fill="none">
                                            <path d="M168.636 86.8182C168.636 150.455 86.8182 205 86.8182 205C86.8182 205 5 150.455 5 86.8182C5 65.1187 13.6201 44.3079 28.964 28.964C44.3079 13.6201 65.1187 5 86.8182 5C108.518 5 129.328 13.6201 144.672 28.964C160.016 44.3079 168.636 65.1187 168.636 86.8182Z" stroke="currentColor" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M86.8182 114.091C101.88 114.091 114.091 101.88 114.091 86.8182C114.091 71.7559 101.88 59.5455 86.8182 59.5455C71.7559 59.5455 59.5455 71.7559 59.5455 86.8182C59.5455 101.88 71.7559 114.091 86.8182 114.091Z" stroke="currentColor" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                                
                                
                                
                              
                                
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="contact__form-wrap">
                                <h2 class="title">Leave Us A Message</h2>
                                <form id="contact-form" action="#" class="contact__form" method="POST">
                                    <div class="form-grp">
                                        <label for="name">Name *</label>
                                        <input id="name" name="name" type="text">
                                    </div>
                                    <div class="form-grp">
                                        <label for="email">Email *</label>
                                        <input id="email" name="email" type="email">
                                    </div>
                                    <div class="form-grp">
                                        <label for="website">Website *</label>
                                        <input id="website" name="website" type="url">
                                    </div>
                                    <div class="form-grp">
                                        <label for="comment">Comment *</label>
                                        <textarea name="message" id="comment"></textarea>
                                    </div>
                                    <div class="form-grp checkbox-grp">
                                        <input type="checkbox" id="checkbox">
                                        <label for="checkbox">Save my name, email, and website in this browser for the next time I comment.</label>
                                    </div>
                                    <button type="submit" class="tg-btn tg-btn-three black-btn">Submit Message</button>
                                </form>
                                <p class="ajax-response mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

    <!-- Page Contact Us End -->
<?= view('frontend/inc/footerLink') ?>

    
</body>

</html>