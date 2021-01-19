<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Map;
use DB;

class MapController extends Controller
{
    public function __construct(Map $map)
    {
      $this->map = $map;
    }

    public function getCords($id) {
      $cords =  $this->map->getCords($id);
      return response()->json($cords);
    }

    public function updateCords(Request $request) {
      $this->map->updateCords($request->zone_id,json_decode($request->coords));
      return response()->json('success');
    }


}
