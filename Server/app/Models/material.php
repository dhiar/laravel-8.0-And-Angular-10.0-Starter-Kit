<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class material extends Model
{
    use HasFactory;
    protected $table="material";
    protected $fillable=['name','category_id','manufacturer_code','currency_id','manufacturer_id','unit_price','unit','reference_no_vender','description','is_active','vendor_id'];

    public function getrecord($id){
          // return $this->hasMany('App\Models\Country','id');
          $results=DB::table('material')
          ->leftjoin('material_category', 'material_category.id', '=', 'material.category_id')
          ->leftjoin('currencies', 'currencies.id', '=', 'material.currency_id')
          ->leftjoin('unit', 'unit.id', '=', 'material.unit')
          ->leftjoin('product_vender', 'product_vender.id', '=', 'material.vendor_id')
          ->leftjoin('manufacturers', 'manufacturers.id', '=', 'material.manufacturer_id')
          ->select('material_category.name as category_name','material.*','currencies.id as currency_id','currencies.code as currency_code','currencies.title as currency_title','unit.type as unit_name','product_vender.id as venderId','product_vender.vender_name as venderName','manufacturers.name as ManufacturerName')
          ->where('material.id',$id)->first();
          return $results;
    }

    public function fetchmaterialForSearch($searchColum, $searchText) {
     $material =  DB::table('material')
     ->leftjoin('material_category', 'material_category.id', '=', 'material.category_id')
     ->leftjoin('currencies', 'currencies.id', '=', 'material.currency_id')
     ->leftjoin('unit', 'unit.id', '=', 'material.unit')
     ->leftjoin('product_vender', 'product_vender.id', '=', 'material.vendor_id')
     ->leftjoin('manufacturers', 'manufacturers.id', '=', 'material.manufacturer_id')
     ->select('material_category.name as category_name'
     ,'material.*','currencies.id as currency_id',
     'currencies.code as currency_code',
     'currencies.title as currency_title',
     'unit.type as unit_name',
     'product_vender.id as venderId',
     'product_vender.vender_name as venderName',
     'manufacturers.name as ManufacturerName');
     if ($searchColum == 'id'){
        $material->where('material.'.$searchColum,$searchText);
      }else{
        $material->where('material.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $material->paginate(config('paginateRecord'));
      return $result;
    }
    public function fetchmaterialByPage() {
        $material = DB::table('material')
        ->leftjoin('material_category', 'material_category.id', '=', 'material.category_id')
        ->leftjoin('currencies', 'currencies.id', '=', 'material.currency_id')
        ->leftjoin('unit', 'unit.id', '=', 'material.unit')
        ->leftjoin('product_vender', 'product_vender.id', '=', 'material.vendor_id')
        ->leftjoin('manufacturers', 'manufacturers.id', '=', 'material.manufacturer_id')
        ->select('material_category.name as category_name','material.*','currencies.id as currency_id','currencies.code as currency_code','currencies.title as currency_title','unit.type as unit_name','product_vender.id as venderId','product_vender.vender_name as venderName','manufacturers.name as ManufacturerName')
        ->paginate(config('paginateRecord'));
        return $material;
    }

    public function fetchmaterialBySorting($sorted_colum, $data_sort_order) {
        // $material = material::orderBy($sorted_colum,$data_sort_order)
        //                ->paginate(config('paginateRecord'));
        // return $material;
        $material = DB::table('material')
        ->leftjoin('material_category', 'material_category.id', '=', 'material.category_id')
        ->leftjoin('currencies', 'currencies.id', '=', 'material.currency_id')
        ->leftjoin('unit', 'unit.id', '=', 'material.unit')
        ->leftjoin('product_vender', 'product_vender.id', '=', 'material.vendor_id')
        ->leftjoin('manufacturers', 'manufacturers.id', '=', 'material.manufacturer_id')
        ->select('material_category.name as category_name','material.*','currencies.id as currency_id','currencies.code as currency_code','currencies.title as currency_title','unit.type as unit_name','product_vender.id as venderId','product_vender.vender_name as venderName','manufacturers.name as ManufacturerName')
        ->orderBy($sorted_colum,$data_sort_order)->paginate(config('paginateRecord'));
        return $material;
    }

    public function fetchmaterial() {
        $material = DB::table('material')
        ->leftjoin('material_category', 'material_category.id', '=', 'material.category_id')
        ->leftjoin('currencies', 'currencies.id', '=', 'material.currency_id')
        ->leftjoin('unit', 'unit.id', '=', 'material.unit')
        ->leftjoin('product_vender', 'product_vender.id', '=', 'material.vendor_id')
        ->leftjoin('manufacturers', 'manufacturers.id', '=', 'material.manufacturer_id')
        ->select('material_category.name as category_name','material.*','currencies.id as currency_id','currencies.code as currency_code','currencies.title as currency_title','unit.type as unit_name','product_vender.id as venderId','product_vender.vender_name as venderName','manufacturers.name as ManufacturerName')
        ->get();
        return $material;
    }

    public function actvfetchmaterial() {
        $material = DB::table('material')
        ->leftjoin('material_category', 'material_category.id', '=', 'material.category_id')
        ->leftjoin('currencies', 'currencies.id', '=', 'material.currency_id')
        ->leftjoin('unit', 'unit.id', '=', 'material.unit')
        ->leftjoin('product_vender', 'product_vender.id', '=', 'material.vendor_id')
        ->leftjoin('manufacturers', 'manufacturers.id', '=', 'material.manufacturer_id')
        ->select('material_category.name as category_name','material.*','currencies.id as currency_id','currencies.code as currency_code','currencies.title as currency_title','unit.type as unit_name','product_vender.id as venderId','product_vender.vender_name as venderName','manufacturers.name as ManufacturerName')
        ->where('material.'.'is_active',1)->get();
        return $material;
    }
}
