<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;

class BlogTag extends Model
{
    public $timestamps = false;
    
    protected $primaryKey = 'blog_id';
    protected $fillable = [
        'blog_id',
        'tag',
    ];
    public function blog() {
        return $this->hasOne(Blog::class, 'id', 'blog_id');
    }
}
