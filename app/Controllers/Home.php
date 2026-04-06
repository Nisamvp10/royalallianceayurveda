<?php

namespace App\Controllers;
use App\Models\SliderModel;
use App\Models\IndustriesModel;
use App\Models\FeedbackModel;
use App\Models\ServiceModel;


class Home extends BaseController
{
    protected $industyModel;
    protected $templateTitle;
    protected $feedbackModel;
    protected $serviceModel;

    function __construct() {
        $this->industyModel = new IndustriesModel();
        $this->sliderModel = new SliderModel();
        $this->feedbackModel = new FeedbackModel();
        $this->serviceModel = new ServiceModel();
    }
    public function index($slug)
    {
        $banner = $this->sliderModel->where(['status' => 1 ])->orderBy('id','DESC')->get()->getResult();
        $feedback=$this->feedbackModel->where('status',1)->get()->getResult();
        //$services = $this->serviceModel->where('client_id',$cardInfo['client_id'])->orderBy('id', 'ASC')->get()->getResult();
        $industries  = $this->industyModel->where(['status' => 1])->orderBy('id','ASC')->limit(3)->get()->getResult();    
        //echo  $this->industyModel->getLastQuery();   
        $page = "home";
        return view('frontend/theme',compact('banner','industries','feedback','services','page'));
        
    }
}
