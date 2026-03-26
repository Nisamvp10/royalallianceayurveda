<?= $this->extend('template/layout/main') ?>
<?= $this->section('content') ?>
    <!-- titilebar -->
    <div class="flex items-center justify-between">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-0">
                <h1 class="h3 mb-0"><?= $page ?? '' ?></h1>
                <?php
                if(haspermission('','create_product_management')) { ?>
                <div>
                    <a onclick="openModal()"  class="btn btn-primary"> 
                        <!-- onclick="toggleModal('bannerModal', true)"  -->
                        <i class="bi bi-plus-circle me-1"></i> Add <?=$page;?>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div><!-- closee titilebar -->

    <!-- body -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden p-4">
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <!-- Column 1: Search Input -->
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search text-gray-400">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                </div>
                <input type="text" id="searchProductInput" placeholder="Search Title, or location..." class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>
                <!-- Column 2: Status Dropdown -->
            <div class="w-full md:w-48">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter text-gray-400">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    </div>
                    <select id="filerProductStatus" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                    <option value="all">All Products</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                    </select>
                </div>
            </div>
            </div>
            
            
            </div>
            <!-- table -->
             <div class="overflow-x-auto">
                <div id="servicesTable"></div>
            </div>
            <!-- close table -->
</div><!-- body -->
<!-- productModal -->

 <?= view('modal/productMnagementModal');?>
<!-- view('modal/editBannerModal'); -->
<?= view('modal/uploadGalleryModal');?>
<?= view('modal/iconsModal');?>
<?= view('modal/multiImgModal');?>
 <!-- Cose Modal -->
<?= $this->endSection(); ?>
<?= $this->section('scripts') ?>
<script>
    App.init({
        siteUrl: '<?=base_url();?>',
        cust: '<?=base_url('admin/'.slugify(getappdata('product_management')));?>',
    });
</script>
<script src="<?=base_url('public/assets/js/productmanagement.js');?>"></script>
<script src="<?=base_url('public/assets/js/sweetalert.js');?>"></script>
<?= $this->endSection() ?>

