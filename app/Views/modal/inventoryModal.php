<!--  modal Open-->
<div id="inventoryModal" 
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center !z-99991 p-4">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-5xl max-h-[100vh] min-h-[80vh] overflow-y-auto">
    <!-- Header -->
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
      <h2 class="text-2xl font-bold text-gray-900">Create Purchase Order</h2>
      <button id="closeModal" 
              class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
             viewBox="0 0 24 24" fill="none" stroke="currentColor" 
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
             class="lucide lucide-x w-6 h-6">
          <path d="M18 6 6 18"></path>
          <path d="m6 6 12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Body -->
    <form class="p-6 space-y-6" id="createPurchase"> 
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="form-group mb-0">
                    <label for="supplier" class="block text-sm font-medium text-gray-700 mb-2">Supplier *</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" name="supplier" id="supplier">
                        <option value="">Choose Supplier</option>
                        <?php 
                            if(!empty($suppliers)) 
                            {
                                foreach($suppliers as $supplier) {
                                ?>
                                <option value="<?=$supplier['id'];?>"><?=$supplier['supplier_name'];?></option>
                                <?php
                                }
                            }
                            ?>
                    </select>
                     <div class="invalid-feedback" id="supplier_error"></div>
                </div>
            </div>
            <div>
                <div class="form-group mb-0">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Order Number</label>
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

      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div>
          <div class="form-group mb-0">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Purchase Date *</label>
            <input type="date" id="purchase_date" name="purchase_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter product name">
            <div class="invalid-feedback" id="purchase_date_error"></div>
          </div>
        </div>

        <div>
            <div class="form-group mb-0">
            <label for="baseSku" class="block text-sm font-medium text-gray-700 mb-2">Payment Status </label>
            <select name="payment_status" id="payment_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" >
                <option value="">Choose Payment Status</option>
                <option value="paid">Paid</option>
                <option value="credit">Credit</option>
            </select>
            <div class="invalid-feedback" id="payment_status_error"></div>
          </div>
        </div>

        <div>
            <div class="form-group mb-0">
            <label for="baseSku" class="block text-sm font-medium text-gray-700 mb-2">Payment Type</label>
            <select name="payment_type" id="payment_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" >
                <option value="">Choose Payment Type</option>
                <option value="bank">Bank</option>
                <option value="cash">Cash</option>
            </select>
            <div class="invalid-feedback" id="payment_type_error"></div>
          </div>
        </div>
        <div>
          <div class="form-group mb-0">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Payment Date </label>
            <input type="date" id="payment_date" name="payment_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Payment Date">
            <div class="invalid-feedback" id="payment_date_error"></div>
          </div>
        </div>

        <div></div>
        <div></div>
        <div></div>
                 
      <div>
        <div class="flex items-center justify-end  mb-0">
            <button type="button" id="addContactRow" class="mt-3 px-3 py-2 bg-blue-500 text-white !rounded-lg">+ Add Item</button>
        </div>
      </div>
      </div>

      <div id="productWrapper">
        <div class="border border-gray-200 rounded-lg p-4 product-row mt-2">
            <div class="flex items-center justify-between mb-1">
                <h6 class="item-title font-medium text-gray-900">Item 1</h6>
                <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors removeRow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-4 h-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line>
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <div class="form-group mb-0">
                        <label class="">Products *</label>
                        <div class="relative">

                            <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package text-xl text-gray-400">  <path d="M16.5 9.4 7.5 4.21"></path>  <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>  <path d="m3.3 7 8.7 5 8.7-5"></path>  <path d="M12 22V12"></path></svg>
                            </div>
                       
                            <!-- <select id="category" name="category[]"  class="product-select w-full px-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent productList__">
                                 <option value="">Choose Product</option>
                                <?php 
                                    if(!empty($products)) 
                                    {
                                        foreach($products as $product) {
                                        ?>
                                        <option value="<?=$product['id'];?>"><?=$product['product_name'];?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                            </select> -->
                                <input list="productList" name="" class="product-input  w-full px-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Search & select product">

                                <!-- hidden field to store ID -->
                                <input type="hidden" name="category[]" class="product-id">

                                <datalist id="productList">
                                <?php foreach($products as $product): ?>
                                    <option value="<?= $product['product_name'] ?>" data-id="<?= $product['id'] ?>"></option>
                                <?php endforeach; ?>
                                </datalist>
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
                <input type="number" step="0.01"  name="quantity[]" id="quantity"  class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Item Quantity">
                <div class="invalid-feedback" id="quantity_error"></div>
            </div>
        </div>

                        <!-- Phone -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1 !flex" for="price">Price</label>
            <span class="last-price" ></span>
            <span class="price-diff"></span>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg"      width="24" height="24" viewBox="0 0 24 24"      fill="none" stroke="currentColor" stroke-width="2"      stroke-linecap="round" stroke-linejoin="round"      class="lucide lucide-dollar-sign text-xl text-gray-400">  <line x1="12" y1="1" x2="12" y2="23"></line>  <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
                <input type="number" name="price[]" step="0.01"  id="price" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Price">
                <div class="invalid-feedback" id="price_error"></div>
            </div>
        </div>
       
        </div>

        </div>
    </div>
            
         <div class="flex justify-end space-x-4 pt-6 gap-3 border-t border-gray-200">
        <button type="button" onclick="closeModal()" 
                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors !rounded-md">
          Cancel
        </button>
        <button type="submit" id="submitBtn"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors !rounded-md">
          Save
        </button>
      </div>
      
      </form>

  </div>
</div>


<!--  -->