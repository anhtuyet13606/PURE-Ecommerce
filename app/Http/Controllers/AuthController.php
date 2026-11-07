<?php
namespace App\Http\Controllers;
use App\Models\User;use Illuminate\Http\Request;use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Hash;use Illuminate\Validation\Rules\Password;
class AuthController extends Controller {
 public function login(){return view('auth.login');}
 public function authenticate(Request $r){$data=$r->validate(['email'=>'required|email','password'=>'required']);if(Auth::attempt($data,$r->boolean('remember'))){$r->session()->regenerate();return redirect()->intended(route('home'));}return back()->withErrors(['email'=>'Email hoặc mật khẩu không chính xác.'])->onlyInput('email');}
 public function register(){return view('auth.register');}
 public function store(Request $r){$data=$r->validate(['name'=>'required|string|max:120','email'=>'required|email|unique:users,email','phone'=>'required|string|max:30','password'=>['required','confirmed',Password::min(8)]]);$user=User::create($data);Auth::login($user);$r->session()->regenerate();return redirect()->route('home')->with('success','Tạo tài khoản thành công!');}
 public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect()->route('home');}
}
