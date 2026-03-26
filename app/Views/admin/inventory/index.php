<?= $this->extend('template/layout/main') ?>

<?= $this->section('content') ?>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- titilebar -->
    <div class="flex items-center justify-between">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-0">
                <h1 class="h3 mb-0"><?= $page ?? '' ?></h1>
                <?php
                if(haspermission('','purchase')) { ?>
                <div>
                    <button id="inventoryBtn" class="flex items-center space-x-2 px-4 py-2 bg-green-600 text-white !rounded-lg hover:bg-green-700 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart w-4 h-4"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg><span>New Order</span></button>
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
                <input type="text" id="searchInput" placeholder="Search Invoice Number , Supplier Name or Items..." class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
               <i class="bi bi-calendar"></i>
                </div>
                <input type="text" id="filterDate" placeholder="Filter by date" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>
            
            <!-- Column 2: Status Dropdown -->
            <div class="w-full md:w-48">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter text-gray-400">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    </div>
                    <select id="filerStatus" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                    <option value="all">Account Status</option>
                    <option value="paid">Paid</option>
                    <!-- <option value="on leave">On Leave</option> -->
                    <option value="credit">Credit</option>
                    </select>
                </div>
            </div>
            </div>
            <!-- table -->
             <div class="overflow-x-auto">
                <div id="inventoryTable"></div>
            </div>
            <!-- close table -->
</div><!-- body -->



<?= view('modal/inventoryModal'); ?>
<?= view('modal/purchaseorderModal'); ?>

<?= $this->endSection(); ?>
<?= $this->section('scripts') ?>

<!--  -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!--  -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script src="<?=base_url('public/assets/js/nice-select.js');?>"></script>
<script src="<?=base_url('public/assets/js/sweetalert.js');?>"></script>
<script src="<?=base_url('public/assets/js/inventory.js');?>"></script>

    <script>
        //$(document).ready(function() {

let currentPage = 1;
let rowsPerPage = 50; // default rows per page
let allProducts = []; // store products globally

function renderTable(products) {
    allProducts = products; // save globally
    let html = '';

    if (products.length === 0) {
        html += `
            <div class="text-center py-8">
                <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                <p class="text-gray-500 mt-1">Try adjusting your search</p>
            </div>
        `;
    } else {
        // Pagination calculation
        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        let paginatedProducts = products.slice(start, end);

        html += `
            <table class="border-collapse border min-w-full divide-y divide-gray-200 border rounded-md">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">S/o</th>
                        <th class="px-4 py-3">Invoice No</th>
                        <th class="px-4 py-3">Order Date</th>
                        <th class="px-4 py-3">Supplier</th>
                        <th class="px-4 py-3">Payment Status</th>
                        <th class="px-4 py-3">Items</th>
                        <th class="px-4 py-3">Total Amount</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
        `;

        let i = start + 1;
        paginatedProducts.forEach(product => {
            let joinedDate = new Date(product.order_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });

            html += `
                <tr class="hover:bg-gray-50">
                    <td class="px-2 py-2 border">${i++}</td>
                    <td class="px-2 py-2 border">${product.inoicenumber}</td>
                    <td class="px-2 py-2 border">${joinedDate}</td>
                    <td class="px-2 py-2 border">${product.supplier}</td>
                    <td class="px-2 py-2 border">
                        ${product.payment === 'paid'
                            ? `<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Paid</span>`
                            : (product.payment == 'credit' ? `<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Credit</span>` : `<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Pending</span>`) }
                    </td>
                    <td class="px-2 py-2 relative border border-gray-300">
                        <div class="text-xs text-gray-500"> `;
                                let items = product.items;
                                    if(items){
                                        html += `<div> ${items.length} Items </div>`
                                        items.slice(0,5).map(item => {
                                        //items.forEach(item => {
                                            html += `<div> ${item.quantity} x ${item.product} (${item.sku}) </div>`
                                        }).join('');
                                        html += items.length > 5 ? `<div class="absolute top-0 mt-2 mr-2 bottom-0 right-0 rounded-full overflow-hidden bg-blue-100 flex items-center justify-center w-10 h-10 text-xs border-2 bg-gray-200 border-white">
                                <span class="text-gray-700 font-semibold">+${items.length - 5}</span>
                        </div>`:'';
                                    }
                                    
                    html +=` </div></td>
                    <td class="px-2 py-2 border font-semibold">${product.totalAmount}</td>
                     <td class="px-2 py-2 whitespace-nowrap text-center text-sm font-medium border border-gray-300">
                                   <div class="flex gap-2">
                                     <button onclick="purchaseDetails(this)" data-id="${product.orderId}" class="text-blue-600 hover:text-blue-900 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye w-4 h-4"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                                     <?php
                                     if(hasPermission('','edit_purchase')){?>
                                    <a href="<?=base_url('inventory/edit/');?>${product.orderId}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen h-4 w-4" data-lov-id="src/components/TaskCard.tsx:112:12" data-lov-name="Edit" data-component-path="src/components/TaskCard.tsx" data-component-line="112" ><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path></svg></a>
                                    <?php } ?>
                                   </div>
                                </td>
                </tr>
            `;
        });

        html += `</tbody></table>`;

        // Pagination controls
        let totalPages = Math.ceil(products.length / rowsPerPage);
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

    $('#inventoryTable').html(html);
}

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
  $('#searchInput').on('input',function(){
    let value = $(this).val();
    loadInventory(value);
})
$('#filerStatus').on('change',function(){
    let value = $('#searchInput').val();
    loadInventory(value);
})
loadInventory();
// AJAX load function
function loadInventory(search = '', startDate ='', endDate='') {
    let filter = $('#filerStatus').val();
    $.ajax({
        url: "<?= site_url('admin/inventory-list') ?>",
        type: "POST",
        data: { search: search, filter: filter, startDate: startDate, endDate: endDate },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                currentPage = 1; // reset page
                renderTable(response.products);
            }
        }
    });
}
       // });
    </script>
<?= $this->endSection() ?>

