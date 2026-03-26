<?= $this->extend('template/layout/main') ?>

<?= $this->section('content') ?>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- titilebar -->
    <div class="flex items-center justify-between">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-0">
                <h1 class="h3 mb-0"><?= $page ?? '' ?></h1>
                <?php
                if(haspermission('','sales')) { ?>
                <div>
                   <button id="salesBtn" 
  class="flex items-center space-x-2 px-4 hidden py-2 bg-green-600 text-white !rounded-lg hover:bg-green-700">
  + New Sale
</button>
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
                    <option value="all">Payment Status</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="unpaid">Unpaid</option>
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
<?= view('modal/salesModal'); ?>
<?= view('modal/saleInfoModal'); ?>

<?= $this->endSection(); ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!--  -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!--  -->
<script src="<?=base_url('public/assets/js/sweetalert.js');?>"></script>
<script src="<?=base_url('public/assets/js/sales.js');?>"></script>

    <script>
        //$(document).ready(function() {
        let currentPage = 1;
        let rowsPerPage = 50;
        let allSales = [];

            function loadSales(search = '',startDate ='', endDate='') {
                let filter = $('#filerStatus').val();
                $.ajax({
                    url: "<?= site_url('admin/sales-list') ?>",
                    type: "POST",
                    data: { search: search,filter:filter,startDate:startDate,endDate:endDate },
                    dataType: "json",
                    success: function(response) {
                        
                        if (response.success) {
                            renderTable(response.products);
                        }
                    }
                });
            }

            function renderTable(products){
                allSales = products;
                let start = (currentPage - 1) * rowsPerPage;
                let end   = start + rowsPerPage;
                let paginationSales = products.slice(start,end);
                let html = '';

                if (products.length === 0) {
                    html += `
                        <div class="text-center py-8">
                            <h3 class="text-lg font-medium text-gray-700">No Data found</h3>
                            <p class="text-gray-500 mt-1">Try adjusting your search</p>
                        </div>
                    `;
                }else{
                    html += `
                        <table class="border-collapse border min-w-full !rounded-md divide-y divide-gray-200 no-underline border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">S/o</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                    `;
                     let i =1;
                    paginationSales.forEach(product => {
                       
                let joinedDate = new Date(product.sale_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                        let orderStatus = product.orderStatus == 'pending' ? `bg-yellow-100 text-yellow-800` : product.orderStatus == 'confirmed' ? `bg-green-100 text-green-800` : product.orderStatus == 'delivered' ? `bg-blue-100 text-blue-800` : product.orderStatus == 'cancelled' ? `bg-red-100 text-red-800` : `bg-gray-100 text-gray-800`;
                        html += `
                            <tr class="hover:bg-gray-50">
                             <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                                    <div class="text-sm text-gray-900">${i++}</div>
                                </td>
                                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                                    <div class="flex items-center">
                                        
                                        <div class="text-sm font-medium text-gray-900">${product.inoicenumber}</div>
                                    </div>
                                </td>
                                <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                                    <div class="text-sm text-gray-900">${joinedDate}</div>
                                </td>
                                 <td class="px-2 py-2 whitespace-nowrap border border-gray-300">
                                    <div class="text-sm text-gray-900">${product.customer}</div>
                                </td>
                                <td class="px-2 py-2 whitespace-nowrap  border border-gray-300">
                                    <div class="text-sm text-gray-900 capitalize">${product.payment == 'paid' ? `<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Paid</span>` :`<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">${product.payment}</span>`}</div>
                                </td>
                                <td class="px-2 py-2 whitespace-nowrap  border border-gray-300">
                                        
                                    <div class="text-sm text-gray-900 capitalize"><span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${orderStatus}">${product.orderStatus}</span></div>
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
                                <td class="px-2 py-2 whitespace-nowrap  border border-gray-300">
                                    <div class="text-sm font-semibold text-gray-900 capitalize">${product.totalAmount}</div>
                                </td>
                              
                             
                                <td class="px-2 py-2 whitespace-nowrap text-center text-sm font-medium border border-gray-300">
                                 <div class="flex gap-2">
                                       <button onclick="purchaseDetails(this)" data-id="${product.orderId}" class="text-blue-600 hover:text-blue-900 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye w-4 h-4"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                                    <?php if(hasPermission('','edit_sale')){?>
                                    <a href="<?=base_url('sale/edit/');?>${product.orderId}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen h-4 w-4" data-lov-id="src/components/TaskCard.tsx:112:12" data-lov-name="Edit" data-component-path="src/components/TaskCard.tsx" data-component-line="112" ><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path></svg></a>
                                    <?php } ?>
                                 </div>
                                </td>
                            </tr>
                        `;
                    });
                    

                    html += `</tbody></table>`;

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
                    i++;
                }
                $('#inventoryTable').html(html);
            }
            
            loadSales();

            $('#searchInput').on('input',function(){
                let value = $(this).val();
                loadSales(value);
            })
            $('#filerStatus').on('change',function(){
                let value = $('#searchInput').val();
                loadSales(value);
            })

            // Change rows per page
        function changeRowsPerPage(value) {
            rowsPerPage = parseInt(value);
            currentPage = 1;
            renderTable(allSales);
            
        }

        // Pagination functions
        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderTable(allSales);
            }
        }
        function nextPage(totalPages) {
            if (currentPage < totalPages) {
                currentPage++;
                renderTable(allSales);
            }
        }

       // });
    </script>
<?= $this->endSection() ?>

