<?php

namespace App\Http\Controllers;

use App\Models\Version_Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateOS_Controller extends Controller
{
    public function CreateOS(){

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . 'Create OS page Access');

        return view('create_os');
    }

    public function SaveOS(Request $request){

        $os_master_id = $request->input('os_name');
      
        $os_version = $request->input('os_version');

        $current_time = date("Y-m-d H:i:s");

        if($os_master_id == 1){
            $os_type = 'Windows';
        }elseif($os_master_id == 5){
            $os_type = 'IOS';
        }
        else{
            $os_type = $request->input('os_type');
        }

        // First, retrieve all records that match the given os_master_id
        $osMasterRecords = DB::table('version_masters')
        ->where('os_master_id', '=', $os_master_id)
        ->get();

        // Log the number of matched records for the given os_master_id
        Log::channel('daily')->info(now() . '-' . Auth::user()->name . ' - Matched os_master_id records: ' . $osMasterRecords->count());

        // Check if any of the retrieved records have the specified version_name and additional os_type check if os_master_id is 2
        $recordExists = $osMasterRecords->contains(function ($record) use ($os_master_id, $os_version, $os_type) {
            if ($os_master_id == 2 || $os_master_id == 3 || $os_master_id == 4) {
                return $record->os_master_id == $os_master_id && $record->version_name == $os_version && $record->version_type == $os_type;
            } else {
                return $record->os_master_id == $os_master_id && $record->version_name == $os_version;
            }
        });

        if ($recordExists) {
            $msg = 'OS Version Already Exist!';
            return Redirect::to('create_os')->with('success', $msg);
        }

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($os_type));

        $version_deatils = [
            'os_master_id' => $os_master_id,
            'user_id' => Auth()->user()->id,
            'version_name' => $os_version,
            'version_type' => $os_type,
            'version_status' => 'Y',
            'version_entry_date' =>  $current_time,
            'version_modified_date' => $current_time
        ];

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($version_deatils));

        Version_Master::insert($version_deatils);

        $msg = 'OS Details Stored Successfully';

        return Redirect::to('create_os')->with('success', $msg);

    }

}


