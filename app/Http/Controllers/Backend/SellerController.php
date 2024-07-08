<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\Store;
use App\model\FoodMenu;
use App\model\MenuPrice;
use App\model\MenuPricePromotion;
use App\model\Contact;
use App\model\Order;
use App\model\OrderConfirm;
use App\model\PaymentCheckout;
use App\model\ProductCart;
use App\model\Shipment;
use App\model\Voucher;
use App\Seller;

use Validator;
use Auth;

use Carbon\Carbon;

class SellerController extends Controller
{
    public function listMenu(Request $request){
        $NUM_PAGE = 20;
        $store_id = Seller::where('id',Auth::guard('seller')->user()->id)->value('store_id');
        $food_menus = FoodMenu::where('store_id',$store_id)->orderBy('menu_type_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/seller/manageMenu/list-menu')->with('NUM_PAGE',$NUM_PAGE)
                                                          ->with('page',$page)
                                                          ->with('food_menus',$food_menus);
    }

    public function updateFoodMenu(Request $request){
        $id = $request->get('id');
        $food_menu = FoodMenu::findOrFail($id);
        $food_menu->update($request->all());
        $request->session()->flash('alert-success', 'อัพเดตรายการเมนูสำเร็จ');
        return back();
    }

    // ตัวจัดการราคา
    public function listMenuPrice(Request $request){
        $NUM_PAGE = 20;
        $store_id = Seller::where('id',Auth::guard('seller')->user()->id)->value('store_id');
        $food_menus = FoodMenu::where('store_id',$store_id)->orderBy('menu_type_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/seller/manageMenuPrice/menu-price')->with('NUM_PAGE',$NUM_PAGE)
                                                                ->with('page',$page)
                                                                ->with('food_menus',$food_menus);
    }

    public function updateMenuPrice(Request $request){
        $validator = Validator::make($request->all(), $this->rules_updateMenuPrice(), $this->messages_updateMenuPrice());
        if($validator->passes()) {
            $price = $request->all();
            $price = MenuPrice::create($price); 
            $request->session()->flash('alert-success', 'อัพโหลดราคาสำเร็จ');
            return back();
        }
        else {
            $request->session()->flash('alert-danger', 'อัพโหลดราคาไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function menuPriceDetail(Request $request,$id){
        $NUM_PAGE = 20;
        $prices = MenuPrice::where('menu_id',$id)->orderBy('id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/seller/manageMenuPrice/menu-price-detail')->with('NUM_PAGE',$NUM_PAGE)
                                                                       ->with('page',$page)
                                                                       ->with('prices',$prices);
    }

    // ตัวจัดการราคาโปรโมชั่น
    public function listMenuPricePromotion(Request $request){
        $NUM_PAGE = 20;
        $store_id = Seller::where('id',Auth::guard('seller')->user()->id)->value('store_id');
        $food_menus = FoodMenu::where('store_id',$store_id)->orderBy('menu_type_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/seller/manageMenuPricePromotion/menu-price-promotion')->with('NUM_PAGE',$NUM_PAGE)
                                                                                   ->with('page',$page)
                                                                                   ->with('food_menus',$food_menus);
    }

    public function updateMenuPricePromotion(Request $request){
        $validator = Validator::make($request->all(), $this->rules_updateMenuPricePromotion(), $this->messages_updateMenuPricePromotion());
        if($validator->passes()) {
            $price = $request->all();
            $price = MenuPricePromotion::create($price); 
            $request->session()->flash('alert-success', 'อัพโหลดราคาสำเร็จ');
            return back();
        }
        else {
            $request->session()->flash('alert-danger', 'อัพโหลดราคาไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function menuPricePromotionDetail(Request $request,$id){
        $NUM_PAGE = 20;
        $prices = MenuPricePromotion::where('menu_id',$id)->orderBy('id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/seller/manageMenuPricePromotion/menu-price-promotion-detail')->with('NUM_PAGE',$NUM_PAGE)
                                                                                          ->with('page',$page)
                                                                                          ->with('prices',$prices);
    }

    public function message(Request $request){
        $NUM_PAGE = 50;
        $store_id = Seller::where('id',Auth::guard('seller')->user()->id)->value('store_id');
        $messages = Contact::where('store_id',$store_id)->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/seller/contact/message')->with('page',$page)
                                                     ->with('NUM_PAGE',$NUM_PAGE)
                                                     ->with('messages',$messages);
    }

    public function answerMessage(Request $request){
        $id = $request->get('id');
        $answer_message = $request->get('answer_message');
        $message = Contact::findOrFail($id);
        $message->answer_message = $answer_message; 
        $message->update();
        return back();
    }

    public function order(Request $request){
        $NUM_PAGE = 50;
        $store_id = Seller::where('id',Auth::guard('seller')->user()->id)->value('store_id');
        $orders = Order::groupBy('bill_number')->where('store_id',$store_id)->orderBy('id','desc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/seller/manageOrder/order')->with('NUM_PAGE',$NUM_PAGE)
                                                       ->with('page',$page)
                                                       ->with('orders',$orders);
    }

    public function orderDetail($id){
        $order = Order::findOrFail($id);
        return view('backend/seller/manageOrder/order-detail')->with('order',$order);
    }

    public function updateOrdertatus(Request $request) {
        $status = $request->all();
        $status = OrderConfirm::create($status);
        return back();
    }

    public function deleteOrder($id){
        $order = Order::findOrFail($id);
        $products = Order::where('bill_number',$order->bill_number)->get();

            foreach($products as $product => $value) {
                $order_confirm = OrderConfirm::where('bill_number',$value->bill_number)->delete();
                $product = Order::where('bill_number',$value->bill_number)->delete();
                $payment = PaymentCheckout::where('bill_number',$value->bill_number)->delete();
                $shipment = Shipment::where('bill_number',$value->bill_number)->delete();
                $product_cart = ProductCart::where('bill_number',$value->bill_number)->delete();
                $order = Order::where('bill_number',$value->bill_number)->delete();
            }

            return back();
    }

    public function updateShipment(Request $request){
        $id = $request->get('id');
        $bill_number = $request->get('bill_number');
        $shipment_id = Shipment::where('bill_number',$bill_number)->value('id');
        $shipment = Shipment::findOrFail($shipment_id);
        $shipment->update($request->all());
        return redirect()->action('Backend\SellerController@order');
    }

    // คูปองเงินสด
    public function voucher(Request $request){
        $NUM_PAGE = 50;
        $vouchers = Voucher::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/seller/voucher/voucher')->with('vouchers',$vouchers)
                                                     ->with('page',$page)
                                                     ->with('NUM_PAGE',$NUM_PAGE);
    }
    public function updateVoucher(Request $request){
        $validator = Validator::make($request->all(), $this->rules_createVoucher(), $this->messages_createVoucher());
        if($validator->passes()) {
            $id = $request->get('id');
            $voucher = Voucher::findOrFail($id);
            $voucher->date = Carbon::now();
            $voucher->update($request->all());
            $request->session()->flash('alert-success', 'อัพเดตข้อมูลสำเร็จ');
            return redirect()->action('Backend\SellerController@voucher');
        }
        else {
            $request->session()->flash('alert-danger', 'อัพเดตข้อมูลไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function messages_updateMenu() {
        return [
            'thai_name.required' => 'กรุณากรอกชื่อเมนูอาหาร (ภาษาไทย)',
            'eng_name.required' => 'กรุณากรอกชื่อเมนูอาหาร (ภาษาอังกฤษ)',
        ];
    }

    public function rules_updateMenuPrice() {
        return [
            'price' => 'required',
        ];
    }

    public function messages_updateMenuPrice() {
        return [
            'price.required' => 'กรุณากรอกราคาอาหาร',
        ];
    }

    public function rules_updateMenuPricePromotion() {
        return [
            'promotion_price' => 'required',
        ];
    }

    public function messages_updateMenuPricePromotion() {
        return [
            'promotion_price.required' => 'กรุณากรอกราคาอาหารโปรโมชั่น',
        ];
    }

    public function rules_createVoucher() {
        return [
            'serialnumber' => 'required',
            'creator' => 'required',
        ];
    }

    public function messages_createVoucher() {          
        return [
            'serialnumber.required' => 'กรุณากรอกหมายเลขหน้าบัตร',
            'creator.required' => 'กรุณากรอกชื่อผู้ขายคูปอง',
        ];
    }
}
