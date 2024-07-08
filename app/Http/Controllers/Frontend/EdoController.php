<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\Contact;
use App\model\FoodMenu;
use App\model\MenuType;
use App\model\Store;
use App\model\SpecialMenu;
use App\model\CustomerReview;
use App\model\ApplyWork;

use DB;

use Validator;

class EdoController extends Controller
{
    // public function indexPage(){
    //     $store_id = Store::where('branch','official')->where('status','เปิด')->value('id');
    //     return redirect()->action('Frontend\EdoController@edoStore', ['store_id' => $store_id]);
    // }

    public function indexPage(){
        return view('frontend/edoStore/store');
    }

    public function contactUs(){
        return view('frontend/contact/contact-us');
    }

    public function contactUsPost(Request $request){
        $validator = Validator::make($request->all(), $this->rules_contactUsPost(), $this->messages_contactUsPost());
        if($validator->passes()) {
            $store_id = $request->get('store_id');
            $message = $request->all();
            $message = Contact::create($message);
            $request->session()->flash('alert-success', 'ส่งข้อความติดต่อสำเร็จ');
            
            $store_mail = Store::where('id',$store_id)->value('mail');
            
            $subject = $request->get('subject');
            $message_contact = $request->get('message');
            $phone = $request->get('tel');
            $store_name = Store::where('id',$store_id)->value('name');

            $details = [
                'subject' => $subject,
                'phone' => $phone,
                'message_contact' => $message_contact,
                'store_name' => $store_name,
            ];
            \Mail::to($store_mail)->send(new \App\Mail\ContactMail($details));

            return back();
        }
        else {
            $request->session()->flash('alert-danger', 'ส่งข้อความติดต่อไม่สำเร็จ กรุณากรอกข้อมูลให้ครบถ้วน');
            return back()->withErrors($validator)->withInput(); 
        }
    }

    public function categoryMenu(){ 
        return view('frontend/menu/category-menu');
    }

    public function categoryMenuType($menu_type){ 
        $menu_type_id = MenuType::where('menu_type_eng',$menu_type)->value('id');
        $menus = FoodMenu::where('menu_type_id',$menu_type_id)->where('status',"เปิด")->get();
        return view('frontend/menu/category-menu-type')->with('menus',$menus)
                                                       ->with('menu_type',$menu_type);
    }

    public function gallery(){
        return view('frontend/edoStore/gallery');
    }

    public function blog(){
        return view('frontend/edoStore/blog');
    }

    public function review(){
        return view('frontend/edoStore/review');
    }

    public function menu(){
        return view('frontend/menu/menu');
    }

    public function specialMenu(){
        $special_menus = SpecialMenu::orderBy('id', 'desc')->get();
        return view('frontend/menu/special-menu')->with('special_menus',$special_menus);
    }

    public function customerReview($branch_name){
    	return view('frontend/edoStore/customer-review')->with('branch_name',$branch_name);
    }

    public function customerReviewPost(Request $request){
        $review = $request->all();
        $review = CustomerReview::create($review);
        return redirect()->action('Frontend\EdoController@customerReviewSuccess');
    }

    public function customerReviewSuccess(){
    	return view('frontend/edoStore/customer-review-success');
    }

    public function customerFeedback(){
        $branchs = CustomerReview::groupBy('branch_name')->get();
    	return view('frontend/edoStore/customer-feedback')->with('branchs',$branchs);
    }

    public function customerFeedbackDetail(Request $request, $branch_name){
        $NUM_PAGE1 = 20;
        $NUM_PAGE2 = 20;
        $feedbacks = CustomerReview::where('branch_name',$branch_name)
                                    ->whereIn('feedback',['1','2','3'])
                                    ->paginate(20, ['*'], 'feedbacks');

        $allfeedbacks = CustomerReview::where('branch_name',$branch_name)->paginate(20, ['*'], 'allfeedbacks');

        $page = $request->input('page');
        $page = ($page != null)?$page:1;
    	return view('frontend/edoStore/customer-feedback-detail')->with('NUM_PAGE1',$NUM_PAGE1)
                                                                 ->with('NUM_PAGE2',$NUM_PAGE2)
                                                                 ->with('page',$page)
                                                                 ->with('feedbacks',$feedbacks)
                                                                 ->with('allfeedbacks',$allfeedbacks)
                                                                 ->with('branch_name',$branch_name);
    }

    public function applyWork($branch_name) {
        return view('frontend/apply/apply-work')->with('branch_name',$branch_name);
    }

    public function applyWorkPost(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_applyWorkPost(), $this->messages_applyWorkPost());
        if($validator->passes()) {
            $apply_request = $request->all();
            $apply = ApplyWork::create($apply_request);
            if($request->hasFile('performance')){
                $performance = $request->file('performance');
                $filename = md5(($performance->getClientOriginalName(). time()) . time()) . "_o." . $performance->getClientOriginalExtension();
                $performance->move('file_upload/performance/', $filename);
                $path = 'file_upload/performance/'.$filename;
                $apply->performance = $filename;
                $apply->save();
            }
            if($request->hasFile('facebook')){
                $facebook = $request->file('facebook');
                $filename = md5(($facebook->getClientOriginalName(). time()) . time()) . "_o." . $facebook->getClientOriginalExtension();
                $facebook->move('file_upload/facebook/', $filename);
                $path = 'file_upload/facebook/'.$filename;
                $apply->facebook = $filename;
                $apply->save();
            }
            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('file_upload/image/', $filename);
                $path = 'file_upload/image/'.$filename;
                $apply->image = $filename;
                $apply->save();
            }
            return view('frontend/apply/apply-success');
        }
        else {
                $request->session()->flash('alert-danger', 'ส่งใบสมัครไม่สำเร็จ กรุณาตรวจสอบข้อมูลให้ถูกต้องครบถ้วน');
                return back()->withErrors($validator)->withInput(); 
            }
    }

    public function voucherCard(){
        return view('frontend/voucher-card');
    }


    // Validate
    public function rules_contactUsPost() {
        return [
            'tel' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ];
    }

    public function messages_contactUsPost() {
        return [
            'tel.required' => 'กรุณากรอกหมายเลขโทรศัพท์',
            'subject.required' => 'กรุณากรอกหัวข้อเรื่องที่จะติดต่อ',
            'message.required' => 'กรุณากรอกข้อความที่ต้องการติดต่อ',
        ];
    }

    public function rules_applyWorkPost() {
        return [
            'salary' => 'required',
            'card_id' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'age' => 'required',
            'tel' => 'required',
            'history_work' => 'required',
            'performance' => 'required',
            'facebook' => 'required',
            'image' => 'required',
        ];
    }

    public function messages_applyWorkPost() {
        return [
            'salary.required' => 'กรุณากรอกเงินเดือนที่ต้องการ',
            'card_id.required' => 'กรุณากรอกหมายเลขบัตรประชาชน',
            'name.required' => 'กรุณากรอกชื่อผู้สมัคร',
            'surname.required' => 'กรุณากรอกนามสกุลผู้สมัคร',
            'age.required' => 'กรุณากรอกอายุ',
            'tel.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'history_work.required' => 'กรุณากรอกประวัติการทำงาน',
            'performance.required' => 'กรุณาอัพโหลดไฟล์เอกสาร ผลงาน',
            'facebook.required' => 'อัพโหลดรูปภาพหน้า Facebook ให้ติดชื่อเฟส',
            'image.required' => 'กรุณาอัพโหลดรูปภาพปัจจุบัน',
        ];
    }
}
