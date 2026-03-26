<?php
namespace App\Models;
use CodeIgniter\Model;
class CartModel extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'session_id', 'total_amount','couponcode_id','coupon_discount','created_at', 'updated_at'];
    public function getCart($userId, $sessionId)
    {
        return $this->where('user_id', $userId)
            ->where('session_id', $sessionId)
            ->first();
    }
    public function createCart($userId, $sessionId)
    {
        $this->insert([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'total_amount' => 0
        ]);
        return $this->insertID;
    }
}   