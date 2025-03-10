<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Change_Password_Controller extends Controller
{
    public function changepassword(){
        return view('auth.changepassword');
    }

    public function validateOldPassword(Request $request)
{
    $request->validate([
        'old_password' => 'required|string|min:8',
    ]);

    $oldPassword = $request->old_password;
    $currentPassword = auth()->user()->password; // Assuming you use the authenticated user's password

    if (Hash::check($oldPassword, $currentPassword)) {
        return response()->json(['valid' => true]);
    } else {
        return response()->json(['valid' => false]);
    }
}

    public function ChangePasswordSave(Request $request){

        $new_password = $request->input('new_password');

        $confirm_password = $request->input('confirm_password');

        $Auth_id = auth()->id();

        $hashed_pass = hash::make($new_password); 

        DB::table('users')->where('id', $Auth_id)->update(['password' => $hashed_pass]);
        
        return redirect()->route('login')->with('status', 'Password changed successfully.');
    }


}
