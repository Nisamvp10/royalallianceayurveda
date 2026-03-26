<?php
namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\UserModel;
use App\Models\IndustriesModel;
class IndustryController extends BaseController
{
    protected $userModel;
    protected $industriesModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->industriesModel = new IndustriesModel();
    }

    public function index()
    {
        $page = "Industries";
        $teams = $this->userModel->getUsers('','','','','u.id ASC');
        $industries = $this->industriesModel->where('status',1)->findAll();
        return view('frontend/industries',compact('page','teams','industries'));

    }
}
