function purchaseReport(search = '',startDate ='', endDate='') {
                let filter = $('#filerStatus').val();
                $.ajax({
                    url: App.getSiteurl() +'inventory-list',
                    type: "POST",
                    data: { search: search,filter:filter,startDate:startDate,endDate:endDate },
                    dataType: "json",
                    success: function(response) {
                        
                        if (response.success) {
                            renderPurchase(response.products);
                        }
                    }
                });
            }

            function renderPurchase(products){
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
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                    `;
                     let i =1;
                    products.forEach(product => {
                       
                let joinedDate = new Date(product.order_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });

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
                                    <div class="text-sm text-gray-900">${product.supplier}</div>
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
                    
                }
                $('#purchaseReport').html(html);
            }
            purchaseReport();

           