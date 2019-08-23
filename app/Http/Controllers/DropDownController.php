<?php

namespace App\Http\Controllers;
use App\months;
use DB;


use Illuminate\Http\Request;

class DropDownController extends Controller
{
    public function dd()
        {
            $countries = DB::table("countries")->pluck("name","id");
            return view('dd',compact('countries'));
        }

        public function getStateList(Request $request)
        {
            $states = DB::table("states")
            ->where("country_id",$request->country_id)
            ->pluck("name","id");
            return response()->json($states);
        }

        public function getCityList(Request $request)
        {
            $cities = DB::table("cities")
            ->where("state_id",$request->state_id)
            ->pluck("name","id");
            return response()->json($cities);
        }




}
