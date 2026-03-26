<?= view('frontend/inc/header') ?>

      
    <!-- main-area -->
    <main class="main-area fix">

             <section class="breadcrumb__area breadcrumb__bg" data-background="<?=base_url('public/assets/template/');?>assets/img/br4.jpg">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-10">
                            <div class="breadcrumb__content">
                                <h2 class="title">Shipping & Delivery Policy</h2>
                                <nav class="breadcrumb">
                                    <span property="itemListElement" typeof="ListItem">
                                        <a href="<?=base_url();?>">Home</a>
                                    </span>
                                    <span class="breadcrumb-separator">|</span>
                                    <span property="itemListElement" typeof="ListItem">Shipping & Delivery Policy</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>


                </section>
           
             
                        <section class="faq__area section-py-150">
                <div class="container">
                    <div class="row align-items-center justify-content-center">

                          <div class="col-lg-12">
                            <div class="faq__content">
                              
                               
                               <div class="product-desc-description">
                                     <?= getappdata('shippingInput') ?>

                                    </div> 
                            </div>
                        </div>
                    
                    </div>
                </div>
              
            </section>

    </main>

    <!-- Page Contact Us End -->
<?= view('frontend/inc/footerLink') ?>

    
</body>

</html>