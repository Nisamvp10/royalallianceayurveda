<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
    protected $table = 'users';
    protected $allowedFields =  ['id','name', 'email','role', 'password', 'role_id','store_id','status','phone','position','hire_date','profileimg','booking_status','created_at'];
    protected $primaryKey = 'id';

    function password_hash($password) {
        return password_hash($password,PASSWORD_DEFAULT);
    }

    function getUsers($search=false,$filter=false,$branch = false,$id=false,$order='') {
       $builder = $this->db->table('users as u')
            ->select('u.id, u.name, u.email, u.phone, u.hire_date, u.profileimg, u.booking_status,u.status, u.position,r.id as roleId, r.role_name,sm.facebook,sm.instagram,sm.twitter,sm.linkedin')
            ->join('roles as r', 'r.id = u.role')
            ->join('staff_media as sm','u.id = sm.staff_id')
            ->where('u.role !=',1)
            ->groupBy('u.id');

            if($order){
                $builder->orderBy($order);
            }else{
                $builder->orderBy('u.id', 'ASC');
            }

            if($filter !== 'all' && !empty($filter)){
               $builder->where('u.booking_status',$filter);
            }
            if($id){
                $builder->where(['u.id' => $id]);
            }

            if (!empty($search)) {
                $builder->like('u.name',$search)
                ->orLike('u.email',$search)
                ->orLike('r.role_name',$search)
                ->orLike('u.position',$search)
                ->orLike('u.phone',$search); 
            }

            return $builder->get()->getResultArray();
    }

    
}