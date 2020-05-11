<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Leave;
use App\Holidayconfig;
use App\Leavecategory;
use App\Roles;
use App\User;
use App\Activity;
use App\Activitydescription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    private $dateCalCAllow = 0;
    private $dateCalCWeekend = 0;
    private $dateCalCHoliday = 0;
    private $dateCalCWeekendHoliday = 0;
    private $StartDate;
    private $EndDate;
    private $limit = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(\Gate::allows('isAdmin') || \Gate::allows('isApprover')){
            $user = auth('api')->user();

            $QueryLeave = Leave::latest()
                                ->select('leave.*','users.name','roles.role_name_th','leave_category.name_th')
                                ->leftJoin('users','leave.user_id', '=', 'users.id')
                                ->leftJoin('roles', 'leave.approve_by_role_id', '=', 'roles.id')
                                ->leftJoin('leave_category', 'leave.leave_category_id', '=', 'leave_category.id')
                                ->when($user ,function($q,$user){
                                    if(\Gate::allows('isUser')){
                                        return $q->where('leave.user_id', '=', $user->id);
                                    }elseif(\Gate::allows('isApprover')){
                                        $q->where('leave.user_id', '=', $user->id);
                                        $q->orWhere('leave.approve_by_role_id', '=', $user->role_id);
                                        return $q;
                                    }
                                })
                                ->paginate($this->limit);

            $QueryRoles = Roles::when($user, function($q,$user){
                                        if(\Gate::allows('isUser')){
                                            return $q->where([['id','!=',$user->role_id]]);
                                        }else{
                                            return $q->where([['id','=','1']]);
                                        }
                                    })
                                ->get();
            return [
                'leave' => $QueryLeave,
                'holidayconfig' => Holidayconfig::all(),
                'leavecategory' => Leavecategory::all(),
                'role' => $QueryRoles
            ];
        // }
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

    public function ConfirmLeave(Request $request)
    {
        $user = auth('api')->user();

        $Leave = Leave::where('id',$request->id)
                    ->update(
                            [
                                'is_accept_by_user_id' => $user->id,
                                'is_accept' => $request->is_accept,
                                'status_confirm_date' => date('Y-m-d H:i:s')
                            ]
                        ); 
        if($Leave){
            $code = '';
            if($request->is_accept == '1'){
                $code = 2001;
                $message = 'การขอลาของคุณได้รับการอนุมัติแล้ว';
            }else{
                $code = 2002;
                $message = 'การขอลาของคุณถูกปฏิเสธ';
            }

            $res = Leave::where('id','=',$request->id)->first();

            $activity = Activity::create([
                'activity_code' => $code,
                'user_id' => $res->user_id,
            ]);
            
            if(!empty($activity)){
                $activity_description = Activitydescription::create([
                    'activity_id' => $activity->id,
                    'activity_description' => $message,
                ]);
            }

        }
        return [$Leave];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'user_id' => 'required',
            'approve_by_role_id' => 'required|not_in:0',
            'reason_leave' => 'required',
            'leave_category_id' => 'required|not_in:0',
            'leave_start' => 'required',
            'leave_end' => 'required',
        ]);

        $CheckLeaveAlllow = false;
        $dateInfo = self::CalculateDate(date('Y-m-d',strtotime($request['leave_start'])),date('Y-m-d',strtotime($request['leave_end'])));

        $user = auth('api')->user();

        $CountMaximumLeave = Leave::where(
            [
              ['user_id','=',$user->id],
              ['leave_category_id','=',$request['leave_category_id']],
              ['is_accept','=','1'],
              ['status_confirm_date','<>','0000-00-00 00:00:00'],
              ['created_at','<=',date('Y').'-12-31 23:59:59'],
              ['created_at','>=',date('Y').'-01-01 00:00:00'],
            ]
          )
        ->sum('date_of_leave');
        $CountMaximumLeave = ($CountMaximumLeave + $dateInfo['dateCalCAllow']);

        // check count of leave
        $GetStartWork = User::findOrfail($user->id);
        
        $date = Carbon::parse(date('Y-m-d H:i:s',strtotime($GetStartWork->start_work)));
        $now = Carbon::now();
        $diff = $date->diffInDays($now);

        $GetCountLeaveUnit = Leavecategory::where('id','=',$request['leave_category_id'])->first();
        (Int) $GetCountLeaveUnit->leave_unit;
        if(date('Ymd',strtotime($GetStartWork->start_work)) >= date('Y').'0701'){
            // half year
            $GetCountLeaveUnit->leave_unit = ($GetCountLeaveUnit->leave_unit/2);
            if($CountMaximumLeave > $GetCountLeaveUnit->leave_unit){
                $CheckLeaveAlllow = true;
            }
        }else{
            // full year
            if($CountMaximumLeave < $GetCountLeaveUnit->leave_unit){
                $CheckLeaveAlllow = true;
            }
        }

        // --------------------

        if($CheckLeaveAlllow){
            $result = Leave::create([
                'user_id' => $user->id,
                'approve_by_role_id' => $request['approve_by_role_id'],
                'reason_leave' => $request['reason_leave'],
                'date_of_leave' => $dateInfo['dateCalCAllow'],
                'holiday_of_leave'  => $dateInfo['dateCalCHoliday'],
                'leave_category_id' => $request['leave_category_id'],
                'leave_start' => date('Y-m-d',strtotime($request['leave_start'])),
                'leave_end' => date('Y-m-d',strtotime($request['leave_end'])),
                'is_accept_by_user_id' => $request['is_accept_by_user_id'],
                'status_confirm_date' => date('Y-m-d'),
            ]);

            // mail notification confirmed
        }else{
            $result = false;

            // mail notification decline
        }

        return $result;
    }

    private function CalculateDate($startDate,$endDate)
    {
        
        $this->StartDate = Carbon::parse($startDate);
        $this->EndDate = Carbon::parse($endDate);

        $ArrayStoreHoliday = array();
        foreach(Holidayconfig::all() as $key => $value){
            array_push($ArrayStoreHoliday,Carbon::create($value->holiday_date));
        }

        $daysForExtraCoding  = $this->StartDate->diffInDaysFiltered(function(Carbon $date) use ($ArrayStoreHoliday) {
            if(!in_array($date, $ArrayStoreHoliday)){
                if(!$date->isWeekend()){
                    $this->dateCalCAllow += 1; // วันปกติที่สามารถลาได้
                }else{
                    $this->dateCalCWeekend += 1; // วันเสาร์-อาทิตย์
                }
            }else{
                if(!$date->isWeekend()){
                    $this->dateCalCHoliday += 1; // วันหยุดที่ไม่ใช่วันเสาร์-อาทิตย์
                }else{
                    $this->dateCalCWeekendHoliday += 1 ; // วันหยุดที่ตรงกับเสาร์-อาทิตย์
                }
            }
        }, $this->EndDate);


        return ['dateCalCAllow' => $this->dateCalCAllow+1,'dateCalCWeekend' => $this->dateCalCWeekend,'dateCalCHoliday' => $this->dateCalCHoliday,'dateCalCWeekendHoliday' => $this->dateCalCWeekendHoliday];
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
        $leave = Leave::findOrFail($id);

        $this->validate($request,[
            'user_id' => 'required',
            'approve_by_role_id' => 'required',
            'reason_leave' => 'required',
            'date_of_leave' => 'required',
            'holiday_of_leave'  => 'required',
            'leave_category_id' => 'required',
            'leave_start' => 'required',
            'leave_end' => 'required',
            'is_accept' => 'required',
            'is_accept_by_user_id' => 'required',
            'status_confirm_date' => 'required',
        ]);

        $leave->update($request->all());

        return ['message' => 'Update Success'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $leave = Leave::findOrFail($id);
        $leave->delete();
        return ['message' => 'Delete Leave Success'];
    }
}
