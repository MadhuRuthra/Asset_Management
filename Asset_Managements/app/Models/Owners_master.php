<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owners_master extends Model
{
    use HasFactory;


    protected $table = 'owners_masters'; // Replace with your actual table name
    protected $primaryKey = 'owner_master_id';
    public $timestamps = false;

    protected $fillable = [
        'owner_master_id',
        'user_id',
        'owner_name',
        'owner_id',
        'owner_role',
        'owner_status',
        'owner_entry_date',
        'owner_modified_date',
    ];

}
