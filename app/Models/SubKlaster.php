<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKlaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'master_klaster_uuid',
        'name'
    ];
}
