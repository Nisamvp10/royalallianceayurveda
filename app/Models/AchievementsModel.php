<?php
namespace App\Models;

use CodeIgniter\Model;

class AchievementsModel extends Model {
    protected $table = 'achievements';
    protected $allowedFields = ['id','title','description','note','image','status','created_at','created_by','updated_at','updated_by'];
    protected $primaryKey = 'id';

    public function getData($search='') {
        $builder = $this->db->table('achievements')
                ->select('id,title ,image,description,note')
                ->where(['status'=>1]);
        if(!empty($search)) {
            $builder->like('title',$search);
        }
        $builder->orderBy('id','DESC');
        $result = $builder->get()->getResultArray();
        return $result;
    }
}