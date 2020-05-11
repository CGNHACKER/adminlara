<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Leave;
use App\Leavecategory;
use App\Activity;
use App\Activitysdescription;

class DashboardController extends Controller
{
    private $limit = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = auth('api')->user();
        $CountLeaveByUser = Leave::where(
            [
              ['user_id','=',$user->id],
              ['is_accept','=','1'],
              ['status_confirm_date','<>','0000-00-00 00:00:00'],
              ['created_at','<=',date('Y').'-12-31 23:59:59'],
              ['created_at','>=',date('Y').'-01-01 00:00:00'],
            ]
          )
        ->selectRaw('sum(case when leave_category_id = 1 then date_of_leave END) as "sick_leave" ')
        ->selectRaw('sum(case when leave_category_id = 3 then date_of_leave END) as "leave" ')
        ->selectRaw('sum(case when leave_category_id = 2 then date_of_leave END) as "holiday_leave" ')
        ->first();

        $CountMaxLeave = Leavecategory::all();

        $CountWaitForConfirm = Leave::where([
            ['user_id','=',$user->id],
            ['is_accept','=','0']
        ])->count();

        if(date('Ymd',strtotime($user->start_work)) >= date('Y').'0701'){
            foreach($CountMaxLeave as $key => $value){
                $value->leave_unit = ($value->leave_unit/2);
            }
        }
        
        return ['CountLeaveByUser' => $CountLeaveByUser,'CountMaxLeave' => $CountMaxLeave,'CountWaitForConfirm' => $CountWaitForConfirm];
    }

    public function lastactivity()
    {
        $user = auth('api')->user();

        $LastActivity = Activity::select('activity.*','activity_description.activity_description')
                                ->leftjoin('activity_description','activity.id', '=', 'activity_description.activity_id')
                                ->where('activity.user_id','=',$user->id)
                                ->orderBy('created_at','DESC')
                                ->paginate($this->limit);
        return ['lastactivity' => $LastActivity];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
