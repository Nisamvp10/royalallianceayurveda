<?= $this->extend('template/layout/main') ?>
<?= $this->section('content') ?>
    <!-- titilebar -->
    <div class="flex items-center justify-between">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-0">
                <h1 class="h3 mb-0"><?= $page ?? '' ?></h1>
                <?php
                if(haspermission('','create_banner')) { ?>
                <div>
                    <a onclick="openBannerModal()"  class="btn btn-primary"> 
                        <!-- onclick="toggleModal('bannerModal', true)"  -->
                        <i class="bi bi-plus-circle me-1"></i> Add Banner
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
                <div id="productsTable"></div>
            </div>
            <!-- close table -->
</div><!-- body -->
<!-- productModal -->

 <?= view('modal/openBannerModal');?>
<!-- view('modal/editBannerModal'); -->
 <?= view('modal/uploadGalleryModal');?>
 <!-- Cose Modal -->
<?= $this->endSection(); ?>
<?= $this->section('scripts') ?>
<script src="<?=base_url('public/assets/js/banner.js');?>"></script>
<script src="<?=base_url('public/assets/js/sweetalert.js');?>"></script>

<script>
        


  let currentPage = 1;
  let rowsPerPage = 50;
  let allBanner = [];

    //   
       // $(document).ready(function() {

            function loadProducts(search = '') {
                let filter = $('#filerProductStatus').val();
                $.ajax({
                    url: "<?= site_url('admin/banner/get-banner') ?>",
                    type: "POST",
                    data: { search: search,filter:filter },
                    dataType: "json",
                    success: function(response) {
                        if(response.success) {
                            renderTable(response.results);
                        }else{
                            renderTable(response.results);
                        }
                         
                    }
                });
            }

            function renderTable(results){
              
                let html = '';
               
                allBanner = results;
                if (results.length === 0) {
                    html += `
                        <div class="text-center py-8">
                            <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                            <p class="text-gray-500 mt-1">${(results.message ? results.message :'Try adjusting your search')}</p>
                        </div>
                    `;
                }else{
                    let start = (currentPage -1 ) * rowsPerPage;
                    let end   = start + rowsPerPage;
                    let paginationProducts = results.slice(start, end);
                    //console.log(paginationProducts);
                   html += `
                        <div class="overflow-x-auto w-full">
                        <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium">S/N</th>
                                <th class="px-4 py-3 text-left font-medium">Banner IMG</th>
                                <th class="px-4 py-3 text-left font-medium">Title</th>
                                <th class="px-4 py-3 text-left font-medium w-1/3">Description</th>
                                <th class="px-4 py-3 text-center font-medium">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                        `;

                      let i = start + 1;
                    paginationProducts.forEach(banner => {
            

                        html += `
                            <tr class="hover:bg-gray-50">
                             <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">${i++}</div>
                                    </div>
                                </td>
                                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">
                                        <img src="${banner.image ? banner.image : '<?=base_url('uploads/default.png');?>'}" class="w-20" />
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 py-2 text-gray-700 break-words max-w-x border border-gray-300 font-extralight">
                                    <div class="text-sm text-gray-900">${banner.title}</div>
                                </td>
                                

                                <td class="px-2 py-2 border text-gray-700 break-words max-w-x border-gray-300 w-20">
                                    <div class="text-sm text-gray-900">${banner.subtitle}</div>
                                </td>
                               
                                <td class="px-2 py-2  text-center text-sm font-medium border border-gray-300">
                                    <a onclick="openBannerModal('${banner.encrypted_id}')" class="!text-blue-600 !no-underline hover:text-blue-800 mr-3">Edit</a>
                                    <button type="button" onclick="deleteBanner(this)" data-id="${banner.encrypted_id}" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors removeRow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-4 h-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line>
                                        </svg>
                                    </button>
                                </td>
                              
                            </tr>`;
                    });
                    

                    html += `</tbody></table>`;
                     // Pagination controls
                    let totalPages = Math.ceil(results.length / rowsPerPage);
                    html += `
                        <div class="flex justify-between items-center mt-4">
                            <div>
                                <label class="mr-2">Rows per page:</label>
                                <select onchange="changeRowsPerPage(this.value)" class="px-2 py-1 border rounded">
                            
                                    <option value="10" ${rowsPerPage == 10 ? 'selected' : ''}>10</option>
                                    <option value="20" ${rowsPerPage == 20 ? 'selected' : ''}>20</option>
                                    <option value="50" ${rowsPerPage == 50 ? 'selected' : ''}>50</option>
                                    <option value="100" ${rowsPerPage == 100 ? 'selected' : ''}>100</option>
                                </select>
                            </div>
                            <div>
                                <button onclick="prevPage()" ${currentPage === 1 ? 'disabled' : ''} class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50">Prev</button>
                                <span class="mx-2">Page ${currentPage} of ${totalPages}</span>
                                <button onclick="nextPage(${totalPages})" ${currentPage === totalPages ? 'disabled' : ''} class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50">Next</button>
                            </div>
                        </div>`;
                }
                $('#productsTable').html(html);
            }
            loadProducts();

            $('#searchProductInput').on('input',function(){
                let value = $(this).val();
                loadProducts(value);
            })
            $('#filerProductStatus').on('change',function(){
                let value = $('#searchProductInput').val();
               loadProducts(value);
            })

            
// Change rows per page
function changeRowsPerPage(value) {
    rowsPerPage = parseInt(value);
    currentPage = 1;
    renderTable(allBanner);
}

// Pagination functions
function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        renderTable(allBanner);
    }
}
function nextPage(totalPages) {
    if (currentPage < totalPages) {
        currentPage++;
        renderTable(allBanner);
    }
}


//$(document).on('submit', '#createSale', function(e) {
  $('#bannerForm').on('submit', function(e) {
    let modal =  $('#bannerModal');
    const previewImg = $('#previewImg');
    let webForm = $('#bannerForm');
    e.preventDefault();
    const formData = new FormData(this);
    e.preventDefault();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#submitBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );
    $.ajax({
        url : '<?=base_url('admin/banner/save');?>',
        method:'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType : 'json',

        success:function(response)
        { 
           
            if(response.success){
                toastr.success(response.message);
                webForm[0].reset();
                modal.addClass('hidden');
                previewImg.attr('src', '');
                $('#edit_id').val('');
                loadProducts();
            }else{
                if(response.errors){
                    $.each(response.errors,function(field,message)
                    {
                        $('#'+ field).addClass('is-invalid');
                        $('#' + field + '_error').text(message.replaceAll('_',' '));
                    })
                }else{
                     toastr.error(response.message);
                }
            }
        },error: function() {
            toastr.error('An error occurred while saving ');
        },
        complete: function() {
            // Re-enable submit button
            $('#submitBtn').prop('disabled', false).text('Save ');
        }
    })
})

function deleteBanner(e){
    let id = $(e).data('id');
    if(confirm('are you sure You want to Delete This')) {
        if(id) {
            $.ajax({
                 url : App.getSiteurl()+'admin/banner/delete/'+ id,
                type: "DELETE",
                dataType: 'json',
                success:function(response)
                { 
                   if(response.success){
                     Swal.fire({  title: "Done!",  text:response.message,  icon: "success"});
                     loadProducts();
                   }else{
                     Swal.fire({  title: "Oops!",  text:response.message,  icon: "error"});
                   }
                }
            })
        }else{
             toastr.error('OOps Item Not Found !Pls try later', 'Error', { 
                allProductstimeOut: 10000,        
                extendedTimeOut: 5000, 
                closeButton: true,     
                progressBar: true      
            });
        }
    }
}


        
    </script>
<?= $this->endSection() ?>

