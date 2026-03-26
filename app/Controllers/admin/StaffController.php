<?php
namespace App\Controllers\admin;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\BranchesModel;
use App\Controllers\UploadImages;
use App\Models\StaffmediaModel;

class StaffController extends Controller {
    protected $userModel;
    protected $roleModel;
    protected $branchModel;
    protected $imageUploader;
    protected $staffMedia;

    function __construct(){
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->branchModel = new BranchesModel();
        $this->imageUploader = new UploadImages();
        $this->staffMedia =  new StaffmediaModel();
    }

    public function index() {
        $page = "Staff Member";
        $active = 'staff';
        $roles = $this->roleModel->where(['id !=' => 1])->findAll();
        return view('admin/staff/index',compact('roles'));
        
    }

     function create($id = false){
        
         
        if ($id){

            $page = "Edit Team";
            $id = decryptor($id);
            $data = $this->userModel->where('id',$id)->first();

        }else{
            $selectedSpecialties = [];
            $data = '';
            $page = "Add Team";
        }
        
        $branches = $this->branchModel->where('status',1)->findAll();
        $roles = $this->roleModel->findAll();
        $services =  [];//$this->categoryModel->getCategory();
      
        return view('admin/staff/create',compact('page','branches','roles','data',));
    }
    function save(){

        $userModel = new UserModel();
        $validSuccess = false;
        $validMsg = '';

        $id = decryptor($this->request->getPost('staffId'));

        if (!$this->request->isAJAX())
        {
            return $this->response->setJSON([
                'success' => false,
                'message' => "Invalid Request"
            ]);
        }
        if(!haspermission(session('user_data')['role'],'create_staff') ) {
            return $this->response->setJSON(['success' =>false,'message' => 'Permission Denied']);
        }

        $rules = [
            'name'     => 'required|min_length[3]|max_length[100]',
            'position' => 'required|min_length[2]', // assuming YYYY-MM-DD
            //'branch' => 'required|numeric', // or string based on your table
            'role'     => 'required',
        ];
        if (empty($id)) {
            $rules['password'] = 'required|min_length[6]|max_length[50]';
            $rules['email'] = 'required|valid_email|max_length[100]|is_unique[users.email]';
            $rules['phone'] = [
                    'label'  => 'Phone Number',
                    'rules'  => 'required|numeric|exact_length[10]|is_unique[users.phone]',
                    'errors' => [
                        'required'     => 'Phone number is required.',
                        'numeric'      => 'Phone number must contain only digits.',
                        'exact_length' => 'Phone number must be exactly 10 digits.',
                        'is_unique'    => 'This phone number is already registered.',
                    ]
            ];
           
        }else{
            $rules['phone'] = [
                    'label'  => 'Phone Number',
                    'rules'  => "required|numeric|exact_length[10]|is_unique[users.phone,id,{$id}]",
                    'errors' => [
                        'required'     => 'Phone number is required.',
                        'numeric'      => 'Phone number must contain only digits.',
                        'exact_length' => 'Phone number must be exactly 10 digits.',
                        'is_unique'    => 'This phone number is already registered by another user.',
                    ]
            ];
             
        }
        if(!empty($this->request->getPost('password'))) {
            $rules['password'] = 'required|min_length[6]|max_length[50]';
        }
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }
        $file = $this->request->getFile('file');
        $selectedImage = $this->request->getPost('selected_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Upload new image
            $upload = json_decode($this->imageUploader->uploadimg($file, 'user'), true);
            $imagePath = ($upload['status'] == true ? base_url($upload['file']) : '');
        } else {
            // Keep old image if no new upload
            $imagePath = $selectedImage;
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'phone'     => $this->request->getPost('phone'),
            'position'  => $this->request->getPost('position'),
            'role'      => $this->request->getPost('role'),
            'status'    => 2,
        ];
        $media = [
            'facebook'  => $this->request->getPost('facebook'),
            'instagram' => $this->request->getPost('instagram'),
            'twitter'   => $this->request->getPost('twitter'),
            'linkedin'  => $this->request->getPost('linkedin'),
        ];
        if(!empty($imagePath)) {
            $data['profileimg'] = $imagePath;
        }
        if ($id) {
               
            if(!empty($this->request->getPost('password'))) {
                    $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                }
            if ($userModel->update($id,$data)) {
                $this->staffMedia->where('staff_id', $id)->set($media)->update();

                $validSuccess = true;
                $validMsg = "Updated Successfully";
            }else {
                $validMsg = "Somthing went wrong Please try agin later";
            }
        }else {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $data['email'] =  $this->request->getPost('email');
            if ($lastId = $userModel->insert($data)) {
                $media['staff_id'] = $lastId;
                $this->staffMedia->insert($media);
                $validSuccess = true;
                $validMsg = "New User Added Successfully";
            }else {
                $validMsg = "Somthing went wrong Please try agin later";
            }
        }
        
        return $this->response->setJSON([
            'success' => $validSuccess,
            'message' => $validMsg,
        ]);
    }
    public function getinfo($id=false) {
        $data = $this->userModel->getUsers('','','',decryptor($id));
        if ($data) {
            $data['image'] = !empty($data['profileimg']) 
                ? $data['profileimg']
                : base_url('uploads/default.png');
            return $this->response->setJSON($data);
        }
        return $this->response->setJSON(['error' => 'Feedback not found']);
    }

    function list() {

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid Request'
            ]);
        }
        if (!haspermission(session('user_data')['role'],'view_staff')) {
             return $this->response->setJSON([
                'success' => false,
                'message' => 'Permission Denied'
            ]);
        }
        $userModel = new UserModel();

        $search = $this->request->getPost('search');
        $filter = $this->request->getPost('filter');
        $branch = $this->request->getPost('branch');

        $staff = $userModel->getUsers($search,$filter,$branch);

        foreach ($staff as &$staffKey) {
            $staffKey['encrypted_id'] = encryptor($staffKey['id']);
        }

        return $this->response->setJSON([
            'success' => true,
            'staff' => $staff
        ]);
    }

    function delete($id=false) {

        if (!$this->request->isAjax()) {
            return $this->response->setJSON([ 'success' => false, 'message' => "Invalid Request"]);
        }
        $userModel = new UserModel();
        $validSuccess = false;
        $validMsg = "oops! Item Not Valid ";
        
        $id = decryptor($id);

        if ($id) {
            $staffFind = $userModel->where('id',$id)->find();
            if ($staffFind) {

                if( $userModel->delete($id)){
                    $validSuccess = true;
                    $validMsg = 'Deleted successfully!';
                }else{
                    $validMsg = 'Delete failed. Please try again.';
                }
            }
        }

        return $this->response->setJSON([
            'success' => $validSuccess,
            'message' => $validMsg
        ]);
    }
}