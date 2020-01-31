<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Holidayconfig;

class HolidayConfigController extends Controller
{
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
        if(\Gate::allows('isAdmin') || \Gate::allows('isApprover')){
            return Holidayconfig::latest()->paginate(10);
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
        $this->validate($request,[
            'name_th' => 'required',
            'name_en' => 'required',
            'holiday_date' => 'required',
            'is_active' => 'required',
        ]);

        return Holidayconfig::create([
            'name_th' => $request['name_th'],
            'name_en' => $request['name_en'],
            'holiday_date' => $request['holiday_date'],
            'is_active' => $request['is_active'],
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
        $holiday = Holidayconfig::findOrFail($id);

        $this->validate($request,[
            'name_th' => 'required',
            'name_en' => 'required',
            'holiday_date' => 'required',
            'is_active' => 'required',
        ]);


        $holiday->update($request->all());

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

        $holiday = Holidayconfig::findOrFail($id);
        $holiday->delete();
        return ['message' => 'Delete Holiday Success'];
    }
}
