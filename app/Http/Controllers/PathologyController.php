<?php

namespace App\Http\Controllers;

use App\Models\Pathology;
use Illuminate\Http\Request;

class PathologyController extends Controller
{

    public function index()
    {
        return Pathology::all();
    }


    public function store(Request $request)
    {
        $pathology = new Pathology();
        $pathology->name = $request->name;
        return $pathology->save();
    }


    public function show(Pathology $pathology)
    {
        //
    }


    public function edit(Pathology $pathology)
    {
        //
    }


    public function update(Request $request, Pathology $pathology)
    {
        //
    }


    public function destroy(Pathology $pathology)
    {
        //
    }
}
