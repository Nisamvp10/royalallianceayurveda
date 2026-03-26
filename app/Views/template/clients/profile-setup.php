<?php $this->extend('template/layout/main') ;?>
<?= $this->section('content') ?>
<?php
    if (!empty($data)) 
    {
        $infoId     = encryptor($data['id']);
        $clientId   = encryptor($data['client_id']);
        $title      = $data['title'];
        $email      = $data['email'];
        $phone      = $data['phone'];
        $status     = $data['status'];
        $img        = $data['logo'];
        $url        = $data['slug'];
        $bannerImg  = $data['bannerimage'];
        $address    = $data['address'];
        $aboutUs    = $data['about_us'];
        $whatsapp   = $data['whatsapp_link'];
        $facebook   = $data['facebook_link'];
        $twitter    = $data['twitter_link'];
        $instagram  = $data['instagaram_link'];
        $website    = $data['website_link'];
        $secondary  = $data['secondarycolor'];
        $primary    = $data['primarycolor'];
    }else 
    {
        $whatsapp = $facebook = $twitter = $website = $instagram = $secondary=$primary='';
        $infoId=$title=$email=$phone=$position=$hire_date=$status=$ebranch=$img=$url=$bannerImg=$address=$aboutUs='';
    }?>
  <!-- titilebar -->
   
    <div class="flex items-center justify-between">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-0">
                <h1 class="h3 mb-0"><?= $page ?? '' ?></h1>
                 <?php if(haspermission('','create_client') ) { ?>
                <div>
                   
                    <a href="<?=base_url('clients');?>"  class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Add New Client
                    </a>
                    
                 </div>
                <?php } ?>
            </div>
        </div>
    </div><!-- closee titilebar -->

<!-- body -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden p-4">
    <form id="product_info" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div><h3 class="!text-lg !font-semibold text-gray-900 mb-4">Basic Information</h3><div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"> Clients</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-person text-xl text-gray-400"></i></div>
                        <select name="client" id="client" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required="">
                            <option  value="">Choose Client</option>
                            <?php 
                            foreach($clients as $clientKey) { ?>
                            <option  value="<?=$clientKey->id;?>"><?=$clientKey->name;?></option>
                            <?php } ?>
                        </select>                       
                        <div class="invalid-feedback" id="client_error"></div>
                    </div>
                </div>

                <?php 
                if(hasPermission('','generate_url')) { ?>
               <div >
                <label class="block text-sm font-medium text-gray-700 mb-1">Title / Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-bag-dash text-xl text-gray-400"></i></div>
                        <input type="text" value="<?= $url ?>"  name="url"  id="url" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Position">
                        <div class="invalid-feedback" id="url_error"></div>
                    </div>
                </div>
                <?php } ?>

               
                <div >
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-envelope-at text-xl text-gray-400"></i></div>
                        <input type="email" value="<?= $email ?>" <?=(!empty($id) ? 'readonly' : '') ?> name="email"  id="email" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Email">
                        <div class="invalid-feedback" id="email_error"></div>
                    </div>
                </div>
                <div >
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-telephone text-xl text-gray-400"></i></div>
                        <input type="number" value="<?= $phone ?>"  name="phone"  id="phone" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your phone">
                        <div class="invalid-feedback" id="phone_error"></div>
                    </div>
                </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile / Logo</label>
                    <div class="relative flex">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-image text-xl text-gray-400"></i></div>
                        <input type="file" name="file"  id="file" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Password">
                        <div class="ml-2">
                            <img src="<?=validImg($img);?>" class="w-10 h-10 rounded-full border border-solid border-gray-300">
                        </div>
                        <div class="invalid-feedback" id="file_error"></div>
                    </div>
                </div>
             
              
                
            </div>

            <!-- 2 -->
            <div class="space-y-4">
                 <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"> Plan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-cash text-xl text-gray-400"></i></div>
                        <select name="plan" id="paln" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required="">
                            <option  value="1">Basic Plan</option>
                           
                        </select>                       
                        <div class="invalid-feedback" id="paln_error"></div>
                    </div>
                </div>

                <div >
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-plus text-xl text-gray-400"></i></div>
                        <input type="number"   name="quantity"  id="quantity" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Quantity">
                        <div class="invalid-feedback" id="quantity_error"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-shop text-xl text-gray-400"></i></div>
                        <textarea class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" name="address" id="address" placeholder="Full Address"><?=$address;?></textarea>
                        <div class="invalid-feedback" id="address_error"></div>
                    </div>
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">About Us</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-emoji-smile text-xl text-gray-400"></i></div>
                        <textarea class="w-full h-20 pl-10 pr-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" name="about" id="about" placeholder="Enter Here... "><?=$aboutUs;?></textarea>
                        <div class="invalid-feedback" id="about_error"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Banner</label>
                    <div class="relative ">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-image text-xl text-gray-400"></i></div>
                        <input type="file" name="banner"  id="banner" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Password">
                        <div class="ml-2">
                            <img src="<?=validImg($bannerImg);?>" class="w-full h-22 mt-2 rounded-lg rounded-md border border-solid border-gray-300">
                        </div>
                        <div class="invalid-feedback" id="banner_error"></div>
                    </div>
                </div>
               
            </div><!-- close2 -->
        </div>
         <div><h3 class="!text-lg !font-semibold text-gray-900 mb-4 pt-3">Social Media Links</h3><div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Whatsapp</label>
                    <div class="relative ">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-whatsapp text-xl text-gray-400"></i></div>
                        <input type="url" name="whatsapp" value="<?=$whatsapp;?>"  id="whatsapp" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your whatsapp Link">
                        <div class="invalid-feedback" id="whatsapp_error"></div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                    <div class="relative ">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-facebook text-xl text-gray-400"></i></div>
                        <input type="url" name="facebook" value="<?=$facebook;?>"  id="facebook" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Instagram url">
                        <div class="invalid-feedback" id="facebook_error"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Twitter</label>
                    <div class="relative ">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-twitter text-xl text-gray-400"></i></div>
                        <input type="url" name="twitter" value="<?=$twitter;?>"  id="twitter" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Instagram url">
                        <div class="invalid-feedback" id="twitter_error"></div>
                    </div>
                </div>

            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                    <div class="relative ">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-instagram text-xl text-gray-400"></i></div>
                        <input type="url" name="instagram" value="<?=$instagram;?>" id="instagram" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Instagram url">
                        <div class="invalid-feedback" id="binstagram_error"></div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                    <div class="relative ">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-globe text-xl text-gray-400"></i></div>
                        <input type="url" name="web" value="<?=$website;?>"  id="web" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Instagram url">
                        <div class="invalid-feedback" id="web_error"></div>
                    </div>
                </div>
                <?php 
                if(hasPermission('','access_info')) {  ?>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"> Status</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-lock text-xl text-gray-400"></i></div>
                        <select name="status" id="status" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required="">
                            <option <?= ($status == "active" ? 'selected' :'') ?> value="1">Active</option>
                            <option <?= ($status == "inactive" ? 'selected' :'') ?> value="2">Inactive</option>
                        </select>                       
                        <div class="invalid-feedback" id="status_error"></div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php
               if(hasPermission('','access_info')) {  ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Primary Color</label>
                    <div class="relative">
                        <input type="color" id="primaryColorPicker" value="<?=rgbToHex($primary) ;?>" class="pl-3 pr-3 py-2 w-full border" />
                        <input type="hidden" name="primarycolor" id="primaryColorRGB" value="<?=esc($primary);?>" />
                        <p>RGB: <span id="primaryRgbValue"><?= esc($primary ?? 'rgb(0, 0, 0)') ?></span></p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Secondary Color</label>
                    <div class="relative">
                        <input type="color" id="secondaryColorPicker" class="pl-3 pr-3 py-2 w-full border" value="<?= rgbToHex($secondary); ?>" />
                        <input type="hidden" name="secondarycolor" id="secondaryColorRGB" value="<?= esc($secondary ?? '') ?>"  />
                        <p>RGB: <span id="secondaryRgbValue"><?= esc($secondary ?? 'rgb(0, 0, 0)') ?></span></p>



                <?php } ?>

           
        </div>
         <div class="flex mt-2 justify-end gap-3">
                <a href="<?=base_url('staff');?>" class="border border-gray-300 px-4 py-2 !text-gray-700 rounded-lg hover:bg-gray-50 ! transition-colors">Cancel</a>
                <?php if(haspermission('','create_client') ) { ?>
                    <button type="submit" id="submitBtn" class="bg-primary-600 px-4 py-2 flex !rounded-md hover:bg-primary-700 text-white transition-colors items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save mr-1"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>Save</button>
                <?php } ?>
        </div>
    </form>
</div><!-- close body -->
<?= $this->endSection();?>
<?= $this->section('scripts'); ?>
<script src="<?=base_url('public/assets/js/blog.js')?>" ></script>
<script>
        $('#product_info').on('submit', function(e) {
            let webForm = $('#product_info');
            e.preventDefault();
            let formData = new FormData(this);

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            $('#submitBtn').prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
            );

            $.ajax({
                url : '<?=base_url('product_info/save');?>',
                method:'POST',
                data: formData,
                contentType: false,
                processData: false,
                success:function(response)
                { 
                    if(response.success){
                        toastr.success(response.message);
                        webForm[0].reset();
                    }else{
                        if(response.errors){
                            $.each(response.errors,function(field,message)
                            {
                                $('#'+ field).addClass('is-invalid');
                                $('#' + field + '_error').text(message);
                            })
                        }else{
                            toastr.error(response.message);
                        }
                    }
                },error: function() {
                    toastr.error('An error occurred while saving Service');
                },
                complete: function() {
                    // Re-enable submit button
                    $('#submitBtn').prop('disabled', false).text('Save Branch');
                }
            })
        })



    function hexToRgb(hex) {
        hex = hex.replace('#', '');
        if (hex.length === 3) {
            hex = hex.split('').map(h => h + h).join('');
        }
        const bigint = parseInt(hex, 16);
        const r = (bigint >> 16) & 255;
        const g = (bigint >> 8) & 255;
        const b = bigint & 255;
        return `rgb(${r}, ${g}, ${b})`;
    }

    document.getElementById('primaryColorPicker').addEventListener('input', function () {
        const rgb = hexToRgb(this.value);
        document.getElementById('primaryRgbValue').textContent = rgb;
        document.getElementById('primaryColorRGB').value = rgb;
    });

    document.getElementById('secondaryColorPicker').addEventListener('input', function () {
        const rgb = hexToRgb(this.value);
        console.log(rgb);
        document.getElementById('secondaryRgbValue').textContent = rgb;
        document.getElementById('secondaryColorRGB').value = rgb;
    });



</script>
<?= $this->endSection();?>
