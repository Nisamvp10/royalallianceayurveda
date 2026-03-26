<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model{
    protected $table = 'supplier';
    protected $allowedFields =  ['id','supplier_name', 'email','store', 'phone','status','created_at'];
    protected $primaryKey = 'id';

     function getSupplier($search=false,$filter=false) {
       $builder = $this->db->table('supplier as s')
            ->select('s.id,s.store,s.supplier_name,s.phone,s.email,s.status')
            ->groupBy('s.id')
            ->orderBy('s.store', 'ASC');


            if($filter !== 'all' && !empty($filter)){
            
               $builder->where('s.status',$filter);
            }
            

            if (!empty($search)) {
                $builder->like('s.store',$search)
                ->orLike('s.email',$search)
                ->orLike('s.supplier_name',$search)
                ->orLike('s.phone',$search); 
            }

            return $builder->get()->getResultArray();
    }

    public function getTransactionHistory($SupplierId =false ,$startDate ='',$endDate ='' ,$filter ='',$paymentType=false) {
        $builder = $this->db->table('supplier as s')
                    ->select("s.id,
                    po.invoice_number,po.order_date,payment_status,po.paid_date,po.total_amount,po.payment_type,
                      (
            SELECT SUM(po2.total_amount) 
            FROM purchase_orders po2
            WHERE po2.supplier_id = s.id
            " . ($filter !== 'all' && !empty($filter) ? " AND po2.payment_status = ".$this->db->escape($filter) : "") . "
             " . ($paymentType !== 'all' && !empty($paymentType) ? " AND po2.payment_type = ".$this->db->escape($paymentType) : "") . "
            " . (!empty($startDate) && !empty($endDate) 
                ? " AND po2.order_date BETWEEN ".$this->db->escape(date('Y-m-d 00:00:00', strtotime($startDate)))." AND ".$this->db->escape(date('Y-m-d 23:59:59', strtotime($endDate))) 
                : "") . "
        ) as total
         ")
                    ->join('purchase_orders as po','s.id =po.supplier_id')
                    ->where('s.id',$SupplierId)
                    ->orderBy('po.order_date','DESC');
                    if($filter !== 'all' && !empty($filter)){
                        $builder->where('po.payment_status',$filter);
                    }
                     if($paymentType !== 'all' && !empty($paymentType)){
                        $builder->where('po.payment_type',$paymentType);
                    }
                    if(!empty($startDate) && !empty($endDate)) {
                        $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
                        $endDate   = date('Y-m-d 23:59:59', strtotime($endDate));
                        $builder->where('po.order_date >=', $startDate);
                        $builder->where('po.order_date <=', $endDate);
                    }
         return $builder->get()->getResultArray();
    }
}