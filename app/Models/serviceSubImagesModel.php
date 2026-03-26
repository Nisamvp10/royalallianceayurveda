<?php
namespace App\Models;

use CodeIgniter\Model;
class serviceSubImagesModel extends Model{
    protected $table = 'service_sub_image';
    protected $allowedFields = ['service_id','image','created_at'];
    protected $primaryKey = 'id';
}