<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function showLogin(){
        return view("login");
    }

    public function login(Request $request){
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            // Kiểm tra trạng thái của người dùng
            $user = Auth::user();
            if ($user->status == 1) {
                return redirect('/home');
            } else {
                Auth::logout();
                return redirect('/login')->with('message', 'Tài khoản của bạn đã bị tạm khóa.')->with("type", "ERR");
            }
        } else {
            return redirect('/login')->with('message', 'Tên đăng nhập hoặc mật khẩu không đúng.')->with("type", "ERR");
        }
    }
    
    public function showRegister(){
        return view("register");
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);
    
        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'password_admin' => $request->input('password'),
            'status' => 1,
        ]);
    
        if ($user) {
            return redirect('/login')->with('message', 'Đăng ký thành công!')->with('type', 'OK');
        } else {
            return redirect('/login')->with('message', 'Có lỗi khi đăng ký.')->with('type', 'ERR');
        }
    }
    
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
