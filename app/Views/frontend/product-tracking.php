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
                 <li>Home</li>
                 <li><i class="fa-solid fa-chevron-right"></i></li>
                 <li><?=$page ??'' ?></li>
              </ul>
           </div>
        </div>
     </div>

    
     <section class="contact-section fix section-padding">
        <div class="container">
            <div class="contact-section-wrapper bg-white">
                <div class="row">
                  
                 <form action="<?= base_url('track-order') ?>" id="trackOrderForm" method="post">
                    <div class="col-md-12 d-flex align-items-center justify-content-center m-auto w-100">
                        <div class="form-group w-50 mb-0">
                            <input type="text" style="border-radius: 10px 0 0 10px" class="form-control" id="trackingNumber" name="trackingNumber" placeholder="Enter Tracking Number">
                        </div>
                         <div class="">
                            <button type="submit" class="btn btn-primary p-2 rounded-0">Track Order</button>
                        </div>
                    </div>
                 </form>
                </div>
              </div>
        </div>
      </section>
    



    <!-- Page Contact Us End -->
<?= view('frontend/inc/footerLink') ?>

    <script>
        $('#trackOrderForm').on('submit',function(e) {
            e.preventDefault();
            var trackingNumber = $('#trackingNumber').val();
            $.ajax({
                url: '<?= base_url('track-order') ?>',
                type: 'POST',
                data: {trackingNumber: trackingNumber},
                success: function(response) {
                    console.log(response);
                }
            });
        });
    </script>
</body>

</html>