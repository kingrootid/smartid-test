<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInput extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'schedule_input_uuid',
        'sub_klaster_uuid',
    ];
}
