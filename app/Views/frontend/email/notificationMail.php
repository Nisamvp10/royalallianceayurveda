<div class="container">
    <div class="row">
        <div class="cols-md-12 d-flex align-items-center justify-content-between" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; background-color: #072a4eff;">
            <div class="col-sm-3">
                <img src="<?=base_url(getappdata('applogo'))?>" alt="<?=getappdata('company_name');?>" class="img-fluid" style="width: 100px;">
            </div>
            <div class="col-sm-9">
               <h3 style="color: #fff;"><?= getappdata('company_name');?></h3>
            </div>
        </div>
        <div class="col-md-12">
            <h2 style="color: #fff;"><?=$subject?></h2>
            <p>Dear <strong><?=$user->name?></strong>,</p>
            <p><?=$messages?></p>
            
            <h2 style="color: #072a4eff;">Order Details</h2>
            <p>Order Number: <?=$order['order_number']?></p>
            <p>Order Date: <?=$order['created_at']?></p>
            <p>Order Status:<b> <?=$order['status']?></b></p>
            
            
            <p>Thank you for shopping with us. We look forward to serving you again.</p>
        </div>
    </div>
</div>