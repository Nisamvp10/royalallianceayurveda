<?php
namespace App\Services;
use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\CouponcodeModel;
use App\Models\ProductManageModel;
use App\Models\CustomerOrderModel;
class CartService
{
    protected $cartModel;
    protected $itemModel;
    protected $productModel;
    protected $categoryModel;
    protected $productManageModel;
    protected $couponcodeModel;
    protected $customerOrderModel;
    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->itemModel = new CartItemModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productManageModel = new ProductManageModel();
        $this->couponcodeModel = new CouponcodeModel();
        $this->customerOrderModel = new CustomerOrderModel();
    }
    public function getMyCart()
    {
       $cart = $this->getCart();
       return $cart;
    }

    private function getCart()
    {
        $session = session();
        
        $user = $session->get('user');
        $userId = 0;

        if ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true) {
            $userId = $user['userId']; // use 'id' not userId
        }

        $sessionId = $session->get('cart_session') ?? session_id();
        $session->set('cart_session', $sessionId);

        if ($userId) {
            $this->mergeCartAfterLogin();
            $cart = $this->cartModel->where('user_id', $userId)->first();
            if ($cart) {
                return $cart;
            }
        }

        return $this->cartModel->where('session_id', $sessionId)->first();
    }

    /* ==========================================
    NEW FUNCTION : MERGE SESSION CART TO USER
    ========================================== */
    public function mergeCartAfterLogin()
    {
        $session = session();
        $user = $session->get('user');

        if (!$user || !$user['isLoggedIn']) return;

        $userId = $user['userId'];
        $sessionId = $session->get('cart_session');

        if (!$sessionId) return;

        // Session cart
        $sessionCart = $this->cartModel
            ->where('session_id', $sessionId)
            ->where('user_id', 0)
            ->first();

        if (!$sessionCart) return;

        // User cart
        $userCart = $this->cartModel
            ->where('user_id', $userId)
            ->first();

        // If user has no cart → assign session cart
        if (!$userCart) {

            $this->cartModel->update($sessionCart['id'], [
                'user_id' => $userId
            ]);

            return;
        }

        // Merge Items
        $sessionItems = $this->itemModel
            ->where('cart_id', $sessionCart['id'])
            ->findAll();

        foreach ($sessionItems as $sItem) {

            $existing = $this->itemModel
                ->where('cart_id', $userCart['id'])
                ->where('product_id', $sItem['product_id'])
                ->first();

            if ($existing) {

                $newQty = $existing['quantity'] + $sItem['quantity'];

                $this->itemModel->update($existing['id'], [
                    'quantity' => $newQty,
                    'subtotal' => $newQty * $existing['price']
                ]);

            } else {

                $this->itemModel->insert([
                    'cart_id' => $userCart['id'],
                    'product_id' => $sItem['product_id'],
                    'price' => $sItem['price'],
                    'quantity' => $sItem['quantity'],
                    'subtotal' => $sItem['subtotal']
                ]);
            }
        }

        // Delete old session cart
        $this->itemModel->where('cart_id', $sessionCart['id'])->delete();
        $this->cartModel->delete($sessionCart['id']);
    }


     private function createCart()
    {
        $session = session();
        $user = $session->get('user');
        $userId = 0;

        if ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true) {
            $userId = $user['userId']; // use 'id' not userId
        }
        return $this->cartModel->insert([
            'user_id'    => $userId,
            'session_id' => $session->get('cart_session'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

   public function add($data)
    {
        $productId = $data['product_id'] ?? null;
        $qty       = max(1, (int)($data['qty'] ?? 1));

        $product = $this->productManageModel->find($productId);
        $stockItem = $this->productModel->find($product['product_id']);
        if (!$product || $stockItem['current_stock'] < $qty) {
            return ['status' => false, 'message' => 'Out of stock'];
        }

        $productPrice =  calculatePrice(
                    $product['price'],
                    $product['compare_price'],
                    $product['price_offer_type']
            );
            
            $offerPrice  = $productPrice['offer_price'];
            $discount    = $productPrice['discount'];
            $actualPrice = $productPrice['actual_price'];

        $cart = $this->getCart();
        $cartId = $cart['id'] ?? $this->createCart();

        $item = $this->itemModel
            ->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();

        $newQty = $item ? $item['quantity'] + $qty : $qty;

        if ($newQty > $stockItem['current_stock']) {
            return ['status' => false, 'message' => 'Stock exceeded'];
        }

        if ($item) {
            $this->itemModel->update($item['id'], [
                'quantity' => $newQty,
                'subtotal' => $newQty * $offerPrice,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->itemModel->insert([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'price' => $offerPrice,
                'quantity' => $qty,
                'subtotal' => $qty * $offerPrice
            ]);
        }

        return [
            'status' => true,
            'message' =>'Added to cart',
            'cartCount' => $this->itemModel
                ->where('cart_id', $cartId)
                ->countAllResults()
        ];
    }

    public function remove($data)
    {
        $productId = $data['product_id'] ?? null;

        $cart = $this->getCart();
        if (!$cart) {
            return ['status' => false, 'message' => 'Cart not found'];
        }

        $item = $this->itemModel
            ->where('cart_id', $cart['id'])
            ->where('product_id', $productId)
            ->first();
            //echo $this->itemModel->getLastQuery();

        if (!$item) {
            return ['status' => false, 'message' => 'Item not found in cart'];
        }

        $this->itemModel->delete($item['id']);

        return [
            'status' => true,
            'message' => 'Item removed successfully',
            'cartCount' => $this->itemModel
                ->where('cart_id', $cart['id'])
                ->countAllResults()
        ];
    }

    public function update(array $data)
    {
        $cart = $this->getCart();
        if (!$cart) {
            return ['status' => false, 'message' => 'Cart not found'];
        }

        if (!isset($data['item_id']) || !isset($data['quantity'])) {
            return ['status' => false, 'message' => 'Invalid request'];
        }

        $itemIds   = $data['item_id'];
        $quantities = $data['quantity'];

        $total = 0;

        foreach ($itemIds as $index => $itemId) {
            $itemId = decryptor($itemId);
            $qty = (int) $quantities[$index];

            if ($qty < 1) {
                $this->itemModel->delete($itemId);
                continue;
            }

            $item = $this->itemModel
                ->where('id', $itemId)
                ->where('cart_id', $cart['id'])
                ->first();

            if (!$item) continue;

            $productmanage = $this->productManageModel->find($item['product_id']);
            $product = $this->productModel->find( $productmanage['product_id']);

            if (!$productmanage || $qty > $product['current_stock']) {
                return [
                    'status' => false,
                    'message' => 'Stock exceeded for ' . $productmanage['product_title']
                ];
            }

            $subtotal = $qty * $item['price'];

            $this->itemModel->update($itemId, [
                'quantity' => $qty,
                'subtotal' => $subtotal
            ]);
            $total += $subtotal;
        }

        return [
            'status' => true,
            'message' => 'Cart updated successfully',
            'total' => $total
        ];
    }


    

    public function getCartItems()
    {
        $cart = $this->getCart();
        if (!$cart) {
            return [];
        }

        $items = $this->itemModel->where('cart_id', $cart['id'])->findAll();

        if (empty($items)) {
            return [];
        }
        // Products
        $productIds = array_column($items, 'product_id');
        if (empty($productIds)) {
            return [];
        }

        $products = $this->productManageModel->whereIn('id', $productIds)->findAll();
        $products = array_column($products, null, 'id');

        // Categories
        $categoryIds = array_unique(array_column($products, 'category_id'));

        if (!empty($categoryIds)) {
            $categories = $this->categoryModel
                ->whereIn('id', $categoryIds)
                ->findAll();
            $categories = array_column($categories, null, 'id');
        } else {
            $categories = [];
        }

        // Build cart response
        $cartItems = [];

        foreach ($items as $item) {
            $product = $products[$item['product_id']] ?? null;
            if (!$product) continue;

            $category = $categories[$product['category_id']] ?? null;

            $cartItems[] = [
                'id'            => $item['id'],
                'product_id'    => $item['product_id'],
                'product_title' => $product['product_title'],
                'category_name' => $category['category'] ?? null,
                'price'         => $item['price'],
                'quantity'      => $item['quantity'],
                'subtotal'      => $item['subtotal'],
                'image'         => $product['product_image']
            ];
        }

        return $cartItems;
    }
    public function deleteCart($data)
    {
        $cart = $this->getCart();
        if (!$cart) {
            return ['status' => false, 'message' => 'Cart not found'];
        }

        $this->cartModel->where('id', $cart['id'])->delete();

        return [
            'status' => true,
            'message' => 'Cart deleted successfully'
        ];
    }
    public function couponCodeApply($couponCode)
    {
        $cart = $this->getCart();
        if (!$cart) {
            return ['status' => false, 'message' => 'Cart not found'];
        }
        $coupon = $this->couponcodeModel->where(['coupencode'=> $couponCode, 'is_active' => 1])->first();
        if (!$coupon) {
            return ['status' => false, 'message' => 'Coupon code not valid'];
        }
        $cartItems = $this->getCartItems();
        if(empty($cartItems)){
            return ['status' => false, 'message' => 'Cart is empty'];
        }
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['subtotal'];
        }
       //$coupon['minimumShopping'] is 150 the $total is 150 or 150 above condition is true 
        if($total < $coupon['minimumShopping']){
            return ['status' => false, 'message' => 'Minimum shopping amount is '.$coupon['minimumShopping']];
        }
        $discount = ($coupon['discount_type'] == 2) ? $total * ($coupon['discount'] / 100) : $coupon['discount'];
        //the maximum_discount_amount discount is limited 500 the discount graterthan 500 then set 500
        if($coupon['maximum_discount_amount'] < $discount){
            $discount = $coupon['maximum_discount_amount'];
        }
        //orderpurchsed history check the coupon is used by same user then return false
        $orderHistory = $this->cartModel->where(['couponcode_id' => $coupon['id'], 'user_id' => $cart['user_id']])->first();
        if($orderHistory){
            return ['status' => false, 'message' => 'Coupon code is already used'];
        }
        //coupon valid from date to valid to date from date is coupon start date and to date is coupon end date
        if($coupon['validity_from'] <= date('Y-m-d') && $coupon['validity_to'] >= date('Y-m-d')){
            $discount = $discount;
        }
        else{
            return ['status' => false, 'message' => 'Coupon code is expired'];
        }
        // if coupon is used by same user then return false
        $couponUsed = $this->customerOrderModel->where(['coupen_code_id' => $coupon['id'], 'user_id' => $cart['user_id']])->first();
        if($couponUsed){
            return ['status' => false, 'message' => 'Coupon code is already used'];
        }
        $total = $total - $discount;
        //insert coupon_discount and coupon id in cart
        $this->cartModel->update($cart['id'], [
            'couponcode_id' => $coupon['id'],
            'coupon_discount' => $discount
        ]);
        return [
            'status' => true,
            'message' => 'Coupon code applied successfully',
            'total' => $total
        ];
    }


}