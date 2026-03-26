<?= $this->extend('template/layout/main') ?>
<?= $this->section('content') ?>
    <!-- titilebar -->
    <div class="flex items-center justify-between">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-0">
                <h1 class="h3 mb-0"><?= $page ?? '' ?></h1>
                <?php
                if(haspermission('','create_expertise')) { ?>
                <div>
                    <a onclick="openExpertiseModal()"  class="btn btn-primary" id="secTitle" data-title="<?=ucwords(getappdata('expertise'));?>"> 
                        <!-- onclick="toggleModal('bannerModal', true)"  -->
                        <i class="bi bi-plus-circle me-1"></i> Add <?=ucwords(getappdata('expertise'));?>
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
                <input type="text" id="searchProductInput" placeholder="Search branch by name, or location..." class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>
            
            
            </div>
            <!-- table -->
             <div class="overflow-x-auto">
                <div id="expertiseTable"></div>
            </div>
            <!-- close table -->
</div><!-- body -->
<!-- productModal -->

 <?= view('modal/expertiseModal');?>
<!-- view('modal/editBannerModal'); -->
 <?= view('modal/uploadGalleryModal');?>
 <!-- Cose Modal -->
<?= $this->endSection(); ?>
<?= $this->section('scripts') ?>
<script src="<?=base_url('public/assets/js/expertise.js');?>"></script>
<script src="<?=base_url('public/assets/js/sweetalert.js');?>"></script>
<?= $this->endSection() ?>

