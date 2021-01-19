<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Quotations;
use App\Models\quotation_tasks;
use App\Models\quotation_tasks_assignee;
use App\Models\Quotations_Materials;
use App\Models\Quotation_Charges;
use App\Models\Project;
use App\Models\projectTasks;
use App\Models\projectTasksAssignee;
use App\Models\projectMaterials;
use App\Models\projectAdditionalCharges;
use App\Models\Site;
use Validator;
use Illuminate\Http\Request;
use DB;
class QuotationController extends Controller
{

  public function __construct(Quotations $quotations)
  {
    $this->quotations = $quotations;
  }

  public function FetchQuotation(Request $request){
    if($request->searchText){
        $quotations = $this->quotations->fetchQuotationForSearch($request->searchColum,$request->searchText);
        return response()->json($quotations);
    }
    if($request->page && !$request->data_sort_order){
        $quotations = $this->quotations->fetchQuotationByPage();
        return response()->json($quotations);
    }
    else if($request->data_sort_order){
        $quotations = $this->quotations->fetchQuotationBySorting($request->sorted_colum,$request->data_sort_order);
        return response()->json($quotations);
    }
    $quotations = $this->quotations->fetchQuotation();
    return response()->json($quotations);
  }

public function ActiveFetchQuotation(){
  $select= $this->quotations->ActivefetchQuotation();
  return response()->json($select);
}

  public function quotationStore(Request $request){
    $QuotData = json_decode(json_encode($request->data),true);
    // $QuotData = json_decode($request->data,true);
    // dd($QuotData['ShipmentCurrencyId']);

      $quotation=new Quotations();
      $quotation->reference_no = $QuotData['ReferenceNo'];
      $quotation->created_date = $QuotData['Createdate'];
      $quotation->client_id = $QuotData['ClientId'];
      $quotation->site_id = $QuotData['SiteId'];
      $quotation->DesignerPersonPhone = $QuotData['DesignerPersonPhone'];
      $quotation->RequesterPersonEmail = $QuotData['RequesterPersonEmail'];
      $quotation->DesignerPersonEmail = $QuotData['DesignerPersonEmail'];
      $quotation->DesignerPerson = $QuotData['DesignerPerson'];
      $quotation->RequesterPerson= $QuotData['RequesterPerson'];

      $quotation->quotation_status_id = 2;
      $quotation->IsGenerated = 1;
      $quotation->IsDraft = 0;

      $quotation->quotation_note = $QuotData['QuotationNote'];
      $quotation->ShipmentPrice = $QuotData['ShipmentPrice'];
      $quotation->shipment_currency_id = $QuotData['ShipmentCurrencyId'];
      $quotation->quotation_validity_date = $QuotData['ValidityDate'];
      $quotation->estimated_completed_date = $QuotData['EstimatesComplationDate'];
      $quotation->shipment_detail = $QuotData['ShipmentDetail'];
      $quotation->RequesterPersonPhone = $QuotData['RequesterPersonPhone'];
      $quotation->attachment = $QuotData['FileAttach'];
      $quotation->save();
      $getlast=$quotation->id;
      foreach ($QuotData['QoutationMaterialList'] as $individual_QoutationMaterialList)
        {
          DB::table('quotations_materials')->insert([
                'quotation_id' => $getlast,
                'material_id' => $individual_QoutationMaterialList['MaterialId'],
                'material_name' => $individual_QoutationMaterialList['MaterialName'],
                'qty' => $individual_QoutationMaterialList['Qty'],
                'price' => $individual_QoutationMaterialList['price'],
                'vender_id' => $individual_QoutationMaterialList['VenderId'],
                'vender_name' => $individual_QoutationMaterialList['VenderName'],
                'currency_id' => $individual_QoutationMaterialList['CurrencyId'],
                'currency_name' => $individual_QoutationMaterialList['CurrencyName'],
                'Unit' => $individual_QoutationMaterialList['Unit'],
                'distributor_no' => $individual_QoutationMaterialList['Qty'],
                'Description' => $individual_QoutationMaterialList['Description'],
                'manufacture_id' => $individual_QoutationMaterialList['ManufactureId'],
                'manufacture_name' => $individual_QoutationMaterialList['ManufactureName'],
                'manufacture_no' => $individual_QoutationMaterialList['DistributorNo'],
                'sub_total'=> $individual_QoutationMaterialList['SubTotal']
              ]);
        }

      foreach ($QuotData['Tasks'] as $individual_task)
        {
          $last_id = DB::table('quotation_tasks')
              ->insertGetId([
                'task_id' => $individual_task['taskId'],
                'quotation_id' => $getlast,
                'per_houre_rate' => $individual_task['perHoureRate'],
                'task_code' => $individual_task['taskCode'],
                'description'=> $individual_task['Description'],
                'qty'=> $individual_task['qty'],
                'sub_total'=> $individual_task['subTotal']
              ]);
        }
        foreach ($QuotData['additionalChanres'] as $individual_additionalChanres)
          {
            DB::table('quotations_additional_charges')
                ->insert([
                  'price' => $individual_additionalChanres['price'],
                  'description' => $individual_additionalChanres['desctiption'],
                  'quotation_id' => $getlast
                ]);
          }
        foreach ($QuotData['workfroceDetail'] as $individual_taskDetailDto)
          {
            DB::table('quotation_tasks_assignee')
                ->insert([
                  'quotation_id' => $getlast,
                  'workforce_id' => $individual_taskDetailDto['workforceId'],
                  'alot_time' => $individual_taskDetailDto['houre'],
                  'price' => $individual_taskDetailDto['Price'],
                  'time_type' => $individual_taskDetailDto['timeType'],
                  'workforce_name' => $individual_taskDetailDto['workforceName']
                ]);
          }
if($quotation->save()){
  $quotation = Quotations::with('QoutationMaterialList')->with('Tasks')->with('workfroceDetail')->with('additionalChanres')->find($getlast);
  // $quotation=Quotations::find($getlast);
  $add_quotation = [
      'data' => $quotation,
      'status' => true,
      'success' => 1,
      'message' => 'Quotation added successfully'
  ];
}else{
  $add_quotation = [
      'status' => false,
      'success' => 0,
      'message' => 'Something probelm in internal system'
  ];
}
        return response()->json($add_quotation);
  }


  public function quotationDraft(Request $request){
      $QuotData = json_decode(json_encode($request->data),true);
      $quotationDraft=new Quotations();
      if(isset($QuotData['ReferenceNo'])){
       $quotationDraft->reference_no = $QuotData['ReferenceNo'];
      }
      if(isset($QuotData['Createdate'])){
       $quotationDraft->created_date = $QuotData['Createdate'];
      }
      if(isset($QuotData['ClientId'])){
        $quotationDraft->client_id = $QuotData['ClientId'];
      }
      if(isset($QuotData['SiteId'])){
        $quotationDraft->site_id = $QuotData['SiteId'];
      }
      if(isset($QuotData['DesignerPersonPhone'])){
        $quotationDraft->DesignerPersonPhone = $QuotData['DesignerPersonPhone'];
      }
      if(isset($QuotData['RequesterPersonEmail'])){
        $quotationDraft->RequesterPersonEmail = $QuotData['RequesterPersonEmail'];
      }
      if(isset($QuotData['DesignerPersonEmail'])){
        $quotationDraft->DesignerPersonEmail = $QuotData['DesignerPersonEmail'];
      }
      if(isset($QuotData['DesignerPerson'])){
        $quotationDraft->DesignerPerson = $QuotData['DesignerPerson'];
      }
      if(isset($QuotData['RequesterPerson'])){
        $quotationDraft->RequesterPerson= $QuotData['RequesterPerson'];
      }

      $quotationDraft->quotation_status_id = 1;
      $quotationDraft->IsDraft = 1;

      if(isset($QuotData['QuotationNote'])){
        $quotationDraft->quotation_note = $QuotData['QuotationNote'];
      }
      if(isset($QuotData['ShipmentPrice'])){
        $quotationDraft->ShipmentPrice = $QuotData['ShipmentPrice'];
      }
      if(isset($QuotData['ShipmentCurrencyId'])){
        $quotationDraft->shipment_currency_id = $QuotData['ShipmentCurrencyId'];
      }
      if(isset($QuotData['ValidityDate'])){
        $quotationDraft->quotation_validity_date = $QuotData['ValidityDate'];
      }
      if(isset($QuotData['EstimatesComplationDate'])){
        $quotationDraft->estimated_completed_date = $QuotData['EstimatesComplationDate'];
      }
      if(isset($QuotData['ShipmentDetail'])){
        $quotationDraft->shipment_detail = $QuotData['ShipmentDetail'];
      }
      if(isset($QuotData['RequesterPersonPhone'])){
        $quotationDraft->RequesterPersonPhone = $QuotData['RequesterPersonPhone'];
      }
      if(isset($QuotData['FileAttach'])){
        $quotationDraft->attachment = $QuotData['FileAttach'];
      }
      $quotationDraft->save();
      $getlast=$quotationDraft->id;
      // dd($getlast);
      if(isset($QuotData['QoutationMaterialList'])){
      foreach ($QuotData['QoutationMaterialList'] as $individual_QoutationMaterialList)
        {
          if(isset($individual_QoutationMaterialList['MaterialId'])){
            $material_id = $individual_QoutationMaterialList['MaterialId'];
          }
          if(isset($individual_QoutationMaterialList['MaterialName'])){
            $material_name = $individual_QoutationMaterialList['MaterialName'];
          }
          else{
            $material_name = '';
          }
          if(isset($individual_QoutationMaterialList['Qty'])){
            $qty = $individual_QoutationMaterialList['Qty'];
          }
          else{
            $qty = '';
          }
          if(isset($individual_QoutationMaterialList['price'])){
            $price = $individual_QoutationMaterialList['price'];
          }
          else{
            $price = '';
          }
          if(isset($individual_QoutationMaterialList['VenderId'])){
            $vender_id = $individual_QoutationMaterialList['VenderId'];
          }
          else{
            $vender_id = '';
          }
          if(isset($individual_QoutationMaterialList['VenderName'])){
            $vender_name = $individual_QoutationMaterialList['VenderName'];
          }
          else{
            $vender_name = '';
          }
          if(isset($individual_QoutationMaterialList['CurrencyId'])){
            $currency_id = $individual_QoutationMaterialList['CurrencyId'];
          }
          else{
            $currency_id = '';
          }
          if(isset($individual_QoutationMaterialList['CurrencyName'])){
            $currency_name = $individual_QoutationMaterialList['CurrencyName'];
          }
          else{
            $currency_name = '';
          }
          if(isset($individual_QoutationMaterialList['Unit'])){
            $Unit = $individual_QoutationMaterialList['Unit'];
          }
          else{
            $Unit = '';
          }
          if(isset($individual_QoutationMaterialList['DistributorNo'])){
            $distributor_no = $individual_QoutationMaterialList['DistributorNo'];
          }
          else{
            $distributor_no = '';
          }
          if(isset($individual_QoutationMaterialList['Description'])){
            $Description = $individual_QoutationMaterialList['Description'];
          }
          else{
            $Description = '';
          }
          if(isset($individual_QoutationMaterialList['ManufactureId'])){
            $manufacture_id = $individual_QoutationMaterialList['ManufactureId'];
          }
          else{
            $manufacture_id = '';
          }
          if(isset($individual_QoutationMaterialList['ManufactureName'])){
            $manufacture_name = $individual_QoutationMaterialList['ManufactureName'];
          }
          else{
            $manufacture_name = '';
          }
          if(isset($individual_QoutationMaterialList['ManufactureNo'])){
            $manufacture_no = $individual_QoutationMaterialList['ManufactureNo'];
          }
          else{
            $manufacture_no = '';
          }
          if(isset($individual_QoutationMaterialList['SubTotal'])){
            $sub_total=$individual_QoutationMaterialList['SubTotal'];
          }
          else{
            $sub_total = '';
          }
          DB::table('quotations_materials')->insert([
              'material_id' => $material_id,
              'material_name' => $material_name,
              'qty' => $qty,
              'price' => $price,
              'vender_id' => $vender_id,
              'vender_name' => $vender_name,
              'currency_id' => $currency_id,
              'currency_name' => $currency_name,
              'Unit' => $Unit,
              'distributor_no' => $distributor_no,
              'Description' => $Description,
              'manufacture_id' => $manufacture_id,
              'manufacture_name' => $manufacture_name,
              'manufacture_no' => $manufacture_no,
              'sub_total'=> $sub_total,
              'quotation_id' => $getlast
              ]);
        }
      }
    if(isset($QuotData['Tasks'])){
      foreach ($QuotData['Tasks'] as $individual_task)
        {
          if(isset($individual_task['taskId'])){
          $task_id = $individual_task['taskId'];
        }
        else{
          $task_id='';
        }

            if(isset($individual_task['perHoureRate'])){
            $per_houre_rate = $individual_task['perHoureRate'];
          }
          else{
            $per_houre_rate='';
          }
          if(isset($individual_task['taskCode'])){
            $task_code = $individual_task['taskCode'];
          }
          else{
            $task_code='';
          }
          if(isset($individual_task['Description'])){
            $description= $individual_task['Description'];
          }
          else{
            $description='';
          }
          if(isset($individual_task['qty'])){
            $qty= $individual_task['qty'];
          }
          else{
            $qty='';
          }
          if(isset($individual_task['subTotal'])){
            $sub_total= $individual_task['subTotal'];
          }
          else{
            $sub_total='';
          }
          $last_id = DB::table('quotation_tasks')
              ->insertGetId([
                'task_id' => $task_id,
                'quotation_id' => $getlast,
                'per_houre_rate' => $per_houre_rate,
                'task_code' => $task_code,
                'description'=> $description,
                'qty'=> $qty,
                'sub_total'=> $sub_total

              ]);
        }
     }
         if(isset($QuotData['additionalChanres']))
           {
              foreach ($QuotData['additionalChanres'] as $individual_additionalChanres)
                {
                  if(isset($individual_additionalChanres['price'])){
                  $price = $individual_additionalChanres['price'];
                }
                else{
                  $price='';
                }
                if(isset($individual_additionalChanres['desctiption'])){
                  $description = $individual_additionalChanres['desctiption'];
                }
                else{
                  $description='';
                }
                  DB::table('quotations_additional_charges')
                      ->insert([
                        'price' => $price,
                        'description' => $description,
                        'quotation_id' => $getlast
                      ]);
                }
            }
        if(isset($QuotData['workfroceDetail'])){
          foreach ($QuotData['workfroceDetail'] as $individual_taskDetailDto)
            {
              if(isset($individual_taskDetailDto['workforceId'])){
              $workforce_id = $individual_taskDetailDto['workforceId'];
            }
            else{
              $workforce_id='';
            }
            if(isset($individual_taskDetailDto['houre'])){
              $alot_time = $individual_taskDetailDto['houre'];
            }
            else{
              $alot_time='';
            }
            if(isset($individual_taskDetailDto['Price'])){
              $price = $individual_taskDetailDto['Price'];
            }
            else{
              $price='';
            }
            if(isset($individual_taskDetailDto['timeType'])){
              $time_type = $individual_taskDetailDto['timeType'];
            }
            else{
              $time_type='';
            }
            if(isset($individual_taskDetailDto['workforceName'])){
              $workforce_name = $individual_taskDetailDto['workforceName'];
            }
            else{
              $workforce_name='';
            }
              DB::table('quotation_tasks_assignee')
                  ->insert([
                    'quotation_id' => $getlast,
                    'workforce_id' => $workforce_id,
                    'alot_time' => $alot_time,
                    'price' => $price,
                    'time_type' => $time_type,
                    'workforce_name' => $workforce_name
                  ]);
            }
        }



        if($quotationDraft->save()){
          $quotationDraft = Quotations::with('QoutationMaterialList')->with('Tasks')->with('workfroceDetail')->with('additionalChanres')->find($getlast);
          // $quotation=Quotations::find($getlast);
          $draft_quotation = [
              'data' => $quotationDraft,
              'status' => true,
              'success' => 1,
              'message' => 'Quotation added In Draft successfully'
          ];
        }
        else{
          $draft_quotation = [
              'status' => false,
              'success' => 0,
              'message' => 'Something probelm in internal system'
          ];
        }
        return response()->json($draft_quotation);
  }




  public function GetQuotation($id){
    if($id){
      $quotationsByID = Quotations::with('QoutationMaterialList')->with('Tasks')->with('workfroceDetail')->with('additionalChanres')->find($id);
        // $getquotation = $this->quotations->getquotations($id);
        if($quotationsByID){
          $show_quotation=[
              'data' => $quotationsByID,
              'message' => 'Quotation Detail',
              'success' => '1',
              'status' => 'true'
            ];
        }
    }else{
      $show_quotation=[
        'message' => 'Something probelm in internal system',
        'success' => '0',
        'status' => 'false'
      ];
    }
    return response()->json($show_quotation);
  }

  public function DeleteQuotation($id){
    // $uid=$request->id;
    $delquot=Quotations::where('id',$id)->delete();
    $delquotmaterial=Quotations_Materials::where('quotation_id',$id)->delete();
    $delquottask=quotation_tasks::where('quotation_id',$id)->delete();
    $delquottaskAssignee=quotation_tasks_assignee::where('quotation_id',$id)->delete();
    $delquotCharge=Quotation_Charges::where('quotation_id',$id)->delete();
    if($delquottaskAssignee){
      $del_quotation=[
        'message' => 'Quotation Has Been Delete Successfully',
        'success' => '1',
        'status' => 'true'
      ];
    }else{
      $del_quotation=[
        'message' => 'Something probelm in internal system',
        'success' => '0',
        'status' => 'false'
      ];
    }
    return response()->json($del_quotation);
  }

  public function UpdateQuotation(Request $request){
    $quot  = Quotations::find($request->id);
    if($quot){
    $QuotData = json_decode(json_encode($request->data),true);
    // $QuotData = json_decode($request->data,true);
    // dd($QuotData);
    // Quotations::where('id',$request->id)->delete();
              DB::table('quotations')
                  ->where('id',$request->id)
                  ->update(['reference_no' => $QuotData['ReferenceNo'],
                    'created_date' => $QuotData['Createdate'],
                    'client_id' => $QuotData['ClientId'],
                    'site_id' => $QuotData['SiteId'],
                    'RequesterPersonEmail' => $QuotData['RequesterPersonEmail'],
                    'DesignerPersonEmail' => $QuotData['DesignerPersonEmail'],
                    'DesignerPerson' => $QuotData['DesignerPerson'],
                    'RequesterPerson' => $QuotData['RequesterPerson'],
                    'DesignerPersonPhone' => $QuotData['DesignerPersonPhone'],
                    'RequesterPersonPhone' => $QuotData['RequesterPersonPhone'],
                    'quotation_status_id' => $QuotData['QuoteStatusId'],
                    'quotation_note' => $QuotData['QuotationNote'],
                    'ShipmentPrice' => $QuotData['ShipmentPrice'],
                    'shipment_currency_id' => $QuotData['ShipmentCurrencyId'],
                    'quotation_validity_date' => $QuotData['ValidityDate'],
                    'estimated_completed_date' => $QuotData['EstimatesComplationDate'],
                    'attachment' => $QuotData['FileAttach']
                    ]);


    // $quotation=new Quotations();
    // $quotation->reference_no = $QuotData['ReferenceNo'];
    // $quotation->created_date = $QuotData['Createdate'];
    // $quotation->client_id = $QuotData['ClientId'];
    // $quotation->site_id = $QuotData['SiteId'];
    // $quotation->DesignerPersonPhone = $QuotData['DesignerPersonPhone'];
    // $quotation->RequesterPersonEmail = $QuotData['RequesterPersonEmail'];
    // $quotation->DesignerPersonEmail = $QuotData['DesignerPersonEmail'];
    // $quotation->DesignerPerson = $QuotData['DesignerPerson'];
    // $quotation->RequesterPerson= $QuotData['RequesterPerson'];
    // $quotation->quotation_status_id = $QuotData['QuoteStatusId'];
    // $quotation->quotation_note = $QuotData['QuotationNote'];
    // $quotation->ShipmentPrice = $QuotData['ShipmentPrice'];
    // $quotation->quotation_validity_date = $QuotData['ValidityDate'];
    // $quotation->estimated_completed_date = $QuotData['EstimatesComplationDate'];
    // $quotation->shipment_detail = $QuotData['ShipmentDetail'];
    // $quotation->RequesterPersonPhone = $QuotData['RequesterPersonPhone'];
    // $quotation->save();
    // $getlast=$quotation->id;
    Quotations_Materials::where('quotation_id',$request->id)->delete();
    foreach ($QuotData['QoutationMaterialList'] as $individual_QoutationMaterialList)
      {
        DB::table('quotations_materials')->insert([
              'quotation_id' => $request->id,
              'material_id' => $individual_QoutationMaterialList['MaterialId'],
              'material_name' => $individual_QoutationMaterialList['MaterialName'],
              'qty' => $individual_QoutationMaterialList['Qty'],
              'price' => $individual_QoutationMaterialList['price'],
              'vender_id' => $individual_QoutationMaterialList['VenderId'],
              'vender_name' => $individual_QoutationMaterialList['VenderName'],
              'currency_id' => $individual_QoutationMaterialList['CurrencyId'],
              'currency_name' => $individual_QoutationMaterialList['CurrencyName'],
              'Unit' => $individual_QoutationMaterialList['Unit'],
              'distributor_no' => $individual_QoutationMaterialList['Qty'],
              'Description' => $individual_QoutationMaterialList['Description'],
              'manufacture_id' => $individual_QoutationMaterialList['ManufactureId'],
              'manufacture_name' => $individual_QoutationMaterialList['ManufactureName'],
              'manufacture_no' => $individual_QoutationMaterialList['DistributorNo'],
              'sub_total'=> $individual_QoutationMaterialList['SubTotal']
            ]);
      }

        quotation_tasks::where('quotation_id',$request->id)->delete();
        foreach ($QuotData['Tasks'] as $individual_task)
          {
            $last_id = DB::table('quotation_tasks')
                ->insertGetId([
                  'task_id' => $individual_task['taskId'],
                  'quotation_id' => $request->id,
                  'per_houre_rate' => $individual_task['perHoureRate'],
                  'task_code' => $individual_task['taskCode'],
                  'description'=> $individual_task['Description'],
                  'qty'=> $individual_task['qty'],
                  'sub_total'=> $individual_task['subTotal']
                ]);
          }
          Quotation_Charges::where('quotation_id',$request->id)->delete();
          foreach ($QuotData['additionalChanres'] as $individual_additionalChanres)
            {
              DB::table('quotations_additional_charges')
                  ->insert([
                    'price' => $individual_additionalChanres['price'],
                    'quotation_id' => $request->id,
                    'description' => $individual_additionalChanres['desctiption']
                  ]);
            }
                quotation_tasks_assignee::where('quotation_id',$request->id)->delete();
                foreach ($QuotData['workfroceDetail'] as $individual_taskDetailDto)
                  {
                    DB::table('quotation_tasks_assignee')
                        ->insert([
                          'quotation_id' => $request->id,
                          'workforce_id' => $individual_taskDetailDto['workforceId'],
                          'alot_time' => $individual_taskDetailDto['houre'],
                          'price' => $individual_taskDetailDto['Price'],
                          'time_type' => $individual_taskDetailDto['timeType'],
                          'workforce_name' => $individual_taskDetailDto['workforceName']
                        ]);
                  }

                  if($QuotData['QuoteStatusId'] == 4){
                    $st=$QuotData['SiteId'];
                    $get=Site::where('id',$st)->select('zone_id')->first();
                    $project=new Project();
                    $project->project_reference_no=$QuotData['ReferenceNo'];
                    $project->project_created_date = $QuotData['Createdate'];
                    $project->project_client_id = $QuotData['ClientId'];
                    $project->project_site_id = $QuotData['SiteId'];
                    $project->quotation_id = $QuotData['SiteId'];
                    $project->project_user_id = $request->userId;
                    $project->quotation_id = $request->id;
                    $project->project_status_id = $QuotData['QuoteStatusId'];
                    $project->project_note= $QuotData['QuotationNote'];
                    $project->zone_id = $get->zone_id;
                    $project->currency_id = 1;
                    $project->save();
                    $getlast=$project->id;
                    foreach ($QuotData['QoutationMaterialList'] as $individual_ProjectMaterialList)
                      {
                        DB::table('project_materials')->insert([
                              'project_id' => $getlast,
                              'material_id' => $individual_ProjectMaterialList['MaterialId'],
                              'material_name' => $individual_ProjectMaterialList['MaterialName'],
                              'qty' => $individual_ProjectMaterialList['Qty'],
                              'price' => $individual_ProjectMaterialList['price'],
                              'vender_id' => $individual_ProjectMaterialList['VenderId'],
                              'vender_name' => $individual_ProjectMaterialList['VenderName'],
                              // 'currency_id' => $individual_ProjectMaterialList['CurrencyId'],
                              // 'currency_name' => $individual_ProjectMaterialList['CurrencyName'],
                              'Unit' => $individual_ProjectMaterialList['Unit'],
                              'distributor_no' => $individual_ProjectMaterialList['Qty'],
                              'Description' => $individual_ProjectMaterialList['Description'],
                              'manufacture_id' => $individual_ProjectMaterialList['ManufactureId'],
                              'manufacture_name' => $individual_ProjectMaterialList['ManufactureName'],
                              'manufacture_no' => $individual_ProjectMaterialList['DistributorNo'],
                              'sub_total'=> $individual_ProjectMaterialList['SubTotal'],
                              'added_user_id'=>$request->userId
                            ]);
                      }
                      foreach ($QuotData['Tasks'] as $individual_task)
                        {
                          $last_id = DB::table('project_tasks')
                              ->insertGetId([
                                'task_id' => $individual_task['taskId'],
                                'project_id' => $getlast,
                                'per_houre_rate' => $individual_task['perHoureRate'],
                                'task_code' => $individual_task['taskCode'],
                                'description'=> $individual_task['Description'],
                                'qty'=> $individual_task['qty'],
                                'sub_total'=> $individual_task['subTotal']
                              ]);
                        }
                        foreach ($QuotData['additionalChanres'] as $individual_additionalChanres)
                          {
                            DB::table('project_additional_charges')
                                ->insert([
                                  'price' => $individual_additionalChanres['price'],
                                  'description' => $individual_additionalChanres['desctiption'],
                                  'project_id' => $getlast
                                ]);
                          }
                        foreach ($QuotData['workfroceDetail'] as $individual_taskDetailDto)
                          {
                            DB::table('project_tasks_assignee')
                                ->insert([
                                  'project_id' => $getlast,
                                  'workforce_category_id' => $individual_taskDetailDto['workforceId'],
                                  'alot_time' => $individual_taskDetailDto['houre'],
                                  'price' => $individual_taskDetailDto['Price'],
                                  'time_type' => $individual_taskDetailDto['timeType'],
                                  'workforce_name' => $individual_taskDetailDto['workforceName'],
                                  'is_joined'=> 1,
                                  'joined_user_id'=>$request->userId
                                ]);
                          }
                  }
                  $edit_quot=[
                    'message' => 'Quotation Has Been Successfully Updated',
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
