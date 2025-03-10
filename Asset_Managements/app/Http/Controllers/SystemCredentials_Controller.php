<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class SystemCredentials_Controller extends Controller
{
    public function SysCredential(){
        Log::channel('daily')->info(now() . '-' . Auth::user()->name . 'System Credentials function Access');
        return view('system_credentials');
    }

    public function SaveSysCredential(Request $request){

        $selected_os_name = $request->input('selected_os_name');
        $serial_number = $request->input('serial_number');
        $pin_number = $request->input('pin_number');
        $user_name = $request->input('user_name');
        $user_password = $request->input('user_password');
        $root_password = $request->input('root_password');

        $current_time = date("Y-m-d H:i:s");

        // Split the string by the '~' delimiter
        $parts = explode('~', $selected_os_name);

        // Directly get the first and second values
        $os_master_id = $parts[0];

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . $os_master_id);

        $version_master_id = $parts[1];
        
        Log::channel('daily')->info(now() . '-' . Auth::user()->name . $version_master_id);

        // Retrieve inputs from the request
        $labels = $request->input('asset_label', []);
        $details = $request->input('asset_details', []);
        $titles = $request->input('asset_titles', []);

        // Initialize an empty array for assets
        $assets = [];

            // Check if $labels, $details, or $titles is empty
        if (empty($labels) || empty($details) || empty($titles)) {
                // Store a placeholder if any of the arrays is empty
                $assets = "-";
            } else {
                // Ensure $titles, $labels, and $details are arrays
                if (is_array($titles) && is_array($labels) && is_array($details)) {
                    foreach ($titles as $key => $title) {
                        if (isset($labels[$key]) && isset($details[$key])) {
                            $assets[] = [
                                'Service' => $title,
                                'User Name' => $details[$key],
                                'Password' =>  $labels[$key]
                            ];
                        }
                    }
                }
            }

        $assetsJson = json_encode($assets);

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . $assetsJson);

        $osMasterRecords = DB::table('system_credentials')
        ->where('os_master_id', '=', $os_master_id)
        ->get();

        $recordExists = $osMasterRecords->contains(function ($record) use ($os_master_id, $version_master_id, $serial_number) {
          
                return $record->os_master_id == $os_master_id && $record->version_master_id == $version_master_id && $record->serial_number == $serial_number;
           
        });

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($recordExists));

        if ($recordExists) {
            $msg = 'System Credentials Already Exist!';
            return Redirect::to('system_credentials')->with('success', $msg);
        }

        if($pin_number != ''){

            $credential_data = array(
                'os_master_id' => $os_master_id,
                'version_master_id' => $version_master_id,
                'user_id' => Auth()->user()->id,
                'serial_number' => $serial_number,
                'user_name' => '-',
                'password' => $pin_number,
                'root_password' => '-',
                'mysql_user_password' => '-',
                'mongodb_user_password' => '-',
                'credential_status' => 'Y',
                'credential_entry_date' => $current_time,
                'credential_modified_date' => $current_time
    
            );

        }else{

            $credential_data = array(
                'os_master_id' => $os_master_id,
                'version_master_id' => $version_master_id,
                'user_id' => Auth()->user()->id,
                'serial_number' => $serial_number,
                'user_name' => $user_name,
                'password' => $user_password,
                'root_password' => $root_password,
                'mysql_user_password' => $assetsJson,
                'mongodb_user_password' => '-',
                'credential_status' => 'Y',
                'credential_entry_date' => $current_time,
                'credential_modified_date' => $current_time
    
            );
        }

       

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($credential_data));

        DB::table('system_credentials')->insert($credential_data);

        // echo "###".json_encode($assets)."###"; exit;

        $msg = 'New Credentials Created Successfully';

        return Redirect::to('system_credentials')->with('success', $msg);
    }

}
