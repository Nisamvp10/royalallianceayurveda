<!-- Banner Modal -->
<div id="serviceModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 wrapModal">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[80vh] min-h-[80vh] overflow-scroll">
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
      <h2 class="text-2xl font-bold text-gray-900 head"></h2>
      <button data-close="serviceModal" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
        ✕
      </button>
    </div>
    <div class="p-6">
         <!-- Progress steps -->
    <div class="flex justify-center mb-6">
      <div class="flex items-center">
        <div id="step1circle" class="w-8 h-8 rounded-full bg-blue-600 text-white flex justify-center items-center">1</div>
        <div class="w-10 h-[2px] bg-blue-600"></div>
        <div id="step2circle" class="w-8 h-8 rounded-full bg-gray-300 text-gray-700 flex justify-center items-center hidden">2</div>
        <div class="w-10 h-[2px] bg-gray-300"></div>
        <div id="step3circle" class="w-8 h-8 rounded-full bg-gray-300 text-gray-700 flex justify-center items-center hidden">3</div>
         <div class="w-10 h-[2px] bg-gray-300"></div>
        <div id="step4circle" class="w-8 h-8 rounded-full bg-gray-300 text-gray-700 flex justify-center items-center">2</div>
      </div>
    </div>

        <form class="p-6 space-y-6" id="serviceForm" enctype="multipart/form-data" method="post"> 
             <?= csrf_field() ?>
              <input type="hidden" name="itmId" id="edit_id" />
               <div id="step1" class="step">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <div >
                        <div class="form-group ">
                            <label class="block text-gray-700 font-semibold mb-2">Upload  Image</label>
                            <input type="hidden" name="selected_image" id="selected_image">
                                    <button type="button" id="openUploader" data-folder="news" class="bg-gray-100 border px-4 py-2 rounded hover:bg-gray-200 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                        Choose Image
                                    </button>
                                    <div id="selectedPreview" class="mt-3 hidden">
                                        <img src="" id="previewImg" class="w-full max-h-60 object-contain border rounded ">
                                    </div>
                                    <input type="file" name="file" id="imageInput" class="hidden " accept="image/*">
                            </div>
                        </div>
                             <div >
                        <div class="form-group ">
                            <label class="block text-gray-700 font-semibold mb-2">Icon Upload </label>
                            <input type="hidden" name="selected_icons" id="selected_icons">
                                    <button type="button" id="openUploader2" data-folder="icons" class="bg-gray-100 border px-4 py-2 rounded hover:bg-gray-200 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                        Choose Image
                                    </button>
                                    <div id="selectedIconsPreview" class="mt-3 hidden w-20">
                                        <img src="" id="iconPreviewImg" class="w-full max-h-60 object-contain border rounded ">
                                    </div>
                                    <input type="file" name="iconfile" id="iconInput" class="hidden " accept="image/*">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">News Title *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-briefcase text-xl text-gray-400"></i></div>
                                <input type="text" name="title"  id="title" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your News Title">
                                <div class="invalid-feedback" id="title_error"></div>
                            </div>
                        </div>
                          <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-diagram-3 text-xl text-gray-400"></i></div>
                                <select class="w-full px-3 !pl-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" name="category" id="category">
                                     <option value="">Choose Category</option>
                                <?php
                                if(!empty($categories)){
                                    foreach ($categories as $cate) {
                                    ?>
                                        <option value="<?=$cate['id'];?>"><?=$cate['category'];?></option>
                                    <?php
                                    }
                                }?>
                                </select>
                                <div class="invalid-feedback" id="type_error"></div>
                            </div>
                        </div>
                          <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sub Categories </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-diagram-3 text-xl text-gray-400"></i></div>
                                <select class="w-full px-3 !pl-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" name="subcategory" id="subcategory">
                                     <option value="">Select Sub Category</option>
                               
                                </select>
                                <div class="invalid-feedback" id="subcategory_error"></div>
                            </div>
                        </div>
                       
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Short Note *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-pen text-xl text-gray-400"></i></div>
                                <textarea name="note" rows="3"  id="note" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Job Short Note...."></textarea>
                                <div class="invalid-feedback" id="note_error"></div>
                            </div>
                        </div>

                        <div>
                            <div class="form-group ">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2"> Description </label>
                                <textarea  id="description" rows="3" name="description" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Description...."></textarea>
                                <div class="invalid-feedback" id="description_error"></div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded" onclick="nextStep(4)">Next</button>
                    </div>
                </div> <!-- close set 1 -->
             <!-- Step 2 -->
                <div id="step2" class="step hidden">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 hidden">
                          <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-briefcase text-xl text-gray-400"></i></div>
                                <input type="text" name="pointtitle"  id="pointtitle" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Title">
                                <div class="invalid-feedback" id="pointtitle_error"></div>
                            </div>
                        </div>
                        <div id="productWrapper">
                       
                        
                              <div class="border border-gray-200 rounded-lg p-4  mt-2 ">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold">Highlight Points</label>
                                    <div id="points">
                                        <div>
                                            <input type="text" name="points[]" class="w-full border p-2 rounded mb-2" placeholder="Highlight point 1">
                                            <div class="invalid-feedback" id="points_error"></div>
                                        </div>
                                        <div>
                                            <textarea name="remark[]" class="w-full border p-2 rounded mb-2" placeholder="Description"></textarea>
                                        <div class="invalid-feedback" id="remark_error"></div>
                                        </div>
                                    </div>
                                    <button type="button" onclick="addPoint()" class="text-blue-600 text-sm mb-4">+ Add Point</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-3">
                        <button type="button" class="border px-4 py-2 rounded" onclick="prevStep(1)">Previous</button>
                        <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded" onclick="nextStep(3)">Next</button>
                    </div>
                </div>
                <div id="step3" class="step hidden hidden">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                     <div>
                        <div class="form-group">
                            <label class="block text-gray-700 font-semibold mb-2">Upload Gallery</label>
                            <input type="hidden" name="selected_images[]" id="selected_images">
                            <button type="button" id="openultiUploader" data-folder="products" class="bg-gray-100 border px-4 py-2 rounded hover:bg-gray-200 w-full">
                                Choose Images
                            </button>
                            <div id="selectedMultiPreview" class="mt-3 grid grid-cols-7 gap-2"></div>
                            <input type="file" name="media[]" id="mediaImageInput" class="hidden" accept="image/jpeg, image/jpg,image/png,image/webp,image/svg" multiple>

                            </div>
                        </div>
                        </div> 
                         <div class="flex justify-between mt-3">
                            <button type="button" class="border px-4 py-2 rounded" onclick="prevStep(2)">Previous</button>
                            <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded" onclick="nextStep(4)">Next</button>
                        </div>                

                        
                    </div>
                     <div id="step4" class="step hidden">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <h3>Product or Sub Service </h3>
                          <div class="hidden">
                           <label class="block text-sm font-medium text-gray-700 mb-1">Product Main Title *</label>
                           <div class="relative">
                               <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-briefcase text-xl text-gray-400"></i></div>
                               <input type="text" name="variant_main_title"  id="variant_main_title" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Title">
                               <div class="invalid-feedback" id="variant_main_title_error"></div>
                           </div>
                        </div>
                        <div id="variantWrapper">
                            <div class="border border-gray-200 rounded-lg p-4 new-row mt-2">
                                <input type="hidden" name="variantId" value="" />
                                <div>
                                    <label class="block mb-2 text-sm font-semibold">Product Title</label>
                                    <input type="text" name="variant_title[]" class="w-full border p-2 rounded mb-2" placeholder="Enter Title">
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-semibold">Description</label>
                                    <textarea name="variant_notes[]" class="w-full border p-2 rounded mb-2 wdesc" id="sds" placeholder="Enter Short Description"></textarea>
                                </div>

                               <div>
                                    <label class="block mb-2 text-sm font-semibold">Image</label>

                                    <input type="file"
                                        name="variant[]"
                                        multiple
                                        accept="image/jpeg, image/jpg, image/png, image/webp, image/svg+xml"
                                        class="bg-gray-100 border px-4 py-2 rounded hover:bg-gray-200 w-full"
                                        id="variantImages">

                                    <!-- Preview Area -->
                                    <div id="variantPreview" class="mt-3 flex flex-wrap gap-2"></div>
                                </div>

                            </div>
                        </div>

                        <button type="button" onclick="addVariantRow()" class="bg-blue-500 text-white px-3 py-2 rounded mt-2">+ Add Product</button>
                    </div>
                    <div class="flex justify-end space-x-4 pt-6 gap-3 border-t border-gray-200">
                            <button type="button" class="border px-4 py-2 rounded" onclick="prevStep(1)">Previous</button>
                            <button type="button" data-close="serviceModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors !rounded-md">Cancel</button>
                            <button type="submit" id="submitBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors !rounded-md">Save</button>
                    </div>
                </div>
                </div>
        </form>
    </div>
  </div>
</div>
