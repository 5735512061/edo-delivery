<?php

namespace App\Http\Controllers\AuthSeller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Seller;

use Validator;

class RegisterController extends Controller
{
    public function manageSeller(Request $request){
        $NUM_PAGE = 10;
        $sellers = Seller::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('authSeller/register')->with('NUM_PAGE',$NUM_PAGE)
                                          ->with('page',$page)
                                          ->with('sellers',$sellers);
    }

    public function registerSeller(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_registerSeller(), $this->messages_registerSeller());
        if($validator->passes()) {
            $seller = $request->all();
            $seller['password'] = bcrypt($seller['password']);
            $seller = Seller::create($seller);
            $request->session()->flash('alert-success', 'ลงทะเบียนพนักงานขายสำเร็จ');
            return back();
        }
        else {
            $request->session()->flash('alert-danger', 'ลงทะเบียนพนักงานขายไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function rules_registerSeller() {
        return [
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ];
    }

    public function messages_registerSeller() {
        return [
            'name.required' => 'กรุณากรอกชื่อ',
            'surname.required' => 'กรุณากรอกนามสกุล',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password_confirmation.required' => 'กรุณายืนยันรหัสผ่าน',
        ];
    }
}
