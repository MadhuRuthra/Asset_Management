<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $table = 'user_logs'; // Replace with your actual table name
    protected $primaryKey = 'user_log_id';
    public $timestamps = false;

    protected $fillable = [
        'user_log_id',
        'user_id',
        'ip_address',
        'login_date',
        'login_time',
        'logout_time',
        'user_log_status',
        'user_log_entry_date',
    ];

}
