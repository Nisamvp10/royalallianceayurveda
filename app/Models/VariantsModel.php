<?php
namespace App\Models;
use CodeIgniter\Model;
class VariantsModel extends Model{
    protected $table = 'variants';
    protected $allowedFields = ['id','service_id','title','short_note','image'];
    protected $primaryKey = 'id';

}