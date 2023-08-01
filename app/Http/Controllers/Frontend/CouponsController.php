<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Coupon;

use App\Cart;

use Session;

class CouponsController extends Controller
{
    public function store(Request $request) {
        $store_id = $request->get('store_id');
        $totalPrice = $request->get('totalPrice');

        $coupon = Coupon::where('code',$request->code)->where('status','เปิด')->first();

        if(!$coupon) {
            $request->session()->flash('alert-danger', 'คูปองส่วนลดไม่สามารถใช้ได้ กรุณาลองใหม่อีกครั้ง');
            return redirect()->route('checkout', ['store_id' => $store_id]);
        }

        $amount_type = $coupon->amount_type;
        $amount = $coupon->amount;
        $coupon_type = $coupon->coupon_type;
        $user_option = $coupon->user_option;
        $category_option = $coupon->category_option;

        if($amount_type == 'ค่าคงที่') {
            $discount = $amount;
            $total = $totalPrice - $discount;
        } elseif($amount_type == 'เปอร์เซ็นต์') {
            $discount = $totalPrice * ($amount/100);
            $total = $totalPrice - $discount; 
        }

        session()->put('coupon' , [
            'coupon_id' => $coupon->id,
            'name' => $coupon->coupon_name,
            'total' => $total,
            'discount' => $discount,
        ]);

        $value = $request->session()->get('coupon');
        
        $request->session()->flash('alert-success', 'ใช้คูปองส่วนลด');
        return redirect()->route('checkout', ['store_id' => $store_id]);
    }

    public function destroy($store_id) {
        Session::forget('coupon');
        return redirect()->route('checkout', ['store_id' => $store_id])->with('success_message','delete success!');
    }
}
