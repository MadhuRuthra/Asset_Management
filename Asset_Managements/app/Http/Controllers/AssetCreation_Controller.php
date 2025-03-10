<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AssetCreation_Controller extends Controller
{
    public function AssetCreation(){
        Log::channel('daily')->info(now() . '-' . Auth::user()->name .'Asset Creation page access');
        return view('asset_creation');
    }

    public function SaveAsset(Request $request){


        $userId = auth()->user()->id;
        $asset_name = $request->input('asset_name');
        $asset_serial_name = $request->input('asset_serial_name');
        $current_time = date("Y-m-d H:i:s");
        $asset_details = $request->input('asset_details');
        $remarks = $request->input('remarks');
        $current_time = date("Y-m-d H:i:s");
        $jsonData = json_encode($asset_details);

        $existing_data = DB::table('asset_masters')
            ->where('asset_name','=', $asset_name)
            ->orWhere('asset_serial_name','=','YJ'.strtoupper($asset_serial_name))
            ->orWhere('asset_status','=','Y')        
            ->exists();

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($existing_data));

        if($existing_data){

            $msg = 'That Asset Already Exist!';

            return Redirect::to('asset_creation')->with('success', $msg);
        }

        if($asset_name != ''){

        $asset_data = array(

            'user_id' => $userId,
            'asset_name' => $asset_name,
            'asset_serial_name' => 'YJ'.strtoupper($asset_serial_name),
            'asset_details' => $jsonData,
            'asset_status' => 'S',
            'asset_entry_date' => $current_time,
            'asset_modified_date' => $current_time

        );
    
        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($asset_data));

        $asset_id = DB::table('asset_masters')->insertGetId($asset_data);

        }

        
        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($jsonData));
        // echo '###'.json_encode($asset_details).'###'.$asset_master_id.''; exit;


        $msg = 'New Asset Entry Stored Successfully';

        return Redirect::to('asset_creation')->with('success', $msg);
    }
}
