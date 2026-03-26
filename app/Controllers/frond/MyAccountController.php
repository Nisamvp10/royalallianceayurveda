<?php
namespace App\Controllers\frond;
use CodeIgniter\Controller;
use App\Models\UsersregistrationsModel;
use App\Models\CustomerOrderModel;
use App\Models\CustomerOrderItemsModel;
use App\Models\ShippingAddressModel;
use Mpdf\Mpdf;

class MyAccountController extends Controller
{
    protected $usersregistrationsModel;
    protected $customerOrdersModel;
    protected $customerOrderItemsModel;
    protected $shippingAddressModel;
    function __construct()
    {
        $this->usersregistrationsModel = new UsersregistrationsModel();
        $this->customerOrdersModel = new CustomerOrderModel();
        $this->customerOrderItemsModel = new CustomerOrderItemsModel();
        $this->shippingAddressModel = new ShippingAddressModel();
    }
    public function index()
    { 
        $page = 'my-account';
        $thisUser = session('user');
        $userData = $this->usersregistrationsModel->select('id,name,phone,email')->where('id', $thisUser['userId'])->get()->getRow();
        $recentOrders = $this->customerOrdersModel->select('customer_orders.*,COUNT(coi.id) as total_items')
        ->where('user_id', $thisUser['userId'])->orderBy('id', 'DESC')
        ->join('customer_orders_items as coi','coi.customer_order_id = customer_orders.id','left')
        ->groupBy('customer_orders.id')
        ->findAll(8);
        $orders = $this->customerOrdersModel->select('customer_orders.*,COUNT(coi.id) as total_items')
        ->where('user_id', $thisUser['userId'])->orderBy('id', 'DESC')
        ->join('customer_orders_items as coi','coi.customer_order_id = customer_orders.id','left')
        ->groupBy('customer_orders.id')
        ->findAll();
        $defaultSHippingAddress = $this->shippingAddressModel->where('user_id', $thisUser['userId'])->where('is_default', 1)->get()->getRow();
        return view('frontend/myaccount/index',compact('userData','recentOrders','orders','defaultSHippingAddress','page'));
    }

    public function myDataupdate() {
        $thisUser = session('user');
        $userId = $thisUser['userId'];
         $rules = [
            'name' => 'required|min_length[2]',
            'phone' => "required|numeric|exact_length[10]|is_unique[usersregistrations.phone,id,{$userId}]",
        ];

        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }

         $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];
        $userModel = new UsersregistrationsModel();
        if($userModel->update($userId,$data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Your data Updated successfully',
            ]); 
        }else{
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Oops Please try later',
            ]);
        }
    }
    public function changePassword() {
        $thisUser = session('user');
        $userId = $thisUser['userId'];
         $rules = [
            'currentPassword' => 'required',
            'newPassword' => 'required|min_length[6]',
            'confirmPassword' => 'required|matches[newPassword]',
        ];

        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $userModel = new UsersregistrationsModel();
        $user = $userModel->where('id', $userId)->get()->getRow();
        if(!password_verify($this->request->getPost('currentPassword'), $user->password)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => ['currentPassword' => 'Current password is incorrect'],
            ]);
        }

         $data = [
            'password' => password_hash($this->request->getPost('newPassword'), PASSWORD_DEFAULT),
        ];
        $userModel = new UsersregistrationsModel();
        if($userModel->update($userId,$data)) {
            $this->sendOrderMail($userId);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Your password Updated successfully',
            ]); 
        }else{
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Oops Please try later',
            ]);
        }
    }

    private function sendOrderMail($userId){
        $emailService = \Config\Services::email();
        $user = $this->usersregistrationsModel->where('id', $userId)->get()->getRow();
        
        $emailService->setTo($user->email);
        $emailService->setSubject('Your Password Changed');
        $emailService->setMessage(
            'Hello ' . $user->name . ',<br><br>' .
            'Your password has been changed successfully.<br><br>' .
            'Thank you for using our service.'
        );
        $emailService->send();
    }
    function invoice($orderId){
        $thisUser = session('user');
        $userId = $thisUser['userId'];
        if(!$userId){
            return redirect()->to(base_url('my-account'));
        }
        $orderId = $orderId;
        $purchaseInvoice = $this->customerOrdersModel->salesHistory(null,null,null,null,null,$orderId);

        $purchaseHistory = [];
        $invoiceNo = '';
        foreach ($purchaseInvoice as &$purchase) {
            $purchaseOrderId = $purchase['orderId'];
            if(!isset($purchaseHistory[$purchaseOrderId])) {
                $invoiceNo = $purchase['order_number'];
                $purchaseHistory[$purchaseOrderId] = [
                    'orderId'   => encryptor($purchaseOrderId),
                    'inoicenumber'  => $purchase['order_number'],
                    'orderDate'     => $purchase['orderDate'],
                    'payment'       => $purchase['payment_status'],
                    'orderStatus'   => $purchase['status'],
                    'paymentMethod' => $purchase['payment_method'],
                    'note'          => '',
                    'tax'           => $purchase['tax'],
                    'discount'      => $purchase['discount'],
                    'customer'      => $purchase['customerName'],
                    'phone'         => $purchase['customerPhone'],
                    'email'         => $purchase['customerEmail'],
                    'totalAmount'  => $purchase['total_amount'],
                    'shippingAddress' => $purchase['shipping_address'],
                    // 'shippingAddress' => json_encode([
                    // 'name' => $purchase['shipping_full_name'], 
                    // 'phone' => $purchase['shipping_phone'],
                    // 'address' => $purchase['shipping_address_line1'].','.$purchase['shipping_city'].', '.$purchase['shipping_state'].', '.$purchase['shipping_postal_code'].', '.$purchase['shipping_country'],
                    // ]),
                    'items'         => []
                ];
                if(!empty($purchase['product_title'])) {
                    $purchaseHistory[$purchaseOrderId]['items'][] = [
                        'product'   => $purchase['product_title'],
                        'sku'       => $purchase['sku'],
                        'price'     => $purchase['unit_price'],
                        'quantity'  => $purchase['quantity'],
                        'total'     => $purchase['total'],
                    ];
                }
            }else{
                if(!empty($purchase['product_title'])) {
                    $purchaseHistory[$purchaseOrderId]['items'][] = [
                        'product'   => $purchase['product_title'],
                        'sku'       => $purchase['sku'],
                        'price'     => $purchase['unit_price'],
                        'quantity'  => $purchase['quantity'],
                        'total'     => $purchase['total'],
                    ];
                }
            }
        }

        $result = array_values($purchaseHistory);

         $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'default_font_size' => 10,
            'default_font' => 'dejavusans',
        ]);

        $html = view('admin/sales/invoice', compact('result'));
        
         $mpdf->WriteHTML($html);

        if (ob_get_length()) {
            ob_end_clean();
        }

        $invType = ( getappdata('invoice_type') == 'on') ? 'D' : 'I';
        $mpdf->Output("invoice_$invoiceNo.pdf", $invType);
        exit;
    }

    public function getShippingAddress() {
        $thisUser = session('user');
        $userId = $thisUser['userId'];
        $shippingAddress = $this->shippingAddressModel->where('user_id', $userId)->get()->getRow();
        return $this->response->setJSON([
            'success' => ($shippingAddress) ? true : false,
            'data' => $shippingAddress,
        ]);
    }

}