<?php
namespace App\Models;
use CodeIgniter\Model;
class SettingsModel extends Model {
    protected $table = 'app_settings';
    protected $allowedFields = ['name','value'];
     public function getSetting($key)
    {
        return $this->where('name', $key)->first()['value'] ?? null;
    }
}