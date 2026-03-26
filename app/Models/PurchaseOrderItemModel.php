<?php
namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderItemModel extends Model {
    protected $table = 'purchase_order_items';
    protected $primaryKey ='id';
    protected $allowedFields = [ 'id','purchase_order_id','product_id','quantity','remaining_qty','price','total','purchaseItem_at' ];

    public function getCurrentAverage($productId)
    {
        $builder = $this->table('purchase_order_items');
        $builder->select('SUM(quantity) as total_qty, SUM(quantity * price) as total_value');
        $builder->where('product_id', $productId);
        $row = $builder->get()->getRow();

        if ($row && $row->total_qty > 0) {
            return round($row->total_value / $row->total_qty, 2);
        }
        return 0;
    }

}