<?php

namespace App\Http\Controllers;

use App\Mail\newUserNotification;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class EmployeeController extends Controller
{
    public function index()
    {
        return User::where('type', '1')->with('getPost')->with('getPermission')->with('getGender')->get();
    }

    public function store(Request $request)
    {

        $employee = new User();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->post = $request->userPost;
        $employee->type = $request->type;
        $employee->gender = $request->gender;
        $employee->birthdate = $request->birthdate;
        $employee->userCpf = $request->userCpf;
        $employee->userRg = $request->userRg;
        $employee->permission = $request->permission;
        $employee->password = '12345678';

        $employee->save();

        $address = new UserAddress();
        $address->Cep = $request->addressCep;
        $address->Number = $request->addressNumber;
        $address->City = $request->addressCity;
        $address->Province = $request->addressProvince;
        $address->District = $request->addressDistrict;
        $address->Street = $request->addressStreet;
        $address->userId = $employee->id;

        $address->save();

        $employee = User::find($employee->id);
        $employee->address = $address->id;

        $employee->save();

        $user = User::where('id', $employee->id)->first();

        Mail::to($user->email)->send(new newUserNotification($user));

    }

    public function show(User $employee)
    {
        return User::with('getAddress')->find($employee->id);
    }

    public function update(Request $request, User $employee)
    {

        if (empty($employee->getAddress)) {
            $newAddress = new UserAddress();
            $newAddress->Cep = $request->addressCep;
            $newAddress->Number = $request->addressNumber;
            $newAddress->City = $request->addressCity;
            $newAddress->Province = $request->addressProvince;
            $newAddress->District = $request->addressDistrict;
            $newAddress->Street = $request->addressStreet;
            $newAddress->userId = $employee->id;
            $newAddress->save();
            $employee->address = $newAddress->id;
        } else {
            $address = UserAddress::find($employee->address);
            $address->Cep = $request->addressCep;
            $address->Number = $request->addressNumber;
            $address->City = $request->addressCity;
            $address->Province = $request->addressProvince;
            $address->District = $request->addressDistrict;
            $address->Street = $request->addressStreet;
            $address->save();
        }

        return $employee->update($request->all());
    }

    public function destroy(User $employee)
    {
        return $employee->delete();
    }
}
