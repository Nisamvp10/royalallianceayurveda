<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ServiceModel;
use App\Models\CategoryModel;
class ServiceController extends Controller {
    protected $categoryModel;
    protected $serviceModel;

    function __construct(){
        $this->serviceModel = new ServiceModel();
        $this->categoryModel =  new CategoryModel();
    }

    public function index() {
        $page = "Services";
        $categories = $this->categoryModel->where('is_active' ,1)->get()->getResultArray();
        $services = $this->serviceModel->where('status' ,1)->get()->getResult();;
        return view('frontend/service',compact('services','page','categories'));
    }

    public function details($slug=false) {
        $page = "Services";
            $serviceItems = [
            'title'        => '',
            'short_note'   => '',
            'description'  => '',
            'image'        => '',
            'pointtitle'   => '',
            'varianttitle' => '',
            'icon'         => '',
            'points'       => [],
            'cards'        => [],
            'gallery'      => [],
        ];
        $routeView ='';
        $servicesData = [];
        $titleBar = [];

        $category = $this->categoryModel->select('id')->where('slug', $slug)->get()->getRow();

        if ($category) {
            $services = $this->serviceModel->where('category_id', $category->id)->get()->getResult();
            if (!empty($services) && !empty($services[0]->sub_category)) {
                $items = $this->serviceModel->getMysubcategoryItems($category->id);
                $servicesData = [];

                foreach ($items as $service) {
                    $subCateId = $service->sub_category;
                    // Create subcategory node once
                    if (!isset($servicesData[$subCateId])) {
                        $servicesData[$subCateId] = [
                            'sub_category_id'    => $subCateId,
                            'sub_category_title' => $service->sub_category_title,
                            'items'              => []
                        ];
                    }
                    // Push services under subcategory
                    $servicesData[$subCateId]['items'][] = [
                        'slug'  => $service->slug,
                        'title' => $service->title,
                        'note'  => $service->short_note,
                        'image' => $service->image,
                    ];
                }
                $routeView = 'frontend/services';
            } else {
                $services = $this->serviceModel->where('slug', $slug)->get()->getRow();
                if(!empty($services)) {
                    $getSericeDetails = $this->serviceModel->serviceDetails($services->id);
                    $page = $getSericeDetails[0]->title;
                //echo $this->serviceModel->getLastQuery();
                if(!empty($getSericeDetails)){
                    foreach ($getSericeDetails as $serviseitems) {
                        $variantId = $serviseitems->varintId;
                        if(!isset($titleBar[$variantId])) {
                            $titleBar[$variantId] = [
                                'serviceTitle' => $serviseitems->varinttitle,
                            ];
                        }
                        if(!isset($servicesData[$variantId])) {
                            $servicesData[$variantId] = [
                                'serviceTitle' => $serviseitems->varinttitle,
                                'description'  => $serviseitems->variantdesc,
                                 'banner' => $serviseitems->image,
                                 'subImages' => []
                              
                            ];
                        }
                         $servicesData[$variantId]['subImages'][] = [
                            'image' => $serviseitems->subImg,
                         ];
                    }
                }
                }
              
                $routeView = 'frontend/service-inner';
            }
        }else{
       
        }
        $services = array_values($servicesData);
        $titleBar = array_values($titleBar);
       
        //echo $routeView; exit();
        return view($routeView,compact('services','page','titleBar'));

    }

    function singleDetails($slug) {
        $page = "Services";
        $servicesData = [];
        $titleBar = [];
        $services = $this->serviceModel->where('slug', $slug)->get()->getRow();
        $getSericeDetails = $this->serviceModel->serviceDetails($services->id);
        //echo $this->serviceModel->getLastQuery();
        if(!empty($getSericeDetails)){
             $page = $getSericeDetails[0]->title;
            foreach ($getSericeDetails as $serviseitems) {
                $variantId = $serviseitems->varintId;
                if(!isset($titleBar[$variantId])) {
                    $titleBar[$variantId] = [
                        'serviceTitle' => $serviseitems->varinttitle,
                    ];
                }
                if(!isset($servicesData[$variantId])) {
                    $servicesData[$variantId] = [
                        'serviceTitle' => $serviseitems->varinttitle,
                        'description'  => $serviseitems->variantdesc,
                        'banner' => $serviseitems->image,
                        'subImages' => []
                    
                    ];
                }
                $servicesData[$variantId]['subImages'][] = [
                    'image' => $serviseitems->subImg,
                ];
            }
        }
        $routeView = 'frontend/service-inner';
        $services = array_values($servicesData);
        $titleBar = array_values($titleBar);
        return view($routeView,compact('services','page','titleBar'));
    }
}