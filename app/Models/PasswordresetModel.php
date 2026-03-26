<?php
namespace App\Models;

use CodeIgniter\Model;
class PasswordresetModel extends Model {
    protected $table = 'password_resets';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id','email','token','otp','expires_at','created_at','used'
    ];
}

