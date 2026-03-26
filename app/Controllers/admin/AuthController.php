<?php
namespace App\Controllers\admin;

use App\Models\UserModel;
use App\Models\RoleModel;
use CodeIgniter\Controller;
use App\Models\ProductModel;
use App\Models\ServiceModel;
use App\Models\CustomerOrderModel;
use App\Models\ProductManageModel;

class AuthController extends Controller {
    protected $userModel;
    protected $roleModel;
    protected $serviceModel;
    protected $productModel;
    protected $customerOrderModel;
    protected $productManagementModel;
    function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->serviceModel = new ServiceModel();
        $this->productModel = new ProductModel();
        $this->customerOrderModel = new CustomerOrderModel();
        $this->productManagementModel = new ProductManageModel();
    }

    function login() {

        if( !isLoggedIn()) {
            return view('template/auth/login');
        }
     
        $page = "Dashboard";
        $serviceCount = $this->serviceModel->where(['status' => 1])->countAllResults() ?? 0 ;
        $memberCount = $this->userModel->where(['role !=' => 1,'status' => 'approved'])->countAllResults() ?? 0 ;
        $productCount = $this->productModel->where(['status' => 1])->countAllResults() ?? 0 ;
        $salesItemCount = $this->productManagementModel->where(['product_status' => 1])->countAllResults() ?? 0 ;
        $orderCount = $this->customerOrderModel->countAllResults() ?? 0 ;
       if(session()->get('user_data')['role'] == 6)
       {
            //echo $this->productInfoModel->getLastQuery();

            return view('admin/dashboard',compact('page','serviceCount','memberCount','productCount'));

       }else{
            return view('admin/dashboard',compact('page','serviceCount','memberCount','productCount','orderCount','salesItemCount'));

       }
    }

    function attemptLogin() {
        
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success'=> false,'message' => lang('Cutom.invalidRequest')]);
        }
        
        $validation = [
            'email'     => 'required|valid_email',
            'password'  => 'required|min_length[6]',
        ];

        if(!$this->validate($validation )) {
            return $this->response->setJSON(['success' => false,'errors' => $this->validator->getErrors()]);
        }

        $userName = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $userData = $this->userModel->where('email',$userName)->first();

        if($userData) {
            if($userData && password_verify($password,$userData['password'])) {

                if ($userData['status'] === 'approved') { 

                    $session    = session();
                    $roleModel  = new RoleModel(); 
                    $type = $roleModel->where('id',$userData['role']);
                    $loginHistory = [
                        'user_id'    =>  $userData['id'],
                        'login_time' => date('Y-m-d H:i:s'),
                        'ip_address' => $this->request->getIPAddress(),
                        'user_agent' => $this->request->getUserAgent(),
                    ];

                    $loginData = [
                        'id'        => $userData['id'],
                        'username'  => $userData['name'],
                        'role'      => $userData['role'],
                        'type'      => $type->role_name,
                        'isLoggedIn' => true
                    ];
                    $session->set('user_data',$loginData);
                    return $this->response->setJSON(['success' => true, 'message' => '']);
                }else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Your account is pending approval. Please contact the admin. ']);
                }
            }else{
                return $this->response->setJSON(['success' => false, 'message' => 'Incorrect Password ']);
            }
        }else {
            return $this->response->setJSON(['success' => false, 'message' => 'Username Not valid']);
        }

    }

    function logout() 
    {
        session()->destroy();
        return  redirect()->to(base_url('admin/login'));
    }

}