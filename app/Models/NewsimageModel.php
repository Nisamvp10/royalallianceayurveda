<?php
namespace App\Models;
use CodeIgniter\Model;
class NewsimageModel extends Model{
    protected $table = 'newsimages';
    protected $allowedFields = ['id','news_id','image_url'];

}