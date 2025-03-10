<?php

namespace App\Http\Controllers;

use App\Models\Asset_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class AssetList_Controller extends Controller
{
    public function AssetList(Request $request){


    $data = DB::table('asset_masters as am')
        ->join('users', 'users.id', '=', 'am.user_id')
        ->where('am.asset_status', '=', 'S')
        ->select('am.*','users.username', DB::raw("CASE am.asset_status WHEN 'N' THEN 'INACTIVE' ELSE 'ACTIVE' END AS status"));

    $query = $data->toSql(); // Get the SQL query string

    Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($query));

        if ($request->ajax()) {

            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {

                    if ($request->input('search.value') != "") { // search bar condition

                        $instance->where(function ($w) use ($request) {
                            $searchValue = $request->input('search.value');                           
                            $w->where('asset_name', 'like', "%$searchValue%")
                                ->orWhere('asset_serial_name', 'like', "%$searchValue%")
                                ->orWhere(function ($query) use ($searchValue) {
                                    $query->selectRaw("CASE am.asset_status WHEN 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END")
                                        ->from('am')
                                        ->whereRaw("CASE am.asset_status WHEN 'Y' THEN 'ACTIVE' ELSE 'INACTIVE' END like ?", ["%$searchValue%"]);
                                })
                                ->orWhere('asset_entry_date', 'like', "%$searchValue%");                               
                        });                      
                    }
                    // Date filter function for From date and To date
                    if (empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // Two dates are empty if the condition is display all data
                        $instance = Asset_master::get();                      
                    } elseif (!empty($request->get('detail_to_date')) && empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 

                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {

                            $w->whereDate(DB::raw('DATE(asset_entry_date)'), '=', $detail_end_date);
                        })->get()->all();
                    } elseif (empty($request->get('detail_to_date')) && !empty($request->get('detail_from_date'))) { // if single input given. This condition provide filter data 

                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                            $w->whereDate(DB::raw('DATE(asset_entry_date)'), '=', $detail_from_date);
                        })->get()->all();
                    } else {
                        // if Double output given. else part provide From to To date filtered data
                        $detail_from_date = $request->get('detail_from_date');
                        $detail_end_date = $request->get('detail_to_date');

                        $instance->where(function ($w) use ($detail_from_date, $detail_end_date) {
                            $w->whereDate(DB::raw('DATE(asset_entry_date)'), '>=', $detail_from_date)
                              ->whereDate(DB::raw('DATE(asset_entry_date)'), '<=', $detail_end_date);
                        })->get()->all();
                    }
                })
                ->addColumn('action', function ($data) {
                    return'
                    <a title="Edit Asset" href="'.route("add_asset", ['asset_master_id' => $data->asset_master_id] ).'" class="btn btn-xs btn-success" style="width: 80px; margin-bottom: 2px; margin-top: 2px;">Edit</a>
                    <a title="Delete Asset" href="javascript:void(0)" class="btn btn-danger" style="width: 95px; margin-bottom: 2px; margin-top: 2px;" onclick="DeleteAsset(' . $data->asset_master_id . ')">Delete</a>
                    ';
                })                
                ->make(true);
        }

        return view('asset_list');
    }

    public function DeleteAssetData(Request $request)
    {

        $asset_master_id = $request->input('asset_master_id');

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($asset_master_id));
    
        Asset_master::where('asset_master_id', $asset_master_id)
                    ->update(['asset_status' => 'N']);
    
        return response()->json('Success');
    }


}
