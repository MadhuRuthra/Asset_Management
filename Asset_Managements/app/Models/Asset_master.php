<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset_master extends Model
{
    use HasFactory;

    protected $table = 'asset_masters'; // Replace with your actual table name
    protected $primaryKey = 'asset_master_id';
    public $timestamps = false;

    protected $fillable = [
        'asset_master_id',
        'user_id',
        'asset_name',
        'asset_serial_no',
        'asset_type',
        'asset_brand',
        'asset_model_name',
        'asset_status',
        'purchase_date',
        'asset_entry_date',
        'asset_modified_date',
    ];

}
