<?php

namespace App\Http\Controllers;

use App\Models\Asset_manager;
use App\Models\Asset_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class Add_Asset_Controller extends Controller
{
    public function AddAsset(){

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . ' Add Asset Page Access');
        return view('add_asset');

    }
    public function AddAssetData(Request $request, $asset_master_id){

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . ' Add Asset Data  function Access');

        $data = DB::table('asset_masters as am')
        ->select('asset_details','asset_master_id','asset_name')
        ->where('asset_master_id', $asset_master_id)
        ->get();

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . $data);

        // echo "###".$data."###"; exit;

        return view('add_asset', compact('data'));

    }


    public function SaveAssetData(Request $request)
    {
        // Validate the request input
        $request->validate([
            'asset_master_id' => 'required|integer',
            'asset_details' => 'required|array',
        ]);
    
        // Fetch the asset by asset_master_id
        $id = $request->input('asset_master_id');
        $Asset_data = Asset_master::where('asset_master_id', $id)->first();

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . $Asset_data);
    
        if ($Asset_data) {
            // Get the existing asset details and decode it to an array
            $existingDetails = json_decode($Asset_data->asset_details, true) ?? [];
        
            // Define the input array
            $inputArray = $request->input('asset_details');
        
            // Merge the input array with the existing array
            $mergedDetails = array_merge($existingDetails, $inputArray);
        
            // Remove duplicates from the merged array
            // Assuming each detail is a unique associative array or scalar value
            $mergedDetails = array_map('unserialize', array_unique(array_map('serialize', $mergedDetails)));
        
            // Update the asset_details column with the merged array, encoded as JSON
            $Asset_data->asset_details = json_encode($mergedDetails);
        
            Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($mergedDetails));
        
            // Save the changes to the database
            $Asset_data->save();
        
            return redirect()->route('asset_list');
        } else {
            return view('asset_list')->with('error', 'Asset not found.');
        }
        
    }
    

}
