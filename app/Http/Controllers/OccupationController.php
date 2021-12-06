<?php

namespace App\Http\Controllers;

use App\Models\Occupation;
use Illuminate\Http\Request;

class OccupationController extends Controller
{

    public function index()
    {
        return Occupation::all();
    }

    public function store(Request $request)
    {
        $occupation = new Occupation();
        $occupation->description = $request->name;
        return $occupation->save();
    }

    public function show(Occupation $occupation)
    {
        //
    }

    public function update(Request $request, Occupation $occupation)
    {
        //
    }

    public function destroy(Occupation $occupation)
    {
        //
    }
}
