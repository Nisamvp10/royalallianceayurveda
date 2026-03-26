<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CouponcodeModel;

class OfferController extends BaseController
{
    public function __construct() {
        $this->couponcodeModel = new CouponcodeModel();
    }
    public function index()
    {
        $offers = $this->couponcodeModel->where('is_active', 1)->findAll();
        return view('frontend/offers', compact('offers'));
    }
}