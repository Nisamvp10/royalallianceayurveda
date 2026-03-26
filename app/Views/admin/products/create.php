<?php $this->extend('template/layout/main') ;?>
<?= $this->section('content') ?>
<?php
    if (!empty($data)) {
        $id = encryptor($data['id']);
        $selectedCategory = $data['category_id'];
        $minStock = $data['min_stock'];
        $note = $data['note'];
        $sku = $data['sku'];
        $product_name = $data['product_name'] ?? '';
    }else {
        $id=$product_name=$sku=$note=$minStock=$selectedCategory ='';
    }?>
 <!-- titilebar -->
 <div class="flex items-center justify-between_">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between_ align-items-center mb-0">
            <a href="<?=base_url('admin/all-products');?>" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
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
<div class="bg-white rounded-lg shadow-sm overflow-hidden p-4 w-50">
   <form class="p-6 space-y-6" id="createProduct"> 
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <div class="form-group">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
            <input type="hidden" name="id" value="<?=$id;?>" />
            <input type="text" id="product_name" name="product_name" value="<?=$product_name;?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter product name">
            <div class="invalid-feedback" id="product_name_error"></div>
          </div>
        </div>

        <div>
            <div class="form-group">
            <label for="baseSku" class="block text-sm font-medium text-gray-700 mb-2">Base SKU *</label>
            <input type="text" name="sku" id="sku" value="<?=$sku;?>" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., PROD001">
            <div class="invalid-feedback" id="sku_error"></div>
          </div>
        </div>

          <div>
            <div class="form-group mb-0">
              <label class="">Category *</label>
              <select id="category_id" name="category_id"  class="w-full px-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent ">
                 <option value="">Choose Category</option>
                <?php 
                    if(!empty($categories)) 
                    {
                        foreach($categories as $category) {
                        ?>
                        <option <?=($category['id'] == $selectedCategory ? 'selected' :'');?> value="<?=$category['id'];?>"><?=$category['category'];?></option>
                        <?php
                        }
                    }
                    ?>
            </select>
             <div class="invalid-feedback" id="sku_error"></div>
            </div>
      </div>
         <div class="form-group">
            <label for="minStock" class="block text-sm font-medium text-gray-700 mb-2">Minimum Stock *</label>
            <input type="number" name="min_stock" id="min_stock" value="<?=$minStock;?>" value="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Minimum Stock">
            <div class="invalid-feedback" id="min_stock_error"></div>
          </div>
      </div>
      <div>
        <div class="form-group">
          <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
          <textarea id="notes" rows="3" name="note" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Additional notes..."><?=$note;?></textarea>
        </div>
      </div>


     <div class="flex mt-2 justify-end gap-3">
        <a href="<?=base_url('admin/all-products');?>" class="border border-gray-300 px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">Cancel</a>
        <?php if(haspermission('','create_investment' )) { ?>
            <button type="submit" id="submitBtn" class="bg-primary-600 px-4 py-2 flex !rounded-md hover:bg-primary-700  text-white transition-colors items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save mr-1"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>Save</button>
        <?php } ?>
    </div>
      
      </form>
</div><!-- close body -->
<?= $this->endSection();?>
<?= $this->section('scripts'); ?>
<script src="<?=base_url('public/assets/js/products.js');?>"></script>

<?= $this->endSection();?>
