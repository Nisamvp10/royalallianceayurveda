<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\BlogModel;
use App\Controllers\UploadImages;
use App\Models\BloghighlightsModel;
use App\Models\BloggalleryModel;

class BlogController extends Controller {
    protected $blogModel;
    protected $imgUploader;
    protected $bloghighlights;
    protected $blogimgModel;

    function __construct() {
        $this->blogModel = new BlogModel();
        $this->imgUploader = new UploadImages();
        $this->bloghighlights = new BloghighlightsModel();
        $this->blogimgModel = new BloggalleryModel();
    }
     public function index() {
        $page = (hasPermission('','blog') ?  ucwords(getappdata('blog')) : lang('Custom.permissionDenied'));
        $route = (hasPermission('','blog') ? 'admin/blog/index' :'admin/pages-error-404');
        return view($route,compact('page'));
    }

    public function save () {
        if(!hasPermission('','create_blog')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
        $rules = [
            'title' => 'required|min_length[2]',
            'note'  => 'required|min_length[2]|max_length[800]',
            'type'  => 'required|min_length[2]',
        ];
        if(!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false , 'errors' => $this->validator->getErrors()]);
        }
        $pointsErrors = [];
        $points = $this->request->getPost('points');
        foreach($points as $i => $point) {
            if(empty($point)) {
                $pointsErrors["points.$i"] = "Point is required.";
            }
        }

        if(!empty($pointsErrors)) {
            return $this->response->setJSON(['success' => false , 'pointsErrors' =>$pointsErrors]);
        }
        $pointsData = [];

        foreach($points as $i => $pnt) {
            $pointsData[] = [
                'points' => $pnt
            ];
        }
        $file = $this->request->getFile('file');
        $selectedImage = $this->request->getPost('selected_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Upload new image
            $upload = json_decode($this->imgUploader->uploadimg($file, 'news'), true);
            $imagePath = ($upload['status'] == true ? base_url($upload['file']) : '');
        } else {
            // Keep old image if no new upload
            $imagePath = $selectedImage;
        }

        // multiple Images
        $selectedImages = $this->request->getPost('selected_images')[0] ?? '[]';
        $selectedImages = html_entity_decode($selectedImages); // decode &quot;
        $selectedImages = json_decode($selectedImages, true);

        $uploadedPaths = [];
        if(!empty($selectedImages)){
        foreach ($selectedImages as $img) {
            if (strpos($img, 'data:image') === 0) {
                // Handle base64 image
                list($type, $data) = explode(';', $img);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);

                if (strpos($type, 'image/jpeg') !== false) $ext = '.jpeg';
                elseif (strpos($type, 'image/jpg') !== false) $ext = '.jpg';
                elseif (strpos($type, 'image/png') !== false) $ext = '.png';
                elseif (strpos($type, 'image/webp') !== false) $ext = '.webp';
                elseif (strpos($type, 'image/gif') !== false) $ext = '.gif';
                else $ext = '.jpg';

                $fileName = time() . '_' . uniqid() . $ext;
                $uploadPath =  './uploads/news/' . $fileName;

                if (!is_dir(dirname($uploadPath))) {
                    mkdir(dirname($uploadPath), 0777, true);
                }
                file_put_contents($uploadPath, $data);
                $uploadedPaths[] = base_url('./uploads/news/' . $fileName);
                } else {
                    $uploadedPaths[] = $img;
                }
            }
        }
        // close Multi section

        $id = decryptor($this->request->getPost('itmId'));
        //print_r($_POST); exit();
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'short_note' => $this->request->getPost('note'),
            'type'      => $this->request->getPost('type'),
        ];
        if(!empty($imagePath)) {
            $data['image'] = $imagePath;
        }
        $validStatus = false;
        $validMsg = '';
        
        if($id) {
            $data['updated_by'] = session('user_data')['id'];
            $data['updated_at'] = date('Y-m-d,H:i:s');
            // check already exist points 
            $this->bloghighlights->where('blog_id', $id)->delete();
            foreach($points as $point) {
                if(!empty($point)) {
                    $this->bloghighlights->insert(['blog_id' => $id,'points' => $point]);
                }
            }
            if(!empty($uploadedPaths)) {
                    foreach ($uploadedPaths as $url) {
                        $this->blogimgModel->insert(['blog_id'   => $id,'image_url' => $url]);
                    }
                }
            if($this->blogModel->update($id,$data)) {
                $validStatus = true;
                $validMsg   = 'New News Updated Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }else{
            $data['created_by'] = session('user_data')['id'];
            if($insertId = $this->blogModel->insert($data)) {
                if(!empty($pointsData)) {
                    foreach($pointsData as &$key) {
                        $key['blog_id'] = $insertId;
                    }
                }
                if(!empty($uploadedPaths)) {
                    foreach ($uploadedPaths as $url) {
                        $this->blogimgModel->insert([
                            'blog_id'   => $insertId,
                            'image_url' => $url
                        ]);
                    }
                }
                $this->bloghighlights->insertBatch($pointsData);
                $validStatus = true;
                $validMsg   = 'New News Added Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }
        return $this->response->setJSON(['success' => $validStatus, 'message' => $validMsg]);
    }

    function list(){
        $validMsg = '';
        $status = false;
        if(!hasPermission('','create_blog')) {
            $validMsg = $message = lang('Custom.permissionDenied');
        }
        if(!$this->request->isAJAX()) {
          $validMsg = $message = lang('Custom.invalidRequest');
        }
        $status = false;
        $search = $this->request->getPost('search');
        $data = $this->blogModel->getData($search);
        $dataPoints= [];
        if($data) {
            foreach($data as $news) {
                $newsId = $news['id'];
                if(!isset($dataPoints[$newsId])) {
                    $dataPoints[$newsId] = [
                        'careerId'    => encryptor($newsId),
                        'title'       => $news['title'],
                        'shortnote'  =>  $news['short_note'],
                        'description' => $news['description'],
                        'image'       => $news['image'],
                        'type'        => $news['type'],
                        'highlights'  => [],
                    ];
                    if(!empty($news['pointId'])) {
                        $dataPoints[$newsId]['highlights'][] = [
                            'points'    => $news['points'],
                            'pointId'   => encryptor($news['pointId']),
                        ];
                    }
                    
                }
                else{
                    if(!empty($news['pointId'])) {
                        $existingPoints = array_column($dataPoints[$newsId]['highlights'], 'pointId');
                        if(!in_array(encryptor($news['pointId']),$existingPoints)) {
                            $dataPoints[$newsId]['highlights'][] = [
                                'points'    => $news['points'],
                                'pointId'   => encryptor($news['pointId'])
                            ];
                        }
                    }
                   
                }
            }
        }
        if($dataPoints) {
            $dataPoints = array_values($dataPoints);
            $status = true;
            $result = $dataPoints;
        }else{
            $result = 0;
        }
        return $this->response->setJSON(['success' => $status , 'result' => $result,'message' => $validMsg]);
    }
    public function getinfo($id=false) {
        $data = $this->blogModel->getData(decryptor($id));
        $dataPoints= [];
        if($data) {
            foreach($data as $career) {
                $careerId = $career['id'];
                if(!isset($dataPoints[$careerId])) {
                    $dataPoints[$careerId] = [
                        'careerId'    => encryptor($careerId),
                        'title'       => $career['title'],
                        'shortnote'  => $career['short_note'],
                        'description' => $career['description'],
                        'image'       => $career['image'],
                        'type'        => $career['type'],
                        'highlights'  => [],
                        'gallery'     => []
                    ];
                    if(!empty($career['pointId'])) {
                        $dataPoints[$careerId]['highlights'][] = [
                            'points'    => $career['points'],
                            'pointId'   => encryptor($career['pointId']),
                        ];
                    }
                    if(!empty($career['imgId'])) { 
                        $dataPoints[$careerId]['gallery'][] = [
                            'img'      => $career['image_url'],
                            'imgId'  => encryptor($career['imgId']),
                        ];
                    }
                }
                else{
                if (!empty($career['pointId'])) {
                    $existingPointIds = array_column($dataPoints[$careerId]['highlights'], 'pointId');
                    if (!in_array(encryptor($career['pointId']), $existingPointIds)) {
                        $dataPoints[$careerId]['highlights'][] = [
                            'points'  => $career['points'],
                            'pointId' => encryptor($career['pointId']),
                        ];
                    }
                }
                    if(!empty($career['imgId'])) {
                        $exsitingGalleryId = array_column( $dataPoints[$careerId]['gallery'],'imgId');
                        if(!in_array( encryptor($career['imgId']),$exsitingGalleryId)) {
                            $dataPoints[$careerId]['gallery'][] = [
                                'img'      => $career['image_url'],
                                'imgId'  => encryptor($career['imgId'])
                            ];
                        }
                    }
                }
            }
            $data = array_values($dataPoints);
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['error' => 'Feedback not found']);
    }
    public function delete($id) {
        if(!hasPermission('','delete_blog')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
      
        $status = false;
        $msg = '';
        $item = $this->blogModel->find(decryptor($id));
        if($item) {
            if($this->blogModel->where(['id' => decryptor($id)])->delete()) {
                $status  = true;
                $msg = 'Successfully Deleted';
            }else{
                $msg = '!Opps try agian';
            }
        }else{
            $msg = '!Opps try agian';
        }
        return $this->response->setJSON(['success' => $status , 'message' => $msg]);
    }

    public function glleryDelete($id) {
        if(!hasPermission('','delete_blog')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
       
        if(empty($id)) {
            return $this->response->setJSON(['success' => false , 'message' => 'ddss d']);
        }
        $status = false;
        $msg = '';
        $item = $this->blogimgModel->find(decryptor($id));
        if($item) {
            if($this->blogimgModel->where(['id' => decryptor($id)])->delete()) {
                $status  = true;
                $msg = 'Successfully Deleted';
            }else{
                $msg = '!Opps try agian';
            }
        }else{
            $msg = '!Opps try agian';
        }
        return $this->response->setJSON(['success' => $status , 'message' => $msg]);
    }
}