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
           data-bg-src="assets/images/breadcumb/breadcumb-bg.png"
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
                    <a href="<?=base_url('productlist');?>"
                       ><i class="fa-sharp fa-light fa-house"></i
                    ></a>
                 </li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>Products</li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li>Offers</li>
              </ul>
           </div>
        </div>
     </div>

     <!--  -->
<div class="container">
    <div class="row justify-content-center mt-4 pb-5">
        <div class="col-lg-8">
         <?php 
         if(!empty($offers)) {
            foreach($offers as $offer) {
               ?>
                  <div class="coupon-card d-flex align-items-center mb-4">
                  <!-- Left Discount Box -->
                  <div class="discount-box col-md-2">
                     <h2><?=$offer['discount'] ;?><?=($offer['discount_type'] == 1 ? 'RS':'%')?><br>OFF</h2>
                  </div>

                  <!-- Middle Content -->
                  <div class="coupon-content col-md-7">
                     <p class="mb-1 text-muted">
                           <?=$offer['description'] ;?>
                     </p>
                  </div>

                  <!-- Right Button -->
                  <div class="text-center col-md-3">
                     <button class="coupon-btn" onclick="copyCode('<?=$offer['coupencode'] ;?>')">
                           GET CODE
                     </button>
                     <div class="expire-text mt-2">
                           Expires <?= date('m-d-Y',strtotime($offer['validity_to'])) ;?>
                     </div>
                  </div>

            </div>

               <?php
            }
            
         } ?>

       

        </div>
    </div>
</div>

<?= view('frontend/inc/footerLink') ?>
<script>
function copyCode(code) {
   navigator.clipboard.writeText(code);
   toastr.success('Code copied to clipboard');
}
</script>