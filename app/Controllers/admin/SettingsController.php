<?php
namespace App\Controllers\admin;
use App\Controllers\UploadImages;
use App\Models\UserModel;
use CodeIgniter\Controller;

class SettingsController extends Controller{
    protected $userData;
    protected $uploadImg;
    protected $userModel;
    protected $clientTitle;
    function __construct(){
        $this->userData = session()->get('user_data');
        $this->uploadImg = new UploadImages();
        $this->userModel = new UserModel();
    }

    function index(){
        $userRole=  $this->userData['role'];
        if($this->userData['role'] ==1 || hasPermission('','settings')){
            $clients = '';
            return view('template/settings/index',compact('clients','userRole'));
        }else{
            redirect()->to('dashboard');
        }
    }
    

    function save(){
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $rules = [
            'company_name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[10]',
            'address' => 'required|min_length[5]',
            //'tax_number' => 'required|min_length[5]',
            //'notification_email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $postData = $this->request->getPost();
         if (isset($postData['site_mode'])) {
            $postData['site_mode'] = 'on';
        } else {
            $postData['site_mode'] = 'off';
        }
        if(isset($postData['order_status_mail_notification'])){
            $postData['order_status_mail_notification'] = 'on';
        }else{
            $postData['order_status_mail_notification'] = 'off';
        }
        if(isset($postData['invoice_type'])){
            $postData['invoice_type'] = 'on';
        }else{
            $postData['invoice_type'] = 'off';
        }
        foreach($postData as $key => $value){

            saveSettings($key,$value);
        }
        if(isset($_FILES['file']['name'])) { 
            $file = $this->request->getFile('file');
            $logo = $this->uploadimgae($file,'logo',getappdata('applogo'));
          
            if(!empty($logo['file'])) {
                saveSettings('applogo',$logo['file']);
            }
        }

        try {
           // $this->settingsModel->save($data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Settings updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update settings'
            ]);
        }

    }

     function terms_save(){
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        $postData = $this->request->getPost();
        foreach($postData as $key => $value){

            saveSettings($key,$value);
        }
         try {
           // $this->settingsModel->save($data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Settings updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update settings'
            ]);
        }

     }

    function titleSave() {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        $postData = $this->request->getPost();
        if(!empty($postData)) {
            foreach($postData as $key => $value){

                saveSettings($key,strtolower($value));
            }
        }
        try {
           // $this->settingsModel->save($data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Settings updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update settings'
            ]);
        }
    }

    function uploadimgae($file,$folder,$oldPath) {
        if(!empty($_FILES['file']['name'])) {
            $image =   ($file->isValid() && !$file->hasMoved() ? json_decode($this->uploadImg->uploadimg($file,$folder),true):'');

            if(!empty( $image['file'])) {
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            return  $image;

            
        }
    }
    function __titleSave() {

    // Ensure AJAX request
    if (!$this->request->isAJAX()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => lang('Custom.invalidRequest')
        ]);
    }

    $titles = $this->request->getPost('titles');
    $clientId = $this->request->getPost('client');

    $validMsg = '';
    $validStatus = false;

    if ($clientId && is_array($titles)) {
        foreach ($titles as $slug => $label) {
            // sanitize
            $slug = trim(strtolower($slug));
            $label = trim($label);

            if ($slug === '' || $label === '') continue;

            $exist = $this->clientTitle
                ->where('client_id', $clientId)
                ->where('slug', $slug)
                ->first();

               

            if ($exist) {
                $data = ['label' => $label];
                $this->clientTitle->where(['client_id' => $clientId, 'slug' => $slug])->set($data)->update();
                $validMsg = "Successfully Updated";
            } else {
                $this->clientTitle->insert([
                    'client_id' => $clientId,
                    'slug' => $slug,
                    'label' => $label
                ]);
                $validMsg = "New Labels Saved";
            }

            $validStatus = true;
        }
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Client or labels missing.'
        ]);
    }

    return $this->response->setJSON([
        'success' => $validStatus,
        'message' => $validMsg
    ]);
    }


    public function get_titles_by_client()
    {
        $clientId = $this->request->getPost('client_id');
        $result = $this->clientTitle->where('client_id', value: $clientId)->get()->getResult();

        $labels = [];
        foreach ($result as $row) {
            $labels[$row->slug] = $row->label;
        }

        return $this->response->setJSON($labels);
    }

}