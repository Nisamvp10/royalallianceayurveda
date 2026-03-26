  <?php
    if ($result) {
        $qty = 1;
        $total = 0;
        ?>
        <form method="post" id="cartForm">
    <div class="table_desc">
        <div class="table_page table-responsive cart__table">
            <table class="table table-bordered w-100">
              
                <tbody>
                    <!-- Start Cart Single Item-->

                  <?php
                        foreach ($result as $row) {
                    ?>

                        <tr>
                            <td class="product__thumb-cart">
                                <a href="shop-details.html"><img src="<?= validImg($row['image']) ?>" alt=""></a>
                                <input type="hidden" value="<?= encryptor($row['id']) ?>"  name="item_id[]" />
                            </td>
                            <td class="product__name">
                                <a href="shop-details.html"><?= $row['product_title'] ?></a>
                            </td>
                            <td class="product__price"><?= money_format_custom($row['price']) ?></td>
                           <td class="product_quantity">
                                    <div class="plus-minus-input quickview-cart-plus-minus">
                                        <div class="input-group-button">
                                            <button type="button" class="button dec qtybutton" onclick="minusCartQty(this)" data-quantity="minus" 
                                                data-field="itemQty<?= $qty ?>">-</button>
                                        </div>
                                        <input class="form-control" type="number" id="itemQty<?= $qty ?>" name="quantity[]" value="<?= $row['quantity'] ?>">
                                        <div class="input-group-button">
                                            <button type="button" class="button inc qtybutton" onclick="plusCartQty(this)" data-quantity="plus"
                                                data-field="itemQty<?= $qty ?>">+</button>
                                        </div>
                                    </div>
                                </td>
                            <td class="product__subtotal"><?= money_format_custom($row['price'] * $row['quantity']) ?></td>
                                    <td class="product__remove">
                                        <a href="#">×</a>
                                    </td>
                                </tr>


                    
                           
                    <?php $qty++;
                        }
                     ?>
                    <!-- End Cart Single Item-->
                    <!-- Start Cart Single Item-->

                </tbody>
            </table>
        </div>
    </div>
    <div class="coupon-inner">
     
        <div class="coupon-right">
            <div class="cart_submit">
                <button class="theme-btn style6" type="submit">update cart</button>
            </div>
        </div>
    </div>

</form>
<?php
} else {
    echo "<p>No items in cart</p>";
}
?>