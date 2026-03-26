<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductvariantImagesModel extends Model
{
    protected $table = 'product_variant_images';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','product_id', 'image'];
}
