<?php
namespace App\Controllers\admin;

use App\Models\ProductModel;
use CodeIgniter\Controller;
use App\Models\SupplierModel;
use App\Models\PurchaseOrderModel;
use App\Models\PurchaseOrderItemModel;
use App\Models\Salesmodel;
use App\Models\SaleItemModel;

class InventoryController extends Controller {
    protected $productModel;
    protected $supplierModel;
    protected $purchaseModel;
    protected $purchasedItemModel;
    protected $salesModel;
    protected $salesItemModel;
    function __construct() {
        $this->productModel = new ProductModel();
        $this->supplierModel = new SupplierModel();
        $this->purchaseModel = new PurchaseOrderModel();
        $this->purchasedItemModel = new PurchaseOrderItemModel();
        $this->salesModel = new Salesmodel();
        $this->salesItemModel = new SaleItemModel();
    }
    public function index() {
        $page = (!hasPermission('','purchase') ? lang('Custom.permissionDenied') : 'Purchase History');
        $pageRote = (!hasPermission('','purchase') ? 'pages-error-404': 'admin/inventory/index');
        $products = $this->productModel->where('status',1)->orderBy('product_name','ASC')->findAll();
        $suppliers = $this->supplierModel->where('status','active')->findAll();
        return view($pageRote,compact('page','products','suppliers'));
    }

    function edit($id) {
        $page = (!hasPermission('','edit_purchase') ? lang('Custom.permissionDenied') : 'Edit ');
        $pageRote = (!hasPermission('','purchase') ? 'pages-error-404': 'admin/inventory/create');
        $products = $this->productModel->where('status',1)->findAll();
        $suppliers = $this->supplierModel->where('status','active')->findAll();
        $purchaseInvoice = $this->purchaseModel->purchaseHistory('','','','',decryptor($id));
        $groupDataInventory = []; 
       
        
        if(!empty($purchaseInvoice)) {
            foreach ($purchaseInvoice as &$inventory) {
               $inventoryId = $inventory['id'];
               if(!isset($groupDataInventory[$inventoryId])) {
                $groupDataInventory[$inventoryId] = [
                    'orderId'   =>  $inventory['id'],
                    'supplier'  => $inventory['supplierId'],
                    'payment'   => $inventory['payment_status'],
                    'paid_date'   => $inventory['paid_date'],
                    'orderDate' => $inventory['order_date'],
                    'paymentType' => $inventory['payment_type'],
                    'note'      => $inventory['note'],
                    'tems'      => []
                ];

                if(!empty($inventory['product_name'])) {
                  $groupDataInventory[$inventoryId]['items'][] =[
                    'itemId'    => $inventory['pitemId'],
                    'productId' => $inventory['productId'],
                    'unitPrice' => $inventory['price'],
                    'quantity'  => $inventory['quantity'],
                    'product'  => $inventory['product_name'],
                  ];
                }
               }else{
                if(!empty($inventory['product_name'])) {
                    $groupDataInventory[$inventoryId]['items'][] =[
                        'itemId'    => $inventory['pitemId'],
                        'productId' => $inventory['productId'],
                        'unitPrice' => $inventory['price'],
                        'quantity'  => $inventory['quantity'],
                        'product'  => $inventory['product_name'],
                    ];
                }
               }
            }
        }
        $result = array_values($groupDataInventory);
        return view($pageRote,compact('page','products','suppliers','result'));
    }

    public function updateSave()
    {
        if (!hasPermission('', 'edit_purchase')) {
            return $this->response->setJSON(['success' => false, 'message' => lang('Custom.permissionDenied')]);
        }
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => lang('Custom.invalidRequest')]);
        }

        $rules = [
            'supplier'       => 'required|numeric',
            'purchase_date'  => 'required|valid_date[Y-m-d]',
            //'payment_status' => 'required',
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
        }

        // Incoming arrays
        $categories  = (array) $this->request->getPost('category');   // product ids (hidden IDs)
        $quantities  = (array) $this->request->getPost('quantity');   
        $prices      = (array) $this->request->getPost('price');      
        $itemsId     = (array) $this->request->getPost('itemsId');    
        $purchaseId  = (int)  $this->request->getPost('purchaseId');

        // Per-row validation
        $itemErrors = [];
        foreach ($categories as $i => $cat) {
            if (empty($cat)) { $itemErrors["category.$i"] = "Category is required."; }
            if (!isset($quantities[$i]) || $quantities[$i] === '') { $itemErrors["quantity.$i"] = "Quantity is required."; }
            if (!isset($prices[$i])     || $prices[$i] === '')     { $itemErrors["price.$i"]    = "Price is required."; }
        }
        if (!empty($itemErrors)) {
            return $this->response->setJSON(['success' => false, 'item_errors' => $itemErrors]);
        }

        $supplier       = (int) $this->request->getPost('supplier');
        $order_date     = $this->request->getPost('purchase_date');
        $payment_status = $this->request->getPost('payment_status');
        $paidDate       = $this->request->getPost('payment_date'); 
        $paymentType    = $this->request->getPost('payment_type'); 
        $note           = $this->request->getPost('note');
        $total_amount   = 0.0;

        // Models
        $purchaseModel      = $this->purchaseModel;        
        $purchaseItemModel  = $this->purchasedItemModel;   
        $salesItemModel     = $this->salesItemModel;       
        $productModel       = $this->productModel;         

        $planExisting = []; 
        $planNew      = []; 
        $proposedTotals = []; // keyed by product_id => total purchased after this change (not final stock)
        $affectedProductIds = []; // associative set

        $db = \Config\Database::connect();
        $db->transStart(); // open transaction

        // Build plans and proposed totals
        foreach ($categories as $i => $productId) {
            $productId = (int) $productId;
            $qty       = (float) $quantities[$i];
            $price     = (float) $prices[$i];
            $lineTotal = $qty * $price;
            $total_amount += $lineTotal;

            // Ensure proposedTotals seeded for this (new) product
            if (!array_key_exists($productId, $proposedTotals)) {
                $row = $purchaseItemModel->selectSum('quantity')
                                        ->where('product_id', $productId)
                                        ->get()->getRow();
                $currentTotalPurchased = (float) ($row->quantity ?? 0);
                $proposedTotals[$productId] = $currentTotalPurchased;
            }

            if (!empty($itemsId[$i])) {
                // Existing row being edited
                $piId = (int) $itemsId[$i];
                $existing = $purchaseItemModel->find($piId);
                if (!$existing) {
                    $db->transRollback();
                    return $this->response->setJSON(['success' => false, 'message' => "Purchase item not found (ID: $piId)."]);
                }

                $oldProductId = (int) $existing['product_id'];
                $oldQty       = (float) $existing['quantity'];

                // Make sure old product is seeded in proposedTotals and marked as affected
                if (!array_key_exists($oldProductId, $proposedTotals)) {
                    $row = $purchaseItemModel->selectSum('quantity')
                                            ->where('product_id', $oldProductId)
                                            ->get()->getRow();
                    $proposedTotals[$oldProductId] = (float) ($row->quantity ?? 0);
                }
                $affectedProductIds[$oldProductId] = true;
                $affectedProductIds[$productId] = true;

                if ($productId === $oldProductId) {
                    // same product → adjust by diff
                    $proposedTotals[$productId] += ($qty - $oldQty);
                } else {
                    // product changed → remove old qty from old product and add new qty to new product
                    $proposedTotals[$oldProductId] -= $oldQty;
                    // ensure key exists for new product (already seeded above, but double safe)
                    if (!array_key_exists($productId, $proposedTotals)) {
                        $row = $purchaseItemModel->selectSum('quantity')
                                                ->where('product_id', $productId)
                                                ->get()->getRow();
                        $proposedTotals[$productId] = (float) ($row->quantity ?? 0);
                    }
                    $proposedTotals[$productId] += $qty;
                }

                $planExisting[] = [
                    'id'         => $piId,
                    'product_id' => $productId,
                    'quantity'   => $qty,
                    'price'      => $price,
                    'total'      => $lineTotal,
                ];
            } else {
                // New row
                $proposedTotals[$productId] += $qty;
                $affectedProductIds[$productId] = true;

                $planNew[] = [
                    'purchase_order_id' => $purchaseId,
                    'product_id'        => $productId,
                    'quantity'          => $qty,
                    'price'             => $price,
                    'total'             => $lineTotal,
                    'purchaseItem_at'   => $order_date,
                ];
            }
        }

        // Validation: ensure proposed purchased totals are not less than sold quantity
        $affectedIds = array_keys($affectedProductIds);
        if (!empty($affectedIds)) {
            $soldRows = $salesItemModel->select('product_id, SUM(quantity) as sold_qty')
                                    ->whereIn('product_id', $affectedIds)
                                    ->groupBy('product_id')
                                    ->get()->getResultArray();

            $soldMap = [];
            foreach ($soldRows as $r) {
                $soldMap[(int)$r['product_id']] = (float)$r['sold_qty'];
            }

            $negativeStocks = [];
            
            // foreach ($affectedIds as $pid) {
            //     $soldQty = $soldMap[$pid] ?? 0.0;
            //     $newPurchasedTotal = $proposedTotals[$pid] ?? 0.0;
            //     if ($newPurchasedTotal < $soldQty) {
            //         $product = $productModel->find($pid);
            //         $name = $product ? $product['product_name'] : "Product #$pid";
            //         $negativeStocks[] = [
            //             'product_id' => $pid,
            //             'product_name' => $name,
            //             'sold' => $soldQty,
            //             'proposed_purchased_total' => $newPurchasedTotal,
            //             'message' => "$name cannot be reduced below sold qty. Sold: $soldQty, proposed purchased total: $newPurchasedTotal."
            //         ];
            //     }
            // }

            if (!empty($negativeStocks)) {
                $db->transRollback();
                return $this->response->setJSON([
                    'success' => false,
                    'stock_errors' => $negativeStocks
                ]);
            }
        }

        // Save purchase header
        $purchaseHeader = [
            'supplier_id'    => $supplier,
            'order_date'     => $order_date,
            'payment_status' => $payment_status,
            'paid_date'      => $paidDate,
            'total_amount'   => $total_amount,
            'payment_type'   => !empty($paymentType) ? $paymentType : 1,
            'note'           => $note,
            'status'         => 2,
            'updated_at'     => session('user_data')['id'] ?? null,
        ];
        $purchaseModel->update($purchaseId, $purchaseHeader);

        // Apply existing item updates
        foreach ($planExisting as $row) {
            $purchaseItemModel->update($row['id'], [
                'product_id' => $row['product_id'],
                'quantity'   => $row['quantity'],
                'price'      => $row['price'],
                'total'      => $row['total'],
                'purchaseItem_at' => $order_date,
            ]);
        }

        // Insert new items (if any)
        if (!empty($planNew)) {
            $purchaseItemModel->insertBatch($planNew);
        }

        // OPTIONAL: handle deleted items (items that belonged to this purchase but are not present in $itemsId).
        // If you want to allow deleting lines on edit, you should detect and remove those purchase_items and
        // mark their product IDs as affected so stock recalculation accounts for deletions.
        // Example:
        // $existingIdsForPurchase = array_column($purchaseItemModel->where('purchase_order_id', $purchaseId)->get()->getResultArray(), 'id');
        // $incomingIds = array_filter(array_map('intval', $itemsId));
        // $toDelete = array_diff($existingIdsForPurchase, $incomingIds);
        // if (!empty($toDelete)) { foreach ($toDelete as $delId) { $delRow = $purchaseItemModel->find($delId); $purchaseItemModel->delete($delId); $affectedProductIds[$delRow['product_id']] = true; } }

        // Recalculate and update current_stock for each affected product
        $affectedIds = array_keys($affectedProductIds);
        foreach ($affectedIds as $pid) {
            // total purchased after changes
            $pRow = $purchaseItemModel->selectSum('quantity')
                                    ->where('product_id', $pid)
                                    ->get()->getRow();
            $totalPurchased = (float) ($pRow->quantity ?? 0);

            // total sold
            $sRow = $salesItemModel->selectSum('quantity')
                                ->where('product_id', $pid)
                                ->get()->getRow();
            $totalSold = (float) ($sRow->quantity ?? 0);

            $stock = $totalPurchased - $totalSold;
            if ($stock < 0) { $stock = 0; } // safety

            $productModel->update($pid, ['current_stock' => $stock]);
        }

        // Complete transaction and check status
        $db->transComplete();
        if ($db->transStatus() === false) {
            // transaction failed
            return $this->response->setJSON([
                'success' => false,
                'message' => 'DB error while updating purchase.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Successfully Completed'
        ]);
    }



    function save() {
        if(!hasPermission('','purchase')) {
            return $this->response->setJSON(['success' => false,'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false,'message' => lang('Custom.invalidRequest')]);
        }

        $rules = [
            'supplier' => 'required|numeric',
            'purchase_date' => 'required|valid_date[Y-m-d]',
            //'payment_status' => 'required',
           
        ];
        if(!$this->validate($rules)) {
            return $this->response->setJSON(['success'=>false,'errors' => $this->validator->getErrors()]);
        }
        $categories = $this->request->getPost('category');
        $quantities = $this->request->getPost('quantity');
        $prices     = $this->request->getPost('price');

        $errors = [];

        foreach ($categories as $i => $cat) {
            if (empty($cat)) {
                $errors["category.$i"] = "Category is required.";
            }
            if (empty($quantities[$i])) {
                $errors["quantity.$i"] = "Quantity is required.";
            }
            if (empty($prices[$i])) {
                $errors["price.$i"] = "Price is required.";
            }
        }

        if (!empty($errors)) {
            return $this->response->setJSON([
                'success' => false,
                'item_errors'  => $errors
            ]);
        }

        $invoice_no = 'PO' . date('ymd') . '-' . strtoupper(substr(md5(uniqid()),0,3));
        $supplier   = $this->request->getPost('supplier');
        $order_date = $this->request->getPost('purchase_date');
        $paidDate = $this->request->getPost('payment_date');
        $payment_status = $this->request->getPost('payment_status');
        $paymentType    = $this->request->getPost('payment_type');
        $total_amount = 0;
        $purchase_order_items = [];
        $total_amount = 0;

        if (!empty($categories)) {
            foreach ($categories as $i => $item) {
                $piceRate = ($prices[$i] / $quantities[$i]);
                $total_amount += ($prices[$i] * $quantities[$i]);
                $purchase_order_items[] = [
                    'product_id'    => $item,
                    'quantity'      => $quantities[$i],
                    'remaining_qty' => $quantities[$i],
                    'price'         => $prices[$i],//$piceRate,
                    'total'         =>  ($prices[$i] * $quantities[$i]),//$total_amount,
                    'purchaseItem_at' => $order_date,
                ];
            }
        }

        $purchase_orders = [
            'invoice_number'    => $invoice_no,
            'supplier_id'       => $supplier,
            'order_date'        => $order_date,
            'paid_date'         => $paidDate,
            'payment_status'    => !empty($payment_status) ? $payment_status : 1,
            'total_amount'      => $total_amount,
            'note'              => $this->request->getPost('note'),
            'payment_type'      => !empty($paymentType) ? $paymentType : 1,
            'status'            => 2,
            'created_by'        => session('user_data')['id'],
        ];
        $purchaseId = $this->purchaseModel->insert($purchase_orders, true);

        if ($purchaseId) {
            foreach ($purchase_order_items as &$itms) {
                // stock update
                $getStock = $this->productModel->find($itms['product_id']); 
                $data = [
                    'current_stock'  => $getStock['current_stock'] + $itms['quantity'], 
                ];
                $this->productModel->update($itms['product_id'], $data);
                $itms['purchase_order_id'] = $purchaseId;
            }

            $this->purchasedItemModel->insertBatch($purchase_order_items);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully Purchased'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => '!Oops Something went wrong, try again'
            ]);
        }
    }

    function list() {

        if(!hasPermission('','purchase')) {
            return $this->response->setJSON(['success' => false ,'message' => lang('CUstom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false,'message' => lang('Custom.invalidRequest')]);
        }
        $filter = $this->request->getPost('filter');
        $searchInput = $this->request->getPost('search');
        $startDate = $this->request->getPost('startDate');
        $endDate = $this->request->getPost('endDate');
        $orderId = decryptor($this->request->getPost('id'));
        $purchaseInvoice = $this->purchaseModel->purchaseHistory($searchInput,$filter,$startDate,$endDate,$orderId);
        $purchaseHistory = [];
        //echo  $this->purchaseModel->getLastQuery();
        foreach ($purchaseInvoice as &$purchase) {
            $purchaseOrderId = $purchase['id'];
            if(!isset($purchaseHistory[$purchaseOrderId])) {
                $purchaseHistory[$purchaseOrderId] = [
                    'orderId'   => encryptor($purchaseOrderId),
                    'inoicenumber'  => $purchase['invoice_number'],
                    'order_date'    => $purchase['order_date'],
                    'payment'       => $purchase['payment_status'],
                    'note'          => $purchase['note'],
                    'supplier'      => $purchase['supplier_name'],
                    'totalAmount'  => $purchase['total_amount'],
                    'items'         => []
                ];
                if(!empty($purchase['product_name'])) {
                    $purchaseHistory[$purchaseOrderId]['items'][] = [
                        'product'   => $purchase['product_name'],
                        'sku'       => $purchase['sku'],
                        'price'     => $purchase['price'],
                        'quantity'  => $purchase['quantity'],
                        'stock'     => $purchase['current_stock'],
                        'total'     => $purchase['total'],
                    ];
                }
            }else{
                if(!empty($purchase['product_name'])) {
                    $purchaseHistory[$purchaseOrderId]['items'][] = [
                        'product'   => $purchase['product_name'],
                        'sku'       => $purchase['sku'],
                        'price'     => $purchase['price'],
                        'quantity'  => $purchase['quantity'],
                        'stock'     => $purchase['current_stock'],
                        'total'     => $purchase['total'],
                    ];
                }
            }
        }

        $result = array_values($purchaseHistory);
        return $this->response->setJSON(['success' => true,'products' => $result]);
    }
    public function getProductPrice()
    {
        $productId = $this->request->getPost('product_id');
        $saleQty   = (int) $this->request->getPost('sale_qty'); // optional: new sale qty

        // Get all purchase batches for this product (FIFO order)
        $purchases = $this->purchasedItemModel
            ->where('product_id', $productId)
            ->orderBy('purchaseItem_at', 'ASC')
            ->findAll();

        if (!$purchases) {
            echo json_encode([
                'success' => false,
                'message' => 'No purchase history found'
            ]);
            return;
        }

        // Get total sold quantity from sales table
        $saledItm = $this->salesItemModel
            ->selectSum('quantity', 'total_qty')
            ->where('product_id', $productId)
            ->get()
            ->getRow();

        $productStock = $this->productModel->where(['id' => $productId])->first();
        $currentStock = $productStock['current_stock'] ?? 0;

        $totalSoldQty = ($saledItm->total_qty ?? 0) + $saleQty; // include optional new sale

        $remainingStock = [];
        $soldQty = $totalSoldQty;

        // Deduct sold quantity from purchase batches (FIFO)
        foreach ($purchases as $purchase) {
            $qty   = $purchase['quantity'];
            $price = $purchase['price'];

            if ($soldQty >= $qty) {
                // This batch is fully sold
                $soldQty -= $qty;
            } else {
                // Partial batch left
                $rem = $qty - $soldQty;
                $remainingStock[] = [
                    'qty'   => $rem,
                    'price' => $price,
                    'value' => $rem * $price
                ];
                $soldQty = 0;
            }
        }

        // Calculate totals
        $totalQty   = array_sum(array_column($remainingStock, 'qty'));
        $totalValue = array_sum(array_column($remainingStock, 'value'));
        $avgPrice   = $totalQty > 0 ? ($totalValue / $totalQty) : 0;

        echo json_encode([
            'success'       => true,
            'avg_price'     => round($avgPrice, 2),
            'remaining_qty' => $totalQty,
            'stock_value'   => $totalValue,
            'sold_qty'      => $totalSoldQty,
            'batches'       => $remainingStock, // optional: for debug / batch view
             'stock'         => $currentStock,
        ]);
    }
    function getLastPurchasePrice() {
        if(!hasPermission('','purchase')) {
            return $this->response->setJSON(['success' => false ,'message' => lang('CUstom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false,'message' => lang('Custom.invalidRequest')]);
        }
        $rules = [
            'supplier_id' => 'required',
            'product_id'  => 'required',
        ];
        if(!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false,'errors' => $this->validator->getErrors()]);
            
        }
        
        $supplierId = $this->request->getPost('supplier_id');
        $producId   = $this->request->getPost('product_id');
        $productPrice = $this->purchaseModel->getLastPurchaseItemPrice($supplierId,$producId);
         if ($productPrice) {
            return $this->response->setJSON([
                'success'    => true,
                'last_price' => $productPrice->price
                ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No previous purchase found.'
            ]);
        }
    }
}
