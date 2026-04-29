<?php
namespace App\Controllers\frond;

use App\Controllers\BaseController;
use App\Services\ShipbuddyService;
use App\Services\Producttracking;

class ProductTrackingController extends BaseController
{
    protected $shipbuddyService;
    protected $producttracking;

    public function __construct()
    {
        $this->shipbuddyService = new ShipbuddyService();
        $this->producttracking = new Producttracking();
    }   
    public function index()
    {
        $page = "Product Tracking";
        return view('frontend/product-tracking', compact('page'));
    }

    public function trackOrder()
    {
        $rules = ['trackingNumber' => 'required|numeric'];
        if(!$this->validate($rules)) {
              return $this->response->setJSON(['success' => false , 'errors' => $this->validator->getErrors()]);
        }
        $tracKingNumer = $this->request->getPost('trackingNumber');
        $track = $this->producttracking->track($tracKingNumer);
       return $this->response->setJSON($track);

    }

     public function __trackOrder()
    {
        $orderId = 'ORD' . time();

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
                 "fullName" => "Test User",
                "contactNumber" => "9999999999",
                "email" => "nisamvp10@gmail.com",
                "alternateNumber" => "9999999999",
                "address" => "Kerala Address",
                "landmark" => "Near Area",
                "pincode" => 676505,
                "city" => "Malappuram",
                "state" => "Kerala",
                "country" => "India"              
            ],
            "packageList" => [
                [
                    "name" => "Test Product",
                    "qty" => 1,
                    "price" => 500,
                    "category" => "General",
                    "sku" => "SKU001",
                    "hsnCode" => "1234"
                ]
            ]
        ];

        $res = $this->shipbuddyService->request('orderApi/createOrder', 'POST', $payload);
       
        // Save response
        // $this->model->insert([
        //     'order_id' => $orderId,
        //     'response' => json_encode($res),
        //     'status'   => $res['status'] ?? 'created'
        // ]);

        return $this->response->setJSON($res);
    }

    
}