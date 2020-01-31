<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        // $this->authorize('isAdmin');
    }

    public function index()
    {
        if(\Gate::allows('isAdmin') || \Gate::allows('isApprover')){
            return User::latest()->paginate(10);
        }
    }

    public function FindUser()
    {
        if($Search = \Request::get('q')){
            $users =  User::where(function($query) use ($Search){
                $query->where('name','LIKE',"%$Search%")
                ->orWhere('email','LIKE',"%$Search%")
                ->orWhere('position','LIKE',"%$Search%");
            })->paginate(10);
        }else{
            return User::latest()->paginate(10);
        }

        return $users;
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
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required',
            'nickname' => 'required',
            'department_id' => 'required',
            'role_id' => 'required',
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'nickname' => $request['nickname'],
            'department_id' => $request['department_id'],
            'role_id' => $request['role_id'],
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return auth('api')->user();
    }

    public function UpdateProfile(Request $request)
    {
        $user = auth('api')->user();

        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|string|email|unique:users,email,'.$user->id,
            'password' => 'sometimes',
            'nickname' => 'required',
            'department_id' => 'required',
            'role_id' => 'required',
        ]);

        $CurrentPhoto = $user->photo;

        if($request->photo != $CurrentPhoto){
            $ImageName = time().'.'.explode('/',explode(':',substr($request->photo,0,strpos($request->photo,';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$ImageName);

            $request->merge(['photo' => $ImageName]);

            $UserPhotoOld = public_path('img/profile/').$CurrentPhoto;

            if(file_exists($UserPhotoOld)){
                @unlink($UserPhotoOld);
            }
        }

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());

        return ['message' => 'Update Profile Success'];
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
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|string|email|unique:users,email,'.$user->id,
            'password' => 'sometimes',
            'nickname' => 'required',
            'department_id' => 'required',
            'role_id' => 'required',
        ]);


        $user->update($request->all());

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

        $user = User::findOrFail($id);
        $user->delete();
        return ['message' => 'Delete User Success'];
    }
}
