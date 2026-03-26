<?php
namespace App\Models;

use CodeIgniter\Model;

class CouponproductsModel extends Model
{
    protected $table = 'coupon_products';
    protected $primaryKey = 'id';
    protected $allowedFields = [ 'coupen_id','product_id'];
}
