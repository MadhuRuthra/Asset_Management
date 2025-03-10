<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version_Master extends Model
{
    use HasFactory;

    protected $table = 'version_masters'; // Replace with your actual table name
    protected $primaryKey = 'version_master_id';
    public $timestamps = false;

    protected $fillable = [
        'version_master_id',
        'user_id',
        'os_master_id',
        'version_type',
        'version_name',
        'version_status',
        'version_entry_date',
        'version_modified_date',
    ];
}
