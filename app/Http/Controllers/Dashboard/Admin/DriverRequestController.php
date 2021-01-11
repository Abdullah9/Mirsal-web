<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Model\Animal;
use App\Model\DriverRequest;
use App\Model\Size;
use App\Model\TimeSlot;
use Illuminate\Http\Request;

class DriverRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $driverRequests = DriverRequest::with('animal')->get();
        $data['driverRequests'] = $driverRequests;

        return view('pages.admin.driver-requests.index')->with(compact('data'));
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
        $driverRequest = DriverRequest::find($id);
        $data = array();
        $driverRequest = $driverRequest;

        $sizes = Size::all();
        $animals = Animal::all();
        $timeslots = TimeSlot::all();
        $data['driverRequest'] = $driverRequest;
        $data['sizes'] = $sizes;
        $data['animals'] = $animals;
        $data['timeslots'] = $timeslots;

        return view('pages.admin.driver-requests.show')->with(compact("data"));
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
        $driverRequest = DriverRequest::find($id);
        $driverRequest->type = $request->type;
        $driverRequest->animal_id = $request->animal_id;
        $driverRequest->size_id = $request->size_id;
        $driverRequest->quantity = $request->quantity;
        $driverRequest->preferred_date = $request->preferred_date;
        $driverRequest->preferred_time = $request->preferred_time;

        $driverRequest->save();

        return redirect()->route('admins.driver-requests.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driverOffer = DriverOffer::find($id);
        $driverOffer->delete();

        return redirect()->route('admins.driver-requests.index');
    }
}