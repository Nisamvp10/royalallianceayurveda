<!-- Banner Modal -->
<div id="productManageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 wrapModal">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl max-h-[80vh] min-h-[80vh] overflow-scroll">
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
      <h2 class="text-2xl font-bold text-gray-900 head"></h2>
      <button data-close="productManageModal" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
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
        <div id="step3circle" class="w-8 h-8 rounded-full bg-gray-300 text-gray-700 flex justify-center items-center ">2</div>
         <div class="w-10 h-[2px] bg-gray-300"></div>
        <div id="step4circle" class="w-8 h-8 rounded-full bg-gray-300 text-gray-700 flex justify-center items-center">3</div>
      </div>
    </div>

        <form class="p-6 space-y-6" id="productManageForm" enctype="multipart/form-data" method="post"> 
             <?= csrf_field() ?>
              <input type="hidden" name="itmId" id="edit_id" />
               <div id="step1" class="step">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <div >
                        <div class="form-group ">
                            <label class="block text-gray-700 font-semibold mb-2">Upload  Image</label>
                            <input type="hidden" name="selected_image" id="selected_image">
                                    <button type="button" id="openUploader" data-folder="products" class="bg-gray-100 border px-4 py-2 rounded hover:bg-gray-200 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                        Choose Image
                                    </button>
                                    <div id="selectedPreview" class="mt-3 hidden">
                                        <img src="" id="previewImg" class="w-full max-h-60 object-contain border rounded ">
                                    </div>
                                    <input type="file" name="file" id="imageInput" class="hidden " accept="image/*">
                            </div>
                        </div>
                          

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1"> Title *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-briefcase text-xl text-gray-400"></i></div>
                                <input type="text" name="title"  id="title" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Product Title">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product  </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-diagram-3 text-xl text-gray-400"></i></div>
                                <select class="w-full px-3 !pl-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" name="products" id="products">
                                     <option value="">Select Product</option>
                               
                                </select>
                                <div class="invalid-feedback" id="products_error"></div>
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

                        <div class="bg-card rounded-xl border border-border p-6 space-y-6 mb-2">
                            <h3 class="text-lg font-medium">Pricing &amp; Inventory</h3>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="price">Price * [AVG : <span id="avgAmt"></span>]</label>
                                    <div class="relative"><span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">$</span>
                                        <input type="number" class="flex h-10 w-full rounded-md border border-input bg-background px-4 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm pl-7"
                                        id="price" name="price" step="0.01" min="0" value="0">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="compare_at_price">Compare at Price</label>
                                    <div class="relative"><span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">$</span>
                                        <input type="number" class="flex h-10 w-full rounded-md border border-input bg-background px-4 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm pl-7"
                                        name="compare_price" id="compare_at_price" step="0.01" min="0" placeholder="Optional" value="">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="sku">SKU</label>
                                    <input class="flex h-10 w-full rounded-md border border-input bg-background px-4 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                    id="sku" placeholder="SKU-001" value="" readonly>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="stock_quantity">Stock Quantity *</label>
                                    <input type="number" class="flex h-10 w-full rounded-md border border-input bg-background px-4 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
                                    id="stock_quantity" min="0" value="0" readonly>
                                </div>
                            </div>
                        </div>                        
                    </div>

                    <!--  -->
                    <div class="bg-card rounded-xl p-6 space-y-6 border border-border mt-2">
                        <div class="grid gap-4 sm:grid-cols-3">
                              <div class="space-y-2">
                                 <div class=" border border-border p-2 rounded-xl">
                                        <h4 class="text-lg font-medium">Product Status</h4>
                                        <p class="text-sm text-muted-foreground">Active products are visible in your store</p>
                                        <label class="form-check form-switch mt-2">
                                            <input class="form-check-input" id="status" type="checkbox" name="status" >
                                        </label>
                                  </div>
                            </div>
                            <!--  -->
                            <div class="space-y-2">
                                <div class=" border border-border p-2 rounded-xl">
                                    <h4 class="text-lg font-medium">Premium Product</h4>
                                    <p class="text-sm text-muted-foreground">Active products are visible in your Premium List</p>
                                    <label class="form-check form-switch mt-2">
                                        <input class="form-check-input" id="premium" type="checkbox" name="premium" >
                                    </label>
                                </div>
                            </div>
                            <!--  -->
                             <!--  -->
                            <div class="space-y-2">
                                <div class=" border border-border p-2 rounded-xl">
                                    <h4 class="text-lg font-medium">Featured product</h4>
                                    <p class="text-sm text-muted-foreground">Active products are visible in your Featured List</p>
                                    <label class="form-check form-switch mt-2">
                                        <input class="form-check-input" id="featured" type="checkbox" name="featured" >
                                    </label>
                                </div>
                            </div>
                            <!--  -->
                        </div>
                    </div>
                    <!--  -->
                    <div class="flex justify-end mt-2">
                        <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded" onclick="nextStep(3)">Next</button>
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
                <div id="step3" class="step hidden ">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                     <div>
                        <div class="form-group">
                            <label class="block text-gray-700 font-semibold mb-2">Upload Veriant Images</label>
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
                            <button type="button" class="border px-4 py-2 rounded" onclick="prevStep(1)">Previous</button>
                            <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded" onclick="nextStep(4)">Next</button>
                        </div>                

                        
                    </div>
                     <div id="step4" class="step hidden">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <h3>SEO </h3>
                          <div class="">
                           <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title </label>
                           <div class="relative">
                               <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-briefcase text-xl text-gray-400"></i></div>
                               <input type="text" name="meta_title"  id="meta_title" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Meta Title">
                               <div class="invalid-feedback" id="meta_title_error"></div>
                           </div>
                        </div>
                           <div class="">
                           <label class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords </label>
                           <div class="relative">
                               <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-briefcase text-xl text-gray-400"></i></div>
                                    <textarea name="meta_keywords" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="meta_description" placeholder="Enter Meta Description"></textarea>                               <div class="invalid-feedback" id="meta_title_error"></div>
                               <div class="invalid-feedback" id="meta_keywords_error"></div>
                           </div>
                        </div>
                        

                    </div>
                    <div class="flex justify-end space-x-4 pt-6 gap-3 border-t border-gray-200">
                            <button type="button" class="border px-4 py-2 rounded" onclick="prevStep(3)">Previous</button>
                            <button type="button" data-close="serviceModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors !rounded-md">Cancel</button>
                            <button type="submit" id="submitBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors !rounded-md">Save</button>
                    </div>
                </div>
                </div>
        </form>
    </div>
  </div>
</div>
