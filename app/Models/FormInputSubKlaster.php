<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormInputSubKlaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_klaster_uuid',
        'label',
        'name',
    ];
}
