<?php

namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\ExpertiseModel;
use App\Controllers\UploadImages;

class ExpertiseController extends Controller {
    protected $expertiseModel;
    protected $imgUploader;

    function __construct() {
        $this->expertiseModel = new ExpertiseModel();
        $this->imgUploader = new UploadImages();
    }

    public function index() {
        $page = (hasPermission('','view_expertise') ? ucwords(getappdata('expertise')) : lang('Custom.permissionDenied'));
        $route = (hasPermission('','view_expertise') ? 'admin/expertise/index' :'pages-error-404');
        return view($route,compact('page'));
    }

    public function save () {
        if(!hasPermission('','create_expertise')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
        $rules = [
            'title' => 'required|min_length[2]'
        ];
        if(!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false , 'errors' => $this->validator->getErrors()]);
        }
        $file = $this->request->getFile('file');
        $selectedImage = $this->request->getPost('selected_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Upload new image
            $upload = json_decode($this->imgUploader->uploadimg($file, 'expertise'), true);
            $imagePath = ($upload['status'] == true ? base_url($upload['file']) : '');
        } else {
            // Keep old image if no new upload
            $imagePath = $selectedImage;
        }

        $id = decryptor($this->request->getPost('itmId'));
        $data = [
            'title' => $this->request->getPost('title'),

        ];
        if(!empty($imagePath)) {
            $data['image'] = $imagePath;
        }
        $validStatus = false;
        $validMsg = '';
        
        if($id) {
            $data['updated_by'] = session('user_data')['id'];
            $data['updated_at'] = date('Y-m-d,H:i:s');
            if($this->expertiseModel->update($id,$data)) {
                $validStatus = true;
                $validMsg   = 'New Expertise Updated Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }else{
            $data['created_by'] = session('user_data')['id'];
            if($this->expertiseModel->insert($data)) {
                $validStatus = true;
                $validMsg   = 'New Expertise Added Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }
        return $this->response->setJSON(['success' => $validStatus, 'message' => $validMsg]);
    }

    function expertiseData(){
        $validMsg = '';
        if(!hasPermission('','create_expertise')) {
            $validMsg = $message = lang('Custom.permissionDenied');
        }
        if(!$this->request->isAJAX()) {
          $validMsg = $message = lang('Custom.invalidRequest');
        }
        $status = false;
        $search = $this->request->getPost('search');
        $data = $this->expertiseModel->getexpdata($search);
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
    public function getExpertise($id=false) {
        $data = $this->expertiseModel->where(['id' => decryptor($id)])->first();
        if ($data) {
            $bannedadatatar['image'] = !empty($data['image']) 
                ? $data['image']
                : base_url('uploads/default.png');
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['error' => 'Banner not found']);
    }
    public function delete($id) {
        if(!hasPermission('','delete_expertise')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
      
        $status = false;
        $msg = '';
        if($id) {
            if($this->expertiseModel->update(decryptor($id),['status' => 2])) {
                $status  = true;
                $msg = 'Successfully Deleted';
            }else{
                 $msg = '!Opps try agian';
            }
        }
        return $this->response->setJSON(['success' => $status , 'message' => $msg]);
    }
}