<?php
namespace App\Controllers;

use CodeIgniter\Controllers;
use App\Models\PartnershipModel;
class GalleryController extends BaseController
{
    public function index() {
        $partnershipModel = new PartnershipModel();
        $gallery = $partnershipModel->where('status',1)->findAll();
        return view('frontend/gallery',compact('gallery'));
    }
}