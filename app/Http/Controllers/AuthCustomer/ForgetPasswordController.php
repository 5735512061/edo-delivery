<?php

namespace App\Http\Controllers\AuthCustomer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Customer;

use Auth;
use Hash;
use Validator;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ForgetPasswordController extends Controller
{
    public function index($store_id){
        return view('authCustomer/passwords/forget')->with('store_id',$store_id);
    }

    public function forgetForm(Request $request){
        
        $validator = Validator::make($request->all(), $this->rules_forgetForm(), $this->messages_forgetForm());
        if($validator->passes()) {
            $phone = $request->get('phone');
            $store_id = $request->get('store_id');
            
            $customer = Customer::where('phone',$phone)->get();
            
            $password = Customer::where('phone',$phone)->value('password');

            if(count($customer) > 0 && $password != NULL) {
                $request->session()->flash('alert-success', 'ยืนยันหมายเลขโทรศัพท์สำเร็จ กรุณากรอกรหัสผ่านใหม่');
                return View::make('authCustomer/passwords/forget-confirm')->with('phone', $phone)
                                                                          ->with('store_id', $store_id);
            }
            else {
                $request->session()->flash('alert-danger', 'หมายเลขโทรศัพท์นี้ไม่เคยลงทะเบียน กรุณากรอกรหัสผ่านใหม่');
                return back()->withErrors($validator)->withInput();
            }
        }
        else {
            $request->session()->flash('alert-danger', 'ยืนยันหมายเลขโทรศัพท์ไม่สำเร็จ กรุณากรอกข้อมูลให้ถูกต้อง');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function UpdatePassword(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_UpdatePassword(), $this->messages_UpdatePassword());
        if($validator->passes()) {
            $phone = $request->get('phone');
            $password = $request->get('password');
            $store_id = $request->get('store_id');
            
            $id = Customer::where('phone',$phone)
                        ->value('id');
                        
                $customer = Customer::find($id);
                $customer->password = Hash::make($password);
                $customer->save();
                Auth::guard('customer')->logout();

            $request->session()->flash('alert-success', 'เปลี่ยนรหัสผ่านสำเร็จ');
            return redirect()->route('customer.login', ['store_id' => $store_id]);
        }
        else {
            $request->session()->flash('alert-danger', 'เปลี่ยนรหัสผ่านไม่สำเร็จ กรุณากรอกข้อมูลให้ถูกต้อง');
            return back()->withErrors($validator)->withInput();
        }
        
    }

    /////////////////////////////// validate ///////////////////////////////
    public function rules_forgetForm() {
        return [
            'phone' => 'required',
        ];
    }

    public function messages_forgetForm() {
        return [
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์ที่ลงทะเบียนไว้',
        ];
    }

    public function rules_UpdatePassword() {
        return [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages_UpdatePassword() {
        return [
            'password.required' => 'กรุณากรอกรหัสผ่านใหม่',
            'password.confirmed' => "รหัสผ่านยืนยันไม่ตรงกับรหัสผ่านใหม่",
            'password_confirmation.required' => "กรุณายืนยันรหัสผ่าน",
        ];
    }
}
