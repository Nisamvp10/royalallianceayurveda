<?php
namespace App\Controllers\admin;
use CodeIgniter\Controller;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductManageModel;
use App\Controllers\UploadImages;
use App\Models\ProductvariantImagesModel;
class ProductmanagementController extends Controller
{
    protected $categoryModel;
    protected $productModel;
    protected $productManageModel;
    protected $imgUploader;
    protected $productvariantImagesModel;
    function __construct() {
        $this->imgUploader = new UploadImages();
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
        $this->productManageModel = new ProductManageModel();
        $this->productvariantImagesModel = new ProductvariantImagesModel();
    }
    public function index()
    {
       $page = (haspermission('','product_management')) ? ucwords(getappdata('product_management')) : lang('Custom.permissiondenied');
       $route = (haspermission('','product_management')) ? 'admin/productmanagement/index' : 'admin/pages-error-404';
       $categories = $this->categoryModel->where('is_active',1)->findAll();
       //$products = 
       return view($route,compact('page','categories'));
    }

    public function getProductBycategory($id=false) {
        $validStatus = false;
        $validMsg    = '';
        $validResult = '';

        if(!$this->request->isAJAX()) {
            $validMsg = lang('Custom.invalidRequest');
        }
        if(!haspermission('','product_management')) {
             $validMsg = lang('Custom.permissiondenied');
        }else{
            
           $products = $this->productModel->select('id,product_name')->where('category_id', $id)->where('current_stock >', 0)->where('status', 1)->findAll();

            if($products) {
                $validStatus = true;
                $validResult = $products;

            }
        }
        return $this->response->setJson([
            'success' => $validStatus,
            'message' => $validMsg,
            'products' => $validResult
        ]);
    }

    public function list() {
        $validMsg = '';
        $status = false;
        if(!hasPermission('','product_management')) {
            $validMsg = $message = lang('Custom.permissionDenied');
        }
        if(!$this->request->isAJAX()) {
          $validMsg = $message = lang('Custom.invalidRequest');
        }
        $status = false;
        $result ='';
        $search = $this->request->getPost('search');
        $filter = $this->request->getPost('filter');
        $data   = $this->productManageModel->getData($search,$filter);
        //echo  $this->productManageModel->getLastQuery();
        if($data) {

            foreach($data as &$key) {
                $key['id'] = encryptor($key['id']);
                $key['image'] = validImg($key['product_image']);
                $price =  dicountPrice($key['price'],$key['price_offer_type'],$key['compare_price']); // money_format_custom($key['price']);
                $totalDiscount = totalDiscount($key['compare_price'],$key['price_offer_type'],$key['price']);
                $key['compare_price'] = ($key['price_offer_type'] == 2) ? '<del>'.money_format_custom($totalDiscount).'%</del>' : '<del>'.money_format_custom($totalDiscount).'<del>';
                $key['price'] = money_format_custom($price);
            }
            $status = true;
            $validMsg = '';
            $result = $data;
        }
        return $this->response->setJSON(['success' => $status , 'result' => $result,'message' => $validMsg]);

    }

    function productPurchaseDetail($id = false)
    {
        $validStatus = false;
        $validMsg    = '';
        $validResult = [];

        if (!$this->request->isAJAX()) {
            $validMsg = lang('Custom.invalidRequest');
        } elseif (!haspermission('', 'product_management')) {
            $validMsg = lang('Custom.permissiondenied');
        } else {

            $products = $this->productModel->getPurchaseDetail($id); 

            if (!empty($products)) {

                $totalAmount   = 0;
                $totalQuantity = 0;
                $sku           = '';

                foreach ($products as $item) {
                    $totalAmount   += ($item->price * $item->quantity);
                    $totalQuantity += $item->quantity;
                    $sku            = $item->sku;
                }

                $averagePrice = $totalQuantity > 0 ? round($totalAmount / $totalQuantity, 2) : 0;

                $validStatus = true;
                $validResult = [
                    'product_id'     => $id,
                    'total_quantity' => $totalQuantity,
                    'total_amount'   => $totalAmount,
                    'average_price'  => $averagePrice,
                    'sku'            => $sku
                ];
            }
        }

        return $this->response->setJSON([
            'success'  => $validStatus,
            'message'  => $validMsg,
            'products' => $validResult
        ]);
    }

    public function save() {
        if(!$this->request->isAJAX()){
            return $this->response->setJSON(['success' => false,'message' => lang('Custom.invalidRequest')]);
        }
        if(!haspermission('','create_product_management')) {
            return $this->response->setJSON(['success' => false,'message' => lang('Custom.permissiondenied')]);
        }
        $message = '';
        $validStatus = false;
        $rules = [
            'title'         => 'required|min_length[3]',
            'category'      => 'required',
            'note'          => 'required',
            'products'      => 'required',
            'price'         => 'required',
           // 'current_stock' => 'required',
            //'status'        => 'required',
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false,'errors' => $this->validator->getErrors()]);
        }

        $file = $this->request->getFile('file');
        $selectedImage = $this->request->getPost('selected_image');
        $id = decryptor($this->request->getPost('itmId'));

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Upload new image
            $upload = json_decode($this->imgUploader->uploadimg($file, 'products'), true);
            $imagePath = ($upload['status'] == true ? base_url($upload['file']) : '');
        } else {
            // Keep old image if no new upload
            $imagePath = $selectedImage;
        }

        // multiple Images
        $selectedImages = $this->request->getPost('selected_images')[0] ?? '[]';
        $selectedImages = html_entity_decode($selectedImages); // decode &quot;
        $selectedImages = json_decode($selectedImages, true);

        $uploadedPaths = [];
        if(!empty($selectedImages)){
        foreach ($selectedImages as $img) {
            if (strpos($img, 'data:image') === 0) {
                // Handle base64 image
                list($type, $data) = explode(';', $img);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);

                if (strpos($type, 'image/jpeg') !== false) $ext = '.jpeg';
                elseif (strpos($type, 'image/jpg') !== false) $ext = '.jpg';
                elseif (strpos($type, 'image/png') !== false) $ext = '.png';
                elseif (strpos($type, 'image/webp') !== false) $ext = '.webp';
                elseif (strpos($type, 'image/gif') !== false) $ext = '.gif';
                else $ext = '.jpg';

                $fileName = time() . '_' . uniqid() . $ext;
                $uploadPath =  './uploads/products/' . $fileName;

                if (!is_dir(dirname($uploadPath))) {
                    mkdir(dirname($uploadPath), 0777, true);
                }
                file_put_contents($uploadPath, $data);
                $uploadedPaths[] = base_url('./uploads/products/' . $fileName);
                } else {
                    $uploadedPaths[] = $img;
                }
            }
        }


       $data = [
            'product_title' => $this->request->getPost('title'),
            'category_id'   => (int) $this->request->getPost('category'),
            'slug'           =>  slugify($this->request->getPost('title')),
            'product_id'    => (int) $this->request->getPost('products'),
            'price'         => (float) $this->request->getPost('price'),
            'current_stock' => (int) $this->request->getPost('current_stock'),
            'status'        => (int) $this->request->getPost('status'),
            'compare_price' => (float) $this->request->getPost('compare_price'),
            'price_offer_type' => (int) ($this->request->getPost('price_offer_type') ?? 1),
            'short_description' => $this->request->getPost('note'),
            'description' => $this->request->getPost('description'),
            'seo_title' => $this->request->getPost('meta_title'),
            'seo_description' => $this->request->getPost('meta_keywords'),
            'product_status'=> $this->request->getPost('status') ? 1 : 0,
            'premium_product'=> $this->request->getPost('premium') ? 1 : 0,
            'featured_product'=> $this->request->getPost('featured') ? 1 : 0,
        ];
      
        if(!empty($imagePath)) {
            $data['product_image'] = $imagePath;
        }

        if($id){
            $this->productManageModel->update($id,$data);
             if(!empty($uploadedPaths)) {
                foreach ($uploadedPaths as $url) {
                        $this->productvariantImagesModel->insert(['product_id'   => $id,'image' => $url]);
                }
            }

            $message = 'Data successfully updated';
            $validStatus = true;
        }else{
            $this->productManageModel->insert($data);
            $message = 'Data successfully added';
            $validStatus = true;
        }
        return $this->response->setJSON(['success' => $validStatus,'message' => $message]);
    }

    public function getinfo($id =false) {
       
        if(!haspermission('','create_product_management')) {
            return $this->response->setJSON(['success' => false,'message' => lang('Custom.permissiondenied')]);
        }
        $product = [];
        $id = decryptor($id);
        $data = $this->productManageModel->getInfo($id);
        if($data){
            foreach($data as $row) {
                $productId = $row->id;

                if(!isset($product[$productId])) {
                    $product[$productId] = [
                        'id' => encryptor($row->id),
                        'product_title' => $row->product_title,
                        'product_id' => $row->product_id,
                        'category_id' => $row->category_id,
                        'price' => $row->price,
                        'compare_price' => $row->compare_price,
                        'image' => validImg($row->product_image),
                        'product_status' => $row->product_status,
                        'seo_title' => $row->seo_title,
                        'seo_description' => $row->seo_description,
                        'short_description' => $row->short_description,
                        'description' => $row->description,
                        'price_offer_type' => $row->price_offer_type,
                        'premium_product' => $row->premium_product,
                        'featured_product' => $row->featured_product,
                        'created_at' => $row->created_at,
                        'updated_at' => $row->updated_at,
                        'variantimages' => [],
                        'highlights'    => [],
                    ];
                }
                if($row->variantimages) {

                    $product[$productId]['variantimages'][] = [
                        'image' => $row->variantimages,
                        'id' => encryptor($row->variantimageid)
                    ];
                }
            }
        }
        $product = array_values($product);
        return $this->response->setJSON(['success' => true,'message' => lang('Custom.success'),'result' => $product]);
    }
    
    public function glleryDelete($id) {
        if(!hasPermission('','create_product_management')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
       
        if(empty($id)) {
            return $this->response->setJSON(['success' => false , 'message' => 'ddss d']);
        }
        $status = false;
        $msg = '';
        $item = $this->productvariantImagesModel->find(decryptor($id));
        if($item) {
            if($this->productvariantImagesModel->where(['id' => decryptor($id)])->delete()) {
                $status  = true;
                $msg = 'Successfully Deleted';
            }else{
                $msg = '!Opps try agian';
            }
        }else{
            $msg = '!Opps try agian';
        }
        return $this->response->setJSON(['success' => $status , 'message' => $msg]);
    }

    public function delete($id) {
        if(!hasPermission('','delete_product_management')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
      
        $status = false;
        $msg = '';
        $item = $this->productManageModel->find(decryptor($id));
        if($item) {
            if($this->productManageModel->update(decryptor($id),['product_status'=>2])) {
                $status  = true;
                $msg = 'Successfully Deleted';
            }else{
                $msg = '!Opps try agian';
            }
        }else{
            $msg = '!Opps try agian';
        }
        return $this->response->setJSON(['success' => $status , 'message' => $msg]);
    }

}