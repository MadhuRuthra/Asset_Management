<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashboard_Controller extends Controller
{
   public function DashboardDisplay(Request $request){
        return view('dashboard');
   }
}
