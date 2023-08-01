<?php

namespace App\Http\Controllers\AuthCustomer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Hash;
use App\Customer;

class ChangePasswordController extends Controller
{
    public function index($store_id){
        return view('authCustomer/passwords/change')->with('store_id',$store_id);
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

        $hashedPassword = Auth::guard('customer')->user()->password;
        if(Hash::check($request->oldpassword,$hashedPassword)) {
            $store_id = $request->get('store_id');
            $customer = Customer::find(Auth::guard('customer')->id());
            $customer->password = Hash::make($request->password);
            $customer->save();
            Auth::guard('customer')->logout();
            return redirect()->route('customer.login',['store_id' => $store_id])->with('successMsg',"เปลี่ยนรหัสผ่านสำเร็จ");
        }else {
            return redirect()->back()->with('errorMsg',"รหัสผ่านไม่ถูกต้อง");
        }
       
    }
}
