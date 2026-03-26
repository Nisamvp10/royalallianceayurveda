
<div id="coupencodeModal" 
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
  <div class="bg-white rounded-lg shadow-xl w-[50%]  max-h-[90vh] overflow-y-auto">
    
    <!-- Header -->
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
      <h2 id="mdlTitle" class="text-2xl font-bold text-gray-900">Add New Coupen</h2>
      <button   data-close="coupencodeModal"
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
    <div class="p-6">
    <!-- Body -->
        <form id="coupencodeForm" method="post" action="<?= base_url('coupencode/save') ?>">
            <?= csrf_field() ;?>
            
            <div class="mb-4">
                <input type="hidden" name="edit_id" id="edit_id" value="">
                <label for="coupenType" class="block text-sm font-medium text-gray-700 mb-1">Coupon Type</label>
                <select name="coupenType" id="coupenType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" >
                    <option value="">Select Coupon Type</option>
                    <option value="1">For Order</option>
                    <option value="2">For Product</option>
                </select>
                 <div class="invalid-feedback" id="coupenType_error"></div>
            </div>
            <div class="mb-4">
                <label for="coupencodeName" class="block text-sm font-medium text-gray-700 mb-1">Coupen Code</label>
                <input type="text" id="coupencode" name="coupencode" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Coupen Code" >
                 <div class="invalid-feedback" id="coupencode_error"></div>
            </div>

         

            <div class="mb-4">
                <div class="flex gap-2">
                    <div class="w-full">
                        <label for="maximumShopping" class="block text-sm font-medium text-gray-700 mb-1"> Discount</label>
                        <input type="number" min="0" id="discount" name="discount" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Discount" >
                        <div class="invalid-feedback" id="discount_error"></div>
                    </div>
                    <div class="w-full">
                         <label for="coupenType" class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
                        <select name="discount_type" id="discount_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" >
                            <option value="">Select Coupon Type</option>
                            <option value="1">Flat</option>
                            <option value="2">Percentage</option>
                        </select>
                        <div class="invalid-feedback" id="discount_type_error"></div>
                    </div>
                </div>
            </div>

            <div class="flex gap-2">
                <div class="mb-4 w-full">
                    <label for="minimumShopping" class="block text-sm font-medium text-gray-700 mb-1">Minimum Shopping</label>
                    <input type="number" min="0" id="minimumShopping" name="minimumShopping" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Minimum Shopping" >
                    <div class="invalid-feedback" id="minimumShopping_error"></div>
                </div>

                <div class="mb-4 w-full">
                    <label for="maxdiscountAmount" class="block text-sm font-medium text-gray-700 mb-1">Maximum Discount Amount</label>
                    <input type="number" min="0" id="maximum_discount_amount" name="maximum_discount_amount" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Maximum Discount Amount" >
                    <div class="invalid-feedback" id="maximum_discount_amount_error"></div>
                </div>
            </div>

            <!-- for products list all products here  -->


            <div class="mb-4">
                <label for="validity" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="text" id="filterDate" name="filterDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Select Start date to End date" >
                 <div class="invalid-feedback" id="filterDate_error"></div>
            </div>
             <div class="mb-4">
                <label for="validity" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea type="text" id="description" name="description" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Select Start date to End date" ></textarea>
                 <div class="invalid-feedback" id="description_error"></div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" data-close="coupencodeModal" class="px-4 py-2 text-gray-700 border border-gray-300 !rounded-md hover:bg-gray-50">Cancel</button>
                <button id="submitBtn" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 !rounded-md flex items-center transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save mr-1"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>Save</button>
            </div>
        </form>
    </div>
  </div>
</div>
