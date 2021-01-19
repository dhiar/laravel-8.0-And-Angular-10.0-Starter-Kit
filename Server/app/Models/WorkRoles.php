<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkRoles extends Model
{
    use HasFactory;
    protected $table = 'work_roles';
    protected $fillable = [
        'name','is_active','status'
    ];
    public function fetchWorkRolesForSearch($searchColum, $searchText) {
     $WorkRoles =  WorkRoles::where($searchColum,'LIKE','%'.$searchText.'%')
                      ->paginate(config('paginateRecord'));
         return $WorkRoles;
    }
    public function fetchWorkRolesByPage() {
        $WorkRoles = WorkRoles::paginate(config('paginateRecord'));
        return $WorkRoles;
    }

    public function fetchWorkRolesBySorting($sorted_colum, $data_sort_order) {
        $WorkRoles = WorkRoles::orderBy($sorted_colum,$data_sort_order)
                       ->paginate(config('paginateRecord'));
        return $WorkRoles;
    }

    public function fetchWorkRoles() {
        $WorkRoles = WorkRoles::get();
        return $WorkRoles;
    }
}
