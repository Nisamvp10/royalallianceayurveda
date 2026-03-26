<?php $this->extend('template/layout/main') ;?>
<?= $this->section('content') ?>
<?php
    if (!empty($result)) {
       foreach($result as $data) {
            $id = $data['orderId'];
            $customer_name = $data['customer_name'];
            $paymentType = $data['payment'];
            $note = $data['note'];
            $saleDate = $data['sale_date'];
            $items = $data['items'] ?? '';
       }
    }else {
        $id=$paymentType=$saleDate=$note=$items=$customer_name='';
    }?>
 <!-- titilebar -->
 <div class="flex items-center justify-between_">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between_ align-items-center mb-0">
            <a href="<?=base_url('admin/inventory');?>" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left text-gray-500">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
                </svg>
            </a> 
            <h1 class="h3 mb-0 text-left"><?= $page ?? '' ?></h1>
            <?php
            if(haspermission('','create_staff')) { ?>
                <div class="hidden">
                    <a href="<?= base_url('staff-upload') ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Bulk Team Data Upload 
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div><!-- closee titilebar -->

<!-- body -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden p-4 w-full">
   <form class="p-6 space-y-6" id="createSale"> 

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <div class="form-group mb-0">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Customer Name *</label>
            <input type="hidden" name="mastersaleId" value="<?=$id;?>" />
            <input type="text" id="customer_name" name="customer_name" value="<?=$customer_name;?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Customer name">
            <div class="invalid-feedback" id="customer_name_error"></div>
          </div>
        </div>
            <div>
                <div class="form-group mb-0">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Invoice Number</label>
                    <input type="text" readonly="" class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-600" value="Auto-generated">
                </div>
            </div>
        </div>
        
        <div>
            <div class="form-group">
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
            <textarea id="notes" rows="3" name="note" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Additional notes..."></textarea>
            </div>
        </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <div class="form-group mb-0">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Sale Date *</label>
            <input type="date" id="sale_date" value="<?=$saleDate;?>" name="sale_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Sale Sate">
            <div class="invalid-feedback" id="sale_date_error"></div>
          </div>
        </div>

        <div>
            <div class="form-group mb-0">
            <label for="baseSku" class="block text-sm font-medium text-gray-700 mb-2">Payment Status *</label>
            <select name="payment_status" id="payment_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" >
                <option value="">Choose Payment Status</option>
                <option <?=($paymentType == 'paid' ? 'selected' :'');?> value="1">Paid</option>
                <option <?=($paymentType == 'credit' ? 'selected' :'');?> value="2">Credit</option>
            </select>
            <div class="invalid-feedback" id="payment_status_error"></div>
          </div>
        </div>
        <div></div>
          <div>
        <div class="flex items-center justify-end  mb-0">
            <button type="button" id="addContactRow" class="mt-3 px-3 py-2 bg-blue-500 text-white !rounded-lg">+ Add Item</button>
        </div>
      </div>
      </div>
        
   

  

      <div id="productWrapper">
        <?php 
        if(!empty($items)) {
            foreach($items as $item) { ?>
        
        <div class="border border-gray-200 rounded-lg py-2 px-2 product-row mt-2">
            <div class="flex items-center justify-between mb-1">
                
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <div class="form-group mb-0">
                        <label class="">Category *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package text-xl text-gray-400">  <path d="M16.5 9.4 7.5 4.21"></path>  <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>  <path d="m3.3 7 8.7 5 8.7-5"></path>  <path d="M12 22V12"></path></svg>
                            </div>
                            <input type="hidden" name="itemsId[]" value="<?=$item['saleId'];?>" />
                       
                            <select id="category" name="category[]"  class="w-full px-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent productList__">
                                 <option value="">Choose Product</option>
                                <?php 
                                    if(!empty($products)) 
                                    {
                                        foreach($products as $product) {
                                        ?>
                                        <option <?=($item['productId'] == $product['id'] ?'selected' :'' );?> value="<?=$product['id'];?>"><?=$product['product_name'];?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                            </select>
                            <div class="invalid-feedback" id="category_error"></div>
                         </div>
                    </div>
                </div>
           
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package text-xl text-gray-400">  <path d="M16.5 9.4 7.5 4.21"></path>  <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>  <path d="m3.3 7 8.7 5 8.7-5"></path>  <path d="M12 22V12"></path></svg>
                </div>
                <input type="number" step="0.01"  name="quantity[]" id="quantity"  value="<?=$item['quantity'];?>" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Item Quantity">
                <div class="invalid-feedback" id="quantity_error"></div>
            </div>
        </div>

                        <!-- Phone -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Unit Price</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg"      width="24" height="24" viewBox="0 0 24 24"      fill="none" stroke="currentColor" stroke-width="2"      stroke-linecap="round" stroke-linejoin="round"      class="lucide lucide-dollar-sign text-xl text-gray-400">  <line x1="12" y1="1" x2="12" y2="23"></line>  <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
                <input type="number" name="price[]" step="0.01"  id="price" value="<?=$item['price'];?>" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Price">
                <div class="invalid-feedback" id="price_error"></div>
            </div>
        </div>
        <div>
           
        </div>
       
        </div>

        </div>
        <?php 
        }
    }?>
    </div>
            
         <div class="flex justify-end space-x-4 pt-6 gap-3 border-t border-gray-200">
        <button type="button" id="closeModal"
                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors !rounded-md">
          Cancel
        </button>
        <button type="submit" id="submitBtn"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors !rounded-md">
          Save
        </button>
      </div>
      
      </form>
</div><!-- close body -->
<?= $this->endSection();?>
<?= $this->section('scripts'); ?>
<script src="<?=base_url(relativePath: 'public/assets/js/sale.js');?>"></script>

<script>
    
// Add new row
$('#addContactRow').on('click', function () {
    let newRow = $('#productWrapper .product-row:first').clone();

    // Clear all inputs
    newRow.find('input').val('');
    newRow.find('select').val('');

    //$('#productWrapper').append(newRow);
    addNewRow();
    
});
$(document).on('change', 'select[name="category[]"]', function () {
    let lastSelect = $('select[name="category[]"]').last();

    // If the changed dropdown is the last one
    if ($(this).is(lastSelect) && $(this).val() !== "") {
        addNewRow();
    }
});

function addNewRow() {
    let newRow = `
    <div class="border border-gray-200 rounded-lg py-2 px-2 product-row mt-2">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Category -->
            <div class="md:col-span-1">
                <label class="">Category *</label>
                <select name="category[]" class="w-full px-3 py-2 border rounded-lg">
                    <option value="">Choose Product</option>
                    <!-- Populate dynamically -->
                    <?php foreach($products as $product): ?>
                        <option value="<?= $product['id']; ?>"><?= $product['product_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Quantity -->
            <div>
                <label>Quantity</label>
                <input type="number" step="0.01" name="quantity[]" class="w-full px-3 py-2 border rounded-lg" placeholder="Qty">
            </div>

            <!-- Unit Price -->
            <div>
                <label>Unit Price</label>
                <input type="number" step="0.01" name="price[]" class="w-full px-3 py-2 border rounded-lg" placeholder="Price">
            </div>

            <!-- Delete Button -->
            <div class="flex items-end">
                 <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors removeRow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-4 h-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    `;

    $("#productWrapper").append(newRow);
}




// Remove row
$(document).on('click', '.removeRow', function () {
    $(this).closest('.product-row').remove();
});



// Remove row
$(document).on('click', '.removeRow', function () {
    if ($('#productWrapper .product-row').length > 1) {
        $(this).closest('.product-row').remove();
       
    } else {
        alert("At least one row is required.");
    }
});

</script>
<?= $this->endSection();?>
