<?php
namespace App\Models;
use CodeIgniter\Model;

class CustomerOrderItemsModel extends Model
{
    protected $table = 'customer_orders_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['customer_order_id','product_id','qty','price','subtotal','created_at'];
}
