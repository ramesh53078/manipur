<?php

namespace App\Http\Controllers\Admin;

use App\Admin\LargeVideoWall;
use App\Admin\TimeWall;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Hash;
use App\User;
use App\Admin\Admin;
use App\Admin\Feedback;
use DataTables;
class DashboardController extends Controller
{
    public function index()
    {
        $timeWall = TimeWall::count();
        $largeVideoWall = LargeVideoWall::count();
        return view('admin.dashboard',[
            'timeWall' => $timeWall,
            'largeVideoWall' => $largeVideoWall
        ]);
    }

    public function changePassword(Request $request)
    {
        return view('admin.changePassword');
    }

    public function updateProfilePassword(Request $request)
    {
            $user_id = Auth::guard('admin')->user()->id;
            $user = Admin::findOrFail($user_id);
            $this->validate($request, [
                'old_password' => 'required',
                'new_password' => 'min:8|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'required|min:8'
            ]);

        if (Hash::check($request->old_password, $user->password)) {
        $user->fill([
            'password' => Hash::make($request->new_password)
            ])->save();


        $request->session()->flash('success', 'Password changed');
                return redirect('admin/dashboard');

        } else {
                
                return back()->with('error','Old Password Not Matching Our Records');
        }
    }

    public function updateProfile(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z ]+$/',
            'email' => 'required|email'
        ]);

        try {
            $user_id = Auth::guard('admin')->user()->id;
            $user = Admin::where(['id' => $user_id])->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            if($user){

                return redirect('admin/dashboard')->with('success','Successfully Updated');
            }else{
                return redirect()->back()->with('error','Something Went Wrong Try Again');
            }
        } catch (\Exception $e) {

            return back()->with('error',$e->getMessage());
        }
    }

    public function employeeList(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('user_type','employee')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return Str::title($row->name);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('M d, Y/h.ia');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->created_at->format('M d, Y/h.ia');
                })
                   ->rawColumns(['name','created_at','updated_at'])
                ->make(true);
        }

        return view('admin.employeeList');
    }

    public function vistorList(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('user_type','visitor')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return Str::title($row->name);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('M d, Y/h.ia');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->created_at->format('M d, Y/h.ia');
                })
                   ->rawColumns(['name','created_at','updated_at'])
                ->make(true);
        }

        return view('admin.visitorsList');
    }

    public function feedbackList(Request $request)
    {
        if ($request->ajax()) {
            $data = Feedback::with('user')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return Str::title($row->user->name);
                })
                ->addColumn('description', function ($row) {
                    return Str::title($row->description);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('M d, Y/h.ia');
                })
                   ->rawColumns(['name','description','created_at'])
                ->make(true);
        }

        return view('admin.feedbackList');
    }
}
