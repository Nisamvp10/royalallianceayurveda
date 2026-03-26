<!-- Banner Modal -->
<div id="feedbackModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 wrapModal">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[100vh] min-h-[80vh] overflow-y-auto">
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
      <h2 class="text-2xl font-bold text-gray-900 head"></h2>
      <button data-close="feedbackModal" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
        ✕
      </button>
    </div>
    <div class="p-6">
        <form class="p-6 space-y-6" id="feedbackForm" enctype="multipart/form-data"> 
             <?= csrf_field() ?>
              <input type="hidden" name="itmId" id="edit_id" />
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <div >
                   <div class="form-group ">
                    <label class="block text-gray-700 font-semibold mb-2">Upload  Image</label>
                      <input type="hidden" name="selected_image" id="selected_image">
                            <button type="button" id="openUploader" data-folder="feedback" class="bg-gray-100 border px-4 py-2 rounded hover:bg-gray-200 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                Choose Image
                            </button>
                            <div id="selectedPreview" class="mt-3 hidden">
                                <img src="" id="previewImg" class="w-full max-h-60 object-contain border rounded ">
                            </div>
                            <input type="file" name="file" id="imageInput" class="hidden " accept="image/*">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <div class="relative">
                        <input type="hidden" name="staffId" value="">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-person text-xl text-gray-400"></i></div>
                        <input type="text" name="name" value="" id="name" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Name">
                        <div class="invalid-feedback" id="name_error"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Designation *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-briefcase text-xl text-gray-400"></i></div>
                        <input type="text" name="designation" value="" id="designation" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Designation">
                        <div class="invalid-feedback" id="designation_error"></div>
                    </div>
                </div>

                <div>
                    <div class="form-group ">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2"> Note *</label>
                        <textarea  id="note" rows="3" name="note" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Note...."></textarea>
                        <div class="invalid-feedback" id="note_error"></div>
                    </div>
                    
                </div>
            </div>
            <div class="flex justify-end space-x-4 pt-6 gap-3 border-t border-gray-200">
                <button type="button" data-close="feedbackModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors !rounded-md">Cancel</button>
                <button type="submit" id="submitBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors !rounded-md">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>
