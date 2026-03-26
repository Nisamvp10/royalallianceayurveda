<?php
namespace App\Models;

use CodeIgniter\Model;

class FeedbackModel extends Model {
    protected $table = 'feedback';
    protected $allowedFields = ['id','username','designation','note','profile','status','created_at','created_by','updated_at','updated_by'];
    protected $primaryKey = 'id';

    public function getData($search='') {
        $builder = $this->db->table('feedback')
                ->select('id,username as name,profile,designation,note')
                ->where(['status'=>1]);
        if(!empty($search)) {
            $builder->like('title',$search);
        }
        $builder->orderBy('name','ASC');
        $result = $builder->get()->getResultArray();
        return $result;
    }
}