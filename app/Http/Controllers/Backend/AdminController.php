<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;

use App\model\Store;
use App\model\MenuType;
use App\model\FoodMenu;
use App\model\ImageFoodMenu;
use App\model\MenuPrice;
use App\model\MenuPricePromotion;
use App\model\ImageLogoWebsite;
use App\model\ImageSlideWebsite;
use App\model\Order;
use App\model\OrderConfirm;
use App\model\PaymentCheckout;
use App\model\Shipment;
use App\model\ProductCart;
use App\model\Contact;
use App\model\Blog;
use App\model\ImageGallery;
use App\model\Coupon;
use App\model\SpecialMenu;
use App\model\ApplyWork;
use App\model\UrlApplyWork;

use App\Customer;
use App\Seller;

use Response;
use Validator;

class AdminController extends Controller
{   
    public function __construct(){
        $this->middleware('auth:admin');
    }
    
    public function dataCustomer(Request $request){
        $NUM_PAGE = 20;
        $customers = Customer::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageCustomer/data-customer')->with('NUM_PAGE',$NUM_PAGE)
                                                                 ->with('page',$page)
                                                                 ->with('customers',$customers);
    }

    public function updateCustomer(Request $request){
        $validator = Validator::make($request->all(), $this->rules_updateCustomer(), $this->messages_updateCustomer());
        if($validator->passes()) {
            $id = $request->get('id');
            $customer = Customer::findOrFail($id);
            $customer->update($request->all());
            $request->session()->flash('alert-success', 'อัพเดตข้อมูลลูกค้าสำเร็จ');
            return redirect()->action('Backend\AdminController@dataCustomer');
        }
        else {
            $request->session()->flash('alert-danger', 'อัพเดตข้อมูลลูกค้าไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function deleteCustomer($id){
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return back();
    }

    // ตัวจัดการข้อมูลพนักงานขาย
    public function dataSeller(Request $request){
        $NUM_PAGE = 20;
        $sellers = Seller::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageSeller/data-seller')->with('NUM_PAGE',$NUM_PAGE)
                                                             ->with('page',$page)
                                                             ->with('sellers',$sellers);
    }

    public function createSeller(Request $request){
        $validator = Validator::make($request->all(), $this->rules_createSeller(), $this->messages_createSeller());
        if($validator->passes()) {
            $seller = $request->all();
            $seller['password'] = bcrypt($seller['password']);
            $seller = Seller::create($seller);
            $request->session()->flash('alert-success', 'เพิ่มพนักงานขายสำเร็จ');
            return redirect()->action('Backend\AdminController@dataSeller');
        }
        else {
            $request->session()->flash('alert-danger', 'เพิ่มพนักงานขายไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function deleteSeller($id){
        $seller = Seller::findOrFail($id);
        $seller->delete();
        return back();
    }

    public function updateSeller(Request $request){
        $validator = Validator::make($request->all(), $this->rules_updateSeller(), $this->messages_updateSeller());
        if($validator->passes()) {
            $id = $request->get('id');
            $seller = Seller::findOrFail($id);
            $seller->update($request->all());
            $request->session()->flash('alert-success', 'อัพเดตพนักงานขายสำเร็จ');
            return redirect()->action('Backend\AdminController@dataSeller');
        }
        else {
            $request->session()->flash('alert-danger', 'อัพเดตพนักงานขายไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    // ตัวจัดการร้านค้า
    public function createStore(){
        return view('backend/admin/manageStore/create-store');
    }

    public function createStorePost(Request $request){
        $validator = Validator::make($request->all(), $this->rules_createStorePost(), $this->messages_createStorePost());
        if($validator->passes()) {
            $store = $request->all();
            $store = Store::create($store);
            if($request->hasFile('logo')){
                $logo = $request->file('logo');
                $filename = md5(($logo->getClientOriginalName(). time()) . time()) . "_o." . $logo->getClientOriginalExtension();
                $logo->move('image_upload/image_store_logo/', $filename);
                $path = 'image_upload/image_store_logo/'.$filename;
                $store->logo = $filename;
                $store->save();
            }
            $request->session()->flash('alert-success', 'สร้างรายชื่อสำเร็จ');
            return redirect()->action('Backend\AdminController@dataStore');
        }
        else {
            $request->session()->flash('alert-danger', 'สร้างรายชื่อไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function dataStore(Request $request){
        $NUM_PAGE = 20;
        $stores = Store::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageStore/data-store')->with('NUM_PAGE',$NUM_PAGE)
                                                           ->with('page',$page)
                                                           ->with('stores',$stores);
    }

    public function deleteStore($id){
        $store = Store::findOrFail($id);
        $store->delete();
        return back();
    }

    public function updateStore(Request $request){
        $validator = Validator::make($request->all(), $this->rules_updateStore(), $this->messages_updateStore());
        if($validator->passes()) {
            $id = $request->get('id');
            $store = Store::findOrFail($id);
            $store->update($request->all());
            if($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $filename = md5(($logo->getClientOriginalName(). time()) . time()) . "_o." . $logo->getClientOriginalExtension();
                $logo->move('image_upload/image_store_logo/', $filename);
                $path = 'image_upload/image_store_logo/'.$filename;
                $store = Store::findOrFail($id);
                $store->logo = $filename;
                $store->save();
            }
            $request->session()->flash('alert-success', 'แก้ไขข้อมูลร้านค้าสำเร็จ');
            return redirect()->action('Backend\AdminController@dataStore');
        }
        else {
            $request->session()->flash('alert-danger', 'แก้ไขข้อมูลร้านค้าไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    // ตัวจัดการเมนู
    public function manageMenuType(Request $request){
        $NUM_PAGE = 20;
        $menu_types = MenuType::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageMenu/manage-menu-type')->with('NUM_PAGE',$NUM_PAGE)
                                                                ->with('page',$page)
                                                                ->with('menu_types',$menu_types);
    }

    public function createMenuTypePost(Request $request){
        $validator = Validator::make($request->all(), $this->rules_createMenuTypePost(), $this->messages_createMenuTypePost());
        if($validator->passes()) {
            $menu_type = $request->all();
            $menu_type = MenuType::create($menu_type);
            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('image_upload/image_menu_type/', $filename);
                $path = 'image_upload/image_menu_type/'.$filename;
                $menu_type->image = $filename;
                $menu_type->save();
            }
            $request->session()->flash('alert-success', 'สร้างประเภทเมนูอาหารสำเร็จ');
            return redirect()->action('Backend\AdminController@manageMenuType');
        }
        else {
            $request->session()->flash('alert-danger', 'สร้างประเภทเมนูอาหารไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function deleteMenuType($id){
        $menu_type = MenuType::findOrFail($id);
        $menu_type->delete();
        return back();
    }

    public function updateMenuType(Request $request){
        $validator = Validator::make($request->all(), $this->rules_updateMenuType(), $this->messages_updateMenuType());
        if($validator->passes()) {
            $id = $request->get('id');
            $menu_type = MenuType::findOrFail($id);
            $menu_type->update($request->all());
            if($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('image_upload/image_menu_type/', $filename);
                $path = 'image_upload/image_menu_type/'.$filename;
                $menu_type = MenuType::findOrFail($id);
                $menu_type->image = $filename;
                $menu_type->save();
            }
            $request->session()->flash('alert-success', 'แก้ไขประเภทเมนูอาหารสำเร็จ');
            return redirect()->action('Backend\AdminController@manageMenuType');
        }
        else {
            $request->session()->flash('alert-danger', 'แก้ไขประเภทเมนูอาหารไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    // ตัวจัดการรายการเมนูอาหาร
    public function createMenu(){
        return view('backend/admin/manageMenu/create-menu');
    }

    public function createMenuPost(Request $request){
        $validator = Validator::make($request->all(), $this->rules_createMenuPost(), $this->messages_createMenuPost());
        if($validator->passes()) {
            $menu = $request->all();
            $menu = FoodMenu::create($menu);
            $menu_id = FoodMenu::orderBy('id','desc')->value('id');

            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('image_upload/image_food_menu/', $filename);
                $path = 'image_upload/image_food_menu/'.$filename;

                $image_menu = new ImageFoodMenu;
                $image_menu->menu_id = $menu_id;
                $image_menu->image = $filename;
                $image_menu->save();
            }

            $request->session()->flash('alert-success', 'เพิ่มเมนูอาหารสำเร็จ');
            return redirect()->action('Backend\AdminController@createMenu');
        }
        else {
            $request->session()->flash('alert-danger', 'เพิ่มเมนูอาหารไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function listMenu(Request $request, $store_name, $branch){
        $NUM_PAGE = 20;
        $store_id = Store::where('name',$store_name)->where('branch',$branch)->value('id');
        $food_menus = FoodMenu::where('store_id',$store_id)->orderBy('menu_type_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageMenu/list-menu')->with('NUM_PAGE',$NUM_PAGE)
                                                         ->with('page',$page)
                                                         ->with('food_menus',$food_menus);
    }

    public function deleteFoodMenu($id){
        $image = ImageFoodMenu::where('menu_id',$id)->delete();
        $food_menu = FoodMenu::findOrFail($id);
        $food_menu->delete();
        return back();
    }

    public function updateFoodMenu(Request $request){
        $validator = Validator::make($request->all(), $this->rules_updateMenu(), $this->messages_updateMenu());
        if($validator->passes()) {
            $id = $request->get('id');
            $food_menu = FoodMenu::findOrFail($id);
            $food_menu->update($request->all());
            $image_id = ImageFoodMenu::where('menu_id',$id)->value('id');
            if($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('image_upload/image_food_menu/', $filename);
                $path = 'image_upload/image_food_menu/'.$filename;
                $image_menu = ImageFoodMenu::findOrFail($image_id);
                $image_menu->image = $filename;
                $image_menu->save();
            }
            $request->session()->flash('alert-success', 'อัพเดตรายการเมนูสำเร็จ');
            return back();
        }
        else {
            $request->session()->flash('alert-danger', 'อัพเดตรายการเมนูไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    // ตัวจัดการเมนูพิเศษ
    public function createSpecialMenu(Request $request){
        $NUM_PAGE = 20;
        $special_menus = SpecialMenu::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageMenu/create-special-menu')->with('NUM_PAGE',$NUM_PAGE)
                                                                   ->with('page',$page)
                                                                   ->with('special_menus',$special_menus);
    }

    public function createSpecialMenuPost(Request $request){
        $special_menu = $request->all();
        $special_menu = SpecialMenu::create($special_menu);
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/image_special_menu/', $filename);
            $path = 'image_upload/image_special_menu/'.$filename;
            $special_menu->image = $filename;
            $special_menu->save();
        }

        $request->session()->flash('alert-success', 'เพิ่มเมนูพิเศษสำเร็จ');
        return redirect()->action('Backend\AdminController@createSpecialMenu');
    }

    public function deleteSpecialMenu($id){
        $special_menu = SpecialMenu::where('id',$id)->delete();
        return back();
    }

    public function updateSpecialMenu(Request $request){
        $id = $request->get('id');
        $special_menu = SpecialMenu::findOrFail($id);
        $special_menu->update($request->all());

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/image_special_menu/', $filename);
            $path = 'image_upload/image_special_menu/'.$filename;
            $special_menu = SpecialMenu::findOrFail($id);
            $special_menu->image = $filename;
            $special_menu->save();
        }
        $request->session()->flash('alert-success', 'อัพเดตรายการเมนูสำเร็จ');
        return back();
    }

    // ตัวจัดการราคา
    public function listMenuPrice(Request $request, $store_name, $branch){
        $NUM_PAGE = 20;
        $store_id = Store::where('name',$store_name)->where('branch',$branch)->value('id');
        $food_menus = FoodMenu::where('store_id',$store_id)->orderBy('menu_type_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageMenuPrice/menu-price')->with('NUM_PAGE',$NUM_PAGE)
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
        return view('backend/admin/manageMenuPrice/menu-price-detail')->with('NUM_PAGE',$NUM_PAGE)
                                                                      ->with('page',$page)
                                                                      ->with('prices',$prices);
    }

    public function deleteMenuPrice($id){
        $menu_price = MenuPrice::findOrFail($id);
        $menu_price->delete();
        return back();
    }

    // ตัวจัดการราคาโปรโมชั่น
    public function listMenuPricePromotion(Request $request, $store_name,$branch){
        $NUM_PAGE = 20;
        $store_id = Store::where('name',$store_name)->where('branch',$branch)->value('id');
        $food_menus = FoodMenu::where('store_id',$store_id)->orderBy('menu_type_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageMenuPricePromotion/menu-price-promotion')->with('NUM_PAGE',$NUM_PAGE)
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
        return view('backend/admin/manageMenuPricePromotion/menu-price-promotion-detail')->with('NUM_PAGE',$NUM_PAGE)
                                                                                         ->with('page',$page)
                                                                                         ->with('prices',$prices);
    }

    public function deleteMenuPricePromotion($id){
        $menu_price = MenuPricePromotion::findOrFail($id);
        $menu_price->delete();
        return back();
    }

    // ตัวจัดการเว็บไซต์

    // จัดการโลโก้เว็บไซต์
    public function manageLogoWebsite(Request $request){
        $NUM_PAGE = 20;
        $logos = ImageLogoWebsite::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageWebsite/manageLogoWebsite/create-logo-website')->with('NUM_PAGE',$NUM_PAGE)
                                                                                        ->with('page',$page)
                                                                                        ->with('logos',$logos);
    }

    public function createLogoWebsite(Request $request){
        $validator = Validator::make($request->all(), $this->rules_createLogoWebsite(), $this->messages_createLogoWebsite());
        if($validator->passes()) {
            $logo = $request->all();
            $logo = ImageLogoWebsite::create($logo);
            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('image_upload/image_logo_website/', $filename);
                $path = 'image_upload/image_logo_website/'.$filename;
                $logo->image = $filename;
                $logo->save();
            }
            $request->session()->flash('alert-success', 'อัพโหลดโลโก้เว็บไซต์สำเร็จ');
            return redirect()->action('Backend\AdminController@manageLogoWebsite');
        }
        else {
            $request->session()->flash('alert-danger', 'อัพโหลดโลโก้เว็บไซต์ไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function deleteLogoWebsite($id){
        $logo = ImageLogoWebsite::findOrFail($id);
        $logo->delete();
        return back();
    }

    public function updateLogoWebsite(Request $request){
        $id = $request->get('id');
        $logo = ImageLogoWebsite::findOrFail($id);
        $logo->update($request->all());
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/image_logo_website/', $filename);
            $path = 'image_upload/image_logo_website/'.$filename;
            $logo = ImageLogoWebsite::findOrFail($id);
            $logo->image = $filename;
            $logo->save();
        }
        return redirect()->action('Backend\AdminController@manageLogoWebsite');
    }

    // จัดการรูปภาพเว็บไซต์
    public function manageImageSlide(Request $request){
        $NUM_PAGE = 20;
        $images = ImageSlideWebsite::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageWebsite/manageImageSlide/create-image-slide')->with('NUM_PAGE',$NUM_PAGE)
                                                                                      ->with('page',$page)
                                                                                      ->with('images',$images);
    }

    public function createImageSlide(Request $request){
        $validator = Validator::make($request->all(), $this->rules_createImageSlide(), $this->messages_createImageSlide());
        if($validator->passes()) {
            $slide = $request->all();
            $slide = ImageSlideWebsite::create($slide);
            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('image_upload/image_slide_website/', $filename);
                $path = 'image_upload/image_slide_website/'.$filename;
                $slide->image = $filename;
                $slide->save();
            }
            $request->session()->flash('alert-success', 'อัพโหลดรูปภาพสไลด์สำเร็จ');
            return redirect()->action('Backend\AdminController@manageImageSlide');
        }
        else {
            $request->session()->flash('alert-danger', 'อัพโหลดรูปภาพสไลด์ไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function deleteImageSlide($id){
        $slide = ImageSlideWebsite::findOrFail($id);
        $slide->delete();
        return back();
    }

    public function updateImageSlide(Request $request){
        $id = $request->get('id');
        $slide = ImageSlideWebsite::findOrFail($id);
        $slide->update($request->all());
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/image_slide_website/', $filename);
            $path = 'image_upload/image_slide_website/'.$filename;
            $slide = ImageSlideWebsite::findOrFail($id);
            $slide->image = $filename;
            $slide->save();
        }
        return redirect()->action('Backend\AdminController@manageImageSlide');
    }

    // จัดการรูปภาพแกลอรี่
    public function manageImageGallery(Request $request){
        $NUM_PAGE = 20;
        $gallerys = ImageGallery::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageWebsite/manageImageGallery/create-image-gallery')->with('NUM_PAGE',$NUM_PAGE)
                                                                                          ->with('page',$page)
                                                                                          ->with('gallerys',$gallerys);
    }

    public function createImageGallery(Request $request){
        $validator = Validator::make($request->all(), $this->rules_createImageGallery(), $this->messages_createImageGallery());
        if($validator->passes()) {
            $gallery = $request->all();
            $gallery = ImageGallery::create($gallery);
            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('image_upload/image_gallery/', $filename);
                $path = 'image_upload/image_gallery/'.$filename;
                $gallery->image = $filename;
                $gallery->save();
            }
            $request->session()->flash('alert-success', 'อัพโหลดรูปภาพแกลอรี่สำเร็จ');
            return redirect()->action('Backend\AdminController@manageImageGallery');
        }
        else {
            $request->session()->flash('alert-danger', 'อัพโหลดรูปภาพแกลอรี่ไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function deleteImageGallery($id){
        $gallery = ImageGallery::findOrFail($id);
        $gallery->delete();
        return back();
    }

    public function updateImageGallery(Request $request){
        $id = $request->get('id');
        $gallery = ImageGallery::findOrFail($id);
        $gallery->update($request->all());
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/image_gallery/', $filename);
            $path = 'image_upload/image_gallery/'.$filename;
            $gallery = ImageGallery::findOrFail($id);
            $gallery->image = $filename;
            $gallery->save();
        }
        return redirect()->action('Backend\AdminController@manageImageGallery');
    }

    // จัดการ Blog
    public function manageBlog(Request $request){
        $NUM_PAGE = 20;
        $blogs = Blog::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageWebsite/manageBlog/create-blog')->with('NUM_PAGE',$NUM_PAGE)
                                                                         ->with('page',$page)
                                                                         ->with('blogs',$blogs);
    }

    public function createBlog(Request $request){
        $validator = Validator::make($request->all(), $this->rules_createBlog(), $this->messages_createBlog());
        if($validator->passes()) {
            $blog = $request->all();
            $blog = Blog::create($blog);
            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('image_upload/image_blog/', $filename);
                $path = 'image_upload/image_blog/'.$filename;
                $blog->image = $filename;
                $blog->save();
            }
            $request->session()->flash('alert-success', 'อัพโหลด Blog สำเร็จ');
            return redirect()->action('Backend\AdminController@manageBlog');
        }
        else {
            $request->session()->flash('alert-danger', 'อัพโหลด Blog ไม่สำเร็จ');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function deleteBlog($id){
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return back();
    }

    public function updateBlog(Request $request){
        $id = $request->get('id');
        $blog = Blog::findOrFail($id);
        $blog->update($request->all());
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/image_blog/', $filename);
            $path = 'image_upload/image_blog/'.$filename;
            $blog = Blog::findOrFail($id);
            $blog->image = $filename;
            $blog->save();
        }
        return redirect()->action('Backend\AdminController@manageBlog');
    }

    public function order(Request $request,$store_name,$branch){
        $NUM_PAGE = 50;
        $store_id = Store::where('name',$store_name)->where('branch',$branch)->value('id');
        $orders = Order::groupBy('bill_number')->where('store_id',$store_id)->orderBy('id','desc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/manageOrder/order')->with('NUM_PAGE',$NUM_PAGE)
                                                      ->with('page',$page)
                                                      ->with('orders',$orders);
    }

    public function orderDetail($id){
        $order = Order::findOrFail($id);
        return view('backend/admin/manageOrder/order-detail')->with('order',$order);
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
        return redirect()->action('Backend\AdminController@order');
    }

    public function message(Request $request, $store_name, $branch){
        $NUM_PAGE = 50;
        $store_id = Store::where('name',$store_name)->where('branch',$branch)->value('id');
        $messages = Contact::where('store_id',$store_id)->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/contact/message')->with('page',$page)
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

    // คูปองส่วนลด
    public function createCoupon(Request $request){
        $NUM_PAGE = 50;
        $random = Str::random(7);
        $coupons = Coupon::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/coupon/create-coupon')->with('random',$random)
                                                         ->with('coupons',$coupons)
                                                         ->with('page',$page)
                                                         ->with('NUM_PAGE',$NUM_PAGE);
    }

    public function uploadCoupon(Request $request){
        $coupon = $request->all();
        $coupon = Coupon::create($coupon);
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/image_coupon/', $filename);
            $path = 'image_upload/image_coupon/'.$filename;
            $coupon->image = $filename;
            $coupon->save();
        }
        return back();
    }

    public function applyWork(Request $request, $url_name) {
        $NUM_PAGE = 20;
        $branch_id = UrlApplyWork::where('url_name',$url_name)->value('id');
        $apply_works = ApplyWork::where('branch_id',$branch_id)->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/apply/apply-work')->with('NUM_PAGE',$NUM_PAGE)
                                                     ->with('page',$page)
                                                     ->with('apply_works',$apply_works);
    }

    public function urlApplyWork(Request $request) {
        $NUM_PAGE = 20;
        $url_apply_works = UrlApplyWork::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/apply/url-apply-work')->with('NUM_PAGE',$NUM_PAGE)
                                                         ->with('page',$page)
                                                         ->with('url_apply_works',$url_apply_works);
    }

    public function urlApplyWorkPost(Request $request){
        $url = $request->all();
        $url = UrlApplyWork::create($url);
        return back();
    }

    public function openPdfResume($id) {
        $pdf = ApplyWork::select('performance')->where('id', $id)->value('performance');
        
        // $filename = "/public/file_upload/performance/".$pdf;
        $filename = "../file_upload/performance/".$pdf; //in server
        $path = base_path($filename);
        $contentType = mime_content_type($path);
        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }

    /////////////////////////////// validate ///////////////////////////////
    public function rules_createSeller() {
        return [
            'name' => 'required',
            'phone' => 'required',
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function messages_createSeller() {
        return [
            'name.required' => 'กรุณากรอกชื่อ',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'username.required' => 'กรุณากรอกชื่อเข้าใช้งาน (ภาษาอังกฤษ)',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ];
    }

    public function rules_updateSeller() {
        return [
            'name' => 'required',
            'phone' => 'required',
            'username' => 'required',
        ];
    }

    public function messages_updateSeller() {
        return [
            'name.required' => 'กรุณากรอกชื่อ',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'username.required' => 'กรุณากรอกชื่อเข้าใช้งาน (ภาษาอังกฤษ)',
        ];
    }

    public function rules_createStorePost() {
        return [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'logo' => 'required',
        ];
    }

    public function messages_createStorePost() {
        return [
            'name.required' => 'กรุณากรอกชื่อร้านค้า',
            'address.required' => 'กรุณากรอกที่อยู่ร้านค้า',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์ร้านค้า',
            'logo.required' => 'กรุณาแนบไฟล์โลโก้ร้านค้า',
        ];
    }

    public function rules_updateStore() {
        return [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ];
    }

    public function messages_updateStore() {
        return [
            'name.required' => 'กรุณากรอกชื่อร้านค้า',
            'address.required' => 'กรุณากรอกที่อยู่ร้านค้า',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์ร้านค้า',
        ];
    }

    public function rules_updateCustomer() {
        return [
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
        ];
    }

    public function messages_updateCustomer() {
        return [
            'name.required' => 'กรุณากรอกชื่อ',
            'surname.required' => 'กรุณากรอกนามสกุล',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์',
        ];
    }

    public function rules_createMenuTypePost() {
        return [
            'menu_type' => 'required',
        ];
    }

    public function messages_createMenuTypePost() {
        return [
            'menu_type.required' => 'กรุณากรอกประเภทเมนูอาหาร',
        ];
    }

    public function rules_updateMenuType() {
        return [
            'menu_type' => 'required',
        ];
    }

    public function messages_updateMenuType() {
        return [
            'menu_type.required' => 'กรุณากรอกประเภทเมนูอาหาร',
        ];
    }

    public function rules_createMenuPost() {
        return [
            'thai_name' => 'required',
            'eng_name' => 'required',
            'image' => 'required',
        ];
    }

    public function messages_createMenuPost() {
        return [
            'thai_name.required' => 'กรุณากรอกชื่อเมนูอาหาร (ภาษาไทย)',
            'eng_name.required' => 'กรุณากรอกชื่อเมนูอาหาร (ภาษาอังกฤษ)',
            'image.required' => 'กรุณาแนบไฟล์เมนูอาหาร',
        ];
    }

    public function rules_updateMenu() {
        return [
            'thai_name' => 'required',
            'eng_name' => 'required',
        ];
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

    public function rules_createLogoWebsite() {
        return [
            'image' => 'required',
        ];
    }

    public function messages_createLogoWebsite() {
        return [
            'image.required' => 'กรุณาแนบไฟล์โลโก้เว็บไซต์',
        ];
    }

    public function rules_createImageSlide() {
        return [
            'image' => 'required',
        ];
    }

    public function messages_createImageSlide() {
        return [
            'image.required' => 'กรุณาแนบไฟล์รูปภาพสไลด์',
        ];
    }

    public function rules_createImageGallery() {
        return [
            'image' => 'required',
        ];
    }

    public function messages_createImageGallery() {
        return [
            'image.required' => 'กรุณาแนบไฟล์รูปภาพแกลอรี่',
        ];
    }

    public function rules_createBlog() {
        return [
            'thai_name' => 'required',
            'eng_name' => 'required',
            'image' => 'required',
        ];
    }

    public function messages_createBlog() {
        return [
            'thai_name.required' => 'กรุณากรอกเมนู (ภาษาไทย)',
            'eng_name.required' => 'กรุณากรอกเมนู (ภาษาอังกฤษ)',
            'image.required' => 'กรุณาแนบไฟล์รูปภาพ',
        ];
    }
}
