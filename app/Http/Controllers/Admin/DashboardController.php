<?php

namespace App\Http\Controllers\Admin;

use App\Admin\LargeVideoWall;
use App\Admin\TimeWall;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\User;
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
            $user_id = Auth::user()->id;
            $user = User::findOrFail($user_id);
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
            $user_id = Auth::user()->id;
            $user = User::findOrFail($user_id);
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
            ]);

    
        $user->fill([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            ])->save();


        $request->session()->flash('success', 'Profile Updated Successfully');
                return redirect('admin/dashboard');
    }
}
