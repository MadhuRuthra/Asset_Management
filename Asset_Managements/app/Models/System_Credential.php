<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System_Credential extends Model
{
    use HasFactory;

    protected $table = 'system_credentials'; // Replace with your actual table name
    protected $primaryKey = 'credential_id';
    public $timestamps = false;

    protected $fillable = [
        'credential_id',
        'os_master_id',
        'version_master_id',
        'user_id',
        'serial_number',
        'user_name',
        'password',
        'root_password',
        'mysql_user_password',
        'mongodb_user_password',
        'credential_status',
        'credential_entry_date',
        'credential_modified_date'
    ];

}
