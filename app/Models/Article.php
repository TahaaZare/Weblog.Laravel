<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "title",
        "slug",
        "article_id",
        "user_id",
        "tags",
        "description",
        "status",
        "image",
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'json',
        ];
    }

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
