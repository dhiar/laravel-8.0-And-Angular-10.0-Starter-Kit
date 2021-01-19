<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class quotation_status extends Model
{
    use HasFactory;
    protected $table="quotations_status";
    protected $fillable=['name','is_active','color_code','status_code'];
    public function getquotationsStatus($id){
          // return $this->hasMany('App\Models\Country','id');
          $results= DB::table('quotations_status')->where('quotations_status.id',$id)->first();
          return $results;
    }
    public function fetchQuotationStatusForSearch($searchColum, $searchText) {
     $quotationStatus =  quotation_status::where($searchColum,'LIKE','%'.$searchText.'%')
                      ->paginate(config('paginateRecord'));
         return $quotationStatus;
    }
    public function fetchQuotationStatusByPage() {
        $quotationStatus = quotation_status::paginate(config('paginateRecord'));
        return $quotationStatus;
    }

    public function fetchQuotationStatusBySorting($sorted_colum, $data_sort_order) {
        $quotationStatus = quotation_status::orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $quotationStatus;
    }


    public function fetchQuotationStatus() {
        $quotationStatus = quotation_status::get();
        return $quotationStatus;
    }
}
