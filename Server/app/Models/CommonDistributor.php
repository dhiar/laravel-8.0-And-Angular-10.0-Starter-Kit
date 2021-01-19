<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonDistributor extends Model
{
    use HasFactory;
    protected $table="common_distributor";
    protected $fillable=['name','is_active'];
    public function fetchcommondistributorForSearch($searchColum, $searchText) {
     $commondistributor =   DB::table('common_distributor');
     if ($searchColum == 'id'){
        $commondistributor->where('common_distributor.'.$searchColum,$searchText);
      }else{
        $commondistributor->where('common_distributor.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $commondistributor->paginate(config('paginateRecord'));
      return $result;
     // where($searchColum,'LIKE','%'.$searchText.'%')
     //  ->paginate(config('paginateRecord'));
     //     return $commondistributor;
    }
    public function fetchcommondistributorByPage() {
        $commondistributor = CommonDistributor::paginate(config('paginateRecord'));
        return $commondistributor;
    }

    public function fetchcommondistributorBySorting($sorted_colum, $data_sort_order) {
        $commondistributor = CommonDistributor::orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $commondistributor;
    }


    public function fetchcommondistributor() {
        $commondistributor = CommonDistributor::get();
        return $commondistributor;
    }
    public function actvfetchcommondistributor() {
        $commondistributor = CommonDistributor::where('common_distributor.'.'is_active',1)->get();
        return $commondistributor;
    }
}
