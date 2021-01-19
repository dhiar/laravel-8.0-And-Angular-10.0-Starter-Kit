<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Project extends Model
{
    use HasFactory;
    protected $table = 'project';
    protected $fillable=['project_reference_no','project_created_date',
    'project_client_id',
    'project_site_id','project_country_id','project_user_id','quotation_id',
    'project_status_id','project_note','project_closing_date',
    'zone_id','currency_id','is_active'];

    public function getproject($id){
          // return $this->hasMany('App\Models\Country','id');
          $results= DB::table('project')
          ->leftjoin('clients', 'clients.id', '=', 'project.project_client_id')
          ->leftjoin('sites', 'sites.id', '=', 'project.project_site_id')
          ->leftjoin('users', 'users.id', '=', 'project.project_user_id')
          ->leftjoin('zones', 'zones.id', '=', 'project.zone_id')
          ->leftjoin('currencies', 'currencies.id', '=', 'project.currency_id')
          ->select('currencies.value as CurrencyValue',
          'currencies.title as CurrencyTitle',
          'currencies.code as CurrencyCode',
          'users.name as UserName','zones.name as zoneName',
          'clients.client_name as ClientName','sites.name as SitesName','project.*')
          ->where('project.id',$id)->first();
          return $results;
    }

    public function fetchProjectForSearch($searchColum, $searchText) {
     $project =  DB::table('project')
     ->leftjoin('clients', 'clients.id', '=', 'project.project_client_id')
     ->leftjoin('sites', 'sites.id', '=', 'project.project_site_id')
     ->leftjoin('users', 'users.id', '=', 'project.project_user_id')
     ->leftjoin('zones', 'zones.id', '=', 'project.zone_id')
     ->leftjoin('currencies', 'currencies.id', '=', 'project.currency_id')
     ->select('currencies.value as CurrencyValue',
     'currencies.title as CurrencyTitle',
     'currencies.code as CurrencyCode',
     'users.name as UserName','zones.name as zoneName',
     'clients.client_name as ClientName','sites.name as SitesName','project.*');
     if ($searchColum == 'id'){
        $project->where('project.'.$searchColum,$searchText);
      }else{
        $project->where('project.'.$searchColum,'LIKE','%'.$searchText.'%');
      }
      $result = $project->paginate(config('paginateRecord'));
      return $result;
     // where($searchColum,'LIKE','%'.$searchText.'%')
     // ->paginate(config('paginateRecord'));
    }
    public function fetchProjectByPage() {
        $project = DB::table('project')
        ->leftjoin('clients', 'clients.id', '=', 'project.project_client_id')
        ->leftjoin('sites', 'sites.id', '=', 'project.project_site_id')
        ->leftjoin('users', 'users.id', '=', 'project.project_user_id')
        ->leftjoin('zones', 'zones.id', '=', 'project.zone_id')
        ->leftjoin('currencies', 'currencies.id', '=', 'project.currency_id')
        ->select('currencies.value as CurrencyValue',
        'currencies.title as CurrencyTitle',
        'currencies.code as CurrencyCode',
        'users.name as UserName','zones.name as zoneName',
        'clients.client_name as ClientName','sites.name as SitesName','project.*')
        ->paginate(config('paginateRecord'));
        return $project;
    }

    public function fetchProjectBySorting($sorted_colum, $data_sort_order) {
        $project = DB::table('project')
        ->leftjoin('clients', 'clients.id', '=', 'project.project_client_id')
        ->leftjoin('sites', 'sites.id', '=', 'project.project_site_id')
        ->leftjoin('users', 'users.id', '=', 'project.project_user_id')
        ->leftjoin('zones', 'zones.id', '=', 'project.zone_id')
        ->leftjoin('currencies', 'currencies.id', '=', 'project.currency_id')
        ->select('currencies.value as CurrencyValue',
        'currencies.title as CurrencyTitle',
        'currencies.code as CurrencyCode',
        'users.name as UserName','zones.name as zoneName',
        'clients.client_name as ClientName','sites.name as SitesName','project.*')
        ->orderBy($sorted_colum,$data_sort_order)
        ->paginate(config('paginateRecord'));
        return $project;
    }

    public function fetchProject() {
        $project = DB::table('project')
        ->leftjoin('clients', 'clients.id', '=', 'project.project_client_id')
        ->leftjoin('sites', 'sites.id', '=', 'project.project_site_id')
        ->leftjoin('users', 'users.id', '=', 'project.project_user_id')
        ->leftjoin('zones', 'zones.id', '=', 'project.zone_id')
        ->leftjoin('currencies', 'currencies.id', '=', 'project.currency_id')
        ->select('currencies.value as CurrencyValue',
        'currencies.title as CurrencyTitle',
        'currencies.code as CurrencyCode',
        'users.name as UserName','zones.name as zoneName',
        'clients.client_name as ClientName','sites.name as SitesName','project.*')
        ->get();
        return $project;
    }




    public function actvfetchProject() {
        $project = DB::table('project')
        ->leftjoin('clients', 'clients.id', '=', 'project.project_client_id')
        ->leftjoin('sites', 'sites.id', '=', 'project.project_site_id')
        ->leftjoin('users', 'users.id', '=', 'project.project_user_id')
        ->leftjoin('zones', 'zones.id', '=', 'project.zone_id')
        ->leftjoin('currencies', 'currencies.id', '=', 'project.currency_id')
        ->select('currencies.value as CurrencyValue',
        'currencies.title as CurrencyTitle',
        'currencies.code as CurrencyCode',
        'users.name as UserName','zones.name as zoneName',
        'clients.client_name as ClientName','sites.name as SitesName','project.*')
        ->where('project.'.'is_active',1)->get();
        return $project;
    }

    public function Tasks() {
       return $this->hasMany('App\Models\projectTasks','project_id');
    }
    public function workfroceDetail() {
        return $this->hasMany('App\Models\projectTasksAssignee','project_id');
    }
    public function ProjectMaterialList() {
        return $this->hasMany('App\Models\projectMaterials','project_id');
    }
    public function additionalChanres() {
       return $this->hasMany('App\Models\projectAdditionalCharges','project_id');
    }
}
