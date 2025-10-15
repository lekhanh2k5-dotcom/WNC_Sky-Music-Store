<?php

namespace App\Http\Controllers;

use App\Models\User;


class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng
     */
    public function index()
    {
        // Lấy tất cả người dùng
        $users = User::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.users', compact('users'));
    }
}
