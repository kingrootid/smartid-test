<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInputDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_input_uuid',
        'name',
        'label',
        'value'
    ];
}
