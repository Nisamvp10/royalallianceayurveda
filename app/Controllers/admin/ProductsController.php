<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\PurchaseOrderItemModel;

Class ProductsController extends Controller {
    protected $productModel;
    protected $categoryModel;
    protected $itemsModel;
    function __construct(){
        $this->productModel = new ProductModel();
        $this->categoryModel = new categoryModel();
        $this->itemsModel = new PurchaseOrderItemModel();
    }

    public function index () {
        $page = (!haspermission('','investments') ? lang('Custom.permissionDenied' ): 'Products');
        return view('admin/products/index',compact('page'));
    }

    function create($id=false) {
        $page = (!haspermission('','create_investment') ? lang('Custom.permissionDenied' ): 'Edit Product ');
        $route = (!haspermission('','create_investment') ? 'pages-error-404': 'admin/products/create');
        $data = $this->productModel->find(decryptor($id));
        $categories = $this->categoryModel->where(['is_active' =>1])->find();
        return view($route,compact('page','data','categories'));
    }

    public function save() {
       // print_r($_POST);
        if(!hasPermission('','create_investment')) {
            return $this->response->setJSON(['success' => false ,'message' => lang('Custom.permissionDenied')]);
        }

        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false ,'message' => lang('Custom.invalidRequest')]);
        }
        $validMsg ='';
        $validStatus = false;

        $roules = [
            'product_name' => 'required|min_length[2]',
            'category_id'  => 'required',
            'sku'          => 'required|min_length[2]',
            'min_stock'    => 'required|numeric',
        ];

        if(!$this->validate($roules)) {
            return $this->response->setJSON(['success' => false ,'errors' => $this->validator->getErrors()]);
        }

        $productName = $this->request->getPost('product_name');
        $category   = $this->request->getPost('category_id');
        $sku        = $this->request->getPost('sku');
        $note       = $this->request->getPost('note');
        $id         = decryptor($this->request->getPost('id'));

        $data = [
            'product_name' => $productName,
            'category_id' => $category,
            'sku'         => $sku,
           
            'min_stock'     =>  $this->request->getPost('min_stock'),
            'note'        => $note,
            'created_by'   => session('user_data')['id'],
        ];
        if($id) {
            $data['updated_by']   = session('user_data')['id'];
            $data['updated_at']   = date('Y-m-d H:i:s');
            if($this->productModel->update($id,$data)) {
                $validStatus = true;
                $validMsg = 'Product Updated Successfully';
            }
        }else{
            $data['current_stock'] = 0;
            $data['created_by']   = session('user_data')['id'];
            if($this->productModel->insert($data)) {
                $validStatus = true;
                $validMsg = 'New Product Added Successfully';
            }
        }
        

        return $this->response->setJSON(['success' => $validStatus ,'message' => $validMsg]);
        
    }

    public function productList() {
        $validStatus = false;
        $validMsg    = '';
        $validResult = '';
        
        if(!$this->request->isAJAX()) {
            $validMsg = lang('Custom.invalidRequest');
        }
        $searchInput = $this->request->getPost('search');
        $filter     = $this->request->getPost('filter');
        $result = $this->productModel->getProducts($searchInput,$filter,1) ;
        //\echo $this->productModel->getLastQuery();
        if(!hasPermission('','view_products')) {
            $validMsg = lang('Custom.permissionDenied');
        }else{
            if($result){
                $validStatus = true;
                $validResult = $result;
                foreach($validResult as &$row) {
                    $row['encrypted_id'] = encryptor($row['id']);
                }
            }
        }
        return $this->response->setJSON(['success' => $validStatus ,'message' => $validMsg,'results' => $validResult]);
    }
    public function allProducts () {
        $page = (!haspermission('','investments') ? lang('Custom.permissionDenied' ): 'Products');
        return view('admin/products/allproducts',compact('page'));
    }
    public function allProductsList() {
        $validStatus = false;
        $validMsg    = '';
        $validResult = '';
        
        if(!$this->request->isAJAX()) {
            $validMsg = lang('Custom.invalidRequest');
        }
        $searchInput = $this->request->getPost('search');
        $filter     = $this->request->getPost('filter');
        $result = $this->productModel->getProducts($searchInput,$filter) ;
        //\echo $this->productModel->getLastQuery();
        if(!hasPermission('','investments')) {
            $validMsg = lang('Custom.permissionDenied');
        }else{
            if($result){
                $validStatus = true;
                $validResult = $result;
                foreach($validResult as &$row) {
                    $row['encrypted_id'] = encryptor($row['id']);
                }
            }
        }
        return $this->response->setJSON(['success' => $validStatus ,'message' => $validMsg,'results' => $validResult]);
    }

    function delete($id) {
        if(!$this->request->isAJAX()) {
            $validMsg = lang('Custom.invalidRequest');
        }
        $validStatus = false;
        $validMsg = '';
        // if(!hasPermission('','delete_product')) {
        //     $validMsg = lang('Custom.permissionDenied');
        // }
        $id = decryptor($id);
        $product = $this->productModel->find($id);
        if($product) {
            if($product['current_stock'] == 0.00 ){
                $exists = $this->itemsModel->where('product_id', $id)->first();

                if ($exists) {
                   $validMsg = "Record found: This item cannot be deleted as it has been purchased. Please update or cancel related purchase records before attempting to delete the item.";
                } else {
                    $this->productModel->delete($id);
                    $validStatus = true;
                    $validMsg = 'Product Successfully Deleted';
                }
            }else{
                $validMsg = 'Cannot delete item. Stock quantity is greater than 1. Please adjust inventory levels before deletion';
            }
        }else{
            $validMsg = 'Oops Item Not Found';
        }
        
        return $this->response->setJSON(['success' => $validStatus ,'message' => $validMsg]);

    }
}