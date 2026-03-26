<?php

namespace App\Models;
use CodeIgniter\Model;
class ServicehighlightsModel extends Model
{
    protected $table = 'service_highlights';
    protected $allowedFields = [
        'id',
        'service_id',
        'points',
        'remarks',
        'created_at',
    ];
    protected $primaryKey = 'id';
   // public $timestamps = false;
}