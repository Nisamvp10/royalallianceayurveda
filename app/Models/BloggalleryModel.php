<?php
namespace App\Models;
use CodeIgniter\Model;
class BloggalleryModel extends Model{
    protected $table = 'bloggallery';
    protected $allowedFields = ['id','blog_id','image_url'];

}