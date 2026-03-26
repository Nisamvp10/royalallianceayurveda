<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\CategoryModel;

class CategoryController extends Controller{
    protected $categoryModel;

    function __construct(){
         $this->categoryModel = new CategoryModel();
    }

    function index(){
        $page = (hasPermission('','category') ?  ucwords(getappdata('category')) : lang('Custom.permissionDenied'));
        $route = (hasPermission('','category') ? 'admin/category/category' :'admin/pages-error-404');
        $roles = $this->categoryModel->orderBy('level','ASC')->findAll();
        return view($route,compact('page','roles'));
    }
    

    function save(){
        if(!$this->request->isAJAX())
        {
            return $this->response->setJSON(['success' => false,'message' => ' Invalid Request']);
        }
        if(!haspermission('','create_category')) {
            return $this->response->setJSON(['success' => false,'message' => ' Permission Denied']);
        }
        $validSuccess = false;
        $validMsg = '';

        $rules = [
            'category' => 'required|min_length[3]|max_length[100]',
        ];

        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $category = $this->request->getPost('category');
        $id = decryptor($this->request->getPost('itmId'));
        $parentId = $this->request->getPost('parent_id');

        $level = 1;
        if ($parentId) {
            $parent = $this->categoryModel->find($parentId);
            $level = $parent['level'] + 1;
        }

        $data = [
            'category' => $category,
            'parent_id' => $parentId ?: null,
            'slug' => slugify( $category),
            'level' => $level
        ];
        
        if($id)
        {
            if($this->categoryModel->update($id, $data)){

                $validSuccess = true;
                $validMsg = "Updated successfully!";
            }else{
                $validMsg = 'something went wrong Please Try again';
            }
        }else{
            if($this->categoryModel->insert($data)){

                $validSuccess = true;
                $validMsg = "New ".getappdata('category')." Added";
            }else{
                $validMsg = 'something went wrong Please Try again';
            }
        }
        return $this->response->setJSON([
            'success' => $validSuccess,
            'message' => $validMsg,
        ]);
    }
    function categoryList(){

        if(!$this->request->isAJAX()){
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid Request']);
        }
        if(!haspermission('','category')) {
            return $this->response->setJSON(['success' => false,'message' => ' Permission Denied']);
        }
        $search = $this->request->getPost('search');
        $filter = $this->request->getPost('filter');
        $status = false;
        $builder = $this->categoryModel->getdata($search,$filter );
        $categories = $builder;
        if($categories){
            $status = true;
            foreach($categories as &$category){
                $category['encrypted_id'] = encryptor($category['id']);
            }
        }else {
            $status = false;
        }
        return $this->response->setJSON([
            'success' => $status,
            'categories' => $categories,
        ]);
    }
     function getinfo($id=false){
        $data = $this->categoryModel->where(['id' => decryptor($id)])->first();
        if ($data) {
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['error' => 'Banner not found']);
    }
    
    function delete($id)
    {
        if(!hasPermission('','delete_category')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }

        $id = decryptor($id);
        $validSuccess = false;
        $validMsg = "oops! Item Not Valid ";
        if($id)
        {
            $branch = $this->categoryModel->find($id); 
            if($branch){
                //check assigned any staff and appoint ment in the branch 
                if( $this->categoryModel->update($id,['is_active'=>0])){
                    $validSuccess = true;
                    $validMsg = 'Category Inactive successfully!';
                }else{
                    $validMsg = 'Oops. Please try again.';
                }
            }
        }
        return $this->response->setJson([
            'success' => $validSuccess,
            'message' => $validMsg
        ]);
    }
    function unlock()
    {
        $id = decryptor($this->request->getVar('id'));
        $validSuccess = false;
        $validMsg = "oops! Item Not Valid ";
        if($id)
        {
            $branch = $this->categoryModel->find($id);
            if($branch){
                //check assigned any staff and appoint ment in the branch 
                if( $this->categoryModel->update($id,['is_active'=>1])){
                    $validSuccess = true;
                    $validMsg = 'Category Active successfully!';
                }else{
                    $validMsg = 'Oops. Please try again.';
                }
            }
        }
        return $this->response->setJson([
            'success' => $validSuccess,
            'message' => $validMsg
        ]);
    }

    function ajaxcategory() {
         if(!haspermission('','category')) {
            return $this->response->setJSON(['success' => false,'message' => 'Permission Denied']);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false,'message' => ' Invalid Request']);
        }
        
        $category =  $this->categoryModel->where('is_active',1)->findAll();
        return $this->response->setJSON(['success' => true,'result'=>$category]) ;
    }
}
