<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Quotations extends Model
{
    use HasFactory;
    protected $table="quotations";
    protected $fillable=['reference_no','created_date','shipment_detail','client_id','site_id','RequesterPersonEmail','DesignerPersonEmail','DesignerPerson','RequesterPerson','DesignerPersonPhone','RequesterPersonPhone','quotation_status_id','ShipmentPrice','quotation_validity_date','estimated_completed_date','attachment','is_active'];


    public function getquotations($id){
          // return $this->hasMany('App\Models\Country','id');
          $results= DB::table('quotations')
          ->leftjoin('clients', 'clients.id', '=', 'quotations.client_id')
          ->leftjoin('sites', 'sites.id', '=', 'quotations.site_id')
          ->leftjoin('quotations_status', 'quotations_status.id', '=', 'quotations.quotation_status_id')
          ->select('quotations_status.status_code as quotation_status_code','quotations_status.name as quotationStatusName','clients.client_name as ClientName','sites.name as SitesName','quotations.*')
          ->where('quotations.id',$id)->first();
          return $results;
    }
    public function fetchQuotationForSearch($searchColum, $searchText) {
     $quotation =  DB::table('quotations')
     ->leftjoin('clients', 'clients.id', '=', 'quotations.client_id')
     ->leftjoin('sites', 'sites.id', '=', 'quotations.site_id')
     ->leftjoin('quotations_status', 'quotations_status.id', '=', 'quotations.quotation_status_id')
     ->select('quotations_status.status_code as quotation_status_code','quotations_status.name as quotationStatusName',
     'clients.client_name as ClientName',
     'sites.name as SitesName','quotations.*');
     if ($searchColum == 'id'){
        $quotation->where('quotations.'.$searchColum,$searchText);
      }else{
        $quotation->where('quotations.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $quotation->paginate(config('paginateRecord'));
      return $result;
     // ->where('agencies.'. $searchColum,'LIKE','%'.$searchText.'%')
     // ->paginate(config('paginateRecord'));
     //     return $agencies;
    }
    public function fetchQuotationByPage() {
        $quotation = DB::table('quotations')
        ->leftjoin('clients', 'clients.id', '=', 'quotations.client_id')
        ->leftjoin('sites', 'sites.id', '=', 'quotations.site_id')
        ->leftjoin('quotations_status', 'quotations_status.id', '=', 'quotations.quotation_status_id')
        ->select('quotations_status.status_code as quotation_status_code','quotations_status.name as quotationStatusName','clients.client_name as ClientName','sites.name as SitesName','quotations.*')
        ->paginate(config('paginateRecord'));
        return $quotation;
    }

    public function fetchQuotationBySorting($sorted_colum, $data_sort_order) {
        $quotation = DB::table('quotations')
        ->leftjoin('clients', 'clients.id', '=', 'quotations.client_id')
        ->leftjoin('sites', 'sites.id', '=', 'quotations.site_id')
        ->leftjoin('quotations_status', 'quotations_status.id', '=', 'quotations.quotation_status_id')
        ->select('quotations_status.status_code as quotation_status_code','quotations_status.name as quotationStatusName','clients.client_name as ClientName','sites.name as SitesName','quotations.*')
        ->orderBy($sorted_colum,$data_sort_order)->paginate(config('paginateRecord'));
        return $quotation;
    }


    public function fetchQuotation() {
      $quotation=DB::table('quotations')
      ->leftjoin('clients', 'clients.id', '=', 'quotations.client_id')
      ->leftjoin('sites', 'sites.id', '=', 'quotations.site_id')
      ->leftjoin('quotations_status', 'quotations_status.id', '=', 'quotations.quotation_status_id')
      ->select('quotations_status.status_code as quotation_status_code','quotations_status.name as quotationStatusName','clients.client_name as ClientName','sites.name as SitesName','quotations.*')
      ->get();
      return $quotation;
     }
     public function ActivefetchQuotation() {
       $quotation=DB::table('quotations')
       ->leftjoin('clients', 'clients.id', '=', 'quotations.client_id')
       ->leftjoin('sites', 'sites.id', '=', 'quotations.site_id')
       ->leftjoin('quotations_status', 'quotations_status.id', '=', 'quotations.quotation_status_id')
       ->select('quotations_status.status_code as quotation_status_code','quotations_status.name as quotationStatusName','clients.client_name as ClientName','sites.name as SitesName','quotations.*')
       ->where('quotations.'.'is_active',1)->get();
       return $quotation;
      }
     public function Tasks() {
        return $this->hasMany('App\Models\quotation_tasks','quotation_id');
     }
     public function workfroceDetail() {
         return $this->hasMany('App\Models\quotation_tasks_assignee','quotation_id');
     }
     public function QoutationMaterialList() {
         return $this->hasMany('App\Models\Quotations_Materials','quotation_id');
     }
     public function additionalChanres() {
        return $this->hasMany('App\Models\Quotation_Charges','quotation_id');
     }


}
