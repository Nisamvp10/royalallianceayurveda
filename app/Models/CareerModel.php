<?php 

namespace App\Models;
use CodeIgniter\Model;

class CareerModel extends Model {
    protected $table = 'careers';
    protected $allowedFields = ['id','title','highlights_title','short_note','slug','description','duration','type','location','tag',
    'category','salary','jobcode','vacancy','apply_on','image','status','created_at','created_by','updated_at','updated_by'];
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
        $builder = $this->db->table('careers as c')
            ->select('c.id,c.slug,c.title,c.highlights_title,c.short_note,c.image,c.description,c.duration,c.type,c.location,c.category,c.salary,c.jobcode,c.vacancy,c.apply_on,p.points,p.id as pointId')
            ->join('career_highlights as p','p.career_id = c.id','left')
            ->where('c.status',1)
            ->orderBy('c.id','DESC');
            if($id){
                $builder->where(['c.id' => $id]);
            }
            if($search) {
                $builder->like($orderBy);
            }
            if($condition) {
                $builder->where($condition);
            }
            return $builder->get()->getResultArray();
    }
}