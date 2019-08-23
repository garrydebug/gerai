<?php

namespace App\Http\Controllers;
use App\User;
use App\Months;
use App\info;
use App\Helper\mHelper;
use DB;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function userget($id)
	{
		$users = user::select("name","id","permisson","teamleader_id")->get();
		$info=info::where('month_id','=',$id)->get();
		$months = months::select("month_days","month_name")->get();
        return view('users',['users'=>$users,'months'=>$months,'info'=>$info]);
	}


	public function getInfo(Request $request)
	{
		$infos = info::where("user_id",$request->user_id)->where("month_id",$request->month_id)
            ->select("info_id","day","year","comment","tag","hours")->get();
        $overall1 = info::select(DB::raw("SUM(day) as overall"))->where('month_id',$request->month_id)->where('user_id',$request->user_id)->where('tag','R')->get();
        return response()->json($infos);
	}

	public function updateInfo(Request $request)
	{
        foreach ( $request->edits  as $edit){
            $id=$edit[0];
            $status=$edit[1];
            $comment=$edit[2];
            $hours=$edit[3];


            info::where('info_id','=',$id)->update(['tag' => $status,'comment' => $comment,'hours' => $hours]);
        }

	}



    }
