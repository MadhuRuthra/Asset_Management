<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset_manager extends Model
{
    use HasFactory;

    protected $table = 'asset_managers'; // Replace with your actual table name
    protected $primaryKey = 'asset_manager_id';
    public $timestamps = false;


    protected $fillable = [
        'asset_manager_id',
        'asset_master_id',
        'user_id',
        'asset_details',
        'assigned_to',
        'assigned_status',
        'assigned_entry_date',
        'assigned_modified_date',
    ];

}
