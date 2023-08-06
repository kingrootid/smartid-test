<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ScheduleInput extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_klaster_uuid',
        'date_start',
        'date_end'
    ];
}
