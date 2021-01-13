<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Model\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisements = Advertisement::get();

        return view('pages.admin.advertisements.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('pages.admin.advertisements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name' => 'required',
            'display' => 'required|numeric',
            // 'description' => 'required',

        ]);
        $advertisement = new Advertisement();

        $advertisement->name_ar = $request->name_ar;
        $advertisement->name = $request->name;
        $advertisement->display = $request->display;
        // $advertisement->description = $request->description;

        if (!empty($request->image)) {
            $filename = '_ads' . time() . '.' . request()->image->getClientOriginalExtension();
            $request->image->storeAs('ads', $filename, 'public');
            $advertisement->image = $filename;

        }
        $advertisement->save();
        return redirect()->route('admins.advertisements.index')->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advertisement = Advertisement::find($id);
        $advertisement->display = !$advertisement->display;
        $advertisement->save();
        return redirect()->route('admins.advertisements.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advertisement = Advertisement::find($id);

        return view('pages.admin.advertisements.edit', compact('advertisement'));
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
        $request->validate([
            'name_ar' => 'required',
            'name' => 'required',
            'display' => 'required|numeric',
            // 'description' => 'required',

        ]);
        $advertisement = Advertisement::find($id);

        $advertisement->name_ar = $request->name_ar;
        $advertisement->name = $request->name;
        $advertisement->display = $request->display;
        // $advertisement->description = $request->description;
        if (!empty($request->image)) {
            $filename = '_ads' . time() . '.' . request()->image->getClientOriginalExtension();
            $request->image->storeAs('ads', $filename, 'public');
            $advertisement->image = $filename;

        }
        $advertisement->save();
        return redirect()->route('admins.advertisements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertisement = Advertisement::find($id);
        $advertisement->delete();
        return redirect()->route('admins.advertisements.index');
    }
}