<?php

namespace App\Http\Controllers;

use App\Models\VaccineRecord;
use Illuminate\Http\Request;

class VaccineRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VaccineRecord::with('getVaccine')->with('getPatient')->get();
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
     * @param  \App\Models\VaccineRecord  $vaccineRecord
     * @return \Illuminate\Http\Response
     */
    public function show(VaccineRecord $vaccineRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VaccineRecord  $vaccineRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(VaccineRecord $vaccineRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VaccineRecord  $vaccineRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VaccineRecord $vaccineRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VaccineRecord  $vaccineRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(VaccineRecord $vaccineRecord)
    {
        //
    }
}
