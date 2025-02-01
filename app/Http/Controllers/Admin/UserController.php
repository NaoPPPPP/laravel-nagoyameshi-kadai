<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = User::query();

        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('kana', 'LIKE', "%{$keyword}%");
        }

        $users = $query->paginate(15);

        $total = $users->total();

        return view('admin.users.index', compact('users', 'keyword', 'total'));
    }

    /**
     * 会員詳細を表示
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
