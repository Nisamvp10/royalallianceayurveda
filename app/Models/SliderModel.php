<?php

namespace App\Models;
use CodeIgniter\Model;
class SliderModel extends Model {
    protected $table = 'slider';
    protected $allowedFields = ['id','title','subtitle','highlight','image','url','button_title','status','created_at','updated_at','created_by','updated_by'];
    protected $primaryKey = 'id';
}