<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Customer;
use App\model\Order;
use App\model\FoodMenu;

class AdminSearchController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function searchDataCustomer(Request $request){
        $NUM_PAGE = 20;
        $phone = $request->get('phone');
        $name = $request->get('name');
        $customers = Customer::where([
            ['phone','LIKE', $phone],
            ['name','LIKE', $name],
        ])->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageCustomer/data-customer')->with('NUM_PAGE',$NUM_PAGE)
                                                                 ->with('page',$page)
                                                                 ->with('customers',$customers);
    }

    public function searchOrder(Request $request){
        $customer_code = $request->get('customer_code');
        $customer_id = Customer::where('customer_code','LIKE', "%{$customer_code}")->value('id');
        $bill_number = $request->get('bill_number');
        $NUM_PAGE = 50;
        $orders = Order::groupBy('bill_number')->orderBy('id','asc')->where([
            ['bill_number','LIKE', "%{$bill_number}"],
            ['customer_id', $customer_id],
        ])->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageOrder/order')->with('NUM_PAGE',$NUM_PAGE)
                                                      ->with('page',$page)
                                                      ->with('orders',$orders);
    }

    public function searchMenu(Request $request){
        $NUM_PAGE = 20;
        $thai_name = $request->get('thai_name');
        $eng_name = $request->get('eng_name');
        $food_menus = FoodMenu::where([
            ['thai_name','LIKE', "%{$thai_name}%"],
            ['eng_name','LIKE', "%{$eng_name}%"],
        ])->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageMenu/list-menu')->with('NUM_PAGE',$NUM_PAGE)
                                                         ->with('page',$page)
                                                         ->with('food_menus',$food_menus);
    }

    public function searchMenuPrice(Request $request){
        $NUM_PAGE = 20;
        $thai_name = $request->get('thai_name');
        $eng_name = $request->get('eng_name');
        $food_menus = FoodMenu::where([
            ['thai_name','LIKE', "%{$thai_name}%"],
            ['eng_name','LIKE', "%{$eng_name}%"],
        ])->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageMenuPrice/menu-price')->with('NUM_PAGE',$NUM_PAGE)
                                                               ->with('page',$page)
                                                               ->with('food_menus',$food_menus);
    }

    public function searchMenuPricePromotion(Request $request){
        $NUM_PAGE = 20;
        $thai_name = $request->get('thai_name');
        $eng_name = $request->get('eng_name');
        $food_menus = FoodMenu::where([
            ['thai_name','LIKE', "%{$thai_name}%"],
            ['eng_name','LIKE', "%{$eng_name}%"],
        ])->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageMenuPricePromotion/menu-price-promotion')->with('NUM_PAGE',$NUM_PAGE)
                                                                                  ->with('page',$page)
                                                                                  ->with('food_menus',$food_menus);
    }
    
}
