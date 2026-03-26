<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CareerModel;
use App\Models\NewsModel;
use App\Models\NewshighlightsModel;
class NewsController extends BaseController {
    protected $newsModel;

    function __construct() {
        $this->newsModel = new NewsModel();
    }
    public function index() {
        $page = "News";
        $news = $this->newsModel->where(['status' => 1])->orderBy('id','DESC')->get()->getResult();
        return view('frontend/news',compact('page','news'));
    }
    public function details($slug) {
        if($slug) {
            $data = $this->newsModel->singleNews('','','',['n.status '=>1,'n.slug' => $slug]);
            $result = [
                'title'       => '',
                'shortnote'   => '',
                'description' => '',
                'image'       => '',
                'type'        => '',
                'created_at'  => '',
                'highlights'  => [],
                'gallery'     => [],
            ];
            if($data) {
                foreach ($data as $row) {
                    if (empty($result['title'])) {
                        $result['title']       = $row->title;
                        $result['shortnote']   = $row->short_note;
                        $result['description'] = $row->description;
                        $result['image']       =  $row->image;
                        $result['type']        = $row->type;
                        $result['created_at']  = $row->created_at;
                    }
                    if (!empty($row->points)) {
                        $existingpointIds = array_column($result['highlights'],'pointId');
                        if(!in_array(encryptor($row->pointId),$existingpointIds)) {
                            $result['highlights'][] = [
                                'points' => $row->points,
                                'pointId' => encryptor($row->pointId),
                            ];
                        }
                    }
                    if(!empty($row->imgId)){
                        $existingImgIds = array_column($result['gallery'],'imgId');
                        if(!in_array(encryptor($row->imgId),$existingImgIds)) {
                            $result['gallery'][] = [
                                'img' => $row->image_url,
                                'imgId' =>  encryptor($row->imgId),
                            ];
                        }
                    }
                }
                    
            }else{
                return redirect()->to('news');
            }
            $page ="News";
            $allNews = $this->newsModel->where(['status' => 1,'slug !=' => $slug])->orderBy('id','DESC')->get()->getResult();
            $news = $result ?? [];
            return view('frontend/news-details',compact('page','news','allNews'));

        }
    }
}

