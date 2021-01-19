<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UploadController;

use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\MaterialCategoryController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\ProjectapiController;
use App\Http\Controllers\Api\ContracttypeController;
use App\Http\Controllers\Api\WorkrolesController;
use App\Http\Controllers\Api\WorkforceController;
use App\Http\Controllers\Api\DisciplineController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Api\LabourController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\AgencyController;
use App\Http\Controllers\Api\MaterialApiController;
use App\Http\Controllers\Api\RateCardController;
use App\Http\Controllers\Api\QuotationController;
use App\Http\Controllers\Api\QuotationMaterialController;
use App\Http\Controllers\Api\TaskCategoryController;
use App\Http\Controllers\Api\WorkForceCategoryController;
use App\Http\Controllers\Api\QuotationStatusController;
use App\Http\Controllers\Api\WorkForceDisciplineController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\CommonDisbuterController;
use App\Http\Controllers\Api\WorkForceLoginController;
/*
|--------------------------------------------------------------------------
| LOGIN CALL
|--------------------------------------------------------------------------
*/
Route::post('login', [LoginController::class,'login']);
Route::post('WorkForcelogin', [WorkForceLoginController::class,'login']);
Route::get('test', [CountryController::class,'test']);
Route::get('fetchSymbols', [CountryController::class,'currencyDetail']);

// Route::group(['middleware' => ['cors', 'json.response','auth:api']], function () {
// manufacturers
Route::get('Fetchmanufacturers', [ManufacturerController::class,'fetchmanufacturers'])->name('fetch.manufacturers');
Route::post('add-manufacturers', [ManufacturerController::class,'add_manufacturers'])->name('add.manufacturers');
Route::get('show-manufacturers/{id}', [ManufacturerController::class,'show_manufacturers'])->name('show.manufacturers');
Route::get('delete-manufacturers/{id}', [ManufacturerController::class,'delete_manufacturers'])->name('delete.manufacturers');
Route::post('edit-manufacturers', [ManufacturerController::class,'edit_manufacturers'])->name('edit.manufacturers');
Route::get('ActiveFetchmanufacturers', [ManufacturerController::class,'Activemanufacturers']);
// common distributer
Route::get('FetchCommonDisbuter', [CommonDisbuterController::class,'fetchCommonDisbuter'])->name('fetch.CommonDisbuter');
Route::post('add-CommonDisbuter', [CommonDisbuterController::class,'add_CommonDisbuter'])->name('add.CommonDisbuter');
Route::get('show-CommonDisbuter/{id}', [CommonDisbuterController::class,'show_CommonDisbuter'])->name('show.CommonDisbuter');
Route::get('delete-CommonDisbuter/{id}', [CommonDisbuterController::class,'delete_CommonDisbuter'])->name('delete.CommonDisbuter');
Route::post('edit-CommonDisbuter', [CommonDisbuterController::class,'edit_CommonDisbuter'])->name('edit.CommonDisbuter');
Route::get('ActiveFetchCommonDisbuter', [CommonDisbuterController::class,'ActiveCommonDisbuter']);
// quotation
Route::post('quotationStore',[QuotationController::class,'quotationStore'])->name('quotation.store');
Route::get('FetchQuotation',[QuotationController::class,'FetchQuotation'])->name('Fetch.Quotation');
Route::get('GetQuotation-id/{id}',[QuotationController::class,'GetQuotation'])->name('Get.Quotation');
Route::get('DeleteQuotation-id/{id}',[QuotationController::class,'DeleteQuotation'])->name('Delete.Quotation');
Route::post('UpdateQuotation-id',[QuotationController::class,'UpdateQuotation'])->name('update.Quotation');
Route::get('ActiveFetchQuotation',[QuotationController::class,'ActiveFetchQuotation']);
//project
// Route::post('ProjectStore',[ProjectapiController::class,'ProjectStore'])->name('Project.store');
Route::post('project-update',[ProjectapiController::class,'projectUpdate'])->name('project.update');
Route::get('project-delete/{id?}',[ProjectapiController::class,'projectDelete'])->name('project.delete');
Route::get('Fetchproject',[ProjectapiController::class,'getAllProject'])->name('get.all.project');
Route::get('get-project-id/{id}',[ProjectapiController::class,'getProjectById'])->name('get.project.by.id');
Route::get('Fetch-project-id/{id}',[ProjectapiController::class,'FetchProjectById']);
Route::get('ActiveFetchproject',[ProjectapiController::class,'ActivegetAllProject']);
Route::post('getProjectByWorkForce',[ProjectapiController::class,'getProjectByWorkForce']);
Route::get('getProjectWithAllData',[ProjectapiController::class,'getProjectWithAllData']);
Route::post('AssignOrUnAssign',[ProjectapiController::class,'AssignOrUnAssign']);
Route::post('AddHours',[ProjectapiController::class,'AddHours']);

// quotation draft
Route::post('quotationDraft',[QuotationController::class,'quotationDraft'])->name('quotation.draft');

// quotation status
Route::post('quotationStatusStore',[QuotationStatusController::class,'quotationStatusStore'])->name('quotationStatus.store');
Route::get('FetchQuotationStatus',[QuotationStatusController::class,'FetchQuotationStatus'])->name('Fetch.QuotationStatus');
Route::get('GetQuotationStatus-id/{id}',[QuotationStatusController::class,'GetQuotationStatus'])->name('Get.QuotationStatus');
Route::get('DeleteQuotationStatus-id/{id}',[QuotationStatusController::class,'DeleteQuotationStatus'])->name('Delete.QuotationStatus');
Route::post('UpdateQuotationStatus-id',[QuotationStatusController::class,'UpdateQuotationStatus'])->name('update.QuotationStatus');
// task category
Route::get('FetchTaskCategry/{parent?}', [TaskCategoryController::class,'FetchTaskCategry'])->name('fetch.task_category');
Route::post('addTaskCategry', [TaskCategoryController::class,'addTaskCategry'])->name('add.Taskcategory');
Route::get('showTaskCategry/{id}', [TaskCategoryController::class,'showTaskCategry'])->name('show.Taskcategory');
Route::get('deleteTaskCategry/{id}', [TaskCategoryController::class,'deleteTaskCategry'])->name('delete.Taskcategory');
Route::post('editTaskCategry', [TaskCategoryController::class,'editTaskCategry'])->name('edit.Taskcategory');
Route::get('ActiveFetchTaskCategry', [TaskCategoryController::class,'ActiveFetchTaskCategry']);






  Route::get('get-all-contract-type',[ContracttypeController::class,'contractTypeList'])->name('contract.type.list');
  Route::post('contract-type-store',[ContracttypeController::class,'contractTypeStore'])->name('contract.type.store');
  Route::get('get-contract-type-by-id/{id?}',[ContracttypeController::class,'contractTypeById'])->name('contract.type.by.id');
  Route::post('contract-type-update',[ContracttypeController::class,'contractTypeUpdate'])->name('contract.type.update');
  Route::get('delete-contract-type/{id?}',[ContracttypeController::class,'deleteContractType'])->name('delete.contract.type');
  // work force nature
  Route::get('FetchWorkNature',[WorkforceController::class,'FetchWorkNature'])->name('Fetch.WorkNature');
  // forget Password
  Route::post('ForgetPass',[UserApiController::class,'ForgetPass'])->name('forget.pass');
  // set new Password
  Route::post('ReSetPass',[UserApiController::class,'ReSetPass'])->name('ReSet.pass');
  // change Password
    Route::post('change-pass',[UserApiController::class,'change_pass'])->name('change.pass');

  Route::get('get-all-work-roles',[WorkrolesController::class,'getAllWorkRoles'])->name('get.all.work.roles');
  Route::post('work-role-store',[WorkrolesController::class,'workRoleStore'])->name('work.role.store');
  Route::get('get-work-role-by-id/{id?}',[WorkrolesController::class,'getWorkRoleById'])->name('get.work.role.by.id');
  Route::post('work-role-update',[WorkrolesController::class,'workRoleUpdate'])->name('work.role.update');
  Route::get('delete-work-role/{id?}',[WorkrolesController::class,'deleteWorkRole'])->name('delete.work.role');
  // work force
  Route::get('get-all-work-force',[WorkforceController::class,'getAllWorkForce'])->name('get.all.work.force');
  Route::post('work-force-store',[WorkforceController::class,'workForceStore'])->name('work.force.store');
  Route::get('get-work-force-by-id/{id?}',[WorkforceController::class,'getWorkForceById'])->name('get.work.force.by.id');
  Route::post('work-force-update',[WorkforceController::class,'workForceUpdate'])->name('work.force.update');
  Route::get('delete-work-force/{id?}',[WorkforceController::class,'deleteWorkForce'])->name('delete.Work.Force');
  Route::get('Activework-force',[WorkforceController::class,'ActivegetAllWorkForce'])->name('get.all.work.force');


  Route::get('get-all-discipline',[DisciplineController::class,'getAllDiscipline'])->name('get.all.discipline');
  Route::post('discipline-store',[DisciplineController::class,'disciplinestore'])->name('discipline.store');
  Route::get('get-discipline-by-id/{id?}',[DisciplineController::class,'getDisciplineById'])->name('get.discipline.by.id');
  Route::post('discipline-update',[DisciplineController::class,'disciplineUpdate'])->name('discipline.update');
// client
  Route::get('get-all-client',[ClientController::class,'getAllClient'])->name('get.all.client');
  Route::post('client-store',[ClientController::class,'clientStore'])->name('client.store');
  Route::get('get-client-by-id/{id}',[ClientController::class,'getClientById'])->name('get.client.by.id');
  Route::post('client-update',[ClientController::class,'clientUpdate'])->name('client.update');
  Route::get('delete-client/{id}',[ClientController::class,'deleteClient'])->name('delete.client');
  Route::post('search-client',[ClientController::class,'searchClient'])->name('search.client');
  Route::get('Activeget-all-client',[ClientController::class,'ActivegetAllClient']);
// site
  Route::get('get-all-site',[SiteController::class,'getAllSite'])->name('get.all.site');
  Route::post('site-store',[SiteController::class,'siteStore'])->name('site.store');
  Route::post('update-sites-by-map',[SiteController::class,'updateSitesByMap']);
  Route::get('get-site-by-id/{id?}',[SiteController::class,'getSiteById'])->name('get.site.by.id');
  Route::post('site-update',[SiteController::class,'siteUpdate'])->name('site.update');
  Route::get('delete-site/{id?}',[SiteController::class,'deleteSite'])->name('delete.site');
  Route::get('Activeget-all-site',[SiteController::class,'ActivegetAllSite']);


  Route::get('get-all-labour',[LabourController::class,'getAllLabour'])->name('get.all.labour');
  Route::post('labour-store',[LabourController::class,'labourStore'])->name('labour.store');
  Route::get('get-labour-by-id/{id?}',[LabourController::class,'getLabourById'])->name('get.labour.by.id');
  Route::post('labour-update',[LabourController::class,'labourUpdate'])->name('labour.update');
  Route::get('delete-labour/{id?}',[LabourController::class,'deleteLabour'])->name('delete.labour');
  Route::get('delete-discipline/{id}',[DisciplineController::class,'deleteDiscipline'])->name('delete.discipline');

  Route::get('get-all-task',[TaskController::class,'getAllTask'])->name('get.all.task');
  Route::post('task-store',[TaskController::class,'taskStore'])->name('task.store');
  Route::get('get-task-by-id/{id?}',[TaskController::class,'getTaskById'])->name('get.task.by.id');
  Route::post('task-update',[TaskController::class,'taskUpdate'])->name('task.update');
  Route::get('delete-task/{id?}',[TaskController::class,'deleteTask'])->name('delete.task');
  Route::get('Activeget-all-task',[TaskController::class,'ActivegetAllTask']);
  // rate card
  Route::post('add-WorkForceCategory', [WorkForceCategoryController::class,'add_workforcecategory'])->name('add.workforcecategory');
  Route::get('FetchWorkForceCategory/{parent?}', [WorkForceCategoryController::class,'Fetchworkforcecategory'])->name('Fetch.workforcecategory');
  Route::get('get-WorkForceCategory/{id?}',[WorkForceCategoryController::class,'getworkforcecategory'])->name('get.workforcecategory');
  Route::post('WorkForceCategory-update',[WorkForceCategoryController::class,'workforcecategoryUpdate'])->name('workforcecategory.update');
  Route::get('delete-WorkForceCategory/{id?}',[WorkForceCategoryController::class,'deleteworkforcecategory'])->name('delete.workforcecategory');
  Route::get('ActiveFetchWorkForceCategory', [WorkForceCategoryController::class,'ActiveFetchworkforcecategory']);
  // work force discipline
  Route::get('FetchWorkForceDiscipline/{parent?}', [WorkForceDisciplineController::class,'FetchWorkForceDiscipline'])->name('Fetch.WorkForceDiscipline');
  Route::post('add-WorkForceDiscipline', [WorkForceDisciplineController::class,'add_WorkForceDiscipline'])->name('add.WorkForceDiscipline');
  Route::get('get-WorkForceDiscipline-id/{id?}',[WorkForceDisciplineController::class,'getworkforceDiscipline'])->name('get.workforceDiscipline');
  Route::post('WorkForceDiscipline-update',[WorkForceDisciplineController::class,'WorkForceDisciplineUpdate'])->name('WorkForceDiscipline.update');
  Route::get('delete-WorkForceDiscipline/{id?}',[WorkForceDisciplineController::class,'deleteWorkForceDiscipline'])->name('delete.WorkForceDiscipline');
    Route::get('ActiveFetchWorkForceDiscipline', [WorkForceDisciplineController::class,'ActiveFetchWorkForceDiscipline']);


  Route::get('FetchUser', [UserApiController::class,'FetchUser'])->name('Fetch.user');
  Route::post('add-user', [UserApiController::class,'add_user'])->name('add.user');
  Route::post('edit-user', [UserApiController::class,'edit_user'])->name('edit.user');
  Route::get('show-user/{id}', [UserApiController::class,'show_user'])->name('show.user');
  Route::get('delete-user/{id}', [UserApiController::class,'delete_user'])->name('delete.user');
  // product vender
  Route::get('FetchProductVender', [ProductApiController::class,'FetchProductVender'])->name('Fetch.product_vender');
  Route::post('add-product-vender', [ProductApiController::class,'add_product_vender'])->name('add.product_vender');
  Route::get('show-product-vender/{id}', [ProductApiController::class,'show_product_vender'])->name('show.product_vender');
  Route::get('delete-product-vender/{id}', [ProductApiController::class,'delete_product_vender'])->name('delete.vender');
  Route::post('edit-product-vender', [ProductApiController::class,'edit_product_vender'])->name('edit.product_vender');
  Route::get('ActiveFetchProductVender', [ProductApiController::class,'ActiveFetchProductVender']);
  // product categor
  Route::post('add-product-category', [ProductApiController::class,'add_product_category'])->name('add.product_category');
  // Empployee Detail
  Route::get('FetchEmployeeDetail', [EmployeeController::class,'FetchEmployeeDetail'])->name('Fetch.employee_detail');
  Route::post('add-employee-detail', [EmployeeController::class,'add_employee_detail'])->name('add.employee_detail');
  Route::get('show-employee-detail/{id}', [EmployeeController::class,'show_employee_detail'])->name('show.employee_detail');
  Route::get('delete-employee-detail/{id}', [EmployeeController::class,'delete_employee_detail'])->name('delete.employee_detail');
  Route::post('edit-employee-detail', [EmployeeController::class,'edit_employee_detail'])->name('edit.employee_detail');
  //unit
  Route::get('FetchUnit', [UnitController::class,'fetchUnit'])->name('fetch.unit');
  Route::post('add-unit', [UnitController::class,'add_unit'])->name('add.unit');
  Route::get('show-unit/{id}', [UnitController::class,'show_unit'])->name('show.unit');
  Route::get('delete-unit/{id}', [UnitController::class,'delete_unit'])->name('delete.unit');
  Route::post('edit-unit', [UnitController::class,'edit_unit'])->name('edit.unit');
  Route::get('ActiveFetchUnit', [UnitController::class,'activefetchUnit']);
  //  Material category
  Route::get('fetchmaterial_category/{parent?}', [MaterialCategoryController::class,'fetch_material_category'])->name('fetch.material_category');
  Route::post('add-material_category', [MaterialCategoryController::class,'add_material_category'])->name('add.material_category');
  Route::get('show-material_category/{id}', [MaterialCategoryController::class,'show_material_category'])->name('show.material_category');
  Route::get('delete-material_category/{id}', [MaterialCategoryController::class,'delete_material_category'])->name('delete.material_category');
  Route::post('edit-material_category', [MaterialCategoryController::class,'edit_material_category'])->name('edit.material_category');
  Route::get('Activefetchmaterial_category', [MaterialCategoryController::class,'Activefetch_material_category']);
  // currency
  Route::get('fetchcurrency', [CurrencyController::class,'fetchCurrencies'])->name('fetch.currency');
  Route::post('add-currency', [CurrencyController::class,'add_currency'])->name('add.currency');
  Route::get('show-currency/{id}', [CurrencyController::class,'show_currency'])->name('show.currency');
  Route::get('delete-currency/{id}', [CurrencyController::class,'delete_currency'])->name('delete.currency');
  Route::post('edit-currency', [CurrencyController::class,'edit_currency'])->name('edit.currency');
  Route::get('Activefetchcurrency', [CurrencyController::class,'activefetchCurrencies']);
  // Material
  Route::get('FetchMaterial', [MaterialApiController::class,'FetchMaterial'])->name('Fetch.material');
  Route::post('add-material', [MaterialApiController::class,'add_material'])->name('add.material');
  Route::get('show-material/{id}', [MaterialApiController::class,'show_material'])->name('show.material');
  Route::get('delete-material/{id}', [MaterialApiController::class,'delete_material'])->name('delete.material');
  Route::post('edit-material', [MaterialApiController::class,'edit_material'])->name('edit.material');
  Route::get('ActiveFetchMaterial', [MaterialApiController::class,'ActiveFetchMaterial']);
  // Agency
  Route::get('fetchagency', [AgencyController::class,'FetchAgencies'])->name('fetch.agency');
  Route::post('add-agency', [AgencyController::class,'add_agency'])->name('add.agency');
  Route::get('show-agency/{id}', [AgencyController::class,'show_agency'])->name('show.agency');
  Route::get('delete-agency/{id}', [AgencyController::class,'delete_agency'])->name('delete.agency');
  Route::post('edit-agency', [AgencyController::class,'edit_agency'])->name('edit.agency');
  Route::get('Activefetchagency', [AgencyController::class,'ActiveFetchAgencies']);




    /*
    |--------------------------------------------------------------------------
    | PROFILE CALL
    |--------------------------------------------------------------------------
    */
    Route::post('updateProfile', [ProfileController::class,'updateProfile']);
    /*
    |--------------------------------------------------------------------------
    | COUNTRIES CRUD CALL
    |--------------------------------------------------------------------------
    */
    Route::get('fetchCountries', [CountryController::class,'fetchCountries']);
    Route::post('addCountry', [CountryController::class,'addCountry']);
    Route::get('fetchCountryById/{id}', [CountryController::class,'getCountryById']);
    Route::post('updateCountry', [CountryController::class,'updateCountry']);
    Route::get('deleteCountry/{id}', [CountryController::class,'deleteCountry']);
    Route::get('ActivefetchCountries', [CountryController::class,'activefetchCountries']);
    /*
    |--------------------------------------------------------------------------
    | CSTATES CRUD CALL
    |--------------------------------------------------------------------------
    */
    Route::get('fetchCstates', [StateController::class,'fetchStates']);
    Route::post('addCstate', [StateController::class,'addState']);
    Route::get('fetchCstateById/{id}', [StateController::class,'getStateById']);
    Route::get('getStatesByCountry/{id}', [StateController::class,'getStatesByCountry']);
    Route::post('updateCstate', [StateController::class,'updateState']);
    Route::get('deleteCstate/{id}', [StateController::class,'deleteState']);
    Route::get('ActivefetchCstates', [StateController::class,'activefetchStates']);
    /*
    /*
    |--------------------------------------------------------------------------
    | CITIES CRUD CALL
    |--------------------------------------------------------------------------
    */
    Route::get('fetchCities', [CityController::class,'fetchCities']);
    Route::post('addCity', [CityController::class,'addCity']);
    Route::get('fetchCityById/{id}', [CityController::class,'getCityById']);
    Route::get('fetchCitiesByState/{id}', [CityController::class,'fetchCitiesByState']);
    Route::get('fetchCitiesByCountry/{id}', [CityController::class,'fetchCitiesByCountry']);
    Route::post('updateCity', [CityController::class,'updateCity']);
    Route::get('deleteCity/{id}', [CityController::class,'deleteCity']);
    Route::get('ActivefetchCities', [CityController::class,'activefetchCities']);
    /*
    |--------------------------------------------------------------------------
    | ZONES CRUD CALL
    |--------------------------------------------------------------------------
    */
    Route::get('fetchZones', [ZoneController::class,'fetchZones']);
    Route::post('addZone', [ZoneController::class,'addZone']);
    Route::get('fetchZoneById/{id}', [ZoneController::class,'getZoneById']);
    Route::post('updateZone', [ZoneController::class,'updateZone']);
    Route::get('deleteZone/{id}', [ZoneController::class,'deleteZone']);
    Route::get('ActivefetchZones', [ZoneController::class,'activefetchZones']);

    /*
    |--------------------------------------------------------------------------
    | MAP CALL
    |--------------------------------------------------------------------------
    */
    Route::get('getCords/{id}', [MapController::class,'getCords']);
    Route::get('updateCords', [MapController::class,'updateCords']);

    /*
    |--------------------------------------------------------------------------
    | LANGUAGES CRUD CALL
    |--------------------------------------------------------------------------
    */
    Route::get('fetchLanguages', [LanguageController::class,'fetchLanguages']);
    Route::post('addLanguage', [LanguageController::class,'addLanguage']);
    Route::get('fetchLanguageById/{id}', [LanguageController::class,'getLanguageById']);
    Route::get('fetchLanguageByCountry/{id}', [LanguageController::class,'fetchLanguageByCountry']);
    Route::post('updateLanguage', [LanguageController::class,'updateLanguage']);
    Route::get('deleteLanguage/{id}', [LanguageController::class,'deleteLanguage']);
    Route::get('ActivefetchLanguages', [LanguageController::class,'ActivefetchLanguages']);
    /*
    |--------------------------------------------------------------------------
    | ROLES CRUD CALL
    |--------------------------------------------------------------------------
    */
    Route::get('fetchRoles', [RoleController::class,'fetchRoles']);
    Route::post('addRole', [RoleController::class,'addRole']);
    Route::get('fetchRoleById/{id}', [RoleController::class,'getRoleById']);
    Route::post('updateRole', [RoleController::class,'updateRole']);
    Route::get('deleteRole/{id}', [RoleController::class,'deleteRole']);
    /*
    |--------------------------------------------------------------------------
    | PERMISSIONS CRUD CALL
    |--------------------------------------------------------------------------
    */
    Route::get('fetchPermissions/{id}', [PermissionController::class,'fetchPermissionsByRole']);
    Route::get('fetchAllPermissions/{id}', [PermissionController::class,'fetchPermissions']);
    Route::post('updatePermission', [PermissionController::class,'updatePermission']);
    /*
    |--------------------------------------------------------------------------
    | LOGOUT CRUD CALL
    |--------------------------------------------------------------------------
    */
    Route::post('logout', [LoginController::class,'logout']);
    Route::post('workforcelogout', [WorkForceLoginController::class,'logout']);

 // });


   /*
   |--------------------------------------------------------------------------
   | FILE PATH CALL
   |--------------------------------------------------------------------------
   */
    Route::get('images/{type}/{filename}', function ($type, $filename)
    {

      $path = public_path('images/'.$type. '/' . $filename);
      if (!File::exists($path)) {
        abort(404);
      }

      $file = File::get($path);
      $type = File::mimeType($path);

      $response = Response::make($file, 200);
      $response->header("Content-Type", $type);

      return $response;
    });
