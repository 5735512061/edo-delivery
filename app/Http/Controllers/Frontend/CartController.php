<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Cart;
use App\model\FoodMenu;
use App\model\PaymentCheckout;
use App\model\ProductCart;
use App\model\Shipment;
use App\model\Order;
use App\model\Store;
use App\model\ShippingCost;

use Session;
use Auth;
use Carbon\Carbon;
use Validator;

class CartController extends Controller
{
    public function __construct(){
        $this->middleware('auth:customer');
    }

    public function getAddToCart(Request $request, $id, $qty, $store_id) {
        $comment = $request->comment;
        $product = FoodMenu::findOrFail($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id, $qty, $store_id, $comment);
        $request->session()->put('cart', $cart);    
        
        return back();  
    }

    public function getCart($store_id) {
        if (!Session::has('cart')) {
            
            return view('/frontend/cart/shopping-cart',['products' => 'null', 'store_id' => $store_id]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('/frontend/cart/shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice, 'store_id_session' => $cart->store_id_session, 'store_id' => $store_id]);   
    }

    public function getRemoveItem($id, $store_id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if(count($cart->items) > 0 ) {
            Session::put('cart', $cart);
        }
        else {
            Session::forget('cart');
            Session::forget('coupon');
        }
        
        return redirect()->route('cart.index', ['store_id' => $store_id]);    
    }

    public function getCheckout($store_id) {
        if (!Session::has('cart')) {
            return view('/frontend/cart/shopping-cart',['products' => 'null', 'store_id' => $store_id]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('/frontend/cart/checkout', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice, 'total' => $total, 'store_id' => $store_id]);
    }

    public function paymentCheckout(Request $request){
        $validator = Validator::make($request->all(), $this->rules_paymentCheckout(), $this->messages_paymentCheckout());
        if($validator->passes()) {
            $customer_id = Auth::guard('customer')->user()->id;

            $store_id = $request->get('store_id');
            $coupon_id = $request->get('coupon_id');

            $name = $request->get('name');
            $phone = $request->get('phone');
            $address = $request->get('address');
            $district = $request->get('district');
            $amphoe = $request->get('amphoe');
            $province = $request->get('province');
            $zipcode = $request->get('zipcode');

            $product = $request->get('product');
            $price = $request->get('price');
            $qty = $request->get('qty');
            $product_id = $request->get('product_id');
            $comment = $request->get('comment');
            $payday = $request->get('payday');
            $time = $request->get('time');
            $money = $request->get('money');
            $slip = $request->file('slip');

            $date = Carbon::now()->format('d/m/Y');
            
            $bill_number = rand(1111111111,9999999999);  
            $bill_number = wordwrap($bill_number , 4 , true );

            $payment_checkout = new PaymentCheckout;
            $payment_checkout->customer_id = $customer_id;
            $payment_checkout->bill_number = $bill_number;
            $payment_checkout->payday = $payday;
            $payment_checkout->time = $time;
            $payment_checkout->money = $money;

            if($request->hasFile('slip')){
                $slip = $request->file('slip');
                $filename = md5(($slip->getClientOriginalName(). time()) . time()) . "_o." . $slip->getClientOriginalExtension();
                $slip->move('image_upload/payment/', $filename);
                $path = 'image_upload/payment/'.$filename;
                $payment_checkout->slip = $filename;
                $payment_checkout->save();
            }

            $payment_checkout->save();

            $shipment = new Shipment;
            $shipment->customer_id = $customer_id;
            $shipment->bill_number = $bill_number;
            $shipment->name = $name;
            $shipment->phone = $phone;
            $shipment->address = $address;
            $shipment->district = $district;
            $shipment->amphoe = $amphoe;
            $shipment->province = $province;
            $shipment->zipcode = $zipcode;
            $shipment->save();

            for ($i=0; $i < count($product) ; $i++) { 
                $product_cart = new ProductCart;
                $product_cart->customer_id = $customer_id;
                $product_cart->bill_number = $bill_number;
                $product_cart->product_id = $product_id[$i];
                $product_cart->price = $price[$i];
                $product_cart->qty = $qty[$i];
                $product_cart->comment = $comment[$i];
                $product_cart->save();
            }

            $payment_id = PaymentCheckout::where('bill_number',$bill_number)->value('id');
            $shipment_id = Shipment::where('bill_number',$bill_number)->value('id');
            $product_carts = ProductCart::where('bill_number',$bill_number)->get();

            $date = Carbon::now()->format('d/m/Y');

            foreach($product_carts as $product_cart => $value) {
                $order = new Order;
                $order->customer_id = $customer_id;
                $order->store_id = $store_id;
                $order->bill_number = $bill_number;
                $order->payment_id = $payment_id;
                $order->shipment_id = $shipment_id;
                $order->product_cart_id = $value->id;
                $order->date = $date;
                $order->coupon_id = $coupon_id;
                $order->save();
            }

            Session::forget('cart');
            Session::forget('coupon');
            
            $request->session()->flash('alert-success', 'แจ้งชำระเงินและสั่งซื้อสินค้าสำเร็จ');
            $request->session()->flash('alert-danger', '* พนักงานจะติดต่อกลับภายใน 5 นาที ถ้าไม่ได้รับการติดต่อกลับจากพนักงาน รบกวนคุณลูกค้าติดต่อ 063-494-2044 ค่ะ');
            $customer_id = Auth::guard('customer')->user()->id;
            $orders = Order::where('customer_id',$customer_id)->groupBY('bill_number')->orderBy('id','asc')->get();
            $order_id = Order::groupBy('bill_number')->where('store_id',$store_id)->orderBy('id','desc')->value('id');
            $order = Order::findOrFail($order_id);

            $store_mail = Store::where('id',$store_id)->value('mail');

            $details = [
                'bill_number' => $bill_number,
                'order' => $order,
            ];

            \Mail::to($store_mail)->send(new \App\Mail\OrderMail($details));

            return view('/frontend/account/order-history-detail')->with('store_id',$store_id)
                                                                 ->with('orders',$orders)
                                                                 ->with('order',$order);
        } else {
            $request->session()->flash('alert-danger', 'แจ้งชำระเงินไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function getShipping(Request $request) {
        $district = $request->get('district'); // รับค่ามาจาก ajax
        $store_id = $request->get('store_id'); // รับค่ามาจาก ajax

        $shipping = ShippingCost::where('store_id',$store_id)->where('place',$district)->get(); // ดึงค่ามาจากฐานข้อมูลที่ตรงกับตำบล
        $shipping_count = count($shipping); // นับจำนวนข้อมูลที่ตรงกัน

        $min_cost = ShippingCost::where('store_id',$store_id)->where('place',$district)->value('min_cost');
        $price = ShippingCost::where('store_id',$store_id)->where('place',$district)->value('price');

        if($shipping_count == 0) { // ในกรณีที่ไม่มีที่อยู่ในฐานข้อมูลที่กำหนด ให้เข้าเงื่อนไขนี้
            $obj = new \stdClass();
            $obj->status = "NULL";
            return response()->json($obj);
        } else { // ในกรณีที่มีที่อยู่ตามฐานข้อมูลที่กำหนด ให้เข้าเงื่อนไขนี้
            $obj = new \stdClass();
            $obj->min_cost = $min_cost;
            $obj->price = $price;
            $obj->status = "Pass";
            return response()->json($obj);
        }        
    }

    // Validate
    public function rules_paymentCheckout() {
        return [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'district' => 'required',
            'amphoe' => 'required',
            'province' => 'required',
            'zipcode' => 'required',
            'payday' => 'required',
            'time' => 'required',
            'money' => 'required',
            'slip' => 'required',
        ];
    }

    public function messages_paymentCheckout() {
        return [
            'name.required' => 'กรุณากรอกชื่อและนามสกุล',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'address.required' => 'กรุณากรอกที่อยู่',
            'district.required' => 'กรุณากรอกตำบล',
            'amphoe.required' => 'กรุณากรอกอำเภอ',
            'province.required' => 'กรุณากรอกจังหวัด',
            'zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์',
            'payday.required' => 'กรุณากรอกวันที่ชำระเงิน',
            'time.required' => 'กรุณากรอกเวลาที่ชำระเงิน',
            'money.required' => 'กรุณากรอกจำนวนเงินที่ชำระ',
            'slip.required' => 'กรุณาแนบหลักฐานการโอนเงิน',
        ];
    }

}
