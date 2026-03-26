<!-- Banner Modal -->
<div id="staffModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 wrapModal">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[100vh] min-h-[80vh] overflow-y-auto">
    <div class="flex items-center justify-between p-6 border-b border-gray-200">
      <h2 class="text-2xl font-bold text-gray-900 head"></h2>
      <button data-close="staffModal" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
        ✕
      </button>
    </div>
    <div class="p-6">
        <form class="p-6 space-y-6" id="teamForm" enctype="multipart/form-data"> 
             <?= csrf_field() ?>
              <input type="hidden" name="staffId" id="edit_id" />
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                <div >
                   <div class="form-group ">
                    <label class="block text-gray-700 font-semibold mb-2">Upload  Image</label>
                    <input type="hidden" name="selected_image" id="selected_image">
                        <button type="button" id="openUploader" data-folder="user" class="bg-gray-100 border px-4 py-2 rounded hover:bg-gray-200 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                            Choose Image
                        </button>
                        <div id="selectedPreview" class="mt-3 hidden">
                            <img src="" id="previewImg" class="w-full max-h-60 object-contain border rounded ">
                        </div>
                        <input type="file" name="file" id="imageInput" class="hidden " accept="image/*">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div >
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-person text-xl text-gray-400"></i></div>
                        <input type="text" name="name"  id="name" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Name">
                        <div class="invalid-feedback" id="name_error"></div>
                    </div>
                </div>
                <div >
                    <label class="block text-sm font-medium text-gray-700 mb-1">Position*</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-person text-xl text-gray-400"></i></div>
                        <input type="text" name="position"  id="position" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Position">
                        <div class="invalid-feedback" id="position_error"></div>
                    </div>
                </div>
                <div >
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-envelope-at text-xl text-gray-400"></i></div>
                        <input type="email" name="email"  id="email" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Email">
                        <div class="invalid-feedback" id="email_error"></div>
                    </div>
                </div>
                <div >
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-telephone text-xl text-gray-400"></i></div>
                        <input type="text"  name="phone"  id="phone" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your phone">
                        <div class="invalid-feedback" id="phone_error"></div>
                    </div>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-instagram text-xl text-gray-400"></i></div>
                        <input type="url"   name="instagram"  id="instagram" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Instagram URL">
                        <div class="invalid-feedback" id="instagram_error"></div>
                    </div>
                </div>
                          
            </div>

            <!-- 2 -->
            <div class="space-y-4">
           
                 
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <!-- Eye Icon (clickable) -->
                        <div id="togglePassword" class="absolute inset-y-0 left-0 pl-3 mt-2  items-center cursor-pointer">
                            <i class="bi bi-eye text-xl text-gray-400"></i>
                        </div>

                        <!-- Password Input -->
                        <input type="password" name="password"  id="password" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Password">
                        <div class="invalid-feedback" id="password_error"></div>
                    </div>
                </div>
                                
                

               
                   <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-key text-xl text-gray-400"></i></div>
                        <select name="role" id="role" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required="">
                            <option   value="">Select Role</option>
                            <?php
                                if(!empty($roles)){
                                    foreach($roles as $role){
                                    ?>
                                        <option value="<?=$role->id;?>"><?=$role->role_name;?></option>
                                    <?php 
                                    } 
                                } ?>
                        </select>                       
                        <div class="invalid-feedback" id="hrole_error"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-facebook text-xl text-gray-400"></i></div>
                        <input type="url"   name="facebook"  id="facebook" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Facebook URL">
                        <div class="invalid-feedback" id="facebook_error"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Linkedin</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-linkedin text-xl text-gray-400"></i></div>
                        <input type="url"   name="linkedin"  id="linkedin" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter linkedin URL">
                        <div class="invalid-feedback" id="linkedin_error"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Twitter</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-twitter text-xl text-gray-400"></i></div>
                        <input type="url"   name="twitter"  id="twitter" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Twitter URL">
                        <div class="invalid-feedback" id="twitter_error"></div>
                    </div>
                </div>
               
            </div><!-- close2 -->
        </div>
            </div>
            <div class="flex justify-end space-x-4 pt-6 gap-3 border-t border-gray-200">
                <button type="button" data-close="staffModal" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors !rounded-md">Cancel</button>
                <button type="submit" id="submitBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors !rounded-md">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>