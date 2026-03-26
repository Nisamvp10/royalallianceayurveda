<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model{
    protected $table ='products';
    protected $allowedFields = ['id','product_name','note','category_id','sku','current_stock','min_stock','status','created_at','updated_at','created_by','updated_by'];
    protected $primaryKey = 'id';

    function getProducts($search ='',$filter = '',$stock=false,$intock = false,$orderByname='') {
       $builder = $this->db->table('products as p')
                    ->select('p.product_name,p.sku,p.note,c.category,p.created_at,p.id,p.current_stock,p.min_stock')
                    ->join('categories as c','p.category_id = c.id','left');
                    if($intock) {
                        $builder->where('p.current_stock !=',0);
                    }
                    if($filter != 'all' && !empty($filter)) {
                        if($filter ==2) {
                            $builder->where('p.current_stock',0);
                        }else{
                            $builder->where('p.current_stock <  p.min_stock');
                              $builder->where('p.current_stock !=',0);
                        }                    }
                     if($search) {
                        $builder->like('p.product_name',$search)
                        ->orLike('p.sku',$search);
                    }
                    if($stock) {
                        $builder->where('current_stock !=',0);
                    }
                    if($orderByname) {
                         $builder->orderBy('product_name ASC');
                    }
        return $builder->get()->getResultArray();
    }
    function getProductswithAmount($search ='',$filter = '',$stock=false,$intock = false,$orderByname='') {
       $builder = $this->db->table('products as p')
                    ->select('p.product_name,p.sku,p.note,c.category,p.created_at,p.id,p.current_stock,p.min_stock')
                    ->join('categories as c','p.category_id = c.id','left');
                    if($intock) {
                        $builder->where('p.current_stock !=',0);
                    }
                    if($filter != 'all' && !empty($filter)) {
                        if($filter ==2) {
                            $builder->where('p.current_stock',0);
                        }else{
                            $builder->where('p.current_stock <  p.min_stock');
                              $builder->where('p.current_stock !=',0);
                        }                    }
                     if($search) {
                        $builder->like('p.product_name',$search)
                        ->orLike('p.sku',$search);
                    }
                    if($stock) {
                        $builder->where('current_stock !=',0);
                    }
                    if($orderByname) {
                         $builder->orderBy('product_name ASC');
                    }
        return $builder->get()->getResultArray();
    }
    public function lowStockTotal()
    {
        $builder = $this->db->table('products');
        $builder->select("COUNT(*) as low_stock_total");
        $builder->where('status',1);
        $builder->where('current_stock < min_stock');
        return $builder->get()->getRow();
    }

    public function getPurchaseDetail($id=false) {
        $builder = $this->db->table('products as p')
            ->select('p.sku,p.current_stock,poi.price,poi.quantity')
            ->join('purchase_order_items as poi','p.id = poi.product_id','left')
            ->where('p.id',$id);
        return $builder->get()->getResult();
    }

}