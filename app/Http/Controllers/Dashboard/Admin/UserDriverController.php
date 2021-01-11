<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserDriverController extends Controller
{
    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = User::where("role", "DRIVER")->get();
        $data['drivers'] = $drivers;

        return view('pages.admin.drivers.index')->with(compact('data'));
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

    public function store(UserRequest $request)
    {
        $driver = new User;
        $driver->role = "DRIVER";

        $rules = array();
        if ($driver->email != $request->email) {
            $driver->email = $request->email;
            $rules['email'] = 'unique:users|max:255|email';
        }

        if ($driver->phone != $request->phone) {
            $driver->phone = $request->phone;
            $rules['phone'] = 'unique:users|max:10';
        }

        $rules['avatar'] = 'nullable|mimes:jpeg,png,jpg,gif,svg';

        if (!empty($request->password)) {
            $driver->password = bcrypt($request->password);
        }

        $driver->name = $request->name;

        $validatedData = Validator::make($request->all(), $rules, [], [])->validate();

        $driver->save();

        if (isset($request->avatar)) {
            $avatarName = $driver->id . '_userAvatar' . time() . '.' . request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('user_avatars', $avatarName);
            $driver->avatar = $avatarName;
            $driver->save();
        }

        return redirect()->route('admins.drivers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = User::find($id);
        $data['driver'] = $driver;
        return view('pages.admin.drivers.show')->with(compact('data'));
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
        $driver = User::find($id);

        if ($request->filled("email")) {
            $driver->email = $request->email;
        }

        if ($request->filled("phone")) {
            $driver->phone = $request->phone;
        }

        if (!empty($request->password)) {
            $driver->password = bcrypt($request->password);
        }

        $driver->name = $request->name;

        if (isset($request->avatar)) {
            $avatarName = $driver->id . '_userAvatar' . time() . '.' . request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('user_avatars', $avatarName);
            $driver->avatar = $avatarName;
        }

        $driver->save();

        return redirect()->route('admins.drivers.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver = User::find($id);
        $driver->delete();

        return redirect()->route('admins.drivers.index');
    }
}