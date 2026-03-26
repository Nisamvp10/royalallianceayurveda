<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\AchievementsModel;
use App\Controllers\UploadImages;

class AchievementsController extends Controller {
    protected $achievementModel;
    protected $imgUploader;

    function __construct() {
        $this->achievementModel = new AchievementsModel();
        $this->imgUploader = new UploadImages();
    }
     public function index() {
        $page = (hasPermission('','achievements') ? ucwords(getappdata('achievements')) : lang('Custom.permissionDenied'));
        $route = (hasPermission('','feedback') ? 'admin/achievements/index' :'admin/pages-error-404');
        return view($route,compact('page'));
    }

    public function save () {
        if(!hasPermission('','create_achievement')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
        $rules = [
            'title' => 'required|min_length[2]',
            'description' => 'required|min_length[2]|max_length[500]',
            'note'        => 'required|min_length[2]|max_length[100]'
        ];
        if(!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false , 'errors' => $this->validator->getErrors()]);
        }
        $file = $this->request->getFile('file');
        $selectedImage = $this->request->getPost('selected_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Upload new image
            $upload = json_decode($this->imgUploader->uploadimg($file, 'achievements'), true);
            $imagePath = ($upload['status'] == true ? base_url($upload['file']) : '');
        } else {
            // Keep old image if no new upload
            $imagePath = $selectedImage;
        }

        $id = decryptor($this->request->getPost('itmId'));
        $data = [
            'title' => $this->request->getPost('title'),
            'note' => $this->request->getPost('note'),
            'description' => $this->request->getPost('description'),

        ];
        if(!empty($imagePath)) {
            $data['image'] = $imagePath;
        }
        $validStatus = false;
        $validMsg = '';
        
        if($id) {
            $data['updated_by'] = session('user_data')['id'];
            $data['updated_at'] = date('Y-m-d,H:i:s');
            if($this->achievementModel->update($id,$data)) {
                $validStatus = true;
                $validMsg   = 'New Achievement Updated Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }else{
            $data['created_by'] = session('user_data')['id'];
            if($this->achievementModel->insert($data)) {
                $validStatus = true;
                $validMsg   = 'New Achievement Added Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }
        return $this->response->setJSON(['success' => $validStatus, 'message' => $validMsg]);
    }

    function list(){
        $validMsg = '';
        if(!hasPermission('','create_achievement')) {
            $validMsg = $message = lang('Custom.permissionDenied');
        }
        if(!$this->request->isAJAX()) {
          $validMsg = $message = lang('Custom.invalidRequest');
        }
        $status = false;
        $search = $this->request->getPost('search');
        $data = $this->achievementModel->getData($search);
        if($data) {
            $status = true;
            foreach($data as &$key) {
               $key['encrypted_id'] = encryptor($key['id']);
            }
            $result = $data;
        }else{
            $result = 0;
        }
        return $this->response->setJSON(['success' => $status , 'result' => $result,'message' => $validMsg]);
    }
    public function getinfo($id=false) {
        $data = $this->achievementModel->select('id,image,description,note,title')->where(['id' => decryptor($id)])->first();
        if ($data) {
            $data['image'] = !empty($data['image']) 
                ? $data['image']
                : base_url('uploads/default.png');
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['error' => 'Feedback not found']);
    }
    public function delete($id) {
        if(!hasPermission('','delete_achievement')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
      
        $status = false;
        $msg = '';
        if($id) {
            if($this->achievementModel->update(decryptor($id),['status' => 2])) {
                $status  = true;
                $msg = 'Successfully Deleted';
            }else{
                 $msg = '!Opps try agian';
            }
        }
        return $this->response->setJSON(['success' => $status , 'message' => $msg]);
    }
}