<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Blog extends Model
{
    use HasFactory;
    use Notifiable;

    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'img',
        'file_id',
    ];

    public function blog_tag()
    {
        return $this->hasMany(BlogTag::class);
    }
}
