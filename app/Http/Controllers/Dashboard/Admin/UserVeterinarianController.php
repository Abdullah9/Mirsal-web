<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Events\VeterinarianAccepted;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserVeterinarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['accepted_veterinarians'] = User::where("role", "VETERINARIAN")->where("vet_status", "ACCEPTED")->orderBy('id', 'desc')->get();
        $data['pending_veterinarians'] = User::where("role", "VETERINARIAN")->where("vet_status", "PENDING")->orderBy('id', 'desc')->get();

        return view('pages.admin.veterinarians.index')->with(compact('data'));
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
        $vet = new User;
        $vet->role = "VETERINARIAN";

        if ($vet->email != $request->email) {
            $vet->email = $request->email;
            $rules['email'] = 'unique:users|max:255|email';
        }

        if ($vet->phone != $request->phone) {
            $vet->phone = $request->phone;
            $rules['phone'] = 'unique:users|max:10';
        }

        $rules['avatar'] = 'nullable|mimes:jpeg,png,jpg,gif,svg';

        if (!empty($request->password)) {
            $vet->password = bcrypt($request->password);
        }

        $vet->name = $request->name;

        $validatedData = Validator::make($request->all(), $rules, [], [])->validate();

        $vet->save();

        if (isset($request->avatar)) {
            $avatarName = $vet->id . '_userAvatar' . time() . '.' . request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('user_avatars', $avatarName);
            $vet->avatar = $avatarName;
            $vet->save();
        }

        return redirect()->route('admins.veterinarians.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $veterinarian = User::find($id);
        $data['veterinarian'] = $veterinarian;
        return view('pages.admin.veterinarians.show')->with(compact('data'));
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
        $vet = User::find($id);

        if ($request->filled("email")) {
            $vet->email = $request->email;
            $rules['email'] = 'email';
        }

        if ($request->filled("phone")) {
            $vet->phone = $request->phone;
            $rules['phone'] = 'max:10';
        }

        if (!empty($request->password)) {
            $vet->password = bcrypt($request->password);
        }

        $vet->name = $request->name;

        if (isset($request->avatar)) {
            $avatarName = $vet->id . '_userAvatar' . time() . '.' . request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('user_avatars', $avatarName);
            $vet->avatar = $avatarName;
        }

        $vet->save();

        return redirect()->route('admins.veterinarians.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vet = User::find($id);
        $vet->delete();

        return redirect()->route('admins.veterinarians.index');
    }

    public function accept($id)
    {
        $vet = User::find($id);
        $vet->vet_status = "ACCEPTED";
        event(new VeterinarianAccepted($vet));
        $vet->save();

        return redirect()->route('admins.veterinarians.index');
    }
}