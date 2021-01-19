<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class WorkforceDecipline extends Model
{
    use HasFactory;
    protected $table = 'workforce_decipline';
    protected $fillable = [
        'name','parent_id','description','is_active'
    ];

    public function getrecord(){
          return $this->belongsTo(WorkforceDecipline::class, 'parent_id');
          // $workforce_category=DB::select("SELECT w_d.*,(select name from workforce_decipline as w_d2 where w_d2.id = w_d.parent_id) as parent_name FROM workforce_decipline AS w_d WHERE w_d.id=".$id);
          // return $workforce_category;
    }

    public function fetchworkforceDisciplineForSearch() {
      return $this->belongsTo(WorkforceDecipline::class, 'parent_id');
     // $workforce_category =  workforcecategory::where($searchColum,'LIKE','%'.$searchText.'%')
     //                  ->paginate(config('paginateRecord'));
     //     return $workforce_category;
    }


    public function fetchworkforceDisciplineByPage() {
      return $this->belongsTo(WorkforceDecipline::class, 'parent_id');
      //return $this->belongsTo('App\Models\WorkforceDecipline','parent_id')->paginate(config('paginateRecord'));
      // $workforce_category=DB::select("SELECT w_d.*,(select name from workforce_decipline as w_d2 where w_d2.id = w_d.parent_id) as parent_name FROM workforce_decipline AS w_d LIMIT $page OFFSET $offst");
      // return $workforce_category;
      // $workforce_category = Abc::where('id','=','parent_id')->groupBy('id'); // Eloquent Builder instance

// $count = DB::table( DB::raw("({$sub->toSql()}) as sub") )
//     ->mergeBindings($sub->getQuery()) // you need to get underlying Query Builder
//     ->count();

        // $workforce_category = workforcecategory::paginate(config('paginateRecord'));
        // return $workforce_category;
        // $workforce_category=WorkforceDecipline::where('')
        // return $workforce_category;
    }

    public function fetchworkforceDisciplineBySorting() {
        return $this->belongsTo(WorkforceDecipline::class, 'parent_id');
        // $workforce_category = workforcecategory::orderBy($sorted_colum,$data_sort_order)
        //                ->paginate(config('paginateRecord'));
        // return $workforce_category;
    }
    public function fetchworkforceDiscipline() {
      return $this->belongsTo(WorkforceDecipline::class, 'parent_id');
      // $workforce_category=DB::select("SELECT w_d.*,(select name from workforce_decipline as w_d2 where w_d2.id = w_d.parent_id) as parent_name FROM workforce_decipline AS w_d");
      // return $workforce_category;
     }
     public function fetchworkforceDisciplineParent() {
       return $this->belongsTo(WorkforceDecipline::class, 'parent_id');
         // $material_catrgory = DB::select("SELECT * FROM `workforce_decipline` where parent_id IS NULL OR parent_id=0");
         // return $material_catrgory;
     }
     public function ActivefetchworkforceDisciplineParent() {
       return $this->belongsTo(WorkforceDecipline::class, 'parent_id');
     }
}
