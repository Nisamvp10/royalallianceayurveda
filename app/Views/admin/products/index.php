<?= $this->extend('template/layout/main') ?>
<?= $this->section('content') ?>
    <!-- titilebar -->
    <div class="flex items-center justify-between">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-0">
                <h1 class="h3 mb-0"><?= $page ?? '' ?></h1>
           
            </div>
        </div>
    </div><!-- closee titilebar -->

    <!-- body -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden p-4">
        <div class="flex flex-col md:flex-row gap-4 mb-6">
    
            <!-- Column 1: Search Input -->
             <!-- <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-calendar"></i>
                        </div>
                        <input type="date" id="saleDate" placeholder="Sale Date" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div> -->
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search text-gray-400">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                </div>
                <input type="text" id="searchProductInput" placeholder="Search branch by name, or location..." class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
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
                    <option value="all">All Stock</option>
                    <option value="1">low Stock</option>
                    <option value="2">Out of Stock</option>
                    </select>
                </div>
            </div>
            </div>
            <!-- table -->
             <div class="overflow-x-auto">
                <div id="productsTable"></div>
            </div>
            <!-- close table -->
</div><!-- body -->
<!-- productModal -->
 <?= view('modal/productModal');?>
 <?= view('modal/categoryModal');?>
 <!-- Cose Modal -->
<?= $this->endSection(); ?>
<?= $this->section('scripts') ?>
<script src="<?=base_url('public/assets/js/sweetalert.js');?>"></script>

<script src="<?=base_url('public/assets/js/dropdown.js');?>"></script>
<script src="<?=base_url('public/assets/js/category.js');?>"></script>
<script src="<?=base_url('public/assets/js/products.js');?>"></script>


<script>
        

  const openBtn = document.getElementById('openProductModal');
  const modal = document.getElementById('productModal');
  const closeBtn = document.getElementById('closeProductModal');
  const cancelBtn = document.getElementById('cancelProductModal');

  // Open modal
if (openBtn) {
  openBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
  });
}

  // Close modal
  function closeModal() {
    modal.classList.add('hidden');
  }

  closeBtn.addEventListener('click', closeModal);
  cancelBtn.addEventListener('click', closeModal);

  // Optional: close on background click
  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      closeModal();
    }
  });
  let currentPage = 1;
  let rowsPerPage = 50;
  let allProducts = [];

    //   
       // $(document).ready(function() {

            function loadProducts(search = '') {
                let filter = $('#filerProductStatus').val();
                $.ajax({
                    url: "<?= site_url('products/get-products') ?>",
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
                allProducts = results;
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
                        <table class="border-collapse border min-w-full divide-y divide-gray-200 no-underline border">
                            <thead class="bg-gray-100 border">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                     <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                     <?php
                                        if(hasPermission('','__sales')){ ?>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sold</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 p-3~">
                    `;
                    paginationProducts.forEach(product => {
              
                let joinedDate = new Date(product.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });

                        html += `
                            <tr class="hover:bg-gray-50">
                                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">${product.product_name}</div>
                                    </div>
                                </td>
                                <td class="px-2 py-2 whitespace-nowrap border border-gray-300 font-extralight">
                                    <div class="text-sm text-gray-900">${product.sku}</div>
                                </td>
                                   <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                                    <div class="text-sm ${
                                        Number(product.current_stock) === 0
                                        ? 'text-red-600'
                                        : (Number(product.current_stock) < Number(product.min_stock)
                                            ? 'text-orange-600 font-bold'
                                            : 'text-green-600 font-bold')
                                    }">
                                        ${
                                        Number(product.current_stock) === 0
                                            ? 'Out of Stock (Min: ' + product.min_stock + ')'
                                            : (Number(product.current_stock) < Number(product.min_stock)
                                                ? product.current_stock + ' Left'// (Min: ' + product.min_stock + ')'
                                                : product.current_stock + ' In Stock ')//(Min: ' + product.min_stock + ')'
                                        }
                                    </div>
                                </td>

                                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                                    <div class="text-sm text-gray-900">${product.category}</div>
                                </td>
                                 <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                                    <div class="text-sm text-gray-900">${product.note}</div>
                                </td>`;
                                <?php
                                if(hasPermission('','__sales')){ ?>
                                 html += `<td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                                    <div class="text-sm text-gray-900 d-flex">
                                    <form  id="createSale"> 
                                    <input type="hidden" id="category" value="${product.id}" name="category[]"  class="w-full px-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                                        <input type="number" step="0.01" name="quantity[]" id="quantity" class="pl-1 pr-1 py-2 w-full border border-gray-300  focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Item Quantity">
                                        <button type="submit" id="submitBtn" class="px-6 py-2 bg-blue-600 text-white  hover:bg-blue-700 transition-colors ">Save         </button>
                                    </form>
                                    </div>
                                </td>`;
                                <?php } ?>
                                  html += `
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
    renderTable(allProducts);
}

// Pagination functions
function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        renderTable(allProducts);
    }
}
function nextPage(totalPages) {
    if (currentPage < totalPages) {
        currentPage++;
        renderTable(allProducts);
    }
}


//$(document).on('submit', '#createSale', function(e) {
$(document).on('submit', 'form#createSale', function (e) {


        //let webForm = $('#createSale');
        let webForm = $(this); // the form that was submitted
        let clickedBtn = webForm.find('button[type="submit"]'); // the Save button of this row
        let originalText = clickedBtn.html();
        
        e.preventDefault();
        let formData = new FormData(this);
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty();
       let btn = webForm.find('button[type="submit"]');


            // Show spinner + disable button
            clickedBtn.prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );
        formData.append('sale_date', $('#saleDate').val());
        $.ajax({
            url : App.getSiteurl()+'sales/save',
            method:'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success:function(response)
            { 
            
                if(response.success){
                    toastr.success(response.message);
                    Swal.fire({  title: "Good job!",  text:response.message,  icon: "success"});
                    webForm[0].reset();
                    closeModal();
                    loadProducts();
                }else{
                    if(response.errors){
                        $.each(response.errors,function(field,message)
                        {
                            //console.log(field)
                            $('#'+ field).addClass('is-invalid');
                            $('#' + field + '_error').text(message);
                             toastr.error( message, 'Error', {
                                    timeOut: 10000,        
                                    extendedTimeOut: 5000, 
                                    closeButton: true,     
                                    progressBar: true      
                                });
                        })
                        
                    }else{
                        if (response.item_errors) {
                                $(".error-text").remove();

                                $.each(response.item_errors, function(field, message) {
                                      toastr.error(message, 'Error', {
                                                timeOut: 10000,        
                                                extendedTimeOut: 5000, 
                                                closeButton: true,     
                                                progressBar: true      
                                            });
                                    let parts = field.split(".");
                                    let fieldName = parts[0];   
                                    let index = parts[1];       

                                    if (typeof index !== "undefined") {
                                        let input = $("[name='" + fieldName + "[]']").eq(index);
                                        if (input.length > 0) {
                                            input.after('<span class="error-text text-danger">' + message + '</span>');
                                        }
                                    } else {
                                      
                                        let input = $("[name='" + fieldName + "']");
                                        if (input.length > 0) {
                                            input.after('<span class="error-text text-danger">' + message + '</span>');
                                            
                                        }
                                         
                                    }
                                });
                            } else if(response.messages) {
                                response.messages.forEach(msg => {
                                    toastr.error(msg, 'Error', {
                                    timeOut: 10000,        
                                    extendedTimeOut: 5000, 
                                    closeButton: true,     
                                    progressBar: true      
                                });
                                })
                            }else{
                                toastr.error(response.message);
                            }

                    }
                }
            },error: function() {
                toastr.error('An error occurred while saving Service');
            },
            complete: function() {
                // Re-enable submit button
                //$('#submitBtn').prop('disabled', false).text('Save');
                 clickedBtn.prop('disabled', false).html(originalText);
            }
        })
})

        
    </script>
<?= $this->endSection() ?>

