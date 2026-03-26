<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Services\CartService;

class CartController extends Controller
{
    protected CartService $cart;

    public function __construct()
    {
        $this->cart = new CartService();
    }

    private function cartItemHtml(){
        $result = $this->cart->getCartItems();
        return view('frontend/cart/cart-items',compact('result'));
    }

    private function subtotalHtml() {
        $subtotal = $this->cart->getCartItems();
        return view('frontend/cart/subtotal',compact('subtotal'));
    }

    private function checkoutItemsHtml() {
        $cartdata = $this->cart->getMyCart();
        $subtotal = $this->cart->getCartItems();
        return view('frontend/cart/checkoutItems',compact('subtotal','cartdata'));
    }

    public function index() {
        $page = "Cart";
        return view('frontend/cart/index', compact('page'));
    }

    public function getMyCartItems() {
        $cartItemhtml = $this->cartItemHtml();
        $subtotalhtml = $this->subtotalHtml();
        return $this->response->setJSON(['res' =>$cartItemhtml,'subtotal'=>$subtotalhtml]);
    }
    public function getMyCheckoutItems() {
        
        $cartItemhtml = $this->cartItemHtml();
        $subtotalhtml = $this->checkoutItemsHtml();
        return $this->response->setJSON(['res' =>$cartItemhtml,'subtotal'=>$subtotalhtml]);
    }

    public function add()
    {
        $data = $this->request->getJSON(true);
        $result = $this->cart->add($data);
        return $this->response->setJSON($result);
    }

    public function remove()
    {
        $data = $this->request->getJSON(true);
        $result = $this->cart->remove($data);
        return $this->response->setJSON($result);
    }

    public function update()
    {
        $data = $this->request->getPost();//$this->request->getJSON(true);
        $result = $this->cart->update($data);
        return $this->response->setJSON($result);
    }

    public function clear()
    {
        $result = $this->cart->clear();
        return $this->response->setJSON($result);
    }

    public function getCartItems()
    {
        $result = $this->cart->getCartItems();
        $cartItemhtml = $result; //view('frontend/cart/cart-items-navbar',compact('result'));
        return $this->response->setJSON(['res' =>$cartItemhtml,'itmsCount' => count($result)]);
    }
}