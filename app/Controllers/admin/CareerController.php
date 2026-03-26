<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\CareerModel;
use App\Controllers\UploadImages;
use App\Models\Careerhighlights;

class CareerController extends Controller {
    protected $careerModel;
    protected $imgUploader;
    protected $careerHighlight;

    function __construct() {
        $this->careerModel = new CareerModel();
        $this->imgUploader = new UploadImages();
        $this->careerHighlight = new Careerhighlights();
    }
     public function index() {
        $page = (hasPermission('','Careers') ? ' Careers' : lang('Custom.permissionDenied'));
        $route = (hasPermission('','Careers') ? 'admin/careers/index' :'admin/pages-error-404');
        return view($route,compact('page'));
    }

    public function save () {
        if(!hasPermission('','create_career')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
        $rules = [
            'title'     => 'required|min_length[2]',
            'note'      => 'required|min_length[2]|max_length[800]',
            'category'  => 'required|min_length[2]',
            'location'  => 'required|min_length[2]',
            'duration'  => 'required',
            'status'    => 'required'
        ];
        if(!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false , 'errors' => $this->validator->getErrors()]);
        }
        $pointsErrors = [];
        if ($this->request->getPost('points')) {
            $points = $this->request->getPost('points');

            foreach ($points as $i => $point) {
                if (trim($point) === '') {
                    $pointsErrors["points.$i"] = "Point is required.";
                }
            }
        }
        
        if(!empty($pointsErrors)) {
            return $this->response->setJSON(['success' => false , 'pointsErrors' =>$pointsErrors]);
        }
        $pointsData = [];
        if ($this->request->getPost('points')) {
            foreach($points as $i => $pnt) {
                $pointsData[] = [
                    'points' => $pnt
                ];
            }
        }
        $file = $this->request->getFile('file');
        $selectedImage = $this->request->getPost('selected_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Upload new image
            $upload = json_decode($this->imgUploader->uploadimg($file, 'career'), true);
            $imagePath = ($upload['status'] == true ? base_url($upload['file']) : '');
        } else {
            // Keep old image if no new upload
            $imagePath = $selectedImage;
        }

        $id = decryptor($this->request->getPost('itmId'));
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'short_note' => $this->request->getPost('note'),
            'duration' => $this->request->getPost('duration'),
            'location'  => $this->request->getPost('location'),
            'category'  => $this->request->getPost('category'),
            'jobcode'   => $this->request->getPost('job_code'),
            'salary'    => $this->request->getPost('salary'),
            'vacancy'   => $this->request->getPost('vacancy'),
            'highlights_title'   => $this->request->getPost('highlights_title'),
            'apply_on'  => $this->request->getPost('apply_on'),
            'type'      => $this->request->getPost('status'),


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
            $this->careerHighlight->where('career_id', $id)->delete();

            if(!empty($points)) {
                foreach($points as $point) {
                    if(!empty($point)) {
                        $this->careerHighlight->insert(['career_id' => $id,'points' => $point]);
                    }
                }
            }

            if($this->careerModel->update($id,$data)) {
                $validStatus = true;
                $validMsg   = 'New Career Updated Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }else{
            $data['created_by'] = session('user_data')['id'];
            if($insertId = $this->careerModel->insert($data)) {
                if(!empty($pointsData)) {
                    foreach($pointsData as &$key) {
                        $key['career_id'] = $insertId;
                    }
                }
                $this->careerHighlight->insertBatch($pointsData);
                $validStatus = true;
                $validMsg   = 'New Career Added Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }
        return $this->response->setJSON(['success' => $validStatus, 'message' => $validMsg]);
    }

    function list(){
        $validMsg = '';
        $status = false;
        if(!hasPermission('','create_career')) {
            $validMsg = $message = lang('Custom.permissionDenied');
        }
        if(!$this->request->isAJAX()) {
          $validMsg = $message = lang('Custom.invalidRequest');
        }
        $status = false;
        $search = $this->request->getPost('search');
        $data = $this->careerModel->getData($search);
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
                        'duration'    => $career['duration'],
                        'type'        => $career['type'],
                        'location'    => $career['location'],
                        'highlights_title' => $career['highlights_title'],
                        'category'    => $career['category'],
                        'salary'      => $career['salary'],
                        'jobcode'     => $career['jobcode'],
                        'vacancy'     => $career['vacancy'],
                        'apply_on'    => $career['apply_on'],
                        'highlights'  => []
                    ];
                    if(!empty($career['points'])) {
                        $dataPoints[$careerId]['highlights'][] = [
                            'points'    => $career['points']
                        ];
                    }
                }
                else{
                    if(!empty($career['points'])) {
                            $dataPoints[$careerId]['highlights'][] = [
                                'points'    => $career['points']
                            ];
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
        $data = $this->careerModel->getData(decryptor($id));
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
                        'duration'    => $career['duration'],
                        'type'        => $career['type'],
                        'jobType'     => ($career['type'] == 'Urgent' ? 1 : ($career['type'] == 'ASAP' ? 2 : 3)),
                        'location'    => $career['location'],
                        'highlights_title' => $career['highlights_title'],
                        'category'    => $career['category'],
                        'salary'      => $career['salary'],
                        'jobcode'     => $career['jobcode'],
                        'vacancy'     => $career['vacancy'],
                        'apply_on'    => $career['apply_on'],
                        'highlights'  => []
                    ];
                    if(!empty($career['points'])) {
                        $dataPoints[$careerId]['highlights'][] = [
                            'points'    => $career['points'],
                            'pointId'   => encryptor($career['pointId']),
                        ];
                    }
                }
                else{
                    if(!empty($career['points'])) {
                        $dataPoints[$careerId]['highlights'][] = [
                            'points'    => $career['points'],
                            'pointId'   => encryptor($career['pointId']),
                        ];
                    }
                }
            }
            $data = array_values($dataPoints);
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['error' => 'Feedback not found']);
    }
    public function delete($id) {
        if(!hasPermission('','delete_career')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
      
        $status = false;
        $msg = '';
        $item = $this->careerModel->find(decryptor($id));
        if($item) {
            if($this->careerModel->where(['id' => decryptor($id)])->delete()) {
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