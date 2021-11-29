<?php

namespace App\Http\Controllers;

use App\Models\VaccineBrand;
use Illuminate\Http\Request;

class VaccineBrandController extends Controller
{

    public function index()
    {
        return VaccineBrand::all();
    }

    public function showBrandVaccine(Request $request)
    {
        return vaccineBrand::find($request->id)->get();
    }

    public function store(Request $request)
    {
        $brand = new VaccineBrand();
        $brand->name = $request->name;
        $brand->vaccine = $request->vaccineId;
        $brand->save();
    }

    public function show(vaccineBrand $vaccineBrand)
    {
        //
    }


    public function update(Request $request, vaccineBrand $vaccineBrand)
    {
        //
    }


    public function destroy(vaccineBrand $vaccineBrand)
    {
        //
    }
}
