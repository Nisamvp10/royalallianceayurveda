<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\FeedbackModel;
use App\Controllers\UploadImages;

class FeedbackController extends Controller {
    protected $feedbackModel;
    protected $imgUploader;

    function __construct() {
        $this->feedbackModel = new FeedbackModel();
        $this->imgUploader = new UploadImages();
    }
     public function index() {
        $page = (hasPermission('','feedback') ? ' Feedback' : lang('Custom.permissionDenied'));
        $route = (hasPermission('','feedback') ? 'admin/feedback/index' :'admin/pages-error-404');
        return view($route,compact('page'));
    }

    public function save () {
        if(!hasPermission('','create_feedback')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
        $rules = [
            'name' => 'required|min_length[2]',
            'designation' => 'required|min_length[2]|max_length[100]',
            'note'        => 'required|min_length[5]|max_length[500]'
        ];
        if(!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false , 'errors' => $this->validator->getErrors()]);
        }
        $file = $this->request->getFile('file');
        $selectedImage = $this->request->getPost('selected_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Upload new image
            $upload = json_decode($this->imgUploader->uploadimg($file, 'feedback'), true);
            $imagePath = ($upload['status'] == true ? base_url($upload['file']) : '');
        } else {
            // Keep old image if no new upload
            $imagePath = $selectedImage;
        }

        $id = decryptor($this->request->getPost('itmId'));
        $data = [
            'username' => $this->request->getPost('name'),
            'designation' => $this->request->getPost('designation'),
            'note' => $this->request->getPost('note'),

        ];
        if(!empty($imagePath)) {
            $data['profile'] = $imagePath;
        }
        $validStatus = false;
        $validMsg = '';
        
        if($id) {
            $data['updated_by'] = session('user_data')['id'];
            $data['updated_at'] = date('Y-m-d,H:i:s');
            if($this->feedbackModel->update($id,$data)) {
                $validStatus = true;
                $validMsg   = 'New Feedback Updated Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }else{
            $data['created_by'] = session('user_data')['id'];
            if($this->feedbackModel->insert($data)) {
                $validStatus = true;
                $validMsg   = 'New Feedback Added Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }
        return $this->response->setJSON(['success' => $validStatus, 'message' => $validMsg]);
    }

    function feedbackData(){
        $validMsg = '';
        if(!hasPermission('','create_feedback')) {
            $validMsg = $message = lang('Custom.permissionDenied');
        }
        if(!$this->request->isAJAX()) {
          $validMsg = $message = lang('Custom.invalidRequest');
        }
        $status = false;
        $search = $this->request->getPost('search');
        $data = $this->feedbackModel->getData($search);
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
    public function getfeedback($id=false) {
        $data = $this->feedbackModel->select('id,profile,designation,note,username')->where(['id' => decryptor($id)])->first();
        if ($data) {
            $data['image'] = !empty($data['profile']) 
                ? $data['profile']
                : base_url('uploads/default.png');
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['error' => 'Feedback not found']);
    }
    public function delete($id) {
        if(!hasPermission('','feedback_delete')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
      
        $status = false;
        $msg = '';
        if($id) {
            if($this->feedbackModel->update(decryptor($id),['status' => 2])) {
                $status  = true;
                $msg = 'Successfully Deleted';
            }else{
                 $msg = '!Opps try agian';
            }
        }
        return $this->response->setJSON(['success' => $status , 'message' => $msg]);
    }
}