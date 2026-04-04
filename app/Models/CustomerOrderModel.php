<?php
namespace App\Models;
use CodeIgniter\Model;

class CustomerOrderModel extends Model
{
    protected $table = 'customer_orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'order_number', 'gateway_order_id','tax','discount', 'coupen_code_id','address_id','shipping_address','shipping_order_id', 'sub_total', 'total_amount', 'payment_method', 'payment_status', 'status', 'created_at'];

    public function salesHistory($searchInput=false,$filter=false,$startDate=false,$endDate=false,$orderId=false,$orderInvoiceId=false) {
        $builder = $this->db->table('customer_orders as co')
                    ->select('co.id as orderId,co.order_number,co.tax,co.discount,co.address_id,co.shipping_address,co.sub_total,co.total_amount,co.payment_method,co.payment_status,co.status,co.created_at as orderDate,
                    pm.id as productId,
                    pm.product_title,
                    p.sku,
                    p.current_stock,
                    ur.name as customerName,
                    ur.phone as customerPhone,
                    ur.email as customerEmail,
                    sa.full_name as shipping_full_name,
                    sa.phone as shipping_phone,
                    sa.address_line1 as shipping_address_line1,
                    sa.address_line2 as shipping_address_line2,
                    sa.city as shipping_city,
                    sa.state as shipping_state,
                    sa.postal_code as shipping_postal_code,
                    sa.country as shipping_country,
                    coi.id as saleId,coi.price as unit_price,coi.qty as quantity,coi.subtotal as total')
                    ->join('customer_orders_items as coi','coi.customer_order_id = co.id')
                    ->join('product_management as pm','coi.product_id = pm.id')
                    ->join('products as p','p.id = pm.product_id')
                    //gut purchase user id = 0 so join not required
                    //->join('usersregistrations as ur','ur.id = co.user_id')
                    ->join('usersregistrations as ur','ur.id = co.user_id','left')
                    ->join('shipping_addresses as sa','sa.id = co.address_id')
                    ->orderBy('coi.id','DESC');
                    if($searchInput) {
                        $builder->groupStart();
                           $builder->like('pm.product_title ', $searchInput);
                           $builder->orLike('p.sku ', $searchInput);
                           $builder->orLike('ur.name ', $searchInput);
                           $builder->orLike('ur.phone ', $searchInput);
                           $builder->orLike('ur.email ', $searchInput);
                           $builder->orLike('co.order_number ', $searchInput);
                           $builder->orLike('co.tax ', $searchInput);
                           $builder->orLike('co.address_id ', $searchInput);
                           $builder->orLike('co.sub_total ', $searchInput);
                           $builder->orLike('co.total_amount ', $searchInput);
                           $builder->orLike('co.payment_method ', $searchInput);
                           $builder->orLike('co.payment_status ', $searchInput);
                           $builder->orLike('co.status ', $searchInput);
                           $builder->orLike('co.created_at ', $searchInput);
                        $builder->groupEnd();
                    }
                    if($filter && $filter != 'all') {
                           $builder->where('co.payment_status ', $filter);
                    }
                    if(!empty($startDate) && !empty($endDate)) {
                        $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
                        $endDate   = date('Y-m-d 23:59:59', strtotime($endDate));
                        $builder->where('co.created_at >=', $startDate);
                        $builder->where('co.created_at <=', $endDate);
                    }
                    if($orderId) {
                           $builder->where('co.id ', $orderId);
                    }
                    if($orderInvoiceId) {
                           $builder->where('co.order_number ', $orderInvoiceId);
                    }
        $result = $builder->get()->getResultArray();
        return $result;
    }
}