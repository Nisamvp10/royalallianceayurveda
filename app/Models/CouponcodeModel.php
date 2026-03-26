<?php
namespace App\Models;

use CodeIgniter\Model;

class CouponcodeModel extends Model{
    protected $table = 'coupons';
    protected $primaryKey = 'id';
    protected $allowedFields = [ 'coupencode','coupenType','description','minimumShopping','discount','discount_type','is_active','maximum_discount_amount','validity_from','validity_to','created_at'];

    public function getCoupon($id=false,$filter='',$input=''){
        $builder = $this->db->table('coupons');
        $builder->select('id,coupencode,coupenType,minimumShopping,discount,discount_type,maximum_discount_amount,validity_from,validity_to');
        if($id){
            $builder->where('id',$id);
        }
        if($filter && $filter != 'all'){
            $builder->where('status',$filter);
        }
        if($input){
            $builder->like('coupencode',$input);
        }
        $builder->where('is_active',1);
        return $builder->get()->getResultArray();
    }
}