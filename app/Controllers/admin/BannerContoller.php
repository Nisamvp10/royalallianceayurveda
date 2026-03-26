<?php

namespace App\Controllers\admin;

use CodeIgniter\Controller;

use App\Controllers\UploadImages;
use App\Models\SliderModel;
class BannerContoller extends Controller {

    protected $imgUploader;
    protected $sliderModel;
    function __construct(){
        $this->imgUploader = new UploadImages();
        $this->sliderModel = new SliderModel();
    }

    
    public function index() {
        $page = (!hasPermission('','view_banner') ) ? lang('Custom.permissionDenied')  :'Banner';
        $route = (!hasPermission('','view_banner') ) ? lang('Custom.route')  :'admin/banner/index';

        return view($route,compact('page'));//
    }

    public function List() {
        if(!hasPermission('','view_banner')) {
            return $this->response->setJSON(['success' => false , 'msg' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'msg' => lang('Custom.invalidRequest')]);
        }
        $bannerItms = [];
        $status = false;
        $bannerItms = $this->sliderModel->where(['status' => 1])->orderBy('id','DESC')->findAll();
        if($bannerItms) {
            $status = true;
            foreach($bannerItms as &$item) {
                $title = $item['title'];
                $item['title'] = str_replace('<span> </span>',' ',$title);
                $item['encrypted_id'] = encryptor($item['id']);
            }
        }

        return $this->response->setJSON(['results' => $bannerItms,'success' => $status]);
       
    }

    function getBannerData($id) {
        $banner = $this->sliderModel->where(['id' => decryptor($id)])->first();
        if ($banner) {
            $banner['image'] = !empty($banner['image']) 
                ? $banner['image']
                : base_url('uploads/default.png');
                if (!empty($banner['title'])) {
                     $banner['title'] = preg_replace('/<\/?span[^>]*>/', '', $banner['title']);
                    $banner['title'] = preg_replace('/\s+/', ' ', trim($banner['title']));
                }

            return $this->response->setJSON($banner);
        }

        return $this->response->setJSON(['error' => 'Banner not found']);
    }

    public function save() {
       
        if(!hasPermission('','create_banner')) {
            return $this->response->setJSON(['success' => false , 'msg' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'msg' => lang('Custom.invalidRequest')]);
        }

        $rules = [
            'banner_title' => 'required|min_length[5]|max_length[255]',
            'description'  => 'required|min_length[5]|max_length[255]',
        ];

        if(!$this->validate($rules)) {
           return $this->response->setJSON(['success' => false , 'errors' => $this->validator->getErrors()]);
        }

        $bannerTitle = $this->request->getPost('banner_title');
        $highlight   = $this->request->getPost('highlight');
        $description = $this->request->getPost('description');
        $id          = decryptor($this->request->getPost('bannerId'));
        $url         = $this->request->getPost('url');
        $buttonName  = $this->request->getPost('button_title');

        if($highlight && stripos($bannerTitle,$highlight) !== false) {
            $bannerTitle = str_replace($highlight,'<span>'.$highlight.'</span>',$bannerTitle);
        }
        $file = $this->request->getFile('file');
        $selectedImage = $this->request->getPost('selected_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Upload new image
            $upload = json_decode($this->imgUploader->uploadimg($file, 'slider'), true);
            $imagePath = ($upload['status'] == true ? base_url($upload['file']) : '');
        } else {
            // Keep old image if no new upload
            $imagePath = $selectedImage;
        }

        $data = [
            'title'     => $bannerTitle,
            'subtitle'  => $description,
            'highlight' => $highlight,
            'url'       => $url,
            'button_title' => $buttonName,
        ];
        if(!empty($imagePath)) {
            $data['image'] = $imagePath;
        }
        if($id) {
            $data['updated_by'] = session('user_data')['id'];
            $data['updated_at'] = date('Y-m-d,H:i:s');
            if($this->sliderModel->update($id,$data)) {
                $status = true;
                $message = 'New Banner Updated Successfully';
            }else{
                $message = '!Oops Something went wrong Please try again later'; 
            }
        }else{
            $data['created_by'] = session('user_data')['id'];
            if($this->sliderModel->insert($data)) {
                $status = true;
                $message = 'New Banner Added Successfully';
            }else{
                $message = '!Oops Something went wrong Please try again later'; 
            }
        }
        return $this->response->setJSON(['success' => $status , 'message' => $message]);
    }

    public function delete($id) {
        if(!hasPermission('','delete_banner')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
      
        $status = false;
        $msg = '';
        if($id) {
            if($this->sliderModel->update(decryptor($id),['status' => 2])) {
                $status  = true;
                $msg = 'Successfully Deleted';
            }else{
                 $msg = '!Opps try agian';
            }
        }
         return $this->response->setJSON(['success' => $status , 'message' => $msg]);
    }

    public function getUploadedImages()
    {
        $folder = $this->request->getGet('folder') ?? 'slider';
        $uploadPath = FCPATH . 'uploads/'.$folder.'/';
        $files = [];
        if (is_dir($uploadPath)) {
            $images = array_diff(scandir($uploadPath), ['.', '..']);
            foreach ($images as $img) {
                if (preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $img)) {
                    $files[] = base_url('uploads/'.$folder.'/' . $img);
                }
            }
        }

        return $this->response->setJSON($files);
    }

    function getMutiUploadedImages() {
        $folder = $this->request->getGet('folder') ?? 'slider';
        $uploadPath = FCPATH . 'uploads/'.$folder.'/';
        $urls = []; 
        if(is_dir($uploadPath)) {
            $images = array_diff(scandir($uploadPath),['.','..']);
            foreach ($images as $img) {
                if (preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $img)) {
                    $urls[] = base_url('uploads/'.$folder.'/' . $img);
                }
            }
        }
         return $this->response->setJSON($urls);
    }
}