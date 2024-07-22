<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\model\Audit;
use App\model\CheckListAudit;

use Validator;
use DB;

class AuditController extends Controller
{
    public function auditCheckList() {
        return view('frontend/audit/index');
    }

    public function auditCheckListByBranch(Request $request, $branch_id) {
        $NUM_PAGE = 20;
        $checklists = Audit::where('branch_id',$branch_id)->orderBy('number','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('frontend/audit/checklist')->with('NUM_PAGE',$NUM_PAGE)
                                               ->with('page',$page)
                                               ->with('branch_id',$branch_id)
                                               ->with('checklists',$checklists);
    }

    public function checkListAudit(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_checkListAudit(), $this->messages_checkListAudit());
        if($validator->passes()) {

            $checklists = $request->get('checklist');  
            $comments = $request->get('comment');  
            $images = $request->file('image');  

            foreach($checklists as $key => $value) {
                $branch_id = $request->get('branch_id');
                $list_id = $key;
                $checklist = $value;
                $date = $request->get('date');
                $comment_detail = $request->get('comment_detail');

                $audit_checklist = new CheckListAudit;
                $audit_checklist->branch_id = $branch_id;
                $audit_checklist->list_id = $list_id;
                $audit_checklist->checklist = $checklist;
                $audit_checklist->date = $date;
                $audit_checklist->comment_detail = $comment_detail;
                for($i=0; $i<count($comments); $i++) {
                    $audit_checklist->comment = $comments[$key];
                }

                if($request->hasFile('image')){
                    for($i=0; $i<count($images); $i++) {
                        // $audit_checklist->image = $images[$key];
                        $filename = md5(($images[1]->getClientOriginalName(). time()) . time()) . "_o." . $images[1]->getClientOriginalExtension();
                        // $images[$key]->move('file_upload/image_audit/', $filename);
                        $path = 'file_upload/image_audit/'.$filename;
                        $audit_checklist->image = $filename;
                        
                        // if($request->hasFile('image')){
                        //     $filename = md5(($images[$key]->getClientOriginalName(). time()) . time()) . "_o." . $images[$key]->getClientOriginalExtension();
                        //     $images[$key]->move('file_upload/image_audit/', $filename);
                        //     $path = 'file_upload/image_audit/'.$filename;
                        //     $audit_checklist->image = $filename[$key];
                        //     $audit_checklist->save();
                        // }

                    }
                }
                
                $audit_checklist->save();
                
            }

            $request->session()->flash('alert-success', 'บันทึกข้อมูลสำเร็จ');
            return back()->withErrors($validator)->withInput(); 
        }
        else {
            $request->session()->flash('alert-danger', 'บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลให้ถูกต้องครบถ้วน');
            return back()->withErrors($validator)->withInput(); 
        }
        // $validator = Validator::make($request->all(), $this->rules_checkListAudit(), $this->messages_checkListAudit());
        // if($validator->passes()) {

        //     $checklists = $request->all();  
        //     $comments = $request->get('comment');  
        //     foreach($checklists['checklist'] as $key => $value) {
        //         foreach($comments as $key1 => $value1) {
        //             $comment[] = $value1;
        //         }
                
        //         $branch_id = $request->get('branch_id');
        //         $list_id = $key;
        //         $checklist = $value;
        //         $date = $request->get('date');
                
        //         $audit_checklist = new CheckListAudit;
        //         $audit_checklist->branch_id = $branch_id;
        //         $audit_checklist->list_id = $list_id;
        //         $audit_checklist->checklist = $checklist;
        //         for($i=0; $i<count($comment); $i++) {
        //             $audit_checklist->comment = $comment[0];
        //         }
                
        //         $audit_checklist->date = $date;

        //             if($request->hasFile('image')){
        //                 $audit_checklist = $request->file('image');
        //                 $filename = md5(($audit_checklist->getClientOriginalName(). time()) . time()) . "_o." . $audit_checklist->getClientOriginalExtension();
        //                 $audit_checklist->move('file_upload/image_audit/', $filename);
        //                 $path = 'file_upload/image_audit/'.$filename;
        //                 $audit_checklist->image = $filename;
        //                 $audit_checklist->save();
        //             }

        //         $audit_checklist->save();
        //     }

            
        //     $request->session()->flash('alert-success', 'บันทึกข้อมูลสำเร็จ');
        //     return back()->withErrors($validator)->withInput(); 
        // }
        // else {
        //     $request->session()->flash('alert-danger', 'บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลให้ถูกต้องครบถ้วน');
        //     return back()->withErrors($validator)->withInput(); 
        // }
    }

    public function resultAuditCheckListByBranch(Request $request, $branch_id) {
        $NUM_PAGE = 20;
        $years = checkListAudit::select(DB::raw('YEAR(created_at) year'))
                            ->where('branch_id',$branch_id)
                            ->groupBy('year')
                            ->orderBy('id','asc')
                            ->get();
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('frontend/audit/result-audit')->with('NUM_PAGE',$NUM_PAGE)
                                                  ->with('page',$page)
                                                  ->with('branch_id',$branch_id)
                                                  ->with('years',$years);
    }

    public function resultAuditByYear(Request $request, $branch_id, $year) {
        $NUM_PAGE = 20;
        $months = checkListAudit::select(DB::raw('MONTH(created_at) month'))
                            ->where('branch_id',$branch_id)
                            ->groupBy('month')
                            ->orderBy('id','asc')
                            ->get();
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('frontend/audit/result-audit-by-month')->with('NUM_PAGE',$NUM_PAGE)
                                                          ->with('page',$page)
                                                          ->with('branch_id',$branch_id)
                                                          ->with('months',$months)
                                                          ->with('year',$year);
    }

    public function resultAuditByMonth(Request $request, $branch_id, $year, $month) {
        $NUM_PAGE = 20;
        $days = checkListAudit::where('branch_id',$branch_id)
                            ->groupBy('date')
                            ->orderBy('id','asc')
                            ->get();
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('frontend/audit/result-audit-by-date')->with('NUM_PAGE',$NUM_PAGE)
                                                          ->with('page',$page)
                                                          ->with('branch_id',$branch_id)
                                                          ->with('days',$days)
                                                          ->with('month',$month)
                                                          ->with('year',$year);
    }

    public function resultAuditDetail(Request $request, $branch_id, $date) {
        $NUM_PAGE = 20;
        $results = checkListAudit::where('branch_id',$branch_id)
                                 ->where('date',$date)
                                 ->orderBy('id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('frontend/audit/result-audit-detail')->with('NUM_PAGE',$NUM_PAGE)
                                                         ->with('page',$page)
                                                         ->with('branch_id',$branch_id)
                                                         ->with('date',$date)
                                                         ->with('results',$results);
    }

    // Validate
    public function rules_checkListAudit() {
        return [
            'checklist' => 'required',
        ];
    }

    public function messages_checkListAudit() {
        return [
            'checklist.required' => 'กรุณากรอกข้อมูล',
        ];
    }
}
