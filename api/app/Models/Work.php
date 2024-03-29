<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Work extends Model
{
    use HasFactory;
    use Notifiable;

    protected $primaryKey = 'id';
    protected $fillable = [
        'img',
        'title',
        'file_id',
    ];

    public function work_tag()
    {
        return $this->hasMany(WorkTag::class);
    }
}
