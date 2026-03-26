<style>
    .spacer{
        height: 40px;
    }
    .row{
        display: flex;
        flex-wrap: wrap;
    }
    .p-3 {
        padding: 1rem !important;
    }    
    .col-sm-8 {
        flex: 0 0 auto;
        width: 66.66666667%;
    }   
    .col-md-4 {
        flex: 0 0 auto;
        width: 33.33333333%;
    }
    .w-100{
        width:100%;
    }
    table{
        width: 100%;
         border-collapse: collapse;
    }
    thead td {
        background: #ddd;
    }
    .head{
        width:60%;
        float:left;
        border:1px red solid;
    }
    .head table td{
        font-size:13px;
        text-align:right;
    }
    .logo{
        float:left
    }
    logo img{
        float:left
    }
    .orderDetailTbl 
    {
        width:100%;
    }
    .orderDetailTbl td{
            padding:10px 0;
    }
    table.orderDetailTbl {
        width: 100%;
        border-collapse: collapse;
    }
    table.orderDetailTbl th, table.orderDetailTbl td {
        border: 1px solid black;
        padding: 3px;
        text-align: left;
    }
    table.orderDetailTbl td.custom-padding {
        padding-left: 20px;
        padding-right: 20px;
    }
    table.orderDetailTbl th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    table.orderDtl td{
        font-size:12px
    }
</style>
<?php
if(!empty($result)) {
    foreach($result as $res) {
        $orderId = $res['inoicenumber'];
        $paymentStatus = $res['payment'];
        $deliveryStatus = $res['orderStatus'];
        $paymentStatus = $res['paymentMethod'];
        $orderDate = $res['orderDate'];
        $grandTotal = $res['totalAmount'];
        $shippingAddress = json_decode($res['shippingAddress'], true);
        $orderDate = date('Y-m-d H:i:s',strtotime($orderDate));
        $discount = $res['discount'];
    }
}else{
    $orderId = '';
    $paymentStatus = '';
    $deliveryStatus = '';
    $paymentStatus = '';
    $orderDate = '';
    $grandTotal = '';
    $shippingAddress = '';
    $orderDate = '';
    $discount = '';
}?>
    <div class="head row d-flex" style=" display:block; border:1px red solid; text-align: center; font-weight: bold;font-size:18px;width:100%;">
        <div class="logo col-sm-8" style="width:340px;text-align:left;padding:0px;margin:0px;" >
            <img src="<?=base_url(getappdata('applogo'))?>" style="text-align:left;padding:0;margin:0" width="100px"/>
            <div class="hd-title w-100" style="font-size:13px;padding:0;margin:0" > <?=getappdata('company_name')?>  </div>
            <p style="font-size:13px;padding:0;margin:0;font-weight:100" ><?=getappdata('address')?></p>
        </div>
               
        <div class="col-sm-4" style="width: 50%; flot:right; text-align: right; margin-top: 20px;font-size:12px">
                <h3 style="font-size:18px;font-weight:500;font-familly">INVOICE</h3>
                <table class="ml-auto " style="padding-left:10px;width:100%;float:right">
                            <tbody class="orderDtl">
                                <tr>
                                    <td class="text-main text-bold">Order # : </td>
                                    <td class="text-info text-bold text-right"> <?=$orderId?></td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">Order status : </td>
                                    <td class="text-right">
                                    <?= ucwords($deliveryStatus)?>
                                       </td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">Order date : </td>
                                    <td class="text-right"> <?= $orderDate ?></td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">
                                        Total amount :
                                    </td>
                                    <td class="text-right">
                                        <?= money_format_custom($grandTotal) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">Payment method : </td>
                                    <td class="text-right"> <?= ucwords($paymentStatus) ?></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
    </div>
               
                <hr>
    <div class="row p-3" style="">
        <div class="col-sm-12" > 
            <p>Bill to</p>
            <ul class="orderDtl" style=" list-style: none; padding-left:  0;">
                <?php   
                    if(!empty($result))
                    {   
                        foreach($result as $row)
                        {
                            $shippingAddress = json_decode($row['shippingAddress'], true);
                        ?>
                        <li><b><?=$shippingAddress['name'] ?? 'N/A'?></b></li>
                        <li><?=$shippingAddress['address'] ?? 'N/A'?>
                        <?=$shippingAddress['city'] .',' ?? 'N/A'?>
                        <?=$shippingAddress['state'] .',' ?? 'N/A'?>
                        <?=$shippingAddress['post'] .',' ?? 'N/A'?>
                        <?=$shippingAddress['country'] ?? 'N/A'?> </li>
                        <li><?=$shippingAddress['phone'] ?? 'N/A'?></li>
                        <?php
                        }
                    }
                ?>
            </ul>
        </div>
        <div class="col-md-4">
                        
        </div>
    </div>

    <div class="row mt-4 pt-10 pb-10 border" >
            <div class="pt-30 pb-10 pl-30 pr-30 w-100">
                <h6 class="pb-3 border-bottom w-100 pt-3" style="font-size:15px;font-weight:500;font-familly">Order Details</h6>
                <table class="w-100 mt-4 table orderDetailTbl" style="width:100%">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td>Product</td>
                        <td>Quantity</td>
                        <!-- <td>Discount</td> -->
                        <td style="text-align:right;">Price</td>
                    </tr>
                    </thead>
                    <tbody>
                        
                        <?php 
                        if(!empty($result))
                        {
                            $i=1;
                            $totalAmount = 0;
                            $totalTax    = 0;
                            $totalDiscount = 0;
                            foreach($result as $orders){
                                foreach($orders['items'] as $detail){                            
                              ?>
                              <tr class="mt-4">
                                <td><?=$i?></td>
                                <td><?=$detail['product']?></td>
                                <td><?=$detail['quantity']?></td>
                                <!-- <td><?=money_format_custom( $detail['price'] * $detail['quantity'])?></td> -->
                                <td style="text-align:right;"><?=money_format_custom($detail['price'])?></td>
                            </tr>
                            <?php
                            
                           
                            $i++;
                            $totalAmount += $detail['price'] * $detail['quantity'];
                            $totalTax    = ( $orders['tax']);
                           // $totalDiscountAmount = ($detail['discount'] / 100 *  $detail['price'] * $detail['quantity']);
                            //$totalDiscount += $totalDiscountAmount;
                                } ?>
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                <th id="total" style="text-align:right;" colspan="2">Sub Total :</th>
                                <td colspan="2" style="text-align:right;">RS:  <?=money_format_custom($totalAmount)?></td>
                                </tr>
                                <tr>
                                <th id="total" style="text-align:right;" colspan="2">Tax :</th>
                                <td colspan="2" style="text-align:right;">RS:  <?=money_format_custom($totalTax)?></td>
                                </tr>
                                <?php
                                if($discount > 0){ ?>
                                <tr>
                                <th id="total" style="text-align:right;" colspan="2">Discount :</th>
                                <td colspan="2" style="text-align:right;">RS:  <?=money_format_custom($discount)?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                <th id="total" style="text-align:right;" colspan="2">Total :</th>
                                <td colspan="2" style="text-align:right;"><b>RS:  <?=money_format_custom($orders['totalAmount'])?></b></td>
                                </tr>
                            </tfoot>
                            <?php
                            }
                            
                        } ?>
                        </tr>
                </table>
            </div>
        </div>