<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workforce_category extends Model
{
    use HasFactory;
    protected $table = 'workforce_category';
    protected $fillable = [
        '	name','decipline_id','currency_id','description','normal','over_time','weekend','g_h','is_active'
    ];
    public function fetchworkforce_rate_cardForSearch($searchColum, $searchText) {
     $workforce_category = DB::table('workforce_category');
       // where($searchColum,'LIKE','%'.$searchText.'%')
       //                ->paginate(10);
       //   return $workforce_category;
    }
    public function fetchworkforce_rate_cardByPage() {
        $workforce_category = workforce_category::paginate(10);
        return $workforce_category;
    }

    public function fetchworkforce_rate_cardBySorting($sorted_colum, $data_sort_order) {
        $workforce_category = workforce_category::orderBy($sorted_colum,$data_sort_order)
                       ->paginate(10);
        return $workforce_category;
    }
    public function fetchworkforce_rate_card() {
      $workforce_category=workforce_category::get();
      return $workforce_category;
     }
}
