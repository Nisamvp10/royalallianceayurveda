<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\UsersregistrationsModel;

class ClientsController extends Controller
{
    protected $usersregistrationsModel;
    public function __construct()
    {
        $this->usersregistrationsModel = new UsersregistrationsModel();
    }
    public function index()
    {
        $page = (hasPermission('','view_clients') ?  ucwords(getappdata('clients')) : lang('Custom.permissionDenied'));
        $route = (hasPermission('','view_clients') ? 'admin/clients/clients' :'admin/pages-error-404');
        return view('admin/clients/index',compact('page','route'));
    }
    function list() {

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid Request'
            ]);
        }
        if (!haspermission('','view_clients')) {
             return $this->response->setJSON([
                'success' => false,
                'message' => 'Permission Denied'
            ]);
        }

        $search = $this->request->getPost('search');
        $filter = $this->request->getPost('filter');
        $branch = $this->request->getPost('branch');

        $clients = $this->usersregistrationsModel->getUsers($search,$filter,$branch);

        foreach ($clients as &$clientKey) {
            $clientKey['encrypted_id'] = encryptor($clientKey['id']);
        }

        return $this->response->setJSON([
            'success' => true,
            'clients' => $clients
        ]);
    }
    public function delete($id=false)
    {
        if (!haspermission('','delete_client')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Permission Denied'
            ]);
        }
        $id = decryptor($id);
        $this->usersregistrationsModel->update($id,['status' => 0]);
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Client Inactive successfully'
        ]);
    }
    public function active($id)
    {
        if (!haspermission('','delete_client')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Permission Denied'
            ]);
        }
        if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid Request'
            ]);
        }
        $id = decryptor($id);
        $this->usersregistrationsModel->update($id,['status' => 1]);
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Client Active successfully'
        ]);
    }
    
}