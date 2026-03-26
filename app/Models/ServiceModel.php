<?php 

namespace App\Models;
use CodeIgniter\Model;

class ServiceModel extends Model {
    protected $table = 'services';

    protected $allowedFields = ['id','title','point_title','variant_title','short_note','slug','description','category_id','sub_category','image','icon','status','created_at','created_by','updated_at','updated_by'];
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
        $builder = $this->db->table('services as s')
            ->select('s.id,s.slug,s.title,s.point_title,s.variant_title,s.short_note,s.image,s.description,s.category_id,s.sub_category,sh.points,sh.id as pointId,sg.image_url,sg.id as imgId,v.id as varintId,
          v.title as varinttitle,v.short_note as variantdesc,v.image as varintImg,s.icon,sh.remarks,
          si.id as subimgId,si.image subImage'
          )
            ->join('service_highlights as sh','sh.service_id = s.id','left')
             ->join('servicegallery as sg','s.id = sg.service_id','left')
            ->join('variants as v','s.id = v.service_id','left')
            ->join('service_sub_image as si','si.service_id = v.id','left')
            ->where('s.status',1)
            ->orderBy('s.id','DESC');
            if($id){
                $builder->where(['s.id' => $id]);
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
        $builder = $this->db->table('services as s')
            ->select('s.id,s.slug,s.title,s.point_title,s.variant_title,s.short_note,s.image,s.description,s.category_id,sh.points,sh.id as pointId,sg.image_url,sg.id as imgId,v.id as varintId,
            v.service_id as variantServiceId,v.title as varinttitle,v.short_note as variantdesc,v.image as varintImg,s.icon,sh.remarks')
            ->join('service_highlights as sh','sh.service_id = s.id','left')
            ->join('servicegallery as sg','sg.service_id = s.id','left')
            ->join('variants as v','s.id = v.service_id','left')
            ->where('s.status',1)
            ->orderBy('s.id','DESC');
            if($id){
                $builder->where(['s.id' => $id]);
            }
            if($search) {
                $builder->like($orderBy);
            }
            if($condition) {
                $builder->where($condition);
            }
            return $builder->get()->getResult();
    }

    public function getMysubcategoryItems($categoryId = false,$limit = false)
    {
        $builder =  $this->db->table('services as s')
            ->select('
                s.id, s.slug, s.title, s.short_note, s.image,
                s.sub_category,
                pc.category as parent_category,
                sc.category as sub_category_title
            ')
            ->join('categories as pc', 'pc.id = s.category_id', 'left')
            ->join('categories as sc', 'sc.id = s.sub_category', 'left');
            if($categoryId){
                $builder->where('s.category_id', $categoryId);
            }
            $builder->where('s.status', 1)
            ->orderBy('s.id','DESC');
            if($limit){
                $builder->limit($limit);
            }
            return $builder->get()->getResult();
    }

    public function serviceDetails($serviceId = false,$search='',$condition=false) {
         $builder = $this->db->table('services as s')
            ->select('s.id,s.slug,s.title,s.variant_title,s.short_note,s.image,s.description,s.category_id,
           v.id as varintId,
            v.service_id as variantServiceId,v.title as varinttitle,v.short_note as variantdesc,v.image as varintImg,s.icon,
            si.image as subImg')
            ->join('variants as v','s.id = v.service_id','left')
            ->join('service_sub_image as si','v.id = si.service_id','left')
            ->where('s.status',1)
            ->orderBy('s.id','DESC');
            if($serviceId){
                $builder->where(['s.id' => $serviceId]);
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