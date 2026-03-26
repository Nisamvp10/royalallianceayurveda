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
            <h2 style="color: #fff;">Order Placed</h2>
            <p>Dear <strong><?=$user->name?></strong>,</p>
            <p>Thank you for placing your order with us. We have received your order and are processing it as soon as possible.</p>
            
            <h2 style="color: #072a4eff;">Order Details</h2>
            <p>Dear <strong><?=$user->name?></strong>,</p>
            <p>Thank you for placing your order with us. We have received your order and are processing it as soon as possible.</p>
            <p>Order Details:</p>
            <h3>Order Number: <?=$order['order_number']?></h3>
            <h3>Order Date: <?=$order['created_at']?></h3>
            <h3>Order Status: <?=$order['status']?></h3>
            <p>Order Items:</p>
            <ul>
                <?php foreach ($order_items as $item): ?>
                    <li style="color: #072a4eff; padding: 5px; margin: 5px; border: 1px solid #072a4eff; border-radius: 5px; font-size: 16px; font-weight: bold; "><?=$item['product_title']?> x <?=$item['qty']?></li>
                <?php endforeach; ?>
            </ul>
            <h3>Order Total: <b> <?=money_format_custom($order['total_amount'])?></b></h3>
            <br>
            <p>Shipping Address:</p>
            <p>Name: <?=$shippingAddress->full_name?></p>
            <p>Address: <?=$shippingAddress->address_line1?></p>
            <p>City: <?=$shippingAddress->city?></p>
            <p>State: <?=$shippingAddress->state?></p>
            <p>Zip Code: <?=$shippingAddress->postal_code?></p>
            <p>Country: <?=$shippingAddress->country?></p>
            <p>Phone: <?=$shippingAddress->phone?></p>
            <p>Thank you for shopping with us. We look forward to serving you again.</p>
        </div>
    </div>
</div>