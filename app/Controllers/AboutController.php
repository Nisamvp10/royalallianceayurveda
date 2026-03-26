<?php
namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\UserModel;
use App\Models\IndustriesModel;
use App\Models\AchievementsModel;
class AboutController extends BaseController
{
    protected $userModel;
    protected $achievements;
    protected $industyModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->achievements = new AchievementsModel();
        $this->industyModel = new IndustriesModel();
    }

    public function index()
    {
        $page = "About Us";
        $teams = $this->userModel->getUsers('','','','','u.id ASC');
        $achievements = $this->achievements->where('status',1)->findAll();
        $industries  = $this->industyModel->where(['status' => 1])->orderBy('id','ASC')->get()->getResult();    
        return view('frontend/about-us',compact('page','teams','achievements','industries'));

    }

    public function clinics()
    {
        $page = "Clinics";
        return view('frontend/our-clinics',compact('page'));

    }
}

