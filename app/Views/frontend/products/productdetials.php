<?= view('frontend/inc/header') ?>

      <!-- Search Area Start -->
      <div class="search-wrap">
         <div class="search-inner">
            <i class="fas fa-times search-close" id="search-close"></i>
            <div class="search-cell">
               <form method="get">
                  <div class="search-field-holder">
                     <input
                        type="search"
                        class="main-search-input"
                        placeholder="Search..."
                     />
                  </div>
               </form>
            </div>
         </div>
      </div>

      <div class="breadcumb-section">
        <div
           class="breadcumb-container-wrapper"
           data-bg-src="<?=base_url('public/assets/template/');?>assets/images/breadcumb/breadcumb-bg.png"
        >
           <div class="shape1">
              <img
                 src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_1.png"
                 alt="shape"
              />
           </div>
           <div class="shape2">
              <img
                 src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_2.png"
                 alt="shape"
              />
           </div>
           <div class="shape3">
              <img
                 src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_3.png"
                 alt="shape"
              />
           </div>
           <div class="shape4">
              <img
                 src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_4.png"
                 alt="shape"
              />
           </div>
           <div class="container">
              <ul class="breadcumb-wrapper">
                 <li>
                    <a href="index.html"
                       ><i class="fa-sharp fa-light fa-house"></i
                    ></a>
                 </li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>Products</li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>Products Detials</li>
              </ul>
           </div>
        </div>
     </div>

    

     <div class="shop-details-section section-padding fix">
        <div class="shop-details bg-white">
           <div class="container">
            <?php
            if(!empty($product)) {
                foreach($product as $item) {
                    $price = calculatePrice(
                        $item['price'],
                        $item['compare_price'],
                        $item['price_offer_type']
                    );
                ?>

              <div class="row gx-60">
                 <div class="col-lg-6">
                    <div class="product-big-img bg-color2">
                       <img
                          src="<?= validImg($item['product_image']) ?>"
                          alt="thumb"
                       />
                    </div>
                 </div>
                 <div class="col-lg-6">
                    <div class="product-about">
                       <div class="rating">
                          <ul class="star">
                             <li><i class="fa-solid fa-star"></i></li>
                             <li><i class="fa-solid fa-star"></i></li>
                             <li><i class="fa-solid fa-star"></i></li>
                             <li><i class="fa-solid fa-star"></i></li>
                             <li><i class="fa-solid fa-star"></i></li>
                          </ul>
                          <!-- <h6>(2 customer reviews)</h6> -->
                       </div>
                       <h6 class="product-price">
                        <?= money_format_custom($price['offer_price']); ?>
                        </h6>
                       <h2 class="product-title"><?= $item['product_title']; ?></h2>
                       <p class="text">
                         <?= $item['short_description']; ?>
                       </p>
                    
                       <div class="actions">
                          <div class="quantity">
                             <p>Quantity</p>
                             <div class="qty-wrapper">
                                <input
                                   type="number"
                                   id="quantity"
                                   class="qty-input"
                                   step="1"
                                   min="1"
                                   max=" <?= $item['stock']; ?>"
                                   name="quantity"
                                   value="1"
                                   title="Qty"
                                />
                                <div class="btn-wrapper">
                                   <button
                                      class="quantity-plus qty-btn"
                                      type="button"
                                   >
                                      <i class="fa-solid fa-plus"></i>
                                   </button>
                                   <button
                                      class="quantity-minus qty-btn"
                                      type="button"
                                   >
                                      <i class="fa-solid fa-minus"></i>
                                   </button>
                                </div>
                             </div>
                          </div>
                       </div>

                       <div class="product-details-footer">
                         <a href="javascript:void(0)" class="theme-btn add-to-cart"   data-id="<?= $item['id'] ?>">   Add to Cart   <i class="fa-regular fa-cart-shopping bg-transparent text-white"></i></a>
                          <a
                             class="theme-btn style7 border-0"
                             href="#"
                             >ADD TO WISHLIST<i
                                class="fa-sharp fa-solid fa-heart"
                             ></i
                          ></a>

                          <div class="share">
                             <ul class="social-media">
                                <li>
                                   <a href="https://www.facebook.com">
                                      <i class="fa-brands fa-facebook-f"></i>
                                   </a>
                                </li>
                                <li>
                                   <a href="https://www.youtube.com">
                                      <i class="fa-brands fa-youtube"></i>
                                   </a>
                                </li>
                                <li>
                                   <a href="https://www.x.com">
                                      <i class="fa-brands fa-twitter"></i>
                                   </a>
                                </li>
                                <li>
                                   <a href="https://www.instagram.com">
                                      <i class="fa-brands fa-instagram"></i>
                                   </a>
                                </li>
                             </ul>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="row">
                 <div class="col-12">
                    <div class="product-description">
                       <h3>product Description</h3>
                       <div class="desc">
                          <?= $item['description']; ?>
                       </div>
                    </div>
                  
                 </div>
              </div>
           </div>
            <?php
                }
            }?>


        </div>
     </div>

<?= view('frontend/inc/footerLink') ?>
