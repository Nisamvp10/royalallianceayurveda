<?= view('frontend/inc/header') ?>
  <main class="main-area fix">
         <section class="breadcrumb__area breadcrumb__bg" data-background="<?=base_url('public/assets/template/');?>assets/img/br1.jpg">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-10">
                            <div class="breadcrumb__content">
                                <h2 class="title">Product Tracking</h2>
                                <nav class="breadcrumb">
                                    <span property="itemListElement" typeof="ListItem">
                                        <a href="<?=base_url();?>">Home</a>
                                    </span>
                                    <span class="breadcrumb-separator">|</span>
                                    <span property="itemListElement" typeof="ListItem">Product Tracking</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>


                </section>
           




    
     <section class="contact-section fix section-padding pt-5">
        <div class="container">
            <div class="contact-section-wrapper bg-white">
                <div class="row">
                  
                 <form action="<?= base_url('track-order') ?>" id="trackOrderForm" method="post">
                    <div class="col-md-12 d-flex align-items-center justify-content-center m-auto w-100">
                        <div class="form-group w-50 mb-0">
                            <input type="number" style="border-radius: 10px 0 0 10px" class="form-control" id="trackingNumber" name="trackingNumber" placeholder="Enter Tracking Number">
                        </div>
                         <div class="">
                            <button type="submit" class="btn btn-primary p-2 " style=" height: 50px; border-radius: 0 10px 10px 0px; ">Track Order</button>
                        </div>
                    </div>
                 </form>
                </div>
              </div>
        </div>
      </section>
    


<style>
        .tracking-card {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .tracking-header {
            background: linear-gradient(90deg, #9bb7d4, #d8a9c1);
            padding: 20px;
            position: relative;
        }

        .status-text {
            font-size: 32px;
            font-weight: bold;
            color: #1f4aa8;
        }

        .progress-line {
            height: 4px;
            background: #28a745;
            width: 100%;
            border-radius: 10px;
        }

        .icon-circle {
            width: 40px;
            height: 40px;
            background: #e6f0ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .copy-btn {
            color: red;
            cursor: pointer;
            font-size: 14px;
        }

        .section-footer {
            background: #f5f5f5;
            padding: 15px;
        }
    </style>
</head>


<div class="container py-5">

    <div class="tracking-card">

        <!-- Top Info -->
        <div class="d-flex justify-content-between p-3">
            <div><strong>Order ID :<span id="orderId"></span></strong> </div>
            <div><strong>Order Date :<span id="orderDate"></span></strong> </div>
        </div>

        <!-- Gradient Header -->
        <div class="tracking-header">

            <div class="d-flex justify-content-between">
                <div>
                    <!-- <strong>ats (amazon transportation services)</strong><br> -->
                    Tracking ID: <span id="awb"></span>
                </div>

                <div class="copy-btn" onclick="copyAWB()">
                    📋 Copy AWB Number <span id="awb"></span>
                </div>
            </div>

            <!-- Status -->
            <div class="mt-3 status-text" id="statusText">
               
            </div>

            <!-- Progress -->
            <div class="d-flex align-items-center mt-4">
                <div class="icon-circle me-3">
                    📄
                </div>
                <div class="progress-line"></div>
            </div>

        </div>

        <!-- Footer -->
        <div class="section-footer">
            <strong>Shipment Progress</strong>
        </div>

        <div class="p-3">
            <a href="#" class="text-decoration-none">View Tracking History</a>
        </div>

    </div>

</div>


    <!-- Page Contact Us End -->
<?= view('frontend/inc/footerLink') ?>

    <script>
      let awbNumber = "";
        $('#trackOrderForm').on('submit',function(e) {
            e.preventDefault();
            var trackingNumber = $('#trackingNumber').val();
            $('#orderId').text();
            $('#orderDate').text('');
            $('#awb').text('');
            $('#statusText').text('');
            awbNumber = '';

            $.ajax({
                url: '<?= base_url('track-order') ?>',
                type: 'POST',
                data: {trackingNumber: trackingNumber},
                success: function(response) {
                    console.log(response);

                    if(response.success == true) {
                     response.data.forEach(function(item) {
                        console.log(item);
                        $('#orderId').text(item.order_id);
                        $('#orderDate').text(item.order_date);
                        $('#awb').text(item.awbNumber);
                        $('#statusText').text(item.status);
                        awbNumber = item.awbNumber;
                     });
                    }
                }
            });
        });
      function copyAWB() {
         let text = awbNumber;
         navigator.clipboard.writeText(text);
         alert("AWB Copied!");
      }

    </script>
</body>

</html>