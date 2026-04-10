<?= view('frontend/inc/header') ?>





         <main class="main-area fix">
            <!-- banner-area -->


            
             <section class="banner__area banner__bg pb-2" data-background="<?=base_url('public/assets/template/');?>assets/img/hero_bg.jpg">
               
            </section>

            <section id="product" class="product__details-area section-pt-100 section-pb-100 section-bg">
    <div class="container">

    <?php if(!empty($premiumProducts)) {
        foreach($premiumProducts as $product) {

            $variantImages = $product['variantImages'];
            $firstImage = $product['product_image'];
            $variantImagesGallery = [];

            if (!empty($firstImage)) {
                $variantImagesGallery[] = [
                    'image' => $firstImage
                ];
            }
            if (!empty($variantImages)) {
                foreach ($variantImages as $variantImage) {
                    // avoid duplicate
                    if ($variantImage['image'] == $firstImage) continue;
                    $variantImagesGallery[] = [
                        'image' => $variantImage['image']
                    ];
                        }
                    }

            

            if(!empty($variantImages)) {
                $firstImage = $variantImages[0]['image'];
            }
    ?>

    <div class="row align-items-center justify-content-center ">

        <!-- LEFT SIDE (IMAGES) -->
        <div class="col-lg-6 col-md-9">
            <div class="product__details-wrap">

                <!-- MAIN IMAGE -->
                <div class="product__details-img text-center">
                    <img id="mainImage_<?= $product['id'] ?>"
                         src="<?= validImg($firstImage); ?>"
                         style="max-width:100%;  object-fit:contain;">
                </div>

                <!-- THUMBNAILS -->
                <div class="product__thumbs mt-3 d-flex gap-2 flex-wrap justify-content-center">

                    <!-- Main image thumb -->
                    <img 
                        src="<?= validImg($product['product_image']); ?>"
                        class="thumb-img active-thumb"
                        data-target="mainImage_<?= $product['id'] ?>"
                        style="width:70px;height:70px;object-fit:cover;cursor:pointer;border:1px solid #ddd;padding:3px;"
                    >

                    <!-- Variant images -->
                    <?php if(!empty($variantImages)) {
                        foreach($variantImages as $img) {

                            // avoid duplicate image
                            if($img['image'] == $product['product_image']) continue;
                    ?>

                    <img 
                        src="<?= validImg($img['image']); ?>"
                        class="thumb-img"
                        data-target="mainImage_<?= $product['id'] ?>"
                        style="width:70px;height:70px;object-fit:cover;cursor:pointer;border:1px solid #ddd;padding:3px;"
                    >

                    <?php } } ?>

                </div>

            </div>
        </div>

        <!-- RIGHT SIDE (CONTENT) -->
        <div class="col-lg-6">
            <div class="product__details-content">

                <!-- <span class="sub-title">Proteins, shots</span> -->

                <h4 class="title">
                    <?= $product['product_title'] ?? '' ?>
                </h4>

                <?php
                $price = calculatePrice(
                    $product['price'],
                    $product['compare_price'],
                    $product['price_offer_type']
                );

                $offerPrice  = $price['offer_price'];
                $actualPrice = $price['actual_price'];
                ?>

                <h2 class="product__details-price">
                    <del><?= money_format_custom($actualPrice) ?></del>
                    <?= money_format_custom($offerPrice) ?>
                </h2>

                <p><?= $product['short_description'] ?? '' ?></p>

                <div class="product__details-list">
                    <?= $product['description'] ?? '' ?>
                </div>

                <div class="product__details-info">
                      <div class="sd-cart-wrap">
                        <form action="#">
                            <div class="quickview-cart-plus-minus">
                                <input type="text" id="quantity" value="1">
                            </div>
                        </form>
                    </div>

                    <a href="javascript:void(0)" 
                       class="cart-btn add-to-cart" 
                       data-id="<?= $product['id'] ?>">
                       Add to cart
                    </a>
                </div>

            </div>
        </div>

    </div>

    <?php } } ?>

    </div>
</section>


            <!-- banner-area-end -->
            <!-- about-area -->
            
                        <section id="ingredient" class="about__area-three p-relative section-pt-100 section-pb-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-8">
                            <div class="section__title mb-60" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                                <span class="sub-title">TRUSTED SINCE 1980</span>
                                <h2 class="title">Helps to Improve Male Sexual Wellness </h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-10">
                            <div class="about__img-three p-relative">
                                <div class="main__img p-relative">
                                    <img src="<?=base_url('public/assets/template/');?>assets/img/pa.png" alt="img">
                                    <div class="marquee__wrap marquee__wrap-two">
                                        <div class="slider__marquee clearfix marquee-wrap">
                                            <div class="marquee_mode marquee__group">
                                                <h6 class="marquee__item">Raise Blood Circulation </h6>
                                                <h6 class="marquee__item">Restore Shukra Dhatu (Vitality) </h6>
                                                <h6 class="marquee__item">Reduce stress-related anxiety</h6>
                                                <h6 class="marquee__item">Improve male health and wellness</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about__content-three">
                                <p>
                                    Cheetah Sithaswagandhadi Thailam is a premium, ayurvedic quality formulation developed by Shankara’s Pharma, Malappuram, and Kerala. Enriched with N 100% ayurvedic herbs like olive oil, gingelly oil, madhu, shigru,pippalli, ashwagandha, Cheetah ensure quality and effectiveness to our customers. This oil is designed to improve blood circulation, restore Shukra Dhatu (Vitality), reduce stress-related anxiety and improve male health and wellness.
                                </p>

                                <p>It contains all natural herbs that may functioned as a permanent solution for urinary incontinence, overactive bladder (OAB), sexual numbness, erectile dysfunction (ED), lack of firmness and thickness, premature ejaculation, nightfall / wet dreams, phimosis,  nerve issues, low sperm count.</p>


                                <p>
                                    Disclaimer: Cheetah oil never claims sudden changes. This is a medicine for solve the patient’s problems forever. Results typically begin to appear only after 10–12 days of continuous use. A patient may need to use at least 4 bottles of Cheetah Oil for the condition to improve.
                                </p>

                                <ul class="list-wrap about__list">
                                <li>✅ Scientifically Tested Ingredients</li>
                                <li>🌿 100% Ayurvedic & Herbal 	</li>
                                <li>🛡️ No Synthetic Side Effects </li>
                                <li>❤️ Developed by Certified Doctors</li>
                              
                            </ul>
                             
                            </div>
                        </div>
                    </div>
                </div>
              
            </section>



                



                        <section id="features" class="features__area section-bg-four section-pt-100 section-pb-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="section__title text-center white-title mb-60 sal-animate" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                                <span class="sub-title">TRUSTED SINCE 1980</span>
                                <h2 class="title">HERBS that used to Manufacture</h2>
                            </div>
                        </div>
                    </div>



<div class="row justify-content-center">
                        <div class="col-lg-4 col-md-8 order-0 order-lg-2">
                            <div class="ingredients-img-two tg-supplement-img ">
                                <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/p.png" alt="img">
                                  <div class="tg-supplement-shape">
                                    <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/supplement_shape02.png" alt="" class="rotateme">
                                </div>
                            </div>
                          
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="ingredients-item-wrap reverse-item">
                                <div class="ingredients-item-two">
                                    <div class="ingredients-icon">
                                      <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/olive-oil.png" alt="Logo">
                                    </div>
                                    <div class="ingredients-content-two">
                                        <h3 class="title">Olive Oil</h3>
                                        <p>Reduce blood pressure and improve lining of blood vessels</p>
                                    </div>
                                </div>
                                <div class="ingredients-item-two">
                                    <div class="ingredients-icon">
                                       <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/oil.png" alt="Logo">
                                    </div>
                                    <div class="ingredients-content-two">
                                        <h3 class="title">Gingelly Oil</h3>
                                        <p>High in zinc, copper and calcium. Boost hormones and enzymes. </p>
                                    </div>
                                </div>
                                <div class="ingredients-item-two">
                                    <div class="ingredients-icon">
                                 <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/honey.png" alt="Logo">
                                    </div>
                                    <div class="ingredients-content-two">
                                        <h3 class="title">Madhu</h3>
                                        <p>Rich in nitrates. Elevate stamina and energy.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 order-3">
                            <div class="ingredients-item-wrap">
                                <div class="ingredients-item-two">
                                    <div class="ingredients-icon">
                                      <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/ayurveda.png" alt="Logo">
                                    </div>
                                    <div class="ingredients-content-two">
                                        <h3 class="title">Shigru</h3>
                                        <p>Increase sperm count and motility. Allowing testosterone to function properly.</p>
                                    </div>
                                </div>
                                <div class="ingredients-item-two">
                                    <div class="ingredients-icon">
                                        <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/ashwagandha.png" alt="Logo">
                                    </div>
                                    <div class="ingredients-content-two">
                                        <h3 class="title">Ashwagandha</h3>
                                        <p>Encourages the production of Nitric Oxide that helps dilate the blood vessels in genital area. </p>
                                    </div>
                                </div>
                                <div class="ingredients-item-two">
                                    <div class="ingredients-icon">
                                  <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/black-pepper.png" alt="Logo">
                                    </div>
                                    <div class="ingredients-content-two">
                                        <h3 class="title">Pippalli</h3>
                                        <p>Increase stimulation and nutrients absorption. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                  
                </div>
                <div class="features__shape-three">
                    <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/h3_features_shape.svg" alt="shape" data-sal="slide-right" data-sal-duration="700" data-sal-delay="100" class="sal-animate">
                </div>
            </section>

                        <section id="ingredient" class="about__area-two section-pt-100 section-pb-100">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-6 col-md-10">
                            <div class="about__img-two" data-sal="slide-right" data-sal-duration="700" data-sal-delay="100">
                                <img src="<?=base_url('public/assets/template/');?>assets/img/paq.png" alt="img">
                                
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about__content-two">
                                <div class="section__title mb-30">
                                    <h2>For External Application</h2>
                                </div>
                               
                                

<ul class="list-wrap about__list about__list-three">
                            <li>
                                <div class="icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20Z" fill="currentColor"></path>
                                        <path d="M14.5451 7.27344L8.9201 13.0488L6.36328 10.4237" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>

                              Shake well before use.



                            </li>
                            <li>
                                <div class="icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20Z" fill="currentColor"></path>
                                        <path d="M14.5451 7.27344L8.9201 13.0488L6.36328 10.4237" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                              Apply 15 drops to the required area.
                            </li>
                            <li>
                                <div class="icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20Z" fill="currentColor"></path>
                                        <path d="M14.5451 7.27344L8.9201 13.0488L6.36328 10.4237" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                          Massage gently until well absorbed.
                            </li>
                            <li>
                                <div class="icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20Z" fill="currentColor"></path>
                                        <path d="M14.5451 7.27344L8.9201 13.0488L6.36328 10.4237" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                           Use twice daily – morning and night.
                            </li>
                         
                        </ul>

                          <div class="section__title mb-30">
                                    <h2>  For Internal Intake</h2>
                                </div>

                                <ul class="list-wrap about__list about__list-three">

                                        <li>
                                <div class="icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20Z" fill="currentColor"></path>
                                        <path d="M14.5451 7.27344L8.9201 13.0488L6.36328 10.4237" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>

                          Shake well before use.



                            </li>
                            <li>
                                <div class="icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20Z" fill="currentColor"></path>
                                        <path d="M14.5451 7.27344L8.9201 13.0488L6.36328 10.4237" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>

                           Take 8 to 10 drops mixed with warm milk or juice.



                            </li>
                            <li>
                                <div class="icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20Z" fill="currentColor"></path>
                                        <path d="M14.5451 7.27344L8.9201 13.0488L6.36328 10.4237" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                              Consume twice daily – morning and night.
                            </li>
                        
                         
                        </ul>




                            </div>
                        </div>
                    </div>
                </div>
              
            </section>




                    <section class="choose__area  section-pb-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                         
                            <div class="choose__img text-center p-relative">
                                <img src="<?=base_url('public/assets/template/');?>assets/img/as.jpeg" alt="img" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                            </div>
                        </div>
                    </div>
                </div>
            </section>



                        <section id="pricing" class="pricing__area section-pt-100 section-pb-100 section-bg">
                <div class="container">
                    <div class="row align-items-end">
                        <div class="col-xl-7 col-lg-6">
                            <div class="section__title mb-60" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                                <span class="sub-title">OUR PRODUCTS</span>
                                <h2 class="title">90-day wellness journey powered by Ayurvedic oils</h2>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6" data-sal="slide-up" data-sal-duration="700" data-sal-delay="150">
                          
                        </div>
                    </div>
                    <div class="row gutter-y-30 justify-content-center">
                        <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                            <div class="pricing__item">
                                <div class="pricing__top">
                                    <span class="pricing__plan">Month 1</span>
                                                                                                       <h2 class="pricing__price"><span>(Energize)</span></h2>

                                    <div class="pricing__content">
                                        <p>It significantly enhances blood circulation throughout the body, ensuring that oxygen and vital nutrients are efficiently delivered to every cell. By optimizing your systemic flow, it effectively flushes out toxins and combats fatigue, providing a sustained surge of natural energy.</p>
                                    </div>
                                    <div class="pricing__btn">
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="200">
                            <div class="pricing__item active">
                                <div class="pricing__top">
                                    <span class="pricing__plan">Month 2</span>
                                    <h2 class="pricing__price"><span>(Revive)</span></h2>

                                    <div class="pricing__content">
                                        <p>This powerful formula works to restore your natural stamina and reignite your inner passion, allowing you to approach every day with renewed Vigor. By replenishing the body's core energy reserves, it helps overcome physical exhaustion and emotional burnout, making you feel more driven and connected.</p>
                                    </div>
                                    <div class="pricing__btn">
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="300">
                            <div class="pricing__item">
                                <div class="pricing__top">
                                    <span class="pricing__plan">Month 3</span>
                                   <h2 class="pricing__price"><span>(Strengthen)</span></h2>
                                    <div class="pricing__content">
                                        <p>It focuses on building long-term vitality by strengthening your body’s natural resilience and sustaining peak performance…</p>
                                    </div>
                                    <div class="pricing__btn">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>


                        <section class="testimonial__area  section-pt-100 section-pb-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="section__title text-center mb-60" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                                <span class="sub-title">clients feedback</span>
                                <h2 class="title">what our client saying</h2>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial__active-three swiper-container fix" id="testimonialSlider" data-swiper-options='{
                    "loop": true,
                    "autoplay": { "delay": 8000 },
                    "breakpoints": {
                        "0": {
                            "spaceBetween": 10,
                            "slidesPerView": 1
                        },
                        "375": {
                            "spaceBetween": 20,
                            "slidesPerView": 1
                        },
                        "575": {
                            "spaceBetween": 20,
                            "slidesPerView": 2
                        },
                        "768": {
                            "spaceBetween": 20,
                            "slidesPerView": 2
                        },
                        "992": {
                            "spaceBetween": 25,
                            "slidesPerView": 3
                        },
                        "1400": {
                            "spaceBetween": 30,
                            "slidesPerView": 3
                        }
                    }}'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="testimonial__item-three">
                                    <div class="testimonial__img-two">
                                        <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/p.png" alt="img">
                                    </div>
                                    <div class="testimonial__content-three">
                                        <div class="rating">
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.2441 6.91016H19.5098L13.6318 11.1807L15.877 18.0898L9.99902 13.8193L4.12109 18.0898L6.36621 11.1807L0.488281 6.91016H7.75391L9.99902 0L12.2441 6.91016ZM9.99902 12.584L10.5869 13.0107L13.9746 15.4717L12.6807 11.4893L12.4561 10.7988L13.0439 10.3711L16.4316 7.91016H11.5176L11.293 7.21875L9.99902 3.23535V12.584Z" fill="currentColor"/>
                                            </svg>
                                        </div>
                                        <h2 class="title">"As someone with a busy lifestyle, this supplement helps me stay balanced without feeling jittery or tired."</h2>
                                        <span>Rahul M N</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonial__item-three">
                                    <div class="testimonial__img-two">
                                        <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/p.png" alt="img">
                                    </div>
                                    <div class="testimonial__content-three">
                                        <div class="rating">
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.2441 6.91016H19.5098L13.6318 11.1807L15.877 18.0898L9.99902 13.8193L4.12109 18.0898L6.36621 11.1807L0.488281 6.91016H7.75391L9.99902 0L12.2441 6.91016ZM9.99902 12.584L10.5869 13.0107L13.9746 15.4717L12.6807 11.4893L12.4561 10.7988L13.0439 10.3711L16.4316 7.91016H11.5176L11.293 7.21875L9.99902 3.23535V12.584Z" fill="currentColor"/>
                                            </svg>
                                        </div>
                                        <h2 class="title">"This supplement truly changed how I feel every day. I wake up energized and ready to go!"</h2>
                                        <span>Justin Kdakath</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonial__item-three">
                                    <div class="testimonial__img-two">
                                        <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/p.png" alt="img">
                                    </div>
                                    <div class="testimonial__content-three">
                                        <div class="rating">
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.2441 6.91016H19.5098L13.6318 11.1807L15.877 18.0898L9.99902 13.8193L4.12109 18.0898L6.36621 11.1807L0.488281 6.91016H7.75391L9.99902 0L12.2441 6.91016ZM9.99902 12.584L10.5869 13.0107L13.9746 15.4717L12.6807 11.4893L12.4561 10.7988L13.0439 10.3711L16.4316 7.91016H11.5176L11.293 7.21875L9.99902 3.23535V12.584Z" fill="currentColor"/>
                                            </svg>
                                        </div>
                                        <h2 class="title">"As someone with a busy lifestyle, this supplement helps me stay balanced without feeling jittery or tired."</h2>
                                        <span>Muhzin K</span>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonial__item-three">
                                    <div class="testimonial__img-two">
                                        <img src="https://royalallianceayurveda.com/demo/public/assets/template/assets/img/p.png" alt="img">
                                    </div>
                                    <div class="testimonial__content-three">
                                        <div class="rating">
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                                            </svg>
                                            <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.2441 6.91016H19.5098L13.6318 11.1807L15.877 18.0898L9.99902 13.8193L4.12109 18.0898L6.36621 11.1807L0.488281 6.91016H7.75391L9.99902 0L12.2441 6.91016ZM9.99902 12.584L10.5869 13.0107L13.9746 15.4717L12.6807 11.4893L12.4561 10.7988L13.0439 10.3711L16.4316 7.91016H11.5176L11.293 7.21875L9.99902 3.23535V12.584Z" fill="currentColor"/>
                                            </svg>
                                        </div>
                                        <h2 class="title">"This supplement truly changed how I feel every day. I wake up energized and ready to go!"</h2>
                                        <span>Dani M Hohan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section class="faq__area-two p-relative section-pb-100 section-pt-100">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="faq__inner-wrap" >
                                <div class="section__title  mb-60">
                                    <span class="sub-title">our Royalalliance answer</span>
                                    <h2 class="title">what people ask?</h2>
                                </div>
                                <div class="faq__item-wrap faq__item-wrap-three">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Can I take multiple supplements together?
                                        </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                 
                                                    <p>Vitamin D3 supplements are commonly recommended for people at risk for vitamin D deficiency. Low vitamin D levels cause depression, fatigue, and muscle weakness. Over time, vitamin D deficiency can lead to weak bones, rickets in children.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Can I take supplements with medications or other dietary products?
                                        </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                  
                                                    <p>Vitamin D3 supplements are commonly recommended for people at risk for vitamin D deficiency. Low vitamin D levels cause depression, fatigue, and muscle weakness. Over time, vitamin D deficiency can lead to weak bones, rickets in children.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Can I take multiple supplements together?
                                        </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                   
                                                    <p>Vitamin D3 supplements are commonly recommended for people at risk for vitamin D deficiency. Low vitamin D levels cause depression, fatigue, and muscle weakness. Over time, vitamin D deficiency can lead to weak bones, rickets in children.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">What is the recommended daily dosage for your supplements?
                                        </button>
                                            </h2>
                                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    
                                                    <p>Vitamin D3 supplements are commonly recommended for people at risk for vitamin D deficiency. Low vitamin D levels cause depression, fatigue, and muscle weakness. Over time, vitamin D deficiency can lead to weak bones, rickets in children.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Why should I take dietary supplements?
                                        </button>
                                            </h2>
                                            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                  
                                                    <p>Vitamin D3 supplements are commonly recommended for people at risk for vitamin D deficiency. Low vitamin D levels cause depression, fatigue, and muscle weakness. Over time, vitamin D deficiency can lead to weak bones, rickets in children.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </section>



            </main>


<?= view('frontend/inc/footerLink') ?>

<script>
    $(document).ready(function() {
        // Smooth scroll to product section
        $('.tg-btn-three').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 1000);
        });
    });


    $(document).on('click', '.thumb-img', function () {

    let imgSrc = $(this).attr('src');
    let target = $(this).data('target');

    // Change main image
    $('#' + target).attr('src', imgSrc);

    // Active border
    $(this).closest('.product__thumbs').find('.thumb-img').removeClass('active-thumb');
    $(this).addClass('active-thumb');
});

</script>
