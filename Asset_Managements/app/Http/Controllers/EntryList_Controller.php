<?php

namespace App\Http\Controllers;

use App\Models\Asset_manager;
use App\Models\Asset_propertie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class EntryList_Controller extends Controller
{
    public function EntryList(Request $request){

        $data = DB::table('asset_properties as ap')
        ->join('users', 'users.id', '=', 'ap.user_id')
        ->join('asset_managers as aman', 'aman.asset_manager_id', '=', 'ap.asset_manager_id')
        ->where('aman.assigned_status','=','Y')
        ->select(
            'users.username', 
            'aman.asset_serial_no', 
            DB::raw('MAX(ap.feature_entry_date) as feature_entry_date'),
            'aman.assigned_to',
            'aman.assigned_status',
            'aman.asset_manager_id',
            DB::raw("CASE MAX(ap.feature_status) WHEN 'N' THEN 'INACTIVE' ELSE 'ACTIVE' END AS status"), 
            DB::raw("GROUP_CONCAT(CONCAT(ap.feature_name, ' - ', ap.feature_input) SEPARATOR ', ') AS feature_details")
        )
        ->groupBy('users.username', 'aman.asset_serial_no','aman.assigned_to','aman.asset_manager_id','aman.assigned_status');
    
$query = $data->toSql(); // Get the SQL query string

Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($query));

    if ($request->ajax()) {

        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) {

                if ($request->input('search.value') != "") { // search bar condition

                    $instance->where(function ($w) use ($request) {
                        $searchValue = $request->input('search.value');
                        
                        $w->where('username', 'like', "%$searchValue%")
                            ->orWhere('asset_serial_no', 'like', "%$searchValue%")
                            ->orWhere('feature_entry_date', 'like', "%$searchValue%")
                            ->orWhere('assigned_to', 'like', "%$searchValue%")
                            ->orWhere(function ($query) use ($searchValue) {
                                $query->selectRaw("CASE ap.feature_status WHEN 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END")
                                    ->from('ap')
                                    ->whereRaw("CASE ap.feature_status WHEN 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END like ?", ["%$searchValue%"]);
                            })
                            ->orWhere('feature_entry_date', 'like', "%$searchValue%");
                            
                    });
                    
                }

                // Date filter function for From date and To date
                if (empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // Two dates are empty if the condition is display all data
                    $instance = Asset_manager::get();                      
                } elseif (!empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 

                    $detail_from_date = $request->get('detail_from_date');
                    $detail_end_date = $request->get('detail_to_date');

                    $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {

                        $w->whereDate(DB::raw('DATE(feature_entry_date)'), '=', $detail_end_date);
                    })->get()->all();
                } elseif (empty($request->get('detail_to_date')) && !empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 

                    $detail_from_date = $request->get('detail_from_date');
                    $detail_end_date = $request->get('detail_to_date');

                    $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                        $w->whereDate(DB::raw('DATE(feature_entry_date)'), '=', $detail_from_date);
                    })->get()->all();
                } else {
                    // if Double output given. else part provide From to To date filtered data
                    $detail_from_date = $request->get('detail_from_date');
                    $detail_end_date = $request->get('detail_to_date');

                    $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                        $w->whereDate(DB::raw('DATE(feature_entry_date)'), '>=', $detail_from_date)
                          ->whereDate(DB::raw('DATE(feature_entry_date)'), '<=', $detail_end_date);
                    })->get()->all();
                }
            })
            ->addColumn('action', function ($data) {
                return '
                <a title="Edit Asset" href="'.route("edit_asset", ['asset_master_id' => $data->asset_manager_id] ).'" class="btn btn-xs btn-success" style="width: 80px; margin-bottom: 2px; margin-top: 2px;">Edit</a>
                <a title="Delete Asset Entry" href="javascript:void(0)" class="btn btn-danger" style="width: 95px; margin-bottom: 2px; margin-top: 2px;" onclick="DeleteAssetEntry(' . $data->asset_manager_id . ')">Delete</a>
                ';
            })  
            ->make(true);
    }

        return view('entry_list');
    }

    public function DeleteAssetEntryData(Request $request)
    {
        $asset_manager_id = $request->input('asset_manager_id');
        
        Log::channel('daily')->info(now() . '-' . Auth::user()->name . 'Delete Asset Function Access');

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($asset_manager_id));
    
        Asset_manager::where('asset_manager_id', $asset_manager_id)
                    ->update(['assigned_status' => 'N']);

        Asset_propertie::where('asset_manager_id', $asset_manager_id)
                    ->update(['feature_status' => 'N']);
    
        return response()->json('Success');
    }
    
}
