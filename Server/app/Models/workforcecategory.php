<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class workforcecategory extends Model
{
    use HasFactory;
    protected $table = 'workforce_category';
    protected $fillable = [
        'name','decipline_id','description','normal','over_time','weekend','g_h','is_active','currency_id'
    ];
    public function fetchworkforce_categoryForSearch($searchColum, $searchText) {
     $workforce_category =  DB::table('workforce_category')
     ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'workforce_category.decipline_id')
     ->leftjoin('currencies', 'currencies.id', '=', 'workforce_category.currency_id')
     ->select('workforce_decipline.name as workforceDeciplineName',
     'workforce_category.*');
     if ($searchColum == 'id'){
        $workforce_category->where('workforce_category.'.$searchColum,$searchText);
      }else{
        $workforce_category->where('workforce_category.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $workforce_category->paginate(config('paginateRecord'));
      return $result;
     // ->where($searchColum,'LIKE','%'.$searchText.'%')
     // ->paginate(config('paginateRecord'));
     // return $workforce_category;
    }
    public function fetchworkforce_categoryByPage() {
        $workforce_category = DB::table('workforce_category')
        ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'workforce_category.decipline_id')
        ->leftjoin('currencies', 'currencies.id', '=', 'workforce_category.currency_id')
        ->select('workforce_decipline.name as workforceDeciplineName','workforce_category.*','currencies.id as currency_id','currencies.code as currency_code','currencies.title as currency_title')
        ->paginate(config('paginateRecord'));
        return $workforce_category;
    }

    public function fetchworkforce_categoryBySorting($sorted_colum, $data_sort_order) {
        $workforce_category = DB::table('workforce_category')
        ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'workforce_category.decipline_id')
        ->leftjoin('currencies', 'currencies.id', '=', 'workforce_category.currency_id')
        ->select('workforce_decipline.name as workforceDeciplineName','workforce_category.*','currencies.id as currency_id','currencies.code as currency_code','currencies.title as currency_title')
        ->orderBy($sorted_colum,$data_sort_order)->paginate(config('paginateRecord'));
        return $workforce_category;
    }
    public function fetchworkforce_category() {
      $workforce_category=DB::table('workforce_category')
      ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'workforce_category.decipline_id')
      ->leftjoin('currencies', 'currencies.id', '=', 'workforce_category.currency_id')
      ->select('workforce_decipline.name as workforceDeciplineName','workforce_category.*','currencies.id as currency_id','currencies.code as currency_code','currencies.title as currency_title')
      ->get();
      return $workforce_category;
     }

     public function actvfetchworkforce_category() {
       $workforce_category=DB::table('workforce_category')
       ->leftjoin('workforce_decipline', 'workforce_decipline.id', '=', 'workforce_category.decipline_id')
       ->leftjoin('currencies', 'currencies.id', '=', 'workforce_category.currency_id')
       ->select('workforce_decipline.name as workforceDeciplineName','workforce_category.*','currencies.id as currency_id','currencies.code as currency_code','currencies.title as currency_title')
       ->where('workforce_category.'.'is_active',1)->get();
       return $workforce_category;
      }
     // public function fetchworkforce_CatrgoryParent() {
     //     $material_catrgory = DB::select("SELECT * FROM `workforce_category` where parent_id IS NULL OR parent_id=0");
     //     return $material_catrgory;
     // }
}
