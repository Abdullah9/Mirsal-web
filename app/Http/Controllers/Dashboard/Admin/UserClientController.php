<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = User::whereIn("role", ["CLIENT"])->orderBy('id', 'desc')->get();
        $data['clients'] = $clients;

        return view('pages.admin.clients.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new User;
        $client->role = "CLIENT";

        $rules = array();
        if ($client->email != $request->email) {
            $client->email = $request->email;
            $rules['email'] = 'unique:users|max:255|email';
        }

        if ($client->phone != $request->phone) {
            $client->phone = $request->phone;
            $rules['phone'] = 'unique:users|max:10';
        }

        $rules['avatar'] = 'nullable|mimes:jpeg,png,jpg,gif,svg';

        if (!empty($request->password)) {
            $client->password = bcrypt($request->password);
        }

        $client->name = $request->name;

        $validatedData = Validator::make($request->all(), $rules, [], [])->validate();

        $client->save();

        if (isset($request->avatar)) {
            $avatarName = $client->id . '_userAvatar' . time() . '.' . request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('user_avatars', $avatarName);
            $client->avatar = $avatarName;
            $client->save();
        }

        return redirect()->route('admins.clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = User::find($id);
        $data['client'] = $client;
        return view('pages.admin.clients.show')->with(compact('data'));
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
    public function update(UserRequest $request, $id)
    {
        $client = User::find($id);

        if ($request->filled("email")) {
            $client->email = $request->email;
            $rules['email'] = 'email';
        }

        if ($request->filled("phone")) {
            $client->phone = $request->phone;
            $rules['phone'] = 'max:10';
        }

        if (!empty($request->password)) {
            $client->password = bcrypt($request->password);
        }

        $client->name = $request->name;

        if (isset($request->avatar)) {
            $avatarName = $client->id . '_userAvatar' . time() . '.' . request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('user_avatars', $avatarName);
            $client->avatar = $avatarName;
        }

        $client->save();

        return redirect()->route('admins.clients.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = User::find($id);
        $client->delete();

        return redirect()->route('admins.clients.index');
    }
}