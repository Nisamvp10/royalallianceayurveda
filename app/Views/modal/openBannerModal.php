<!-- Banner Modal -->
<div id="bannerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 wrapModal">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[100vh] min-h-[80vh] overflow-y-auto">
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
      <h2 class="text-2xl font-bold text-gray-900 head"></h2>
      <button data-close="bannerModal" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
        ✕
      </button>
    </div>
    <div class="p-6">
        <form class="p-6 space-y-6" id="bannerForm" enctype="multipart/form-data"> 
             <?= csrf_field() ?>
              <input type="hidden" name="bannerId" id="edit_id" />
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <div >
                   <div class="form-group ">
                    <label class="block text-gray-700 font-semibold mb-2">Upload Banner Image</label>
                      <input type="hidden" name="selected_image" id="selected_image">
                            <button type="button" id="openUploader" data-folder="slider" class="bg-gray-100 border px-4 py-2 rounded hover:bg-gray-200 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                Choose Banner Image
                            </button>
                            <div id="selectedPreview" class="mt-3 hidden">
                                <img src="" id="previewImg" class="w-full max-h-60 object-contain border rounded ">
                            </div>
                            <input type="file" name="file" id="imageInput" class="hidden " accept="image/*">
                    </div>

                </div>
                <div>
                    <div class="form-group ">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Banner Title *</label>
                        <input type="text" id="banner_title" name="banner_title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter product name">
                        <div class="invalid-feedback" id="banner_title_error"></div>
                    </div>

                     <div class="form-group mb-0">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Highlighted Words  *</label>
                        <input type="text" id="highlight" name="highlight" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter product name">
                        <div class="invalid-feedback" id="highlight_error"></div>
                    </div>
                </div>
           
                <div>
                    <div class="form-group mb-0">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                        <textarea id="description" rows="3" name="description" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Additional notes..."></textarea>
                        <div class="invalid-feedback" id="description_error"></div>
                    </div>
                </div>               

                <div> 
                    <div class="form-group ">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Url</label>
                        <input type="url" id="url" name="url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Redirect URL">
                        <div class="invalid-feedback" id="url_error"></div>
                    </div>
                </div>
                <div> 
                    <div class="form-group mb-0">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Button Title</label>
                        <input type="text" id="button_title" name="button_title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Button Title ">
                        <div class="invalid-feedback" id="url_error"></div>
                    </div>
                </div>
              
            <div class="flex justify-end space-x-4 pt-6 gap-3 border-t border-gray-200">
                <button type="button" data-close="bannerModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors !rounded-md">Cancel</button>
                <button type="submit" id="submitBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors !rounded-md">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>

