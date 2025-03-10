<?php

namespace App\Http\Controllers;

use App\Models\Asset_manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Asset_propertie;

class EditAsset_Controller extends Controller
{
    public function EditAsset(){

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . 'Edit Asset Page Access');

        return view('edit_asset');

    }
    public function EditAssetData(Request $request, $asset_master_id){

        $data = DB::table('asset_properties as ap')
        ->join('asset_managers AS am','am.asset_manager_id','=','ap.asset_manager_id')
        ->select('ap.feature_name', 'ap.feature_input','ap.asset_manager_id','am.assigned_to')
        ->where('ap.asset_manager_id', $asset_master_id)
        ->get();

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($data));

        return view('edit_asset', compact('data'));

    }

    public function SaveEditAssetData(Request $request)
    {
        // Get all request data
        $data = $request->all();
        $userId = auth()->user()->id;
        $current_time = date("Y-m-d H:i:s");
        $manager_id = $request->get("asset_master_id");

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($data));
        
        // Skip the _token key and other specific keys
        $skipKeys = ['_token', 'assigned_to', 'asset_master_id', 'asset_labels', 'asset_details'];
        
        // Extract asset labels and details if they exist
        $assetLabels = $data['asset_labels'] ?? [];
        $assetDetails = $data['asset_details'] ?? [];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $skipKeys)) {
                continue;
            }
        
            Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($key));
            Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($value));

            // Update or create asset property
            Asset_propertie::updateOrCreate(
                [
                    'asset_manager_id' => $manager_id,
                    'feature_name' => $key,
                ],
                [
                    'feature_input' => $value,
                    'user_id' => $userId,
                    'feature_status' => 'Y',
                    'feature_entry_date' => $current_time,
                    'feature_modified_date' => $current_time
                ]
            );
        }
        
        // Handle asset labels and details if provided
        if (is_array($assetLabels) && is_array($assetDetails)) {
            foreach ($assetLabels as $index => $label) {
                // Ensure there's a corresponding detail for the label
                if (isset($assetDetails[$index])) {
                    $detail = $assetDetails[$index];

                    Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($detail));
        
                    // Update or create asset property for labels and details
                    Asset_propertie::updateOrCreate(
                        [
                            'asset_manager_id' => $manager_id,
                            'feature_name' => $label,
                        ],
                        [
                            'feature_input' => $detail,
                            'user_id' => $userId,
                            'feature_status' => 'Y',
                            'feature_entry_date' => $current_time,
                            'feature_modified_date' => $current_time
                        ]
                    );
                }
            }
        }
             
        // Update the asset manager with the assigned_to value and merged asset details
        $Assign = [
            'assigned_to' => $data['assigned_to'],
        ];

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($Assign));
        
        DB::table('asset_managers')
            ->where('asset_master_id', '=', $data['asset_master_id'])
            ->update($Assign);
        
        // Redirect to the asset list page with a success message
        return redirect()->route('entry_list')->with('message', 'Asset details updated successfully.');
    }
    
    

}
