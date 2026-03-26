<?php

namespace App\Controllers;

use CodeIgniter\Controllers;
use App\Models\SliderModel;
use App\Models\ExpertiseModel;
use App\Models\IndustriesModel;
use App\Models\FeedbackModel;
use App\Models\NewsModel;
use App\Models\ServiceModel;
use App\Models\CategoryModel;
use App\Models\ProductManageModel;

class HomeController extends BaseController {
    protected $sliderModel;
    protected $expertiseModel;
    protected $industyModel;
    protected $feedbackModel;
    protected $newsModel;
    protected $serviceModel;
    protected $categoryModel;
    protected $productManageModel;

    function __construct(){
        $this->sliderModel = new SliderModel();
        $this->categoryModel = new CategoryModel();

        $this->expertiseModel = new ExpertiseModel();
        $this->industyModel = new IndustriesModel();
        $this->feedbackModel = new FeedbackModel();
        $this->newsModel = new NewsModel();
        $this->serviceModel =  new ServiceModel();
        $this->productManageModel =  new ProductManageModel();
    }
    public function index() {
        helper('text');
        $page = 'Home';
        $banner = $this->sliderModel->where(['status' => 1 ])->orderBy('id','DESC')->get()->getResult();
        $itemCategories = $this->categoryModel->where(['is_active' => 1])->orderBy('id','DESC')->get()->getResult();
        $premiumProducts = $this->productManageModel->where(['product_status' => 1,'premium_product' =>1])->orderBy('id','DESC')->get()->getRow();
        $featuredProducts = $this->productManageModel->where(['product_status' => 1,'featured_product' =>1])->orderBy('id','DESC')->limit(6)->get()->getResult();
        $tagline = $this->expertiseModel->where(['status' => 1])->orderBy('title','ASC')->get()->getResult();
        $feedback = $this->feedbackModel->where(['status' => 1])->orderBy('id','DESC')->get()->getResult();
        $news  = $this->newsModel->where(['status' => 1])->orderBy('id','DESC')->limit(3)->get()->getResult();
        $srevices  = $this->serviceModel->getMysubcategoryItems('',9);
        $industries  = $this->industyModel->where(['status' => 1])->orderBy('id','ASC')->limit(3)->get()->getResult();    
        return view('frontend/index',compact('page','banner','tagline','industries','feedback','news','srevices','itemCategories','premiumProducts','featuredProducts'));

    }
}