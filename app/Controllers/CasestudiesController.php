<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BlogModel;
use App\Models\ServiceModel;
class CasestudiesController extends BaseController {
    protected $blogModel;
    protected $serviceModel;

    function __construct() {
        $this->blogModel = new BlogModel();
        $this->serviceModel = new ServiceModel();
    }
    public function index() {
        $page = "case studies";
        $blogs  = $this->blogModel->where(['status' => 1])->orderBy('id','DESC')->get()->getResult();
        return view('frontend/case-studies',compact('page','blogs'));
    }
    public function details($slug=false) {
        $page = "case studies";
        $blogs  = $this->blogModel->singleNews('','','',['b.slug' => $slug]);
        $recentBlog  = $this->blogModel->where(['status' => 1,'slug !=' => $slug])->orderBy('id','DESC')->get()->getResult();
        $services = $this->serviceModel->where('status' ,1)->limit(10)->orderBy('id','DESC')->get()->getResult();
        $blogsData = [
            'title' => '',
            'note'  => '',
            'description' => '',
            'image'  => '',
            'type'   => '',
            'points'  => [],
            'bloggallery' => []
        ];
        if(!empty($blogs)) {
            foreach($blogs as $blog) {
                $blogsData['title'] = $blog->title;
                $blogsData['note'] = $blog->short_note;
                $blogsData['description'] = $blog->description;
                $blogsData['type'] = $blog->type;
                $blogsData['image'] = $blog->image;

                if($blog->pointId) {
                    $pointsExist = array_column($blogsData['points'],'pointId');
                    if(!in_array(encryptor($blog->pointId),$pointsExist)) {
                        $blogsData['points'][] = [
                            'point' => $blog->points,
                            'pointId' => encryptor($blog->pointId)
                        ];
                    }
                }

                if(!empty($blog->imgId)) {
                    $galleryExist = array_column($blogsData['bloggallery'],'imgId');
                    if(!in_array(encryptor($blog->imgId),$galleryExist)) {
                        $blogsData['bloggallery'][] =[
                          'image'   => $blog->image_url,
                          'imgId'  => encryptor($blog->imgId)
                        ];
                    }
                }

            }
        }
        return view('frontend/case-detail',compact('page','blogsData','recentBlog','services'));
    }
}