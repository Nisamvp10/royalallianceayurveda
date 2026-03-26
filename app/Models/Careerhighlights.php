<?php

namespace App\Models;
use CodeIgniter\Model;
class Careerhighlights extends Model
{
    protected $table = 'career_highlights';
    protected $allowedFields = [
        'id',
        'career_id',
        'points',
        'created_at',
    ];
    protected $primaryKey = 'id';
   // public $timestamps = false;
}