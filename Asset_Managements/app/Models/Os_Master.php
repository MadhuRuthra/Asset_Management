<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Os_Master extends Model
{
    use HasFactory;

    protected $table = 'os_masters'; // Replace with your actual table name
    protected $primaryKey = 'os_master_id';
    public $timestamps = false;

    protected $fillable = [
        'os_master_id',
        'user_id',
        'os_name',
        'os_status',
        'os_entry_date',
        'os_modified_date',
    ];

}
