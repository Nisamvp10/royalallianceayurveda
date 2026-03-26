<?php
namespace App\Controllers\frond;

use App\Controllers\BaseController;
use App\Services\ShipbuddyService;

class ProductTrackingController extends BaseController
{
    protected $shipbuddyService;

    public function __construct()
    {
        $this->shipbuddyService = new ShipbuddyService();
    }   
    public function index()
    {
        $page = "Product Tracking";
        return view('frontend/product-tracking', compact('page'));
    }

   public function trackOrder()
    {
        $trackingId = $this->request->getPost('trackingNumber');

        if(!$trackingId){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tracking number required'
            ]);
        }

        $tracking = $this->shipbuddyService->trackShipment($trackingId);

        return $this->response->setJSON($tracking);
    }
}