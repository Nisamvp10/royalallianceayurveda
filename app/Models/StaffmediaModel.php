<?php
namespace App\Models;

use CodeIgniter\Model;

class StaffmediaModel extends Model {
    protected $table ='staff_media';
    protected $allowedFields = ['id','staff_id','facebook','instagram','twitter','linkedin'];
    protected $primaryKey = 'id';
}