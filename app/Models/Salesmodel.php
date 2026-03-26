<?php
namespace App\Models;

use CodeIgniter\Model;

class Salesmodel extends Model {
    protected $table = 'sales';
    protected $primaryKey = 'id';
    protected $allowedFields = [ 'id','invoice_number','customer_name','payment_status','sale_date','total_amount','note','status','created_at','updated_by','updated_at','created_by' ];

    function salesHistory($searchInput='', $filter ='',$startDate='', $endDate='',$id=false) {
        $builder = $this->db->table('sales as s')
                    ->select('s.id,s.invoice_number,s.payment_status,s.sale_date,s.total_amount,s.note,
                    s.customer_name,
                    p.id as productId,
                    p.product_name,
                    p.sku,
                    p.current_stock,
                    si.id as saleId,si.unit_price,si.quantity,si.total')
                    ->join('sale_items as si','s.id = si.sale_id')
                    ->join('products as p','si.product_id = p.id')
                    ->orderBy('s.id','DESC');
                    if($searchInput){
                        $builder->like('s.invoice_number',$searchInput)
                            ->orLike('s.customer_name',$searchInput)
                            ->orLike('p.product_name',$searchInput);
                    }
                    if($filter !='all' && $filter) {
                        $builder->where('s.payment_status',$filter);
                    }
                    if(!empty($startDate) && !empty($endDate)) {
                        // $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
                        // $endDate   = date('Y-m-d 23:59:59', strtotime($endDate));
                        $builder->where('s.sale_date >=', $startDate);
                        $builder->where('s.sale_date <=', $endDate);
                    }
                    if($id) {
                           $builder->where('s.id ', $id);
                    }
        $result = $builder->get()->getResultArray();
        return $result;
    }
    
}