<?php
    $couponDiscount = 0;

    if(isset($cartdata) && $cartdata != null) {
        $couponDiscount = ($cartdata['coupon_discount'] ==0)?0:$cartdata['coupon_discount'] ?? 0;
    }
    $amountAmt = 0;
    $taxAmt = getappdata('tax');
    if($subtotal)   {
        foreach($subtotal as $res) {
            $amountAmt += $res['subtotal'];  
        }
    }   
    
 
    $subtotalAmt = ($amountAmt - $couponDiscount);
    $taxCalculate = round($subtotalAmt * ($taxAmt / 100));
    $totalAmt = $amountAmt + $taxCalculate - $couponDiscount;
    ?>

<div class="cart-checkout-wrapper w-100 mb-0 border w-100 mt-0" style="w-100">
            <div class="coupon_code right" data-aos="fade-up" data-aos-delay="400">
                <h3 class="p-10 bg-off-white py-3 px-2">Order Summary  (<?= count($subtotal) ?>)</h3>
                <div class="coupon_inner p-2 cart__collaterals-wrap m-0">
                     <div class="coupon-left mt-2">
                            <div class="coupon-input d-flex align-items-center mt-3 mb-3">
                                <input class="couponcodeInput" placeholder="Coupon code" class="h-auto " type="text">
                                <button type="button" class="theme-btn style6 applyCoupon rounded-0 h-auto px-3 py-2">Apply</button>
                            </div>
                        </div>

                <div class="w-100">
                    <?php
                    if(!empty($subtotal)) {
                        foreach($subtotal as $res) {
                            ?>
                            <div class="d-flex align-items-center justify-content-between">
                                <p><?= $res['product_title'] ?> x <?= $res['quantity'] ?></p>
                                <p><?= money_format_custom(($res['price'] * $res['quantity'])) ?></p>
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
                <ul class="list-wrap">
                    <li>Subtotal <span><?= money_format_custom($amountAmt) ?></span></li>
                    <li>Tax <span><?= money_format_custom($taxCalculate) ?></span></li>
                     <?php if($couponDiscount > 0) { ?>
                    <li>Coupon Discount <span><?= money_format_custom($couponDiscount) ?></span></li>
                     <?php } ?>
                    <li>Total <span class="amount"><?= money_format_custom($totalAmt) ?></span></li>
                </ul>

                    <div class="checkout-btn cart__collaterals">
                        <a href="javascript:void(0)" class="theme-btn style6 checkoutBtn tg-btn tg-btn-three black-btn">Place Order <?=money_format_custom($totalAmt)?></a>
                    </div>
                </div>
            </div>
        </div>