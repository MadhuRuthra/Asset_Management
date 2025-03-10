<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class AssetManagerEntry_Controller extends Controller
{
    public function AssetManagerEntry(){

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . 'Asset ManagerEntry page Access');
        return view('asset_manager_entry');
    }

    public function SaveManagerEntry(Request $request){
        

        $asset_details = $request->input('asset_details');
        $asset_master_id = $request->input('selected_asset');
        $remarks = $request->input('remarks');
        $current_time = date("Y-m-d H:i:s");
        $jsonData = json_encode($asset_details);

 
        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($jsonData));
        // echo '###'.json_encode($asset_details).'###'.$asset_master_id.''; exit;

        $assigned_data = array(
            'asset_master_id' => $asset_master_id,
            'user_id' => auth()->user()->id,
            'asset_details' => $jsonData,
            'assigned_entry_date' => $current_time,
            'assigned_status' => 'Y',
            'assigned_modified_date' => $current_time,
            'remarks' => $remarks
        );

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($assigned_data));

        $asset_sts = array(
            'asset_status' => 'S',
        );

        $msg = 'Asset Manager Entry Stored Successfully';

        $assign_id = DB::table('asset_managers')->insertGetId($assigned_data);

        $asset_id = DB::table('asset_masters')->where('asset_master_id', $asset_master_id)->update($asset_sts);

        return Redirect::to('asset_manager_entry')->with('success', $msg);
    }
}
