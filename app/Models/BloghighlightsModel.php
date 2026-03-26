<?php

namespace App\Models;
use CodeIgniter\Model;
class BloghighlightsModel extends Model
{
    protected $table = 'blog_highlights';
    protected $allowedFields = [
        'id',
        'blog_id',
        'points',
        'created_at',
    ];
    protected $primaryKey = 'id';
   // public $timestamps = false;
}