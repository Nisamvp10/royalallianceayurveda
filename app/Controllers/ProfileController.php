<?php
namespace App\Controllers;
use App\Models\AchievementsModel;
use App\Models\ExpertiseModel;

class ProfileController extends BaseController{
    public function index() {
        $qualifications = new AchievementsModel();
        $expertiseModel = new ExpertiseModel();
        $data = $qualifications->where('status', 1)->orderBy('id','DESC')->findAll();
        $expertise = $expertiseModel->where('status',1)->orderBy('id','DESC')->findAll();
        return view('frontend/profile',compact('data','expertise'));
    }
    public function purposeAndValues() {
        return view('frontend/purpose-and-values');
    }
}