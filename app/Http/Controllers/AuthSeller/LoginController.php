<?php

namespace App\Http\Controllers\AuthSeller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Seller;
use App\Model\Store;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('authSeller.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
          'username' => 'required',
          'password' => 'required|min:6'
        ],[
          'username.required' => "กรุณากรอกชื่อผู้ใช้",
          'password.required' => "กรุณากรอกรหัสผ่าน",
          'password.min' => "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร",
        ]);

        $credential = [
          'username' => $request->username,
          'password' => $request->password
        ];

        $username = $request->username;

        $seller_status =  Seller::where('username',$username)->value('status');
        
        $store_id = Seller::where('username',$username)->value('store_id');
        $store_name = Store::where('id',$store_id)->value('name');

        if($seller_status == "เปิด") {
          if(Auth::guard('seller')->attempt($credential, $request->member)){
            return redirect()->intended(route('seller.home', [$store_name]));
          }
          return redirect()->back()->withInput($request->only('username','remember'));
        } else {
            $request->session()->flash('alert-danger', 'เข้าสู่ระบบไม่สำเร็จ เนื่องจาก user ถูกปิดการใช้งาน');
            return redirect()->back()->withInput($request->only('username','remember'));
        }
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route( 'seller.login' ));
    }
}
