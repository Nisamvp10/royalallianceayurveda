<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use App\Models\Salesmodel;
use App\Models\SaleItemModel;
use App\Models\PurchaseOrderItemModel;
class SalesController extends Controller {
    protected $productModel;
    protected $salesModel;
    protected $saleItemModel;
    protected $purchaseItemModel;
    function __construct() {
        $this->productModel = new ProductModel();
        $this->salesModel = new Salesmodel();
        $this->saleItemModel = new SaleItemModel();
        $this->purchaseItemModel = new PurchaseOrderItemModel();
    }

    public function index() {
        $page = (!hasPermission('','sales') ? lang('Custom.permissionDenied') :'Sales');
        $route = (!hasPermission('','sales') ?'pages-error-404' :'admin/sales/index');
        $products = $this->productModel->where(['status'=>1,'current_stock >'=>0])->findAll();
        return view($route,compact('page','products'));
    }
    public function save()
    {
        if (!hasPermission('', 'sales')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => lang('Custom.permissionDenied')
            ]);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => lang('Custom.invalidRequest')
            ]);
        }

        // ---------- Validate main sale fields ----------
        $rules = [
           // 'customer_name'  => 'required|min_length[2]',
            'sale_date'      => 'required|valid_date[Y-m-d]',
            //'payment_status' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors()
            ]);
        }

        // ---------- Collect item inputs ----------
        $categories = $this->request->getPost('category');
        $quantities = $this->request->getPost('quantity');
        $prices     = $this->request->getPost('price');
        $sale_date      = $this->request->getPost('sale_date');

        $errors = [];
        foreach ($categories as $i => $cat) {
            if (empty($cat)) {
                $errors["category.$i"] = "Category is required.";
            }
            if (empty($quantities[$i])) {
                $errors["quantity.$i"] = "Quantity is required.";
            }
            // if (empty($prices[$i])) {
            //     $errors["price.$i"] = "Price is required.";
            // }
        }

        if (!empty($errors)) {
            return $this->response->setJSON([
                'success'     => false,
                'item_errors' => $errors
            ]);
        }

        // ---------- Generate invoice number ----------
        $lastNumber = 1;
        $datePart   = date('ymd');

        $builder = $this->salesModel
            ->like('invoice_number', $datePart, 'after')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get();

        if ($builder->getNumRows() > 0) {
            $lastInvoice = $builder->getRow()->invoice_number;
            $lastNumber  = (int) substr($lastInvoice, -3);
            $lastNumber++;
        }

        $invoice_no = 'INV' . $datePart . '-' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

        // ---------- Prepare data ----------
        $customerName   = $this->request->getPost('customer_name') ?? 'SANA FRESH';
       $payment_status = $this->request->getPost('payment_status') ?? 'Paid';

        $purchase_order_items = [];
        $total_amount = 0;
        $messages = [];

        // ---------- Loop through items ----------
        foreach ($categories as $i => $item) {
            $productInfo = $this->productModel->where('id',$item)->get()->getRow();
            $unitPrice = $this->purchaseItemModel->select('price')->where(['product_id' => $item,'purchaseItem_at <=' => $sale_date])->orderBy('id desc')->first();
            if(!empty($unitPrice)) {

          
            $prices = $unitPrice['price'];
            if ($productInfo->current_stock >= $quantities[$i]) {
                // enough stock
                $piceRate = ($prices * $quantities[$i]);
                $total_amount +=  $quantities[$i] * $prices;
                $purchase_order_items[] = [
                    'product_id' => $item,
                    'quantity'   => $quantities[$i],
                    'unit_price' => round($prices,2),
                    'total'      => round(($prices * $prices),2),
                ];
            } else {
                // low stock message
                $messages[] = "The Item <b>" . $productInfo->product_name .
                            "</b> has low stock (Available: " . $productInfo->current_stock . ")";
            }
        }else{
              return $this->response->setJSON([
                'success' => false,
                'message' => 'Price not valid'
            ]);
        }
        }

        // ---------- If low stock → stop here ----------
        if (!empty($messages)) {
            return $this->response->setJSON([
                'success'  => false,
                'messages' => $messages
            ]);
        }

        // ---------- Insert Sale ----------
        $salesData = [
            'invoice_number' => $invoice_no,
            'customer_name'  => $customerName,
            'sale_date'      => $sale_date,
            'payment_status' => $payment_status,
            'total_amount'   => $total_amount,
            'note'           => $this->request->getPost('note'),
            'status'         => 2,
            'created_by'     => session('user_data')['id'],
        ];

        $saleId = $this->salesModel->insert($salesData, true);

        if ($saleId) {
            // ---------- Insert Sale Items + Update Stock ----------
            foreach ($purchase_order_items as &$itms) {
                $getStock = $this->productModel->find($itms['product_id']);
                $data = [
                    'current_stock' => $getStock['current_stock'] - $itms['quantity'],
                ];
                $this->productModel->update($itms['product_id'], $data);

                $itms['sale_id'] = $saleId;
            }

            $this->saleItemModel->insertBatch($purchase_order_items);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully Saled'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => '!Oops Something went wrong, try again'
            ]);
        }
    }

    function list() {

        if(!hasPermission('','inventory')) {
            return $this->response->setJSON(['success' => false ,'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false,'message' => lang('Custom.invalidRequest')]);
        }
        $filter = $this->request->getPost('filter');
        $searchInput = $this->request->getPost('search');
        $startDate = $this->request->getPost('startDate');
        $endDate = $this->request->getPost('endDate');
        $orderId = decryptor($this->request->getPost('id'));
        $purchaseInvoice = $this->salesModel->salesHistory($searchInput,$filter,$startDate,$endDate,$orderId);
        $purchaseHistory = [];
        //echo  $this->purchaseModel->getLastQuery();
        foreach ($purchaseInvoice as &$purchase) {
            $purchaseOrderId = $purchase['id'];
            if(!isset($purchaseHistory[$purchaseOrderId])) {
                $purchaseHistory[$purchaseOrderId] = [
                    'orderId'   => encryptor($purchaseOrderId),
                    'inoicenumber'  => $purchase['invoice_number'],
                    'sale_date'     => $purchase['sale_date'],
                    'payment'       => $purchase['payment_status'],
                    'note'          => $purchase['note'],
                    'customer'      => $purchase['customer_name'],
                    'totalAmount'  => $purchase['total_amount'],
                    'items'         => []
                ];
                if(!empty($purchase['product_name'])) {
                    $purchaseHistory[$purchaseOrderId]['items'][] = [
                        'product'   => $purchase['product_name'],
                        'sku'       => $purchase['sku'],
                        'price'     => $purchase['unit_price'],
                        'quantity'  => $purchase['quantity'],
                        'total'     => $purchase['total'],
                    ];
                }
            }else{
                if(!empty($purchase['product_name'])) {
                    $purchaseHistory[$purchaseOrderId]['items'][] = [
                        'product'   => $purchase['product_name'],
                        'sku'       => $purchase['sku'],
                        'price'     => $purchase['unit_price'],
                        'quantity'  => $purchase['quantity'],
                        'total'     => $purchase['total'],
                    ];
                }
            }
        }

        $result = array_values($purchaseHistory);
        return $this->response->setJSON(['success' => true,'products' => $result]);
    }

    function edit($id=false) {

        $saleId = decryptor($id);
    
        $page = (!hasPermission('','edit_sale') ? lang('Custom.permissionDenied') : 'Edit Sale');
        $route = (hasPermission('','edit_sale') ? 'admin/sales/create' : 'pages-error-404');
        $products = $this->productModel->where('status',1)->findAll();

        $purchaseInvoice = $this->salesModel->salesHistory('','','','',$saleId);
        $purchaseHistory = [];
        //echo  $this->salesModel->getLastQuery();
        foreach ($purchaseInvoice as &$purchase) {
            $purchaseOrderId = $purchase['id'];
            if(!isset($purchaseHistory[$purchaseOrderId])) {
                $purchaseHistory[$purchaseOrderId] = [
                    'orderId'   => encryptor($purchaseOrderId),
                    'inoicenumber'  => $purchase['invoice_number'],
                    'customer_name' => $purchase['customer_name'],
                    'sale_date'     => $purchase['sale_date'],
                    'payment'       => $purchase['payment_status'],
                    'note'          => $purchase['note'],
                    'customer'      => $purchase['customer_name'],
                    'totalAmount'  => $purchase['total_amount'],
                    'items'         => []
                ];
                if(!empty($purchase['product_name'])) {
                    $purchaseHistory[$purchaseOrderId]['items'][] = [
                        'saleId'    => $purchase['saleId'],
                        'product'   => $purchase['product_name'],
                        'productId'   => $purchase['productId'],
                        'sku'       => $purchase['sku'],
                        'price'     => $purchase['unit_price'],
                        'quantity'  => $purchase['quantity'],
                        'total'     => $purchase['total'],
                    ];
                }
            }else{
                if(!empty($purchase['product_name'])) {
                    $purchaseHistory[$purchaseOrderId]['items'][] = [
                        'saleId'    => $purchase['saleId'],
                        'product'   => $purchase['product_name'],
                        'productId'   => $purchase['productId'],
                        'sku'       => $purchase['sku'],
                        'price'     => $purchase['unit_price'],
                        'quantity'  => $purchase['quantity'],
                        'total'     => $purchase['total'],
                    ];
                }
            }
        }
        $result = array_values($purchaseHistory);
        return view($route,compact('page','products','result'));
    }

    function saleUpdate() {
         if (!hasPermission('', 'sales')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => lang('Custom.permissionDenied')
            ]);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => lang('Custom.invalidRequest')
            ]);
        }

        // ---------- Validate main sale fields ----------
        $rules = [
            'customer_name'  => 'required|min_length[2]',
            'sale_date'      => 'required|valid_date[Y-m-d]',
            'payment_status' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors()
            ]);
        }

        // ---------- Collect item inputs ----------
        $categories = $this->request->getPost('category');
        $quantities = $this->request->getPost('quantity');
        $prices     = $this->request->getPost('price');
        $itemsId    = $this->request->getPost('itemsId');
        $mastersaleId = decryptor( $this->request->getPost('mastersaleId'));  

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
                'success'     => false,
                'item_errors' => $errors
            ]);
        }
      $totalAmount = 0.0;

        foreach($categories as $index => $productId) {

            $qty   = (float) $quantities[$index];
            $price = (float) $prices[$index];
            $lineTotal = $qty * $price;
            $totalAmount += $lineTotal;

            $saleItmId = $itemsId[$index] ?? null; // if not exists, it's a new item

            if ($saleItmId) {
                
                $oldItem = $this->saleItemModel->find($saleItmId);
                $oldQty  = (float)$oldItem['quantity'];

               if ($qty != $oldQty || $productId != $oldItem['product_id']) {
                    $diff = $qty - $oldQty; // positive = need more stock, negative = return stock

                    if ($diff > 0) {
                        // Need extra stock
                        $currentStock = $this->productModel->find($productId)['current_stock'];
                         $productInfo = $this->productModel->find($productId);
                        if ($currentStock < $diff) {
                            return $this->response->setJSON([
                                'success' => false,
                                'message' => "Not enough stock for product ".$productInfo['product_name']
                            ]);
                        }
                        $this->productModel->update($productId, [
                            'current_stock' => $currentStock - $diff
                        ]);
                    } else {
                        // Return stock
                        $this->productModel->where('id', $productId)
                                        ->set('current_stock', "current_stock + " . abs($diff), false)
                                        ->update();
                    }

                    // Update sale item
                    $this->saleItemModel->update($saleItmId, [
                        'quantity'   => $qty,
                        'product_id' => $productId,
                        'unit_price' => $price,
                        'total'      => $lineTotal,
                    ]);
                }

            } else {
                // New Item Added
                $currentStock = $this->productModel->find($productId)['current_stock'];
                if ($currentStock < $qty) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => "Not enough stock for product ID $productId"
                    ]);
                }

                // Deduct stock
                $this->productModel->update($productId, [
                    'current_stock' => $currentStock - $qty
                ]);

                // Insert new sale item
                $this->saleItemModel->insert([
                    'sale_id'    => $mastersaleId,
                    'product_id' => $productId,
                    'quantity'   => $qty,
                    'unit_price' => $price,
                    'total'      => $lineTotal,
                ]);
            }
        }

        // Update master sale
        $purchaseHistory = [
            'customer_name' => $this->request->getPost('customer_name'),
            'sale_date'     => $this->request->getPost('sale_date'),
            'payment_status'=> $this->request->getPost('payment_status'),
            'note'          => $this->request->getPost('note'),
            'total_amount'  => $totalAmount,
        ];
        $this->salesModel->update($mastersaleId, $purchaseHistory);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Sale updated and stock adjusted successfully'
        ]);
    }

}