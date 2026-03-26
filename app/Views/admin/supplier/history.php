<?= $this->extend('template/layout/main') ?>
<?= $this->section('content') ?>

    <!-- titilebar -->
    <div class="flex items-center justify-between w-full mb-4">
        <div class="flex items-center space-x-3">
                  <a href="<?=base_url('admin/supplier');?>" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left text-gray-500">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
                </svg>
            </a> 
            <h1 class="h3 mb-0"><?= $page ?? '' ?></h1>
        </div>
        <div class="d-flex gap-3" >
        <button class="btn btn-primary transition d-flex" >
             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
         viewBox="0 0 24 24" fill="none" stroke="currentColor" 
         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
         class="lucide lucide-dollar-sign">
        <line x1="12" y1="1" x2="12" y2="23"></line>
        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
    </svg> <span id="totalAmt" class="font-medium"></span></button>
      <button class="btn btn-primary transition d-flex justify-center items-center" onclick="downloadHistory()" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download w-4 h-4"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg><span class="font-medium"></span>Download</button>
      </div>
    </div><!-- closee titilebar -->

    <!-- body -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden p-4">
        <div class="flex  gap-4 mb-6">
    
            <!-- Column 1: Search Input -->
              <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
               <i class="bi bi-calendar"></i>
                </div>
                <input type="text" id="filterDate" placeholder="Filter by date" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>
            
            <!-- Column 2: Status Dropdown -->
         
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter text-gray-400">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    </div>
                    <select id="filerStatus" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                    <option value="all" selected>All Status</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="credit">Credit</option>
                    </select>
                </div>

                 <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter text-gray-400">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    </div>
                    <select id="paymentType" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                    <option value="all" selected>Payment Type</option>
                    <option value="bank">Bank</option>
                    <option value="cash">Cash</option>
                    </select>
                </div>
           
        
        </div>
         <div class="overflow-x-auto">
            <div id="historyTbl"></div>
        </div>
</div><!-- body -->
<?= $this->endSection(); ?>
<?= $this->section('scripts');?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?=base_url('public/assets/js/moment.min.js');?>"></script>
<script src="<?=base_url('public/assets/js/daterangepicker.min.js');?>"></script>
<script>

     $('#filterDate').daterangepicker({
        opens: 'left',
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear',
            format: 'DD-MM-YYYY'
        },
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });
    let fromDate = '';
    let toDate = '';
    // Apply event
    $('#filterDate').on('apply.daterangepicker', function(ev, picker) {
        let startDate = picker.startDate.format('YYYY-MM-DD');
        let endDate = picker.endDate.format('YYYY-MM-DD');
        $(this).val(startDate + ' to ' + endDate);
        fromDate = startDate;
        toDate = endDate;
        let search = $('#searchInput').val();
        loadHistory(search,startDate, endDate)     
    });

    $('#filerStatus,#paymentType').on('change',function(){
        let value = $('#searchInput').val();
        loadHistory(value,fromDate,toDate);
    })

    // Cancel event
    $('#filterDate').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        $('#results').empty();
    });
    

   loadHistory();
    function loadHistory(search = '', startDate ='', endDate='') {
        let filter = $('#filerStatus').val();
        let paymentType = $('#paymentType').val();
        $.ajax({
            url: "<?= site_url('admin/supplier/history-list') ?>",
            type: "POST",
            data: {id:'<?=$id;?>',startDate: startDate,filter:filter,endDate:endDate,paymentType:paymentType},
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    if(response.total) {
                          let subtotal = response.total;
                            $('#totalAmt').text(subtotal)
                    }else{
                         $('#totalAmt').text(0.00)
                    }
                    renderTable(response.history);
                }
            }
        });
    }
    let currentPage = 1;
    let rowsPerPage = 50;
    let historyStore = [];
    function renderTable(history) {
        let html ='';
        let table = $('#historyTbl');
        historyStore = history;
       
        if(history.length  === 0 ) {
             html += `<div class="text-center py-8">
                            <h3 class="text-lg font-medium text-gray-700">No History found</h3>
                            <p class="text-gray-500 mt-1">Try adjusting your search</p>
                        </div>`;
        }else{
            let start = (currentPage - 1) * rowsPerPage;
            let end  = start + rowsPerPage;
            let paginationHistory = historyStore.slice(start,end);
              html += `
            <table class="border-collapse border min-w-full divide-y divide-gray-200 border rounded-md text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">S/o</th>
                        <th class="px-4 py-3">Invoice No</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Payment Status</th>
                        <th class="px-4 py-3">Payment Type</th>
                        <th class="px-4 py-3">Total Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">`;
                let i= 1;
                paginationHistory.forEach(data => {
                    html += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-2 border">${i++}</td>
                            <td class="px-2 py-2 border">${data.invoice_number}</td>
                            <td class="px-2 py-2 border">
                                ${(data.payment_status == 'pending' ? 'Order Date : ' + data.order_date: (data.payment_status == 'paid' ? 'Order Date : ' + data.order_date + '<br>' + '<span class="  rounded-full text-green-800">Paid Date : ' + data.paid_date +'</span>':'Order Date : ' + data.order_date )) }
                            </td>
                           <td class="px-2 py-2 border">
                                    ${data.payment_status === 'paid'
                                ? `<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Paid</span>`
                                : (data.payment_status == 'credit' ? `<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Credit</span>` : `<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Pending</span>`) }
                            </td>
                             <td class="px-2 py-2 border">
                                    ${data.payment_type != 'pending'
                                ? `<span class="px-2 py-1 text-xs capitalize rounded-full bg-green-100 text-green-800"> ${data.payment_type}</span>`
                                : (data.payment_status == 'credit' ? `<span class="px-2 py-1 capitalize text-xs rounded-full bg-red-100 text-red-800">Pending</span>` : `<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Pending</span>`) }
                            </td>
                            <td class="px-2 py-2 border">${data.total_amount}</td>

                        </tr>
                    `;
                });
                 html += `</tbody></table>`;

        // Pagination controls
        let totalPages = Math.ceil(historyStore.length / rowsPerPage);
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
        table.html(html)
    }
// Change rows per page
function changeRowsPerPage(value) {
    rowsPerPage = parseInt(value);
    currentPage = 1;
    renderTable(historyStore);
}

// Pagination functions
function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        renderTable(historyStore);
    }
}

function nextPage(totalPages) {
    if (currentPage < totalPages) {
        currentPage++;
        renderTable(historyStore);
    }
}


function downloadHistory() {
    let dateBysort = $('#filterDate').val();
    console.log(dateBysort);
    let startDate ='';
    let endDate = '';
        if (dateBysort && dateBysort.includes(" to ")) {
            let parts = dateBysort.split(" to ");
             startDate = parts[0].trim(); 
             endDate = parts[1].trim();  
        }
        let paymentStatus = $('#filerStatus').val();
        let paymentType = $('#paymentType').val();
        let supplierId = "<?= $id ?>";  
        let url = App.getSiteurl() + 'admin/supplier-history?cus=' + supplierId + '&start=' + startDate + '&end=' + endDate + '&ptype=' + paymentType +'&pstatus=' + paymentStatus;
        window.open(url, '_blank');

}

</script>
<?= $this->endSection(); ?>