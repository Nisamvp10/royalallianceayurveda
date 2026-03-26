<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ShippingAddressModel;
use App\Controllers\CheckoutController;

class ShippingAddressController extends BaseController
{
    protected $checkoutController;
    public function __construct() {
        $this->checkoutController = new CheckoutController();
    }
    public function save()
    {
        if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }
        $isLogin = $this->checkoutController->userLogin();
        if(!$isLogin){
            return $this->response->setJSON([
                'success' => false,
                'login' => false,
                'message' => 'User not logged in',
            ]);
        }
        $model = new ShippingAddressModel();
        
        $rules = [
            'shipping_name' => 'required|min_length[2]|max_length[50]',
            'shipping_phone' => 'required|min_length[10]|max_length[10]',
            'shipping_address' => 'required',
            'shipping_city' => 'required',
            'shipping_state' => 'required',
            'shipping_pincode' => 'required',
            'shipping_country' => 'required',
        ];

        if(!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }
        $userId = session('user');
        $shipping_address_id = $this->request->getPost('shipping_address_id');
      
        $data = [
            'user_id' => $userId['userId'],
            'session_id' => session()->get('cart_session'),
            'full_name' => $this->request->getPost('shipping_name'),
            'phone' => $this->request->getPost('shipping_phone'),
            'email' => $this->request->getPost('shipping_email'),
            'address_line1' => $this->request->getPost('shipping_address'),
            //'address_line2' => $this->request->getPost('shipping_address_line2'),
            'city' => $this->request->getPost('shipping_city'),
            'state' => $this->request->getPost('shipping_state'),
            'postal_code' => $this->request->getPost('shipping_pincode'),
            'country' => $this->request->getPost('shipping_country'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if($shipping_address_id){
            $model->update($shipping_address_id, $data);
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Address updated successfully'
            ]);
        }else{
           if($model->save($data)) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Address saved successfully'
            ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Failed to save address'
                ]);
            }
        }

        
    }

    public function getShippingAddress(){
        if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }
        $results = [];
        $isLogin = $this->checkoutController->userLogin();
        if(!$isLogin){
            $results = view('frontend/user/shipping-address-list',compact('isLogin'));
        }else{
            $model = new ShippingAddressModel();
            $userId = session('user');
            $data = $model->where('user_id', $userId['userId'])->findAll();
            $results = view('frontend/user/shipping-address-list', compact('data','isLogin'));
        }
        return $this->response->setJSON([
            'success' => true,
            'result' => $results
        ]);
    }

    public function setDefaultAddress(){
        if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
            ]);
        }
        $id = $this->request->getPost('address_id');
        if(empty($id)){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Address not found',
            ]);
        }
        $id = decryptor($id);
        $model = new ShippingAddressModel();
        $userId = session('user');
        $data = $model->where('user_id', $userId['userId'])->findAll();
       //first all address is_default = 0
       $model->where('user_id', $userId['userId'])->set(['is_default' => 0])->update();
       //then set the clicked address is_default = 1
       $model->where('id', $id)->set(['is_default' => 1])->update();
       if($model->affectedRows() > 0){
           return $this->response->setJSON([
               'success' => true,
               'message' => 'Address set as default successfully'
           ]);
       }else{
           return $this->response->setJSON([
               'success' => false,
               'message' => 'Failed to set address as default'
           ]);
       }
    }
}