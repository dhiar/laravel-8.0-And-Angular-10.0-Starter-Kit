<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract_types extends Model
{
    use HasFactory;
    protected $table = 'contract_type';
    protected $fillable = [
        'name','is_active','status'
    ];
    public function fetchcontactTypesForSearch($searchColum, $searchText) {
     $Contract_types =  Contract_types::where($searchColum,'LIKE','%'.$searchText.'%')
                      ->paginate(config('paginateRecord'));
         return $Contract_types;
    }
    public function fetchcontactTypesByPage() {
        $Contract_types = Contract_types::paginate(config('paginateRecord'));
        return $Contract_types;
    }

    public function fetchcontactTypesBySorting($sorted_colum, $data_sort_order) {
        $Contract_types = Contract_types::orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $Contract_types;
    }

    public function fetchcontactTypes() {
        $Contract_types = Contract_types::get();
        return $Contract_types;
    }

}
