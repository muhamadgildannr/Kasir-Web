<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function index()
    {
        $userAccounts = User::paginate(10);
        return view('pages.user.index', compact('userAccounts'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.user.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required"
        ]);
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        if($request->role == "admin"){
            $user->assignRole("admin");
        }
        $user->assignRole("petugas");

        return redirect("/user")->with("success", "Berhasil membuat akun baru");
    }

    public function update(Request $request, $id){
        $request->validate([
            "name" => "required",
            "password" => "required"
        ]);

        $user = User::find($id);
        $user->update([
            "name" => $request->name,
            "password" => Hash::make($request->password)
        ]);
        $user->syncRoles([]);
        $user->assignRole($request->role);

        return back()->with("success", "Berhasil memperbaharui akun");
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();
        return back()->with("success", "Berhasil menghapus akun");
    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
