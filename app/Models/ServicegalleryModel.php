<?php
namespace App\Models;
use CodeIgniter\Model;
class ServicegalleryModel extends Model{
    protected $table = 'servicegallery';
    protected $allowedFields = ['id','service_id','image_url'];

}