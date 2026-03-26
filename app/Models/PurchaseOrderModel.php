<?php
namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderModel extends Model {
    protected $table = 'purchase_orders';
    protected $primaryKey ='id';
    protected $allowedFields = [ 'id',	'invoice_number',	'supplier_id',	'payment_status','order_date','paid_date','payment_type','note','total_amount',	'status',	'created_at',	'updated_at','created_by'];

    function purchaseHistory($searchInput='', $filter ='',$startDate='', $endDate='',$id=false , $orderBy = false) {
        $builder = $this->db->table('purchase_orders as po')
                    ->select('po.id,po.invoice_number,po.payment_status,po.order_date,po.total_amount,po.note,po.paid_date,po.payment_type,
                    s.supplier_name,s.id as supplierId,
                    p.product_name,p.id as productId,p.sku,p.current_stock,
                    poi.id as pitemId,poi.price,poi.quantity,poi.total')
                    ->join('supplier as s','po.supplier_id = s.id')
                    ->join('purchase_order_items as poi','po.id = poi.purchase_order_id')
                    ->join('products as p','poi.product_id = p.id');
                    
                    if($orderBy) {
                        $builder->orderBy($orderBy);
                    }else{
                        $builder->orderBy('po.id','DESC');
                    }
                    if($searchInput){
                        $builder->like('po.invoice_number',$searchInput)
                            ->orLike('s.supplier_name',$searchInput)
                            ->orLike('p.product_name',$searchInput);
                    }
                    if($filter !='all' && $filter) {
                        $builder->where('po.payment_status',$filter);
                    }
                    if(!empty($startDate) && !empty($endDate)) {
                        $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
                        $endDate   = date('Y-m-d 23:59:59', strtotime($endDate));
                        $builder->where('po.order_date >=', $startDate);
                        $builder->where('po.order_date <=', $endDate);
                    }
                    if($id) {
                           $builder->where('po.id ', $id);
                    }
        $result = $builder->get()->getResultArray();
        return $result;
    }

    public function monthlyPurchase($month='') {
        $builder = $this->db->table('purchase_orders')
                ->select("DATE_FORMAT(order_date ,'%Y-%m') as month , sum(total_amount) total_purchase")
                ->groupBy("DATE_FORMAT(order_date,'%Y-%m')")
                ->orderBy('month');
                if($month){
                    $builder->where("MONTH(order_date)", date('m', strtotime($month)));
                    $builder->where("YEAR(order_date)", date('Y', strtotime($month)));
                }else{
                    $builder->where("MONTH(order_date)", date('m'));
                    $builder->where("YEAR(order_date)", date('Y'));  
                }

        $result = $builder->get()->getRowArray();
        return $result;
    }
    public function getLastPurchaseItemPrice($supplierId = false ,$producId = false) {
        $builder =  $this->db->table('purchase_orders as p')
                    ->select('poi.price')
                    ->join('purchase_order_items as poi','p.id = poi.purchase_order_id')
                    ->where('p.supplier_id',$supplierId)
                    ->where('poi.product_id',$producId)
                    ->orderBy('p.id','DESC')
                    ->limit(1);
        $result = $builder->get()->getRow();
        return $result;
    }
}