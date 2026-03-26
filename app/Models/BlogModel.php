<?php 

namespace App\Models;
use CodeIgniter\Model;

class BlogModel extends Model {
    protected $table = 'blogs';
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
        $builder = $this->db->table('blogs as b')
            ->select('b.id,b.slug,b.title,b.short_note,b.image,b.description,b.type,bh.points,bh.id as pointId,bg.image_url,bg.id as imgId')
            ->join('blog_highlights as bh','bh.blog_id = b.id','left')
             ->join('bloggallery as bg','b.id = bg.blog_id','left')
            ->where('b.status',1)
            ->orderBy('b.id','DESC');
            if($id){
                $builder->where(['b.id' => $id]);
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
        $builder = $this->db->table('blogs as b')
            ->select('b.id,b.slug,b.title,b.short_note,b.image,b.description,b.type,bh.points,bh.id as pointId,bg.image_url,bg.id as imgId')
            ->join('blog_highlights as bh','bh.blog_id = b.id','left')
            ->join('bloggallery as bg','bg.blog_id = b.id','left')
            ->where('b.status',1)
            ->orderBy('b.id','DESC');
            if($id){
                $builder->where(['b.id' => $id]);
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