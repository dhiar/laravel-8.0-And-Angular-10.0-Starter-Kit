<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use http\Env\Response;
use Illuminate\Http\Request;
use Validator;
use App\Models\Project;
use App\Models\projectTasks;
use App\Models\projectTasksAssignee;
use App\Models\projectMaterials;
use App\Models\projectAdditionalCharges;
use App\Models\Workforce;
use DB;
class ProjectapiController extends Controller
{

  public function __construct(Project $Project,Workforce $Workforce)
  {
    $this->Project = $Project;
    $this->Workforce = $Workforce;
  }

    public function getAllProject(Request $request){
      if($request->searchText){
          $Project = $this->Project->fetchProjectForSearch($request->searchColum,$request->searchText);
          return response()->json($Project);
      }
      if($request->page && !$request->data_sort_order){
          $Project = $this->Project->fetchProjectByPage();
          return response()->json($Project);
      }
      else if($request->data_sort_order){
          $Project = $this->Project->fetchProjectBySorting($request->sorted_colum,$request->data_sort_order);
          return response()->json($Project);
      }
      $Project = $this->Project->fetchProject();
      return response()->json($Project);
    }


    public function ActivegetAllProject(){
      $Project = $this->Project->actvfetchProject();
      return response()->json($Project);
    }

      public function AssignOrUnAssign(Request $request){
      //unassign
        if($request->status == 0){
          DB::table('workforce_projects')
            ->where('project_id',$request->project_id)
            ->where('workforce_id',$request->workforce_id)
            ->delete();
            return response()->json('success',200);
        }
        //assign
        else{
          DB::table('workforce_projects')
            ->insertGetId([
              'project_id' => $request->project_id,
              'workforce_id' => $request->workforce_id
            ]);
            return response()->json('success',200);
        }

      }

      public function AddHours(Request $request){
        DB::table('workforce_projects')
        ->where('project_id',$request->project_id)
        ->where('workforce_id',$request->workforce_id)
        ->update([
          'spent_hours' => $request->spent_hours
        ]);
        return response()->json('success',200);
      }


      public function getProjectByWorkForce(Request $request){

          $id=$request->workforce_id;
          $workForce = $this->Workforce->getrecord($id);
          // return response()->json($workForce);
          $records = DB::table('workforce_projects')
                      ->where('workforce_id','=',$id)
                      ->get();
                      // foreach ($records as $key => $value) {
                      //   // $workForce = $this->Workforce->getrecord($value->workforce_id);
                      //   $slectProject = \App\Models\Project::with('ProjectMaterialList')
                      //   ->with('Tasks')->with('workfroceDetail')
                      //   ->with('additionalChanres')
                      //   ->where('id',$value->project_id)
                      //   ->get();
                      //   $value->projectDetail = $slectProject;
                      // }

          $slectProject = \App\Models\Project::with('ProjectMaterialList')
          ->with('Tasks')->with('workfroceDetail')
          ->with('additionalChanres')
          ->whereHas('workfroceDetail', function($q) use ($workForce){
              $q->where('workforce_category_id','=',$workForce->category_id);
          })->where('zone_id',$workForce->zone_id)->get()->toArray();

           $f = json_decode(json_encode($slectProject));

          foreach ($f as $key => $a) {
            foreach ($records as $key => $b) {
              if($a->id == $b->project_id && $b->workforce_id == $id){
                $a->assigned_to_me = 1;
                $a->spent_hours = $b->spent_hours;
              }
            }
            $res = DB::table('workforce_projects')
                        ->where('workforce_id','!=',$id)
                        ->where('project_id','=',$a->id)
                        ->get();
              if(count($res) > 0){
                $a->assigned_to_other = $res[0]->workforce_id;
                $a->spent_hours = $res[0]->spent_hours;

              }
          }




                      return response()->json($f);
                      // ->where('zone_id',$workForce->zone_id)
                      // ->whereHas('workfroceDetail', function($q) use ($workForce){
                      //   $q->where('workforce_category_id','=',$workForce->category_id);
                      // })
                      //




                    // dd(json_encode($slectProject));

          //   $q->where('project_tasks_assignee.workforce_category_id','=',$workForce->category_id);
          //   // $q->where('project.zone_id','=',$workForce->zone_id);
          // });
          // $slectProject=Project::with('ProjectMaterialList')->with('Tasks')->with('workfroceDetail')->with('additionalChanres')
          // $slectProject=DB::table('project')
          // ->select('project.*')
          // ->leftjoin('project_tasks_assignee', 'project_tasks_assignee.project_id', '=', 'project.id')
          // ->leftjoin('project_additional_charges', 'project_additional_charges.project_id', '=', 'project.id')
          // ->leftjoin('project_materials', 'project_materials.project_id', '=', 'project.id')
          // ->leftjoin('project_tasks', 'project_tasks.project_id', '=', 'project.id')
          // ->where('project_tasks_assignee.workforce_category_id','=',$workForce->category_id)
          // ->where('project.zone_id','=',$workForce->zone_id)
          // ->groupBy('project.id')
          // ->get();

      }
//     public function ProjectStore(Request $request){
//       if($request->QuoteStatusId == 4){
//       // $ProData = json_decode(json_encode($request->data),true);
//       $ProData = json_decode($request->data,true);
//       // dd($ProData);
//
//         $project=new Project();
//         $project->name=$ProData['projectName'];
//         $project->project_reference_no = $ProData['ReferenceNo'];
//         $project->project_created_date = $ProData['Createdate'];
//         $project->project_shipment_detail = $ProData['ShipmentDetail'];
//         $project->project_client_id = $ProData['ClientId'];
//         $project->project_site_id = $ProData['SiteId'];
//         $project->project_country_id = $ProData['CountryId'];
//         $project->quotation_id = $request->QuotationId;
//         $project->project_user_id = $request->userId;
//         $project->ProjectRequesterPersonEmail= $ProData['RequesterPersonEmail'];
//         $project->ProjectDesignerPersonEmail = $ProData['DesignerPersonEmail'];
//         $project->ProjectDesignerPerson = $ProData['DesignerPerson'];
//         $project->ProjectRequesterPerson = $ProData['RequesterPerson'];
//         $project->ProjectDesignerPersonPhone = $ProData['DesignerPersonPhone'];
//         $project->ProjectRequesterPersonPhone = $ProData['RequesterPersonPhone'];
//         $project->project_status_id = 4;
//         $project->project_note = $ProData['QuotationNote'];
//         $project->ProjectShipmentPrice = $ProData['RequesterPersonPhone'];
//         $project->project_shipment_currency_id = $ProData['ShipmentCurrencyId'];
//         $project->project_validity_date= $ProData['ValidityDate'];
//         $project->project_estimated_completed_date= $ProData['EstimatesComplationDate'];
//         $project->project_attachment= $ProData['FileAttach'];
//         $project->save();
//         $getlast=$project->id;
//         foreach ($ProData['QoutationMaterialList'] as $individual_ProjectMaterialList)
//           {
//             DB::table('project_materials')->insert([
//                   'project_id' => $getlast,
//                   'material_id' => $individual_ProjectMaterialList['MaterialId'],
//                   'material_name' => $individual_ProjectMaterialList['MaterialName'],
//                   'qty' => $individual_ProjectMaterialList['Qty'],
//                   'price' => $individual_ProjectMaterialList['price'],
//                   'vender_id' => $individual_ProjectMaterialList['VenderId'],
//                   'vender_name' => $individual_ProjectMaterialList['VenderName'],
//                   'currency_id' => $individual_ProjectMaterialList['CurrencyId'],
//                   'currency_name' => $individual_ProjectMaterialList['CurrencyName'],
//                   'Unit' => $individual_ProjectMaterialList['Unit'],
//                   'distributor_no' => $individual_ProjectMaterialList['Qty'],
//                   'Description' => $individual_ProjectMaterialList['Description'],
//                   'manufacture_id' => $individual_ProjectMaterialList['ManufactureId'],
//                   'manufacture_name' => $individual_ProjectMaterialList['ManufactureName'],
//                   'manufacture_no' => $individual_ProjectMaterialList['DistributorNo'],
//                   'sub_total'=> $individual_ProjectMaterialList['SubTotal']
//                 ]);
//           }
//
//         foreach ($ProData['Tasks'] as $individual_task)
//           {
//             $last_id = DB::table('project_tasks')
//                 ->insertGetId([
//                   'task_id' => $individual_task['taskId'],
//                   'project_id' => $getlast,
//                   'per_houre_rate' => $individual_task['perHoureRate'],
//                   'task_code' => $individual_task['taskCode'],
//                   'description'=> $individual_task['Description'],
//                   'qty'=> $individual_task['qty'],
//                   'sub_total'=> $individual_task['subTotal']
//                 ]);
//           }
//           foreach ($ProData['additionalChanres'] as $individual_additionalChanres)
//             {
//               DB::table('project_additional_charges')
//                   ->insert([
//                     'price' => $individual_additionalChanres['price'],
//                     'description' => $individual_additionalChanres['desctiption'],
//                     'project_id' => $getlast
//                   ]);
//             }
//           foreach ($ProData['workfroceDetail'] as $individual_taskDetailDto)
//             {
//               DB::table('project_tasks_assignee')
//                   ->insert([
//                     'project_id' => $getlast,
//                     'workforce_id' => $individual_taskDetailDto['workforceId'],
//                     'alot_time' => $individual_taskDetailDto['houre'],
//                     'price' => $individual_taskDetailDto['Price'],
//                     'time_type' => $individual_taskDetailDto['timeType'],
//                     'workforce_name' => $individual_taskDetailDto['workforceName']
//                   ]);
//             }
//             // $projects = Quotations::with('QoutationMaterialList')->with('Tasks')->with('workfroceDetail')->with('additionalChanres')->find($getlast);
//             $add_project = [
//
//                 'status' => true,
//                 'success' => 1,
//                 'message' => 'Project added successfully'
//             ];
//   // if($project->save()){
//   //
//     // $quotation=Quotations::find($getlast);
//
//   }else{
//     $add_project = [
//         'status' => false,
//         'success' => 0,
//         'message' => ''
//     ];
//   }
//           return response()->json($add_project);
// }
public function getProjectWithAllData(){
    $projectsByID = Project::with('ProjectMaterialList')->with('Tasks')->with('workfroceDetail')->with('additionalChanres')->get();
      // $getquotation = $this->quotations->getquotations($id);
      if($projectsByID){
        $show_project=[
            'data' => $projectsByID,
            'message' => 'Project Detail',
            'success' => '1',
            'status' => 'true'
          ];
  }else{
    $show_project=[
      'message' => 'Something probelm in internal system',
      'success' => '0',
      'status' => 'false'
    ];
  }
  return response()->json($show_project);

}

public function FetchProjectById($id){
  $projectsByID=$this->Project->getproject($id);
  if($projectsByID){
      $show_project=[
          'data' => $projectsByID,
          'message' => 'Project Detail',
          'success' => '1',
          'status' => 'true'
        ];
      }else{
      $show_project=[
        'message' => 'Something probelm in internal system',
        'success' => '0',
        'status' => 'false'
      ];
      }
      return response()->json($show_project);
}
public function getProjectById($id){
  if($id){
    $projectsByID = Project::with('ProjectMaterialList')->with('Tasks')->with('workfroceDetail')->with('additionalChanres')->find($id);
      // $getquotation = $this->quotations->getquotations($id);
      if($projectsByID){
        $show_project=[
            'data' => $projectsByID,
            'message' => 'Project Detail',
            'success' => '1',
            'status' => 'true'
          ];
  }else{
    $show_project=[
      'message' => 'Something probelm in internal system',
      'success' => '0',
      'status' => 'false'
    ];
  }
  return response()->json($show_project);
  }
}
public function projectDelete($id){
  // $uid=$request->id;
  $delproject=Project::where('id',$id)->delete();
  $delprojectmaterial=projectMaterials::where('project_id',$id)->delete();
  $delprojecttask=projectTasks::where('project_id',$id)->delete();
  $delprojecttaskAssignee=projectTasksAssignee::where('project_id',$id)->delete();
  $delprojectCharge=projectAdditionalCharges::where('project_id',$id)->delete();
  if($delprojectCharge){
    $del_project=[
      'message' => 'Project Delete Successfully',
      'success' => '1',
      'status' => 'true'
    ];
  }else{
    $del_project=[
      'message' => 'Something probelm in internal system',
      'success' => '0',
      'status' => 'false'
    ];
  }
  return response()->json($del_project);
}

public function projectUpdate(Request $request){
  $projectsject  = Project::find($request->id);
  if($projectsject){
  // $proData = json_decode(json_encode($request->data),true);
  $proData = json_decode($request->data,true);
  // dd($QuotData);
  // Quotations::where('id',$request->id)->delete();
            DB::table('project')
                ->where('id',$request->id)
                ->update(['project_reference_no' => $proData['ReferenceNo'],
                  'name'=>$proData['projectName'],
                  'project_shipment_detail'=>$proData['ShipmentDetail'],
                  'project_created_date' => $proData['Createdate'],
                  'project_client_id' => $proData['ClientId'],
                  'project_site_id' => $proData['SiteId'],
                  'project_country_id'=>$proData['CountryId'],
                  'quotation_id'=>$request->QuotationId,
                  'project_user_id'=>$request->userId,
                  'ProjectRequesterPersonEmail' => $proData['RequesterPersonEmail'],
                  'ProjectDesignerPersonEmail' => $proData['DesignerPersonEmail'],
                  'ProjectDesignerPerson' => $proData['DesignerPerson'],
                  'ProjectRequesterPerson' => $proData['RequesterPerson'],
                  'ProjectDesignerPersonPhone' => $proData['DesignerPersonPhone'],
                  'ProjectRequesterPersonPhone' => $proData['RequesterPersonPhone'],
                  'project_status_id' => $proData['QuoteStatusId'],
                  'project_note' => $proData['QuotationNote'],
                  'ProjectShipmentPrice' => $proData['ShipmentPrice'],
                  'project_shipment_currency_id' => $proData['ShipmentCurrencyId'],
                  'project_validity_date' => $proData['ValidityDate'],
                  'project_estimated_completed_date' => $proData['EstimatesComplationDate'],
                  'project_attachment' => $proData['FileAttach']
                  ]);
  projectMaterials::where('project_id',$request->id)->delete();
  foreach ($proData['QoutationMaterialList'] as $individual_proMaterialList)
    {
      DB::table('project_materials')->insert([
            'project_id' => $request->id,
            'material_id' => $individual_proMaterialList['MaterialId'],
            'material_name' => $individual_proMaterialList['MaterialName'],
            'qty' => $individual_proMaterialList['Qty'],
            'price' => $individual_proMaterialList['price'],
            'vender_id' => $individual_proMaterialList['VenderId'],
            'vender_name' => $individual_proMaterialList['VenderName'],
            'currency_id' => $individual_proMaterialList['CurrencyId'],
            'currency_name' => $individual_proMaterialList['CurrencyName'],
            'Unit' => $individual_proMaterialList['Unit'],
            'distributor_no' => $individual_proMaterialList['Qty'],
            'Description' => $individual_proMaterialList['Description'],
            'manufacture_id' => $individual_proMaterialList['ManufactureId'],
            'manufacture_name' => $individual_proMaterialList['ManufactureName'],
            'manufacture_no' => $individual_proMaterialList['DistributorNo'],
            'sub_total'=> $individual_proMaterialList['SubTotal']
          ]);
    }

      projectTasks::where('project_id',$request->id)->delete();
      foreach ($proData['Tasks'] as $individual_task)
        {
          $last_id = DB::table('project_tasks')
              ->insertGetId([
                'task_id' => $individual_task['taskId'],
                'project_id' => $request->id,
                'per_houre_rate' => $individual_task['perHoureRate'],
                'task_code' => $individual_task['taskCode'],
                'description'=> $individual_task['Description'],
                'qty'=> $individual_task['qty'],
                'sub_total'=> $individual_task['subTotal']
              ]);
        }
        projectAdditionalCharges::where('project_id',$request->id)->delete();
        foreach ($proData['additionalChanres'] as $individual_additionalChanres)
          {
            DB::table('project_additional_charges')
                ->insert([
                  'price' => $individual_additionalChanres['price'],
                  'project_id' => $request->id,
                  'description' => $individual_additionalChanres['desctiption']
                ]);
          }
              projectTasksAssignee::where('project_id',$request->id)->delete();
              foreach ($proData['workfroceDetail'] as $individual_taskDetailDto)
                {
                  DB::table('project_tasks_assignee')
                      ->insert([
                        'project_id' => $request->id,
                        'workforce_id' => $individual_taskDetailDto['workforceId'],
                        'alot_time' => $individual_taskDetailDto['houre'],
                        'price' => $individual_taskDetailDto['Price'],
                        'time_type' => $individual_taskDetailDto['timeType'],
                        'workforce_name' => $individual_taskDetailDto['workforceName']
                      ]);
                }


                $edit_quot=[
                  'message' => 'Project Has Been Successfully Updated',
                  'success' => '1',
                  'status' => 'true'
                ];
              }else{
              $edit_quot=[
                'message' => 'Something probelm in internal system',
                'success' => '0',
                'status' => 'false'
              ];
            }
// }
            return response()->json($edit_quot);
          }

}
