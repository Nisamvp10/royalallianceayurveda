<?php 

namespace App\Models;
use CodeIgniter\Model;

class NewsModel extends Model {
    protected $table = 'news';
    protected $allowedFields = ['id','title','short_note','slug','description','type','image','status','created_at','created_by','updated_at','updated_by'];
    protected $primaryKey = 'id';

    protected $beforeInsert = ['generateSlug'];
    //protected $beforeUpdate = ['generateSlug'];


    protected function generateSlug(array $data)
    {
        helper('text');

        if (isset($data['data']['title'])) {
            $slug = url_title($data['data']['title'], '-', true);

            // Check if slug already exists
            $count = $this->where('slug', $slug)->countAllResults();

            // If slug exists, append number until unique
            $originalSlug = $slug;
            $i = 1;
            while ($count > 0) {
                $newSlug = $originalSlug . '-' . $i;
                $count = $this->where('slug', $newSlug)->countAllResults();
                if ($count == 0) {
                    $slug = $newSlug;
                    break;
                }
                $i++;
            }

            $data['data']['slug'] = $slug;
        }
        return $data;
    }


    public function getData($id = false,$search='',$orderBy ='',$condition=false) {
        $builder = $this->db->table('news as n')
            ->select('n.id,n.slug,n.title,n.short_note,n.image,n.description,n.type,nh.points,nh.id as pointId,ni.image_url,ni.id as imgId')
            ->join('news_highlights as nh','nh.news_id = n.id','left')
             ->join('newsimages as ni','n.id = ni.news_id','left')
            ->where('n.status',1)
            ->orderBy('n.id','DESC');
            if($id){
                $builder->where(['n.id' => $id]);
            }
            if($search) {
                $builder->like($orderBy);
            }
            if($condition) {
                $builder->where($condition);
            }
            return $builder->get()->getResultArray();
    }
    function singleNews($id = false,$search='',$orderBy ='',$condition=false) {
        $builder = $this->db->table('news as n')
            ->select('n.id,n.slug,n.title,n.short_note,n.image,n.description,n.type,n.created_at,nh.points,nh.id as pointId,ni.image_url,ni.id as imgId')
            ->join('news_highlights as nh','nh.news_id = n.id','left')
            ->join('newsimages as ni','ni.news_id = n.id','left')
            ->where('n.status',1)
            ->orderBy('n.id','DESC');
            if($id){
                $builder->where(['n.id' => $id]);
            }
            if($search) {
                $builder->like($orderBy);
            }
            if($condition) {
                $builder->where($condition);
            }
            return $builder->get()->getResult();
    }
}