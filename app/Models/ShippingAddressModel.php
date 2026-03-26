<?php
namespace App\Models;

use CodeIgniter\Model;

class ShippingAddressModel extends Model
{
    protected $table = 'shipping_addresses';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'session_id',
        'full_name',
        'phone',
        'email',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
        'created_at',
        'updated_at'
    ];
    
}