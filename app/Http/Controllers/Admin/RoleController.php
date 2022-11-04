<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {

        $usersId = DB::table('role_user')->distinct('user_id')->pluck('user_id')->toArray();
        $users = User::whereIn('id', $usersId)->get();
//        $records = DB::table('role_user')
//            ->join('users', 'role_user.user_id', '=', 'users.id')
//            ->join('roles', 'role_user.role_id', '=', 'roles.id')
//            ->select('role_user.id AS id', 'users.email AS email', 'roles.name AS role_name', 'role_user.user_id AS user_id')
//            ->get();
        return view('admin.roles.index', compact('users'));
    }

    public function showEditUserRole($userId)
    {
        $user = User::findOrFail($userId);
        $roles = Role::all();
        return view('admin.roles.form', compact('user', 'roles'));
    }

    public function EditUserRole(Request $request, $userId)
    {
        $roles = $request->get('roles_id');
        $user = User::findOrFail($userId);
        $user->roles()->sync($roles);


        $usersId = DB::table('role_user')->distinct('user_id')->pluck('user_id')->toArray();
        $users = User::whereIn('id', $usersId)->get();
        return view('admin.roles.index', compact('users'));
    }

    public function showCreateUserRole()
    {
        $roles = Role::all();
        return view('admin.roles.form', compact( 'roles'));
    }

    public function createUserRole(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'string'],
            'roles_id' => ['required']
        ]);
        $user = User::where('email', $request->get('email'))->firstOrFail();
        $user->roles()->sync($data['roles_id']);

        $usersId = DB::table('role_user')->distinct('user_id')->pluck('user_id')->toArray();
        $users = User::whereIn('id', $usersId)->get();
        return view('admin.roles.index', compact('users'));
    }

    public function deleteUserRole($userId)
    {
        $user = User::findOrFail($userId);
        $user->roles()->detach();

        $usersId = DB::table('role_user')->distinct('user_id')->pluck('user_id')->toArray();
        $users = User::whereIn('id', $usersId)->get();
        return view('admin.roles.index', compact('users'));
    }
}
