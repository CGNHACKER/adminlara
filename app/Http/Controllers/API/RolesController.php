<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Roles;

class RolesController extends Controller
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
            return Roles::latest()->paginate(10);
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
            'role_name_th' => 'required',
            'role_name_en' => 'required',
            'role_slug' => 'required|unique:roles',
            'is_active' => 'required',
        ]);

        return Roles::create([
            'role_name_th' => $request['role_name_th'],
            'role_name_en' => $request['role_name_en'],
            'role_slug' => $request['role_slug'],
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
        $role = Roles::findOrFail($id);

        $this->validate($request,[
            'role_name_th' => 'required',
            'role_name_en' => 'required',
            'role_slug' => 'sometimes|required|unique:roles,role_slug,'.$role->id,
            'is_active' => 'required',
        ]);


        $role->update($request->all());

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

        $role = Roles::findOrFail($id);
        $role->delete();
        return ['message' => 'Delete Role Success'];
    }
}
