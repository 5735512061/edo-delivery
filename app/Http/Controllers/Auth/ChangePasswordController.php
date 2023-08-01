<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Hash;
use App\Admin;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('auth/passwords/change');
    }

    public function changePassword(Request $request)
    {
       $this->validate($request, [
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
       ],[
            'oldpassword.required' => "กรุณากรอกรหัสผ่านเก่า",
            'password.required' => "กรุณากรอกรหัสผ่านใหม่",
            'password.confirmed' => "รหัสผ่านยืนยันไม่ตรงกับรหัสผ่านใหม่",
            'password_confirmation.required' => "กรุณายืนยันรหัสผ่าน",
       ]);

        $hashedPassword = Auth::guard('admin')->user()->password;
        if(Hash::check($request->oldpassword,$hashedPassword)) {
            $admin = Admin::find(Auth::guard('admin')->id());
            $admin->password = Hash::make($request->password);
            $admin->save();
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('successMsg',"เปลี่ยนรหัสผ่านสำเร็จ");
        }else {
            return redirect()->back()->with('errorMsg',"รหัสผ่านไม่ถูกต้อง");
        }
       
    }
}
