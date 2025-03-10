<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset_propertie extends Model
{
    use HasFactory;
    protected $table = 'asset_properties'; // Replace with your actual table name
    protected $primaryKey = 'asset_properties_id';
    public $timestamps = false;

    protected $fillable = [
        'asset_properties_id',
        'asset_manager_id',
        'user_id',
        'feature_input',
        'feature_name',
        'feature_status',
        'feature_entry_date',
        'feature_modified_date',
    ];
}
