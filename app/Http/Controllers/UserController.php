<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.users', compact('users'));
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            return back()->with('error', '❌ Không thể khóa tài khoản admin!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'mở khóa' : 'khóa';
        return back()->with('success', "✅ Đã {$status} tài khoản {$user->name}");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            return back()->with('error', '❌ Không thể xóa tài khoản admin!');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "✅ Đã xóa người dùng {$name}");
    }
}
