<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);
        return view('users.show_users', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'status' => 'required',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);
        return redirect()->route('users.index')
            ->with('success', 'تم انشاء مستعمل جديد بنجاح');
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        if ($request->password) {

            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'required|same:confirm-password',
                'status' => 'required'
            ]);
            User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => $request->status,
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'status' => 'required'
            ]);
            User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'status' => $request->status,
            ]);
        }
        return redirect()->route('users.index')
            ->with('success', 'تم تحديث المستعمل جديد بنجاح');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'تم حذف المستعمل بنجاح');
    }
}
