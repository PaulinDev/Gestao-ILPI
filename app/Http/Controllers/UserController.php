<?php

namespace App\Http\Controllers;

use App\Mail\newUserNotification;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $randomPass = mt_rand(10000000, 99999999);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->post = $request->userPost;
        $user->type = $request->type;
        $user->gender = $request->gender;
        $user->birthdate = $request->birthdate;
        $user->userCpf = $request->userCpf;
        $user->userRg = $request->userRg;
        $user->permission = $request->permission;
        $user->password = Hash::make($randomPass);

        $user->save();

        $address = new UserAddress();
        $address->Cep = $request->addressCep;
        $address->Number = $request->addressNumber;
        $address->City = $request->addressCity;
        $address->Province = $request->addressProvince;
        $address->District = $request->addressDistrict;
        $address->Street = $request->addressStreet;
        $address->userId = $user->id;

        $address->save();

        $user = User::find($user->id);
        $user->address = $address->id;

        $user->save();

        $user = User::where('id', $user->id)->first();
        $user->password = $randomPass;
        Mail::to($user->email)->send(new newUserNotification($user));

        return true;

    }

    public function show(User $user)
    {
        return User::find($user->id);
    }


    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
