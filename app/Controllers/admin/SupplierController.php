<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\SupplierModel;

class SupplierController extends Controller {
    protected $supplierModel;
    function __construct() {
        $this->supplierModel = new SupplierModel();
    }
    public function index() {
        $page = (!hasPermission('','view_supplier') ? lang('Custom.permissionDenied') : 'Suppliers');
        return view('admin/supplier/index',compact('page'));
    }

    public function create($id=false) {
        $page = (!hasPermission('','create_supplier') ? lang('Custom.permissionDenied') : 'Create Suppliers');
        $pageroute = (!hasPermission('','create_supplier') ? 'pages-error-404' : 'admin/supplier/create');
         if ($id){

            $page = "Edit Suppliers";
            $id = decryptor($id);
            $data = $this->supplierModel->where('id',$id)->first();

        }else{
            $selectedSpecialties = [];
            $data = '';
            $page = "Create Suppliers";
        }
        return view($pageroute,compact('page','data'));
    }

    function save(){

      
        $validSuccess = false;
        $validMsg = '';

        $id = decryptor($this->request->getPost('id'));

        if (!$this->request->isAJAX())
        {
            return $this->response->setJSON([
                'success' => false,
                'message' => "Invalid Request"
            ]);
        }
        if(!haspermission('','create_supplier') ) {
            return $this->response->setJSON(['success' =>false,'message' => 'Permission Denied']);
        }

        $rules = [
            'store' => 'required|min_length[3]|max_length[100]',
            //'phone' => 'required|numeric|min_length[8]|max_length[15]',
            'supplier_name' => 'required|min_length[2]', // assuming YYYY-MM-DD
        ];
        
      
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }
        //$file = $this->request->getFile('file');
       // $image =   ($file->isValid() && !$file->hasMoved() ? json_decode($this->imageUploader->uploadimg($file,'user'),true): ['status'=>false]);

        $data = [
            'store' => $this->request->getPost('store'),
            'supplier_name' => $this->request->getPost('supplier_name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'status' => 1,
        ];
        
        if ($id) {

            if ($this->supplierModel->update($id,$data)) {
              
                $validSuccess = true;
                $validMsg = "Updated Successfully";
            }else {
                $validMsg = "Somthing went wrong Please try agin later";
            }
        }else {

            if ($this->supplierModel->insert($data)) {
                
                $validSuccess = true;
                $validMsg = "New User Added Successfully";
            }else {echo "HERE";
                $validMsg = "Somthing went wrong Please try agin later";
            }
        }
        
        return $this->response->setJSON([
            'success' => $validSuccess,
            'message' => $validMsg,
        ]);
    }

     function list() {

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid Request'
            ]);
        }
        if (!haspermission('','view_supplier')) {
             return $this->response->setJSON([
                'success' => false,
                'message' => 'Permission Denied'
            ]);
        }
        

        $search = $this->request->getPost('search');
        $filter = $this->request->getPost('filter');

        $staff = $this->supplierModel->getSupplier($search,$filter,);

        foreach ($staff as &$staffKey) {
            $staffKey['encrypted_id'] = encryptor($staffKey['id']);
        }

        return $this->response->setJSON([
            'success' => true,
            'suppliers' => $staff
        ]);
    }

    function delete() {

        if (!$this->request->isAjax()) {
            return $this->response->setJSON([ 'success' => false, 'message' => "Invalid Request"]);
        }
      
        $validSuccess = false;
        $validMsg = "oops! Item Not Valid ";
        
        $id = decryptor($this->request->getPost('id'));

        if ($id) {
            $staffFind =$this->supplierModel->where('id',$id)->find();
            if ($staffFind) {

                if( $this->supplierModel->update($id,['status'=>2])){
                    $validSuccess = true;
                    $validMsg = 'Deleted successfully!';
                }else{
                    $validMsg = 'Delete failed. Please try again.';
                }
            }
        }

        return $this->response->setJSON([
            'success' => $validSuccess,
            'message' => $validMsg
        ]);
    }

    public function history($id) {
        $id = decryptor($id);
        $pageRoute  = (!hasPermission('','view_supplier') ? 'pages-error-404':'admin/supplier/history' );
        $page = (!hasPermission('','view_supplier') ?  lang('Custom.permissionDenied'):'Supplier History' );
        return view($pageRoute,compact('page','id'));
    }

    public function historyList() {
        if(!$this->request->isAJAX()){
            return $this->response->setJSON(['success' => 400 ,'message' => lang('Custom.invalidRequest')]);
        }
        if(!hasPermission('','view_supplier')) {
            return $this->response->setJSON(['success' => 400 ,'message' => lang('Custom.permissionDenied')]);
        }
        $total = 0.00;
        $validStatus = 400;
        $validMsg = '';
        $result = '';
        $suppllierId = $this->request->getPost('id');
        $fromDate = $this->request->getPost('startDate');
        $toDate = $this->request->getPost('endDate');
        $filter = $this->request->getPost('filter');
        $paymentType = $this->request->getPost('paymentType');

        if(!empty($suppllierId)) {
            $result = $this->supplierModel->getTransactionHistory($suppllierId,$fromDate,$toDate,$filter,$paymentType);
            foreach($result as &$res){
                $total = $res['total'];
            }
        }else{
            $validMsg = "Supplier not valid please try again";
        }
        return $this->response->setJSON(['success' => $validStatus ,'message' =>$validMsg,'history' => $result,'total'=>$total]);
    }
}