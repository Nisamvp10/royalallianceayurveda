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
        $categories  = (array) $this->request->getPost('category');   
        $quantities  = (array) $this->request->getPost('quantity');   
        $prices      = (array) $this->request->getPost('price');      
        $itemsId     = (array) $this->request->getPost('itemsId');    
        $purchaseId  = (int)  $this->request->getPost('purchaseId');

        // Per-row validation
        $itemErrors = [];
        foreach ($categories as $i => $cat) {
            if (empty($cat))             { $itemErrors["category.$i"]  = "Category is required."; }
            if (!isset($quantities[$i]) || $quantities[$i] === '') { $itemErrors["quantity.$i"]  = "Quantity is required."; }
            if (!isset($prices[$i])     || $prices[$i] === '')     { $itemErrors["price.$i"]     = "Price is required."; }
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

        // Models (rename if yours differ)
        $purchaseModel      = $this->purchaseModel;        
        $purchaseItemModel  = $this->purchasedItemModel;   
        $salesItemModel     = $this->salesItemModel;       
        $productModel       = $this->productModel;         

       
        $planExisting = []; 
        $planNew      = []; 
        $proposedTotals = []; 
        $affectedProductIds = []; 

        // Seed proposedTotals with current total purchases per product we touch
        // (so multiple lines for the same product are accumulated correctly)
        $db = \Config\Database::connect();
        $db->transStart(); // start early; we’ll commit/rollback at the end

        foreach ($categories as $i => $productId) {
            
            $productId   = (int) $productId;
            $qty         = (float) $quantities[$i];
            $price       = (float) $prices[$i];
            $lineTotal   = $qty * $price;
            $total_amount += $lineTotal;

            // lazily load current total purchased once per product
            if (!array_key_exists($productId, $proposedTotals)) {
                $row = $purchaseItemModel->selectSum('quantity')
                                        ->where('product_id', $productId)
                                        ->get()->getRow();
                $currentTotalPurchased = (float) ($row->quantity ?? 0);
                $proposedTotals[$productId] = $currentTotalPurchased;
            }

            if (!empty($itemsId[$i])) {
                // Existing row – adjust proposed total by diff
                $piId = (int) $itemsId[$i];
                $existing = $purchaseItemModel->find($piId);
                if (!$existing) {
                    $db->transRollback();
                    return $this->response->setJSON(['success' => false, 'message' => "Purchase item not found (ID: $piId)."]);
                }
                $oldQty = (float) $existing['quantity'];

                $proposedTotals[$productId] += ($qty - $oldQty);

                $planExisting[] = [
                    'id'         => $piId,
                    'product_id' => $productId,
                    'quantity'   => $qty,
                    'price'      => $price,
                    'total'      => $lineTotal,
                ];
            } else {
                // New row – add to proposed total
                $proposedTotals[$productId] += $qty;

                $planNew[] = [
                    'purchase_order_id' => $purchaseId,
                    'product_id'        => $productId,
                    'quantity'          => $qty,
                    'price'             => $price,
                    'total'             => $lineTotal,
                ];
            }

            $affectedProductIds[$productId] = true;
        }

        // Validation: proposed total purchased must be >= total sold for each affected product
        $affectedIds = array_keys($affectedProductIds);
        if (!empty($affectedIds)) {
            // Get sold qty per affected product in one query
            $soldMap = [];
            $soldRows = $salesItemModel->select('product_id, SUM(quantity) as sold_qty')
                                    ->whereIn('product_id', $affectedIds)
                                    ->groupBy('product_id')
                                    ->get()->getResultArray();
            foreach ($soldRows as $r) {
                $soldMap[(int)$r['product_id']] = (float)$r['sold_qty'];
            }

            $negativeStocks = [];
            // foreach ($affectedIds as $pid) {
            //     $soldQty = $soldMap[$pid] ?? 0.0;
            //     $newPurchasedTotal = $proposedTotals[$pid]; // after this edit
            //     if ($newPurchasedTotal < $soldQty) {
            //         $product = $productModel->find($pid);
            //         $name = $product ? $product['product_name'] : "Product #$pid";
            //         $negativeStocks[] = [
            //             'stock_error' => "$name cannot be reduced below sold qty. Sold: $soldQty, proposed purchased total: $newPurchasedTotal."
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

        // Apply item updates
        foreach ($planExisting as $row) {
            $purchaseItemModel->update($row['id'], [
                'product_id' => $row['product_id'],
                'quantity'   => $row['quantity'],
                'price'      => $row['price'],
                'total'      => $row['total'],
                'purchaseItem_at' => $order_date,
            ]);
        }

        // Insert new items
        if (!empty($planNew)) {
            $purchaseItemModel->insertBatch($planNew);
        }

        // Recalculate and update current_stock for each affected product
        foreach ($affectedIds as $pid) {
            // total purchased
            $purchasedRow = $purchaseItemModel->selectSum('quantity')
                                            ->where('product_id', $pid)
                                            ->get()->getRow();
            $totalPurchased = (float) ($purchasedRow->quantity ?? 0);

            // total sold
            $soldRow = $salesItemModel->selectSum('quantity')
                                    ->where('product_id', $pid)
                                    ->get()->getRow();
            $totalSold = (float) ($soldRow->quantity ?? 0);

            $stock = $totalPurchased - $totalSold; // canonical
            if ($stock < 0) { $stock = 0; } // safety net (shouldn’t happen after validation)

            $productModel->update($pid, ['current_stock' => $stock]);
        }

        // Commit
        if ($db->transStatus() === false) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'DB error while updating purchase.'
            ]);
        }
        $db->transComplete();

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
        $product = $this->purchasedItemModel->where(['product_id' => $productId])->first();

        if ($product) {
            echo json_encode(['success' => true, 'price' => $product['price']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
        }
    }

    
}