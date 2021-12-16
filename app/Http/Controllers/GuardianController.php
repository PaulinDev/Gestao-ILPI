<?php

namespace App\Http\Controllers;

use App\Mail\newUserNotification;
use App\Models\Guardian;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class GuardianController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $guardian = new Guardian();
        $guardian->patientId = $request->patientId;
        $guardian->type = $request->type;
        $guardian->userId = $request->userId;
        return $guardian->save();
    }

    public function show(User $employee)
    {

    }

    public function update(Request $request, User $employee)
    {
    }

    public function destroy(Guardian $guardian)
    {
        return $guardian->delete();
    }
}
