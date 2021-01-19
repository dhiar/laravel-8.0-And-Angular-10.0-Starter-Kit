<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class material_catrgory extends Model
{
    use HasFactory;
    protected $table="material_category";
    protected $fillable=['name','parent_id','description','is_active'];

    public function getrecord(){
          return $this->belongsTo(material_catrgory::class, 'parent_id');
          // $workforce_category=DB::select("SELECT w_d.*,(select name from workforce_decipline as w_d2 where w_d2.id = w_d.parent_id) as parent_name FROM workforce_decipline AS w_d WHERE w_d.id=".$id);
          // return $workforce_category;
    }

    public function fetchMaterialCatrgoryForSearch() {
        return $this->belongsTo(material_catrgory::class, 'parent_id');
     // $material_catrgory =  material_catrgory::where($searchColum,'LIKE','%'.$searchText.'%')
     //                  ->paginate(10);
     //     return $material_catrgory;
    }
    public function fetchMaterialCatrgoryByPage() {
        return $this->belongsTo(material_catrgory::class, 'parent_id');
        // $material_catrgory =DB::select("SELECT m_c.*,(select name from material_category as m_c2 where m_c2.id = m_c.parent_id) as parent_name FROM material_category AS m_c LIMIT 10");
        // return $material_catrgory;
    }

    public function fetchMaterialCatrgoryBySorting($sorted_colum, $data_sort_order) {
        return $this->belongsTo(material_catrgory::class, 'parent_id');
        // $material_catrgory = material_catrgory::orderBy($sorted_colum,$data_sort_order)
        //                ->paginate(10);
        // return $material_catrgory;
    }


    public function fetchMaterialCatrgory() {
        return $this->belongsTo(material_catrgory::class, 'parent_id');
        // $material_catrgory =DB::select("SELECT m_c.*,(select name from material_category as m_c2 where m_c2.id = m_c.parent_id) as parent_name FROM material_category AS m_c");
        // // material_catrgory::get();
        // return $material_catrgory;
    }
    public function fetchMaterialCatrgoryParent() {
        return $this->belongsTo(material_catrgory::class, 'parent_id');
        // $material_catrgory = DB::select("SELECT * FROM `material_category` where parent_id IS NULL OR parent_id=0");
        // return $material_catrgory;
    }

    public function ActvfetchMaterialCatrgory() {
        return $this->belongsTo(material_catrgory::class, 'parent_id');
    }
}
