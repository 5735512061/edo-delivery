<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Customer;
use App\model\Order;
use App\model\Contact;

use Validator;

class CustomerController extends Controller
{
    public function __construct(){
        $this->middleware('auth:customer');
    }

    public function profile($store_id){
        $customer_id = Auth::guard('customer')->user()->id;
        $customer = Customer::findOrFail($customer_id);
        return view('frontend/account/profile')->with('store_id',$store_id)
                                               ->with('customer',$customer);
    }

    public function editProfile($id, $store_id){
        $customer = Customer::findOrFail($id);
        return view('frontend/account/edit-profile')->with('customer',$customer)
                                                    ->with('store_id',$store_id);
    }

    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(), $this->rules_updateProfile(), $this->messages_updateProfile());
        if($validator->passes()) {
            $id = $request->get('id');
            $store_id = $request->get('store_id');
            $member = Customer::findOrFail($id);
            $member->update($request->all());
            $request->session()->flash('alert-success', 'แก้ไขข้อมูลส่วนตัวสำเร็จ');
            return redirect()->action('Frontend\\CustomerController@profile',[$store_id]);
        } else {
            $request->session()->flash('alert-danger', 'แก้ไขข้อมูลส่วนตัวไม่สำเร็จ กรุณากรอกข้อมูลให้ครบถ้วน');
            return back()->withErrors($validator)->withInput();   
        }
    }

    public function orderHistory($store_id){
        $customer_id = Auth::guard('customer')->user()->id;
        $orders = Order::where('customer_id',$customer_id)->groupBY('bill_number')->orderBy('id','desc')->get();
        return view('frontend/account/order-history')->with('store_id',$store_id)
                                                     ->with('orders',$orders);
    }

    public function orderHistoryDetail($id, $store_id){
        $order = Order::findOrFail($id);
        return view('frontend/account/order-history-detail')->with('store_id',$store_id)
                                                            ->with('order',$order);
    }

    
    public function messageHistory(Request $request, $store_id){
        $NUM_PAGE = 15;
        $customer_id = Auth::guard('customer')->user()->id;
        $messages = Contact::where('customer_id',$customer_id)->paginate($NUM_PAGE); 
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('frontend/account/message-history')->with('page',$page)
                                                       ->with('NUM_PAGE',$NUM_PAGE)
                                                       ->with('store_id',$store_id)
                                                       ->with('messages',$messages);
    }

    public function rules_updateProfile() {
        return [
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'username' => 'required',
        ];
    }

    public function messages_updateProfile() {
        return [
            'name.required' => 'กรุณากรอกขื่อ',
            'surname.required' => 'กรุณากรอกนามสกุล',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'username.required' => 'กรุณากรอกชื่อเข้าใช้งาน (เป็นภาษาอังกฤษ)',
        ];
    }
}
