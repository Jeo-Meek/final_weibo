<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user')); // compact会转换成一个关联数组
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:25',
            'password' => 'required|confirmed|min:6'
        ]);
        // 注册完之后页面重定向
        // laravel 会默认将所有的验证消息进行闪存，闪存的意思就是与视图进行捆绑
        $user = User::query()->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        session()->flash('success', '注册成功');
        // 这边还是需要理解create的用法，直接返回一个用户对象，包含热乎的信息
        return redirect()->route('users.show', [$user]); // route 方法会自动获取模型的实例的id
        //重定向的时候，给route方法传一个数组参数
    }

}
