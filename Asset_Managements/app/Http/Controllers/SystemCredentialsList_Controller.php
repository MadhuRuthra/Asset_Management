<?php

namespace App\Http\Controllers;

use App\Models\Asset_manager;
use App\Models\Asset_propertie;
use App\Models\System_Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class SystemCredentialsList_Controller extends Controller
{
    public function SysCredentialList(Request $request){

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . 'Credentials List Page Access');

        $data = DB::table('system_credentials as sc')
        ->join('os_masters as os', 'os.os_master_id', '=', 'sc.os_master_id')
        ->join('version_masters as vs', 'vs.version_master_id', '=', 'sc.version_master_id')
        ->where('sc.credential_status','=','Y')
        ->select(
            'sc.serial_number', 
            'os.os_name',
            DB::raw("CONCAT(vs.version_type, ' - ', vs.version_name) AS version_info"),
            'sc.user_name',
            'sc.password',
            'sc.root_password',
            'sc.credential_id',
            DB::raw("REPLACE(REPLACE(REPLACE(sc.mysql_user_password, '{', ''), '}', ''), '\"', '') AS mysqlpassword"),
            'sc.credential_entry_date',
            DB::raw("CASE MAX(sc.credential_status) WHEN 'N' THEN 'INACTIVE' ELSE 'ACTIVE' END AS status"), 

        )
        ->groupBy(
            'sc.serial_number', 
            'os.os_name',
            'credential_id',
            'vs.version_type',
            'vs.version_name',
            'sc.user_name',
            'sc.password',
            'sc.root_password',
            'sc.mysql_user_password',
            'sc.credential_status',
            'credential_entry_date'
        );
    
    
        $query = $data->toSql(); // Get the SQL query string

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . $query);

    if ($request->ajax()) {

        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) {

                if ($request->input('search.value') != "") { // search bar condition

                    $instance->where(function ($w) use ($request) {
                        $searchValue = $request->input('search.value');
                        
                        $w->where('os_name', 'like', "%$searchValue%")
                            ->orWhere('serial_number', 'like', "%$searchValue%")
                            ->orWhere('user_name', 'like', "%$searchValue%")
                            ->orWhere('password', 'like', "%$searchValue%")
                            ->orWhere('root_password', 'like', "%$searchValue%")
                            ->orWhere('mysql_user_password', 'like', "%$searchValue%")
                            ->orWhere('mongodb_user_password', 'like', "%$searchValue%")
                            ->orWhere('version_name', 'like', "%$searchValue%")
                            ->orWhereRaw("CONCAT(vs.version_type, ' - ', vs.version_name) like ?", ["%$searchValue%"])
                            ->orWhere(function ($query) use ($searchValue) {
                                $query->selectRaw("CASE sc.credential_status WHEN 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END")
                                    ->from('sc')
                                    ->whereRaw("CASE sc.credential_status WHEN 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END like ?", ["%$searchValue%"]);
                            })
                            ->orWhere('credential_entry_date', 'like', "%$searchValue%");
                            
                    });
                    
                }

                // Date filter function for From date and To date
                if (empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // Two dates are empty if the condition is display all data
                    $instance = System_Credential::get();                      
                } elseif (!empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 

                    $detail_from_date = $request->get('detail_from_date');
                    $detail_end_date = $request->get('detail_to_date');

                    $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {

                        $w->whereDate(DB::raw('DATE(credential_entry_date)'), '=', $detail_end_date);
                    })->get()->all();
                } elseif (empty($request->get('detail_to_date')) && !empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 

                    $detail_from_date = $request->get('detail_from_date');
                    $detail_end_date = $request->get('detail_to_date');

                    $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                        $w->whereDate(DB::raw('DATE(credential_entry_date)'), '=', $detail_from_date);
                    })->get()->all();
                } else {
                    // if Double output given. else part provide From to To date filtered data
                    $detail_from_date = $request->get('detail_from_date');
                    $detail_end_date = $request->get('detail_to_date');

                    $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                        $w->whereDate(DB::raw('DATE(credential_entry_date)'), '>=', $detail_from_date)
                          ->whereDate(DB::raw('DATE(credential_entry_date)'), '<=', $detail_end_date);
                    })->get()->all();
                }
            }) 
            ->addColumn('action', function ($data) {
                return '
                <a title="Edit Asset" href="'.route("edit_credentials", ['credential_id' => $data->credential_id, 'serial_number'=> $data->serial_number] ).'" class="btn btn-xs btn-success" style="width: 80px; margin-bottom: 2px; margin-top: 2px;">Edit</a>
                <a title="Delete Asset Entry" href="javascript:void(0)" class="btn btn-danger" style="width: 95px; margin-bottom: 2px; margin-top: 2px;" onclick="DeleteCredentials(' . $data->credential_id . ')">Delete</a>
                ';
            })
            ->make(true);
    }

        return view('system_credentials_list');
    }


    public function DeleteCredentials(Request $request)
    {
        Log::channel('daily')->info(now() . '-' . Auth::user()->name . 'Delete Credentials Page Access');

        $credential_id = $request->input('credential_id');

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . $credential_id);
    
        System_Credential::where('credential_id', $credential_id)
                    ->update(['credential_status' => 'N']);
    
        return response()->json('Success');
    }
}
