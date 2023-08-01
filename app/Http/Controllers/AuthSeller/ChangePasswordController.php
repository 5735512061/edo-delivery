<?php

namespace App\Http\Controllers\AuthSeller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Hash;
use App\Seller;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('authSeller/passwords/change');
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

        $hashedPassword = Auth::guard('seller')->user()->password;
        if(Hash::check($request->oldpassword,$hashedPassword)) {
            $seller = Seller::find(Auth::guard('seller')->id());
            $seller->password = Hash::make($request->password);
            $seller->save();
            Auth::guard('seller')->logout();
            return redirect()->route('seller.login')->with('successMsg',"เปลี่ยนรหัสผ่านสำเร็จ");
        }else {
            return redirect()->back()->with('errorMsg',"รหัสผ่านไม่ถูกต้อง");
        }
       
    }
}
