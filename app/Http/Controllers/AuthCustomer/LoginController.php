<?php

namespace App\Http\Controllers\AuthCustomer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Customer;

class LoginController extends Controller
{
    public function showLoginForm($store_id){
        return view('authCustomer.login')->with('store_id',$store_id);
    }

    public function login(Request $request)
    {
      $store_id = \Session::pull('store_id');
        if($store_id == null) {
            $store_id = 2;
        }

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
          'password' =>$request->password
        ];

        $username = $request->username;


        $customer_status =  Customer::where('username',$username)->value('status');
        if($customer_status == "เปิด") {
          if(Auth::guard('customer')->attempt($credential, $request->member)){
            // return redirect()->intended(route('menu.list', ['2']));
            return redirect()->action('Frontend\EdoController@categoryMenu',[$store_id]);
          }
        } else {
            $request->session()->flash('alert-danger', 'เข้าสู่ระบบไม่สำเร็จ เนื่องจาก user ถูกปิดการใช้งาน');
            return redirect()->back()->withInput($request->only('username','remember'));
        }
        
       return redirect()->back()->withInput($request->only('username','remember'));
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
        $store_id = $request->get('store_id');
        Auth::guard('customer')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route( 'customer.login', ['store_id' => $store_id] ));
    }
}
