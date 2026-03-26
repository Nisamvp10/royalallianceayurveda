<?php
namespace App\Controllers\admin;

use CodeIgniter\Controller;
use App\Models\ServiceModel;
use App\Controllers\UploadImages;
use App\Models\ServicehighlightsModel;
use App\Models\ServicegalleryModel;
use App\Models\VariantsModel;
use App\Models\CategoryModel;
use App\Models\serviceSubImagesModel;

class ServiceController extends Controller {
    protected $serviceModel;
    protected $imgUploader;
    protected $servicehighlightModel;
    protected $serviceimgModel;
    protected $variantModel;
    protected $categoryModel;
    protected $subImages;

    function __construct() {
        $this->serviceModel = new ServiceModel();
        $this->imgUploader = new UploadImages();
        $this->servicehighlightModel = new ServicehighlightsModel();
        $this->serviceimgModel  = new ServicegalleryModel();
        $this->variantModel  = new VariantsModel();
        $this->categoryModel = new CategoryModel();
        $this->subImages    = new serviceSubImagesModel();
    }
     public function index() {
        $page = (hasPermission('','service') ?  ucwords(string: getappdata('services')) : lang('Custom.permissionDenied'));
        $route = (hasPermission('','service') ? 'admin/services/index' :'admin/pages-error-404');
        $categories = $this->categoryModel->where(['is_active' => 1,'parent_id'=>0])->findAll();
        return view($route,compact('page','categories'));
    }

    public function subcategories($id) {
        $subcategories = $this->categoryModel->where(['is_active' => 1,'parent_id'=>$id])->findAll();
        return $this->response->setJSON(['success'=>true,'categories'=>$subcategories]);
    }

    public function save () {
        if(!hasPermission('','create_service')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
        $rules = [
            'title' => 'required|min_length[2]',
            'note'  => 'required|min_length[2]|max_length[800]',
            'category'  => 'required',
            //'variant_main_title'  => 'required|min_length[2]',
        ];
        if(!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false , 'errors' => $this->validator->getErrors()]);
        }
        $pointsErrors = [];
        $points = $this->request->getPost('points');
        $remark = $this->request->getPost('remark');
        $subcategory = $this->request->getPost('subcategory');
        // foreach($points as $i => $point) {
        //     if(empty($point)) {
        //         $pointsErrors["points.$i"] = "Point is required.";
        //     }
        //     if(empty($remark[$i])) {
        //         $pointsErrors["remark.$i"] = "Description is required.";
        //     }
        // }

        if(!empty($pointsErrors)) {
            return $this->response->setJSON(['success' => false , 'pointsErrors' =>$pointsErrors]);
        }
        //varian rules
        $variantErrors  = [];
        $varintTitle   = $this->request->getPost('variant_title');
        $variant_notes = $this->request->getPost('variant_notes');
        foreach($varintTitle as $i => $varinats) {
            if(empty($varinats)) {
                $variantErrors["variant_title.$i"] = "Variant Title  is required.";
            }
            if(empty($variant_notes[$i])){
                $variantErrors["variant_notes.$i"] = "Variant Description  is required.";
            }
        }
         if(!empty($variantErrors)) {
            return $this->response->setJSON(['success' => false , 'variantErrors' =>$variantErrors]);
        }
        
        $pointsData = [];
        if(!empty($points)) {
            foreach($points as $i => $pnt) {
                $pointsData[] = [
                    'points' => $pnt,
                    'remarks' => $remark[$i]
                ];
            }
        }
       //print_r($pointsData);exit();
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

        $fileIcon = $this->request->getFile('iconfile');
        $selectedImage = $this->request->getPost('selected_icons');

        if ($fileIcon && $fileIcon->isValid() && !$file->hasMoved()) {
            // Upload new image
            $upload = json_decode($this->imgUploader->uploadimg($fileIcon, 'icons'), true);
            $iconPath = ($upload['status'] == true ? base_url($upload['file']) : '');
        } else {
            // Keep old image if no new upload
            $iconPath = $selectedImage;
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
                $uploadPath =  './uploads/products/' . $fileName;

                if (!is_dir(dirname($uploadPath))) {
                    mkdir(dirname($uploadPath), 0777, true);
                }
                file_put_contents($uploadPath, $data);
                $uploadedPaths[] = base_url('./uploads/products/' . $fileName);
                } else {
                    $uploadedPaths[] = $img;
                }
            }
        }
        // close Multi section
        $id = decryptor($this->request->getPost('itmId'));
        $variantImages = $this->request->getPost('variantImgId');
        //variant Items
       $variantIds   = $this->request->getPost('variantId'); 
       //$variantImages = $this->request->getFiles()['variant'];
        $variantFiles  = $this->request->getFiles()['variant']; 
       //1Get current DB variants for this service
        $existing = $this->variantModel->where('service_id', $id)->findAll();
        $existingIds = array_column($existing, 'id');
        $keepIds = [];
        $varintData = [];
        $varintSubImages = [];

        // 2️⃣ Loop submitted variants
            foreach ($varintTitle as $i => $title) {         
                $varintId    = $variantIds[$i] ?? null;
                $note  = $variant_notes[$i] ?? '';
                $image = $variantImages[$i] ?? null;
                $imgPath = null;

                // Handle upload
                // if ($image && $image->isValid() && !$image->hasMoved()) {
                //     $newName = $image->getRandomName();
                //     $uploadPath = FCPATH . 'uploads/variants/';
                //     if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
                //     $image->move($uploadPath, $newName);
                //     $imgPath = 'uploads/variants/' . $newName;
                // }

                if ($varintId && in_array($varintId, $existingIds)) {
                    $updateData = [
                        'title'      => $title,
                        'short_note' => $note,
                    ];
                    if ($imgPath) {
                        $updateData['image'] = $imgPath;
                    }

                    $this->variantModel->update($varintId, $updateData);
                    $keepIds[] = $varintId;
                } else {
                
                    $varintData[]=[
                        //'service_id' => $id,
                        'title'      => $title,
                        'short_note' => $note,
                        'image'      => $imgPath,
                    ];
                    $keepIds[] = $this->variantModel->getInsertID();
                }

                if(!empty($variantFiles)) {
                    foreach ($variantFiles[$i] as $file) {
                     
                        if ($file->isValid() && !$file->hasMoved()) {

                            $newName = $file->getRandomName();
                            $path = FCPATH . 'uploads/variants/';

                            if (!is_dir($path)) {
                                mkdir($path, 0777, true);
                            }

                            $file->move($path, $newName);

                         $varintSubImages[$i][] = 'uploads/variants/' . $newName;
                        }
                    }
                
                }

                /* ===============================
                   INSERT SUB IMAGES FOR EXISTING VARIANT
                   =============================== */
                if ($varintId && in_array($varintId, $existingIds) && !empty($varintSubImages[$i])) {
                    foreach ($varintSubImages[$i] as $imgPath) {
                        $this->subImages->insert([
                            'service_id' => $varintId,   
                            'image'      => $imgPath,
                        ]);
                    }
                }

            }

        if (!empty($existingIds)) {
            $deleteIds = array_diff($existingIds, $keepIds);
            if (!empty($deleteIds)) {
                $this->variantModel->whereIn('id', $deleteIds)->delete();
            }
        }
        //close varint
        $data = [
            'title'         => $this->request->getPost('title'),
            'description'   => $this->request->getPost('description'),
            'short_note'    => $this->request->getPost('note'),
            'category_id'   => $this->request->getPost('category'),
            'sub_category'   => $subcategory,
            'point_title'   => $this->request->getPost('pointtitle'),
            'variant_title'   => 'DR',//$this->request->getPost('variant_main_title'),
        ];
        if(!empty($imagePath)) {
            $data['image'] = $imagePath;
        }
        if(!empty($iconPath)) {
            $data['icon'] = $iconPath;
        }
        $validStatus = false;
        $validMsg = '';
        
        if($id) {

            $data['updated_by'] = session('user_data')['id'];
            $data['updated_at'] = date('Y-m-d,H:i:s');
            // check already exist points 
            if(!empty($points)) {
                $this->servicehighlightModel->where('service_id', $id)->delete();
                foreach($points as $i => $point) {
                    if(!empty($point)) {
                        $pointsData['service_id'] = $id;
                        $this->servicehighlightModel->insert(['service_id' => $id,'points' => $point ,'remarks' => $remark[$i]]);
                    }
                }

            }
        
            if(!empty($uploadedPaths)) {
                foreach ($uploadedPaths as $url) {
                        $this->serviceimgModel->insert(['service_id'   => $id,'image_url' => $url]);
                }
            }
            if(!empty($varintData)) {
                foreach ($varintData as $index => $incdata) {
                   $variantId = $this->variantModel->insert([
                    'service_id' => $id,
                    'title'      => $incdata['title'],
                    'short_note' => $incdata['short_note'],
                    'image'      => $incdata['image'],
                   ],true);

                   if (!empty($varintSubImages[$index])) {
                        foreach ($varintSubImages[$index] as $imgPath) {
                            $this->subImages->insert([
                                'service_id' => $variantId,   
                                'image'      => $imgPath,
                            ]);
                        }
                    }

                }
            }
            if($this->serviceModel->update($id,$data)) {
                $validStatus = true;
                $validMsg   = getappdata('services').' Updated Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }else{
            $data['created_by'] = session('user_data')['id'];
            $variantId = '';
            if($insertId = $this->serviceModel->insert($data)) {
                if(!empty($pointsData)) {
                    foreach($pointsData as &$key) {
                        $key['service_id'] = $insertId;
                    }
                }
                if(!empty($uploadedPaths)) {
                    foreach ($uploadedPaths as $url) {
                        $this->serviceimgModel->insert([
                            'service_id'   => $insertId,
                            'image_url' => $url
                        ]);
                    }
                }
                if (!empty($varintData)) {

                foreach ($varintData as $index => $incdata) {

                    /* ===============================
                    INSERT VARIANT
                    =============================== */
                    $variantId = $this->variantModel->insert([
                        'service_id' => $insertId,
                        'title'      => $incdata['title'],
                        'short_note' => $incdata['short_note'],
                        'image'      => $incdata['image'] ?? null,
                    ], true);

                    /* ===============================
                    INSERT SUB IMAGES (INDEX WISE)
                    =============================== */
                    if (!empty($varintSubImages[$index])) {

                        foreach ($varintSubImages[$index] as $imgPath) {

                            $this->subImages->insert([
                                'service_id' => $variantId,   // ✅ correct
                                'image'      => $imgPath,
                            ]);
                        }
                    }
                }

            }

                $this->servicehighlightModel->insertBatch($pointsData);

               
                $validStatus = true;
                $validMsg   = 'New '.getappdata('services').' Added Successfully';
            }else{
                $validMsg   = '!Oops Something went wrong Please try again later'; 
            }
        }
        return $this->response->setJSON(['success' => $validStatus, 'message' => $validMsg]);
    }

    function list(){
        $validMsg = '';
        $status = false;
        if(!hasPermission('','create_service')) {
            $validMsg = $message = lang('Custom.permissionDenied');
        }
        if(!$this->request->isAJAX()) {
          $validMsg = $message = lang('Custom.invalidRequest');
        }
        $status = false;
        $search = $this->request->getPost('search');
        $data = $this->serviceModel->getData($search);
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
                        'type'        => $news['category_id'],
                        'icon'        => $news['icon'],
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
   public function getinfo($id = false)
{
    $data = $this->serviceModel->getData(decryptor($id));

    $dataPoints = [];

    if ($data) {

        foreach ($data as $row) {

            $rowId = $row['id'];

            /* ===============================
               SERVICE INIT
            =============================== */
            if (!isset($dataPoints[$rowId])) {

                $dataPoints[$rowId] = [
                    'careerId'      => encryptor($rowId),
                    'title'         => $row['title'],
                    'shortnote'     => $row['short_note'],
                    'description'   => $row['description'],
                    'image'         => $row['image'],
                    'type'          => $row['category_id'],
                    'subcategoryId' => $row['sub_category'],
                    'variant_title' => $row['variant_title'],
                    'point_title'   => $row['point_title'],
                    'icon'          => $row['icon'],
                    'highlights'    => [],
                    'gallery'       => [],
                    'variants'      => []
                ];
            }

            /* ===============================
               HIGHLIGHTS
            =============================== */
            if (!empty($row['pointId'])) {

                $existingPointIds = array_column($dataPoints[$rowId]['highlights'],'pointId');

                if (!in_array(encryptor($row['pointId']), $existingPointIds)) {

                    $dataPoints[$rowId]['highlights'][] = [
                        'points'  => $row['points'],
                        'remark'  => $row['remarks'],
                        'pointId' => encryptor($row['pointId'])
                    ];
                }
            }

            /* ===============================
               GALLERY
            =============================== */
            if (!empty($row['imgId'])) {

                $existingGalleryIds = array_column(
                    $dataPoints[$rowId]['gallery'],
                    'imgId'
                );

                if (!in_array(encryptor($row['imgId']), $existingGalleryIds)) {

                    $dataPoints[$rowId]['gallery'][] = [
                        'img'   => $row['image_url'],
                        'imgId' => encryptor($row['imgId'])
                    ];
                }
            }

            /* ===============================
               VARIANTS + SUB IMAGES
            =============================== */
            if (!empty($row['varintId'])) {

                // find variant index
                $variantIndex = null;

                foreach ($dataPoints[$rowId]['variants'] as $k => $v) {
                    if ($v['varintId'] == $row['varintId']) {
                        $variantIndex = $k;
                        break;
                    }
                }

                /* ---------- CREATE VARIANT ---------- */
                if ($variantIndex === null) {

                    $dataPoints[$rowId]['variants'][] = [
                        'varintId'           => $row['varintId'],
                        'varintTitle'        => $row['varinttitle'],
                        'varintdescription' => $row['variantdesc'],
                        'image'              => $row['varintImg']
                            ? base_url($row['varintImg'])
                            : base_url('uploads/default.png'),
                        'subImages'          => []
                    ];

                    $variantIndex = array_key_last(
                        $dataPoints[$rowId]['variants']
                    );
                }

                /* ---------- ADD SUB IMAGES ---------- */
                if (!empty($row['subimgId'])) {

                    $existingSubIds = array_column($dataPoints[$rowId]['variants'][$variantIndex]['subImages'],'id');

                    if (!in_array($row['subimgId'], $existingSubIds)) {

                        $dataPoints[$rowId]['variants'][$variantIndex]['subImages'][] = [
                            'id'    => $row['subimgId'],
                            'image' => validImg($row['subImage'])
                        ];
                    }
                }
            }
        }

        return $this->response->setJSON(array_values($dataPoints));
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
        $item = $this->serviceModel->find(decryptor($id));
        if($item) {
            if($this->serviceModel->where(['id' => decryptor($id)])->delete()) {
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
        $item = $this->serviceimgModel->find(decryptor($id));
        if($item) {
            if($this->serviceimgModel->where(['id' => decryptor($id)])->delete()) {
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
    public function deleteVariantGallery($id) {
        if(!hasPermission('','delete_service')) {
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
        $item = $this->subImages->find(decryptor($id));
        if($item) {
            if($this->subImages->where(['id' => $id])->delete()) {
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