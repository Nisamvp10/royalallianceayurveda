<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CareerModel;
use App\Models\SettingsModel;
class CareerController extends BaseController {
    protected $careerModel;

    function __construct() {
        $this->careerModel = new CareerModel();
    }
    public function index() {
        $page = "Career";
        $data = $this->careerModel->getData('','','',['c.status !='=>'Closed']);
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
                        'slug'        => $career['slug'],
                        'salary'      => $career['salary'],
                        'jobcode'     => $career['jobcode'],
                        'vacancy'     => $career['vacancy'],
                        'apply_on'    => $career['apply_on'],
                    ];
                   
                }
            }
        }
        $careers = array_values($dataPoints);
        return view('frontend/career',compact('page','careers'));
    }

    public function details($slug) {
        if($slug) {
            $data = $this->careerModel->getData('','','',['c.status !='=>'Closed','c.slug' => $slug]);
            if($data) {
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
            }
            if(!empty($dataPoints)) {
                $careers = array_values($dataPoints);
            }else{
                $careers = [];
            }
          
            $page ="Career Details";
            return view('frontend/career-details',compact('page','careers'));

        }
    }
}