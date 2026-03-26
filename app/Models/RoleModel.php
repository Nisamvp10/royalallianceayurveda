<?php
namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model {
    protected $table = 'roles';
    protected $allowedFields = ['id','role_name'];
    protected $primaryKey = 'id';
    protected $returnType = 'object';

}