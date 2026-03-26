

    <!-- Banner Modal -->
<div id="categoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 wrapModal">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[100vh] min-h-[80vh] overflow-y-auto">
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
      <h2 class="text-2xl font-bold text-gray-900 head capitalize"></h2>
      <button data-close="categoryModal" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
        ✕
      </button>
    </div>
    <div class="p-6">
         <!-- Progress steps -->
        <form class="p-6 space-y-6" id="categoryForm" enctype="multipart/form-data" method="post"> 
             <?= csrf_field() ?>
            <input type="hidden" name="itmId" id="edit_id" />    
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <div class="mb-4">
                    <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                    <input type="text" id="category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter category name" required>
                    <div class="invalid-feedback" id="category_error"></div>
                </div>
                <div class="mb-4">
                    <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-1">Sub Category </label>
                  <select name="parent_id" id="parent_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                          <option value="">Sub Category</option>
                          <?php foreach ($roles as $role): ?>
                              <option value="<?= $role['id'] ?>">
                                  <?= str_repeat('— ', $role['level'] - 1) . $role['category'] ?>
                              </option>
                          <?php endforeach ?>
                      </select>
              </div>

                <div class="flex justify-end space-x-4 pt-6 gap-3 border-t border-gray-200">
                    <button type="button" data-close="categoryModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors !rounded-md">Cancel</button>
                    <button type="submit" id="submitBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors !rounded-md">Save</button>
                </div>
            </div>
        </form>
    </div>
  </div>
</div>
