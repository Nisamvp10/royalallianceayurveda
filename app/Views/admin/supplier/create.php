<?php $this->extend('template/layout/main') ;?>
<?= $this->section('content') ?>
<?php
    if (!empty($data)) {
        $id = encryptor($data['id']);
        $name = $data['supplier_name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $store = $data['store'];
        $profile = $data['profileimg'] ?? '';
    }else {
        $id=$name=$email=$phone=$profile=$store ='';
    }?>
 <!-- titilebar -->
 <div class="flex items-center justify-between_">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between_ align-items-center mb-0">
            <a href="<?=base_url('staff');?>" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left text-gray-500">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
                </svg>
            </a> 
            <h1 class="h3 mb-0 text-left"><?= $page ?? '' ?></h1>
            <?php
            if(haspermission(session('user_data')['role'],'create_staff')) { ?>
                <div class="hidden">
                    <a href="<?= base_url('staff-upload') ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Bulk Team Data Upload 
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div><!-- closee titilebar -->

<!-- body -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden p-4">
    <form id="supplierForm" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div >
                    <label class="block text-sm font-medium text-gray-700 mb-1">Srore</label>
                    <div class="relative">
                        <input type="hidden" name="id" value="<?=$id;?>" />
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-person text-xl text-gray-400"></i></div>
                        <input type="text" name="store" value="<?= $store ?>"  id="store" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Store Name">
                        <div class="invalid-feedback" id="store_error"></div>
                    </div>
                </div>
                <div >
                    <label class="block text-sm font-medium text-gray-700 mb-1">Supplier Name</label>
                    <div class="relative">
                        <input type="hidden" name="id" value="<?=$id;?>" />
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-person text-xl text-gray-400"></i></div>
                        <input type="text" name="supplier_name" value="<?= $name ?>"  id="supplier_name" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Supplier Name">
                        <div class="invalid-feedback" id="supplier_name_error"></div>
                    </div>
                </div>
                <div >
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-envelope-at text-xl text-gray-400"></i></div>
                        <input type="email" value="<?= $email ?>"  name="email"  id="email" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Your Email">
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
                
                <!-- <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile / IMG URL</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 mt-2 items-center pointer-events-none"><i class="bi bi-image text-xl text-gray-400"></i></div>
                        <input type="file" name="file"  id="file" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Password">
                        <div class="invalid-feedback" id="file_error"></div>
                    </div>
                </div> -->
                 <div class="flex mt-2 justify-end gap-3">
                        <a href="<?=base_url('admin/staff');?>" class="border border-gray-300 px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">Cancel</a>
                        <?php if(haspermission('','create_supplier' )) { ?>
                            <button type="submit" id="submitBtn" class="bg-primary-600 px-4 py-2 flex !rounded-md hover:bg-primary-700 rounded-lg text-white transition-colors items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save mr-1"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>Save</button>
                        <?php } ?>
                </div>
                
            </div>

            <!-- 2 -->
          
        </div>
        
    </form>
</div><!-- close body -->
<?= $this->endSection();?>
<?= $this->section('scripts'); ?>
<script>
        $('#supplierForm').on('submit', function(e) {
            let webForm = $('#supplierForm');
            e.preventDefault();
            let formData = new FormData(this);

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            $('#submitBtn').prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
            );

            $.ajax({
                url : '<?=base_url('admin/supplier/save');?>',
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

 const dropdown = document.getElementById('serviceDropdown');
  const addBtn = document.getElementById('addServiceBtn');
  const tagContainer = document.getElementById('serviceTags');

  addBtn.addEventListener('click', () => {
    const value = dropdown.value;
    const text = dropdown.options[dropdown.selectedIndex].text;

    if (!value) return;

    dropdown.querySelector(`option[value="${value}"]`).remove();
    dropdown.value = "";

    const tag = document.createElement('div');
    tag.className = 'inline-flex items-center bg-blue-50 text-blue-700 rounded-full px-3 py-1 text-sm';
    tag.dataset.value = value;
    tag.innerHTML = `
      ${text}
      <button type="button" class="ml-1 text-blue-700 hover:text-blue-900 removeBtn" data-value="${value}" data-text="${text}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x "><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
      </button>
      <input type="hidden" name="services[]" value="${value}">
    `;
    tagContainer.appendChild(tag);
  });

  // Remove tag and restore dropdown option
  tagContainer.addEventListener('click', (e) => {
    const btn = e.target.closest('.removeBtn');
    if (btn) {
      const tag = btn.closest('.inline-flex');
      const value = btn.dataset.value;
      const text = btn.dataset.text;

      // Remove tag
      tag.remove();

      // Add back to dropdown
      const option = document.createElement('option');
      option.value = value;
      option.textContent = text;
      dropdown.appendChild(option);

      const options = Array.from(dropdown.options).slice(1); // skip first (placeholder)
      options.sort((a, b) => a.text.localeCompare(b.text));
      options.forEach(option => dropdown.appendChild(option));
    }
  });


    document.getElementById("togglePassword").addEventListener("click", function() {
        const passwordField = document.getElementById("password");
        const icon = this.querySelector("i");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    });


</script>
<?= $this->endSection();?>
