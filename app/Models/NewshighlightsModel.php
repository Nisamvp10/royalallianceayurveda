<?php

namespace App\Models;
use CodeIgniter\Model;
class NewshighlightsModel extends Model
{
    protected $table = 'news_highlights';
    protected $allowedFields = [
        'id',
        'news_id',
        'points',
        'created_at',
    ];
    protected $primaryKey = 'id';
   // public $timestamps = false;
}