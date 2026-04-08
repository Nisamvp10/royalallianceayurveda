<?php
namespace App\Controllers;

class CommonController extends BaseController {

    public function terms() {
        $page = "Terms and  Conditions";
        return view('frontend/terms-and-conditions',compact('page'));
    }
     public function refundcancellation() {
        $page = "Refund & Cancellation";
        return view('frontend/refund-cancellation',compact('page'));
    }
    public function privacyPolicy() {
        $page = "Privacy Policy";
        return view('frontend/privacy-policy',compact('page'));
    }
    public function shippingPolicy() {
        $page = "Shipping Policy";
        return view('frontend/shipping-policy',compact('page'));
    }
    public function faq() {
        $page = "FAQ";
        return view('frontend/faq',compact('page'));
    }
    public function promo() {
        $page = "Promo";
        return view('frontend/products/promo',compact('page'));
    }
}