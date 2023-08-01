<?php

namespace App\Http\Controllers\AuthCustomer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Customer;
use Validator;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function ShowRegisterFormCustomer($store_id){
        return view('authCustomer/register')->with('store_id',$store_id);
    }

    public function registerCustomer(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_registerCustomer(), $this->messages_registerCustomer());
        if($validator->passes()) {
            $customer = $request->all();
            $store_id = $request->get('store_id');
            $date = Carbon::now()->format('Y-m-d');
            $customer['password'] = bcrypt($customer['password']);
            $customer['date'] = $date;
            $customer = Customer::create($customer);
            $request->session()->flash('alert-success', 'ลงทะเบียนสำเร็จ กรุณาเข้าสู่ระบบเพื่อทำการสั่งซื้ออาหาร');
            return redirect()->action('AuthCustomer\LoginController@ShowLoginForm',[$store_id]);
        }
        else {
            $request->session()->flash('alert-danger', 'ลงทะเบียนไม่สำเร็จ กรุณากรอกข้อมูลให้ครบถ้วน');
            return back()->withErrors($validator)->withInput();
        }
    }

    // Validate
    public function rules_registerCustomer() {
        return [
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required|unique:customers',
            'username' => 'required|unique:customers|min:6',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages_registerCustomer() {
        return [
            'name.required' => 'กรุณากรอกขื่อ',
            'surname.required' => 'กรุณากรอกนามสกุล',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'phone.unique' => 'เบอร์โทรศัพท์ใช้ในการสมัครสมาชิกแล้ว',
            'username.required' => 'กรุณากรอกชื่อเข้าใช้งาน (เป็นภาษาอังกฤษ)',
            'username.unique' => 'ชื่อผู้ใช้นี้มีผู้อื่นใช้แล้ว ลองใช้ชื่ออื่น',
            'username.min' => 'กรุณากรอกชื่อผู้ใช้งานอย่างน้อย 6 ตัวอักษร',
            'password.required' => "กรุณากรอกรหัสผ่านอย่างน้อย 6 หลัก",
            'password.min' => "กรุณากรอกรหัสผ่านอย่างน้อย 6 หลัก",
            'password.confirmed' => "รหัสผ่านยืนยันไม่ตรงกับรหัสผ่านใหม่",
            'password_confirmation.required' => "กรุณายืนยันรหัสผ่าน",
        ];
    }
}
