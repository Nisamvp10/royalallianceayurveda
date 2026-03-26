<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\UsersregistrationsModel;
use App\Models\CouponcodeModel;
use App\Models\CouponproductsModel;
class CoupenCodeController extends Controller
{
    protected $couponcodeModel;
    protected $couponproductsModel;
    public function __construct()
    {
        $this->couponcodeModel = new CouponcodeModel();
        $this->couponproductsModel = new CouponproductsModel();
    }
    public function index()
    {
        $page = 'Coupen Code';
        return view('admin/coupencode/index',compact('page'));
    }

    public function list() {
        if(!$this->request->isAjax()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid Request'
            ]);
        }


        $search = $this->request->getPost('search');
        $filter = $this->request->getPost('filterDate');
        $clients = $this->couponcodeModel->getCoupon('',$search,$filter);

        foreach ($clients as &$clientKey) {
            $clientKey['encrypted_id'] = encryptor($clientKey['id']);
            $clientKey['minimumShopping'] = money_format_custom($clientKey['minimumShopping']);
            $clientKey['maximum_discount_amount'] = money_format_custom($clientKey['maximum_discount_amount']);
            $clientKey['validity'] = 'From '.$clientKey['validity_from'].' To '.$clientKey['validity_to'];
            $clientKey['discount'] = $clientKey['discount_type'] == 1 ?money_format_custom($clientKey['discount']): $clientKey['discount'].'%';
        }
        return $this->response->setJSON([
            'success' => true,
            'data' => $clients
        ]);

    }
    public function save() {
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid Request'
            ]);
        }
        $rules = [
            'coupenType' => 'required',
            'coupencode' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
            'minimumShopping' => 'required',
            'maximum_discount_amount' => 'required',
            'filterDate' => 'required',
        ];
        if(!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        if($this->request->getPost('coupenType') == 2) {
            if(empty($this->request->getPost('products'))){
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => ['product' => 'Please select products']
                ]);
            }
        }

        $validateDate = $this->request->getPost('filterDate'); 
        $fromDate = explode(' to ', $validateDate)[0];
        $toDate = explode(' to ', $validateDate)[1];

        $id = $this->request->getPost('edit_id');
        
        $data = [
            'coupenType' => $this->request->getPost('coupenType'),
            'coupencode' => $this->request->getPost('coupencode'),
            'discount' => $this->request->getPost('discount'),
            'discount_type' => $this->request->getPost('discount_type'),
            'minimumShopping' => $this->request->getPost('minimumShopping'),
            'maximum_discount_amount' => $this->request->getPost('maximum_discount_amount'),
            'validity_from' => $fromDate,
            'validity_to' => $toDate,
            'description'   => $this->request->getpost('description')
        ];

        if($id) {
            if($this->couponcodeModel->update($id, $data)) {
                if($this->request->getPost('coupenType') == 2) {
                    $this->couponproductsModel->where('coupen_id', $id)->delete();
                    $data = [
                        'coupen_id' => $id,
                        'product_id' => $this->request->getPost('products'),
                    ];
                    $this->couponproductsModel->insertBatch($data);
                }
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Coupen Code Updated successfully'
                ]);
            }

        }else{
            if($this->couponcodeModel->insert($data)) {

                if($this->request->getPost('coupenType') == 2) {
                    $data = [
                        'coupen_id' => $this->couponcodeModel->insertID(),
                        'product_id' => $this->request->getPost('products'),
                    ];
                    $this->couponproductsModel->insertBatch($data);
                }
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Coupen Code Added successfully'
                ]);
            }
        }
        
    }

    public function getinfo($id=false) {
      
        $id = decryptor($id);
        $coupon = $this->couponcodeModel->find($id);
        return $this->response->setJSON([
            'success' => true,
            'data' => $coupon
        ]);
    }

    public function delete($id=false) {
        $id = decryptor($id);
        if($this->couponcodeModel->update($id, ['is_active' => 0])) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Coupen Code Deleted successfully'
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Coupen Code Not Deleted'
        ]);
    }
    
}
