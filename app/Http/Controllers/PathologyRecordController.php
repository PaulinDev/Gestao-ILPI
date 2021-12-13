<?php

namespace App\Http\Controllers;

use App\Models\Pathology;
use App\Models\PathologyRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PathologyRecordController extends Controller
{

    public function index()
    {
        return PathologyRecord::all();
    }


    public function store(Request $request)
    {
        $records = [];

        foreach ($request->pathologyId as $x) {
            array_push($records,
                [
                    'pathologyId' => $x,
                    'patientId' => $request->patientId
                ]
            );
        }
        return DB::table('pathology_records')->insert($records);
    }


    public function show(PathologyRecord $pathologyRecord)
    {
        return $pathologyRecord;
    }

    public function pathologyByPatient($id)
    {
        return PathologyRecord::where('patientId', '=', $id)->get();
    }

    public function destroy(PathologyRecord $pathologyRecord)
    {
        return $pathologyRecord->delete();
    }
}
