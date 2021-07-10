<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkTag extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'work_id',
        'tag',
    ];
}
