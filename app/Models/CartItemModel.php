<?php
namespace App\Models;
use CodeIgniter\Model;
class CartItemModel extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cart_id', 'product_id', 'price', 'quantity', 'subtotal','created_at','updated_at'];
    public function getItems($cartId)
    {
        return $this->where('cart_id', $cartId)->findAll();
    }
    public function updateItem($id, $data)
    {
        return $this->update($id, $data);
    }
    public function insertItem($data)
    {
        return $this->insert($data);
    }
    public function deleteItem($id)
    {
        return $this->delete($id);
    }
    public function deleteItems($cartId)
    {
        return $this->where('cart_id', $cartId)->delete();
    }
    public function getItem($cartId, $productId)
    {
        return $this->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();
    }
    public function countItems($cartId)
    {
        return $this->where('cart_id', $cartId)->countAllResults();
    }
}