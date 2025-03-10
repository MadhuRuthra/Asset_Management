<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset_propertie;
use App\Models\System_Credential;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class EditCredentials_Controller extends Controller
{

    public function EditCredentials(){
        Log::channel('daily')->info(now() . '-' . Auth::user()->name . 'Edit Credentials Page Access');
        return view('edit_credentials');
    }
    
    public function EditCredentialsData(Request $request, $credential_id, $serial_number){

        $data = DB::table('system_credentials as sc')
        ->join('os_masters as os', 'os.os_master_id', '=', 'sc.os_master_id')
        ->join('version_masters as vs', 'vs.version_master_id', '=', 'sc.version_master_id')
        ->select('sc.serial_number', 'sc.user_name', 'sc.password','sc.root_password', 'sc.mysql_user_password','sc.credential_id','os.os_master_id','vs.version_master_id')
        ->where('sc.credential_id', $credential_id)
        ->where('sc.serial_number', $serial_number)
        ->get();

        // echo "###".$data."###"; exit;
        
        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($data));
        // echo "###".$data."###"; exit;
    
        return view('edit_credentials', compact('data'));

    }

    public function SaveEditCredentials(Request $request){

        $userId = auth()->user()->id;

        $credential_id = $request->input('credential_id');
        $serial_number = $request->input('serial_number');
        $user_name = $request->input('user_name');
        $password = $request->input('password');
        $root_password = $request->input('root_password');
        $credential_value = $request->input('credential_value');
        $credential_label = $request->input('credential_label');
        $credential_title = $request->input('credential_title');
        $current_time = date("Y-m-d H:i:s");

        // Initialize an empty array

        $labels = $request->input('credential_label', []);
        $details = $request->input('credential_value', []);
        $titles = $request->input('credential_title', []);

                // Retrieve inputs from the request
        $asset_labels = $request->input('asset_label', []);
        $asset_details = $request->input('asset_details', []);
        $asset_titles = $request->input('asset_titles', []);
        
        $credentials = [];

        $assets = [];

        if($credential_value != '' && $credential_title != '' && $credential_label != ''){

        if (empty($asset_labels) || empty($asset_details) || empty($asset_titles)) {
            // Store a placeholder if any of the arrays is empty
            $assets = "-";
        } else {
            // Ensure $titles, $labels, and $details are arrays
            if (is_array($asset_titles) && is_array($asset_labels) && is_array($asset_details)) {
                foreach ($asset_titles as $key => $title) {
                    if (isset($asset_labels[$key]) && isset($asset_details[$key])) {
                        $assets[] = [
                            'Service' => $title,
                            'User Name' => $asset_details[$key],
                            'Password' =>  $asset_labels[$key]
                        ];
                    }
                }
            }
        }

    $assetsJson = json_encode($assets);


            if (empty($labels) || empty($details) || empty($titles)) {
                // Store a placeholder if any of the arrays is empty
                $credentials = "-";
            } else {
                // Ensure $titles, $labels, and $details are arrays
                if (is_array($titles) && is_array($labels) && is_array($details)) {
                    foreach ($titles as $key => $title) {
                        if (isset($labels[$key]) && isset($details[$key])) {
                            $credentials[] = [
                                'Service' => $title,
                                'User Name' => $details[$key],
                                'Password' =>  $labels[$key]
                            ];
                        }
                    }
                }
            }

        // Convert the associative array to JSON
        $credentials_json = json_encode($credentials);

        if (empty($asset_labels) || empty($asset_details) || empty($asset_titles)){
            $output = json_encode($credentials);
        }else{

        $combined_data = array_merge($assets, $credentials);

        // Convert the combined array to JSON
        $output = json_encode($combined_data);

        }

        // echo ''.$output.''; exit;

    }else{
        $output = '-';
    }

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($output));

        // echo "###".$credentials_json."###"; exit;

        $os_name = $request->input('selected_os_name');
        // Split the string by the '~' delimiter
        $parts = explode('~', $os_name);

        // Directly get the first and second values
        $os_master_id = $parts[0];
        $version_master_id = $parts[1];

        // echo "###".$data."###"; exit;

            $data = array(    
                'os_master_id' => $os_master_id,
                'version_master_id' => $version_master_id,
                'user_id' => $userId,
                'serial_number' => $serial_number,
                'user_name' => $user_name,
                'password' => $password,
                'root_password' => $root_password,
                'mysql_user_password' => $output,
                'credential_status' => 'Y',
                'credential_entry_date' => $current_time,
                'credential_modified_date' => $current_time
            );

            Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($data));

            DB::table('system_credentials')->where('credential_id','=',$credential_id)->update($data);
      

            $msg = $serial_number.' Credentials Edited Successfully';

            return Redirect::to('system_credentials_list')->with('success', $msg);

    }
}
