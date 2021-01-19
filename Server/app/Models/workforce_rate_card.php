<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workforce_rate_card extends Model
{
    use HasFactory;
    protected $table = 'workforce_rate_card';
    protected $fillable = [
        'Category_name','sub_category','normal_rate','overtime_rate','weekend_rate','public_holiday_rate','is_active'
    ];
    public function fetchworkforce_rate_cardForSearch($searchColum, $searchText) {
     $workforce_rate_card =  workforce_rate_card::where($searchColum,'LIKE','%'.$searchText.'%')
                      ->paginate(10);
         return $workforce_rate_card;
    }
    public function fetchworkforce_rate_cardByPage() {
        $workforce_rate_card = workforce_rate_card::paginate(10);
        return $workforce_rate_card;
    }

    public function fetchworkforce_rate_cardBySorting($sorted_colum, $data_sort_order) {
        $workforce_rate_card = workforce_rate_card::orderBy($sorted_colum,$data_sort_order)
                       ->paginate(10);
        return $workforce_rate_card;
    }
    public function fetchworkforce_rate_card() {
      $workforce_rate_card=workforce_rate_card::get();
      return $workforce_rate_card;
     }
}
