<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Services\CartService;
use App\Services\PaymentGateway;
use App\Models\CustomerOrderModel;
use App\Models\ShippingAddressModel;
use App\Models\CustomerOrderItemsModel;
use App\Models\UsersregistrationsModel;
use App\Models\ProductModel;
use App\Models\ProductManageModel;
use App\Models\CouponcodeModel;
use App\Services\ShipbuddyService;
//thi controller in controllers frond folder 
use Razorpay\Api\Api;
use App\Controllers\front\RazorpayController; 

class CheckoutController extends Controller
{
    protected CartService $cart;
    protected PaymentGateway $paymentGateway;
    protected $customerOrderModel;
    protected $shippingAddressModel;
    protected $customerOrderItemsModel;
    protected $userModel;
    protected $productModel;
    protected $productManageModel;
    protected $couponcodeModel;
    protected $shipbuddyService;
    public function __construct()
    {
        $this->cart = new CartService();
        $this->customerOrderModel = new CustomerOrderModel();
        $this->shippingAddressModel = new ShippingAddressModel();
        $this->customerOrderItemsModel = new CustomerOrderItemsModel();
        $this->userModel = new UsersregistrationsModel();
        $this->productModel = new ProductModel();
        $this->productManageModel = new ProductManageModel();
        $this->couponcodeModel = new CouponcodeModel();
        $this->paymentGateway = new PaymentGateway();
        $this->shipbuddyService = new ShipbuddyService();
    }
    public function index()
    {
        $page = "Checkout";
        return view('frontend/checkout/index', compact('page'));
    }

    public function isLogin() {

        $user = session()->get('user');
        $status = ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true);
        return $this->response->setJSON([
            'status' => $status
        ]);
    }

    function userLogin() {
        $user = session()->get('user');
        $status = ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true);
        return $status;
    }
    private function generateOrderNumber($orderId)
    {
        // $prefix = 'ORD';
        // $date = date('Ymd');
        // //last order id 
        // $lastOrder = $this->customerOrderModel->like('order_number', $prefix . '-' . $date, 'after')->orderBy('id', 'DESC')->first();

        // if ($lastOrder) {
        //     //last id last orderId unique 
        //     $lastNumber = (int) substr($lastOrder['order_number'], -5);
        //     $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        // } else {
        //     $newNumber = '00001';
        // }
        return 'ORD-' . date('Ymd') . '-' . str_pad($orderId, 6, '0', STR_PAD_LEFT);

    }

    public function placeOrder() {
        $address_id = $this->request->getPost('address_id');
        $payment_method = $this->request->getPost('payment_method') ?? 'cod'; //gateway
        helper('cookie');
        $sessionId = get_cookie('cart_session');

        $user = session()->get('user') ?? $sessionId;
        $status = ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true);
        $minimumOrderAmount = getappdata('minimum_order_amount');
        $itemSum = 0;
        $tax = getappdata('tax');

        if ($status) {
            //2 get cart data
            $cart = $this->cart->getMyCart();
            if(!$cart){
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Cart is empty',
                    'url' => base_url('checkout')
                ]);
            }
            //3 get cart items 
            $cartItems = $this->cart->getCartItems();
            if(empty($cartItems)){
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Cart is empty',
                    'url' => base_url('checkout')
                ]);
            }
            foreach($cartItems as $item){
                $itemSum += $item['subtotal'];
            }
            $coupenDiscount = ($cart['coupon_discount'] !=0)?$cart['coupon_discount']:0;
            $subTotal  = $itemSum - $coupenDiscount; 
            $taxAmount = round($subTotal * ($tax / 100));
         
            $totalAmount = $subTotal + $taxAmount; 
            if($totalAmount < $minimumOrderAmount){
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Minimum order amount is '.money_format_custom($minimumOrderAmount),
                    'url' => base_url('checkout')
                ]);
            }
            
            //$db = \Config\Database::connect();
            //$db->transStart();
            //4 create order
            $address = $this->shippingAddressModel->where('user_id', $user['userId'])->where('is_default', 1)->get()->getRow();
            $shippingAddress = [
                'name'  => $address->full_name,
                'email' => $address->email,
                'phone' => $address->phone,
                'address'   => $address->address_line1,
                'city'  =>$address->city,
                'state' => $address->state,
                'post'  => $address->postal_code,
                'country'   => $address->country,

            ];
          
            $orderData = [
                'user_id' => $user['userId'],
               // 'order_number' => $orderNumber,
                'tax' => $taxAmount,
                'coupen_code_id' => $cart['couponcode_id'],
                'discount' => $cart['coupon_discount'],
                'address_id' => $address->id,
                'shipping_address' => json_encode($shippingAddress,true),
                'sub_total' => $itemSum,
                'total_amount' => $totalAmount,
                'payment_method' => $payment_method,
                'coupon_id' => $cart['couponcode_id'],
                'coupon_discount' => $coupenDiscount,
                'payment_status' => 'pending',
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            if($payment_method == 'gateway'){
                
               //$order = $this->paymentGateway->createOrder($totalAmount, 'INR', $orderData['order_number']);
                 $order = $this->paymentGateway->createOrder($totalAmount,$orderData['order_number']);
                 $orderNumber = $this->generateOrderNumber();

                if(isset($order['id'])){

                    $orderData['gateway_order_id'] = $order['id'];

                    $order_id = $this->customerOrderModel->insert($orderData,true);
                    foreach($cartItems as $item){
                        $orderItemData = [
                            'customer_order_id' => $order_id,
                            'product_id' => $item['product_id'],
                            'qty' => $item['quantity'],
                            'price' => $item['price'],
                            'subtotal' => $item['subtotal'],
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        $this->customerOrderItemsModel->insert($orderItemData);
                    }
                    
                    return $this->response->setJSON([
                        'success'=>true,
                        'razorpay_order_id'=>$order['id'],
                        'amount'=>$totalAmount * 100,
                        'key'=>env('payment.keyId'),
                        'order_id'=>$order_id
                    ]);

                }
            }
            //print_r($orderData); exit();
            $order = $this->customerOrderModel->insert($orderData);
            $lastOrderId = $this->customerOrderModel->insertID();
            $orderNumber = $this->generateOrderNumber($lastOrderId);
            //update order number
            $this->customerOrderModel->update($lastOrderId, ['order_number' => $orderNumber]);
            if($order){

                $packageList = [];
                $order_id = $this->customerOrderModel->insertID();
                foreach($cartItems as $item){
                    $orderItemData = [
                        'customer_order_id' => $order_id,
                        'product_id' => $item['product_id'],
                        'qty' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                        'type' => $payment_method,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    

                    $this->customerOrderItemsModel->insert($orderItemData);
                    //select product id from productmanagement 
                    $productManage = $this->productManageModel->where('id', $item['product_id'])->first();
                    //product stock update 
                    $currentStock = $this->productModel->where('id', $productManage['product_id'])->first();
                    $blanceQty = $currentStock['current_stock'] - $item['quantity'];
                    $this->productModel->update( $productManage['product_id'], ['current_stock' => $blanceQty]);
                     $packageList[] = [
                            "name" => $productManage['product_title'],
                            "qty" => (int)$item['quantity'],
                            "price" => (int)$item['price'],
                            "category" => 'General',
                            "sku" => $currentStock['sku'],
                            "hsnCode" => (string) "1234",//$currentStock['hsn_code']
                        ];
                }

                //payment method COD
                if($payment_method == 'cod'){

                    //get user details like email and phone \\ is cart_session \\ is user_id
                    
                    $user = $this->userModel->where('id', $user['userId'])->first();
                    $pincode = trim($address->postal_code);
                    $pincode = trim($address->postal_code); // remove spaces
                    $pincode = preg_replace('/[^0-9]/', '', $pincode);
                    $pincode = substr(preg_replace('/\D/', '', $address->postal_code), 0, 6);
                    //shiping address to shipbuddy 
                
                    $payload = [
                        "orderData" => [
                            "deliveryType" => "FORWARD",
                            "isDangerousGoods" => "n",
                            "paymentMode" => "cod",
                            "length" => 10,
                            "breadth" => 10,
                            "height" => 10,
                            "warehouseName" => "royal alliance ayurveda",
                            "packageCount" => 1,
                            "shippingMode" => "surface",
                            "deadWeight" => 0.5
                        ],
                        "customerAddressList" => [
                            "fullName" => $address->full_name ?? '',
                            "contactNumber" => $address->phone ?? '',
                            "email" => $address->email ?? '',
                            "alternateNumber" => $address->phone ?? '',
                            "address" => $address->address_line1 ?? '',
                            //"landmark" => $shippingAddress['landmark'] ?? '',
                            //"pincode" => $address->postal_code ?? '',
                            "pincode" => (int)$pincode, // ✅ important
                            "city" => $address->city ?? '',
                            "state" => $address->state ?? '',
                            "country" => $address->country ?? ''
                        ],
                        "packageList" => $packageList
                    ];
                    //$response = $this->shipbuddyService->request('orders/create', 'POST', $payload);
                    $res = $this->shipbuddyService->request('orderApi/createOrder', 'POST', $payload);
                    print_r($res);
                    die;
                    $shipping_order_id = $res['response']['data'][0]['orderId'];
                    $this->customerOrderModel->update($order_id, ['payment_status' => 'unpaid','status' => 'confirmed','shipping_order_id'=>$shipping_order_id]); 

                    //clear cart 
                    $this->cart->deleteCart($cart['id']);
                    //mail template 
                    $this->sendOrderMail($order_id);
                  //  $db->transComplete();
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Order placed successfully',
                        'type' => $payment_method,
                        'url' => base_url('order-success/'.$orderNumber)
                    ]);
                }
                
                
            }else{
                //dd($this->customerOrderModel->errors());
               // $db->transRollback();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Order placement failed',
                    'url' => base_url('checkout')
                ]);
            }
           
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to place order',
                'url' => base_url('login')
            ]);
        }
    }

    //verify 
    public function verifyPayment()
    {

        // $order_id = 'order_SYCisFoZwVIOXq';
        //   $order = $this->customerOrderModel->where('gateway_order_id',$order_id)->first();
        //   $shippingAddress = json_decode($order['shipping_address'], true);
        //     echo "<pre>";
        //     print_r($shippingAddress);
        //     echo "</pre>";
        //     echo   $pincode = trim($shippingAddress['post']);

        //   exit();

        $keyId = env('payment.keyId');
        $keySecret = env('payment.keySecret');

        $cart = $this->cart->getMyCart();

        $payment_id = $this->request->getPost('razorpay_payment_id');
        $order_id = $this->request->getPost('razorpay_order_id');
        $signature = $this->request->getPost('razorpay_signature');

        /* GET ORDER */
        $order = $this->customerOrderModel->where('gateway_order_id',$order_id)->first();

        /* VERIFY SIGNATURE */

        $generated_signature = hash_hmac('sha256',$order_id . "|" . $payment_id,$keySecret);

        if ($generated_signature != $signature) {

            return $this->response->setJSON(['status'=>false,'message'=>'Invalid signature']);
        }

        /* CHECK PAYMENT STATUS FROM RAZORPAY */

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.razorpay.com/v1/payments/".$payment_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $keyId . ":" . $keySecret
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        $payment = json_decode($response,true);

        if($payment['status'] != 'captured'){   

            return $this->response->setJSON([
                'status'=>false,
                'order_id'=>$order['order_number'],
                'message'=>'Payment not completed'
            ]);
        }

        /* PAYMENT SUCCESS */



        $orderItems = $this->customerOrderItemsModel->where('customer_order_id',$order['id'])->findAll();

        /* UPDATE STOCK */

        foreach($orderItems as $item){

            $productManage = $this->productManageModel->where('id',$item['product_id'])->first();

            $currentStock = $this->productModel->where('id',$productManage['product_id'])->first();

            $balanceQty = $currentStock['current_stock'] - $item['qty'];

            $this->productModel->update($productManage['product_id'], ['current_stock'=>$balanceQty]);

        }
        //create shipping address
        
        $orderId = 'ORD' . time();
        $shippingAddress = json_decode($order['shipping_address'], true);
        $packageList = [];
        if($orderItems){
            foreach($orderItems as $item){
                $productManage = $this->productManageModel->where('id',$item['product_id'])->first();
                $currentStock = $this->productModel->where('id',$productManage['product_id'])->first();
                $packageList[] = [
                    "name" => $productManage['product_title'],
                    "qty" => (int)$item['qty'],
                    "price" => (int)$item['price'],
                    "category" => 'General',
                    "sku" => $currentStock['sku'],
                    "hsnCode" => (string) "123",//$currentStock['hsn_code']
                ];
            }
        }
        $user = $this->userModel->where('id', $order['user_id'])->first();
        $pincode = trim($shippingAddress['post']);
        $pincode = trim($shippingAddress['post']); // remove spaces
        $pincode = preg_replace('/[^0-9]/', '', $pincode);
        $pincode = substr(preg_replace('/\D/', '', $shippingAddress['post']), 0, 6);

        $payload = [
            "orderData" => [
                "deliveryType" => "FORWARD",
                "isDangerousGoods" => "n",
                "paymentMode" => "prepaid",
                "length" => 10,
                "breadth" => 10,
                "height" => 10,
                "warehouseName" => "royal alliance ayurveda",
                "packageCount" => 1,
                "shippingMode" => "surface",
                "deadWeight" => 0.5
            ],
            "customerAddressList" => [
                "fullName" => $shippingAddress['name'] ?? '',
                "contactNumber" => $shippingAddress['phone'] ?? '',
                "email" => $user['email'] ?? '',
                "alternateNumber" => $shippingAddress['phone'] ?? '',
                "address" => $shippingAddress['address'] ?? '',
                "pincode" => (int)$pincode, 
                "city" => $shippingAddress['city'] ?? '',
                "state" => $shippingAddress['state'] ?? '',
                "country" => $shippingAddress['country'] ?? ''
            ],
            "packageList" => $packageList
        ];
        $res = $this->shipbuddyService->request('orderApi/createOrder', 'POST', $payload);
        $shipping_order_id = $res['response']['data'][0]['orderId'];
        $this->customerOrderModel->where('gateway_order_id',$order_id)->set(['payment_status'=>'paid','status'=>'confirmed','shipping_order_id'=>$shipping_order_id])->update();
        /* DELETE CART */

        $this->cart->deleteCart($cart['id']);

        /* SEND EMAIL */

        $this->sendOrderMail($order['id']);

        return $this->response->setJSON([
            'status'=>true,
            'order_id'=>$order['order_number'],
            'message'=>'Payment successful'
        ]);

    }
    // close verify 
    private function sendOrderMail($order_id){
        $emailService = \Config\Services::email();
        $order = $this->customerOrderModel->find($order_id);
        $order_items = $this->customerOrderItemsModel->where('customer_orders_items.customer_order_id', $order_id)->
        join('product_management', 'product_management.id = customer_orders_items.product_id')
        ->get()
        ->getResultArray();

        //check login he is logged in send mail to user email else send to $shipping address email
        $userLog = session()->get('user');

        $status = ($userLog && isset($userLog['isLoggedIn']) && $userLog['isLoggedIn'] === true);
        $user = $this->userModel->where('id', $order['user_id'])->get()->getRow();
        if($status){
            $shippingAddress = json_decode($order['shipping_address'], true);
            $mailTo = ($shippingAddress['email']) ? $shippingAddress['email'] : $user->email;
        }

       // $shippingAddress = $this->shippingAddressModel->where('id', $order['address_id'])->get()->getRow();
        $emailService->setTo($mailTo);
        $emailService->setSubject('Order Placed');
        $emailService->setMessage(view('frontend/email/order_placed', compact('order', 'order_items','user')));
        $emailService->send();
    }
    public function applyCoupon(){
        if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
                'url' => base_url('checkout')
            ]);
        }
        $rules = [
            'coupon_code' => 'required'
        ];
        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $coupon_code = $this->request->getPost('coupon_code');
        $coupon = $this->cart->couponCodeApply($coupon_code);
        if($coupon['status'] == 'success'){
            return $this->response->setJSON([
                'success' => true,
                'message' => $coupon['message'],
                'url' => base_url('checkout')
            ]);
        }else{
            return $this->response->setJSON([
                'success' => false,
                'message' => $coupon['message'],
                'url' => base_url('checkout')
            ]);
        }
        
    }

    public function cancelOrder() {
        $orderId = $this->request->getPost('order_id');
        if($orderId) {
            $this->customerOrderModel->where('gateway_order_id',$orderId)->set(['payment_status'=>3,'status'=>3])->update();
        }
      return true;  
    }
}