<!--  modal Open-->
<div id="productModal" 
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[100vh] min-h-[80vh] overflow-y-auto">
    <!-- Header -->
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
      <h2 class="text-2xl font-bold text-gray-900">Add New Product</h2>
      <button id="closeProductModal" 
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
    <form class="p-6 space-y-6" id="createProduct"> 
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <div class="form-group">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
            <input type="text" id="product_name" name="product_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter product name">
            <div class="invalid-feedback" id="product_name_error"></div>
          </div>
        </div>

        <div>
            <div class="form-group">
            <label for="baseSku" class="block text-sm font-medium text-gray-700 mb-2">Base SKU *</label>
            <input type="text" name="sku" id="sku" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., PROD001">
            <div class="invalid-feedback" id="sku_error"></div>
          </div>
        </div>

          <div>
            <div class="form-group mb-0">
              <label class="">Category *</label>
              <div class="relative w-full" id="categoryWrapper">
                
                <!-- Hidden input to hold selected value -->
                <input type="hidden" name="category_id" id="category_id">

                <!-- Selected -->
                <button id="dropdownButton" type="button"  
                  class="w-full bg-white border border-gray-300 !rounded-lg px-4 py-2 text-left flex justify-between items-center">
                  <span id="selectedText">-- Select Category --</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">  
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>

                <!-- Dropdown -->
                <div id="dropdownMenu" class="absolute z-10 mt-1 w-full bg-white border border-gray-200 !rounded-lg shadow-lg hidden">
                  <!-- Search -->
                  <div class="p-2">
                    <input type="text" id="dropdownSearch" placeholder="Search or add..."
                      class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                  </div>

                  <!-- Options -->
                  <ul id="dropdownOptions" class="max-h-40 overflow-y-auto">
                  
                  </ul>

                  <!-- Add New -->
                  <div class="border-t border-gray-200">
                    <button type="button" id="openCateModal" class="w-full px-4 py-2 text-left text-blue-600 hover:bg-blue-50">
                      + Add New Category
                    </button>
                  </div>
                </div>
                <div class="invalid-feedback" id="category_id_error"></div>
              </div>
            </div>
      </div>
         <div class="form-group">
            <label for="minStock" class="block text-sm font-medium text-gray-700 mb-2">Minimum Stock *</label>
            <input type="number" name="min_stock" id="min_stock" value="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Minimum Stock">
            <div class="invalid-feedback" id="min_stock_error"></div>
          </div>
      </div>
      <div>
        <div class="form-group">
          <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
          <textarea id="notes" rows="3" name="note" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Additional notes..."></textarea>
        </div>
      </div>



         <div class="flex justify-end space-x-4 pt-6 gap-3 border-t border-gray-200">
        <button type="button" id="cancelProductModal"
                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors !rounded-md">
          Cancel
        </button>
        <button type="submit" id="submitBtn"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors !rounded-md">
          Create Product
        </button>
      </div>
      
      </form>

  </div>
</div>


<!--  -->