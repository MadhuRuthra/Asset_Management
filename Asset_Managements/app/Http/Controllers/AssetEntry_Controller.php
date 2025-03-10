<?php

namespace App\Http\Controllers;

use App\Models\Asset_manager;
use App\Models\Asset_propertie;
use App\Models\Asset_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AssetEntry_Controller extends Controller
{
    public function AssetEntry(){
        Log::channel('daily')->info(now() . '-' . Auth::user()->name . 'Asset Entry Function access');
        return view('asset_entry');
    }

    public function NewAssetEntry(Request $request){

        $userId = auth()->user()->id;
        $asset_master_id = $request->input('selected_asset');
        $remarks = $request->input('remarks');
        $assigned_to = $request->input('assigned_to');
        $asset_serial_no = $request->input('asset_serial_no');
        $asset_model_name = $request->input('asset_model_name');
        $asset_brand = $request->input('asset_brand');
        $purchase_date = $request->input('asset_purchase_date');
        $formattedDate = date('Y-m-d H:i:s', strtotime($purchase_date));

        $current_time = date("Y-m-d H:i:s");

        $data = $request->all();

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($data));


        $asset_assign = array(
            'asset_master_id' => $asset_master_id,
            'user_id' => auth()->user()->id,
            'assigned_entry_date' => $current_time,
            'assigned_status' => 'Y',
            'assigned_modified_date' => $current_time,
            'assigned_to' => $assigned_to,
            'remarks' => $remarks,
            'asset_serial_no' => $asset_serial_no,
            'asset_modal_name' => $asset_model_name,
            'asset_brand' => $asset_brand,
            'purchase_date' => $formattedDate,
        );

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($asset_assign));

        $msg = 'Asset Manager Entry Stored Successfully';

        $assign_id = DB::table('asset_managers')->insertGetId($asset_assign);


  

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($asset_assign));

        // echo "###".$data."###"; exit;

        foreach ($data as $key => $value) {
            // Skip the _token key and other specified keys
            if ($key === '_token' || $key === 'assigned_to' || $key === 'remarks' || $key === 'selected_asset') {
                continue;
            }

            // Check if the record already exists
            $existingRecord = Asset_propertie::where('asset_manager_id', $assign_id)
                ->where('feature_input', $value)
                ->first();

            $asset_manager_id =$assign_id;
            // If no existing record is found, create a new one
            if (!$existingRecord) {

                Asset_propertie::create([
                    'user_id' => $userId,
                    'asset_manager_id' => $asset_manager_id,
                    'feature_name' => $key,
                    'feature_input' => $value,
                    'feature_status' => 'Y',
                    'feature_entry_date' => $current_time,
                    'feature_modified_date' => $current_time
                ]);
            }

        }


        $msg = 'New Asset Entry Stored Successfully';

        return Redirect::to('asset_entry')->with('success', $msg);
        
    }

    public function getAssetsByType(Request $request)
    {
    $asset_master_id = $request->input('asset_type');

    // echo "".$asset_master_id.""; exit;
    
    $assetMasters = Asset_master::where('asset_status', 'S')
        ->where('asset_master_id', $asset_master_id)
        ->select('asset_details')
        ->get();

    Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($assetMasters));

    return response()->json($assetMasters);
    }


    public function GenerateSerialNo(Request $request)
    {
    $asset_master_id = $request->input('asset_id');

    $serial_name_record = DB::table('asset_masters')
    ->select('asset_serial_name')
    ->where('asset_master_id', $asset_master_id)
    ->first();

    Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($serial_name_record));

    // Ensure $serial_name_record is not null before accessing the property
    $serial_name = $serial_name_record ? $serial_name_record->asset_serial_name : '';

    $serialNumbers = DB::table('asset_managers')
    ->select('asset_serial_no')
    ->get();

    $numericValues = $serialNumbers->map(function ($item) {
        return preg_replace('/\D/', '', $item->asset_serial_no);
    });

    // Convert the numeric values to integers
    $numericValues = $numericValues->map(function ($value) {
        return (int) $value;
    });

    // Find the maximum value
    $max_id = $numericValues->max();

    Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($max_id));

    // If max_id is 0, start from 1
        if ($max_id === 0) {
            $next_id = 1;
        } else {
            $next_id = $max_id + 1;
        }

    Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($next_id));

    // Concatenate the serial name with the max_id
    $serial_no = $serial_name.$next_id;

    Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($serial_no));

    return response()->json($serial_no);
    }
}
