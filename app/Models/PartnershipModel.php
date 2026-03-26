<?php
namespace App\Models;

use CodeIgniter\Model;

class PartnershipModel extends Model {
    protected $table = 'partnership';
    protected $allowedFields = ['id','title','image','status','created_at','created_by','updated_at','updated_by',];
    protected $primaryKey = 'id';

    public function getexpdata($search='') {
        $builder = $this->db->table('partnership')
                ->select('id,title,image')
                ->where(['status'=>1]);
        if(!empty($search)) {
            $builder->like('title',$search);
        }
        $builder->orderBy('title','ASC');
        $result = $builder->get()->getResultArray();
        return $result;

    }
}