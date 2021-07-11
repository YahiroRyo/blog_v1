<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Work;

class WorkTag extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'work_id';

    protected $fillable = [
        'work_id',
        'tag',
    ];
    public function work() {
        return $this->hasOne(Work::class, 'id', 'work_id');
    }
}
