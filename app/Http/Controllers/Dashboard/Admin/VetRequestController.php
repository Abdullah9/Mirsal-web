<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Model\Animal;
use App\Model\Size;
use App\Model\TimeSlot;
use App\Model\VetRequest;
use Illuminate\Http\Request;

class VetRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vetRequests = VetRequest::all();
        $data['vetRequests'] = $vetRequests;

        return view('pages.admin.vet-requests.index')->with(compact('data'));
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
        $vetRequest = VetRequest::find($id);
        $data = array();

        $sizes = Size::all();
        $animals = Animal::all();
        $timeslots = TimeSlot::all();
        $data['vetRequest'] = $vetRequest;
        $data['sizes'] = $sizes;
        $data['animals'] = $animals;
        $data['timeslots'] = $timeslots;

        return view('pages.admin.vet-requests.show')->with(compact("data"));
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
        $vetRequest = VetRequest::find($id);
        $vetRequest->type = $request->type;
        $vetRequest->animal_id = $request->animal_id;
        $vetRequest->size_id = $request->size_id;
        $vetRequest->status = $request->status;
        $vetRequest->description = $request->description;
        if ($vetRequest->address !== null) {
            $vetRequest->address->house_number = $request->house_number;
            $vetRequest->address->street = $request->street;
            $vetRequest->address->city = $request->city;
            $vetRequest->address->postal_code = $request->postal_code;
            $vetRequest->address->loc_lat = $request->loc_lat;
            $vetRequest->address->loc_lat = $request->loc_long;
            $vetRequest->address->save();
        }
        $vetRequest->save();

        return redirect()->route('admins.vet-requests.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vetRequest = VetRequest::find($id);
        $vetRequest->delete();

        return redirect()->route('admins.vet-requests.index');
    }
}