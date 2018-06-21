<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveUserRequest;
use App\User;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('is_admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('resource')->orderBy('id', 'desc')->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('admin.user.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveUserRequest $request)
    {
        $request->merge(['password' => bcrypt($request->password)]);
        try {
            $new_user = User::create($request->all());
            return redirect()->action('Admin\UserController@edit', $new_user->id)->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.create')]);
        } catch (\Exception $ex) {
            return back()->withFlashData(['status' => 'error', 'message' => $ex->getMessage()])->withInput();
        }
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
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->has('password')) $request->merge(['password' => bcrypt($request->password)]);
        try {
            $user->update($request->all());
            return back()->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.update')]);
        } catch (\Exception $ex) {
            return back()->withFlashData(['status' => 'error', 'message' => $ex->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($id);
        if (!$currentUser->isAdmin || $currentUser->id == $user->id){
            return redirect()->action('Admin\UserController@index')->withFlashData(['status' => 'error', 'message' => 'Permission Denied']);
        }
        $user->delete();
        return redirect()->action('Admin\UserController@index')->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.delete')]);
    }
}
