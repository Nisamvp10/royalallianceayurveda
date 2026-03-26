
            function loadSales(search = '',startDate ='', endDate='') {
                let filter = $('#filerStatus').val();
                $.ajax({
                    url: App.getSiteurl()+'sales-list',
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
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                    `;
                     let i =1;
                    products.forEach(product => {
                       
                let joinedDate = new Date(product.sale_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });

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
                                    <div class="text-sm text-gray-900 capitalize">${product.payment == 'paid' ? `<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Paid</span>` :`<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Credit</span>`}</div>
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
                              
                             
                               
                            </tr>
                        `;
                    });
                    

                    html += `</tbody></table>`;
                    i++;
                }
                $('#salesReport').html(html);
            }
            loadSales();

           function initDateRangePicker(selector, callback) {
                $(selector).daterangepicker({
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

                // Apply event
                $(selector).on('apply.daterangepicker', function(ev, picker) {
                    let startDate = picker.startDate.format('YYYY-MM-DD');
                    let endDate   = picker.endDate.format('YYYY-MM-DD');
                    $(this).val(startDate + ' to ' + endDate);

                    callback(startDate, endDate);
                });

                // Cancel event
                $(selector).on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
            }

            // 🔹 Initialize
            initDateRangePicker('#salesFilterDate', function(start, end){
                let search = $('#searchInput').val();
                loadSales(search, start, end);
            });

            initDateRangePicker('#inventoryFilterDate', function(start, end){
                let search = $('#searchInput').val();
                purchaseReport(search, start, end);
            });

   function saleReport(e) {
    let dateBysort = $('#salesFilterDate').val();

    if (dateBysort && dateBysort.includes(" to ")) {
        let parts = dateBysort.split(" to ");
        let startDate = parts[0].trim(); 
        let endDate = parts[1].trim();  

       let url = App.getSiteurl() + 'admin/sale-report?start=' + startDate + '&end=' + endDate;
       window.open(url,'_blank');

    } else {
        alert("Invalid date range format");
    }
}

   function purchaseReportExport(e) {
    let dateBysort = $('#inventoryFilterDate').val();

    if (dateBysort && dateBysort.includes(" to ")) {
        let parts = dateBysort.split(" to ");
        let startDate = parts[0].trim(); 
        let endDate = parts[1].trim();  

        let url = App.getSiteurl() + 'admin/purchase-report?start=' + startDate + '&end=' + endDate;
        window.open(url,'_blank');

    } else {
        alert("Invalid date range format");
    }
}

   function purchaseCustReport(e) {
    let dateBysort = $('#inventoryFilterDate').val();

    if (dateBysort && dateBysort.includes(" to ")) {
        let parts = dateBysort.split(" to ");
        let startDate = parts[0].trim(); 
        let endDate = parts[1].trim();  

       // window.location.href = App.getSiteurl() + 'admin/purchase-custom-report?start=' + startDate + '&end=' + endDate,'_blank';
       let url = App.getSiteurl() + 'admin/purchase-custom-report?start=' + startDate + '&end=' + endDate;
       window.open(url, '_blank');


    } else {
        alert("Invalid date range format");
    }
}

function stockReport(e) {
    let url  = App.getSiteurl() + 'admin/stock-report';
    window.open(url,'_blank');
}