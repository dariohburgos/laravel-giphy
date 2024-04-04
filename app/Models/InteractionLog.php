<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteractionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service',
        'request_data',
        'response_code',
        'response_data',
        'ip_address',
    ];
}
