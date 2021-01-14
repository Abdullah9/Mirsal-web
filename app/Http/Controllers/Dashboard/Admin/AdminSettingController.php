<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Model\AdminSetting;
use App\User;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_setting = AdminSetting::first();

        return view('pages.admin.admin-settings.index')->with(compact('admin_setting'));
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
        $company = AdminSetting::find(1);
        // $company->tax_perc = $request->tax_perc;
        $company->admin_commission_perc = $request->admin_commission_perc;
        $company->first_payment_perc = $request->first_payment_perc;

        $company->vet_offer_note = $request->vet_offer_note;
        $company->driver_offer_note = $request->driver_offer_note;
        $company->vet_offer_note_ar = $request->vet_offer_note_ar;
        $company->driver_offer_note_ar = $request->driver_offer_note_ar;

        $company->terms_and_conditions = $request->terms_and_conditions;
        $company->terms_and_conditions_ar = $request->terms_and_conditions_ar;
        $company->save();

        return redirect()->route('admins.admin-settings.index');
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

    public function changePassword(Request $request, $id)
    {
        $admin_user = User::find(1);
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $admin_user->password = bcrypt($request->password);
        $admin_user->save();

        return redirect()->route('admins.admin-settings.index');
    }
}