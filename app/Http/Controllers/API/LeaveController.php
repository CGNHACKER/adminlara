<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Leave;
// use Carbon\Carbon;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Gate::allows('isAdmin') || \Gate::allows('isApprover')){
            return Leave::latest()->paginate(10);
        }
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
        dd($request->all());

        $this->validate($request,[
            'user_id' => 'required',
            'approve_by_role_id' => 'required',
            'reason_leave' => 'required',
            'leave_category_id' => 'required',
            'leave_start' => 'required',
            'leave_end' => 'required',
        ]);

        $user = auth('api')->user();

        // check count of leave

        // --------------------

        return Leave::create([
            'user_id' => $user->id,
            'approve_by_role_id' => $request['approve_by_role_id'],
            'reason_leave' => $request['reason_leave'],
            'date_of_leave' => $request['date_of_leave'],
            'holiday_of_leave'  => $request['holiday_of_leave'],
            'leave_category_id' => $request['leave_category_id'],
            'leave_start' => $request['leave_start'],
            'leave_end' => $request['leave_end'],
            'is_accept' => $request['is_accept'],
            'is_accept_by_user_id' => $request['is_accept_by_user_id'],
            'status_confirm_date' => $request['status_confirm_date'],
        ]);
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
