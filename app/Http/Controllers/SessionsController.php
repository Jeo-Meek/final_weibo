<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {   // 我的思路是在这个地方做个表单的验证
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials,$request->has('remember'))) {
            //登录成功后的相关操作
            session()->flash('success', '欢迎回来!');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            session()->flash('danger', '很抱歉,您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }

    }

    public function destory()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出');
        return redirect()->route('login');
    }


}
