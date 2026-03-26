<?php
namespace App\Models;
use CodeIgniter\Model;
class UsersregistrationsModel extends Model {
    protected $table = 'usersregistrations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','email','phone','password','is_active','status','created_at','updated_at'];

    public function getUsers($search = null, $filter = null, $branch = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id,name,email,phone,created_at,status');
        if ($search) {
            $builder->groupStart();
            $builder->like('name', $search);
            $builder->orLike('email', $search);
            $builder->orLike('phone', $search);
            $builder->groupEnd();
        }
        if ($filter && $filter != 'all') {
            $builder->where('is_active', $filter);
        }
        if ($branch && $branch != 'all') {
            $builder->where('branch_id', $branch);
        }
        return $builder->get()->getResultArray();
    }
}
